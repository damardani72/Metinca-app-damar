@extends('layouts.app')

@section('page-title', 'Edit Produk')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-warning text-dark">
            <i class="fas fa-edit me-1"></i> Form Edit Produk
        </div>
        <div class="card-body">
            <form action="{{ route('master.products.update', $product->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Wajib untuk Update Data --}}

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Part Number</label>
                        {{-- value="{{ old('field', $data->field) }}" berfungsi menampilkan data lama --}}
                        <input type="text" name="part_number" class="form-control" value="{{ old('part_number', $product->part_number) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Material</label>
                        <input type="text" name="material" class="form-control" value="{{ old('material', $product->material) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Berat (KG)</label>
                        <input type="number" step="0.01" name="weight" class="form-control" value="{{ old('weight', $product->weight) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Harga (Rp)</label>
                        <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('master.products.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-warning text-dark">
                        <i class="fas fa-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection