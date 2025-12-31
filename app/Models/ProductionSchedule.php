<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionSchedule extends Model
{
    use HasFactory;

    // Izinkan mass assignment (agar bisa create data dengan array)
    protected $guarded = [];

    /**
     * Relasi ke Sales Order (Induk Pesanan)
     * ProductionSchedule MILIK SalesOrder
     */
    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class);
    }

    /**
     * Relasi ke Mesin
     * ProductionSchedule MILIK Machine
     * (INI YANG MENYEBABKAN ERROR TADI)
     */
    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }

    /**
     * Relasi ke Produk
     * ProductionSchedule MILIK Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}