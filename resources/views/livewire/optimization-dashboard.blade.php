<div class="min-h-screen flex flex-col lg:flex-row" 
     x-data="{ 
         sidebarOpen: window.innerWidth >= 1024,
         toggleSidebar() { this.sidebarOpen = !this.sidebarOpen }
     }"
     @resize.window="if(window.innerWidth >= 1024) sidebarOpen = true; else sidebarOpen = false">
    
    <!-- ==================== MOBILE HEADER ==================== -->
    <div class="lg:hidden glass-strong p-4 flex items-center justify-between sticky top-0 z-50">
        <h2 class="text-lg font-bold text-white tracking-tight flex items-center">
            <span class="text-2xl mr-2">🐋</span> 
            <span class="bg-gradient-to-r from-electric-blue to-cyan-accent bg-clip-text text-transparent">OptimDashboard</span>
        </h2>
        <button @click="toggleSidebar()" class="p-2 rounded-lg bg-white/10 text-white hover:bg-white/20 transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    <!-- ==================== MOBILE OVERLAY ==================== -->
    <div x-show="sidebarOpen && window.innerWidth < 1024" 
         @click="sidebarOpen = false"
         x-transition:enter="transition-opacity ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/80 z-40 lg:hidden backdrop-blur-sm"></div>

    <!-- ==================== SIDEBAR ==================== -->
    <aside class="fixed inset-y-0 left-0 z-50 w-80 glass-strong transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:h-screen lg:flex-shrink-0 flex flex-col"
           :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}">
        
        <!-- Sidebar Header (Desktop) -->
        <div class="p-4 border-b border-white/10 hidden lg:block">
            <div class="flex items-center justify-between">
                <div class="sidebar-text">
                    <h2 class="text-xl font-bold text-white tracking-tight">⚙️ Kontrol Paneli</h2>
                    <p class="text-xs text-slate-400 mt-1">Algoritma & Parametreler</p>
                </div>
                <!-- Desktop Collapse Button (Optional, removed for cleaner UX or can be kept) -->
            </div>
        </div>

        <!-- Mobile Sidebar Close Button -->
        <div class="p-4 border-b border-white/10 flex items-center justify-between lg:hidden">
            <span class="text-white font-bold">Ayarlar</span>
            <button @click="sidebarOpen = false" class="text-slate-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <!-- Scrollable Content -->
        <div class="flex-1 overflow-y-auto p-4 space-y-4 sidebar-text">
            
            <!-- Mode Seçimi -->
            <div class="glass rounded-xl p-4 card-hover">
                <h3 class="text-sm font-semibold text-white mb-3 flex items-center uppercase tracking-wider">
                    <span class="w-6 h-6 rounded-lg bg-electric-blue/20 flex items-center justify-center mr-2 text-xs">🎮</span>
                    Çalışma Modu
                </h3>
                <div class="space-y-2">
                    <button wire:click="$set('versusMode', false)" type="button"
                            class="w-full flex items-center p-3 rounded-lg cursor-pointer transition-all {{ !$versusMode ? 'bg-electric-blue/20 border border-electric-blue/50' : 'hover:bg-white/5 border border-transparent' }}">
                        <span class="w-4 h-4 rounded-full border-2 mr-3 flex items-center justify-center {{ !$versusMode ? 'border-electric-blue' : 'border-slate-500' }}">
                            @if(!$versusMode)
                                <span class="w-2 h-2 rounded-full bg-electric-blue"></span>
                            @endif
                        </span>
                        <span class="text-sm {{ !$versusMode ? 'text-white font-medium' : 'text-slate-400' }}">🎯 Tekli Mod</span>
                    </button>
                    <button wire:click="$set('versusMode', true)" type="button"
                            class="w-full flex items-center p-3 rounded-lg cursor-pointer transition-all {{ $versusMode ? 'bg-neon-purple/20 border border-neon-purple/50' : 'hover:bg-white/5 border border-transparent' }}">
                        <span class="w-4 h-4 rounded-full border-2 mr-3 flex items-center justify-center {{ $versusMode ? 'border-neon-purple' : 'border-slate-500' }}">
                            @if($versusMode)
                                <span class="w-2 h-2 rounded-full bg-neon-purple"></span>
                            @endif
                        </span>
                        <span class="text-sm {{ $versusMode ? 'text-white font-medium' : 'text-slate-400' }}">⚔️ Versus Mod</span>
                    </button>
                </div>
            </div>

            <!-- Algoritma Seçimi -->
            <div class="glass rounded-xl p-4 card-hover">
                <h3 class="text-sm font-semibold text-white mb-3 flex items-center uppercase tracking-wider">
                    <span class="w-6 h-6 rounded-lg bg-cyan-accent/20 flex items-center justify-center mr-2 text-xs">🧬</span>
                    Algoritma
                </h3>
                
                @if(!$versusMode)
                    <!-- Tekli mod - Güzel kartlarla seçim -->
                    <div class="space-y-2">
                        @foreach($this->algorithms as $key => $alg)
                            @php
                                $isSelected = $selectedAlgorithm === $key;
                            @endphp
                            <button wire:click="$set('selectedAlgorithm', '{{ $key }}')" type="button"
                                    class="w-full flex items-center p-3 rounded-lg cursor-pointer transition-all border {{ $isSelected ? 'bg-white/10 border-white/30' : 'border-transparent hover:bg-white/5' }}">
                                <span class="w-3 h-3 rounded-full mr-3" style="background-color: {{ $alg['color'] ?? '#fff' }}"></span>
                                <span class="text-sm {{ $isSelected ? 'text-white font-medium' : 'text-slate-400' }}">
                                    {{ $alg['name'] ?? strtoupper($key) }}
                                </span>
                            </button>
                        @endforeach
                    </div>
                @else
                    <!-- Versus mod - Çoklu seçim -->
                    <div class="space-y-2">
                        <p class="text-xs text-slate-500 mb-2">En az 2 algoritma seçin:</p>
                        @foreach($this->algorithms as $key => $alg)
                            @php
                                $isInVersus = in_array($key, $versusAlgorithms);
                            @endphp
                            <button wire:click="toggleVersusAlgorithm('{{ $key }}')" type="button"
                                    class="w-full flex items-center p-3 rounded-lg cursor-pointer transition-all border {{ $isInVersus ? 'bg-white/10 border-white/30' : 'border-transparent hover:bg-white/5' }}">
                                <span class="w-5 h-5 rounded border-2 mr-3 flex items-center justify-center text-xs {{ $isInVersus ? 'bg-neon-green/30 border-neon-green text-neon-green' : 'border-slate-500' }}">
                                    @if($isInVersus) ✓ @endif
                                </span>
                                <span class="w-3 h-3 rounded-full mr-2" style="background-color: {{ $alg['color'] ?? '#fff' }}"></span>
                                <span class="text-sm {{ $isInVersus ? 'text-white font-medium' : 'text-slate-400' }}">
                                    {{ $alg['name'] ?? strtoupper($key) }}
                                </span>
                            </button>
                        @endforeach
                        
                        <!-- Same Seed Toggle -->
                        <div class="mt-4 pt-3 border-t border-white/10">
                            <button wire:click="$toggle('useSameSeed')" type="button" class="w-full flex items-center justify-between">
                                <span class="text-xs text-slate-400">🎲 Aynı Seed Kullan</span>
                                <div class="relative">
                                    <div class="w-10 h-5 {{ $useSameSeed ? 'bg-neon-green' : 'bg-slate-700' }} rounded-full transition-colors"></div>
                                    <div class="absolute top-0.5 w-4 h-4 bg-white rounded-full transition-transform {{ $useSameSeed ? 'left-5' : 'left-0.5' }}"></div>
                                </div>
                            </button>
                            @if($useSameSeed && $versusSeed)
                                <p class="text-xs text-neon-green mt-2">Seed: {{ $versusSeed }}</p>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <!-- Parametreler -->
            <div class="glass rounded-xl p-4 card-hover">
                <h3 class="text-sm font-semibold text-white mb-3 flex items-center uppercase tracking-wider">
                    <span class="w-6 h-6 rounded-lg bg-neon-green/20 flex items-center justify-center mr-2 text-xs">📊</span>
                    Parametreler
                </h3>
                
                <!-- Örnek Preset Butonları -->
                <div class="flex flex-wrap gap-1 mb-3">
                    <button wire:click="$set('populationSize', 30); $set('maxIterations', 100)" type="button"
                            class="text-xs px-2 py-1 rounded bg-electric-blue/20 text-electric-blue hover:bg-electric-blue/30 transition">
                        Hızlı
                    </button>
                    <button wire:click="$set('populationSize', 50); $set('maxIterations', 200)" type="button"
                            class="text-xs px-2 py-1 rounded bg-neon-green/20 text-neon-green hover:bg-neon-green/30 transition">
                        Normal
                    </button>
                    <button wire:click="$set('populationSize', 100); $set('maxIterations', 500)" type="button"
                            class="text-xs px-2 py-1 rounded bg-neon-orange/20 text-neon-orange hover:bg-neon-orange/30 transition">
                        Detaylı
                    </button>
                </div>
                
                <div class="space-y-3">
                    <div>
                        <label class="text-xs text-slate-500 mb-1 block">Popülasyon Boyutu <span class="text-slate-600">(örn: 30)</span></label>
                        <input type="number" wire:model.live="populationSize" min="10" max="100"
                               class="w-full bg-slate-800/50 text-white rounded-lg px-3 py-2.5 border border-white/10 
                                      focus:border-electric-blue focus:ring-1 focus:ring-electric-blue/50 transition text-sm"
                               placeholder="30">
                    </div>
                    <div>
                        <label class="text-xs text-slate-500 mb-1 block">Maksimum İterasyon <span class="text-slate-600">(örn: 100)</span></label>
                        <input type="number" wire:model.live="maxIterations" min="10" max="500"
                               class="w-full bg-slate-800/50 text-white rounded-lg px-3 py-2.5 border border-white/10 
                                      focus:border-electric-blue focus:ring-1 focus:ring-electric-blue/50 transition text-sm"
                               placeholder="100">
                    </div>
                    <div>
                        <label class="text-xs text-slate-500 mb-1 block">Boyut (Dim) <span class="text-slate-600">(2D için: 2)</span></label>
                        <input type="number" wire:model.live="dimension" min="2" max="50"
                               class="w-full bg-slate-800/50 text-white rounded-lg px-3 py-2.5 border border-white/10 
                                      focus:border-electric-blue focus:ring-1 focus:ring-electric-blue/50 transition text-sm"
                               placeholder="2">
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="text-xs text-slate-500 mb-1 block">Alt Sınır <span class="text-slate-600">(-10)</span></label>
                            <input type="number" wire:model.live="lowerBound" step="0.1"
                                   class="w-full bg-slate-800/50 text-white rounded-lg px-3 py-2.5 border border-white/10 
                                          focus:border-electric-blue focus:ring-1 focus:ring-electric-blue/50 transition text-sm"
                                   placeholder="-10">
                        </div>
                        <div>
                            <label class="text-xs text-slate-500 mb-1 block">Üst Sınır <span class="text-slate-600">(10)</span></label>
                            <input type="number" wire:model.live="upperBound" step="0.1"
                                   class="w-full bg-slate-800/50 text-white rounded-lg px-3 py-2.5 border border-white/10 
                                          focus:border-electric-blue focus:ring-1 focus:ring-electric-blue/50 transition text-sm"
                                   placeholder="10">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Amaç Fonksiyonu -->
            <div class="glass rounded-xl p-4 card-hover">
                <h3 class="text-sm font-semibold text-white mb-3 flex items-center uppercase tracking-wider">
                    <span class="w-6 h-6 rounded-lg bg-neon-orange/20 flex items-center justify-center mr-2 text-xs">📐</span>
                    Amaç Fonksiyonu
                </h3>
                
                <!-- Hazır Fonksiyonlar -->
                <div class="mb-3">
                    <select wire:model.live="objectiveFunction" 
                            class="w-full bg-slate-800/50 text-white rounded-lg px-3 py-2.5 border border-white/10 
                                   focus:border-electric-blue focus:ring-1 focus:ring-electric-blue/50 transition text-sm"
                            {{ $useCustomFunction ? 'disabled' : '' }}>
                        @foreach($this->objectiveFunctions as $key => $fn)
                            <option value="{{ $key }}">{{ $fn['name'] }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Custom Toggle -->
                <button wire:click="$toggle('useCustomFunction')" type="button" class="w-full flex items-center justify-between mb-3">
                    <span class="text-xs text-slate-400">✨ Özel Fonksiyon</span>
                    <div class="relative">
                        <div class="w-10 h-5 {{ $useCustomFunction ? 'bg-electric-blue' : 'bg-slate-700' }} rounded-full transition-colors"></div>
                        <div class="absolute top-0.5 w-4 h-4 bg-white rounded-full transition-transform {{ $useCustomFunction ? 'left-5' : 'left-0.5' }}"></div>
                    </div>
                </button>

                @if($useCustomFunction)
                    <div class="space-y-2">
                        <textarea wire:model.live.debounce.500ms="customExpression" rows="2"
                                  class="w-full bg-slate-800/50 text-white rounded-lg px-3 py-2 border text-sm font-mono
                                         {{ $expressionValid ? 'border-neon-green/50' : ($expressionErrors ? 'border-red-500/50' : 'border-white/10') }}"
                                  placeholder="x[0]^2 + x[1]^2"></textarea>
                        
                        @if($expressionValid)
                            <p class="text-xs text-neon-green flex items-center">✓ Geçerli ifade</p>
                        @endif
                        @foreach($expressionErrors as $error)
                            <p class="text-xs text-red-400">{{ $error }}</p>
                        @endforeach

                        <!-- Örnekler -->
                        <div class="flex flex-wrap gap-1 mt-2">
                            @foreach($this->expressionExamples as $ex)
                                <button wire:click="selectExample('{{ $ex }}')" type="button"
                                        class="text-xs px-2 py-1 rounded bg-white/5 text-slate-400 hover:bg-white/10 hover:text-white transition">
                                    {{ $ex }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- PSO Parametreleri -->
            @if($selectedAlgorithm === 'pso' && !$versusMode)
                <div class="glass rounded-xl p-4 card-hover">
                    <h3 class="text-sm font-semibold text-white mb-3 flex items-center uppercase tracking-wider">
                        <span class="w-6 h-6 rounded-lg bg-neon-orange/20 flex items-center justify-center mr-2 text-xs">🔵</span>
                        PSO Parametreleri
                    </h3>
                    <div class="space-y-3">
                        <div>
                            <label class="text-xs text-slate-500 mb-1 block">Atalet (w): {{ $psoInertia }}</label>
                            <input type="range" wire:model.live="psoInertia" min="0.1" max="1" step="0.1"
                                   class="w-full accent-neon-orange">
                        </div>
                        <div>
                            <label class="text-xs text-slate-500 mb-1 block">Bilişsel (c1): {{ $psoCognitive }}</label>
                            <input type="range" wire:model.live="psoCognitive" min="0.5" max="3" step="0.1"
                                   class="w-full accent-neon-orange">
                        </div>
                        <div>
                            <label class="text-xs text-slate-500 mb-1 block">Sosyal (c2): {{ $psoSocial }}</label>
                            <input type="range" wire:model.live="psoSocial" min="0.5" max="3" step="0.1"
                                   class="w-full accent-neon-orange">
                        </div>
                    </div>
                </div>
            @endif

            <!-- GA Parametreleri -->
            @if($selectedAlgorithm === 'ga' && !$versusMode)
                <div class="glass rounded-xl p-4 card-hover">
                    <h3 class="text-sm font-semibold text-white mb-3 flex items-center uppercase tracking-wider">
                        <span class="w-6 h-6 rounded-lg bg-neon-green/20 flex items-center justify-center mr-2 text-xs">🧬</span>
                        GA Parametreleri
                    </h3>
                    <div class="space-y-3">
                        <div>
                            <label class="text-xs text-slate-500 mb-1 block">Çaprazlama Oranı: {{ $gaCrossoverRate }}</label>
                            <input type="range" wire:model.live="gaCrossoverRate" min="0.5" max="1" step="0.05"
                                   class="w-full accent-neon-green">
                        </div>
                        <div>
                            <label class="text-xs text-slate-500 mb-1 block">Mutasyon Oranı: {{ $gaMutationRate }}</label>
                            <input type="range" wire:model.live="gaMutationRate" min="0.01" max="0.3" step="0.01"
                                   class="w-full accent-neon-green">
                        </div>
                        <div>
                            <label class="text-xs text-slate-500 mb-1 block">Turnuva Boyutu: {{ $gaTournamentSize }}</label>
                            <input type="range" wire:model.live="gaTournamentSize" min="2" max="5" step="1"
                                   class="w-full accent-neon-green">
                        </div>
                    </div>
                </div>
            @endif

        </div>
        
        <!-- Sidebar Footer - Butonlar -->
        <div class="p-4 border-t border-white/10 space-y-2 sidebar-text">
            @if(!$versusMode)
                <button wire:click="startOptimization" wire:loading.attr="disabled" type="button"
                        class="w-full py-3 rounded-xl font-semibold text-white transition-all btn-glow
                               {{ $isRunning ? 'bg-slate-600 cursor-not-allowed' : 'bg-gradient-to-r from-electric-blue to-cyan-accent' }}">
                    <span wire:loading.remove wire:target="startOptimization">🚀 Optimizasyonu Başlat</span>
                    <span wire:loading wire:target="startOptimization" class="flex items-center justify-center">
                        <span class="spinner mr-2"></span> Çalışıyor...
                    </span>
                </button>
            @else
                <button wire:click="startVersus" wire:loading.attr="disabled" type="button"
                        class="w-full py-3 rounded-xl font-semibold text-white transition-all btn-glow
                               {{ $isRunning ? 'bg-slate-600 cursor-not-allowed' : 'bg-gradient-to-r from-neon-purple to-pink-500' }}">
                    <span wire:loading.remove wire:target="startVersus">⚔️ Versus Başlat</span>
                    <span wire:loading wire:target="startVersus" class="flex items-center justify-center">
                        <span class="spinner mr-2"></span> Karşılaştırılıyor...
                    </span>
                </button>
            @endif
            
            <button wire:click="resetDashboard" type="button"
                    class="w-full py-2.5 rounded-xl font-medium text-slate-400 bg-white/5 hover:bg-white/10 transition">
                🔄 Sıfırla
            </button>
        </div>
    </aside>

    <!-- ==================== ANA İÇERİK ==================== -->
    <main class="flex-1 flex flex-col min-w-0 min-h-screen">
        
        <!-- Header -->
        <header class="glass-strong px-6 py-4 hidden lg:flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-white tracking-tight flex items-center">
                    🐋 <span class="ml-2 bg-gradient-to-r from-electric-blue to-cyan-accent bg-clip-text text-transparent">
                        Optimizasyon Algoritmaları Dashboard
                    </span>
                </h1>
                <p class="text-sm text-slate-400 mt-1">WOA • PSO • GWO • GA — Gerçek Zamanlı Karşılaştırmalı Analiz</p>
            </div>
            <div class="text-right">
                <p class="text-xs text-slate-500">Tokat Gaziosmanpaşa Üniversitesi</p>
                <p class="text-xs text-slate-600">Meta-Sezgisel Optimizasyon</p>
            </div>
        </header>

        <!-- Stats Cards -->
        <div class="p-6 grid grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- İterasyon -->
            <div class="glass rounded-xl p-4 card-hover">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs text-slate-500 uppercase tracking-wider">İterasyon</span>
                    <span class="text-lg">🔄</span>
                </div>
                <p class="stat-number text-white">{{ $currentIteration }}<span class="text-slate-500 text-lg">/{{ $maxIterations }}</span></p>
            </div>
            
            <!-- En İyi Fitness -->
            <div class="glass rounded-xl p-4 card-hover box-glow-cyan">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs text-slate-500 uppercase tracking-wider">En İyi Fitness</span>
                    <span class="text-lg">⭐</span>
                </div>
                <p class="stat-number text-cyan-accent neon-cyan">
                    @if($currentBestFitness == 0 && $currentIteration == 0)
                        —
                    @elseif($currentBestFitness < 0.000001 && $currentBestFitness > 0)
                        {{ sprintf('%.2e', $currentBestFitness) }}
                    @elseif($currentBestFitness == 0)
                        0 (Optimal!)
                    @else
                        {{ number_format($currentBestFitness, 6) }}
                    @endif
                </p>
            </div>

            
            <!-- Popülasyon -->
            <div class="glass rounded-xl p-4 card-hover">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs text-slate-500 uppercase tracking-wider">Popülasyon</span>
                    <span class="text-lg">👥</span>
                </div>
                <p class="stat-number text-white">{{ $populationSize }}</p>
            </div>
            
            <!-- Durum -->
            <div class="glass rounded-xl p-4 card-hover {{ $isRunning ? 'box-glow-green animate-pulse' : '' }}">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs text-slate-500 uppercase tracking-wider">Durum</span>
                    @if($isRunning)
                        <span class="relative flex h-4 w-4">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-neon-green opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-4 w-4 bg-neon-green"></span>
                        </span>
                    @elseif(count($results) > 0 || count($versusResults) > 0)
                        <span class="h-4 w-4 rounded-full bg-electric-blue"></span>
                    @else
                        <span class="h-4 w-4 rounded-full bg-slate-600"></span>
                    @endif
                </div>
                <div wire:loading wire:target="startOptimization, startVersus" class="flex items-center">
                    <div class="spinner mr-2" style="width: 20px; height: 20px;"></div>
                    <span class="text-neon-green font-bold animate-pulse">İşleniyor...</span>
                </div>
                <div wire:loading.remove wire:target="startOptimization, startVersus">
                    @if($isRunning)
                        <p class="stat-number text-neon-green text-lg font-bold">🔄 Çalışıyor</p>
                    @elseif(count($results) > 0 || count($versusResults) > 0)
                        <p class="stat-number text-electric-blue text-lg font-bold">✅ Tamamlandı</p>
                    @else
                        <p class="stat-number text-slate-500 text-lg">⏳ Bekliyor</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Charts Grid -->
        <div class="flex-1 p-6 pt-0 grid grid-cols-1 lg:grid-cols-2 gap-4">
            
            <!-- Convergence Chart -->
            <div class="glass rounded-xl p-5 card-hover">
                <h3 class="text-sm font-semibold text-white mb-4 flex items-center uppercase tracking-wider">
                    📈 Yakınsama Eğrisi
                </h3>
                <div class="chart-container" wire:ignore>
                    <canvas id="convergenceChart"></canvas>
                </div>
            </div>
            
            <!-- Scatter Chart -->
            <div class="glass rounded-xl p-5 card-hover">
                <h3 class="text-sm font-semibold text-white mb-4 flex items-center uppercase tracking-wider">
                    🎯 Arama Uzayı (2D)
                </h3>
                <div class="chart-container" wire:ignore>
                    <canvas id="scatterChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Versus Results Table -->
        @if($versusMode && count($versusResults) > 0)
            <div class="px-6 pb-6">
                <div class="glass rounded-xl p-5 card-hover">
                    <h3 class="text-sm font-semibold text-white mb-4 flex items-center uppercase tracking-wider">
                        ⚔️ Versus Sonuçları
                        @if($winner && $winner !== 'tie')
                            <span class="ml-3 px-3 py-1 rounded-full text-xs font-bold bg-neon-green/20 text-neon-green">
                                🏆 Kazanan: {{ strtoupper($winner) }}
                            </span>
                        @elseif($winner === 'tie')
                            <span class="ml-3 px-3 py-1 rounded-full text-xs font-bold bg-yellow-500/20 text-yellow-400">
                                🤝 Berabere
                            </span>
                        @endif
                    </h3>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-white/10">
                                    <th class="text-left py-3 px-4 text-slate-400 font-medium">Algoritma</th>
                                    <th class="text-right py-3 px-4 text-slate-400 font-medium">En İyi Fitness</th>
                                    <th class="text-right py-3 px-4 text-slate-400 font-medium">Süre (ms)</th>
                                    <th class="text-center py-3 px-4 text-slate-400 font-medium">Sonuç</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($versusResults as $key => $result)
                                    <tr class="border-b border-white/5 {{ $winner === $key ? 'bg-neon-green/5' : '' }}">
                                        <td class="py-3 px-4">
                                            <div class="flex items-center">
                                                <span class="w-3 h-3 rounded-full mr-3" style="background-color: {{ $result['color'] ?? '#fff' }}"></span>
                                                <span class="text-white font-medium">{{ $result['name'] }}</span>
                                            </div>
                                        </td>
                                        <td class="text-right py-3 px-4 font-mono {{ $winner === $key ? 'text-neon-green font-bold' : 'text-white' }}">
                                            {{ number_format($result['bestFitness'], 8) }}
                                        </td>
                                        <td class="text-right py-3 px-4 text-slate-400">
                                            {{ $result['executionTime'] }} ms
                                        </td>
                                        <td class="text-center py-3 px-4">
                                            @if($winner === $key)
                                                <span class="text-2xl">🏆</span>
                                            @elseif($winner === 'tie')
                                                <span class="text-2xl">🤝</span>
                                            @else
                                                <span class="text-slate-500">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        <!-- Single Mode Results -->
        @if(!$versusMode && count($results) > 0)
            <div class="px-6 pb-6">
                <div class="glass rounded-xl p-5 card-hover">
                    <h3 class="text-sm font-semibold text-white mb-4 flex items-center uppercase tracking-wider">
                        📋 Optimizasyon Sonuçları
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-white/5 rounded-lg p-3">
                            <p class="text-xs text-slate-500 mb-1">Algoritma</p>
                            <p class="text-white font-semibold">{{ $results['algorithm'] ?? 'N/A' }}</p>
                        </div>
                        <div class="bg-white/5 rounded-lg p-3">
                            <p class="text-xs text-slate-500 mb-1">En İyi Fitness</p>
                            <p class="text-cyan-accent font-mono font-bold">
                                @php
                                    $val = $results['bestFitness'] ?? 0;
                                @endphp
                                @if($val == 0)
                                    0 (Optimal!)
                                @elseif($val < 0.00000001 && $val > 0)
                                    {{ sprintf('%.2e', $val) }}
                                @else
                                    {{ number_format($val, 8) }}
                                @endif
                            </p>
                        </div>
                        <div class="bg-white/5 rounded-lg p-3">
                            <p class="text-xs text-slate-500 mb-1">Best Position</p>
                            <p class="text-white font-mono text-xs">
                                @if(isset($results['bestPosition']))
                                    [
                                    @foreach(array_slice($results['bestPosition'], 0, 3) as $pos)
                                        @if(abs($pos) < 0.0001 && $pos != 0)
                                            {{ sprintf('%.2e', $pos) }}
                                        @else
                                            {{ number_format($pos, 4) }}
                                        @endif
                                        {{ !$loop->last ? ', ' : '' }}
                                    @endforeach
                                    {{ count($results['bestPosition']) > 3 ? '...' : '' }}
                                    ]
                                @else
                                    N/A
                                @endif
                            </p>
                        </div>
                        <div class="bg-white/5 rounded-lg p-3">
                            <p class="text-xs text-slate-500 mb-1">Amaç Fonksiyonu</p>
                            <p class="text-white font-semibold">{{ ucfirst($results['objectiveFunction'] ?? 'N/A') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Export & Code Section -->
        <div class="px-6 pb-6">
            <div class="glass rounded-xl overflow-hidden">
                <!-- Tabs -->
                <div class="flex border-b border-white/10">
                    <button wire:click="setCodeLanguage('python')" type="button"
                            class="flex-1 py-3 text-sm font-medium transition-all {{ $codeLanguage === 'python' ? 'bg-white/10 text-white border-b-2 border-electric-blue' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                        🐍 Python Kodu
                    </button>
                    <button wire:click="setCodeLanguage('matlab')" type="button"
                            class="flex-1 py-3 text-sm font-medium transition-all {{ $codeLanguage === 'matlab' ? 'bg-white/10 text-white border-b-2 border-neon-orange' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                        📊 MATLAB Kodu
                    </button>
                </div>
                
                <!-- Code Block -->
                <div class="p-4 relative">
                    <pre class="language-{{ $codeLanguage }} rounded-lg text-xs overflow-x-auto max-h-64"><code id="codeBlock">{{ $generatedCode }}</code></pre>
                    <button onclick="copyCode()" id="copyBtn"
                            class="absolute top-6 right-6 px-3 py-1.5 rounded-lg text-xs font-medium bg-white/10 text-slate-400 hover:bg-white/20 hover:text-white transition">
                        📋 Kopyala
                    </button>
                </div>
                
                <!-- Export Buttons -->
                <div class="p-4 pt-0 flex flex-wrap gap-2">
                    <button wire:click="downloadCsv" type="button"
                            class="px-4 py-2 rounded-lg text-xs font-medium bg-neon-green/20 text-neon-green hover:bg-neon-green/30 transition"
                            {{ count($convergenceHistory) === 0 ? 'disabled' : '' }}>
                        📄 CSV İndir
                    </button>
                    <button wire:click="downloadPdf" type="button"
                            class="px-4 py-2 rounded-lg text-xs font-medium bg-red-500/20 text-red-400 hover:bg-red-500/30 transition"
                            {{ count($convergenceHistory) === 0 && count($versusResults) === 0 ? 'disabled' : '' }}>
                        📁 PDF Rapor
                    </button>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="glass-strong px-6 py-4 text-center">
            <p class="text-xs text-slate-500">
                © {{ date('Y') }} Tokat Gaziosmanpaşa Üniversitesi • 
                WOA, PSO, GWO & GA Meta-Sezgisel Optimizasyon Algoritmaları
            </p>
        </footer>
    </main>
</div>
