<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'    => 'required|string|max:255',
            'stock'    => 'required|integer',
            'price'    => 'required|numeric',
            'user_id'  => 'required|exists:users,id', // Validasi dropdown owner
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Nama/Title produk wajib diisi.',
            'title.max'      => 'Nama/Title produk tidak boleh lebih dari 255 karakter.',

            'stock.required' => 'Jumlah stock produk wajib diisi.',
            'stock.integer'  => 'Stock produk harus berupa angka bulat.',

            'price.required' => 'Harga produk wajib diisi.',
            'price.numeric'  => 'Harga produk harus berupa angka yang valid.',
            
            'user_id.required' => 'Pemilik produk (Owner) wajib dipilih.',
        ];
    }
}