<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClaimRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'allocation_id' => 'required|integer|exists:allocations,id',
            'from' => 'required|date',
            'to' => 'required|date',
            'claimed_amount' => 'required|numeric|gt:0',
            'qty' => 'required|integer|gt:0',
        ];
    }
}
