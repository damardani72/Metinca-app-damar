@extends('layouts.app')

@section('page-title', 'Daftar Sales Order')

@section('content')
<div class="container-fluid">

    {{-- Alert Success --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card border-top-primary shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-list me-2 text-primary"></i> Data Pesanan Masuk</h5>
            <a href="{{ route('sales.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Input PO Baru
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th>Nomor PO</th>
                            <th>Customer</th>
                            <th>Tgl Order</th>
                            <th>Deadline</th>
                            <th>Total Item</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $index => $order)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="fw-bold text-primary">{{ $order->po_number }}</td>
                            <td>
                                {{-- PERBAIKAN: Cek apakah relasi customer ada --}}
                                @if($order->customer)
                                    {{ $order->customer->name }}
                                @else
                                    <span class="text-danger fst-italic">Customer Terhapus</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</td>
                            <td class="text-danger">
                                {{ \Carbon\Carbon::parse($order->delivery_date)->format('d M Y') }}
                            </td>
                            <td>
                                <span class="badge bg-secondary">
                                    {{ $order->items->count() }} Jenis
                                </span>
                            </td>
                            <td class="text-center">
                                @if($order->status == 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($order->status == 'process')
                                    <span class="badge bg-info text-dark">Proses</span>
                                @elseif($order->status == 'done')
                                    <span class="badge bg-success">Selesai</span>
                                @else
                                    <span class="badge bg-secondary">{{ $order->status }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    {{-- Tombol Detail --}}
                                    <a href="{{ route('sales.show', $order->id) }}" class="btn btn-info btn-sm text-white" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    {{-- Tombol Hapus (Agar Anda bisa hapus data rusak) --}}
                                    <form action="{{ route('sales.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus PO ini?');" style="display: inline-block;">
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
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="fas fa-box-open fa-2x mb-2"></i><br>
                                Belum ada data pesanan.
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