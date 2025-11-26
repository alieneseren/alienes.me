@extends('layouts.admin')
@section('title', 'Profil Düzenle')
@section('content')
<h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Profil Bilgileri</h1>

<!-- GitHub Sync Section -->
<div class="card mb-6" x-data="{ showGithub: false, username: '{{ $profile->github_username ?? '' }}' }">
    <div class="flex justify-between items-center mb-4">
        <div>
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">GitHub Profil Senkronizasyonu</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">GitHub profilinizden bilgileri otomatik çekin</p>
            @if($profile->github_synced_at)
                <p class="text-xs text-green-600 dark:text-green-400 mt-1">
                    Son senkronizasyon: {{ $profile->github_synced_at->diffForHumans() }}
                </p>
            @endif
        </div>
        <button 
            type="button" 
            @click="showGithub = !showGithub"
            class="text-primary-600 dark:text-primary-400 hover:underline text-sm">
            <span x-text="showGithub ? 'Gizle' : 'Göster'"></span>
        </button>
    </div>
    
    <div x-show="showGithub" x-transition>
        <form action="{{ route('admin.profile.sync-github') }}" method="POST" class="flex gap-2">
            @csrf
            <input 
                type="text" 
                name="username"
                x-model="username"
                placeholder="GitHub kullanıcı adı (alieneseren)"
                class="input-field flex-1">
            <button type="submit" class="btn-primary whitespace-nowrap">
                🔄 Senkronize Et
            </button>
        </form>
        
        @if($profile->github_username)
        <div class="mt-4 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
            <div class="flex items-center gap-4">
                @if($profile->github_avatar_url)
                <img src="{{ $profile->github_avatar_url }}" alt="{{ $profile->github_username }}" class="w-16 h-16 rounded-full">
                @endif
                <div>
                    <h3 class="font-semibold text-gray-900 dark:text-white">@{{ $profile->github_username }}</h3>
                    @if($profile->github_bio)
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $profile->github_bio }}</p>
                    @endif
                    <div class="flex gap-4 mt-2 text-xs text-gray-500 dark:text-gray-400">
                        <span>📦 {{ $profile->github_public_repos }} repo</span>
                        <span>👥 {{ $profile->github_followers }} takipçi</span>
                        <span>👤 {{ $profile->github_following }} takip</span>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<div class="card">
    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Ad Soyad *</label>
                <input type="text" name="full_name" value="{{ old('full_name', $profile->full_name) }}" required class="input-field">
                @error('full_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Unvan *</label>
                <input type="text" name="title" value="{{ old('title', $profile->title) }}" required class="input-field">
                @error('title')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Biyografi *</label>
                <textarea name="bio" rows="6" required class="input-field">{{ old('bio', $profile->bio) }}</textarea>
                @error('bio')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email *</label>
                <input type="email" name="email" value="{{ old('email', $profile->email) }}" required class="input-field">
                @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Telefon</label>
                <input type="text" name="phone" value="{{ old('phone', $profile->phone) }}" class="input-field">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Konum</label>
                <input type="text" name="location" value="{{ old('location', $profile->location) }}" class="input-field">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Profil Fotoğrafı</label>
                <input type="file" name="profile_image" accept="image/*" class="input-field">
                @if($profile->profile_image)
                <img src="{{ asset('storage/' . $profile->profile_image) }}" class="w-32 h-32 object-cover rounded-lg mt-2">
                @elseif($profile->github_avatar_url)
                <img src="{{ $profile->github_avatar_url }}" class="w-32 h-32 object-cover rounded-lg mt-2" alt="GitHub Avatar">
                @endif
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">GitHub Kullanıcı Adı</label>
                <input type="text" name="github_username" value="{{ old('github_username', $profile->github_username) }}" class="input-field" placeholder="alieneseren">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">GitHub URL</label>
                <input type="url" name="github_url" value="{{ old('github_url', $profile->github_url) }}" class="input-field" placeholder="https://github.com/alieneseren">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">LinkedIn URL</label>
                <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $profile->linkedin_url) }}" class="input-field">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Twitter URL</label>
                <input type="url" name="twitter_url" value="{{ old('twitter_url', $profile->twitter_url) }}" class="input-field">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Instagram URL</label>
                <input type="url" name="instagram_url" value="{{ old('instagram_url', $profile->instagram_url) }}" class="input-field">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">CV/Özgeçmiş URL</label>
                <input type="url" name="resume_url" value="{{ old('resume_url', $profile->resume_url) }}" class="input-field">
            </div>
        </div>
        <div class="mt-6">
            <button type="submit" class="btn-primary">Kaydet</button>
        </div>
    </form>
</div>
@endsection
