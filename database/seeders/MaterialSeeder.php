<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Material;

class MaterialSeeder extends Seeder
{
    public function run(): void
    {
        // Data 1: Besi
        Material::create([
            'material_code' => 'MAT-001', 
            'name'          => 'Plat Besi 3mm', 
            'unit'          => 'Lembar', 
            'current_stock' => 50, 
            'minimum_stock' => 5
        ]);

        // Data 2: Cat
        Material::create([
            'material_code' => 'MAT-002', 
            'name'          => 'Cat Epoksi Grey', 
            'unit'          => 'Kaleng', 
            'current_stock' => 20, 
            'minimum_stock' => 10
        ]);
        
        // Data 3: Baut (Tambahan)
        Material::create([
            'material_code' => 'MAT-003', 
            'name'          => 'Baut M10 x 50mm', 
            'unit'          => 'Pcs', 
            'current_stock' => 1000, 
            'minimum_stock' => 200
        ]);
    }
}