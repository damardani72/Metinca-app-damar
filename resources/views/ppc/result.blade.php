@extends('layouts.app')

@section('page-title', 'Hasil Jadwal Produksi')

@section('content')
<div class="container-fluid">

    {{-- Pesan Sukses --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-calendar-alt me-1"></i> Jadwal Produksi (Gantt Chart Sederhana)
            </div>
            <a href="{{ route('ppc.index') }}" class="btn btn-light btn-sm text-primary fw-bold">
                <i class="fas fa-plus me-1"></i> Buat Jadwal Baru
            </a>
        </div>
        <div class="card-body">
            
            @if($schedules->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada jadwal produksi yang dibuat.</p>
                    <a href="{{ route('ppc.index') }}" class="btn btn-primary">Ke Halaman Perencanaan</a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th>No. PO / Customer</th>
                                <th>Mesin</th>
                                <th>Produk</th>
                                <th class="text-center">Qty Rencana</th>
                                <th>Durasi Jadwal</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" width="15%">Aksi Produksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($schedules as $index => $schedule)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>
                                    {{-- Menggunakan operator ?? untuk mencegah error jika data terhapus --}}
                                    <div class="fw-bold text-primary">{{ $schedule->salesOrder->po_number ?? '-' }}</div>
                                    <small class="text-muted">{{ $schedule->salesOrder->customer->name ?? '-' }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-info text-dark">
                                        <i class="fas fa-cogs me-1"></i> {{ $schedule->machine->name ?? 'Mesin Hapus' }}
                                    </span>
                                </td>
                                <td>
                                    {{ $schedule->product->name ?? '-' }}<br>
                                    <small class="text-muted">{{ $schedule->product->part_number ?? '' }}</small>
                                </td>
                                <td class="text-center fw-bold">{{ number_format($schedule->quantity_plan) }} Pcs</td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="text-success"><i class="fas fa-play me-1"></i> {{ \Carbon\Carbon::parse($schedule->start_date)->format('d M Y') }}</span>
                                        <span class="text-danger"><i class="fas fa-flag-checkered me-1"></i> {{ \Carbon\Carbon::parse($schedule->end_date)->format('d M Y') }}</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    @if($schedule->status == 'planned')
                                        <span class="badge bg-secondary">Terjadwal</span>
                                    @elseif($schedule->status == 'in_progress')
                                        <span class="badge bg-warning text-dark">Sedang Jalan</span>
                                    @elseif($schedule->status == 'done')
                                        <span class="badge bg-success">Selesai</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    {{-- TOMBOL AKSI UPDATE STATUS --}}
                                    
                                    @if($schedule->status == 'planned')
                                        <form action="{{ route('ppc.updateStatus', $schedule->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="status" value="in_progress">
                                            <button type="submit" class="btn btn-primary btn-sm w-100">
                                                <i class="fas fa-play"></i> Mulai
                                            </button>
                                        </form>
                                    
                                    @elseif($schedule->status == 'in_progress')
                                        <form action="{{ route('ppc.updateStatus', $schedule->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="status" value="done">
                                            <button type="submit" class="btn btn-success btn-sm w-100">
                                                <i class="fas fa-check"></i> Selesai
                                            </button>
                                        </form>

                                    @else
                                        <button class="btn btn-secondary btn-sm w-100" disabled>
                                            <i class="fas fa-lock"></i> Closed
                                        </button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection