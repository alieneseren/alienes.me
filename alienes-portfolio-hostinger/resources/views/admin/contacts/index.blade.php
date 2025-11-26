@extends('layouts.admin')
@section('title', 'Mesajlar')
@section('content')
<h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">İletişim Mesajları</h1>
<div class="card">
    @forelse($contacts as $contact)
    <div class="border-b dark:border-gray-700 py-4 last:border-b-0 {{ $contact->is_read ? '' : 'bg-primary-50 dark:bg-primary-900/20' }}">
        <div class="flex justify-between items-start">
            <div class="flex-1">
                <div class="flex items-center gap-2 mb-1">
                    <h3 class="font-semibold text-gray-900 dark:text-white">{{ $contact->name }}</h3>
                    @unless($contact->is_read)
                    <span class="px-2 py-1 bg-primary-600 text-white text-xs rounded-full">Yeni</span>
                    @endunless
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $contact->email }}</p>
                <p class="text-sm text-gray-700 dark:text-gray-300 mt-1">{{ $contact->subject }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ $contact->created_at->diffForHumans() }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.contacts.show', $contact) }}" class="text-primary-600 hover:underline">Görüntüle</a>
                <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" onsubmit="return confirm('Silmek istediğinize emin misiniz?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:underline">Sil</button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <p class="text-gray-600 dark:text-gray-400">Henüz mesaj yok.</p>
    @endforelse
</div>
<div class="mt-6">
    {{ $contacts->links() }}
</div>
@endsection
