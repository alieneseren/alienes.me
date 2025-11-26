@extends('layouts.admin')
@section('title', isset($project) ? 'Proje Düzenle' : 'Yeni Proje Ekle')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">{{ isset($project) ? 'Proje Düzenle' : 'Yeni Proje Ekle' }}</h1>
    <p class="text-gray-500 dark:text-gray-400 mt-1">Portfolyonuza yeni bir proje ekleyin veya mevcut projeyi düzenleyin.</p>
</div>

<!-- GitHub Import Section -->
@if(!isset($project))
<div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 mb-6" x-data="{ showGithub: false, loading: false, repos: [], selectedRepos: [], githubUsername: '', savedUsers: @js($githubUsers ?? []) }">
    <div class="flex justify-between items-center mb-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gray-900 flex items-center justify-center text-white">
                <i class="fab fa-github text-xl"></i>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-800 dark:text-white">GitHub'dan Proje İçe Aktar</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400">GitHub repolarınızı otomatik olarak çekin.</p>
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
        <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700/30 rounded-xl border border-gray-100 dark:border-gray-700">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">GitHub Kullanıcı Adı</label>
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1 flex gap-2">
                    <select 
                        x-model="githubUsername" 
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all"
                        @change="if (githubUsername) { 
                            const btn = $el.parentElement.parentElement.querySelector('button'); 
                            btn.click(); 
                        }">
                        <option value="">Yeni kullanıcı ekle...</option>
                        <template x-for="user in savedUsers" :key="user.id">
                            <option :value="user.username">
                                <span x-text="user.name || user.username"></span>
                                <span x-show="user.public_repos" x-text="' (' + user.public_repos + ' repo)'"></span>
                            </option>
                        </template>
                    </select>
                    <input 
                        type="text" 
                        x-model="githubUsername" 
                        placeholder="veya kullanıcı adı yazın"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all">
                </div>
                <button 
                    type="button"
                    @click="
                        loading = true;
                        fetch('{{ route('admin.projects.github.repos') }}?username=' + (githubUsername || ''))
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    repos = data.repos;
                                    selectedRepos = [];
                                    
                                    // Update saved users list dynamically
                                    fetch('{{ route('admin.projects.github.users') }}')
                                        .then(res => res.json())
                                        .then(userData => {
                                            if (userData.success) {
                                                savedUsers = userData.users;
                                            }
                                        });
                                    
                                    if (data.message) {
                                        alert('ℹ️ ' + data.message);
                                    }
                                } else {
                                    alert('❌ ' + data.message);
                                }
                                loading = false;
                            })
                            .catch(err => {
                                alert('❌ Hata: ' + err.message);
                                loading = false;
                            });
                    "
                    :disabled="loading"
                    class="px-6 py-2 bg-gray-900 hover:bg-black text-white rounded-xl font-medium transition-all shadow-lg shadow-gray-900/30 whitespace-nowrap flex items-center gap-2 justify-center">
                    <i class="fab fa-github" x-show="!loading"></i>
                    <i class="fas fa-spinner fa-spin" x-show="loading"></i>
                    <span x-show="!loading">Projeleri Getir</span>
                    <span x-show="loading">Yükleniyor...</span>
                </button>
            </div>
        </div>

        <!-- Repositories List -->
        <div x-show="repos.length > 0" class="mt-4">
            <div class="flex justify-between items-center mb-3">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    Projeler <span class="bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded-full text-xs" x-text="repos.length"></span>
                    <span x-show="selectedRepos.length > 0" class="text-sm text-sky-600 dark:text-sky-400 font-normal">
                        - <span x-text="selectedRepos.length"></span> seçili
                    </span>
                </h3>
                <div class="flex gap-2">
                    <button 
                        type="button"
                        @click="selectedRepos = repos.map(r => r.full_name)"
                        class="text-sm text-sky-600 dark:text-sky-400 hover:underline font-medium">
                        Tümünü Seç
                    </button>
                    <button 
                        type="button"
                        @click="selectedRepos = []"
                        class="text-sm text-gray-500 dark:text-gray-400 hover:underline font-medium">
                        Seçimi Temizle
                    </button>
                    <button 
                        type="button"
                        x-show="selectedRepos.length > 0"
                        @click="
                            if (!confirm(selectedRepos.length + ' projeyi içe aktarmak istediğinize emin misiniz?')) return;
                            loading = true;
                            fetch('{{ route('admin.projects.github.import') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({ repos: selectedRepos })
                            })
                            .then(res => res.json())
                            .then(data => {
                                alert(data.message);
                                if (data.success) {
                                    window.location.href = '{{ route('admin.projects.index') }}';
                                } else {
                                    if (data.errors?.length) {
                                        console.error('Errors:', data.errors);
                                    }
                                }
                                loading = false;
                            })
                            .catch(err => {
                                alert('Hata: ' + err.message);
                                loading = false;
                            });
                        "
                        class="px-4 py-1.5 bg-sky-600 hover:bg-sky-700 text-white rounded-lg text-sm font-medium transition-colors shadow-md shadow-sky-600/20">
                        Seçilenleri İçe Aktar
                    </button>
                </div>
            </div>
            <div class="space-y-2 max-h-96 overflow-y-auto pr-2 custom-scrollbar">
                <template x-for="repo in repos" :key="repo.id">
                    <label 
                        class="block p-4 border border-gray-200 dark:border-gray-700 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer transition-all duration-200"
                        :class="{ 'bg-sky-50 dark:bg-sky-900/20 border-sky-200 dark:border-sky-800 ring-1 ring-sky-500/20': selectedRepos.includes(repo.full_name) }">
                        <div class="flex items-start gap-3">
                            <div class="pt-1">
                                <input 
                                    type="checkbox" 
                                    :value="repo.full_name"
                                    x-model="selectedRepos"
                                    class="w-5 h-5 text-sky-600 rounded border-gray-300 focus:ring-sky-500">
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-800 dark:text-white" x-text="repo.name"></h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1" x-text="repo.description || 'Açıklama yok'"></p>
                                <div class="flex gap-4 mt-3 text-xs text-gray-500 dark:text-gray-400">
                                    <span x-show="repo.language" class="flex items-center gap-1">
                                        <i class="fas fa-code text-sky-500"></i> <span x-text="repo.language"></span>
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <i class="fas fa-star text-amber-400"></i> <span x-text="repo.stargazers_count"></span>
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <i class="fas fa-code-branch text-purple-400"></i> <span x-text="repo.forks_count"></span>
                                    </span>
                                </div>
                                <div x-show="repo.topics?.length > 0" class="flex flex-wrap gap-1 mt-2">
                                    <template x-for="topic in repo.topics">
                                        <span class="px-2 py-0.5 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-xs rounded-md font-medium" x-text="topic"></span>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </label>
                </template>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Project Form -->
