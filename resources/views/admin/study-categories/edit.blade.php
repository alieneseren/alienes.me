@extends('layouts.admin')

@section('title', 'Kategori Düzenle')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Kategori Düzenle</h1>
</div>

<div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 p-6">
    <form action="{{ route('admin.study-categories.update', $studyCategory) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kategori Adı *</label>
            <input type="text" name="name" value="{{ old('name', $studyCategory->name) }}" required class="input-field">
            @error('name')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">İkon (Emoji)</label>
            <input type="text" name="icon" value="{{ old('icon', $studyCategory->icon) }}" class="input-field">
            @error('icon')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Açıklama</label>
            <textarea name="description" rows="3" class="input-field">{{ old('description', $studyCategory->description) }}</textarea>
            @error('description')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sıra</label>
            <input type="number" name="order" value="{{ old('order', $studyCategory->order) }}" class="input-field" min="0">
            @error('order')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-6">
            <label class="flex items-center">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $studyCategory->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-sky-600 focus:ring-sky-500">
                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Aktif</span>
            </label>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="btn-primary">Güncelle</button>
            <a href="{{ route('admin.study-categories.index') }}" class="btn-secondary">İptal</a>
        </div>
    </form>
</div>
@endsection
