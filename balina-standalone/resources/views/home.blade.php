@extends('layouts.frontend')

@section('title', 'Ana Sayfa - Alienes.me')
@section('meta_description', 'Ali Enes kişisel portfolyo ve özgeçmiş sitesi')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-screen flex items-center justify-center bg-gradient-to-br from-primary-50 to-white dark:from-gray-900 dark:to-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <!-- Left Content -->
            <div class="text-center md:text-left">
                <h1 class="text-5xl md:text-6xl font-bold text-gray-900 dark:text-white mb-6">
                    Merhaba, Ben <span class="text-primary-600 dark:text-primary-400">{{ $profile->full_name ?? 'Ali Enes' }}</span>
                </h1>
                <p class="text-xl md:text-2xl text-gray-600 dark:text-gray-300 mb-8">
                    {{ $profile->title ?? 'Full Stack Developer' }}
                </p>
                <p class="text-lg text-gray-600 dark:text-gray-400 mb-8">
                    {{ $profile->bio ?? 'Yazılım geliştirme ve teknoloji alanında uzmanlaşmış bir profesyonelim.' }}
                </p>
                <div class="flex flex-wrap gap-4 justify-center md:justify-start">
                    <a href="#projects" class="btn-primary">
                        Projelerim
                    </a>
                    <a href="{{ route('contact') }}" class="btn-secondary">
                        İletişime Geç
                    </a>
                </div>
            </div>

            <!-- Right Image -->
            <div class="flex justify-center">
                <div class="relative">
                    @if($profile && $profile->profile_image)
                        <img src="{{ asset('storage/' . $profile->profile_image) }}" 
                             alt="{{ $profile->full_name }}" 
                             class="w-80 h-80 object-cover rounded-full shadow-2xl border-8 border-white dark:border-gray-800">
                    @elseif($profile && $profile->github_avatar_url)
                        <img src="{{ $profile->github_avatar_url }}" 
                             alt="{{ $profile->full_name }}" 
                             class="w-80 h-80 object-cover rounded-full shadow-2xl border-8 border-white dark:border-gray-800">
                    @else
                        <div class="w-80 h-80 bg-gradient-to-br from-primary-400 to-primary-600 rounded-full shadow-2xl border-8 border-white dark:border-gray-800 flex items-center justify-center">
                            <span class="text-8xl font-bold text-white">AE</span>
                        </div>
                    @endif
                    
                    <!-- GitHub Badge -->
                    @if($profile && $profile->github_username)
                    <a href="https://github.com/{{ $profile->github_username }}" 
                       target="_blank"
                       rel="noopener noreferrer" 
                       class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 bg-white dark:bg-gray-800 text-gray-900 dark:text-white px-5 py-2.5 rounded-full shadow-xl hover:shadow-2xl transition-all duration-300 flex items-center gap-2 border-2 border-gray-200 dark:border-gray-700 hover:border-primary-500 dark:hover:border-primary-400 group">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                        </svg>
                        <span class="text-sm font-semibold">{{ $profile->github_username }}</span>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scroll Down Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <a href="#about" class="text-gray-400 hover:text-primary-600 dark:hover:text-primary-400">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </a>
    </div>
</section>

<!-- About Section -->
<section id="about" class="py-20 bg-white dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Hakkımda</h2>
            <div class="w-20 h-1 bg-primary-600 mx-auto"></div>
        </div>
        
        @if($profile)
        <div class="max-w-3xl mx-auto">
            <p class="text-lg text-gray-600 dark:text-gray-300 mb-8 leading-relaxed">
                {{ $profile->about }}
            </p>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @if($profile->email)
                <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Email</p>
                    <p class="font-semibold text-gray-900 dark:text-white">{{ $profile->email }}</p>
                </div>
                @endif
                
                @if($profile->phone)
                <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Telefon</p>
                    <p class="font-semibold text-gray-900 dark:text-white">{{ $profile->phone }}</p>
                </div>
                @endif
                
                @if($profile->location)
                <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Konum</p>
                    <p class="font-semibold text-gray-900 dark:text-white">{{ $profile->location }}</p>
                </div>
                @endif
                
                @if($profile->birth_date)
                <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Yaş</p>
                    <p class="font-semibold text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($profile->birth_date)->age }}</p>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</section>

