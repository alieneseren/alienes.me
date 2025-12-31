<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|regex:/^[\pL\s\-\.]+$/u',
            'email' => 'required|email:rfc|max:255',
            'subject' => 'required|string|max:255|min:3|regex:/^[\pL\d\s\-\.,:!?()]+$/u',
            'message' => 'required|string|max:2000|min:10|regex:/^[\pL\d\s\-\.,:!?()\n\r@]+$/u',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'İsim alanı zorunludur.',
            'name.regex' => 'İsim sadece harf ve boşluk içerebilir.',
            'email.required' => 'E-posta adresi zorunludur.',
            'email.email' => 'Geçerli bir e-posta adresi giriniz.',
            'subject.required' => 'Konu alanı zorunludur.',
            'subject.min' => 'Konu en az 3 karakter olmalıdır.',
            'message.required' => 'Mesaj alanı zorunludur.',
            'message.min' => 'Mesaj en az 10 karakter olmalıdır.',
            'message.max' => 'Mesaj en fazla 2000 karakter olabilir.',
        ];
    }
}