<div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
    <form action="{{ isset($project) ? route('admin.projects.update', $project) : route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($project)) @method('PUT') @endif
        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Başlık *</label>
                <input type="text" name="title" value="{{ old('title', $project->title ?? '') }}" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Teknolojiler (virgülle ayırın) *</label>
                <input type="text" name="technologies" value="{{ old('technologies', isset($project) ? implode(', ', $project->technologies) : '') }}" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Açıklama *</label>
                <textarea name="description" rows="4" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all">{{ old('description', $project->description ?? '') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Proje Görseli</label>
                <input type="file" name="image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all">
                @if(isset($project) && $project->image)
                <img src="{{ asset('storage/' . $project->image) }}" class="w-32 h-32 object-cover rounded-lg mt-2 shadow-md">
                @endif
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Demo URL</label>
                <input type="url" name="demo_url" value="{{ old('demo_url', $project->demo_url ?? '') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">GitHub URL</label>
                <input type="url" name="github_url" value="{{ old('github_url', $project->github_url ?? '') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sıra</label>
                <input type="number" name="order" value="{{ old('order', $project->order ?? 0) }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all">
            </div>
            <div class="flex items-center">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $project->is_featured ?? false) ? 'checked' : '' }} class="w-5 h-5 text-sky-600 rounded border-gray-300 focus:ring-sky-500">
                <label class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">Öne Çıkan</label>
            </div>
        </div>
        <div class="mt-6 flex gap-4">
            <button type="submit" class="px-6 py-2.5 bg-sky-600 hover:bg-sky-700 text-white rounded-xl font-medium transition-all shadow-lg shadow-sky-600/30">{{ isset($project) ? 'Güncelle' : 'Kaydet' }}</button>
            <a href="{{ route('admin.projects.index') }}" class="px-6 py-2.5 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-xl font-medium transition-colors">İptal</a>
        </div>
    </form>
</div>
@endsection
