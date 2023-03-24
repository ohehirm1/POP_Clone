<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Webfox\Xero\OauthCredentialManager;

class XeroController extends Controller
{
    public function index(Request $request, OauthCredentialManager $xeroCredentials)
    {
        try {
            // Check if we've got any stored credentials
            if ($xeroCredentials->exists()) {
                /*
                 * We have stored credentials so we can resolve the AccountingApi,
                 * If we were sure we already had some stored credentials then we could just resolve this through the controller
                 * But since we use this route for the initial authentication we cannot be sure!
                 */
                $xero = resolve(\XeroAPI\XeroPHP\Api\AccountingApi::class);
                $organisationName = $xero->getOrganisations($xeroCredentials->getTenantId())->getOrganisations()[0]->getName();
                $user = $xeroCredentials->getUser();
                $username = "{$user['given_name']} {$user['family_name']} ({$user['username']})";
            }
        } catch (\throwable $e) {
            // This can happen if the credentials have been revoked or there is an error with the organisation (e.g. it's expired)
            $error = $e->getMessage();
        }

        return view('xero', [
            'connected' => $xeroCredentials->exists(),
            'error' => $error ?? null,
            'organisationName' => $organisationName ?? null,
            'username' => $username ?? null,
        ]);
    }

    public function test(Request $request, OauthCredentialManager $xeroCredentials)
    {
        $xero = resolve(\XeroAPI\XeroPHP\Api\AccountingApi::class);
        $invoices = $xero->getInvoices($xeroCredentials->getTenantId());
        dd($invoices);

        //Get contacts
        // $xero = resolve(\XeroAPI\XeroPHP\Api\AccountingApi::class);
        // $contacts = $xero->getContacts($xeroCredentials->getTenantId())[0]->getContactId();

        // $invoice = new \XeroAPI\XeroPHP\Models\Accounting\Invoice;

        // $invoice->setType(\XeroAPI\XeroPHP\Models\Accounting\Invoice::TYPE_ACCREC);
        // $contact = new \XeroAPI\XeroPHP\Models\Accounting\Contact;
        // $contact->setContactId($contacts);
        // $invoice->setContact($contact);
        // $lineitem = new \XeroAPI\XeroPHP\Models\Accounting\LineItem;
        // $lineitem->setDescription('Sample Item')
        //     ->setQuantity(1)
        //     ->setUnitAmount(20)
        //     ->setAccountCode("400");
        // $invoice->setLineItems([$lineitem]);
        // try {
        //     $result = $xero->createInvoices($xeroCredentials->getTenantId(), $invoice);
        // } catch (\XeroAPI\XeroPHP\ApiException $e) {
        //     dd($e->getResponseBody());
        // }
        // dd($result);

        // $xero = resolve(\XeroAPI\XeroPHP\Api\AccountingApi::class);
    }
}
