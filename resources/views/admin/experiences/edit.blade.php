@extends('layouts.admin')
@section('title', 'Deneyim Düzenle')
@section('content')
<h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Deneyim Düzenle</h1>
<div class="card">
    <form action="{{ route('admin.experiences.update', $experience) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Şirket *</label>
                <input type="text" name="company" value="{{ old('company', $experience->company) }}" required class="input-field">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Pozisyon *</label>
                <input type="text" name="position" value="{{ old('position', $experience->position) }}" required class="input-field">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Konum</label>
                <input type="text" name="location" value="{{ old('location', $experience->location) }}" class="input-field">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Başlangıç Tarihi *</label>
                <input type="date" name="start_date" value="{{ old('start_date', $experience->start_date->format('Y-m-d')) }}" required class="input-field">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Bitiş Tarihi</label>
                <input type="date" name="end_date" value="{{ old('end_date', $experience->end_date?->format('Y-m-d')) }}" class="input-field">
            </div>
            <div class="flex items-center">
                <input type="checkbox" name="is_current" value="1" {{ old('is_current', $experience->is_current) ? 'checked' : '' }} class="mr-2">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Devam Ediyor</label>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Açıklama *</label>
                <textarea name="description" rows="5" required class="input-field">{{ old('description', $experience->description) }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sıra</label>
                <input type="number" name="order" value="{{ old('order', $experience->order) }}" class="input-field">
            </div>
        </div>
        <div class="mt-6 flex gap-4">
            <button type="submit" class="btn-primary">Güncelle</button>
            <a href="{{ route('admin.experiences.index') }}" class="btn-secondary">İptal</a>
        </div>
    </form>
</div>
@endsection
