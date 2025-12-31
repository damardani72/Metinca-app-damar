<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrderItem extends Model
{
    use HasFactory;

    // TAMBAHKAN INI JUGA
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}