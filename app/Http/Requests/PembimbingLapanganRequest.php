<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PembimbingLapanganRequest extends FormRequest
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
            'username' => 'required|unique:users',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return[
            'nama.required' => 'nama tidak boleh kosong',
            'username.required' => 'username tidak boleh kosong',
            'username.unique' => 'username sudah dipakai',
            'password.required' => 'password tidak boleh kosong',
        ];
    }
}
