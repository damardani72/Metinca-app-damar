@extends('layouts.app')

@section('page-title', 'Master Data Produk')

@section('content')
<div class="container-fluid">
    
    {{-- Error Validasi --}}
    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- Pesan Sukses --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        {{-- Form Tambah Produk (Kiri) --}}
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-plus-circle me-1"></i> Input Produk Baru
                </div>
                <div class="card-body">
                    <form action="{{ route('master.products.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Part Number (Nomor Part)</label>
                            <input type="text" name="part_number" class="form-control" placeholder="Cth: PN-001">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="Cth: Gear Box Housing" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Material</label>
                                <input type="text" name="material" class="form-control" placeholder="Cth: Steel">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Berat (KG)</label>
                                <input type="number" step="0.01" name="weight" class="form-control" placeholder="0.00">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Harga Satuan (Rp)</label>
                            <input type="number" name="price" class="form-control" placeholder="0">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description" class="form-control" rows="2"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save me-1"></i> Simpan Produk
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Tabel Daftar Produk (Kanan) --}}
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-box me-1"></i> Daftar Produk
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Part No</th>
                                    <th>Nama Produk</th>
                                    <th>Material</th>
                                    <th>Berat (Kg)</th>
                                    <th class="text-center" width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                <tr>
                                    <td>{{ $product->part_number ?? '-' }}</td>
                                    <td class="fw-bold">{{ $product->name }}</td>
                                    <td>{{ $product->material ?? '-' }}</td>
                                    <td>{{ $product->weight }} Kg</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            {{-- 1. TOMBOL DETAIL (BARU) --}}
                                            <a href="{{ route('master.products.show', $product->id) }}" class="btn btn-info btn-sm text-white" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            {{-- 2. TOMBOL EDIT --}}
                                            <a href="{{ route('master.products.edit', $product->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            {{-- 3. TOMBOL HAPUS --}}
                                            <form onsubmit="return confirm('Hapus produk ini?');" action="{{ route('master.products.destroy', $product->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="fas fa-box-open fa-2x mb-2 text-secondary"></i><br>
                                        Belum ada data produk. Silakan tambah di form sebelah kiri.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection