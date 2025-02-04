<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMahasiswaRequest extends FormRequest
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
            'nim' => 'required',
            'password' => 'required',
            'lokasi_id' => 'required',
            // 'pembimbing_lapangan_id' => 'required',
            'dosen_pembimbing_id' => 'required',
            // 'gambar' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'nama.required' => 'nama tidak boleh kosong',
            'nim.required' => 'nim tidak boleh kosong',
            'nim.unique' => 'nim sudah dipakai',
            'password.required' => 'password tidak boleh kosong',
            'lokasi_id.required' => 'lokasi tidak boleh kosong',
            'pembimbing_lapangan_id.required' => 'pembimbing lapangan tidak boleh kosong',
            'dosen_pembimbing_id.required' => 'dosen pembimbing tidak boleh kosong',
            'gambar.image' => 'file yang dikirim harus gambar',
            'gambar.mimes' => 'file gambar harus menggunkan jpg,png,jpeg,gif atau svg',
            'gambar.max' => 'gambar maksimal 2 mb'
        ];
    }
}
