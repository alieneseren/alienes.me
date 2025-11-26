@extends('layouts.frontend')
@section('title', 'İletişim - ' . ($profile->full_name ?? 'alienes.me'))
@section('content')
<section class="py-20 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold text-center text-gray-900 dark:text-white mb-4">İletişim</h1>
        <p class="text-center text-gray-600 dark:text-gray-400 mb-12">Benimle iletişime geçin</p>
        
        @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 rounded-lg">
            {{ session('success') }}
        </div>
        @endif

        <div class="card">
            <form action="{{ route('contact.store') }}" method="POST" data-validate>
                @csrf
                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">İsim *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="input-field @error('name') border-red-500 @enderror">
                        @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="input-field @error('email') border-red-500 @enderror">
                        @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Konu *</label>
                    <input type="text" name="subject" value="{{ old('subject') }}" required class="input-field @error('subject') border-red-500 @enderror">
                    @error('subject')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Mesaj *</label>
                    <textarea name="message" rows="6" required class="input-field @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                    @error('message')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <button type="submit" class="btn-primary w-full">Gönder</button>
            </form>
        </div>

        @if($profile && ($profile->email || $profile->phone))
        <div class="mt-12 grid md:grid-cols-2 gap-6">
            @if($profile->email)
            <div class="card text-center">
                <svg class="w-12 h-12 text-primary-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Email</h3>
                <a href="mailto:{{ $profile->email }}" class="text-primary-600 dark:text-primary-400">{{ $profile->email }}</a>
            </div>
            @endif
            @if($profile->phone)
            <div class="card text-center">
                <svg class="w-12 h-12 text-primary-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                </svg>
                <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Telefon</h3>
                <a href="tel:{{ $profile->phone }}" class="text-primary-600 dark:text-primary-400">{{ $profile->phone }}</a>
            </div>
            @endif
        </div>
        @endif
    </div>
</section>
@endsection
