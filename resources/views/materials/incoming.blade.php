@extends('layouts.app')

@section('page-title', 'Input Barang Masuk')

@section('content')
<div class="container d-flex justify-content-center">
    <div class="card shadow-lg col-md-6 border-0">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="fas fa-truck-loading me-2"></i> Form Barang Masuk (Restock)</h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('materials.storeIncoming') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label class="form-label fw-bold">Pilih Material</label>
                    <select name="material_id" class="form-select form-select-lg" required>
                        <option value="">-- Pilih Material yang Masuk --</option>
                        @foreach($materials as $mat)
                            <option value="{{ $mat->id }}">
                                {{ $mat->material_code }} - {{ $mat->name }} (Sisa: {{ $mat->current_stock }} {{ $mat->unit }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Jumlah Masuk</label>
                    <div class="input-group input-group-lg">
                        <input type="number" name="quantity" class="form-control" placeholder="0" min="1" required>
                        <span class="input-group-text bg-light">Unit</span>
                    </div>
                    <small class="text-muted">Stok akan otomatis bertambah ke data yang dipilih.</small>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('materials.index') }}" class="btn btn-light border">Batal</a>
                    <button type="submit" class="btn btn-success px-5 fw-bold">
                        <i class="fas fa-save me-1"></i> Simpan Stok
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection