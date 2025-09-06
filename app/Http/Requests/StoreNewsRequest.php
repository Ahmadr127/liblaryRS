<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNewsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->hasPermission('manage_news');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Judul berita wajib diisi.',
            'title.max' => 'Judul berita maksimal 255 karakter.',
            'content.required' => 'Konten berita wajib diisi.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'image.image' => 'File yang diupload harus berupa gambar.',
            'image.mimes' => 'Gambar harus berformat JPEG, PNG, JPG, atau GIF.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
            'status.required' => 'Status berita wajib dipilih.',
            'status.in' => 'Status berita tidak valid.',
            'published_at.date' => 'Tanggal publikasi harus berupa tanggal yang valid.',
            // no message; allow optional datetime, controller will normalize
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'title' => 'judul berita',
            'content' => 'konten berita',
            'category_id' => 'kategori',
            'image' => 'gambar',
            'status' => 'status',
            'published_at' => 'tanggal publikasi',
        ];
    }
}
