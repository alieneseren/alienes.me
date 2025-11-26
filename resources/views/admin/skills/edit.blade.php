@extends('layouts.admin')
@section('title', 'Yetenek Düzenle')
@section('content')
<h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Yetenek Düzenle</h1>
<div class="card">
    <form action="{{ route('admin.skills.update', $skill) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Yetenek Adı *</label>
                <input type="text" name="name" value="{{ old('name', $skill->name) }}" required class="input-field">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kategori *</label>
                <input type="text" name="category" value="{{ old('category', $skill->category) }}" list="categories" required class="input-field">
                <datalist id="categories">
                    @foreach($categories ?? [] as $cat)
                    <option value="{{ $cat }}">
                    @endforeach
                </datalist>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Yeterlilik (0-100) *</label>
                <input type="number" name="proficiency" min="0" max="100" value="{{ old('proficiency', $skill->proficiency) }}" required class="input-field">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sıra</label>
                <input type="number" name="order" value="{{ old('order', $skill->order) }}" class="input-field">
            </div>
        </div>
        <div class="mt-6 flex gap-4">
            <button type="submit" class="btn-primary">Güncelle</button>
            <a href="{{ route('admin.skills.index') }}" class="btn-secondary">İptal</a>
        </div>
    </form>
</div>
@endsection
