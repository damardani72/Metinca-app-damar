<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalesController; 
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// ====================================================
// START: RUTE APLIKASI UTAMA (Perlu Login)
// ====================================================
Route::middleware(['auth'])->group(function () {
    
    // 1. Dashboard
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');

    // 2. MODUL SALES ORDER
    Route::get('/sales', [SalesController::class, 'index'])->name('sales.index');
    Route::get('/sales/create', [SalesController::class, 'create'])->name('sales.create');
    Route::post('/sales', [SalesController::class, 'store'])->name('sales.store');
    Route::get('/sales/{id}', [SalesController::class, 'show'])->name('sales.show');
    Route::delete('/sales/{id}', [SalesController::class, 'destroy'])->name('sales.destroy');

    // 3. MODUL PPC (Production Planning)
    Route::get('/ppc', [App\Http\Controllers\PPCController::class, 'index'])->name('ppc.index');
    // Tambahkan ini di group Sales atau PPC (bebas, asal di dalam auth)
Route::post('/sales/check-po', [App\Http\Controllers\SalesController::class, 'checkPoNumber'])->name('sales.checkPo');
    
    // --- JARING PENGAMAN (PENTING) ---
    // Agar tidak error jika user akses via browser/refresh
    Route::get('/ppc/process', function() {
        return redirect()->route('ppc.index');
    });

    // --- RUTE UTAMA (KEMBALIKAN KE CONTROLLER) ---
    // Hapus kode tes "BERHASIL..." tadi, ganti dengan baris ini:
    Route::post('/ppc/process', [App\Http\Controllers\PPCController::class, 'process'])->name('ppc.process');
    
    // Rute Hasil & Update
    Route::get('/ppc/result', [App\Http\Controllers\PPCController::class, 'results'])->name('ppc.result');
    Route::post('/ppc/update-status/{id}', [App\Http\Controllers\PPCController::class, 'updateStatus'])->name('ppc.updateStatus');

    // 8. APPROVAL PRODUKSI (PPC)
    Route::get('/ppc/approval', [App\Http\Controllers\ApprovalController::class, 'index'])->name('ppc.approval.index');
    Route::post('/ppc/approval/{id}', [App\Http\Controllers\ApprovalController::class, 'approve'])->name('ppc.approval.approve');

    // 4. MODUL GUDANG (INVENTORY)
    Route::get('/inventory', [App\Http\Controllers\InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/inventory/incoming', [App\Http\Controllers\InventoryController::class, 'create'])->name('inventory.create');
    Route::post('/inventory/incoming', [App\Http\Controllers\InventoryController::class, 'store'])->name('inventory.store');

    // 6. MODUL LAPORAN
    Route::get('/report', [App\Http\Controllers\ReportController::class, 'index'])->name('report.index');
    Route::get('/report/print', [App\Http\Controllers\ReportController::class, 'print'])->name('report.print');

    // ====================================================
    // MASTER DATA
    // ====================================================

    // A. MASTER PRODUK
    Route::prefix('master/products')->name('master.products.')->group(function () {
        Route::get('/', [App\Http\Controllers\ProductController::class, 'index'])->name('index');
        Route::post('/', [App\Http\Controllers\ProductController::class, 'store'])->name('store');
        Route::get('/{id}/detail', [App\Http\Controllers\ProductController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [App\Http\Controllers\ProductController::class, 'edit'])->name('edit');
        Route::put('/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('update');
        Route::delete('/{id}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('destroy');
    });

    // B. MASTER CUSTOMER
    Route::prefix('master/customers')->name('master.customers.')->group(function () {
        Route::get('/', [App\Http\Controllers\CustomerController::class, 'index'])->name('index');
        Route::post('/', [App\Http\Controllers\CustomerController::class, 'store'])->name('store');
        Route::get('/{id}/detail', [App\Http\Controllers\CustomerController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [App\Http\Controllers\CustomerController::class, 'edit'])->name('edit');
        Route::put('/{id}', [App\Http\Controllers\CustomerController::class, 'update'])->name('update');
        Route::delete('/{id}', [App\Http\Controllers\CustomerController::class, 'destroy'])->name('destroy');
    });

    // C. MASTER MESIN
    Route::prefix('master/machines')->name('master.machines.')->group(function () {
        Route::get('/', [App\Http\Controllers\MachineController::class, 'index'])->name('index');
        Route::post('/', [App\Http\Controllers\MachineController::class, 'store'])->name('store');
        Route::get('/{id}/detail', [App\Http\Controllers\MachineController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [App\Http\Controllers\MachineController::class, 'edit'])->name('edit');
        Route::put('/{id}', [App\Http\Controllers\MachineController::class, 'update'])->name('update');
        Route::delete('/{id}', [App\Http\Controllers\MachineController::class, 'destroy'])->name('destroy');
    });

    // 4. MODUL GUDANG (INVENTORY)
    Route::get('/materials', [App\Http\Controllers\MaterialController::class, 'index'])->name('materials.index');
    Route::post('/materials', [App\Http\Controllers\MaterialController::class, 'store'])->name('materials.store');
    Route::delete('/materials/{id}', [App\Http\Controllers\MaterialController::class, 'destroy'])->name('materials.destroy');

    // Khusus Barang Masuk
    Route::get('/materials/incoming', [App\Http\Controllers\MaterialController::class, 'incomingForm'])->name('materials.incoming');
    Route::post('/materials/incoming', [App\Http\Controllers\MaterialController::class, 'storeIncoming'])->name('materials.storeIncoming');

    

});