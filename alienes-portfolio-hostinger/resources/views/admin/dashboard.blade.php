@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
<h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Dashboard</h1>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <div class="card">
        <h3 class="text-gray-600 dark:text-gray-400 text-sm font-medium mb-2">Deneyimler</h3>
        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['experiences'] }}</p>
    </div>
    <div class="card">
        <h3 class="text-gray-600 dark:text-gray-400 text-sm font-medium mb-2">Eğitim</h3>
        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['educations'] }}</p>
    </div>
    <div class="card">
        <h3 class="text-gray-600 dark:text-gray-400 text-sm font-medium mb-2">Yetenekler</h3>
        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['skills'] }}</p>
    </div>
    <div class="card">
        <h3 class="text-gray-600 dark:text-gray-400 text-sm font-medium mb-2">Projeler</h3>
        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['projects'] }}</p>
    </div>
    <div class="card">
        <h3 class="text-gray-600 dark:text-gray-400 text-sm font-medium mb-2">Toplam Mesaj</h3>
        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['contacts'] }}</p>
    </div>
    <div class="card">
        <h3 class="text-gray-600 dark:text-gray-400 text-sm font-medium mb-2">Okunmamış Mesaj</h3>
        <p class="text-3xl font-bold text-primary-600">{{ $stats['unread_contacts'] }}</p>
    </div>
</div>
<div class="card">
    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Son Mesajlar</h2>
    @forelse($recentContacts as $contact)
    <div class="border-b dark:border-gray-700 py-3 last:border-b-0">
        <div class="flex justify-between items-start">
            <div>
                <p class="font-semibold text-gray-900 dark:text-white">{{ $contact->name }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $contact->subject }}</p>
            </div>
            <a href="{{ route('admin.contacts.show', $contact) }}" class="text-primary-600 dark:text-primary-400 text-sm hover:underline">Görüntüle</a>
        </div>
    </div>
    @empty
    <p class="text-gray-600 dark:text-gray-400">Henüz mesaj yok.</p>
    @endforelse
</div>
@endsection
