@extends('layouts.admin')
@section('title', isset($project) ? 'Proje Düzenle' : 'Yeni Proje Ekle')
@section('content')
<h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">{{ isset($project) ? 'Proje Düzenle' : 'Yeni Proje Ekle' }}</h1>

<!-- GitHub Import Section -->
@if(!isset($project))
<div class="card mb-6" x-data="{ showGithub: false, loading: false, repos: [], selectedRepos: [], githubUsername: '', savedUsers: @js($githubUsers ?? []) }">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">GitHub'dan Proje İçe Aktar</h2>
        <button 
            type="button" 
            @click="showGithub = !showGithub"
            class="text-primary-600 dark:text-primary-400 hover:underline text-sm">
            <span x-text="showGithub ? 'Gizle' : 'Göster'"></span>
        </button>
    </div>
    
    <div x-show="showGithub" x-transition>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">GitHub Kullanıcı Adı</label>
            <div class="flex gap-2">
                <div class="flex-1 flex gap-2">
                    <select 
                        x-model="githubUsername" 
                        class="input-field flex-1"
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
                        class="input-field flex-1">
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
                    class="btn-primary whitespace-nowrap">
                    <span x-show="!loading">Projeleri Getir</span>
                    <span x-show="loading">Yükleniyor...</span>
                </button>
            </div>
        </div>

        <!-- Repositories List -->
        <div x-show="repos.length > 0" class="mt-4">
            <div class="flex justify-between items-center mb-3">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Projeler (<span x-text="repos.length"></span>)
                    <span x-show="selectedRepos.length > 0" class="text-sm text-primary-600 dark:text-primary-400">
                        - <span x-text="selectedRepos.length"></span> seçili
                    </span>
                </h3>
                <div class="flex gap-2">
                    <button 
                        type="button"
                        @click="selectedRepos = repos.map(r => r.full_name)"
                        class="text-sm text-primary-600 dark:text-primary-400 hover:underline">
                        Tümünü Seç
                    </button>
                    <button 
                        type="button"
                        @click="selectedRepos = []"
                        class="text-sm text-gray-600 dark:text-gray-400 hover:underline">
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
                        class="btn-primary text-sm px-4 py-1">
                        Seçilenleri İçe Aktar
                    </button>
                </div>
            </div>
            <div class="space-y-2 max-h-96 overflow-y-auto">
                <template x-for="repo in repos" :key="repo.id">
                    <label 
                        class="block p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition"
                        :class="{ 'bg-primary-50 dark:bg-primary-900 border-primary-500': selectedRepos.includes(repo.full_name) }">
                        <div class="flex items-start gap-3">
                            <input 
                                type="checkbox" 
                                :value="repo.full_name"
                                x-model="selectedRepos"
                                class="mt-1">
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900 dark:text-white" x-text="repo.name"></h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1" x-text="repo.description || 'Açıklama yok'"></p>
                                <div class="flex gap-3 mt-2 text-xs text-gray-500 dark:text-gray-400">
                                    <span x-show="repo.language">
                                        <span class="font-semibold">Dil:</span> <span x-text="repo.language"></span>
                                    </span>
                                    <span>⭐ <span x-text="repo.stargazers_count"></span></span>
                                    <span>🔱 <span x-text="repo.forks_count"></span></span>
                                </div>
                                <div x-show="repo.topics?.length > 0" class="flex flex-wrap gap-1 mt-2">
                                    <template x-for="topic in repo.topics">
                                        <span class="px-2 py-0.5 bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 text-xs rounded" x-text="topic"></span>
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
<div class="card">
    <form action="{{ isset($project) ? route('admin.projects.update', $project) : route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($project)) @method('PUT') @endif
        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Başlık *</label>
                <input type="text" name="title" value="{{ old('title', $project->title ?? '') }}" required class="input-field">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Teknolojiler (virgülle ayırın) *</label>
                <input type="text" name="technologies" value="{{ old('technologies', isset($project) ? implode(', ', $project->technologies) : '') }}" required class="input-field">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Açıklama *</label>
                <textarea name="description" rows="4" required class="input-field">{{ old('description', $project->description ?? '') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Proje Görseli</label>
                <input type="file" name="image" accept="image/*" class="input-field">
                @if(isset($project) && $project->image)
                <img src="{{ asset('storage/' . $project->image) }}" class="w-32 h-32 object-cover rounded-lg mt-2">
                @endif
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Demo URL</label>
                <input type="url" name="demo_url" value="{{ old('demo_url', $project->demo_url ?? '') }}" class="input-field">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">GitHub URL</label>
                <input type="url" name="github_url" value="{{ old('github_url', $project->github_url ?? '') }}" class="input-field">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sıra</label>
                <input type="number" name="order" value="{{ old('order', $project->order ?? 0) }}" class="input-field">
            </div>
            <div class="flex items-center">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $project->is_featured ?? false) ? 'checked' : '' }} class="mr-2">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Öne Çıkan</label>
            </div>
        </div>
        <div class="mt-6 flex gap-4">
            <button type="submit" class="btn-primary">{{ isset($project) ? 'Güncelle' : 'Kaydet' }}</button>
            <a href="{{ route('admin.projects.index') }}" class="btn-secondary">İptal</a>
        </div>
    </form>
</div>
@endsection
