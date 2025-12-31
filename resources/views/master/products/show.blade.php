@extends('layouts.app')

@section('page-title', 'Detail Produk')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-info text-white">
            <i class="fas fa-eye me-1"></i> Detail Informasi Produk
        </div>
        <div class="card-body">
            <div class="row">
                {{-- Bagian Kiri: Informasi Utama --}}
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">Nama Produk</th>
                            <td>: <strong>{{ $product->name }}</strong></td>
                        </tr>
                        <tr>
                            <th>Part Number</th>
                            <td>: {{ $product->part_number ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Material</th>
                            <td>: {{ $product->material ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Berat</th>
                            <td>: {{ $product->weight }} Kg</td>
                        </tr>
                        <tr>
                            <th>Harga</th>
                            <td>: Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </div>

                {{-- Bagian Kanan: Informasi Tambahan --}}
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="fw-bold">Deskripsi / Spesifikasi:</label>
                        <p class="text-muted border p-2 rounded" style="background-color: #f8f9fa;">
                            {{ $product->description ?? 'Tidak ada deskripsi.' }}
                        </p>
                    </div>
                    <div class="text-muted small">
                        <i class="fas fa-calendar-alt me-1"></i> Dibuat: {{ $product->created_at->format('d M Y H:i') }}<br>
                        <i class="fas fa-pen me-1"></i> Update: {{ $product->updated_at->format('d M Y H:i') }}
                    </div>
                </div>
            </div>

            <hr>

            <div class="d-flex justify-content-between">
                <a href="{{ route('master.products.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
                <div>
                    {{-- Tombol Edit Langsung dari Halaman Detail --}}
                    <a href="{{ route('master.products.edit', $product->id) }}" class="btn btn-warning text-dark">
                        <i class="fas fa-edit me-1"></i> Edit Data
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection