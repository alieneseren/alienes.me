@extends('layouts.admin')
@section('title', 'Eğitim')
@section('content')
<div class="flex justify-between items-center mb-8">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Eğitim</h1>
    <a href="{{ route('admin.educations.create') }}" class="btn-primary">Yeni Eğitim Ekle</a>
</div>
<div class="card">
    @forelse($educations as $education)
    <div class="border-b dark:border-gray-700 py-4 last:border-b-0">
        <div class="flex justify-between items-start">
            <div>
                <h3 class="font-semibold text-gray-900 dark:text-white">{{ $education->degree }}</h3>
                <p class="text-primary-600 dark:text-primary-400">{{ $education->school }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $education->field_of_study }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.educations.edit', $education) }}" class="text-primary-600 hover:underline">Düzenle</a>
                <form action="{{ route('admin.educations.destroy', $education) }}" method="POST" onsubmit="return confirm('Silmek istediğinize emin misiniz?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:underline">Sil</button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <p class="text-gray-600 dark:text-gray-400">Henüz eğitim eklenmemiş.</p>
    @endforelse
</div>
@endsection
