<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Girişi - Alienes.me</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-primary-600 to-primary-800 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full px-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-2xl p-8">
            <h1 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-8">Admin Girişi</h1>
            @if($errors->any())
            <div class="mb-6 p-4 bg-red-100 dark:bg-red-900 border border-red-400 text-red-700 dark:text-red-300 rounded-lg">
                @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
                @endforeach
            </div>
            @endif
            @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 dark:bg-green-900 border border-green-400 text-green-700 dark:text-green-300 rounded-lg">
                {{ session('success') }}
            </div>
            @endif
            <form action="{{ route('admin.login.post') }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="input-field">
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Şifre</label>
                    <input type="password" name="password" required class="input-field">
                </div>
                <button type="submit" class="btn-primary w-full">Giriş Yap</button>
            </form>
            <div class="mt-6 text-center">
                <a href="{{ route('home') }}" class="text-sm text-primary-600 dark:text-primary-400 hover:underline">← Ana Sayfaya Dön</a>
            </div>
        </div>
    </div>
</body>
</html>
