@extends('layouts.app')

@section('page-title', 'Dashboard Control Tower')

@section('content')
<div class="page-content">
    
    {{-- BAGIAN 1: STATISTIK UTAMA --}}
    <div class="row">
        {{-- Kartu 1: Total PO --}}
        <div class="col-6 col-lg-3 col-md-6">
            <div class="card shadow-sm">
                <div class="card-body px-3 py-4-5">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="stats-icon purple mb-2">
                                <i class="fas fa-file-invoice"></i>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h6 class="text-muted font-semibold">Total PO</h6>
                            <h6 class="font-extrabold mb-0">{{ $stats['total_po'] }} Order</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kartu 2: Penjualan Bulan Ini --}}
        <div class="col-6 col-lg-3 col-md-6">
            <div class="card shadow-sm">
                <div class="card-body px-3 py-4-5">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="stats-icon blue mb-2">
                                <i class="fas fa-chart-line"></i>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h6 class="text-muted font-semibold">Sales Bulan Ini</h6>
                            <h6 class="font-extrabold mb-0">{{ $stats['monthly_sales'] }} PO</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kartu 3: Stok Kritis (Warna Merah jika ada masalah) --}}
        <div class="col-6 col-lg-3 col-md-6">
            <div class="card shadow-sm">
                <div class="card-body px-3 py-4-5">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="stats-icon {{ $stats['stock_alert'] > 0 ? 'red' : 'green' }} mb-2">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h6 class="text-muted font-semibold">Stok Kritis</h6>
                            <h6 class="font-extrabold mb-0 text-danger">{{ $stats['stock_alert'] }} Item</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kartu 4: Total Material --}}
        <div class="col-6 col-lg-3 col-md-6">
            <div class="card shadow-sm">
                <div class="card-body px-3 py-4-5">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="stats-icon green mb-2">
                                <i class="fas fa-boxes"></i>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h6 class="text-muted font-semibold">Database Material</h6>
                            <h6 class="font-extrabold mb-0">{{ $stats['materials'] }} Jenis</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- BAGIAN 2: INFORMASI DETAIL (SPLIT SCREEN) --}}
    <div class="row">
        
        {{-- KOLOM KIRI: PERINGATAN & AKTIVITAS PRODUKSI --}}
        {{-- KOLOM KIRI --}}
        <div class="col-12 col-xl-8">
            
            {{-- 🔥 WIDGET BARU: DEADLINE ALERT (Paling Atas) --}}
            @if($deadlineOrders->count() > 0)
            <div class="alert alert-warning shadow-sm d-flex align-items-center mb-4" role="alert">
                <i class="bi bi-exclamation-circle-fill fs-3 me-3"></i>
                <div>
                    <strong>Perhatian!</strong> Ada {{ $deadlineOrders->count() }} pesanan yang harus dikirim dalam 7 hari ke depan. 
                    <a href="{{ route('ppc.index') }}" class="alert-link">Segera jadwalkan prioritas!</a>
                </div>
            </div>
            @endif

            {{-- Tabel Peringatan Stok (Kode Lama) --}}
            <div class="card shadow-sm border-top-danger mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-danger"><i class="fas fa-siren me-2"></i>Stok Menipis (Segera Belanja)</h5>
                    <a href="{{ route('materials.index') }}" class="btn btn-sm btn-light text-danger">Lihat Gudang &rarr;</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Material</th>
                                    <th class="text-center">Sisa</th>
                                    <th class="text-center">Min</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($criticalMaterials as $item)
                                <tr>
                                    <td class="fw-bold ps-4 text-dark">{{ $item->name }}</td>
                                    <td class="text-center text-danger fw-bold fs-5">{{ $item->current_stock }}</td>
                                    <td class="text-center text-muted">{{ $item->minimum_stock }}</td>
                                    <td class="text-center"><span class="badge bg-danger">Urgent</span></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-success">
                                        <i class="fas fa-check-circle fa-2x mb-2"></i><br>
                                        Stok aman. Tidak ada kebutuhan belanja.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- 📊 WIDGET UPDATE: STATUS PRODUKSI DENGAN PROGRESS BAR --}}
            <div class="card shadow-sm border-top-info">
                <div class="card-header bg-white">
                    <h5 class="mb-0 text-info"><i class="fas fa-industry me-2"></i>Lantai Produksi (Live)</h5>
                </div>
                <div class="card-body">
                    @if($activeSchedules->isEmpty())
                        {{-- TAMPILAN KOSONG TAPI FUNGSIONAL --}}
                        <div class="text-center py-5">
                            {{-- 1. Ikon Besar dengan Background Bulat --}}
                            <div class="d-inline-block bg-light-secondary rounded-circle p-4 mb-3">
                                <i class="bi bi-robot fs-1 text-secondary"></i>
                            </div>
                            
                            {{-- 2. Teks Penjelasan --}}
                            <h5 class="text-muted">Lantai Produksi Sepi</h5>
                            <p class="text-muted small mb-4">
                                Tidak ada mesin yang sedang beroperasi saat ini.<br>
                                Apakah ada pesanan yang perlu segera dikerjakan?
                            </p>

                            {{-- 3. TOMBOL AKSI (Supaya Berfungsi) --}}
                            <a href="{{ route('ppc.index') }}" class="btn btn-primary btn-sm px-4 rounded-pill shadow-sm">
                                <i class="bi bi-plus-circle me-2"></i> Buat Jadwal Produksi
                            </a>
                        </div>
                    @else
                        {{-- TAMPILAN JIKA ADA DATA (TABEL) --}}
                        <div class="table-responsive">
                            <table class="table table-borderless align-middle mb-0">
                                @foreach($activeSchedules as $schedule)
                                <tr class="border-bottom">
                                    <td style="width: 40%;">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-md bg-light-info me-3 rounded p-2">
                                                <i class="fas fa-cogs text-info fa-lg"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold text-dark">{{ $schedule->product->name ?? 'Produk' }}</h6>
                                                <p class="small text-muted mb-0">Mesin: {{ $schedule->machine->name ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="width: 35%;">
                                        <div class="d-flex justify-content-between mb-1">
                                            <small class="text-muted fw-bold" style="font-size: 0.65rem;">PROGRESS</small>
                                            <small class="fw-bold text-info">{{ $schedule->progress }}%</small>
                                        </div>
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: {{ $schedule->progress }}%"></div>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <span class="badge bg-light-success text-success border border-success px-2 py-1">
                                            <i class="fas fa-play me-1 small"></i> Running
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: FEED AKTIVITAS TERBARU --}}
        <div class="col-12 col-xl-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0"><i class="fas fa-history me-2"></i>PO Terbaru Masuk</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($recentOrders as $order)
                        <div class="list-group-item px-3 py-3">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1 fw-bold text-primary">{{ $order->po_number }}</h6>
                                <small class="text-muted" style="font-size: 0.75rem;">{{ $order->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-1 small text-dark">{{ $order->customer->name ?? 'Unknown Customer' }}</p>
                            
                            @if($order->status == 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($order->status == 'done')
                                <span class="badge bg-success">Selesai</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                            @endif
                        </div>
                        @empty
                        <div class="text-center py-5 text-muted">Belum ada pesanan masuk.</div>
                        @endforelse
                    </div>
                </div>
                <div class="card-footer bg-light text-center">
                    <a href="{{ route('sales.index') }}" class="btn btn-sm btn-outline-primary w-100">Lihat Semua Data</a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection