<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Auth middleware already handles this
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
            'technologies' => 'required|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048|dimensions:min_width=100,min_height=100,max_width=4000,max_height=4000',
            'demo_url' => 'nullable|url|max:500',
            'github_url' => 'nullable|url|max:500',
            'is_featured' => 'boolean',
            'order' => 'integer|min:0|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Proje başlığı zorunludur.',
            'description.required' => 'Proje açıklaması zorunludur.',
            'technologies.required' => 'Teknolojiler alanı zorunludur.',
            'image.image' => 'Dosya bir resim olmalıdır.',
            'image.mimes' => 'Resim jpeg, png, jpg veya webp formatında olmalıdır.',
            'image.max' => 'Resim boyutu en fazla 2MB olabilir.',
            'image.dimensions' => 'Resim boyutları 100x100 ile 4000x4000 arasında olmalıdır.',
            'demo_url.url' => 'Geçerli bir URL giriniz.',
            'github_url.url' => 'Geçerli bir GitHub URL giriniz.',
        ];
    }
}
