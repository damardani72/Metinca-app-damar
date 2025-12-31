@extends('layouts.app')

@section('page-title', 'Edit Data Customer')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-warning text-dark">
            <i class="fas fa-user-edit me-1"></i> Form Edit Customer
        </div>
        <div class="card-body">
            <form action="{{ route('master.customers.update', $customer->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Perusahaan <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $customer->name) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $customer->email) }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">No. Telepon</label>
                        <input type="number" name="phone" class="form-control" value="{{ old('phone', $customer->phone) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Keterangan / Alamat</label>
                        <textarea name="description" class="form-control" rows="2">{{ old('description', $customer->description) }}</textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('master.customers.index') }}" class="btn btn-secondary">
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