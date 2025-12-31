@extends('layouts.app')

@section('page-title', 'Perencanaan Produksi (MODM)')

@section('content')
<div class="container-fluid">
    
    {{-- Pesan Error / Sukses --}}
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

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

    <div class="alert alert-info shadow-sm">
        <i class="fas fa-info-circle me-1"></i> 
        Silakan centang Pesanan (PO) yang ingin dijadwalkan, lalu klik tombol "Proses" di bawah.
    </div>

    {{-- Form Utama untuk Proses Jadwal --}}
    <form action="{{ route('ppc.process') }}" method="POST">
        @csrf
        
        <div class="card mb-4 shadow-sm border-0">
            {{-- PERUBAHAN DISINI: Menambahkan d-flex untuk tombol di kanan --}}
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <span>
                    <i class="fas fa-list me-1"></i> Daftar Pesanan Belum Diproses (Open/Pending)
                </span>
                
                {{-- TOMBOL PINTAS KE INPUT PO --}}
                <a href="{{ route('sales.create') }}" class="btn btn-light btn-sm text-dark fw-bold">
                    <i class="fas fa-cart-plus me-1"></i> Input PO Baru
                </a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" width="5%"><input type="checkbox" id="checkAll"></th>
                                <th>No PO</th>
                                <th>Customer</th>
                                <th>Deadline</th>
                                <th>Total Item</th>
                                <th>Bobot Total (Est)</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($openOrders as $order)
                            <tr>
                                <td class="text-center">
                                    {{-- Checkbox Array --}}
                                    <input type="checkbox" name="selected_orders[]" value="{{ $order->id }}" class="order-checkbox">
                                </td>
                                <td class="fw-bold">{{ $order->po_number }}</td>
                                <td>{{ $order->customer->name ?? '-' }}</td>
                                <td class="text-danger fw-bold">
                                    {{ \Carbon\Carbon::parse($order->delivery_date)->format('d M Y') }}
                                </td>
                                <td>{{ $order->items->count() }} Jenis</td>
                                <td>
                                    {{-- Hitung Total Berat --}}
                                    @php
                                        $totalWeight = 0;
                                        foreach($order->items as $item) {
                                            $totalWeight += $item->quantity * ($item->product->weight ?? 0);
                                        }
                                    @endphp
                                    {{ number_format($totalWeight, 2) }} Kg
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <i class="fas fa-clipboard-check fa-3x mb-3 text-secondary"></i><br>
                                    <h6 class="text-secondary">Tidak ada pesanan baru yang perlu dijadwalkan.</h6>
                                    <p class="small text-muted mb-0">Klik tombol "Input PO Baru" di kanan atas untuk membuat pesanan.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Panel Parameter & Tombol Eksekusi --}}
        <div class="card mb-4 border-success shadow-sm">
            <div class="card-header bg-success text-white">
                <i class="fas fa-cogs me-1"></i> Eksekusi MODM
            </div>
            <div class="card-body">
                <div class="row align-items-end">
                    <div class="col-md-8">
                        <p class="mb-0 text-muted">
                            Sistem akan secara otomatis menghitung durasi produksi berdasarkan kapasitas mesin yang tersedia (Status: Ready) dan mengurutkan jadwal berdasarkan Deadline terdekat.
                        </p>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-success w-100 btn-lg shadow">
                            <i class="fas fa-calculator me-1"></i> Proses Jadwal Produksi
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // Script Sederhana untuk Check All
    document.getElementById('checkAll').addEventListener('change', function() {
        let checkboxes = document.querySelectorAll('.order-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });
</script>
@endpush