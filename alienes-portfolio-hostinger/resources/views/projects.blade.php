@extends('layouts.frontend')

@section('title', 'Projeler - Alienes.me')
@section('meta_description', 'Tüm projelerim ve çalışmalarım')

@section('content')
<!-- Page Header -->
<section class="pt-24 pb-12 bg-gradient-to-br from-primary-50 to-white dark:from-gray-900 dark:to-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-5xl font-bold text-gray-900 dark:text-white mb-4">Projelerim</h1>
        <p class="text-xl text-gray-600 dark:text-gray-300">Üzerinde çalıştığım ve tamamladığım projeler</p>
    </div>
</section>

<!-- Projects Grid -->
<section class="py-20 bg-white dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($projects->count() > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($projects as $project)
            <div class="bg-gray-50 dark:bg-gray-900 rounded-lg shadow-lg overflow-hidden hover:shadow-2xl transition-shadow duration-300">
                @if($project->image)
                <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}" class="w-full h-48 object-cover">
                @else
                <div class="w-full h-48 bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center">
                    <span class="text-4xl font-bold text-white">{{ substr($project->title, 0, 1) }}</span>
                </div>
                @endif
                
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $project->title }}</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">{{ $project->description }}</p>
                    
                    @if($project->technologies)
                    <div class="flex flex-wrap gap-2 mb-4">
                        @foreach(is_array($project->technologies) ? $project->technologies : explode(',', $project->technologies) as $tech)
                        <span class="px-2 py-1 bg-primary-100 dark:bg-primary-900 text-primary-600 dark:text-primary-400 text-xs rounded">{{ trim($tech) }}</span>
                        @endforeach
                    </div>
                    @endif
                    
                    <div class="flex gap-4">
                        @if($project->demo_url)
                        <a href="{{ $project->demo_url }}" target="_blank" class="text-primary-600 dark:text-primary-400 hover:underline text-sm font-semibold">
                            Demo →
                        </a>
                        @endif
                        @if($project->github_url)
                        <a href="{{ $project->github_url }}" target="_blank" class="text-primary-600 dark:text-primary-400 hover:underline text-sm font-semibold">
                            GitHub →
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        @if($projects->hasPages())
        <div class="mt-12">
            {{ $projects->links() }}
        </div>
        @endif
        @else
        <div class="text-center py-12">
            <p class="text-xl text-gray-600 dark:text-gray-400">Henüz proje eklenmemiş.</p>
        </div>
        @endif
    </div>
</section>
@endsection
