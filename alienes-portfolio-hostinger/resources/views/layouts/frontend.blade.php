<!DOCTYPE html>
<html lang="tr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Professional Portfolio Website')">
    <title>@yield('title', 'Alienes.me - Portfolio')</title>
    
    @php
        $profile = \App\Models\Profile::first();
        $faviconUrl = $profile && $profile->github_avatar_url 
            ? $profile->github_avatar_url 
            : asset('favicon.ico');
        
        // Check if sections have content
        $hasExperiences = \App\Models\Experience::count() > 0;
        $hasSkills = \App\Models\Skill::count() > 0;
        $hasProjects = \App\Models\Project::count() > 0;
    @endphp
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ $faviconUrl }}">
    <link rel="apple-touch-icon" href="{{ $faviconUrl }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <!-- Navigation -->
    <nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="text-2xl font-bold text-primary-600 dark:text-primary-400">
                    alienes.me
                </a>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition">Ana Sayfa</a>
                    <a href="{{ route('home') }}#about" class="text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition">Hakkımda</a>
                    @if($hasExperiences)
                    <a href="{{ route('home') }}#experience" class="text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition">Deneyim</a>
                    @endif
                    @if($hasSkills)
                    <a href="{{ route('home') }}#skills" class="text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition">Yetenekler</a>
                    @endif
                    @if($hasProjects)
                    <a href="{{ route('projects') }}" class="text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition">Projeler</a>
                    @endif
                    <a href="{{ route('contact') }}" class="text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition">İletişim</a>
                    
                    <!-- Dark Mode Toggle -->
                    <button id="darkModeToggle" class="p-2 rounded-lg bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                        <svg class="w-5 h-5 hidden dark:block" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"></path>
                        </svg>
                        <svg class="w-5 h-5 block dark:hidden" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                    </button>
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobileMenuBtn" class="md:hidden p-2 rounded-lg bg-gray-200 dark:bg-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden md:hidden bg-white dark:bg-gray-800 border-t dark:border-gray-700">
            <div class="px-4 py-4 space-y-3">
                <a href="{{ route('home') }}" class="block text-gray-700 dark:text-gray-300 hover:text-primary-600">Ana Sayfa</a>
                <a href="{{ route('home') }}#about" class="block text-gray-700 dark:text-gray-300 hover:text-primary-600">Hakkımda</a>
                @if($hasExperiences)
                <a href="{{ route('home') }}#experience" class="block text-gray-700 dark:text-gray-300 hover:text-primary-600">Deneyim</a>
                @endif
                @if($hasSkills)
                <a href="{{ route('home') }}#skills" class="block text-gray-700 dark:text-gray-300 hover:text-primary-600">Yetenekler</a>
                @endif
                @if($hasProjects)
                <a href="{{ route('projects') }}" class="block text-gray-700 dark:text-gray-300 hover:text-primary-600">Projeler</a>
                @endif
                <a href="{{ route('contact') }}" class="block text-gray-700 dark:text-gray-300 hover:text-primary-600">İletişim</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-16">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-100 dark:bg-gray-900 border-t dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="text-center">
                <p class="text-gray-600 dark:text-gray-400">
                    © {{ date('Y') }} alienes.me. Tüm hakları saklıdır.
                </p>
                <p class="text-sm text-gray-500 dark:text-gray-500 mt-2">
                    Laravel ile ❤️ ile yapılmıştır.
                </p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.getElementById('mobileMenuBtn').addEventListener('click', function() {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        });
    </script>
</body>
</html>
