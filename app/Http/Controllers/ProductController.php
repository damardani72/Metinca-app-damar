<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Tampilkan Daftar Produk
     */
    public function index()
    {
        $products = Product::all();
        return view('master.products.index', compact('products'));
    }

    /**
     * Simpan Produk Baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable'
        ]);

        Product::create($request->all());

        return back()->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Tampilkan Form Edit
     */
    public function edit($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        return view('master.products.edit', compact('product'));
    }

    /**
     * Simpan Perubahan (Update)
     */
    public function update(Request $request, $id)
    {
        // Validasi
        $request->validate([
            'name' => 'required|string|max:255',
            'part_number' => 'nullable|string',
            'weight' => 'nullable|numeric',
        ]);

        $product = \App\Models\Product::findOrFail($id);
        
        // Update data
        $product->update($request->all());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('master.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Tampilkan Detail Produk
     */
    public function show($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        return view('master.products.show', compact('product'));
    }

    /**
     * Hapus Produk
     */
    public function destroy($id)
    {
        try {
            $product = \App\Models\Product::findOrFail($id);
            $product->delete();
            
            return back()->with('success', 'Produk berhasil dihapus!');
            
        } catch (\Illuminate\Database\QueryException $e) {
            // Jika error code 23000 (Integrity Constraint), tampilkan pesan error manis
            if ($e->getCode() == "23000") {
                return back()->with('error', 'Gagal menghapus! Produk ini sedang digunakan dalam Jadwal Produksi atau PO.');
            }
            
            // Jika error lain, tampilkan error aslinya
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}