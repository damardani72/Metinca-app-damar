@extends('layouts.app')

@section('page-title', 'Detail Mesin')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-info text-white">
            <i class="fas fa-eye me-1"></i> Informasi Detail Mesin
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="35%">Nama Mesin</th>
                            <td>: <strong>{{ $machine->name }}</strong></td>
                        </tr>
                        <tr>
                            <th>Tipe / Jenis</th>
                            <td>: {{ $machine->type ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Kapasitas</th>
                            <td>: {{ number_format($machine->capacity_per_day) }} Unit/Hari</td>
                        </tr>
                        <tr>
                            <th>Status Saat Ini</th>
                            <td>: 
                                @if($machine->status == 'ready')
                                    <span class="badge bg-success">Ready</span>
                                @elseif($machine->status == 'maintenance')
                                    <span class="badge bg-warning text-dark">Maintenance</span>
                                @else
                                    <span class="badge bg-danger">Rusak</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <div class="alert alert-light border">
                        <i class="fas fa-info-circle me-1"></i> <strong>Catatan:</strong><br>
                        Kapasitas mesin mempengaruhi perhitungan durasi produksi secara otomatis di sistem MODM. Pastikan data ini selalu update.
                    </div>
                    <div class="text-muted small mt-3">
                        <i class="fas fa-calendar-alt me-1"></i> Terdaftar: {{ $machine->created_at->format('d M Y') }}<br>
                        <i class="fas fa-pen me-1"></i> Terakhir Update: {{ $machine->updated_at->format('d M Y H:i') }}
                    </div>
                </div>
            </div>

            <hr>

            <div class="d-flex justify-content-between">
                <a href="{{ route('master.machines.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
                <a href="{{ route('master.machines.edit', $machine->id) }}" class="btn btn-warning text-dark">
                    <i class="fas fa-edit me-1"></i> Edit Data
                </a>
            </div>
        </div>
    </div>
</div>
@endsection