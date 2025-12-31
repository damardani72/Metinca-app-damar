<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesOrder;
use App\Models\ProductionSchedule;
use App\Models\Machine;
use Carbon\Carbon;

class PPCController extends Controller
{
    /**
     * Halaman Utama Perencanaan (List Order Pending)
     */
    public function index()
    {
        // Ambil pesanan yang statusnya 'pending' atau 'open'
        $openOrders = SalesOrder::whereIn('status', ['pending', 'open'])
                                   ->with(['customer', 'items.product'])
                                   ->orderBy('delivery_date', 'asc') // Urutkan by deadline
                                   ->get();

        return view('ppc.index', compact('openOrders'));
    }

    /**
     * Proses Hitung Jadwal (MODM - Multi Order / Bulk)
     * PERBAIKAN: Menerima array 'selected_orders', bukan single 'order_id'
     */
    public function process(Request $request)
    {
        // 1. Validasi: Pastikan ada pesanan yang dicentang
        $request->validate([
            'selected_orders' => 'required|array|min:1',
        ], [
            'selected_orders.required' => 'Pilih setidaknya satu pesanan untuk diproses!',
        ]);

        // 2. Ambil Data Mesin yang Ready
        $machines = Machine::where('status', 'ready')->get();
        if($machines->isEmpty()) {
            return back()->with('error', 'Tidak ada mesin yang statusnya Ready! Silakan update status mesin di Data Master.');
        }

        // 3. Loop setiap pesanan yang dipilih (Pakai whereIn karena inputnya array ID)
        $orders = SalesOrder::with('items.product')->whereIn('id', $request->selected_orders)->get();
        
        // Tentukan start date awal (Besok atau lanjut dari jadwal terakhir)
        $lastSchedule = ProductionSchedule::latest('end_date')->first();
        $globalStartDate = $lastSchedule ? Carbon::parse($lastSchedule->end_date)->addDay() : Carbon::tomorrow();

        $count = 0;

        foreach ($orders as $order) {
            // Hitung Total Durasi untuk Order ini
            $totalQty = $order->items->sum('quantity');
            $avgCapacity = $machines->avg('capacity_per_day'); 
            if ($avgCapacity <= 0) $avgCapacity = 100; 

            $daysNeeded = ceil($totalQty / $avgCapacity);
            
            // Tentukan Start & End Date untuk Order ini
            $startDate = $globalStartDate->copy();
            $endDate = $startDate->copy()->addDays($daysNeeded);

            // Simpan Jadwal
            ProductionSchedule::create([
                'sales_order_id' => $order->id,
                'machine_id'     => $machines->first()->id, 
                'product_id'     => $order->items->first()->product_id ?? 1, // Fallback jika item kosong
                'quantity_plan'  => $totalQty,
                'start_date'     => $startDate,
                'end_date'       => $endDate,
                'status'         => 'planned'
            ]);

            // Update Status PO jadi 'process'
            $order->update(['status' => 'process']);

            // Update Global Start Date untuk pesanan berikutnya (agar tidak bentrok)
            $globalStartDate = $endDate->copy()->addDay();
            $count++;
        }

        return redirect()->route('ppc.result')->with('success', $count . ' pesanan berhasil dijadwalkan!');
    }

    /**
     * Halaman Hasil Jadwal Produksi
     */
    public function results()
    {
        $schedules = ProductionSchedule::with(['salesOrder.customer', 'machine', 'product'])
                                       ->orderBy('start_date', 'asc')
                                       ->get();

        return view('ppc.result', compact('schedules'));
    }

    /**
     * Update Status Produksi
     */
    public function updateStatus(Request $request, $id)
    {
        $schedule = ProductionSchedule::findOrFail($id);
        $schedule->status = $request->status; 
        $schedule->save();

        if ($request->status == 'done') {
            $schedule->salesOrder->update(['status' => 'done']);
        }

        return back()->with('success', 'Status produksi diperbarui.');
    }
}