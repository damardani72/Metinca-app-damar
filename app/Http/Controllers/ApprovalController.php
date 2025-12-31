<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductionSchedule;

class ApprovalController extends Controller
{
    /**
     * Tampilkan daftar jadwal yang MENUNGGU persetujuan (status = planned)
     */
    public function index()
    {
        // Ambil data yang statusnya masih 'planned'
        $pendingSchedules = ProductionSchedule::with(['salesOrder.customer', 'product'])
                            ->where('status', 'planned')
                            ->orderBy('start_date', 'asc')
                            ->get();

        return view('ppc.approval', compact('pendingSchedules'));
    }

    /**
     * Setujui Jadwal (Ubah status planned -> approved)
     */
    public function approve($id)
    {
        $schedule = ProductionSchedule::findOrFail($id);
        
        // Kita ubah statusnya jadi 'approved' (atau langsung in_progress tergantung alur Anda)
        // Untuk skripsi, biasanya ada status 'approved' dulu sebelum dikerjakan.
        $schedule->status = 'approved'; 
        $schedule->save();

        return back()->with('success', 'Jadwal Produksi No PO ' . $schedule->salesOrder->po_number . ' telah DISETUJUI!');
    }
}