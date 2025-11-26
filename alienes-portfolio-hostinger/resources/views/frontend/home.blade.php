@extends('layouts.frontend')

@section('title', $profile ? $profile->full_name . ' - Portfolio' : 'alienes.me')

@section('content')
    <!-- Hero Section -->
    <section id="home" class="min-h-screen flex items-center justify-center bg-gradient-to-br from-primary-50 to-white dark:from-gray-900 dark:to-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Text Content -->
                <div class="text-center md:text-left animate-fadeIn">
                    <h1 class="text-5xl md:text-6xl font-bold text-gray-900 dark:text-white mb-4">
                        {{ $profile->full_name ?? 'Your Name' }}
                    </h1>
                    <h2 class="text-2xl md:text-3xl text-primary-600 dark:text-primary-400 mb-6">
                        {{ $profile->title ?? 'Your Title' }}
                    </h2>
                    <p class="text-lg text-gray-600 dark:text-gray-300 mb-8 max-w-xl">
                        {{ Str::limit($profile->bio ?? 'Your bio goes here', 200) }}
                    </p>
                    
                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                        <a href="#contact" class="btn-primary inline-block text-center">
                            İletişime Geç
                        </a>
                        <a href="{{ route('projects') }}" class="btn-secondary inline-block text-center">
                            Projelerimi Gör
                        </a>
                    </div>

                    <!-- Social Links -->
                    @if($profile)
                    <div class="flex gap-4 mt-8 justify-center md:justify-start">
                        @if($profile->github_url)
                        <a href="{{ $profile->github_url }}" target="_blank" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                            </svg>
                        </a>
                        @endif
                        @if($profile->linkedin_url)
                        <a href="{{ $profile->linkedin_url }}" target="_blank" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                            </svg>
                        </a>
                        @endif
                        @if($profile->twitter_url)
                        <a href="{{ $profile->twitter_url }}" target="_blank" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"></path>
                            </svg>
                        </a>
                        @endif
                    </div>
                    @endif
                </div>

                <!-- Image -->
                <div class="flex justify-center animate-fadeIn" style="animation-delay: 0.2s;">
                    @if($profile && $profile->profile_image)
                        <img src="{{ asset('storage/' . $profile->profile_image) }}" alt="{{ $profile->full_name }}" class="w-64 h-64 md:w-96 md:h-96 rounded-full object-cover shadow-2xl ring-4 ring-primary-200 dark:ring-primary-800">
                    @else
                        <div class="w-64 h-64 md:w-96 md:h-96 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 shadow-2xl flex items-center justify-center">
                            <span class="text-8xl text-white font-bold">{{ substr($profile->full_name ?? 'A', 0, 1) }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-center text-gray-900 dark:text-white mb-12">Hakkımda</h2>
            <div class="max-w-3xl mx-auto">
                <div class="card">
                    <p class="text-lg text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-line">
                        {{ $profile->bio ?? 'Bio bilgisi ekleyin.' }}
                    </p>
                    
                    @if($profile && ($profile->email || $profile->phone || $profile->location))
                    <div class="mt-8 pt-8 border-t dark:border-gray-700">
                        <div class="grid md:grid-cols-3 gap-6">
                            @if($profile->email)
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-gray-700 dark:text-gray-300">{{ $profile->email }}</span>
                            </div>
                            @endif
                            
                            @if($profile->phone)
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <span class="text-gray-700 dark:text-gray-300">{{ $profile->phone }}</span>
                            </div>
                            @endif
                            
                            @if($profile->location)
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span class="text-gray-700 dark:text-gray-300">{{ $profile->location }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Experience Section -->
    @if($experiences->count() > 0)
    <section id="experience" class="py-20 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-center text-gray-900 dark:text-white mb-12">Deneyimler</h2>
            <div class="max-w-4xl mx-auto">
                <div class="space-y-8">
                    @foreach($experiences as $experience)
                    <div class="card hover:scale-105">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $experience->position }}</h3>
                                <p class="text-primary-600 dark:text-primary-400 font-medium">{{ $experience->company }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $experience->start_date->format('M Y') }} - 
                                    {{ $experience->is_current ? 'Devam Ediyor' : $experience->end_date->format('M Y') }}
                                </p>
                                @if($experience->location)
                                <p class="text-sm text-gray-500 dark:text-gray-500">{{ $experience->location }}</p>
                                @endif
                            </div>
                        </div>
                        <p class="text-gray-700 dark:text-gray-300">{{ $experience->description }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Education Section -->
    @if($educations->count() > 0)
    <section id="education" class="py-20 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-center text-gray-900 dark:text-white mb-12">Eğitim</h2>
            <div class="max-w-4xl mx-auto">
                <div class="space-y-8">
                    @foreach($educations as $education)
                    <div class="card hover:scale-105">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $education->degree }}</h3>
                                <p class="text-primary-600 dark:text-primary-400 font-medium">{{ $education->school }}</p>
                                <p class="text-gray-600 dark:text-gray-400">{{ $education->field_of_study }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $education->start_date->format('Y') }} - 
                                    {{ $education->is_current ? 'Devam Ediyor' : $education->end_date->format('Y') }}
                                </p>
                                @if($education->gpa)
                                <p class="text-sm text-gray-500 dark:text-gray-500">GPA: {{ $education->gpa }}</p>
                                @endif
                            </div>
                        </div>
                        @if($education->description)
                        <p class="text-gray-700 dark:text-gray-300">{{ $education->description }}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Skills Section -->
    @if($skills->count() > 0)
    <section id="skills" class="py-20 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-center text-gray-900 dark:text-white mb-12">Yetenekler</h2>
            <div class="max-w-4xl mx-auto">
                @php
                    $groupedSkills = $skills->groupBy('category');
                @endphp
                
                <div class="grid md:grid-cols-2 gap-8">
                    @foreach($groupedSkills as $category => $categorySkills)
                    <div class="card">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">{{ $category }}</h3>
                        <div class="space-y-4">
                            @foreach($categorySkills as $skill)
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-gray-700 dark:text-gray-300">{{ $skill->name }}</span>
                                    <span class="text-primary-600 dark:text-primary-400 font-medium">{{ $skill->proficiency }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="bg-primary-600 h-2 rounded-full transition-all duration-500" style="width: {{ $skill->proficiency }}%"></div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Featured Projects Section -->
    @if($featuredProjects->count() > 0)
    <section id="projects" class="py-20 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Öne Çıkan Projeler</h2>
                <p class="text-gray-600 dark:text-gray-400">Son çalışmalarımdan bazıları</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($featuredProjects as $project)
                <div class="card hover:scale-105">
                    @if($project->image)
                    <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}" class="w-full h-48 object-cover rounded-lg mb-4">
                    @else
                    <div class="w-full h-48 bg-gradient-to-br from-primary-400 to-primary-600 rounded-lg mb-4 flex items-center justify-center">
                        <span class="text-4xl text-white font-bold">{{ substr($project->title, 0, 1) }}</span>
                    </div>
                    @endif
                    
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">{{ $project->title }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">{{ Str::limit($project->description, 100) }}</p>
                    
                    <div class="flex flex-wrap gap-2 mb-4">
                        @foreach($project->technologies as $tech)
                        <span class="px-3 py-1 bg-primary-100 dark:bg-primary-900 text-primary-600 dark:text-primary-400 rounded-full text-sm">{{ $tech }}</span>
                        @endforeach
                    </div>
                    
                    <div class="flex gap-4">
                        @if($project->demo_url)
                        <a href="{{ $project->demo_url }}" target="_blank" class="text-primary-600 dark:text-primary-400 hover:underline text-sm">Demo</a>
                        @endif
                        @if($project->github_url)
                        <a href="{{ $project->github_url }}" target="_blank" class="text-primary-600 dark:text-primary-400 hover:underline text-sm">GitHub</a>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="text-center mt-12">
                <a href="{{ route('projects') }}" class="btn-primary inline-block">Tüm Projeleri Gör</a>
            </div>
        </div>
    </section>
    @endif

    <!-- Contact CTA -->
    <section id="contact" class="py-20 bg-gradient-to-br from-primary-600 to-primary-800">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold text-white mb-4">Birlikte Çalışalım</h2>
            <p class="text-xl text-primary-100 mb-8">Bir projeniz mi var? Benimle iletişime geçin!</p>
            <a href="{{ route('contact') }}" class="inline-block bg-white text-primary-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                İletişime Geç
            </a>
        </div>
    </section>
@endsection
