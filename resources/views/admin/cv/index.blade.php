@extends('layouts.admin')

@section('title', 'CV Yönetimi')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">CV Listesi</h1>
        <a href="{{ route('admin.cv.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Yeni CV Oluştur
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Başlık</th>
                            <th>İsim</th>
                            <th>Durum</th>
                            <th>Oluşturulma</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cvs as $cv)
                        <tr>
                            <td>{{ $cv->title }}</td>
                            <td>{{ $cv->name }}</td>
                            <td>
                                @if($cv->is_published)
                                    <span class="badge badge-success">Yayında</span>
                                @else
                                    <span class="badge badge-secondary">Taslak</span>
                                @endif
                            </td>
                            <td>{{ $cv->created_at->format('d.m.Y') }}</td>
                            <td>
                                <form action="{{ route('admin.cv.publish', $cv) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $cv->is_published ? 'btn-warning' : 'btn-success' }}">
                                        {{ $cv->is_published ? 'Yayından Kaldır' : 'Yayınla' }}
                                    </button>
                                </form>
                                <a href="{{ route('admin.cv.edit', $cv) }}" class="btn btn-sm btn-info">Düzenle</a>
                                <form action="{{ route('admin.cv.destroy', $cv) }}" method="POST" class="d-inline" onsubmit="return confirm('Emin misiniz?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Sil</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Henüz CV oluşturulmamış.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
