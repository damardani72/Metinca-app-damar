<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Machine;
use Illuminate\Database\QueryException; // Penting untuk menangkap error database

class MachineController extends Controller
{
    /**
     * Tampilkan daftar mesin
     */
    public function index()
    {
        // Urutkan dari yang terbaru
        $machines = Machine::orderBy('created_at', 'desc')->get();
        return view('master.machines.index', compact('machines'));
    }

    /**
     * Simpan mesin baru
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string',
            'capacity_per_day' => 'required|numeric|min:1',
            'status' => 'required|in:ready,maintenance,rusak'
        ]);

        Machine::create($request->all());

        // Kirim pesan sukses (akan ditangkap SweetAlert)
        return back()->with('success', 'Mesin berhasil ditambahkan!');
    }

    /**
     * Tampilkan Detail Mesin
     */
    public function show($id)
    {
        $machine = \App\Models\Machine::findOrFail($id);
        return view('master.machines.show', compact('machine'));
    }

    /**
     * Tampilkan Form Edit
     */
    public function edit($id)
    {
        $machine = \App\Models\Machine::findOrFail($id);
        return view('master.machines.edit', compact('machine'));
    }

    /**
     * Simpan Perubahan (Update)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string',
            'capacity_per_day' => 'required|numeric|min:1',
            'status' => 'required|in:ready,maintenance,rusak'
        ]);

        $machine = \App\Models\Machine::findOrFail($id);
        $machine->update($request->all());

        return redirect()->route('master.machines.index')->with('success', 'Data Mesin berhasil diperbarui!');
    }

    /**
     * Hapus mesin
     */
    public function destroy($id)
    {
        try {
            $machine = Machine::findOrFail($id);
            $machine->delete();

            return back()->with('success', 'Mesin berhasil dihapus!');

        } catch (QueryException $e) {
            // Kode 23000 = Integrity Constraint Violation (Data sedang dipakai di tabel lain)
            if ($e->getCode() == "23000") {
                return back()->with('error', 'Gagal menghapus! Mesin ini sedang digunakan dalam Jadwal Produksi. Hapus jadwalnya terlebih dahulu.');
            }

            // Error lain
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}