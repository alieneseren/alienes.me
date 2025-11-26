<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Alienes.me</title>
    
    @php
        $profile = \App\Models\Profile::first();
        $faviconUrl = $profile && $profile->github_avatar_url 
            ? $profile->github_avatar_url 
            : asset('favicon.ico');
    @endphp
    
    <link rel="icon" type="image/png" href="{{ $faviconUrl }}">
    <link rel="apple-touch-icon" href="{{ $faviconUrl }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 dark:bg-gray-900">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white dark:bg-gray-800 border-r dark:border-gray-700">
            <div class="p-6 border-b dark:border-gray-700">
                <h1 class="text-2xl font-bold text-primary-600">Admin Panel</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ session('user_name') }}</p>
            </div>
            <nav class="p-4">
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded-lg mb-2 {{ request()->routeIs('admin.dashboard') ? 'bg-primary-100 dark:bg-primary-900 text-primary-600' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">Dashboard</a>
                <a href="{{ route('admin.profile.edit') }}" class="block px-4 py-2 rounded-lg mb-2 {{ request()->routeIs('admin.profile.*') ? 'bg-primary-100 dark:bg-primary-900 text-primary-600' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">Profil</a>
                <a href="{{ route('admin.experiences.index') }}" class="block px-4 py-2 rounded-lg mb-2 {{ request()->routeIs('admin.experiences.*') ? 'bg-primary-100 dark:bg-primary-900 text-primary-600' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">Deneyimler</a>
                <a href="{{ route('admin.educations.index') }}" class="block px-4 py-2 rounded-lg mb-2 {{ request()->routeIs('admin.educations.*') ? 'bg-primary-100 dark:bg-primary-900 text-primary-600' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">Eğitim</a>
                <a href="{{ route('admin.skills.index') }}" class="block px-4 py-2 rounded-lg mb-2 {{ request()->routeIs('admin.skills.*') ? 'bg-primary-100 dark:bg-primary-900 text-primary-600' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">Yetenekler</a>
                <a href="{{ route('admin.projects.index') }}" class="block px-4 py-2 rounded-lg mb-2 {{ request()->routeIs('admin.projects.*') ? 'bg-primary-100 dark:bg-primary-900 text-primary-600' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">Projeler</a>
                <a href="{{ route('admin.contacts.index') }}" class="block px-4 py-2 rounded-lg mb-2 {{ request()->routeIs('admin.contacts.*') ? 'bg-primary-100 dark:bg-primary-900 text-primary-600' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">Mesajlar</a>
                <hr class="my-4 dark:border-gray-700">
                <a href="{{ route('admin.change-password') }}" class="block px-4 py-2 rounded-lg mb-2 {{ request()->routeIs('admin.change-password') ? 'bg-primary-100 dark:bg-primary-900 text-primary-600' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                    </svg>
                    Şifre Değiştir
                </a>
                <a href="{{ route('home') }}" target="_blank" class="block px-4 py-2 rounded-lg mb-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Siteyi Görüntüle</a>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 rounded-lg text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">Çıkış Yap</button>
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 rounded-lg">
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="mb-6 p-4 bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 rounded-lg">
                {{ session('error') }}
            </div>
            @endif
            @yield('content')
        </main>
    </div>
</body>
</html>
