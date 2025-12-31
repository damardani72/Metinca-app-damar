<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            
            $table->string('material_code')->unique(); // Misal: MAT-IRON-001
            $table->string('name');                    // Misal: Plat Besi 3mm
            $table->string('unit');                    // Satuan (Kg, Lembar, Pcs)
            
            $table->integer('current_stock')->default(0); // Stok saat ini
            $table->integer('minimum_stock')->default(10); // Batas aman stok
            
            $table->text('description')->nullable();   // Keterangan tambahan
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};