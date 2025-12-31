@extends('layouts.app')

@section('page-title', 'Edit Data Mesin')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-warning text-dark">
            <i class="fas fa-cogs me-1"></i> Form Edit Mesin
        </div>
        <div class="card-body">
            <form action="{{ route('master.machines.update', $machine->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Mesin <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $machine->name) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tipe / Jenis</label>
                        <select name="type" class="form-select">
                            <option value="Potong" {{ $machine->type == 'Potong' ? 'selected' : '' }}>Mesin Potong</option>
                            <option value="Bubut" {{ $machine->type == 'Bubut' ? 'selected' : '' }}>Mesin Bubut</option>
                            <option value="Press" {{ $machine->type == 'Press' ? 'selected' : '' }}>Mesin Press</option>
                            <option value="Welding" {{ $machine->type == 'Welding' ? 'selected' : '' }}>Mesin Las</option>
                            <option value="Assembling" {{ $machine->type == 'Assembling' ? 'selected' : '' }}>Meja Assembling</option>
                            <option value="Lainnya" {{ $machine->type == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kapasitas Harian (Unit/Hari)</label>
                        <input type="number" name="capacity_per_day" class="form-control" value="{{ old('capacity_per_day', $machine->capacity_per_day) }}" min="1" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="ready" {{ $machine->status == 'ready' ? 'selected' : '' }}>Ready (Siap Pakai)</option>
                            <option value="maintenance" {{ $machine->status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                            <option value="rusak" {{ $machine->status == 'rusak' ? 'selected' : '' }}>Rusak</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('master.machines.index') }}" class="btn btn-secondary">
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