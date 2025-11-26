@extends('layouts.frontend')

@section('title', 'Oyunlar - Alienes.me')
@section('meta_description', '10+ eğlenceli mini oyun. 2048, Snake, Memory Card, Flappy Bird ve daha fazlası.')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 pt-24 pb-16">
    <!-- Header -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
        <div class="text-center">
            <h1 class="text-5xl md:text-6xl font-bold text-gray-900 dark:text-white mb-6">
                🎮 <span class="bg-gradient-to-r from-primary-600 to-purple-600 bg-clip-text text-transparent">Oyun Merkezi</span>
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                Eğlenceli mini oyunlar ile vakit geçirin. Zeka, refleks ve hız testlerinizi yapın!
            </p>
            <div class="mt-8 flex flex-wrap justify-center gap-4 text-lg">
                <div class="flex items-center gap-2 text-gray-700 dark:text-gray-300">
                    <span class="text-2xl">🎯</span>
                    <span>10 Oyun</span>
                </div>
                <div class="flex items-center gap-2 text-gray-700 dark:text-gray-300">
                    <span class="text-2xl">⚡</span>
                    <span>Hızlı & Eğlenceli</span>
                </div>
                <div class="flex items-center gap-2 text-gray-700 dark:text-gray-300">
                    <span class="text-2xl">📱</span>
                    <span>Mobil Uyumlu</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Games Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <!-- 2048 -->
            <div class="group bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:scale-105">
                <div class="bg-gradient-to-br from-sky-400 to-blue-600 p-8 text-center">
                    <div class="text-6xl mb-4 transform group-hover:scale-110 transition-transform duration-300">🔢</div>
                    <h3 class="text-2xl font-bold text-white">2048</h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Karoları birleştirerek 2048 sayısına ulaşmaya çalışın!</p>
                    <div class="flex gap-2 mb-4 flex-wrap">
                        <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 rounded-full text-sm">Zeka</span>
                        <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300 rounded-full text-sm">Strateji</span>
                    </div>
                    <a href="https://games.alienes.me/2048.html" class="block w-full bg-gradient-to-r from-sky-400 to-blue-600 text-white text-center py-3 rounded-lg font-semibold hover:opacity-90 transition">
                        🎮 Oyna
                    </a>
                </div>
            </div>

            <!-- Snake -->
            <div class="group bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:scale-105">
                <div class="bg-gradient-to-br from-green-400 to-emerald-600 p-8 text-center">
                    <div class="text-6xl mb-4 transform group-hover:scale-110 transition-transform duration-300">🐍</div>
                    <h3 class="text-2xl font-bold text-white">Snake</h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Klasik yılan oyunu. Elmaları yiyin ve büyüyün!</p>
                    <div class="flex gap-2 mb-4 flex-wrap">
                        <span class="px-3 py-1 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded-full text-sm">Klasik</span>
                        <span class="px-3 py-1 bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-300 rounded-full text-sm">Refleks</span>
                    </div>
                    <a href="https://games.alienes.me/snake.html" class="block w-full bg-gradient-to-r from-green-400 to-emerald-600 text-white text-center py-3 rounded-lg font-semibold hover:opacity-90 transition">
                        🎮 Oyna
                    </a>
                </div>
            </div>

            <!-- Flappy Bird -->
            <div class="group bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:scale-105">
                <div class="bg-gradient-to-br from-cyan-400 to-blue-500 p-8 text-center">
                    <div class="text-6xl mb-4 transform group-hover:scale-110 transition-transform duration-300">🐦</div>
                    <h3 class="text-2xl font-bold text-white">Flappy Bird</h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Kuşu uçurun ve borulardan geçmeye çalışın!</p>
                    <div class="flex gap-2 mb-4 flex-wrap">
                        <span class="px-3 py-1 bg-cyan-100 dark:bg-cyan-900 text-cyan-700 dark:text-cyan-300 rounded-full text-sm">Arcade</span>
                        <span class="px-3 py-1 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 rounded-full text-sm">Zorlayıcı</span>
                    </div>
                    <a href="https://games.alienes.me/flappy-bird.html" class="block w-full bg-gradient-to-r from-cyan-400 to-blue-500 text-white text-center py-3 rounded-lg font-semibold hover:opacity-90 transition">
                        🎮 Oyna
                    </a>
                </div>
            </div>

            <!-- Memory Card -->
            <div class="group bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:scale-105">
                <div class="bg-gradient-to-br from-purple-400 to-indigo-600 p-8 text-center">
                    <div class="text-6xl mb-4 transform group-hover:scale-110 transition-transform duration-300">🧠</div>
                    <h3 class="text-2xl font-bold text-white">Memory Card</h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Eşleşen kartları bulun ve hafızanızı test edin!</p>
                    <div class="flex gap-2 mb-4 flex-wrap">
                        <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300 rounded-full text-sm">Hafıza</span>
                        <span class="px-3 py-1 bg-pink-100 dark:bg-pink-900 text-pink-700 dark:text-pink-300 rounded-full text-sm">Eğlenceli</span>
                    </div>
                    <a href="https://games.alienes.me/memory-card.html" class="block w-full bg-gradient-to-r from-purple-400 to-indigo-600 text-white text-center py-3 rounded-lg font-semibold hover:opacity-90 transition">
                        🎮 Oyna
                    </a>
                </div>
            </div>

            <!-- Tic Tac Toe -->
            <div class="group bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:scale-105">
                <div class="bg-gradient-to-br from-amber-400 to-orange-600 p-8 text-center">
                    <div class="text-6xl mb-4 transform group-hover:scale-110 transition-transform duration-300">⭕</div>
                    <h3 class="text-2xl font-bold text-white">Tic Tac Toe</h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-600 dark:text-gray-400 mb-4">XOX oyunu. Bilgisayara karşı veya iki oyuncu!</p>
                    <div class="flex gap-2 mb-4 flex-wrap">
                        <span class="px-3 py-1 bg-orange-100 dark:bg-orange-900 text-orange-700 dark:text-orange-300 rounded-full text-sm">Strateji</span>
                        <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 rounded-full text-sm">2 Oyuncu</span>
                    </div>
                    <a href="https://games.alienes.me/tic-tac-toe.html" class="block w-full bg-gradient-to-r from-amber-400 to-orange-600 text-white text-center py-3 rounded-lg font-semibold hover:opacity-90 transition">
                        🎮 Oyna
                    </a>
                </div>
            </div>

            <!-- Quiz -->
            <div class="group bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:scale-105">
                <div class="bg-gradient-to-br from-teal-400 to-cyan-600 p-8 text-center">
                    <div class="text-6xl mb-4 transform group-hover:scale-110 transition-transform duration-300">❓</div>
                    <h3 class="text-2xl font-bold text-white">Quiz</h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Programlama bilginizi test edin! 10 soru.</p>
                    <div class="flex gap-2 mb-4 flex-wrap">
                        <span class="px-3 py-1 bg-teal-100 dark:bg-teal-900 text-teal-700 dark:text-teal-300 rounded-full text-sm">Eğitim</span>
                        <span class="px-3 py-1 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded-full text-sm">Bilgi</span>
                    </div>
                    <a href="https://games.alienes.me/quiz.html" class="block w-full bg-gradient-to-r from-teal-400 to-cyan-600 text-white text-center py-3 rounded-lg font-semibold hover:opacity-90 transition">
                        🎮 Oyna
                    </a>
                </div>
            </div>

            <!-- Breakout -->
            <div class="group bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:scale-105">
                <div class="bg-gradient-to-br from-indigo-400 to-purple-600 p-8 text-center">
                    <div class="text-6xl mb-4 transform group-hover:scale-110 transition-transform duration-300">🧱</div>
                    <h3 class="text-2xl font-bold text-white">Breakout</h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Tuğlaları kırın! Klasik brick breaker oyunu.</p>
                    <div class="flex gap-2 mb-4 flex-wrap">
                        <span class="px-3 py-1 bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300 rounded-full text-sm">Arcade</span>
                        <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300 rounded-full text-sm">Klasik</span>
                    </div>
                    <a href="https://games.alienes.me/breakout.html" class="block w-full bg-gradient-to-r from-indigo-400 to-purple-600 text-white text-center py-3 rounded-lg font-semibold hover:opacity-90 transition">
                        🎮 Oyna
                    </a>
                </div>
            </div>

            <!-- Color Matcher -->
            <div class="group bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:scale-105">
                <div class="bg-gradient-to-br from-pink-400 to-fuchsia-600 p-8 text-center">
                    <div class="text-6xl mb-4 transform group-hover:scale-110 transition-transform duration-300">🎨</div>
                    <h3 class="text-2xl font-bold text-white">Color Matcher</h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-600 dark:text-gray-400 mb-4">RGB değerlerini ayarlayarak rengi eşleştirin!</p>
                    <div class="flex gap-2 mb-4 flex-wrap">
                        <span class="px-3 py-1 bg-pink-100 dark:bg-pink-900 text-pink-700 dark:text-pink-300 rounded-full text-sm">Yaratıcı</span>
                        <span class="px-3 py-1 bg-fuchsia-100 dark:bg-fuchsia-900 text-fuchsia-700 dark:text-fuchsia-300 rounded-full text-sm">Eğitici</span>
                    </div>
                    <a href="https://games.alienes.me/color-matcher.html" class="block w-full bg-gradient-to-r from-pink-400 to-fuchsia-600 text-white text-center py-3 rounded-lg font-semibold hover:opacity-90 transition">
                        🎮 Oyna
                    </a>
                </div>
            </div>

            <!-- Typing Speed Test -->
            <div class="group bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:scale-105">
                <div class="bg-gradient-to-br from-purple-500 to-purple-700 p-8 text-center">
                    <div class="text-6xl mb-4 transform group-hover:scale-110 transition-transform duration-300">⌨️</div>
                    <h3 class="text-2xl font-bold text-white">Typing Speed</h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Yazma hızınızı ve doğruluğunuzu test edin!</p>
                    <div class="flex gap-2 mb-4 flex-wrap">
                        <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300 rounded-full text-sm">Eğitici</span>
                        <span class="px-3 py-1 bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300 rounded-full text-sm">Hız</span>
                    </div>
                    <a href="https://games.alienes.me/typing-speed.html" class="block w-full bg-gradient-to-r from-purple-500 to-purple-700 text-white text-center py-3 rounded-lg font-semibold hover:opacity-90 transition">
                        🎮 Oyna
                    </a>
                </div>
            </div>

            <!-- Math Quiz -->
            <div class="group bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:scale-105">
                <div class="bg-gradient-to-br from-orange-400 to-orange-600 p-8 text-center">
                    <div class="text-6xl mb-4 transform group-hover:scale-110 transition-transform duration-300">🔢</div>
                    <h3 class="text-2xl font-bold text-white">Math Quiz</h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Matematik becerilerini hızla test et!</p>
                    <div class="flex gap-2 mb-4 flex-wrap">
                        <span class="px-3 py-1 bg-orange-100 dark:bg-orange-900 text-orange-700 dark:text-orange-300 rounded-full text-sm">Matematik</span>
                        <span class="px-3 py-1 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 rounded-full text-sm">Eğitici</span>
                    </div>
                    <a href="https://games.alienes.me/math-quiz.html" class="block w-full bg-gradient-to-r from-orange-400 to-orange-600 text-white text-center py-3 rounded-lg font-semibold hover:opacity-90 transition">
                        🎮 Oyna
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-20">
        <div class="bg-gradient-to-r from-primary-600 to-purple-600 rounded-3xl overflow-hidden shadow-xl">
            <div class="px-6 py-16 sm:px-12 text-center">
                <h2 class="text-4xl font-bold text-white mb-8">🎉 Eğlenceye Katıl!</h2>
                <p class="text-xl text-white/90 mb-12 max-w-2xl mx-auto">
                    10 farklı oyun ile vakit geçirin. Skorlarınızı yükseltin ve eğlenin!
                </p>
                <div class="grid grid-cols-3 gap-8 max-w-md mx-auto">
                    <div>
                        <div class="text-4xl font-bold text-white mb-2">10</div>
                        <div class="text-white/80">Oyun</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold text-white mb-2">♾️</div>
                        <div class="text-white/80">Sınırsız Oynan</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold text-white mb-2">🚀</div>
                        <div class="text-white/80">Hızlı Yükleme</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(isset($profile) && $profile && $profile->github_username)
<style>
    .dark body {
        color-scheme: dark;
    }
</style>
@endif
@endsection
