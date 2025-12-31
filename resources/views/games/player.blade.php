@extends('layouts.frontend')

@section('title', $game->name . ' - Oyun')

@section('content')
<div class="min-h-screen bg-gray-900">
    {{-- Header --}}
    <div class="bg-gray-800 border-b border-gray-700 px-4 py-3 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="https://games.alienes.me" class="text-gray-400 hover:text-white transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="text-white font-semibold text-lg">
                @if($game->icon)
                    <span class="mr-2">{{ $game->icon }}</span>
                @endif
                {{ $game->name }}
            </h1>
        </div>
        <div class="text-gray-400 text-sm">
            {{ $game->description }}
        </div>
    </div>

    {{-- Game Container --}}
    <div class="w-full" style="height: calc(100vh - 60px);">
        <iframe 
            src="{{ asset($game->extracted_path . '/' . $game->entry_file) }}"
            class="w-full h-full border-0"
            allowfullscreen
            allow="autoplay; fullscreen; gamepad"
        ></iframe>
    </div>
</div>
@endsection
