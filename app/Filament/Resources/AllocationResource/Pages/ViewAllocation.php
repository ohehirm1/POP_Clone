<?php

namespace App\Filament\Resources\AllocationResource\Pages;

use App\Filament\Resources\AllocationResource;
use App\Mail\ParticipantVerifyAllocation;
use Filament\Notifications\Notification;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Mail;

class ViewAllocation extends ViewRecord
{
    protected static string $resource = AllocationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\Action::make('verify')
                ->action('verify')
                ->requiresConfirmation(),
            Actions\Action::make('participant_verify')
                ->label('Send Verify Participant Mail')
                ->action('participant_verify')
                ->requiresConfirmation(),
        ];
    }

    public function verify(): void
    {
        $this->record->verified_at = now();
        $this->record->save();
        // $this->redirect($this->getResource()::getUrl('index'));
        Notification::make()
            ->title('Verified Successfully')
            ->success()
            ->send();
        $this->data['verified_at'] = $this->record->verified_at;
    }

    public function participant_verify(): void
    {
        Mail::to($this->record->participant->email)->send(new ParticipantVerifyAllocation($this->record));
        Notification::make()
            ->title('Sent Verification Email Successfully')
            ->success()
            ->send();
    }
}
