<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            
            $table->string('part_number')->nullable(); // Nomor Part (Opsional)
            $table->string('name'); // Nama Produk
            $table->string('material')->nullable(); // Jenis Material
            $table->float('weight')->default(0); // Berat per Unit (KG)
            $table->decimal('price', 15, 2)->default(0); // Harga (Opsional)
            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
