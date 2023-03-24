<?php

namespace App\Http\Requests;

use App\Models\Allocation;
use Illuminate\Foundation\Http\FormRequest;

class StoreAllocationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Allocation::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'business_id' => ['required', 'integer'],
            'participant_id' => ['required', 'integer', 'digits:9', 'exists:participants,ndis'],
            'support_item' => ['required', 'exists:max_prices,item'],
            'price_charged' => ['required', 'numeric'],
            'allocated_amount' => ['required', 'numeric'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'participant_id.exists' => 'This participant does not exist in the system. Please create a new participant',
        ];
    }
}
