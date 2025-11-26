@extends('layouts.admin')
@section('title', 'Yetenekler')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Yetenekler</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Teknik yeteneklerinizi ve uzmanlık seviyelerinizi yönetin.</p>
    </div>
    <a href="{{ route('admin.skills.create') }}" class="flex items-center gap-2 px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white rounded-xl font-medium transition-all shadow-lg shadow-sky-600/30">
        <i class="fas fa-plus"></i>
        <span>Yeni Yetenek Ekle</span>
    </a>
</div>

<div class="grid md:grid-cols-2 gap-6">
    @forelse($skills->groupBy('category') as $category => $categorySkills)
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden h-full">
        <div class="p-4 bg-gray-50 dark:bg-gray-700/30 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-800 dark:text-white flex items-center gap-2">
                <i class="fas fa-layer-group text-sky-500"></i>
                {{ $category }}
            </h3>
            <span class="text-xs font-medium bg-white dark:bg-gray-700 px-2 py-1 rounded-lg text-gray-500 dark:text-gray-400 border border-gray-100 dark:border-gray-600">
                {{ $categorySkills->count() }} Yetenek
            </span>
        </div>
        <div class="divide-y divide-gray-100 dark:divide-gray-700">
            @foreach($categorySkills as $skill)
            <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group flex items-center justify-between">
                <div class="flex-1">
                    <div class="flex justify-between items-center mb-1">
                        <span class="font-medium text-gray-700 dark:text-gray-200">{{ $skill->name }}</span>
                        <span class="text-xs font-bold text-sky-600 dark:text-sky-400 bg-sky-50 dark:bg-sky-900/30 px-2 py-0.5 rounded-full">{{ $skill->proficiency }}%</span>
                    </div>
                    <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-1.5">
                        <div class="bg-sky-500 h-1.5 rounded-full" style="width: {{ $skill->proficiency }}%"></div>
                    </div>
                </div>
                <div class="flex items-center gap-1 ml-4 opacity-0 group-hover:opacity-100 transition-opacity">
                    <a href="{{ route('admin.skills.edit', $skill) }}" class="p-1.5 text-sky-600 hover:bg-sky-50 dark:hover:bg-sky-900/30 rounded-lg transition-colors" title="Düzenle">
                        <i class="fas fa-edit text-sm"></i>
                    </a>
                    <form action="{{ route('admin.skills.destroy', $skill) }}" method="POST" onsubmit="return confirm('Silmek istediğinize emin misiniz?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-1.5 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors" title="Sil">
                            <i class="fas fa-trash-alt text-sm"></i>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @empty
    <div class="col-span-full p-12 text-center bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700">
        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-400">
            <i class="fas fa-bolt text-2xl"></i>
        </div>
        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Henüz yetenek yok</h3>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Yeni bir yetenek ekleyerek başlayın.</p>
    </div>
    @endforelse
</div>
@endsection
