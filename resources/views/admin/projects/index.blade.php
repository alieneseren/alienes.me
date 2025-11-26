@extends('layouts.admin')
@section('title', 'Projeler')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Projeler</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Portfolyonuzdaki projeleri yönetin.</p>
    </div>
    <a href="{{ route('admin.projects.create') }}" class="flex items-center gap-2 px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white rounded-xl font-medium transition-all shadow-lg shadow-sky-600/30">
        <i class="fas fa-plus"></i>
        <span>Yeni Proje Ekle</span>
    </a>
</div>

<div class="grid md:grid-cols-2 xl:grid-cols-3 gap-6">
    @forelse($projects as $project)
    <div class="group bg-white dark:bg-gray-800 rounded-2xl p-4 shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition-all duration-300 flex flex-col h-full">
        @if($project->image)
        <div class="relative h-48 mb-4 overflow-hidden rounded-xl">
            <img src="{{ asset('storage/' . $project->image) }}" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                <a href="{{ $project->url }}" target="_blank" class="text-white text-sm font-medium hover:underline flex items-center gap-2">
                    <i class="fas fa-external-link-alt"></i> Projeyi Görüntüle
                </a>
            </div>
        </div>
        @else
        <div class="h-48 mb-4 rounded-xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-400 dark:text-gray-500">
            <i class="fas fa-image text-4xl"></i>
        </div>
        @endif

        <div class="flex-1">
            <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-2 line-clamp-1">{{ $project->title }}</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4 line-clamp-3">{{ $project->description }}</p>
        </div>

        <div class="pt-4 mt-auto border-t border-gray-100 dark:border-gray-700 flex justify-end gap-2">
            <a href="{{ route('admin.projects.edit', $project) }}" class="p-2 text-sky-600 hover:bg-sky-50 dark:hover:bg-sky-900/30 rounded-lg transition-colors" title="Düzenle">
                <i class="fas fa-edit"></i>
            </a>
            <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Silmek istediğinize emin misiniz?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="p-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors" title="Sil">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </form>
        </div>
    </div>
    @empty
    <div class="col-span-full py-12 text-center">
        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-400">
            <i class="fas fa-folder-open text-2xl"></i>
        </div>
        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Henüz proje yok</h3>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Yeni bir proje ekleyerek başlayın.</p>
    </div>
    @endforelse
</div>
@endsection
