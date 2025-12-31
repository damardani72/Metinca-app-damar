@extends('layouts.app')

@section('page-title', 'Detail Customer')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-info text-white">
            <i class="fas fa-eye me-1"></i> Informasi Lengkap Customer
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="35%">Nama Perusahaan</th>
                            <td>: <strong>{{ $customer->name }}</strong></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>: {{ $customer->email ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>No. Telepon</th>
                            <td>: {{ $customer->phone ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Bergabung Sejak</th>
                            <td>: {{ $customer->created_at->format('d F Y') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="fw-bold">Alamat / Keterangan:</label>
                        <p class="text-muted border p-3 rounded bg-light">
                            {{ $customer->description ?? 'Tidak ada keterangan tambahan.' }}
                        </p>
                    </div>
                </div>
            </div>

            <hr>

            <div class="d-flex justify-content-between">
                <a href="{{ route('master.customers.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
                <a href="{{ route('master.customers.edit', $customer->id) }}" class="btn btn-warning text-dark">
                    <i class="fas fa-edit me-1"></i> Edit Data
                </a>
            </div>
        </div>
    </div>
</div>
@endsection