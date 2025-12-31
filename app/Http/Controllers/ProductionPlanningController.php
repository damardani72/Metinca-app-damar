<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesOrder;
use App\Models\Product;
use App\Models\Resource; // Pastikan Model Resource sudah dibuat
use DB;

class ProductionPlanningController extends Controller
{
    /**
     * Halaman Utama PPC (Dashboard Perencanaan)
     * Menampilkan daftar pesanan yang belum diproses (Status: Open)
     */
    public function index()
    {
        // 1. Ambil Data Demand (Pesanan dari Sales yang statusnya 'open')
        $pendingOrders = SalesOrder::with(['customer', 'items.product'])
                            ->where('status', 'open')
                            ->orderBy('delivery_deadline', 'asc') // Urutkan yang deadline-nya mepet
                            ->get();

        // 2. Ambil Data Kapasitas (Stok Resource / Mesin)
        // Jika Model Resource belum ada, variabel ini akan kosong (aman, tidak error)
        $resources = [];
        if (class_exists('App\Models\Resource')) {
            $resources = Resource::all();
        }

        return view('ppc.index', compact('pendingOrders', 'resources'));
    }

    /**
     * Proses Hitung MODM (Algoritma Sederhana)
     * Menerima input prioritas dari user, lalu membuat jadwal
     */
    public function calculate(Request $request)
    {
        // 1. Ambil Pilihan Prioritas User (Profit vs Waktu vs Biaya)
        $priority = $request->input('priority', 'balanced'); // Default: Balanced

        // 2. Ambil Order yang dipilih untuk diproses
        $selectedOrderIds = $request->input('order_ids', []);
        
        if (empty($selectedOrderIds)) {
            return redirect()->back()->with('error', 'Pilih minimal satu pesanan untuk direncanakan!');
        }

        $orders = SalesOrder::with('items.product')->whereIn('id', $selectedOrderIds)->get();

        // --- LOGIKA MODM (SIMULASI) ---
        // Di skripsi nanti, bagian ini diganti dengan rumus matematika/algoritma
        $results = [];

        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                
                // Logika Sederhana:
                // Jika Prioritas = Waktu, maka kita cari mesin tercepat
                // Jika Prioritas = Profit, kita cari bahan termurah
                
                $statusProduksi = 'Siap Produksi';
                $rekomendasi = 'Lanjutkan sesuai jadwal';
                $warna = 'success';

                // Contoh Constraint: Jika jumlah banyak (>1000), peringatkan kapasitas
                if ($item->quantity > 1000) {
                    $statusProduksi = 'Kapasitas Kritis';
                    $rekomendasi = 'Butuh lembur atau sub-kontraktor';
                    $warna = 'warning';
                }

                $results[] = [
                    'po_number' => $order->po_number,
                    'customer' => $order->customer->company_name,
                    'product_name' => $item->product->part_name,
                    'qty_plan' => $item->quantity,
                    'deadline' => $order->delivery_deadline,
                    'status' => $statusProduksi,
                    'recommendation' => $rekomendasi,
                    'color' => $warna
                ];
            }
        }

        // Kirim hasil perhitungan ke halaman Result
        return view('ppc.result', compact('results', 'priority'));
    }

    /**
     * Menampilkan Halaman Hasil (Jika diakses via GET langsung)
     */
    public function showResult()
    {
        // Jika user akses /ppc/result tanpa proses hitung, kembalikan ke index
        return redirect()->route('ppc.index');
    }
}