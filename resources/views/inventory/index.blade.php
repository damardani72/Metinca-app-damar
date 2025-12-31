@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Gudang Material</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Stok Material</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-boxes me-1"></i> Daftar Stok Bahan Baku
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Kode Material</th>
                        <th>Nama Material</th>
                        <th>Stok Saat Ini</th>
                        <th>Satuan</th>
                        <th>Status Stok</th>
                        <th>Update Terakhir</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($materials as $material)
                    <tr>
                        <td>{{ $material->material_code }}</td>
                        <td>{{ $material->name }}</td>
                        <td class="fw-bold">{{ $material->current_stock }}</td>
                        <td>{{ $material->unit }}</td>
                        <td>
                            {{-- Logika Warna: Merah jika stok tipis, Hijau jika aman --}}
                            @if($material->current_stock <= $material->minimum_stock)
                                <span class="badge bg-danger">Stok Menipis!</span>
                            @else
                                <span class="badge bg-success">Aman</span>
                            @endif
                        </td>
                        <td>{{ $material->updated_at->diffForHumans() }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada data material.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection