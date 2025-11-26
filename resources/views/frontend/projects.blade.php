@extends('layouts.frontend')
@section('title', 'Projeler - ' . ($profile->full_name ?? 'alienes.me'))
@section('content')
<section class="py-20 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold text-center text-gray-900 dark:text-white mb-4">Projelerim</h1>
        <p class="text-center text-gray-600 dark:text-gray-400 mb-12">Gerçekleştirdiğim projeler ve çalışmalar</p>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($projects as $project)
            <div class="card hover:scale-105">
                @if($project->image)
                <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}" class="w-full h-48 object-cover rounded-lg mb-4">
                @else
                <div class="w-full h-48 bg-gradient-to-br from-primary-400 to-primary-600 rounded-lg mb-4 flex items-center justify-center">
                    <span class="text-4xl text-white font-bold">{{ substr($project->title, 0, 1) }}</span>
                </div>
                @endif
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">{{ $project->title }}</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $project->description }}</p>
                <div class="flex flex-wrap gap-2 mb-4">
                    @foreach($project->technologies as $tech)
                    <span class="px-3 py-1 bg-primary-100 dark:bg-primary-900 text-primary-600 dark:text-primary-400 rounded-full text-sm">{{ $tech }}</span>
                    @endforeach
                </div>
                <div class="flex gap-4">
                    @if($project->demo_url)
                    <a href="{{ $project->demo_url }}" target="_blank" class="text-primary-600 dark:text-primary-400 hover:underline">Demo</a>
                    @endif
                    @if($project->github_url)
                    <a href="{{ $project->github_url }}" target="_blank" class="text-primary-600 dark:text-primary-400 hover:underline">GitHub</a>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-12">
                <p class="text-gray-600 dark:text-gray-400">Henüz proje eklenmemiş.</p>
            </div>
            @endforelse
        </div>
        <div class="mt-12">
            {{ $projects->links() }}
        </div>
    </div>
</section>
@endsection
