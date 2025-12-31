@extends('layouts.app')

@section('page-title', 'Gudang Material')

@section('content')
<div class="container-fluid">
    
    {{-- Notifikasi --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row">
        {{-- BAGIAN KIRI: TABEL STOK --}}
        <div class="col-md-8">
            <div class="card shadow-sm border-top-primary">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-primary"><i class="fas fa-boxes me-2"></i>Cek Stok Material</h5>
                    <a href="{{ route('materials.incoming') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-arrow-down me-1"></i> Input Barang Masuk
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama Material</th>
                                    <th class="text-center">Stok Saat Ini</th>
                                    <th class="text-center">Batas Minimum</th>
                                    <th class="text-center">Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($materials as $item)
                                {{-- Logika Warna: Merah jika stok menipis --}}
                                <tr class="{{ $item->current_stock <= $item->minimum_stock ? 'table-danger' : '' }}">
                                    <td class="fw-bold">{{ $item->material_code }}</td>
                                    <td>
                                        {{ $item->name }}<br>
                                        <small class="text-muted">{{ $item->description }}</small>
                                    </td>
                                    <td class="text-center fw-bold fs-5">
                                        {{ $item->current_stock }} <span class="fs-6 text-muted">{{ $item->unit }}</span>
                                    </td>
                                    <td class="text-center text-muted">
                                        {{ $item->minimum_stock }} {{ $item->unit }}
                                    </td>
                                    <td class="text-center">
                                        @if($item->current_stock <= $item->minimum_stock)
                                            <span class="badge bg-danger">KRITIS!</span>
                                        @else
                                            <span class="badge bg-success">Aman</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('materials.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus material ini?');">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-link text-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="6" class="text-center text-muted">Belum ada data material.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- BAGIAN KANAN: FORM TAMBAH MASTER DATA --}}
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <i class="fas fa-plus-circle me-1"></i> Registrasi Material Baru
                </div>
                <div class="card-body">
                    <form action="{{ route('materials.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label>Kode Material</label>
                            <input type="text" name="material_code" class="form-control" placeholder="Contoh: MAT-001" required>
                        </div>
                        <div class="mb-3">
                            <label>Nama Material</label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: Plat Besi 5mm" required>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label>Satuan</label>
                                <select name="unit" class="form-select">
                                    <option value="Pcs">Pcs</option>
                                    <option value="Kg">Kg</option>
                                    <option value="Lembar">Lembar</option>
                                    <option value="Meter">Meter</option>
                                    <option value="Liter">Liter</option>
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label>Min. Stok</label>
                                <input type="number" name="minimum_stock" class="form-control" value="10">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Keterangan</label>
                            <textarea name="description" class="form-control" rows="2"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Simpan Data Master</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection