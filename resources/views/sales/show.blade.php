@extends('layouts.app')

@section('page-title', 'Detail Pesanan')

@section('content')
<div class="container-fluid">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-primary fw-bold">Detail Pesanan</h3>
        <a href="{{ route('sales.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    {{-- KARTU HEADER PO --}}
    <div class="card border-top-primary shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Informasi Header PO</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td width="30%" class="text-muted">Nomor PO</td>
                            <td class="fw-bold fs-5">: {{ $salesOrder->po_number }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Customer</td>
                            <td class="fw-bold">
                                {{-- PERBAIKAN: Menggunakan optional() agar tidak error jika customer terhapus --}}
                                : {{ optional($salesOrder->customer)->name ?? 'Data Customer Hilang' }}
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td width="30%" class="text-muted">Tgl Order</td>
                            <td>: {{ \Carbon\Carbon::parse($salesOrder->order_date)->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Deadline</td>
                            <td class="text-danger fw-bold">: {{ \Carbon\Carbon::parse($salesOrder->delivery_date)->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Status</td>
                            <td>
                                : <span class="badge bg-{{ $salesOrder->status == 'pending' ? 'warning' : 'success' }}">
                                    {{ ucfirst($salesOrder->status) }}
                                  </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- TABEL ITEM BARANG --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title text-secondary mb-3">Daftar Barang (Items)</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Part Number</th>
                            <th>Nama Barang</th>
                            <th width="15%">Qty</th>
                            <th>Estimasi Berat Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($salesOrder->items as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="fw-bold text-primary">
                                {{ $item->product->part_number ?? '-' }}
                            </td>
                            <td>
                                {{-- PERBAIKAN: Gunakan 'name', bukan 'nama_barang' --}}
                                {{ $item->product->name ?? 'Produk Terhapus' }}
                            </td>
                            <td class="fw-bold">{{ $item->quantity }} Pcs</td>
                            <td>
                                {{-- PERBAIKAN: Hitung berat (Qty * Berat Satuan) --}}
                                @php
                                    $weight = $item->product->weight ?? 0;
                                    $totalWeight = $item->quantity * $weight;
                                @endphp
                                {{ number_format($totalWeight, 1) }} Kg
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection