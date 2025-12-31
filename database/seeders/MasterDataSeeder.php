<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Product;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Masukkan data Customer Dummy
        Customer::create([
            'company_name' => 'PT Astra Honda Motor',
            'code' => 'AHM',
            'address' => 'Cikarang Industrial Estate',
            'phone' => '021-123456'
        ]);

        Customer::create([
            'company_name' => 'PT Komatsu Indonesia',
            'code' => 'KMT',
            'address' => 'Cakung, Jakarta Utara',
            'phone' => '021-987654'
        ]);

        // 2. Masukkan data Produk Dummy (Agar dropdown produk juga ada isinya)
        Product::create([
            'part_number' => 'VLV-001',
            'part_name' => 'Valve Body 3 Inch',
            'material_type' => 'FC250',
            'weight_per_unit_kg' => 5.5,
            'price' => 150000
        ]);

        Product::create([
            'part_number' => 'PMP-HSG',
            'part_name' => 'Pump Housing',
            'material_type' => 'FCD450',
            'weight_per_unit_kg' => 12.0,
            'price' => 450000
        ]);
    }
}