<!-- Experience Section -->
@if($experiences->count() > 0)
<section id="experience" class="py-20 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">İş Deneyimlerim</h2>
            <div class="w-20 h-1 bg-primary-600 mx-auto"></div>
        </div>
        
        <div class="max-w-4xl mx-auto">
            @foreach($experiences as $experience)
            <div class="mb-8 relative pl-8 border-l-4 border-primary-600 dark:border-primary-400">
                <div class="absolute -left-3 top-0 w-6 h-6 bg-primary-600 dark:bg-primary-400 rounded-full"></div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $experience->position }}</h3>
                    <p class="text-lg text-primary-600 dark:text-primary-400 font-semibold mb-2">{{ $experience->company }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                        {{ $experience->start_date->format('M Y') }} - 
                        @if($experience->is_current)
                            Devam Ediyor
                        @else
                            {{ $experience->end_date->format('M Y') }}
                        @endif
                    </p>
                    @if($experience->description)
                    <p class="text-gray-600 dark:text-gray-300">{{ $experience->description }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Education Section -->
@if($educations->count() > 0)
<section id="education" class="py-20 bg-white dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Eğitim</h2>
            <div class="w-20 h-1 bg-primary-600 mx-auto"></div>
        </div>
        
        <div class="max-w-4xl mx-auto grid md:grid-cols-2 gap-6">
            @foreach($educations as $education)
            <div class="bg-gray-50 dark:bg-gray-900 p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $education->school }}</h3>
                <p class="text-primary-600 dark:text-primary-400 font-semibold mb-2">{{ $education->degree }} - {{ $education->field_of_study }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                    {{ $education->start_date->format('Y') }} - 
                    @if($education->is_current)
                        Devam Ediyor
                    @else
                        {{ $education->end_date->format('Y') }}
                    @endif
                </p>
                @if($education->gpa)
                <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">GPA: {{ $education->gpa }}</p>
                @endif
                @if($education->description)
                <p class="text-gray-600 dark:text-gray-300 text-sm">{{ $education->description }}</p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Skills Section -->
@if($skills->count() > 0)
<section id="skills" class="py-20 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Yeteneklerim</h2>
            <div class="w-20 h-1 bg-primary-600 mx-auto"></div>
        </div>
        
        @php
            $groupedSkills = $skills->groupBy('category');
        @endphp
        
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($groupedSkills as $category => $categorySkills)
            <div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">{{ $category }}</h3>
                <div class="space-y-4">
                    @foreach($categorySkills as $skill)
                    <div>
                        <div class="flex justify-between mb-1">
                            <span class="text-gray-700 dark:text-gray-300">{{ $skill->name }}</span>
                            <span class="text-gray-500 dark:text-gray-400">{{ $skill->proficiency }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-primary-600 dark:bg-primary-400 h-2 rounded-full" style="width: {{ $skill->proficiency }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Projects Section -->
@if($projects->count() > 0)
<section id="projects" class="py-20 bg-white dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Öne Çıkan Projeler</h2>
            <div class="w-20 h-1 bg-primary-600 mx-auto"></div>
        </div>
        
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
                    <p class="text-gray-600 dark:text-gray-300 mb-4">{{ Str::limit($project->description, 100) }}</p>
                    
                    @if($project->technologies)
                    <div class="flex flex-wrap gap-2 mb-4">
                        @foreach(is_array($project->technologies) ? $project->technologies : explode(',', $project->technologies) as $tech)
                        <span class="px-2 py-1 bg-primary-100 dark:bg-primary-900 text-primary-600 dark:text-primary-400 text-xs rounded">{{ trim($tech) }}</span>
                        @endforeach
                    </div>
                    @endif
                    
                    <div class="flex gap-4">
                        @if($project->demo_url)
                        <a href="{{ $project->demo_url }}" target="_blank" class="text-primary-600 dark:text-primary-400 hover:underline text-sm">Demo →</a>
                        @endif
                        @if($project->github_url)
                        <a href="{{ $project->github_url }}" target="_blank" class="text-primary-600 dark:text-primary-400 hover:underline text-sm">GitHub →</a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('projects') }}" class="btn-primary">
                Tüm Projeleri Gör
            </a>
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="py-20 bg-primary-600 dark:bg-primary-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl font-bold text-white mb-4">Birlikte Çalışalım</h2>
        <p class="text-xl text-primary-100 mb-8">Projeniz için profesyonel bir geliştirici mi arıyorsunuz?</p>
        <a href="{{ route('contact') }}" class="inline-block bg-white text-primary-600 font-semibold px-8 py-4 rounded-lg hover:bg-gray-100 transition-colors duration-300">
            İletişime Geç
        </a>
    </div>
</section>
@endsection
