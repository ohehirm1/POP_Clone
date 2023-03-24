<?php

namespace App\Models;

use App\Enums\Support;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Allocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'participant_id',
        'support_item',
        'price_charged',
        'allocated_amount',
        'start_date',
        'end_date',
    ];

    public function participant(): BelongsTo
    {
        return $this->belongsTo(Participant::class);
    }

    public function support_item_name(): string
    {
        $name = array_column(Support::cases(), 'name', 'value')[explode('_', $this->support_item)[0]];

        return preg_replace('/([A-Z])/m', ' $1', $name);
    }

    public function account_code(): string
    {
        $budget = explode('_', $this->support_item)[0];
        $account = Account::where('budget', $budget)->first();

        return $account->code;
    }

    public function allocated_balance(): string
    {
        $balance = $this->allocated_amount;
        $claimed = $this->claims()->get()->sum('total');

        return sprintf('%.2f', $balance - $claimed);
    }

    public function advance_balance($xeroCredentials): float
    {
        $xero = resolve(\XeroAPI\XeroPHP\Api\AccountingApi::class);
        $balance = 0;
        $ids = $this->claims->pluck('invoice')->flatten()->pluck('invoice_id')->toArray();
        if ($ids) {
            $xeroInvoice = $xero->getInvoices($xeroCredentials, null, null, null, $ids);
            foreach ($xeroInvoice as $invoice) {
                $balance += $invoice->getAmountDue();
            }
        } else {
            $balance = 0;
        }

        return $this->advance_amount - $balance;
    }

    public function getLineItem($from, $to): \XeroAPI\XeroPHP\Models\Accounting\LineItem
    {
        $lineItem = new \XeroAPI\XeroPHP\Models\Accounting\LineItem;
        // set item code
        $lineItem->setItemCode($this->support_item);
        $lineItem->setDescription("{$this->support_item}:{$this->support_item_name()}"." {$from} - {$to}");
        $lineItem->setAccountCode($this->account_code());
        // TODO Tracking
        return $lineItem;
    }

    public function claims(): HasMany
    {
        return $this->hasMany(Claim::class);
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    protected function priceCharged(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => (int) ($value * 100)
        );
    }

    protected function allocatedAmount(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => (int) ($value * 100)
        );
    }

    protected function advanceAmount(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => (int) ($value * 100)
        );
    }
}
