<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Produksi') - PT Metinca Prima Industrial Works</title>

    <link rel="shortcut icon" href="{{ asset('assets/compiled/svg/favicon.svg') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/iconly.css') }}">
    {{-- Font Awesome untuk Ikon --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @stack('styles')
</head>

<body>
    <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>
    <div id="app">
        
        <div id="sidebar">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="logo">
                            <a href="{{ route('dashboard') }}"><img src="{{ asset('assets/compiled/svg/logo.svg') }}" alt="Logo" srcset=""></a>
                        </div>
                        <div class="theme-toggle d-flex gap-2 align-items-center mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--system-uicons" width="20" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                                <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2" opacity=".3"></path>
                                    <g transform="translate(-210 -1)">
                                        <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                        <circle cx="220.5" cy="11.5" r="4"></circle>
                                        <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2"></path>
                                    </g>
                                </g>
                            </svg>
                            <div class="form-check form-switch fs-6">
                                <input class="form-check-input me-0" type="checkbox" id="toggle-dark" style="cursor: pointer">
                                <label class="form-check-label"></label>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--mdi" width="20" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                <path fill="currentColor" d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z"></path>
                            </svg>
                        </div>
                        <div class="sidebar-toggler x">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>

                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Main Menu</li>

                        <li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <a href="{{ route('dashboard') }}" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li class="sidebar-title">Master Data</li>

                        <li class="sidebar-item has-sub {{ request()->routeIs('master.*') ? 'active' : '' }}">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-database-fill"></i>
                                <span>Data Master</span>
                            </a>
                            <ul class="submenu {{ request()->routeIs('master.*') ? 'active' : 'submenu-closed' }}">
                                <li class="submenu-item {{ request()->routeIs('master.products.*') ? 'active' : '' }}">
                                    <a href="{{ route('master.products.index') }}" class="submenu-link">Produk (Part No)</a>
                                </li>
                                <li class="submenu-item {{ request()->routeIs('master.customers.*') ? 'active' : '' }}">
                                    <a href="{{ route('master.customers.index') }}" class="submenu-link">Customer</a>
                                </li>
                                <li class="submenu-item {{ request()->routeIs('master.machines.*') ? 'active' : '' }}">
                                    <a href="{{ route('master.machines.index') }}" class="submenu-link">Mesin & Kapasitas</a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-title">Marketing & Sales</li>

                        <li class="sidebar-item has-sub {{ request()->routeIs('sales.*') ? 'active' : '' }}">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-cart-check-fill"></i>
                                <span>Pesanan (PO)</span>
                            </a>
                            <ul class="submenu {{ request()->routeIs('sales.*') ? 'active' : 'submenu-closed' }}">
                                <li class="submenu-item {{ request()->routeIs('sales.create') ? 'active' : '' }}">
                                    <a href="{{ route('sales.create') }}" class="submenu-link">Input PO Baru</a>
                                </li>
                                <li class="submenu-item {{ request()->routeIs('sales.index') ? 'active' : '' }}">
                                    <a href="{{ route('sales.index') }}" class="submenu-link">List Pesanan</a>
                                </li>
                            </ul>
                        </li>

                        {{-- BAGIAN GUDANG (SUDAH DIPERBAIKI) --}}
                        <li class="sidebar-title">Gudang (Inventory)</li>

                        <li class="sidebar-item has-sub {{ request()->routeIs('materials.*') ? 'active' : '' }}">
                            <a href="#" class='sidebar-link'>
                                <i class="fas fa-boxes"></i>
                                <span>Stok Material</span>
                            </a>
                            <ul class="submenu {{ request()->routeIs('materials.*') ? 'active' : 'submenu-closed' }}">
                                <li class="submenu-item {{ request()->routeIs('materials.index') ? 'active' : '' }}">
                                    {{-- Mengarah ke route 'materials.index' (Cek Stok) --}}
                                    <a href="{{ route('materials.index') }}" class="submenu-link">Cek Stok</a>
                                </li>
                                <li class="submenu-item {{ request()->routeIs('materials.incoming') ? 'active' : '' }}">
                                    {{-- Mengarah ke route 'materials.incoming' (Barang Masuk) --}}
                                    <a href="{{ route('materials.incoming') }}" class="submenu-link">Barang Masuk</a>
                                </li>
                            </ul>
                        </li>

                        {{-- BAGIAN PPC --}}
                        <li class="sidebar-title">Production Planning (PPC)</li>

                        <li class="sidebar-item has-sub {{ request()->routeIs('ppc.*') ? 'active' : '' }}">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-calendar-range-fill"></i>
                                <span>Perencanaan</span>
                            </a>
                            <ul class="submenu {{ request()->routeIs('ppc.*') ? 'active' : 'submenu-closed' }}">
                                <li class="submenu-item {{ request()->routeIs('ppc.index') ? 'active' : '' }}">
                                    <a href="{{ route('ppc.index') }}" class="submenu-link">Buat Rencana (MODM)</a>
                                </li>
                                <li class="submenu-item {{ request()->routeIs('ppc.result') ? 'active' : '' }}">
                                    <a href="{{ route('ppc.result') }}" class="submenu-link">Jadwal Produksi</a>
                                </li>
                                <li class="submenu-item {{ request()->routeIs('ppc.approval.*') ? 'active' : '' }}">
                                    <a href="{{ route('ppc.approval.index') }}" class="submenu-link">Approval</a>
                                </li>
                            </ul>
                        </li>

                        {{-- BAGIAN LAPORAN --}}
                        <li class="sidebar-title">Laporan & Arsip</li>

                        <li class="sidebar-item {{ request()->routeIs('report.*') ? 'active' : '' }}">
                            <a href="{{ route('report.index') }}" class='sidebar-link'>
                                <i class="fas fa-print"></i>
                                <span>Laporan Produksi</span>
                            </a>
                        </li>

                        <li class="sidebar-title">Settings</li>

                        <li class="sidebar-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-people-fill"></i>
                                <span>Manajemen User</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                             <a href="#" onclick="event.preventDefault(); document.getElementById('formLogout').dispatchEvent(new Event('submit'));" class='sidebar-link'>
                                <i class="bi bi-box-arrow-left text-danger"></i>
                                <span class="text-danger">Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="main">
            <header class="mb-3">
                <nav class="navbar navbar-expand navbar-light navbar-top">
                    <div class="container-fluid">
                        <a href="#" class="burger-btn d-block">
                            <i class="bi bi-justify fs-3"></i>
                        </a>
                        
                        {{-- Navbar Toggler --}}
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mb-lg-0">
                                <li class="nav-item dropdown me-3">
                                    <a class="nav-link active dropdown-toggle text-gray-600" href="#"
                                        data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                        <i class="bi bi-bell bi-sub fs-4"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end notification-dropdown" aria-labelledby="dropdownMenuButton">
                                        <li class="dropdown-header">
                                            <h6>Notifications</h6>
                                        </li>
                                        <li class="dropdown-item notification-item">
                                            <a class="d-flex align-items-center" href="#">
                                                <div class="notification-text ms-4">
                                                    <p class="notification-title font-bold">System Ready</p>
                                                    <p class="notification-subtitle font-thin text-sm">Aplikasi Perencanaan Produksi Siap.</p>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            
                            {{-- User Dropdown --}}
                            <div class="dropdown">
                                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="user-menu d-flex">
                                        <div class="user-name text-end me-3">
                                            <h6 class="mb-0 text-gray-600">{{ auth()->user()->name ?? 'Guest' }}</h6>
                                            <p class="mb-0 text-sm text-gray-600">{{ auth()->user()->role ?? 'Staff' }}</p>
                                        </div>
                                        <div class="user-img d-flex align-items-center">
                                            <div class="avatar avatar-md">
                                                <img src="{{ asset('assets/compiled/jpg/1.jpg') }}" />
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton" style="min-width: 11rem">
                                    <li>
                                        <h6 class="dropdown-header">Hello, {{ auth()->user()->name ?? 'User' }}!</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#"><i class="icon-mid bi bi-person me-2"></i> My Profile</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="icon-mid bi bi-gear me-2"></i> Settings</a></li>
                                    <li><hr class="dropdown-divider" /></li>
                                    <li>
                                        <form id="formLogout" action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="icon-mid bi bi-box-arrow-left me-2"></i> Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </header>

            <div class="page-heading">
                <h3>@yield('page-title')</h3>
            </div>

            <div class="page-content">
                @yield('content')
            </div>

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2025 &copy; Sistem Informasi - PT Metinca Prima Industrial Works</p>
                    </div>
                    <div class="float-end">
                        <p>Developed for Production Planning Thesis</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="{{ asset('assets/static/js/components/dark.js') }}"></script>
    <script src="{{ asset('assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/compiled/js/app.js') }}"></script>
    
    @stack('scripts')

    {{-- TAMBAHAN: Script Notifikasi Otomatis & Logout --}}
    <script>
        // 1. Cek Notifikasi Sukses
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        // 2. Cek Notifikasi Error
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
            });
        @endif

        // 3. Cek Error Validasi
        @if($errors->any())
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                html: '<ul style="text-align: left;">' +
                        @foreach ($errors->all() as $error)
                            '<li>{{ $error }}</li>' +
                        @endforeach
                      '</ul>',
            });
        @endif

        // 4. Script Logout Konfirmasi
        document.getElementById('formLogout').addEventListener('submit', function(e){
            e.preventDefault();
            let form = this; 
            Swal.fire({
                title: 'Yakin ingin logout?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
</body>

</html>