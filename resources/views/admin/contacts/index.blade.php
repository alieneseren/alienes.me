@extends('layouts.admin')
@section('title', 'Mesajlar')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">İletişim Mesajları</h1>
    <p class="text-gray-500 dark:text-gray-400 mt-1">Web sitenizden gelen iletişim formlarını yönetin.</p>
</div>

<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
    <div class="divide-y divide-gray-100 dark:divide-gray-700">
        @forelse($contacts as $contact)
        <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group {{ $contact->is_read ? '' : 'bg-sky-50/50 dark:bg-sky-900/10' }}">
            <div class="flex flex-col sm:flex-row justify-between items-start gap-4">
                <div class="flex items-start gap-4 flex-1">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center text-lg font-bold shrink-0 {{ $contact->is_read ? 'bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400' : 'bg-sky-100 dark:bg-sky-900 text-sky-600 dark:text-sky-400' }}">
                        {{ substr($contact->name, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <h3 class="font-bold text-gray-900 dark:text-white truncate">{{ $contact->name }}</h3>
                            @unless($contact->is_read)
                            <span class="px-2 py-0.5 bg-sky-600 text-white text-xs font-bold rounded-full shadow-sm shadow-sky-600/20">Yeni</span>
                            @endunless
                            <span class="text-xs text-gray-400 ml-auto sm:ml-2">{{ $contact->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-sm text-sky-600 dark:text-sky-400 font-medium mb-1">{{ $contact->email }}</p>
                        <p class="text-gray-700 dark:text-gray-300 font-medium">{{ $contact->subject }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 line-clamp-2">{{ $contact->message }}</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity self-end sm:self-center">
                    <a href="{{ route('admin.contacts.show', $contact) }}" class="px-4 py-2 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors text-sm font-medium shadow-sm">
                        Görüntüle
                    </a>
                    <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" onsubmit="return confirm('Silmek istediğinize emin misiniz?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors" title="Sil">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="p-12 text-center">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-400">
                <i class="fas fa-inbox text-2xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Henüz mesaj yok</h3>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Gelen kutunuz boş.</p>
        </div>
        @endforelse
    </div>
</div>
<div class="mt-6">
    {{ $contacts->links() }}
</div>
@endsection
