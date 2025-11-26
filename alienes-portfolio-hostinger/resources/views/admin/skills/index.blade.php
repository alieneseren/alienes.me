@extends('layouts.admin')
@section('title', 'Yetenekler')
@section('content')
<div class="flex justify-between items-center mb-8">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Yetenekler</h1>
    <a href="{{ route('admin.skills.create') }}" class="btn-primary">Yeni Yetenek Ekle</a>
</div>
<div class="card">
    @forelse($skills->groupBy('category') as $category => $categorySkills)
    <div class="mb-6 last:mb-0">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">{{ $category }}</h3>
        @foreach($categorySkills as $skill)
        <div class="flex justify-between items-center py-2 border-b dark:border-gray-700 last:border-b-0">
            <div class="flex-1">
                <span class="text-gray-700 dark:text-gray-300">{{ $skill->name }}</span>
                <span class="text-sm text-primary-600 ml-2">{{ $skill->proficiency }}%</span>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.skills.edit', $skill) }}" class="text-primary-600 hover:underline">Düzenle</a>
                <form action="{{ route('admin.skills.destroy', $skill) }}" method="POST" onsubmit="return confirm('Silmek istediğinize emin misiniz?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:underline">Sil</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @empty
    <p class="text-gray-600 dark:text-gray-400">Henüz yetenek eklenmemiş.</p>
    @endforelse
</div>
@endsection
