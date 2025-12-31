<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material; // Pastikan Model Material dipanggil

class InventoryController extends Controller
{
    /**
     * Tampilkan Daftar Stok Material
     */
    public function index()
    {
        // Ambil semua data dari tabel materials
        $materials = Material::all();
        
        // Kirim data ke view inventory/index.blade.php
        return view('inventory.index', compact('materials'));
    }

    /**
     * Tampilkan Form Barang Masuk
     */
    public function create()
    {
        // Kita butuh daftar material untuk dipilih di dropdown
        $materials = Material::all();
        return view('inventory.create', compact('materials'));
    }

    /**
     * Proses Simpan Barang Masuk (Update Stok)
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'material_id' => 'required|exists:materials,id',
            'qty'         => 'required|integer|min:1',
        ]);

        // 2. Cari Material di Database
        $material = Material::findOrFail($request->material_id);

        // 3. Tambahkan Stok Lama + Stok Baru
        $material->current_stock = $material->current_stock + $request->qty;
        $material->save(); // Simpan perubahan

        // 4. Kembali ke halaman stok dengan pesan sukses
        return redirect()->route('inventory.index')
                         ->with('success', 'Stok berhasil ditambahkan: ' . $material->name);
    }
}