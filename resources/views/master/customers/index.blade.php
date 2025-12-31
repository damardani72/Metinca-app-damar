@extends('layouts.app')

@section('page-title', 'Master Data Customer')

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
        {{-- Form Tambah Customer (Kiri) --}}
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-user-plus me-1"></i> Tambah Customer
                </div>
                <div class="card-body">
                    <form action="{{ route('master.customers.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Perusahaan <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: PT. Astra Honda Motor" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Email (Opsional)</label>
                            <input type="email" name="email" class="form-control" placeholder="procurement@astra.co.id">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">No. Telepon / WA</label>
                            <input type="number" name="phone" class="form-control" placeholder="0812...">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat / Keterangan</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Alamat pabrik atau catatan khusus..."></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">Simpan Customer</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Tabel Daftar Customer (Kanan) --}}
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-users me-1"></i> Daftar Customer
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th width="5%" class="text-center">No</th>
                                    <th>Nama Customer</th>
                                    <th>Kontak</th>
                                    <th>Keterangan</th>
                                    <th class="text-center" width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($customers as $index => $customer)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="fw-bold">{{ $customer->name }}</td>
                                    <td>
                                        <small>
                                            <i class="fas fa-envelope me-1"></i> {{ $customer->email ?? '-' }}<br>
                                            <i class="fas fa-phone me-1"></i> {{ $customer->phone ?? '-' }}
                                        </small>
                                    </td>
                                    <td>{{ $customer->description ?? '-' }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            {{-- 1. TOMBOL DETAIL --}}
                                            <a href="{{ route('master.customers.show', $customer->id) }}" class="btn btn-info btn-sm text-white" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            {{-- 2. TOMBOL EDIT --}}
                                            <a href="{{ route('master.customers.edit', $customer->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            {{-- 3. TOMBOL HAPUS --}}
                                            <form onsubmit="return confirm('Yakin ingin menghapus customer ini?');" action="{{ route('master.customers.destroy', $customer->id) }}" method="POST">
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
                                    <td colspan="5" class="text-center text-muted py-3">
                                        Belum ada data customer. Silakan tambah di form sebelah kiri.
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