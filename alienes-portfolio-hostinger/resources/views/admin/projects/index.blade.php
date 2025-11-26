@extends('layouts.admin')
@section('title', 'Projeler')
@section('content')
<div class="flex justify-between items-center mb-8">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Projeler</h1>
    <a href="{{ route('admin.projects.create') }}" class="btn-primary">Yeni Proje Ekle</a>
</div>
<div class="grid md:grid-cols-2 gap-6">
    @forelse($projects as $project)
    <div class="card">
        @if($project->image)
        <img src="{{ asset('storage/' . $project->image) }}" class="w-full h-40 object-cover rounded-lg mb-4">
        @endif
        <h3 class="font-semibold text-gray-900 dark:text-white mb-2">{{ $project->title }}</h3>
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">{{ Str::limit($project->description, 100) }}</p>
        <div class="flex gap-2">
            <a href="{{ route('admin.projects.edit', $project) }}" class="text-primary-600 hover:underline">Düzenle</a>
            <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Silmek istediğinize emin misiniz?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:underline">Sil</button>
            </form>
        </div>
    </div>
    @empty
    <p class="text-gray-600 dark:text-gray-400">Henüz proje eklenmemiş.</p>
    @endforelse
</div>
@endsection
