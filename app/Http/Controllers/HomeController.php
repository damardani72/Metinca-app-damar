<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
// Import Model agar kode di bawah lebih bersih
use App\Models\SalesOrder;
use App\Models\Material;
use App\Models\ProductionSchedule;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // 1. HALAMAN PORTAL MENU (Landing Page Admin)
    public function index()
    {
        return view('home'); 
    }

    // 2. HALAMAN DASHBOARD ANALYTICS (Control Tower)
    public function dashboard()
    {
        // A. Statistik Kartu Atas
        $stats = [
            'total_po'      => SalesOrder::count(),
            'stock_alert'   => Material::whereColumn('current_stock', '<=', 'minimum_stock')->count(),
            'materials'     => Material::count(),
            'monthly_sales' => SalesOrder::whereMonth('created_at', now()->month)->count(),
        ];

        // B. Tabel Peringatan Stok (Ambil 5 item yang stoknya kritis)
        $criticalMaterials = Material::whereColumn('current_stock', '<=', 'minimum_stock')
                                     ->orderBy('current_stock', 'asc')
                                     ->take(5)
                                     ->get();

        // C. UPDATE 1: Ambil PO yang Deadline-nya 7 hari ke depan & belum selesai
        $deadlineOrders = SalesOrder::where('status', '!=', 'done')
                                    ->whereBetween('delivery_date', [now(), now()->addDays(7)])
                                    ->orderBy('delivery_date', 'asc')
                                    ->get();

        // D. UPDATE 2: Modifikasi Active Schedule agar ada data persentase (Simulasi)
        // Di real application, ini diambil dari (qty_produced / qty_total) * 100
        $activeSchedules = ProductionSchedule::with(['product', 'salesOrder'])
                                             ->where('status', 'in_progress')
                                             ->take(5)
                                             ->get()
                                             ->map(function($item) {
                                                 // Simulasi progress acak untuk demo
                                                 $item->progress = rand(20, 90); 
                                                 return $item;
                                             });

        // E. PO Terbaru (5 Terakhir)
        $recentOrders = SalesOrder::with('customer')
                                  ->latest()
                                  ->take(5)
                                  ->get();

        return view('dashboard', compact('stats', 'criticalMaterials', 'recentOrders', 'activeSchedules', 'deadlineOrders'));
    }
}