@extends('layouts.frontend')

@section('title', 'İletişim - Alienes.me')
@section('meta_description', 'Benimle iletişime geçin')

@section('content')
<!-- Page Header -->
<section class="pt-24 pb-12 bg-gradient-to-br from-primary-50 to-white dark:from-gray-900 dark:to-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-5xl font-bold text-gray-900 dark:text-white mb-4">İletişim</h1>
        <p class="text-xl text-gray-600 dark:text-gray-300">Projeleriniz veya sorularınız için benimle iletişime geçin</p>
    </div>
</section>

<!-- Contact Section -->
<section class="py-20 bg-white dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 gap-12">
            <!-- Contact Form -->
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Mesaj Gönderin</h2>
                
                @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded-lg">
                    {{ session('success') }}
                </div>
                @endif
                
                @if($errors->any())
                <div class="mb-6 p-4 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                
                <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Adınız *
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-600 dark:bg-gray-900 dark:text-white">
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            E-posta *
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-600 dark:bg-gray-900 dark:text-white">
                    </div>
                    
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Konu *
                        </label>
                        <input type="text" 
                               id="subject" 
                               name="subject" 
                               value="{{ old('subject') }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-600 dark:bg-gray-900 dark:text-white">
                    </div>
                    
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Mesajınız *
                        </label>
                        <textarea id="message" 
                                  name="message" 
                                  rows="6"
                                  required
                                  class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-600 dark:bg-gray-900 dark:text-white">{{ old('message') }}</textarea>
                    </div>
                    
                    <button type="submit" class="btn-primary w-full">
                        Gönder
                    </button>
                </form>
            </div>
            
            <!-- Contact Info -->
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">İletişim Bilgileri</h2>
                
                <div class="space-y-6">
                    @if($profile && $profile->email)
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">E-posta</h3>
                            <p class="text-gray-600 dark:text-gray-300">{{ $profile->email }}</p>
                        </div>
                    </div>
                    @endif
                    
                    @if($profile && $profile->phone)
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Telefon</h3>
                            <p class="text-gray-600 dark:text-gray-300">{{ $profile->phone }}</p>
                        </div>
                    </div>
                    @endif
                    
                    @if($profile && $profile->location)
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Konum</h3>
                            <p class="text-gray-600 dark:text-gray-300">{{ $profile->location }}</p>
                        </div>
                    </div>
                    @endif
                </div>
                
                <!-- Social Links -->
                @php
                    // Fallback: Eğer github_url yoksa, github_username'den oluştur
                    $github_url = $profile->github_url ?: ($profile->github_username ? 'https://github.com/' . $profile->github_username : null);
                @endphp
                @if($profile && (($profile->linkedin_url && !empty(trim($profile->linkedin_url))) || ($github_url && !empty(trim($github_url))) || ($profile->twitter_url && !empty(trim($profile->twitter_url))) || ($profile->instagram_url && !empty(trim($profile->instagram_url)))))
                <div class="mt-8 pt-8 border-t dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Sosyal Medya</h3>
                    <div class="flex space-x-6" style="display: flex;">
                        @if($profile->linkedin_url && !empty(trim($profile->linkedin_url)))
                        <a href="{{ $profile->linkedin_url }}" target="_blank" style="display: inline-flex; width: 56px; height: 56px;" class="items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 hover:bg-blue-200 dark:hover:bg-blue-800 transition transform hover:scale-110">
                            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                            </svg>
                        </a>
                        @endif
                        
                        @if($github_url && !empty(trim($github_url)))
                        <a href="{{ $github_url }}" target="_blank" style="display: inline-flex; width: 56px; height: 56px;" class="items-center justify-center rounded-full bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600 transition transform hover:scale-110">
                            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                            </svg>
                        </a>
                        @endif
                        
                        @if($profile->twitter_url && !empty(trim($profile->twitter_url)))
                        <a href="{{ $profile->twitter_url }}" target="_blank" style="display: inline-flex; width: 56px; height: 56px;" class="items-center justify-center rounded-full bg-sky-100 dark:bg-sky-900 text-sky-500 dark:text-sky-400 hover:bg-sky-200 dark:hover:bg-sky-800 transition transform hover:scale-110">
                            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417a9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                        @endif
                        
                        @if($profile->instagram_url && !empty(trim($profile->instagram_url)))
                        <a href="{{ $profile->instagram_url }}" target="_blank" style="display: inline-flex; width: 56px; height: 56px;" class="items-center justify-center rounded-full bg-pink-100 dark:bg-pink-900 text-pink-600 dark:text-pink-400 hover:bg-pink-200 dark:hover:bg-pink-800 transition transform hover:scale-110">
                            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
