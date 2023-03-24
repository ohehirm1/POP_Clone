<?php

namespace App\Http\Controllers;

use App\Enums\Support;
use App\Http\Requests\StoreAllocationRequest;
use App\Http\Requests\UpdateAllocationRequest;
use App\Models\Allocation;
use App\Models\Business;
use App\Models\MaxPrice;
use App\Models\Participant;
use Barryvdh\Debugbar\Facades\Debugbar;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Webfox\Xero\OauthCredentialManager;

class AllocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auther()->is_provider()) {
            return view('allocations.index', [
                'allocations' => Allocation::whereCreatedBy(auther()->id)
                    ->paginate(10),
            ]);
        } else {
            return redirect(route('dashboard'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (auther()->is_provider()) {
            $businesses = Business::select(['id', 'name', 'abn'])
                ->whereCreatedBy(auther()->id)
                ->whereNotNull('verified_at')
                ->get();
            $businesses = $businesses->keyBy('id');
            $max_prices = MaxPrice::all();
            $items = $max_prices->pluck('item');
            $max_prices = $max_prices->keyBy('item');
            $max_prices->transform(fn ($i) => $i->price);
            Debugbar::log($max_prices);
            $support = array_column(Support::cases(), 'name', 'value');
            $businesses->transform(function ($i) {
                return $i->name." ($i->abn)";
            });

            return view('allocations.create', compact('businesses', 'support', 'max_prices', 'items'));
        } else {
            return redirect(route('dashboard'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAllocationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAllocationRequest $request, OauthCredentialManager $xeroCrendentials)
    {
        $a = Allocation::make($request->validated());
        $p = Participant::whereNdis($a->participant_id)->first();
        if (! $p->is_verified()) {
            return redirect()->back()->withErrors(['participant_id' => 'This participant is not verified'])->withInput();
        } else {
            $a->participant_id = $p->id;
        }
        $allocated = Allocation::whereParticipantId($p->id)
            ->whereNotNull('verified_at')
            ->whereNotNull('participant_verified_at')
            ->get()
            ->pluck('allocated_amount')
            ->sum();
        if ($a->price_charged > $a->allocated_amount) {
            return redirect()->back()->withErrors(['allocated_amount' => "The 'Allocated Amount' should not be less than 'Price Charged'"])->withInput();
        }
        $max_price = MaxPrice::whereItem($a->support_item)->first();
        if ($a->price_charged > $max_price->price) {
            return redirect()->back()->withErrors(['price_charged' => "The 'Price Charged' should not be more than the maximum price of $max_price->price"])->withInput();
        }
        $a->created_by = auther()->id;
        $a->save();

        // create xero tracking category
        $xero = resolve(\XeroAPI\XeroPHP\Api\AccountingApi::class);
        $tracking = $xero->getTrackingCategories($xeroCrendentials->getTenantId())[0];

        $option_provider = new \XeroAPI\XeroPHP\Models\Accounting\TrackingOption();
        $option_provider->setName("{$a->business->name} - {$a->business->abn}");
        $option_provider->setStatus(\XeroAPI\XeroPHP\Models\Accounting\TrackingOption::STATUS_ACTIVE);

        $option_participant = new \XeroAPI\XeroPHP\Models\Accounting\TrackingOption();
        $option_participant->setName("{$a->participant->name} - {$a->participant->ndis}");
        $option_participant->setStatus(\XeroAPI\XeroPHP\Models\Accounting\TrackingOption::STATUS_ACTIVE);

        try {
            $xero->createTrackingOptions(
                $xeroCrendentials->getTenantId(),
                $tracking->getTrackingCategoryID(),
                $option_provider,
            );
        } catch (\XeroAPI\XeroPHP\ApiException $e) {
            // dd($e->getResponseBody());
        }
        try {
            $xero->createTrackingOptions(
                $xeroCrendentials->getTenantId(),
                $tracking->getTrackingCategoryID(),
                $option_participant,
            );
        } catch (\XeroAPI\XeroPHP\ApiException $e) {
            // dd($e->getResponseBody());
        }

        Notification::make()
            ->title('Allocation created')
            ->success()
            ->send();

        return redirect(route('allocations.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Allocation  $allocation
     * @return \Illuminate\Http\Response
     */
    public function show(Allocation $allocation, OauthCredentialManager $xeroCrendentials)
    {
        $x = $xeroCrendentials->getTenantId();

        return view('allocations.show', compact('allocation', 'x'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Allocation  $allocation
     * @return \Illuminate\Http\Response
     */
    public function edit(Allocation $allocation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAllocationRequest  $request
     * @param  \App\Models\Allocation  $allocation
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAllocationRequest $request, Allocation $allocation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Allocation  $allocation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Allocation $allocation)
    {
        //
    }

    public function verify(Request $request)
    {
        $id = base64_decode(strtr($request->token, '-_,', '+/='));
        $allocation = Allocation::find($id);
        $msg = 'Verification failed. Please try again later.';
        if ($allocation) {
            $allocation->participant_verified_at = now();
            $allocation->save();
            $msg = 'Verification successful. You can close this page.';
        }

        return $msg;
    }
}
