<?php

namespace App\Http\Requests;

use App\Enums\AuthRole;
use App\Models\Participant;
use Illuminate\Foundation\Http\FormRequest;

class StoreParticipantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Participant::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'ndis' => ['required', 'integer', 'digits:9', 'unique:participants,ndis'],
            'email' => 'required|email|max:255|unique:participants,email',
            'auth_role' => ['required', 'in:'.implode(',', array_keys(AuthRole::cases()))],
            'email1' => 'nullable|email|max:255',
            'email2' => 'nullable|email|max:255',
        ];
    }
}
