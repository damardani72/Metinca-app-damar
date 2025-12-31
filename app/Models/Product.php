<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'part_number',
        'name',
        'material',
        'weight', // <--- Ini yang Anda cari
        'price',
        'description',
    ];
}