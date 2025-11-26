@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Hoş Geldiniz, {{ session('user_name') }} 👋</h1>
    <p class="text-gray-500 dark:text-gray-400 mt-1">Sitenizin genel durumunu buradan takip edebilirsiniz.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <!-- İstatistik Kartları -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 transition-transform hover:-translate-y-1 duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400">
                <i class="fas fa-briefcase text-xl"></i>
            </div>
            <span class="text-xs font-medium text-gray-400 bg-gray-50 dark:bg-gray-700/50 px-2 py-1 rounded-lg">Toplam</span>
        </div>
        <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium mb-1">Deneyimler</h3>
        <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $stats['experiences'] }}</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 transition-transform hover:-translate-y-1 duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-xl bg-purple-50 dark:bg-purple-900/30 flex items-center justify-center text-purple-600 dark:text-purple-400">
                <i class="fas fa-graduation-cap text-xl"></i>
            </div>
            <span class="text-xs font-medium text-gray-400 bg-gray-50 dark:bg-gray-700/50 px-2 py-1 rounded-lg">Toplam</span>
        </div>
        <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium mb-1">Eğitim</h3>
        <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $stats['educations'] }}</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 transition-transform hover:-translate-y-1 duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center text-amber-600 dark:text-amber-400">
                <i class="fas fa-bolt text-xl"></i>
            </div>
            <span class="text-xs font-medium text-gray-400 bg-gray-50 dark:bg-gray-700/50 px-2 py-1 rounded-lg">Toplam</span>
        </div>
        <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium mb-1">Yetenekler</h3>
        <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $stats['skills'] }}</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 transition-transform hover:-translate-y-1 duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                <i class="fas fa-code-branch text-xl"></i>
            </div>
            <span class="text-xs font-medium text-gray-400 bg-gray-50 dark:bg-gray-700/50 px-2 py-1 rounded-lg">Toplam</span>
        </div>
        <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium mb-1">Projeler</h3>
        <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $stats['projects'] }}</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 transition-transform hover:-translate-y-1 duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                <i class="fas fa-envelope text-xl"></i>
            </div>
            <span class="text-xs font-medium text-gray-400 bg-gray-50 dark:bg-gray-700/50 px-2 py-1 rounded-lg">Toplam</span>
        </div>
        <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium mb-1">Mesajlar</h3>
        <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $stats['contacts'] }}</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 transition-transform hover:-translate-y-1 duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-xl bg-rose-50 dark:bg-rose-900/30 flex items-center justify-center text-rose-600 dark:text-rose-400">
                <i class="fas fa-bell text-xl"></i>
            </div>
            <span class="text-xs font-medium text-rose-600 bg-rose-50 dark:bg-rose-900/20 px-2 py-1 rounded-lg">Dikkat</span>
        </div>
        <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium mb-1">Okunmamış Mesaj</h3>
        <p class="text-3xl font-bold text-rose-600 dark:text-rose-400">{{ $stats['unread_contacts'] }}</p>
    </div>
</div>

<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
    <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
        <h2 class="text-lg font-bold text-gray-800 dark:text-white">Son Mesajlar</h2>
        <a href="{{ route('admin.contacts.index') }}" class="text-sm text-sky-600 hover:text-sky-700 font-medium">Tümünü Gör</a>
    </div>
    <div class="divide-y divide-gray-100 dark:divide-gray-700">
        @forelse($recentContacts as $contact)
        <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-500 dark:text-gray-400 font-bold">
                        {{ substr($contact->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800 dark:text-white">{{ $contact->name }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $contact->subject }}</p>
                    </div>
                </div>
                <a href="{{ route('admin.contacts.show', $contact) }}" class="px-3 py-1.5 text-xs font-medium text-sky-600 bg-sky-50 dark:bg-sky-900/30 dark:text-sky-400 rounded-lg hover:bg-sky-100 dark:hover:bg-sky-900/50 transition-colors">
                    Görüntüle
                </a>
            </div>
        </div>
        @empty
        <div class="p-8 text-center text-gray-500 dark:text-gray-400">
            <i class="fas fa-inbox text-4xl mb-3 opacity-20"></i>
            <p>Henüz mesaj yok.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
