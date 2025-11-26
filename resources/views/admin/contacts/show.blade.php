@extends('layouts.admin')
@section('title', 'Mesaj Detayı')
@section('content')
<div class="mb-8">
    <a href="{{ route('admin.contacts.index') }}" class="text-primary-600 hover:underline">← Geri</a>
</div>
<div class="card">
    <div class="mb-6 pb-6 border-b dark:border-gray-700">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">{{ $contact->subject }}</h2>
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Gönderen</p>
                <p class="text-gray-900 dark:text-white">{{ $contact->name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Email</p>
                <a href="mailto:{{ $contact->email }}" class="text-primary-600 hover:underline">{{ $contact->email }}</a>
            </div>
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Tarih</p>
                <p class="text-gray-900 dark:text-white">{{ $contact->created_at->format('d M Y, H:i') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Durum</p>
                <p class="text-gray-900 dark:text-white">{{ $contact->is_read ? 'Okundu' : 'Okunmadı' }}</p>
            </div>
        </div>
    </div>
    <div>
        <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Mesaj</h3>
        <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $contact->message }}</p>
    </div>
    <div class="mt-6 flex gap-4">
        <a href="mailto:{{ $contact->email }}" class="btn-primary">Yanıtla</a>
        <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" onsubmit="return confirm('Silmek istediğinize emin misiniz?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-secondary text-red-600">Sil</button>
        </form>
    </div>
</div>
@endsection
