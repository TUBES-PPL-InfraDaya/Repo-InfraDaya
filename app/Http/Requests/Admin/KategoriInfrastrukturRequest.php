<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KategoriInfrastrukturRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        $kategoriId = $this->route('kategori');
        if (is_object($kategoriId)) {
            $kategoriId = $kategoriId->id;
        }

        return [
            'nama_kategori' => [
                'required',
                'string',
                'max:100',
                Rule::unique('kategori_infrastruktur', 'nama_kategori')->ignore($kategoriId),
            ],
            'deskripsi' => ['nullable', 'string', 'max:500'],
            'bobot_prioritas' => ['required', 'integer', 'in:1,2,3'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique' => 'Kategori tersebut sudah terdaftar.',
            'nama_kategori.max' => 'Nama kategori maksimal 100 karakter.',
            'deskripsi.max' => 'Deskripsi maksimal 500 karakter.',
            'bobot_prioritas.required' => 'Bobot prioritas wajib dipilih.',
            'bobot_prioritas.in' => 'Pilihan bobot prioritas tidak valid (1: Rendah, 2: Sedang, 3: Tinggi).',
        ];
    }
}
