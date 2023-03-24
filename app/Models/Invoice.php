<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'claim_id',
        'invoice_id',
    ];

    public function claim()
    {
        return $this->belongsTo(Claim::class);
    }

    public static function getInvoice(): \XeroAPI\XeroPHP\Models\Accounting\Invoice
    {
        $invoice = new \XeroAPI\XeroPHP\Models\Accounting\Invoice;
        $invoice->setType(\XeroAPI\XeroPHP\Models\Accounting\Invoice::TYPE_ACCREC);

        return $invoice;
    }

    public static function getInvoiceWithContactDueIn7Days($contact): \XeroAPI\XeroPHP\Models\Accounting\Invoice
    {
        $invoice = new \XeroAPI\XeroPHP\Models\Accounting\Invoice;
        $invoice->setType(\XeroAPI\XeroPHP\Models\Accounting\Invoice::TYPE_ACCREC);
        $invoice->setContact($contact);
        $invoice->setDate(now()->format('Y-m-d'));
        $invoice->setDueDate(now()->addDays(7)->format('Y-m-d'));

        return $invoice;
    }
}
