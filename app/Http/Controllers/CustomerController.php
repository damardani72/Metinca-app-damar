<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Database\QueryException; // Tambahan penting untuk menangkap error database

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::orderBy('created_at', 'desc')->get();
        return view('master.customers.index', compact('customers'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|numeric',
        ]);

        Customer::create($request->all());

        // Kirim pesan sukses ke View (akan ditangkap SweetAlert)
        return back()->with('success', 'Customer berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        try {
            $customer = Customer::findOrFail($id);
            $customer->delete();
            
            return back()->with('success', 'Customer berhasil dihapus!');

        } catch (QueryException $e) {
            // Kode 23000 = Integrity Constraint Violation (Data sedang dipakai)
            if ($e->getCode() == "23000") {
                return back()->with('error', 'Gagal menghapus! Customer ini memiliki riwayat pesanan (PO). Hapus PO-nya terlebih dahulu.');
            }

            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan Detail Customer
     */
    public function show($id)
    {
        $customer = \App\Models\Customer::findOrFail($id);
        return view('master.customers.show', compact('customer'));
    }

    /**
     * Tampilkan Form Edit
     */
    public function edit($id)
    {
        $customer = \App\Models\Customer::findOrFail($id);
        return view('master.customers.edit', compact('customer'));
    }

    /**
     * Simpan Perubahan (Update)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|numeric',
        ]);

        $customer = \App\Models\Customer::findOrFail($id);
        $customer->update($request->all());

        return redirect()->route('master.customers.index')->with('success', 'Data Customer berhasil diperbarui!');
    }
}