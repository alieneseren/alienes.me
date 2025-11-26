@extends('layouts.admin')
@section('title', isset($education) ? 'Eğitim Düzenle' : 'Yeni Eğitim Ekle')
@section('content')
<h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">{{ isset($education) ? 'Eğitim Düzenle' : 'Yeni Eğitim Ekle' }}</h1>
<div class="card">
    <form action="{{ isset($education) ? route('admin.educations.update', $education) : route('admin.educations.store') }}" method="POST">
        @csrf
        @if(isset($education)) @method('PUT') @endif
        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Okul *</label>
                <input type="text" name="school" value="{{ old('school', $education->school ?? '') }}" required class="input-field">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Derece *</label>
                <input type="text" name="degree" value="{{ old('degree', $education->degree ?? '') }}" required class="input-field">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Bölüm *</label>
                <input type="text" name="field_of_study" value="{{ old('field_of_study', $education->field_of_study ?? '') }}" required class="input-field">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Başlangıç *</label>
                <input type="date" name="start_date" value="{{ old('start_date', isset($education) ? $education->start_date->format('Y-m-d') : '') }}" required class="input-field">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Bitiş</label>
                <input type="date" name="end_date" value="{{ old('end_date', isset($education) ? $education->end_date?->format('Y-m-d') : '') }}" class="input-field">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">GPA</label>
                <input type="number" step="0.01" name="gpa" value="{{ old('gpa', $education->gpa ?? '') }}" class="input-field">
            </div>
            <div class="flex items-center">
                <input type="checkbox" name="is_current" value="1" {{ old('is_current', $education->is_current ?? false) ? 'checked' : '' }} class="mr-2">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Devam Ediyor</label>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sıra</label>
                <input type="number" name="order" value="{{ old('order', $education->order ?? 0) }}" class="input-field">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Açıklama</label>
                <textarea name="description" rows="3" class="input-field">{{ old('description', $education->description ?? '') }}</textarea>
            </div>
        </div>
        <div class="mt-6 flex gap-4">
            <button type="submit" class="btn-primary">{{ isset($education) ? 'Güncelle' : 'Kaydet' }}</button>
            <a href="{{ route('admin.educations.index') }}" class="btn-secondary">İptal</a>
        </div>
    </form>
</div>
@endsection
