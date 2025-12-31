<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductionSchedule;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // 1. Tentukan Rentang Tanggal (Default: Bulan Ini)
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate   = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        // 2. Query Data Laporan
        // PERBAIKAN:
        // - Menggunakan kolom 'end_date' (bukan production_date)
        // - Menggunakan status 'done' (sesuai status di PPCController)
        
        $reports = ProductionSchedule::with(['salesOrder.customer', 'product', 'machine'])
                    ->where('status', 'done') // Ambil yang sudah selesai
                    ->whereBetween('end_date', [$startDate, $endDate]) // Filter Tanggal Selesai
                    ->orderBy('end_date', 'desc')
                    ->get();

        // Hitung Ringkasan untuk Dashboard Kecil di atas laporan
        $totalItems = $reports->sum('quantity_plan');
        $totalOrders = $reports->count();

        return view('report.index', compact('reports', 'startDate', 'endDate', 'totalItems', 'totalOrders'));
    }

    public function print(Request $request)
    {
        // Logika cetak PDF (bisa dikembangkan nanti)
        // Untuk sekarang redirect saja
        return redirect()->back()->with('error', 'Fitur Cetak PDF belum diinstall (memerlukan dompdf).');
    }
}