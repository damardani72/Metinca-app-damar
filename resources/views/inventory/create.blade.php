@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Input Barang Masuk</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('inventory.index') }}">Gudang</a></li>
        <li class="breadcrumb-item active">Restock Bahan Baku</li>
    </ol>

    <div class="card mb-4 mx-auto" style="max-width: 600px;">
        <div class="card-header bg-success text-white">
            <i class="fas fa-plus-circle me-1"></i> Form Penambahan Stok
        </div>
        <div class="card-body">
            <form action="{{ route('inventory.store') }}" method="POST">
                @csrf
                
                {{-- Pilihan Material --}}
                <div class="mb-3">
                    <label class="form-label">Pilih Material / Bahan Baku</label>
                    <select name="material_id" class="form-select" required>
                        <option value="">-- Pilih Material --</option>
                        @foreach($materials as $material)
                            <option value="{{ $material->id }}">
                                {{ $material->material_code }} - {{ $material->name }} (Sisa: {{ $material->current_stock }} {{ $material->unit }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Jumlah Masuk --}}
                <div class="mb-3">
                    <label class="form-label">Jumlah Masuk</label>
                    <input type="number" name="qty" class="form-control" min="1" placeholder="Masukkan jumlah..." required>
                </div>

                {{-- Tombol Simpan --}}
                <button type="submit" class="btn btn-success w-100">
                    <i class="fas fa-save me-1"></i> Tambah Stok
                </button>
            </form>
        </div>
    </div>
</div>
@endsection