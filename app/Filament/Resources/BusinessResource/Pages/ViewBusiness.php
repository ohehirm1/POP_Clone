<?php

namespace App\Filament\Resources\BusinessResource\Pages;

use App\Filament\Resources\BusinessResource;
use Filament\Notifications\Notification;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;
use Webfox\Xero\OauthCredentialManager;

class ViewBusiness extends ViewRecord
{
    protected static string $resource = BusinessResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\Action::make('verify')
                ->action('verify')
                ->requiresConfirmation(),
        ];
    }

    public function verify(OauthCredentialManager $xeroCredential): void
    {
        if (! $this->record->xero_key) {
            Notification::make()
                ->title('**'.$this->record->name.'** has no Xero Key')
                ->warning()
                ->send();

            return;
        }

        $xero = resolve(\XeroAPI\XeroPHP\Api\AccountingApi::class);
        $xero_contact = $xero->getContacts($xeroCredential->getTenantId(), null, null, null, [$this->record->xero_key]);
        if (! $xero_contact->getContacts()) {
            Notification::make()
                ->title('**'.$this->record->name.'** has no Xero Contact')
                ->warning()
                ->send();

            return;
        }

        $this->record->verified_at = now();
        $this->record->save();
        // $this->redirectRoute('filament.resources.businesses.index');
        Notification::make()
            ->title('Verified **'.$this->record->name.'** Successfully')
            ->success()
            ->send();

        $this->data['verified_at'] = $this->record->verified_at;
    }
}
