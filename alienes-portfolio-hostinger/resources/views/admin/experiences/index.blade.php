@extends('layouts.admin')
@section('title', 'Deneyimler')
@section('content')
<div class="flex justify-between items-center mb-8">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Deneyimler</h1>
    <a href="{{ route('admin.experiences.create') }}" class="btn-primary">Yeni Deneyim Ekle</a>
</div>
<div class="card">
    @forelse($experiences as $experience)
    <div class="border-b dark:border-gray-700 py-4 last:border-b-0">
        <div class="flex justify-between items-start">
            <div>
                <h3 class="font-semibold text-gray-900 dark:text-white">{{ $experience->position }}</h3>
                <p class="text-primary-600 dark:text-primary-400">{{ $experience->company }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $experience->start_date->format('M Y') }} - {{ $experience->is_current ? 'Devam Ediyor' : $experience->end_date->format('M Y') }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.experiences.edit', $experience) }}" class="text-primary-600 hover:underline">Düzenle</a>
                <form action="{{ route('admin.experiences.destroy', $experience) }}" method="POST" onsubmit="return confirm('Silmek istediğinize emin misiniz?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:underline">Sil</button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <p class="text-gray-600 dark:text-gray-400">Henüz deneyim eklenmemiş.</p>
    @endforelse
</div>
@endsection
