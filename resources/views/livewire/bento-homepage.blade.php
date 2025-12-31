{{-- Bento Grid Homepage - Modern Glassmorphism Layout --}}
<div class="min-h-screen bg-gradient-to-br from-[#0a0f1a] via-[#0f172a] to-[#1a1f35]">
    {{-- Hero Section --}}
    <header class="relative overflow-hidden">
        {{-- Animated Background Orbs --}}
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-500/20 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute top-20 -left-20 w-60 h-60 bg-purple-500/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s"></div>
            <div class="absolute bottom-0 right-1/3 w-40 h-40 bg-cyan-500/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
            <div class="text-center">
                {{-- Avatar --}}
                <div class="mb-8 flex justify-center">
                    <div class="relative group">
                        <div class="absolute -inset-1 bg-gradient-to-r from-blue-500 via-purple-500 to-cyan-500 rounded-full blur opacity-75 group-hover:opacity-100 transition duration-1000 group-hover:duration-200 animate-pulse"></div>
                        <div class="relative w-32 h-32 rounded-full bg-[#1e293b] flex items-center justify-center text-5xl">
                            🧑‍💻
                        </div>
                    </div>
                </div>

                {{-- Name & Title --}}
                <h1 class="text-4xl sm:text-6xl font-bold text-white mb-4">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-400 via-purple-400 to-cyan-400">
                        Ali Enes
                    </span>
                </h1>
                <p class="text-xl sm:text-2xl text-slate-400 mb-8">
                    Full-Stack Developer & Creative Technologist
                </p>

                {{-- Social Links --}}
                <div class="flex justify-center gap-4 mb-12">
                    <a href="https://github.com/alienes" target="_blank" 
                       class="p-3 rounded-xl bg-white/5 backdrop-blur-sm border border-white/10 text-slate-400 hover:text-white hover:bg-white/10 transition-all duration-300 hover:scale-110">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                    </a>
                    <a href="https://linkedin.com/in/alienes" target="_blank" 
                       class="p-3 rounded-xl bg-white/5 backdrop-blur-sm border border-white/10 text-slate-400 hover:text-white hover:bg-white/10 transition-all duration-300 hover:scale-110">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    </a>
                    <a href="mailto:contact@alienes.me" 
                       class="p-3 rounded-xl bg-white/5 backdrop-blur-sm border border-white/10 text-slate-400 hover:text-white hover:bg-white/10 transition-all duration-300 hover:scale-110">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </header>

    {{-- Bento Grid Section --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 auto-rows-[200px]">
            
            {{-- Projects Card (Large) --}}
            <a href="/" wire:navigate
               class="group col-span-1 md:col-span-2 row-span-2 rounded-3xl bg-gradient-to-br from-blue-600/20 to-blue-800/20 backdrop-blur-xl border border-white/10 p-6 hover:border-blue-400/50 transition-all duration-500 hover:scale-[1.02] relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative z-10 h-full flex flex-col">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-4xl">🚀</span>
                        <span class="px-3 py-1 rounded-full bg-blue-500/20 text-blue-400 text-sm">{{ $projectStats['published'] ?? 0 }} Proje</span>
                    </div>
                    <h2 class="text-2xl font-bold text-white mb-2">Projelerim</h2>
                    <p class="text-slate-400 mb-4 flex-1">Full-stack web uygulamaları, API'ler ve yaratıcı projeler.</p>
                    
                    {{-- Mini Project Cards --}}
                    <div class="space-y-2">
                        @foreach($featuredProjects->take(2) as $project)
                        <div class="p-3 rounded-xl bg-white/5 border border-white/5">
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">{{ $project->thumbnail ?? '💼' }}</span>
                                <div>
                                    <h3 class="text-white font-medium text-sm">{{ $project->title }}</h3>
                                    <p class="text-slate-500 text-xs">{{ Str::limit($project->description, 40) }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="flex items-center text-blue-400 mt-4 group-hover:translate-x-2 transition-transform">
                        <span>Tümünü Gör</span>
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </div>
                </div>
            </a>

            {{-- Balina Optimization Card --}}
            <a href="https://balina.alienes.me" target="_blank"
               class="group col-span-1 row-span-1 rounded-3xl bg-gradient-to-br from-cyan-600/20 to-cyan-800/20 backdrop-blur-xl border border-white/10 p-6 hover:border-cyan-400/50 transition-all duration-500 hover:scale-[1.02] relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-cyan-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative z-10 h-full flex flex-col">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-3xl">🐋</span>
                        <span class="px-2 py-0.5 rounded-full bg-cyan-500/20 text-cyan-400 text-xs">Yeni</span>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-1">Balina Optimizasyon</h3>
                    <p class="text-slate-400 text-sm flex-1">WOA, PSO, GWO, GA algoritmaları</p>
                    <div class="flex items-center text-cyan-400 text-sm group-hover:translate-x-1 transition-transform">
                        <span>Keşfet</span>
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </div>
            </a>

            {{-- Study Portal Card --}}
            <a href="https://study.alienes.me" target="_blank"
               class="group col-span-1 row-span-1 rounded-3xl bg-gradient-to-br from-purple-600/20 to-purple-800/20 backdrop-blur-xl border border-white/10 p-6 hover:border-purple-400/50 transition-all duration-500 hover:scale-[1.02] relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-purple-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative z-10 h-full flex flex-col">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-3xl">📚</span>
                        <span class="px-2 py-0.5 rounded-full bg-purple-500/20 text-purple-400 text-xs">{{ $studyStats['total_courses'] ?? 0 }} Kurs</span>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-1">Study Portal</h3>
                    <p class="text-slate-400 text-sm flex-1">Kurslar, flashcard'lar ve quizler</p>
                    <div class="flex items-center text-purple-400 text-sm group-hover:translate-x-1 transition-transform">
                        <span>Öğrenmeye Başla</span>
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </div>
            </a>

            {{-- Games Portal Card (Large) --}}
            <a href="https://games.alienes.me" target="_blank"
               class="group col-span-1 lg:col-span-2 row-span-1 rounded-3xl bg-gradient-to-br from-green-600/20 to-green-800/20 backdrop-blur-xl border border-white/10 p-6 hover:border-green-400/50 transition-all duration-500 hover:scale-[1.02] relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-green-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative z-10 h-full flex flex-col">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-3xl">🎮</span>
                        <div class="flex items-center gap-2">
                            <span class="px-2 py-0.5 rounded-full bg-green-500/20 text-green-400 text-xs">{{ $gameStats['total_games'] ?? 0 }} Oyun</span>
                            <span class="px-2 py-0.5 rounded-full bg-yellow-500/20 text-yellow-400 text-xs">{{ number_format($gameStats['total_plays'] ?? 0) }} Oynama</span>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-1">Games Portal</h3>
                    <p class="text-slate-400 text-sm flex-1">Arcade oyunlar, leaderboard ve başarımlar</p>
                    <div class="flex items-center gap-4">
                        @foreach($featuredGames->take(3) as $game)
                        <div class="flex items-center gap-2 text-sm text-slate-300">
                            <span>{{ $game->thumbnail ?? '🎯' }}</span>
                            <span>{{ $game->name }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </a>

            {{-- Stats Card --}}
            <div class="col-span-1 row-span-1 rounded-3xl bg-gradient-to-br from-slate-600/20 to-slate-800/20 backdrop-blur-xl border border-white/10 p-6 relative overflow-hidden">
                <div class="relative z-10 h-full flex flex-col justify-between">
                    <h3 class="text-lg font-bold text-white mb-4">📊 İstatistikler</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-400">{{ $projectStats['total'] ?? 0 }}</div>
                            <div class="text-xs text-slate-500">Proje</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-400">{{ $gameStats['total_games'] ?? 0 }}</div>
                            <div class="text-xs text-slate-500">Oyun</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-purple-400">{{ $studyStats['total_courses'] ?? 0 }}</div>
                            <div class="text-xs text-slate-500">Kurs</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-cyan-400">4</div>
                            <div class="text-xs text-slate-500">Algoritma</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tech Stack Card --}}
            <div class="col-span-1 md:col-span-2 lg:col-span-2 row-span-1 rounded-3xl bg-gradient-to-br from-orange-600/20 to-orange-800/20 backdrop-blur-xl border border-white/10 p-6 relative overflow-hidden">
                <div class="relative z-10 h-full flex flex-col">
                    <h3 class="text-lg font-bold text-white mb-4">🛠️ Tech Stack</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach(['Laravel', 'Livewire', 'Alpine.js', 'Tailwind CSS', 'FilamentPHP', 'MySQL', 'Redis', 'Docker', 'Vue.js', 'Python', 'MATLAB'] as $tech)
                        <span class="px-3 py-1 rounded-full bg-white/5 border border-white/10 text-slate-300 text-sm hover:bg-white/10 transition-colors cursor-default">
                            {{ $tech }}
                        </span>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Contact Card --}}
            <a href="mailto:contact@alienes.me"
               class="group col-span-1 row-span-1 rounded-3xl bg-gradient-to-br from-pink-600/20 to-pink-800/20 backdrop-blur-xl border border-white/10 p-6 hover:border-pink-400/50 transition-all duration-500 hover:scale-[1.02] relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-pink-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative z-10 h-full flex flex-col justify-between">
                    <div>
                        <span class="text-3xl">✉️</span>
                        <h3 class="text-lg font-bold text-white mt-2">İletişim</h3>
                        <p class="text-slate-400 text-sm">Proje veya iş birliği için</p>
                    </div>
                    <div class="flex items-center text-pink-400 text-sm group-hover:translate-x-1 transition-transform">
                        <span>Mesaj Gönder</span>
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </div>
            </a>

            {{-- Blog/Posts Card --}}
            <a href="/blog"
               class="group col-span-1 row-span-1 rounded-3xl bg-gradient-to-br from-amber-600/20 to-amber-800/20 backdrop-blur-xl border border-white/10 p-6 hover:border-amber-400/50 transition-all duration-500 hover:scale-[1.02] relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-amber-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative z-10 h-full flex flex-col justify-between">
                    <div>
                        <span class="text-3xl">📝</span>
                        <h3 class="text-lg font-bold text-white mt-2">Blog</h3>
                        <p class="text-slate-400 text-sm">Yazılar ve notlar</p>
                    </div>
                    <div class="flex items-center text-amber-400 text-sm group-hover:translate-x-1 transition-transform">
                        <span>Oku</span>
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </div>
            </a>
        </div>
    </main>

    {{-- Footer --}}
    <footer class="border-t border-white/5 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-slate-500 text-sm">
                © {{ date('Y') }} alienes.me • Made with ❤️ using Laravel & Livewire
            </p>
        </div>
    </footer>
</div>
