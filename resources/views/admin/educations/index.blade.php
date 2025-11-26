@extends('layouts.admin')
@section('title', 'Eğitim')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Eğitim</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Eğitim geçmişinizi ve sertifikalarınızı yönetin.</p>
    </div>
    <a href="{{ route('admin.educations.create') }}" class="flex items-center gap-2 px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white rounded-xl font-medium transition-all shadow-lg shadow-sky-600/30">
        <i class="fas fa-plus"></i>
        <span>Yeni Eğitim Ekle</span>
    </a>
</div>

<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
    <div class="divide-y divide-gray-100 dark:divide-gray-700">
        @forelse($educations as $education)
        <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group">
            <div class="flex flex-col sm:flex-row justify-between items-start gap-4">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-purple-50 dark:bg-purple-900/30 flex items-center justify-center text-purple-600 dark:text-purple-400 shrink-0">
                        <i class="fas fa-graduation-cap text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white">{{ $education->degree }}</h3>
                        <div class="flex items-center gap-2 text-sky-600 dark:text-sky-400 font-medium mb-1">
                            <i class="fas fa-university text-sm"></i>
                            <span>{{ $education->school }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                            <i class="fas fa-book-open"></i>
                            <span>{{ $education->field_of_study }}</span>
                        </div>
                        @if($education->start_date)
                        <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mt-1">
                            <i class="fas fa-calendar-alt"></i>
                            <span>{{ $education->start_date->format('Y') }} - {{ $education->end_date ? $education->end_date->format('Y') : 'Devam Ediyor' }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                
                <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                    <a href="{{ route('admin.educations.edit', $education) }}" class="p-2 text-sky-600 hover:bg-sky-50 dark:hover:bg-sky-900/30 rounded-lg transition-colors" title="Düzenle">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('admin.educations.destroy', $education) }}" method="POST" onsubmit="return confirm('Silmek istediğinize emin misiniz?')">
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
                <i class="fas fa-graduation-cap text-2xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Henüz eğitim yok</h3>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Yeni bir eğitim ekleyerek başlayın.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
