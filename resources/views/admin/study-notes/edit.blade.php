@extends('layouts.admin')

@section('title', 'Not Düzenle')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Not Düzenle</h1>
</div>

<div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 p-6">
    <form action="{{ route('admin.study-notes.update', $studyNote) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kategori *</label>
            <select name="category_id" required class="input-field">
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id', $studyNote->category_id) == $category->id ? 'selected' : '' }}>
                    {{ $category->icon }} {{ $category->name }}
                </option>
                @endforeach
            </select>
            @error('category_id')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Not Başlığı *</label>
            <input type="text" name="title" value="{{ old('title', $studyNote->title) }}" required class="input-field">
            @error('title')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Açıklama</label>
            <textarea name="description" rows="3" class="input-field">{{ old('description', $studyNote->description) }}</textarea>
            @error('description')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Dosya</label>
            <input type="file" name="file" class="input-field" accept=".html,.htm,.pdf,.md">
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Mevcut: <strong>{{ $studyNote->file_path }}</strong><br>
                Yeni dosya seçerseniz eskisi değiştirilecektir
            </p>
            @error('file')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sıra</label>
            <input type="number" name="order" value="{{ old('order', $studyNote->order) }}" class="input-field" min="0">
            @error('order')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-6">
            <label class="flex items-center">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $studyNote->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-sky-600 focus:ring-sky-500">
                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Aktif</span>
            </label>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="btn-primary">Güncelle</button>
            <a href="{{ route('admin.study-notes.index') }}" class="btn-secondary">İptal</a>
        </div>
    </form>
</div>
@endsection
