@extends('layouts.app')

@section('page-title', 'Approval Jadwal Produksi')

@section('content')
<div class="container-fluid">

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card border-primary mb-4">
        <div class="card-header bg-primary text-white">
            <i class="fas fa-tasks me-1"></i> Daftar Rencana Menunggu Persetujuan
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Rank</th>
                            <th>No PO</th>
                            <th>Customer</th>
                            <th>Produk</th>
                            <th>Jadwal Produksi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendingSchedules as $schedule)
                        <tr>
                            <td class="text-center fw-bold">{{ $schedule->sequence_rank }}</td>
                            <td>{{ $schedule->salesOrder->po_number }}</td>
                            <td>{{ $schedule->salesOrder->customer->name ?? '-' }}</td>
                            <td>{{ $schedule->product->name ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($schedule->production_date)->translatedFormat('d F Y') }}</td>
                            <td class="text-center">
                                <form action="{{ route('ppc.approval.approve', $schedule->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Setujui jadwal ini untuk diproduksi?')">
                                        <i class="fas fa-check"></i> Approve
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="fas fa-check-double fa-2x mb-2 text-success"></i><br>
                                Tidak ada jadwal yang menunggu approval.<br>
                                (Semua jadwal sudah disetujui atau belum dibuat).
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection