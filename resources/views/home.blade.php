<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT.METINCA PRIMA INDUSTRIAL WORKS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/homepage.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/menu-modal.css') }}">
    @stack('styles')
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top" style="background-color: #1e3c72;">
        <div class="container">
            <a class="navbar-brand fs-5 fw-bold" href="#">
                PT. METINCA PRIMA INDUSTRIAL WORKS
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link active" href="/home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#profile">Profile</a>
                    </li>
                    
                    {{-- TOMBOL APLIKASI UTAMA --}}
                    <li class="nav-item ms-2">
                        <a class="btn btn-outline-light btn-sm rounded-pill px-3" data-bs-target="#metincaAppsModal" data-bs-toggle="modal" href="#">
                            <i class="bi bi-grid-3x3-gap-fill me-2"></i> Application
                        </a>
                    </li>

                    {{-- TOMBOL LOGOUT --}}
                    <li class="nav-item ms-2">
                         <a class="nav-link text-danger" href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                           <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

   {{-- Banner Utama --}}
   <div class="container py-5 text-center" style="min-height: 80vh; display: flex; flex-direction: column; justify-content: center; align-items: center;">
        <img src="{{ asset('assets/compiled/svg/logo.svg') }}" alt="Logo Metinca" style="max-height: 150px; margin-bottom: 2rem;">
        <h1 class="display-5 fw-bold text-dark">Portal Sistem Informasi Produksi</h1>
        <p class="lead text-muted mb-4">Selamat datang, <strong>{{ Auth::user()->name }}</strong>. <br>Silakan akses modul pekerjaan Anda melalui menu Aplikasi.</p>
        
        <button class="btn btn-primary btn-lg rounded-pill px-5 shadow" data-bs-target="#metincaAppsModal" data-bs-toggle="modal">
            <i class="bi bi-grid-3x3-gap-fill me-2"></i> Buka Menu Aplikasi
        </button>
   </div>

    <footer class="footer bg-dark text-white pt-4 pb-2">
        <div class="container text-center">
            <p class="small text-white-50">&copy; 2025 PT. Metinca Prima Industrial Works. All Rights Reserved.</p>
        </div>
    </footer>

    <div class="modal fade" id="metincaAppsModal" tabindex="-1" aria-labelledby="metincaAppsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="metincaAppsModalLabel">
                        <i class="bi bi-app-indicator me-2"></i>Metinca Apps
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-light">
                    
                    <div class="category-card engineering mb-3 p-3 bg-white rounded shadow-sm">
                        <div class="category-title h5 text-primary border-bottom pb-2 mb-3">
                            <i class="bi bi-cpu-fill me-2"></i> Production Engineering
                        </div>
                        <div class="sub-category">
                            <div class="menu-grid d-flex gap-3 flex-wrap">
                                {{-- LINK KE DASHBOARD STATISTIK --}}
                                <a href="{{ route('dashboard') }}" class="menu-item text-decoration-none text-center p-3 border rounded hover-shadow" style="width: 140px;">
                                    <div class="menu-icon fs-2 text-primary mb-2">
                                        <i class="bi bi-speedometer2"></i>
                                    </div>
                                    <div class="menu-text small fw-bold text-dark">Analytics Dashboard</div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="category-card commercial mb-3 p-3 bg-white rounded shadow-sm">
                        <div class="category-title h5 text-success border-bottom pb-2 mb-3">
                            <i class="bi bi-briefcase-fill me-2"></i> Commercial (Sales)
                        </div>
                        <div class="sub-category">
                            <div class="menu-grid d-flex gap-3 flex-wrap">
                                <a href="{{ route('sales.index') }}" class="menu-item text-decoration-none text-center p-3 border rounded hover-shadow" style="width: 140px;">
                                    <div class="menu-icon fs-2 text-success mb-2"><i class="bi bi-bag-check-fill"></i></div>
                                    <div class="menu-text small fw-bold text-dark">List Sales Order</div>
                                </a>
                                <a href="{{ route('sales.create') }}" class="menu-item text-decoration-none text-center p-3 border rounded hover-shadow" style="width: 140px;">
                                    <div class="menu-icon fs-2 text-success mb-2"><i class="bi bi-cart-plus-fill"></i></div>
                                    <div class="menu-text small fw-bold text-dark">Input PO Baru</div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="category-card production mb-3 p-3 bg-white rounded shadow-sm">
                        <div class="category-title h5 text-danger border-bottom pb-2 mb-3">
                            <i class="bi bi-building me-2"></i> Production & Warehouse
                        </div>
                        <div class="sub-category">
                            <div class="menu-grid d-flex gap-3 flex-wrap">
                                {{-- PPC --}}
                                <a href="{{ route('ppc.index') }}" class="menu-item text-decoration-none text-center p-3 border rounded hover-shadow" style="width: 140px;">
                                    <div class="menu-icon fs-2 text-danger mb-2"><i class="bi bi-calendar2-week-fill"></i></div>
                                    <div class="menu-text small fw-bold text-dark">Scheduling (MODM)</div>
                                </a>
                                <a href="{{ route('ppc.result') }}" class="menu-item text-decoration-none text-center p-3 border rounded hover-shadow" style="width: 140px;">
                                    <div class="menu-icon fs-2 text-danger mb-2"><i class="bi bi-list-task"></i></div>
                                    <div class="menu-text small fw-bold text-dark">Jadwal Produksi</div>
                                </a>

                                {{-- GUDANG --}}
                                <a href="{{ route('materials.index') }}" class="menu-item text-decoration-none text-center p-3 border rounded hover-shadow" style="width: 140px;">
                                    <div class="menu-icon fs-2 text-warning mb-2"><i class="bi bi-boxes"></i></div>
                                    <div class="menu-text small fw-bold text-dark">Cek Stok Material</div>
                                </a>
                                <a href="{{ route('materials.incoming') }}" class="menu-item text-decoration-none text-center p-3 border rounded hover-shadow" style="width: 140px;">
                                    <div class="menu-icon fs-2 text-warning mb-2"><i class="bi bi-arrow-down-square-fill"></i></div>
                                    <div class="menu-text small fw-bold text-dark">Barang Masuk</div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="category-card quality mb-3 p-3 bg-white rounded shadow-sm">
                        <div class="category-title h5 text-info border-bottom pb-2 mb-3">
                            <i class="bi bi-patch-check-fill me-2"></i> Quality & Report
                        </div>
                        <div class="sub-category">
                            <div class="menu-grid d-flex gap-3 flex-wrap">
                                <a href="{{ route('report.index') }}" class="menu-item text-decoration-none text-center p-3 border rounded hover-shadow" style="width: 140px;">
                                    <div class="menu-icon fs-2 text-info mb-2"><i class="bi bi-file-earmark-bar-graph-fill"></i></div>
                                    <div class="menu-text small fw-bold text-dark">Laporan Produksi</div>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>