<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'claim_id',
        'bill_id',
    ];

    public function claim()
    {
        return $this->belongsTo(Claim::class);
    }

    public static function getBillWithContact($contact): \XeroAPI\XeroPHP\Models\Accounting\Invoice
    {
        $invoice = new \XeroAPI\XeroPHP\Models\Accounting\Invoice;
        $invoice->setType(\XeroAPI\XeroPHP\Models\Accounting\Invoice::TYPE_ACCPAY);
        $invoice->setContact($contact);
        $invoice->setDate(now()->format('Y-m-d'));

        return $invoice;
    }
}
