@extends('layouts.frontend')

@section('title', $category->name . ' - Çalışma Notları')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-6xl mx-auto">
        <!-- Breadcrumb -->
        <nav class="text-sm mb-6">
            <ol class="flex items-center space-x-2 text-gray-600 dark:text-gray-400">
                <li><a href="{{ route('study.index') }}" class="hover:text-primary-600">Çalışma Notları</a></li>
                <li><span>/</span></li>
                <li class="text-gray-900 dark:text-white font-semibold">{{ $category->name }}</li>
            </ol>
        </nav>

        <!-- Category Header -->
        <div class="bg-gradient-to-r from-primary-600 to-primary-700 rounded-lg p-4 sm:p-6 md:p-8 mb-6 md:mb-8 text-white">
            <div class="flex items-center mb-4">
                <span class="text-4xl sm:text-5xl md:text-6xl mr-3 sm:mr-4 flex-shrink-0">{{ $category->icon }}</span>
                <div class="min-w-0 flex-1">
                    <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold break-words">{{ $category->name }}</h1>
                    <p class="text-primary-100 mt-1 sm:mt-2 text-sm sm:text-base break-words">{{ $category->description }}</p>
                </div>
            </div>
            <div class="text-xs sm:text-sm text-primary-200">{{ $notes->count() }} ders notu mevcut</div>
        </div>

        <!-- Notes List -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            @foreach($notes as $note)
            <a href="{{ route('study.show', [$category->slug, $note->slug]) }}" 
               class="group relative bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 dark:border-gray-700 hover:border-primary-500 dark:hover:border-primary-500">
                
                <!-- Order Badge -->
                <div class="absolute top-3 right-3 sm:top-4 sm:right-4 w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-primary-500 to-primary-600 rounded-lg flex items-center justify-center text-white text-sm sm:text-base font-bold shadow-lg transform group-hover:scale-110 transition-transform z-10">
                    {{ $note->order }}
                </div>
                
                <!-- Content -->
                <div class="p-4 sm:p-6">
                    <!-- Icon/Type -->
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-primary-50 dark:bg-primary-900/30 rounded-lg flex items-center justify-center mb-3 sm:mb-4 group-hover:bg-primary-100 dark:group-hover:bg-primary-900/50 transition-colors flex-shrink-0">
                        @if(str_contains(strtolower($note->title), 'test'))
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                        @elseif(str_contains(strtolower($note->title), 'flashcard'))
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                            </svg>
                        @elseif(str_contains(strtolower($note->title), 'formül') || str_contains(strtolower($note->title), 'özet'))
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        @elseif(str_contains(strtolower($note->title), 'pratik'))
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        @else
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        @endif
                    </div>
                    
                    <!-- Title -->
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white mb-2 pr-10 sm:pr-12 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors line-clamp-2 break-words">
                        {{ $note->title }}
                    </h3>
                    
                    <!-- Description -->
                    @if($note->description)
                    <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mb-3 sm:mb-4 line-clamp-2 break-words">{{ $note->description }}</p>
                    @endif
                    
                    <!-- Footer -->
                    <div class="flex items-center justify-between pt-3 sm:pt-4 border-t border-gray-100 dark:border-gray-700">
                        <div class="flex items-center text-xs text-gray-500 dark:text-gray-500">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="truncate">{{ $note->views }}</span>
                        </div>
                        <div class="text-primary-600 dark:text-primary-400 text-xs sm:text-sm font-medium group-hover:translate-x-1 transition-transform whitespace-nowrap">
                            İncele →
                        </div>
                    </div>
                </div>
                
                <!-- Hover Effect -->
                <div class="absolute inset-0 bg-gradient-to-r from-primary-500/5 to-primary-600/5 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
            </a>
            @endforeach
        </div>

        @if($notes->isEmpty())
        <div class="text-center py-12">
            <div class="text-6xl mb-4">📭</div>
            <p class="text-gray-600 dark:text-gray-400">Henüz not eklenmemiş.</p>
        </div>
        @endif
    </div>
</div>
@endsection
