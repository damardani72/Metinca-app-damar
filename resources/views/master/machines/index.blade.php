@extends('layouts.app')

@section('page-title', 'Data Mesin & Kapasitas')

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
        {{-- Form Tambah Mesin (Kiri) --}}
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-cogs me-1"></i> Tambah Mesin Baru
                </div>
                <div class="card-body">
                    <form action="{{ route('master.machines.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Mesin <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: CNC Cutting 01" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tipe / Jenis</label>
                            <select name="type" class="form-select">
                                <option value="Potong">Mesin Potong (Cutting)</option>
                                <option value="Bubut">Mesin Bubut (Lathe)</option>
                                <option value="Press">Mesin Press (Stamping)</option>
                                <option value="Welding">Mesin Las (Welding)</option>
                                <option value="Assembling">Meja Assembling</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kapasitas Harian (Unit/Hari) <span class="text-danger">*</span></label>
                            <input type="number" name="capacity_per_day" class="form-control" placeholder="Contoh: 100" min="1" required>
                            <small class="text-muted">Berapa rata-rata output mesin ini dalam sehari?</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status Awal</label>
                            <select name="status" class="form-select">
                                <option value="ready">Ready (Siap Pakai)</option>
                                <option value="maintenance">Maintenance</option>
                                <option value="rusak">Rusak</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save me-1"></i> Simpan Mesin
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Tabel Daftar Mesin (Kanan) --}}
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-list me-1"></i> Daftar Sumber Daya Mesin
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th width="5%" class="text-center">No</th>
                                    <th>Nama Mesin</th>
                                    <th>Tipe</th>
                                    <th>Kapasitas</th>
                                    <th>Status</th>
                                    <th width="15%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($machines as $index => $machine)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="fw-bold">{{ $machine->name }}</td>
                                    <td>{{ $machine->type ?? '-' }}</td>
                                    <td>{{ number_format($machine->capacity_per_day) }} Unit/Hari</td>
                                    <td>
                                        @if($machine->status == 'ready')
                                            <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Ready</span>
                                        @elseif($machine->status == 'maintenance')
                                            <span class="badge bg-warning text-dark"><i class="fas fa-wrench me-1"></i> Maintenance</span>
                                        @else
                                            <span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i> Rusak</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            {{-- 1. TOMBOL DETAIL --}}
                                            <a href="{{ route('master.machines.show', $machine->id) }}" class="btn btn-info btn-sm text-white" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            {{-- 2. TOMBOL EDIT --}}
                                            <a href="{{ route('master.machines.edit', $machine->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            {{-- 3. TOMBOL HAPUS --}}
                                            <form onsubmit="return confirm('Yakin ingin menghapus mesin ini?');" action="{{ route('master.machines.destroy', $machine->id) }}" method="POST">
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
                                    <td colspan="6" class="text-center text-muted py-4">
                                        Belum ada data mesin. Silakan tambah di form sebelah kiri.
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