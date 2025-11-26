@extends('layouts.admin')
@section('title', 'Profil Düzenle')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Profil Bilgileri</h1>
    <p class="text-gray-500 dark:text-gray-400 mt-1">Kişisel bilgilerinizi ve sosyal medya hesaplarınızı yönetin.</p>
</div>

<!-- GitHub Sync Section -->
<div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 mb-6" x-data="{ showGithub: false, username: '{{ $profile->github_username ?? '' }}' }">
    <div class="flex justify-between items-center mb-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gray-900 flex items-center justify-center text-white">
                <i class="fab fa-github text-xl"></i>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-800 dark:text-white">GitHub Profil Senkronizasyonu</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400">GitHub profilinizden bilgileri otomatik çekin</p>
                @if($profile->github_synced_at)
                    <p class="text-xs text-green-600 dark:text-green-400 mt-1 flex items-center gap-1">
                        <i class="fas fa-check-circle"></i>
                        Son senkronizasyon: {{ $profile->github_synced_at->diffForHumans() }}
                    </p>
                @endif
            </div>
        </div>
        <button 
            type="button" 
            @click="showGithub = !showGithub"
            class="text-sky-600 dark:text-sky-400 hover:text-sky-700 font-medium text-sm flex items-center gap-2 bg-sky-50 dark:bg-sky-900/30 px-3 py-1.5 rounded-lg transition-colors">
            <span x-text="showGithub ? 'Gizle' : 'Göster'"></span>
            <i class="fas" :class="showGithub ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
        </button>
    </div>
    
    <div x-show="showGithub" x-transition>
        <div class="p-4 bg-gray-50 dark:bg-gray-700/30 rounded-xl border border-gray-100 dark:border-gray-700">
            <form action="{{ route('admin.profile.sync-github') }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                @csrf
                <input 
                    type="text" 
                    name="username"
                    x-model="username"
                    placeholder="GitHub kullanıcı adı (alieneseren)"
                    class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all">
                <button type="submit" class="px-6 py-2 bg-gray-900 hover:bg-black text-white rounded-xl font-medium transition-all shadow-lg shadow-gray-900/30 whitespace-nowrap flex items-center justify-center gap-2">
                    <i class="fas fa-sync-alt"></i>
                    Senkronize Et
                </button>
            </form>
            
            @if($profile->github_username)
            <div class="mt-4 p-4 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-600">
                <div class="flex items-center gap-4">
                    @if($profile->github_avatar_url)
                    <img src="{{ $profile->github_avatar_url }}" alt="{{ $profile->github_username }}" class="w-16 h-16 rounded-full border-2 border-gray-100 dark:border-gray-700">
                    @endif
                    <div>
                        <h3 class="font-bold text-gray-900 dark:text-white text-lg">@{{ $profile->github_username }}</h3>
                        @if($profile->github_bio)
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $profile->github_bio }}</p>
                        @endif
                        <div class="flex flex-wrap gap-4 mt-2 text-xs font-medium text-gray-500 dark:text-gray-400">
                            <span class="flex items-center gap-1"><i class="fas fa-box"></i> {{ $profile->github_public_repos }} repo</span>
                            <span class="flex items-center gap-1"><i class="fas fa-users"></i> {{ $profile->github_followers }} takipçi</span>
                            <span class="flex items-center gap-1"><i class="fas fa-user-plus"></i> {{ $profile->github_following }} takip</span>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Ad Soyad *</label>
                <input type="text" name="full_name" value="{{ old('full_name', $profile->full_name) }}" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all">
                @error('full_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Unvan *</label>
                <input type="text" name="title" value="{{ old('title', $profile->title) }}" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all">
                @error('title')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Biyografi *</label>
                <textarea name="bio" rows="6" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all">{{ old('bio', $profile->bio) }}</textarea>
                @error('bio')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email *</label>
                <input type="email" name="email" value="{{ old('email', $profile->email) }}" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all">
                @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Telefon</label>
                <input type="text" name="phone" value="{{ old('phone', $profile->phone) }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Konum</label>
                <input type="text" name="location" value="{{ old('location', $profile->location) }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Profil Fotoğrafı</label>
                <input type="file" name="profile_image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all">
                @if($profile->profile_image)
                <div class="mt-4 flex items-end gap-3">
                    <img src="{{ asset('storage/' . $profile->profile_image) }}" class="w-32 h-32 object-cover rounded-xl shadow-md">
                    <button type="submit" form="delete-image-form" class="px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg text-sm font-medium transition-colors">
                        <i class="fas fa-trash-alt mr-1"></i> Sil
                    </button>
                </div>
                @elseif($profile->github_avatar_url)
                <div class="mt-4">
                    <img src="{{ $profile->github_avatar_url }}" class="w-32 h-32 object-cover rounded-xl shadow-md">
                    <p class="text-xs text-gray-500 mt-1">GitHub'dan çekilen avatar</p>
                </div>
                @endif
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">GitHub Kullanıcı Adı</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                        <i class="fab fa-github"></i>
                    </span>
                    <input type="text" name="github_username" value="{{ old('github_username', $profile->github_username) }}" class="w-full pl-10 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all" placeholder="alieneseren">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">GitHub URL</label>
                <input type="url" name="github_url" value="{{ old('github_url', $profile->github_url) }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all" placeholder="https://github.com/alieneseren">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">LinkedIn URL</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-blue-600">
                        <i class="fab fa-linkedin"></i>
                    </span>
                    <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $profile->linkedin_url) }}" class="w-full pl-10 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Twitter URL</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-sky-500">
                        <i class="fab fa-twitter"></i>
                    </span>
                    <input type="url" name="twitter_url" value="{{ old('twitter_url', $profile->twitter_url) }}" class="w-full pl-10 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Instagram URL</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-pink-600">
                        <i class="fab fa-instagram"></i>
                    </span>
                    <input type="url" name="instagram_url" value="{{ old('instagram_url', $profile->instagram_url) }}" class="w-full pl-10 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">CV/Özgeçmiş URL</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                        <i class="fas fa-file-alt"></i>
                    </span>
                    <input type="url" name="resume_url" value="{{ old('resume_url', $profile->resume_url) }}" class="w-full pl-10 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all">
                </div>
            </div>
        </div>
        <div class="mt-6">
            <button type="submit" class="px-6 py-2.5 bg-sky-600 hover:bg-sky-700 text-white rounded-xl font-medium transition-all shadow-lg shadow-sky-600/30">
                <i class="fas fa-save mr-2"></i> Kaydet
            </button>
        </div>
    </form>
</div>
<form id="delete-image-form" action="{{ route('admin.profile.delete-image') }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endsection
