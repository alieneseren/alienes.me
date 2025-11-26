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
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        .dark ::-webkit-scrollbar-thumb { background: #475569; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        
        /* Glassmorphism */
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        .dark .glass {
            background: rgba(15, 23, 42, 0.7);
        }
        
        /* Sidebar Gradient */
        .sidebar-gradient {
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
        }
        
        /* Animations */
        .fade-in { animation: fadeIn 0.3s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
    <style type="text/tailwindcss">
        @layer components {
            .card {
                @apply bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6;
            }
            .input-field {
                @apply w-full px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 outline-none transition-all;
            }
            .btn-primary {
                @apply px-6 py-2.5 bg-sky-600 hover:bg-sky-700 text-white rounded-xl font-medium transition-all shadow-lg shadow-sky-600/30 flex items-center justify-center gap-2 cursor-pointer;
            }
            .btn-secondary {
                @apply px-6 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-xl font-medium transition-all flex items-center justify-center gap-2 cursor-pointer;
            }
            .btn-danger {
                @apply px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl font-medium transition-all shadow-lg shadow-red-600/30 flex items-center justify-center gap-2 cursor-pointer;
            }
        }
    </style>
    
    <script>
        // Dark Mode initialization
        if (localStorage.getItem('darkMode') === 'true' || (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-300">
    <div class="min-h-screen flex" x-data="{ sidebarOpen: false }">
        
        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-black/50 lg:hidden backdrop-blur-sm transition-opacity" 
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed lg:static inset-y-0 left-0 z-50 w-72 sidebar-gradient text-white transform lg:translate-x-0 transition-transform duration-300 ease-in-out shadow-2xl flex flex-col">
            <!-- Logo -->
            <div class="h-20 flex items-center px-8 border-b border-white/10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-sky-400 to-blue-600 flex items-center justify-center shadow-lg shadow-sky-500/30">
                        <i class="fas fa-rocket text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold tracking-tight">Alienes<span class="text-sky-400">.me</span></h1>
                        <p class="text-xs text-gray-400 font-medium">Admin Console</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1">
                <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Genel</p>
                
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.dashboard') ? 'bg-white/10 text-white shadow-lg shadow-black/10' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                    <i class="fas fa-chart-pie w-5 text-center {{ request()->routeIs('admin.dashboard') ? 'text-sky-400' : 'group-hover:text-sky-400' }}"></i>
                    <span class="font-medium">Dashboard</span>
                </a>

                <a href="{{ route('admin.profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.profile.*') ? 'bg-white/10 text-white shadow-lg shadow-black/10' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                    <i class="fas fa-user-circle w-5 text-center {{ request()->routeIs('admin.profile.*') ? 'text-sky-400' : 'group-hover:text-sky-400' }}"></i>
                    <span class="font-medium">Profil</span>
                </a>

                <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mt-6 mb-2">İçerik Yönetimi</p>

                <a href="{{ route('admin.cv.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.cv.*') ? 'bg-white/10 text-white shadow-lg shadow-black/10' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                    <i class="fas fa-file-alt w-5 text-center {{ request()->routeIs('admin.cv.*') ? 'text-sky-400' : 'group-hover:text-sky-400' }}"></i>
                    <span class="font-medium">CV Yönetimi</span>
                    <span class="ml-auto bg-sky-500/20 text-sky-400 text-xs font-bold px-2 py-0.5 rounded-full">Yeni</span>
                </a>

                <a href="{{ route('admin.projects.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.projects.*') ? 'bg-white/10 text-white shadow-lg shadow-black/10' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                    <i class="fas fa-code-branch w-5 text-center {{ request()->routeIs('admin.projects.*') ? 'text-sky-400' : 'group-hover:text-sky-400' }}"></i>
                    <span class="font-medium">Projeler</span>
                </a>

                <a href="{{ route('admin.experiences.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.experiences.*') ? 'bg-white/10 text-white shadow-lg shadow-black/10' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                    <i class="fas fa-briefcase w-5 text-center {{ request()->routeIs('admin.experiences.*') ? 'text-sky-400' : 'group-hover:text-sky-400' }}"></i>
                    <span class="font-medium">Deneyimler</span>
                </a>

                <a href="{{ route('admin.educations.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.educations.*') ? 'bg-white/10 text-white shadow-lg shadow-black/10' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                    <i class="fas fa-graduation-cap w-5 text-center {{ request()->routeIs('admin.educations.*') ? 'text-sky-400' : 'group-hover:text-sky-400' }}"></i>
                    <span class="font-medium">Eğitim</span>
                </a>

                <a href="{{ route('admin.skills.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.skills.*') ? 'bg-white/10 text-white shadow-lg shadow-black/10' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                    <i class="fas fa-bolt w-5 text-center {{ request()->routeIs('admin.skills.*') ? 'text-sky-400' : 'group-hover:text-sky-400' }}"></i>
                    <span class="font-medium">Yetenekler</span>
                </a>

                <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mt-6 mb-2">Eğitim Modülleri</p>

                <a href="{{ route('admin.study-categories.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.study-categories.*') ? 'bg-white/10 text-white shadow-lg shadow-black/10' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                    <i class="fas fa-folder-open w-5 text-center {{ request()->routeIs('admin.study-categories.*') ? 'text-sky-400' : 'group-hover:text-sky-400' }}"></i>
                    <span class="font-medium">Kategoriler</span>
                </a>

                <a href="{{ route('admin.study-notes.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.study-notes.*') ? 'bg-white/10 text-white shadow-lg shadow-black/10' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                    <i class="fas fa-book-open w-5 text-center {{ request()->routeIs('admin.study-notes.*') ? 'text-sky-400' : 'group-hover:text-sky-400' }}"></i>
                    <span class="font-medium">Notlar</span>
                </a>

                <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mt-6 mb-2">İletişim</p>

                <a href="{{ route('admin.contacts.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.contacts.*') ? 'bg-white/10 text-white shadow-lg shadow-black/10' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                    <i class="fas fa-envelope w-5 text-center {{ request()->routeIs('admin.contacts.*') ? 'text-sky-400' : 'group-hover:text-sky-400' }}"></i>
                    <span class="font-medium">Mesajlar</span>
                </a>
            </nav>

            <!-- User Profile -->
            <div class="p-4 border-t border-white/10">
                <div class="flex items-center gap-3 p-3 rounded-xl bg-white/5 hover:bg-white/10 transition-colors cursor-pointer">
                    <div class="w-10 h-10 rounded-full bg-sky-500 flex items-center justify-center text-white font-bold">
                        {{ substr(session('user_name', 'A'), 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate">{{ session('user_name') }}</p>
                        <p class="text-xs text-gray-400 truncate">Administrator</p>
                    </div>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-red-400 transition-colors">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Top Header -->
            <header class="h-20 glass border-b border-gray-200 dark:border-gray-800 flex items-center justify-between px-6 lg:px-10 sticky top-0 z-30">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="lg:hidden p-2 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white hidden sm:block">@yield('title')</h2>
                </div>

                <div class="flex items-center gap-4">
                    <a href="/" target="_blank" class="hidden sm:flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-external-link-alt"></i> Siteyi Görüntüle
                    </a>

                    <button id="darkModeToggle" class="p-2.5 text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors shadow-sm">
                        <i class="fas fa-moon hidden dark:block"></i>
                        <i class="fas fa-sun block dark:hidden text-amber-500"></i>
                    </button>
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 overflow-y-auto p-6 lg:p-10">
                <div class="max-w-7xl mx-auto fade-in">
                    @if(session('success'))
                        <div class="mb-6 p-4 rounded-xl bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 flex items-center gap-3 text-green-700 dark:text-green-400 shadow-sm" role="alert">
                            <i class="fas fa-check-circle text-xl"></i>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-6 p-4 rounded-xl bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 shadow-sm" role="alert">
                            <div class="flex items-center gap-3 mb-2">
                                <i class="fas fa-exclamation-circle text-xl"></i>
                                <span class="font-bold">Bir şeyler yanlış gitti!</span>
                            </div>
                            <ul class="list-disc list-inside ml-8 space-y-1 text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script>
        // Dark Mode Toggle Logic
        const darkModeToggle = document.getElementById('darkModeToggle');
        const html = document.documentElement;
        
        darkModeToggle.addEventListener('click', () => {
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.setItem('darkMode', 'false');
            } else {
                html.classList.add('dark');
                localStorage.setItem('darkMode', 'true');
            }
        });
    </script>
</body>
</html>
