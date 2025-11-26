@extends('layouts.admin')

@section('title', 'Şifre Değiştir')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Şifre Değiştir</h1>
        </div>

        @if($errors->any())
        <div class="mb-6 p-4 bg-red-100 dark:bg-red-900 border border-red-400 text-red-700 dark:text-red-300 rounded-lg">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 dark:bg-green-900 border border-green-400 text-green-700 dark:text-green-300 rounded-lg">
            {{ session('success') }}
        </div>
        @endif

        <form action="{{ route('admin.change-password.update') }}" method="POST">
            @csrf
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Mevcut Şifre</label>
                <input 
                    type="password" 
                    name="current_password" 
                    required 
                    class="input-field"
                    placeholder="Mevcut şifrenizi girin"
                >
                @error('current_password')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Yeni Şifre</label>
                <input 
                    type="password" 
                    name="password" 
                    required 
                    class="input-field"
                    placeholder="En az 8 karakter, büyük/küçük harf, rakam ve sembol içermeli"
                >
                @error('password')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    Şifreniz en az 8 karakter uzunluğunda olmalı ve büyük harf, küçük harf, rakam ve sembol içermelidir.
                </p>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Yeni Şifre (Tekrar)</label>
                <input 
                    type="password" 
                    name="password_confirmation" 
                    required 
                    class="input-field"
                    placeholder="Yeni şifrenizi tekrar girin"
                >
                @error('password_confirmation')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-4">
                <button type="submit" class="btn-primary">
                    <svg class="w-5 h-5 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    Şifreyi Değiştir
                </button>
                <a href="{{ route('admin.dashboard') }}" class="btn-secondary">
                    İptal
                </a>
            </div>
        </form>

        <div class="mt-6 p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
            <div class="flex">
                <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <div class="text-sm text-yellow-800 dark:text-yellow-200">
                    <p class="font-medium">Önemli Bilgi:</p>
                    <p>Şifrenizi değiştirdikten sonra otomatik olarak çıkış yapılacak ve yeni şifrenizle tekrar giriş yapmanız gerekecektir.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
