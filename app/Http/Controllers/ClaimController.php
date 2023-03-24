<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClaimRequest;
use App\Models\Allocation;
use App\Models\Bill;
use App\Models\Claim;
use App\Models\Invoice;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Webfox\Xero\OauthCredentialManager;

class ClaimController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auther()->is_provider()) {
            return view('claims.index', [
                'claims' => Claim::whereIn('allocation_id', auther()->allocations()->pluck('id'))
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
    public function create(Request $request, OauthCredentialManager $xeroCredentials)
    {
        $allocation = Allocation::findOrFail($request->id);
        $x = $xeroCredentials->getTenantId();

        return view('claims.create', compact('allocation', 'x'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreClaimRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClaimRequest $request, OauthCredentialManager $xeroCredentials)
    {
        $claim = Claim::make($request->validated());

        $advance_balance_after = ($claim->allocation->advance_balance($xeroCredentials->getTenantId())) - ($claim->claimed_amount * $claim->qty);
        $allocation_balance_after = $claim->allocation->allocated_balance() - ($claim->claimed_amount * $claim->qty);

        if ($advance_balance_after < 0 || $allocation_balance_after < 0) {
            Notification::make()
                ->title('Claim amount exceeds advance balance or allocation balance')
                ->warning()
                ->send();

            return redirect()->back();
        }

        $xero = resolve(\XeroAPI\XeroPHP\Api\AccountingApi::class);
        $from = carbon($claim->from)->format('d/m/Y');
        $to = carbon($claim->to)->format('d/m/Y');

        $line_item = $claim->allocation->getLineItem($from, $to);
        $line_item->setUnitAmount($claim->claimed_amount);
        $line_item->setQuantity($claim->qty);

        $tracking = $xero->getTrackingCategories($xeroCredentials->getTenantId());
        $options = collect($tracking[0]->getOptions())->transform(function ($option, $key) {
            return ['name' => $option->getName(), 'id' => $option->getTrackingOptionID()];
        });
        $participant_option = $options->where('name', $claim->allocation->participant->name.' - '.$claim->allocation->participant->ndis)->first();
        $business_option = $options->where('name', $claim->allocation->business->name.' - '.$claim->allocation->business->abn)->first();

        //create new line item tracking
        $line_item_tracking_participant = new \XeroAPI\XeroPHP\Models\Accounting\LineItemTracking();
        // $line_item_tracking_participant->setTrackingCategoryId($tracking[0]->getTrackingCategoryID());
        // $line_item_tracking_participant->setTrackingOptionId($participant_option['id']);
        $line_item_tracking_participant->setName($tracking[0]->getName());
        $line_item_tracking_participant->setOption($participant_option['name']);

        $line_item_tracking_business = new \XeroAPI\XeroPHP\Models\Accounting\LineItemTracking();
        // $line_item_tracking_business->setTrackingCategoryId($tracking[0]->getTrackingCategoryID());
        // $line_item_tracking_business->setTrackingOptionId($business_option['id']);
        $line_item_tracking_business->setName($tracking[0]->getName());
        $line_item_tracking_business->setOption($business_option['name']);

        $line_item->setTracking([$line_item_tracking_business]);

        // create invoice
        $participant_contact = $claim->allocation->participant->getXeroContact();
        $invoice = Invoice::getInvoiceWithContactDueIn7Days($participant_contact);

        $invoice->setReference("{$from} - {$to}");
        $invoice->setLineItems([$line_item]);

        try {
            $result_invoice = $xero->createInvoices($xeroCredentials->getTenantId(), $invoice);
        } catch (\XeroAPI\XeroPHP\ApiException $e) {
            dd($e->getResponseBody());
        }

        // create bill
        $provider_contact = $claim->allocation->business->getXeroContact();
        $bill = Bill::getBillWithContact($provider_contact);

        $line_item->setTracking([$line_item_tracking_participant]);
        $bill->setLineItems([$line_item]);

        try {
            $result_bill = $xero->createInvoices($xeroCredentials->getTenantId(), $bill);
        } catch (\XeroAPI\XeroPHP\ApiException $e) {
            dd($e->getResponseBody());
        }

        $claim->save();

        if (
            $result_invoice->getInvoices()[0]->getStatusAttributeString() == 'OK'
            && $result_bill->getInvoices()[0]->getStatusAttributeString() == 'OK'
        ) {
            Bill::create(
                [
                    'bill_id' => $result_bill->getInvoices()[0]->getInvoiceID(),
                    'claim_id' => $claim->id,
                ]
            );
            Invoice::create(
                [
                    'invoice_id' => $result_invoice->getInvoices()[0]->getInvoiceID(),
                    'claim_id' => $claim->id,
                ]
            );
        } else {
            dd($result_invoice, $result_bill);
        }

        Notification::make()
            ->title('Claim created successfully')
            ->success()
            ->send();

        return redirect()->route('allocations.show', $claim->allocation->id);
    }
}
