<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;

class MaterialController extends Controller
{
    /**
     * HALAMAN 1: CEK STOK (DASHBOARD GUDANG)
     * Menampilkan semua material dan status stoknya (Aman/Kritis)
     */
    public function index()
    {
        // Ambil semua material, urutkan: Stok Kritis paling atas
        $materials = Material::orderByRaw('(current_stock - minimum_stock) ASC')->get();
        
        return view('materials.index', compact('materials'));
    }

    /**
     * SIMPAN MASTER DATA MATERIAL BARU
     * (Hanya mendaftarkan nama barang, stok awal biasanya 0)
     */
    public function store(Request $request)
    {
        $request->validate([
            'material_code' => 'required|unique:materials,material_code',
            'name'          => 'required',
            'unit'          => 'required',
            'minimum_stock' => 'required|integer',
        ]);

        Material::create($request->all());

        return back()->with('success', 'Data Material baru berhasil didaftarkan.');
    }

    /**
     * HALAMAN 2: FORM BARANG MASUK
     */
    public function incomingForm()
    {
        $materials = Material::all();
        return view('materials.incoming', compact('materials'));
    }

    /**
     * PROSES SIMPAN STOK (BARANG MASUK)
     * Logika: Stok Akhir = Stok Awal + Masuk
     */
    public function storeIncoming(Request $request)
    {
        $request->validate([
            'material_id' => 'required|exists:materials,id',
            'quantity'    => 'required|integer|min:1',
        ]);

        // 1. Ambil Data Material
        $material = Material::findOrFail($request->material_id);

        // 2. Tambahkan Stok
        $material->current_stock += $request->quantity;
        $material->save();

        return redirect()->route('materials.index')
            ->with('success', "Stok {$material->name} berhasil ditambah sebanyak {$request->quantity} {$material->unit}.");
    }
    
    // Hapus Material
    public function destroy($id)
    {
        Material::findOrFail($id)->delete();
        return back()->with('success', 'Material dihapus.');
    }
}