@extends('layouts.admin')
@section('title', isset($skill) ? 'Yetenek Düzenle' : 'Yeni Yetenek Ekle')
@section('content')
<h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">{{ isset($skill) ? 'Yetenek Düzenle' : 'Yeni Yetenek Ekle' }}</h1>
<div class="card">
    <form action="{{ isset($skill) ? route('admin.skills.update', $skill) : route('admin.skills.store') }}" method="POST">
        @csrf
        @if(isset($skill)) @method('PUT') @endif
        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Yetenek Adı *</label>
                <input type="text" name="name" value="{{ old('name', $skill->name ?? '') }}" required class="input-field">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kategori *</label>
                <input type="text" name="category" value="{{ old('category', $skill->category ?? '') }}" list="categories" required class="input-field">
                <datalist id="categories">
                    @foreach($categories ?? [] as $cat)
                    <option value="{{ $cat }}">
                    @endforeach
                </datalist>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Yeterlilik (0-100) *</label>
                <input type="number" name="proficiency" min="0" max="100" value="{{ old('proficiency', $skill->proficiency ?? 50) }}" required class="input-field">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sıra</label>
                <input type="number" name="order" value="{{ old('order', $skill->order ?? 0) }}" class="input-field">
            </div>
        </div>
        <div class="mt-6 flex gap-4">
            <button type="submit" class="btn-primary">{{ isset($skill) ? 'Güncelle' : 'Kaydet' }}</button>
            <a href="{{ route('admin.skills.index') }}" class="btn-secondary">İptal</a>
        </div>
    </form>
</div>
@endsection
