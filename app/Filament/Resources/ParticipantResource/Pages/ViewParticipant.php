<?php

namespace App\Filament\Resources\ParticipantResource\Pages;

use App\Filament\Resources\ParticipantResource;
use Filament\Notifications\Notification;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;
use Webfox\Xero\OauthCredentialManager;

class ViewParticipant extends ViewRecord
{
    protected static string $resource = ParticipantResource::class;

    protected function getTitle(): string
    {
        return "{$this->record->name}";
    }

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
        // $this->redirect($this->getResource()::getUrl('view', $this->record));
        Notification::make()
            ->title('Verified **'.$this->record->name.'** Successfully')
            ->success()
            ->send();
        $this->data['verified_at'] = $this->record->verified_at;
    }
}
