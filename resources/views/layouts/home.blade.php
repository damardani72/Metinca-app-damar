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
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top" style="background-color: #1e3c72;"> {{-- Menambahkan warna background agar navbar terlihat jelas --}}
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
                    <li class="nav-item">
                        <a class="nav-link" href="#divisions">Divisions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Facilities</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Gallery</a>
                    </li>
                    
                    {{-- TOMBOL APLIKASI UTAMA --}}
                    <li class="nav-item ms-2">
                        <a class="btn btn-outline-light btn-sm rounded-pill px-3" data-bs-target="#metincaAppsModal" data-bs-toggle="modal" href="#">
                            <i class="bi bi-grid-3x3-gap-fill me-2"></i> Application
                        </a>
                    </li>

                    {{-- TOMBOL LOGOUT (PENTING: Agar user bisa keluar) --}}
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

   @yield('content')

   {{-- KONTEN DEFAULT JIKA TIDAK ADA @section('content') DARI CONTROLLER --}}
   {{-- Anda bisa membiarkan ini atau menggantinya dengan Banner/Hero Section Anda --}}
   <div class="container py-5 text-center" style="min-height: 60vh; display: flex; flex-direction: column; justify-content: center; align-items: center;">
        <img src="{{ asset('assets/compiled/svg/logo.svg') }}" alt="Logo Metinca" style="max-height: 150px; margin-bottom: 2rem;">
        <h1 class="display-5 fw-bold text-dark">Sistem Informasi Produksi Terintegrasi</h1>
        <p class="lead text-muted mb-4">Selamat datang, <strong>{{ Auth::user()->name ?? 'User' }}</strong>. Silakan akses modul pekerjaan Anda melalui menu Aplikasi.</p>
        <button class="btn btn-primary btn-lg rounded-pill px-5" data-bs-target="#metincaAppsModal" data-bs-toggle="modal">
            <i class="bi bi-grid-3x3-gap-fill me-2"></i> Buka Menu Aplikasi
        </button>
   </div>

    <footer class="footer bg-dark text-white pt-5 pb-3">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5>PT. METINCA PRIMA INDUSTRIAL WORKS</h5>
                    <p class="small text-white-50">
                        The #1 Precision Casting and Tooling Facility in Indonesia    
                    </p>
                    <div class="social-icons mt-3">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Products</h5>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Investment Casting</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Sand Casting</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Valve</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Contact</h5>
                    <p class="small text-white-50"><i class="fas fa-phone me-2"></i>+62 21 1234 5678</p>
                    <p class="small text-white-50"><i class="fas fa-envelope me-2"></i>info@metinca-prima.co.id</p>
                </div>
            </div>
            <hr style="border-color: rgba(255,255,255,0.1);">
            <div class="text-center pt-3 small text-white-50">
                <p>&copy; 2025 Metinca. All Rights Reserved.</p>
            </div>
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
                    
                    <div class="category-card">
                        <div class="category-title">
                            <i class="bi bi-people-fill"></i> Human Resources
                        </div>
                        <div class="menu-grid">
                            <a href="#" class="menu-item">
                                <div class="menu-icon" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);"><i class="bi bi-person-plus-fill"></i></div>
                                <div class="menu-text">Recruitment</div>
                            </a>
                            <a href="#" class="menu-item">
                                <div class="menu-icon" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);"><i class="bi bi-person-badge-fill"></i></div>
                                <div class="menu-text">Placement</div>
                            </a>
                            {{-- ... Menu HR Lainnya tetap ... --}}
                        </div>
                    </div>

                    <div class="category-card" style="background: linear-gradient(135deg, #134e5e 0%, #71b280 100%);">
                        <div class="category-title">
                            <i class="bi bi-briefcase-fill"></i> General Affair
                        </div>
                        <div class="menu-grid">
                            <a href="#" class="menu-item">
                                <div class="menu-icon" style="background: linear-gradient(135deg, #134e5e 0%, #71b280 100%);"><i class="bi bi-building"></i></div>
                                <div class="menu-text">Facility Inventory</div>
                            </a>
                            {{-- ... Menu GA Lainnya tetap ... --}}
                        </div>
                    </div>

                    <div class="category-card" style="background: linear-gradient(135deg, #232526 0%, #414345 100%);">
                        <div class="category-title">
                            <i class="bi bi-file-earmark-text-fill"></i> Administration
                        </div>
                        <div class="menu-grid">
                            <a href="#" class="menu-item">
                                <div class="menu-icon" style="background: linear-gradient(135deg, #232526 0%, #414345 100%);"><i class="bi bi-clock-fill"></i></div>
                                <div class="menu-text">Attendance</div>
                            </a>
                            {{-- ... Menu Admin Lainnya tetap ... --}}
                        </div>
                    </div>

                    <div class="category-card commercial">
                        <div class="category-title">
                            <i class="bi bi-briefcase-fill"></i> Commercial & Business
                        </div>

                        <div class="sub-category">
                            <div class="sub-category-title"><i class="bi bi-graph-up-arrow"></i> Sales</div>
                            <div class="menu-grid">
                                {{-- 1. LINK KE SALES ORDER --}}
                                <a href="{{ route('sales.index') }}" class="menu-item">
                                    <div class="menu-icon"><i class="bi bi-bag-check-fill"></i></div>
                                    <div class="menu-text">Product Sales (PO)</div>
                                </a>
                            </div>
                        </div>
                        
                        <div class="sub-category">
                            <div class="sub-category-title"><i class="bi bi-cart-check-fill"></i> Purchasing</div>
                            <div class="menu-grid">
                                <a href="#" class="menu-item">
                                    <div class="menu-icon"><i class="bi bi-shop"></i></div>
                                    <div class="menu-text">Supplier Determination</div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="category-card production">
                        <div class="category-title">
                            <i class="bi bi-building"></i> Production & Warehouse
                        </div>

                        <div class="sub-category">
                            <div class="sub-category-title"><i class="bi bi-clipboard-data-fill"></i> PPIC</div>
                            <div class="menu-grid">
                                {{-- 2. LINK KE PPC (MODM) --}}
                                <a href="{{ route('ppc.index') }}" class="menu-item">
                                    <div class="menu-icon"><i class="bi bi-calendar2-week-fill"></i></div>
                                    <div class="menu-text">Production Scheduling</div>
                                </a>
                                
                                <a href="#" class="menu-item">
                                    <div class="menu-icon"><i class="bi bi-cart-plus-fill"></i></div>
                                    <div class="menu-text">Material Procurement</div>
                                </a>
                                
                                {{-- 3. LINK KE GUDANG (STOK) --}}
                                <a href="{{ route('materials.index') }}" class="menu-item">
                                    <div class="menu-icon"><i class="bi bi-boxes"></i></div>
                                    <div class="menu-text">Material Inventory</div>
                                </a>
                                
                                <a href="#" class="menu-item">
                                    <div class="menu-icon"><i class="bi bi-bullseye"></i></div>
                                    <div class="menu-text">Production Target</div>
                                </a>
                            </div>
                        </div>

                        <div class="sub-category">
                            <div class="sub-category-title"><i class="bi bi-house-fill"></i> Warehouse</div>
                            <div class="menu-grid">
                                {{-- 4. LINK KE GUDANG (BARANG MASUK) --}}
                                <a href="{{ route('materials.incoming') }}" class="menu-item">
                                    <div class="menu-icon"><i class="bi bi-truck"></i></div>
                                    <div class="menu-text">Goods Delivery (In)</div>
                                </a>
                                
                                <a href="#" class="menu-item">
                                    <div class="menu-icon"><i class="bi bi-arrow-return-left"></i></div>
                                    <div class="menu-text">Material Return</div>
                                </a>

                                <a href="#" class="menu-item">
                                    <div class="menu-icon"><i class="bi bi-arrow-left-right"></i></div>
                                    <div class="menu-text">In/Out Management</div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="category-card engineering">
                        <div class="category-title">
                            <i class="bi bi-cpu-fill"></i> Production Engineering
                        </div>

                        <div class="sub-category">
                            <div class="sub-category-title"><i class="bi bi-kanban-fill"></i> Production Management</div>
                            <div class="menu-grid">
                                <a href="#" class="menu-item">
                                    <div class="menu-icon"><i class="bi bi-clipboard-check-fill"></i></div>
                                    <div class="menu-text">Planning Overview</div>
                                </a>
                                <a href="#" class="menu-item">
                                    <div class="menu-icon"><i class="bi bi-diagram-2-fill"></i></div>
                                    <div class="menu-text">Organization</div>
                                </a>
                                {{-- LINK KE JADWAL PRODUKSI (GANTT) --}}
                                <a href="{{ route('ppc.result') }}" class="menu-item">
                                    <div class="menu-icon"><i class="bi bi-speedometer2"></i></div>
                                    <div class="menu-text">Production Control</div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="category-card quality">
                        <div class="category-title">
                            <i class="bi bi-patch-check-fill"></i> Quality Management
                        </div>

                        <div class="sub-category">
                            <div class="sub-category-title"><i class="bi bi-search"></i> Quality Control</div>
                            <div class="menu-grid">
                                <a href="#" class="menu-item">
                                    <div class="menu-icon"><i class="bi bi-box-seam"></i></div>
                                    <div class="menu-text">Raw Material QC</div>
                                </a>
                                <a href="#" class="menu-item">
                                    <div class="menu-icon"><i class="bi bi-check2-square"></i></div>
                                    <div class="menu-text">Finished Product QC</div>
                                </a>
                                {{-- 5. LINK KE LAPORAN --}}
                                <a href="{{ route('report.index') }}" class="menu-item">
                                    <div class="menu-icon"><i class="bi bi-file-earmark-text-fill"></i></div>
                                    <div class="menu-text">Documentation & Report</div>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    @stack('scripts')
</body>

</html>