@extends('layouts.frontend')

@section('title', $note->title . ' - ' . $category->name)

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="container mx-auto px-4">
        <!-- Breadcrumb -->
        <nav class="mb-4">
            <ol class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400">
                <li><a href="{{ route('study.index') }}" class="hover:text-primary-600">📚 Çalışma Notları</a></li>
                <li><span>/</span></li>
                <li><a href="{{ route('study.category', $category->slug) }}" class="hover:text-primary-600">{{ $category->name }}</a></li>
                <li><span>/</span></li>
                <li class="text-gray-900 dark:text-white font-semibold">{{ $note->title }}</li>
            </ol>
        </nav>

        <!-- Note Info Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 p-4 mb-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $note->title }}</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        {{ $category->icon }} {{ $category->name }} • 👁️ {{ $note->views }} görüntülenme
                    </p>
                </div>
                <a href="{{ route('study.category', $category->slug) }}" class="btn-secondary text-sm">
                    ← Geri Dön
                </a>
            </div>
        </div>

        <!-- HTML Content in Iframe -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 overflow-hidden">
            <iframe 
                src="{{ asset($note->file_path) }}" 
                class="w-full border-0"
                style="min-height: calc(100vh - 250px);"
                onload="this.style.height=(this.contentWindow.document.documentElement.scrollHeight + 50) + 'px';"
                frameborder="0">
            </iframe>
        </div>
    </div>
</div>
@endsection
