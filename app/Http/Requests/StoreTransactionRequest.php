<?php

namespace App\Http\Requests;

use App\Enums\TransactionType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date' => ['required', 'date'],
            'description' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0'],
            'type' => ['required', Rule::enum(TransactionType::class)],
            'category_id' => ['nullable', 'exists:categories,id'],
            'is_taxable' => ['boolean'],
            'notes' => ['nullable', 'string'],
            'attachment' => ['nullable', 'file', 'max:5120'], // 5MB max
        ];
    }

    public function messages(): array
    {
        return [
            'date.required' => 'Tanggal wajib diisi',
            'description.required' => 'Deskripsi wajib diisi',
            'amount.required' => 'Jumlah wajib diisi',
            'amount.min' => 'Jumlah tidak boleh negatif',
            'type.required' => 'Tipe transaksi wajib dipilih',
        ];
    }
}
