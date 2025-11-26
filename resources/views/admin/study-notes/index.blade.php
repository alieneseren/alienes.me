@extends('layouts.admin')

@section('title', 'Çalışma Notları')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">📝 Çalışma Notları</h1>
    <a href="{{ route('admin.study-notes.create') }}" class="btn-primary">+ Yeni Not Ekle</a>
</div>

<div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Kategori</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Not</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Dosya</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Görüntülenme</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Durum</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">İşlemler</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($notes as $note)
            <tr>
                <td class="px-6 py-4">
                    <div class="flex items-center">
                        <span class="text-2xl mr-2">{{ $note->category->icon }}</span>
                        <span class="text-sm text-gray-900 dark:text-white">{{ $note->category->name }}</span>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $note->title }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Sıra: {{ $note->order }}</div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                    <span class="px-2 py-1 text-xs rounded bg-gray-100 dark:bg-gray-700">{{ strtoupper($note->type) }}</span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $note->views }}</td>
                <td class="px-6 py-4">
                    @if($note->is_active)
                        <span class="px-2 py-1 text-xs rounded bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">Aktif</span>
                    @else
                        <span class="px-2 py-1 text-xs rounded bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200">Pasif</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-right text-sm space-x-2">
                    <a href="{{ route('study.show', [$note->category->slug, $note->slug]) }}" target="_blank" class="text-green-600 hover:text-green-900">Görüntüle</a>
                    <a href="{{ route('admin.study-notes.edit', $note) }}" class="text-sky-600 hover:text-sky-900">Düzenle</a>
                    <form action="{{ route('admin.study-notes.destroy', $note) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Emin misiniz?')">Sil</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">Henüz not eklenmemiş.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
