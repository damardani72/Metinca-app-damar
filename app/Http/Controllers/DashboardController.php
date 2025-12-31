<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesOrder; // Panggil Model Sales
use App\Models\Material;   // Panggil Model Material

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Hitung Total Pesanan (PO)
        $totalPO = SalesOrder::count();

        // 2. Hitung Ada Berapa Material yang Stoknya 'Bahaya' (Kurang dari batas minimum)
        $lowStockCount = Material::whereColumn('current_stock', '<=', 'minimum_stock')->count();

        // 3. Hitung Total Jenis Material
        $totalMaterials = Material::count();

        // Kirim data ke tampilan dashboard
        return view('dashboard', compact('totalPO', 'lowStockCount', 'totalMaterials'));
    }
}