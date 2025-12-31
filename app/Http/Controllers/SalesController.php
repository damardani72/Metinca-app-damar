<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesOrder;
use App\Models\SalesOrderItem;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Support\Facades\DB; 

class SalesController extends Controller
{
    // 1. TAMPILKAN LIST PESANAN
    public function index()
    {
        // Mengambil data sales order beserta relasinya (Customer & Items)
        // Menggunakan latest() agar data terbaru muncul di atas
        $orders = SalesOrder::with(['customer', 'items'])->latest()->get();
        
        return view('sales.index', compact('orders'));
    }

    // 2. FORM INPUT PO BARU
    public function create()
    {
        $customers = Customer::all();
        $products = Product::all();
        
        return view('sales.create', compact('customers', 'products'));
    }

    // 3. SIMPAN DATA (STORE)
    public function store(Request $request)
    {
        // A. Validasi Input
        $request->validate([
            'po_number'     => 'required|unique:sales_orders,po_number',
            'customer_id'   => 'required|exists:customers,id',
            'order_date'    => 'required|date',
            // Pastikan kolom DB bernama delivery_date (sesuai migrasi terakhir)
            'delivery_date' => 'required|date|after_or_equal:order_date', 
            'products'      => 'required|array|min:1', // Wajib ada minimal 1 produk
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity'   => 'required|integer|min:1',
        ]);

        try {
            // Gunakan Transaksi Database untuk keamanan data
            DB::beginTransaction();

            // B. Simpan Header PO
            $salesOrder = SalesOrder::create([
                'po_number'     => $request->po_number,
                'customer_id'   => $request->customer_id,
                'order_date'    => $request->order_date,
                'delivery_date' => $request->delivery_date, 
                'status'        => 'pending', 
            ]);

            // C. Simpan Detail Item (Looping array produk dari form)
            foreach ($request->products as $item) {
                // Lewati jika product_id kosong (jaga-jaga)
                if(empty($item['product_id'])) continue;

                SalesOrderItem::create([
                    'sales_order_id' => $salesOrder->id,
                    'product_id'     => $item['product_id'],
                    'quantity'       => $item['quantity'],
                ]);
            }

            // Jika semua lancar, simpan permanen
            DB::commit();
            
            return redirect()->route('sales.index')
                             ->with('success', 'Purchase Order ' . $request->po_number . ' berhasil disimpan!');

        } catch (\Exception $e) {
            // Jika ada error, batalkan semua perubahan database
            DB::rollback();
            
            // Kembali ke form dengan input sebelumnya + pesan error
            return redirect()->back()
                             ->with('error', 'Gagal menyimpan data: ' . $e->getMessage())
                             ->withInput();
        }
    }

    // 4. SHOW DETAIL
    public function show($id)
    {
        // PERBAIKAN PENTING:
        // Gunakan nama variabel '$salesOrder' agar cocok dengan view 'sales.show'
        $salesOrder = SalesOrder::with(['customer', 'items.product'])->findOrFail($id);
        
        return view('sales.show', compact('salesOrder')); 
    }

    // 5. HAPUS DATA (DESTROY)
    public function destroy($id)
    {
        try {
            $salesOrder = SalesOrder::findOrFail($id);
            
            // Hapus items terlebih dahulu (opsional jika sudah cascade di database, tapi aman ditulis)
            $salesOrder->items()->delete(); 
            
            // Hapus header
            $salesOrder->delete();          

            return back()->with('success', 'Data pesanan berhasil dihapus.');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

    /**
     * AJAX Check: Cek ketersediaan Nomor PO (Realtime)
     */
    public function checkPoNumber(Request $request)
    {
        // Cek apakah ada PO Number yang sama di database
        $exists = SalesOrder::where('po_number', $request->po_number)->exists();

        // Kembalikan jawaban dalam format JSON (True/False)
        return response()->json(['exists' => $exists]);
    }
}