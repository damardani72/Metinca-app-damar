<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales_order_items', function (Blueprint $table) {
            $table->id();
            
            // --- BAGIAN PENTING YANG TADI HILANG ---
            // Ini membuat kolom 'sales_order_id'
            $table->foreignId('sales_order_id')->constrained('sales_orders')->onDelete('cascade');
            
            // Ini membuat kolom 'product_id'
            $table->foreignId('product_id')->constrained('products');
            // ---------------------------------------
            
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales_order_items');
    }
};