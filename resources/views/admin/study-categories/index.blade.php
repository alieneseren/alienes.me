@extends('layouts.admin')

@section('title', 'Çalışma Kategorileri')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">📚 Çalışma Kategorileri</h1>
    <a href="{{ route('admin.study-categories.create') }}" class="btn-primary">+ Yeni Kategori</a>
</div>

<div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Sıra</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">İkon</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Kategori</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Notlar</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Durum</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">İşlemler</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($categories as $category)
            <tr>
                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $category->order }}</td>
                <td class="px-6 py-4 text-2xl">{{ $category->icon }}</td>
                <td class="px-6 py-4">
                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $category->name }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $category->slug }}</div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $category->notes_count }} not</td>
                <td class="px-6 py-4">
                    @if($category->is_active)
                        <span class="px-2 py-1 text-xs rounded bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">Aktif</span>
                    @else
                        <span class="px-2 py-1 text-xs rounded bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200">Pasif</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-right text-sm space-x-2">
                    <a href="{{ route('admin.study-categories.edit', $category) }}" class="text-sky-600 hover:text-sky-900">Düzenle</a>
                    <form action="{{ route('admin.study-categories.destroy', $category) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Emin misiniz?')">Sil</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">Henüz kategori eklenmemiş.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
