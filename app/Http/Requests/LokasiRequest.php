<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LokasiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nama' => 'required',
            'alamat' => 'required',
            'gambar' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'nama.required' => 'nama tidak boleh kosong',
            'alamat.required' => 'alamat tidak boleh kosong',
            'gambar.required' => 'gambar tidak boleh kosong',
            'gambar.image' => 'file yang dikirim harus gambar',
            'gambar.mimes' => 'file gambar harus menggunkan jpg,png,jpeg,gif atau svg',
            'gambar.max' => 'gambar maksimal 2 mb'
        ];
    }
}
