@extends('layouts.admin')

@section('title', 'Yeni Kategori Ekle')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Yeni Kategori Ekle</h1>
</div>

<div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 p-6">
    <form action="{{ route('admin.study-categories.store') }}" method="POST">
        @csrf
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kategori Adı *</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="input-field" placeholder="Mikroişlemciler">
            @error('name')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">İkon (Emoji)</label>
            <input type="text" name="icon" value="{{ old('icon', '📚') }}" class="input-field" placeholder="💻">
            @error('icon')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Açıklama</label>
            <textarea name="description" rows="3" class="input-field" placeholder="Kısa açıklama">{{ old('description') }}</textarea>
            @error('description')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sıra</label>
            <input type="number" name="order" value="{{ old('order', 0) }}" class="input-field" min="0">
            @error('order')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-6">
            <label class="flex items-center">
                <input type="checkbox" name="is_active" value="1" checked class="rounded border-gray-300 text-sky-600 focus:ring-sky-500">
                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Aktif</span>
            </label>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="btn-primary">Kaydet</button>
            <a href="{{ route('admin.study-categories.index') }}" class="btn-secondary">İptal</a>
        </div>
    </form>
</div>
@endsection
