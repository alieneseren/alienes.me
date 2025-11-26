@extends('layouts.admin')

@section('title', isset($cv) ? 'CV Düzenle' : 'Yeni CV Oluştur')

@section('content')
<div class="container mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">{{ isset($cv) ? 'CV Düzenle' : 'Yeni CV Oluştur' }}</h1>
    </div>

    <form action="{{ isset($cv) ? route('admin.cv.update', $cv) : route('admin.cv.store') }}" method="POST">
        @csrf
        @if(isset($cv))
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Sol Kolon: Kişisel Bilgiler -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="p-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 rounded-t-xl">
                        <h6 class="font-semibold text-sky-600 dark:text-sky-400">Kişisel Bilgiler</h6>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">CV Başlığı</label>
                            <input type="text" name="title" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500" value="{{ old('title', $cv->title ?? '') }}" placeholder="Örn: Yazılım Mühendisi">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ad Soyad</label>
                            <input type="text" name="name" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500" value="{{ old('name', $cv->name ?? '') }}" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">E-posta</label>
                            <input type="email" name="email" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500" value="{{ old('email', $cv->email ?? '') }}" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Telefon</label>
                            <input type="text" name="phone" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500 transition-colors duration-200" value="{{ old('phone', $cv->phone ?? '') }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Adres</label>
                            <textarea name="address" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500 transition-colors duration-200" rows="2">{{ old('address', $cv->address ?? '') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Özet / Hakkımda</label>
                            <textarea name="summary" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500 transition-colors duration-200" rows="4">{{ old('summary', $cv->summary ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Sosyal Medya -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="p-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 rounded-t-xl">
                        <h6 class="font-semibold text-sky-600 dark:text-sky-400">Sosyal Medya</h6>
                    </div>
                    <div class="p-6 space-y-4" id="social-container">
                        @php $socials = old('social_links', $cv->social_links ?? []); @endphp
                        @foreach($socials as $index => $social)
                        <div class="social-item pb-4 border-b border-gray-100 dark:border-gray-700 last:border-0">
                            <input type="text" name="social_links[{{$index}}][platform]" class="w-full px-4 py-2 mb-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500" placeholder="Platform (LinkedIn)" value="{{ $social['platform'] ?? '' }}">
                            <input type="text" name="social_links[{{$index}}][url]" class="w-full px-4 py-2 mb-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500" placeholder="URL" value="{{ $social['url'] ?? '' }}">
                            <button type="button" class="text-sm text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 remove-item">Sil</button>
                        </div>
                        @endforeach
                    </div>
                    <div class="p-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 rounded-b-xl">
                        <button type="button" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-lg text-sm font-medium transition-colors" onclick="addItem('social')">+ Ekle</button>
                    </div>
                </div>
            </div>

            <!-- Sağ Kolon: Detaylar -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Deneyim -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="p-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 rounded-t-xl">
                        <h6 class="font-semibold text-sky-600 dark:text-sky-400">İş Deneyimi</h6>
                    </div>
                    <div class="p-6 space-y-4" id="experience-container">
                        @php $experiences = old('experience', $cv->experience ?? []); @endphp
                        @foreach($experiences as $index => $exp)
                        <div class="experience-item p-4 border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-800/50">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <input type="text" name="experience[{{$index}}][company]" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500" placeholder="Şirket" value="{{ $exp['company'] ?? '' }}">
                                <input type="text" name="experience[{{$index}}][position]" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500" placeholder="Pozisyon" value="{{ $exp['position'] ?? '' }}">
                                <div class="md:col-span-2">
                                    <input type="text" name="experience[{{$index}}][date]" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500" placeholder="Tarih Aralığı (2020 - 2023)" value="{{ $exp['date'] ?? '' }}">
                                </div>
                                <div class="md:col-span-2">
                                    <textarea name="experience[{{$index}}][description]" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500" placeholder="Açıklama" rows="2">{{ $exp['description'] ?? '' }}</textarea>
                                </div>
                            </div>
                            <button type="button" class="text-sm text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 remove-item">Sil</button>
                        </div>
                        @endforeach
                    </div>
                    <div class="p-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 rounded-b-xl">
                        <button type="button" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-lg text-sm font-medium transition-colors" onclick="addItem('experience')">+ Deneyim Ekle</button>
                    </div>
                </div>

                <!-- Eğitim -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="p-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 rounded-t-xl">
                        <h6 class="font-semibold text-sky-600 dark:text-sky-400">Eğitim</h6>
                    </div>
                    <div class="p-6 space-y-4" id="education-container">
                        @php $educations = old('education', $cv->education ?? []); @endphp
                        @foreach($educations as $index => $edu)
                        <div class="education-item p-4 border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-800/50">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <input type="text" name="education[{{$index}}][school]" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500" placeholder="Okul" value="{{ $edu['school'] ?? '' }}">
                                <input type="text" name="education[{{$index}}][department]" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500" placeholder="Bölüm" value="{{ $edu['department'] ?? '' }}">
                                <div class="md:col-span-2">
                                    <input type="text" name="education[{{$index}}][date]" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500" placeholder="Tarih" value="{{ $edu['date'] ?? '' }}">
                                </div>
                            </div>
                            <button type="button" class="text-sm text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 remove-item">Sil</button>
                        </div>
                        @endforeach
                    </div>
                    <div class="p-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 rounded-b-xl">
                        <button type="button" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-lg text-sm font-medium transition-colors" onclick="addItem('education')">+ Eğitim Ekle</button>
                    </div>
                </div>

                <!-- Yetenekler -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="p-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 rounded-t-xl">
                        <h6 class="font-semibold text-sky-600 dark:text-sky-400">Yetenekler</h6>
                    </div>
                    <div class="p-6 space-y-4" id="skills-container">
                        @php $skills = old('skills', $cv->skills ?? []); @endphp
                        @foreach($skills as $index => $skill)
                        <div class="skill-item flex gap-2">
                            <input type="text" name="skills[{{$index}}]" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500" placeholder="Yetenek (PHP, Laravel...)" value="{{ $skill }}">
                            <button type="button" class="px-3 py-2 bg-red-100 text-red-600 hover:bg-red-200 rounded-lg transition-colors remove-item">Sil</button>
                        </div>
                        @endforeach
                    </div>
                    <div class="p-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 rounded-b-xl">
                        <button type="button" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-lg text-sm font-medium transition-colors" onclick="addItem('skills')">+ Yetenek Ekle</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 flex justify-end">
            <button type="submit" class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl font-bold shadow-lg shadow-green-600/20 transition-all transform hover:-translate-y-1">
                <i class="fas fa-save mr-2"></i> Kaydet
            </button>
        </div>
    </form>
</div>

<script>
    function addItem(type) {
        const container = document.getElementById(type + '-container');
        const index = container.children.length;
        let html = '';

        if (type === 'experience') {
            html = `
                <div class="experience-item p-4 border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-800/50">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <input type="text" name="experience[${index}][company]" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500" placeholder="Şirket">
                        <input type="text" name="experience[${index}][position]" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500" placeholder="Pozisyon">
                        <div class="md:col-span-2">
                            <input type="text" name="experience[${index}][date]" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500" placeholder="Tarih Aralığı">
                        </div>
                        <div class="md:col-span-2">
                            <textarea name="experience[${index}][description]" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500" placeholder="Açıklama" rows="2"></textarea>
                        </div>
                    </div>
                    <button type="button" class="text-sm text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 remove-item">Sil</button>
                </div>
            `;
        } else if (type === 'education') {
            html = `
                <div class="education-item p-4 border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-800/50">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <input type="text" name="education[${index}][school]" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500" placeholder="Okul">
                        <input type="text" name="education[${index}][department]" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500" placeholder="Bölüm">
                        <div class="md:col-span-2">
                            <input type="text" name="education[${index}][date]" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500" placeholder="Tarih">
                        </div>
                    </div>
                    <button type="button" class="text-sm text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 remove-item">Sil</button>
                </div>
            `;
        } else if (type === 'skills') {
            html = `
                <div class="skill-item flex gap-2">
                    <input type="text" name="skills[${index}]" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500" placeholder="Yetenek">
                    <button type="button" class="px-3 py-2 bg-red-100 text-red-600 hover:bg-red-200 rounded-lg transition-colors remove-item">Sil</button>
                </div>
            `;
        } else if (type === 'social') {
            html = `
                <div class="social-item pb-4 border-b border-gray-100 dark:border-gray-700 last:border-0">
                    <input type="text" name="social_links[${index}][platform]" class="w-full px-4 py-2 mb-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500" placeholder="Platform">
                    <input type="text" name="social_links[${index}][url]" class="w-full px-4 py-2 mb-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sky-500" placeholder="URL">
                    <button type="button" class="text-sm text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 remove-item">Sil</button>
                </div>
            `;
        }

        container.insertAdjacentHTML('beforeend', html);
    }

    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('remove-item')) {
            e.target.closest('div[class*="-item"]').remove();
        }
    });
</script>
@endsection
