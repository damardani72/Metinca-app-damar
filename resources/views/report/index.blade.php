@extends('layouts.app')

@section('page-title', 'Laporan Produksi Selesai')

@section('content')
<div class="container-fluid">
    
    {{-- Filter Tanggal --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form action="{{ route('report.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Dari Tanggal</label>
                    <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Sampai Tanggal</label>
                    <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-1"></i> Tampilkan Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Ringkasan --}}
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h3>{{ number_format($totalItems) }} Pcs</h3>
                    <div>Total Barang Produksi</div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-info text-dark">
                <div class="card-body text-center">
                    <h3>{{ $totalOrders }} Order</h3>
                    <div>Total Pesanan Selesai</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Laporan --}}
    <div class="card">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <span><i class="fas fa-table me-1"></i> Data Produksi Selesai</span>
            <a href="#" onclick="window.print()" class="btn btn-sm btn-light text-dark">
                <i class="fas fa-print me-1"></i> Cetak
            </a>
        </div>
        <div class="card-body">
            @if($reports->isEmpty())
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-folder-open fa-3x mb-3"></i><br>
                    Tidak ada data produksi selesai pada rentang tanggal ini.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" width="5%">No</th>
                                <th>Tanggal Selesai</th>
                                <th>No PO</th>
                                <th>Customer</th>
                                <th>Produk</th>
                                <th>Mesin</th>
                                <th class="text-center">Qty (Pcs)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reports as $index => $row)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="fw-bold">
                                    {{-- PERBAIKAN: Gunakan end_date --}}
                                    {{ \Carbon\Carbon::parse($row->end_date)->format('d M Y') }}
                                </td>
                                <td>{{ $row->salesOrder->po_number ?? '-' }}</td>
                                <td>{{ $row->salesOrder->customer->name ?? '-' }}</td>
                                <td>{{ $row->product->name ?? '-' }}</td>
                                <td>{{ $row->machine->name ?? '-' }}</td>
                                <td class="text-center fw-bold">{{ number_format($row->quantity_plan) }}</td>
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