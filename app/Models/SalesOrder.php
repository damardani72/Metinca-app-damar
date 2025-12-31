<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    use HasFactory;

    // TAMBAHKAN INI AGAR DATA BISA DISIMPAN
    protected $guarded = []; 

    // Relasi ke Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relasi ke Item Barang
    public function items()
    {
        return $this->hasMany(SalesOrderItem::class);
    }
}