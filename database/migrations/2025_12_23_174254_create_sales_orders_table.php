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
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->id();
            $table->string('po_number')->unique(); // Nomor PO
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->date('order_date'); // Tanggal Order
            
            // PERBAIKAN: Pastikan namanya 'delivery_date' (BUKAN delivery_deadline)
            $table->date('delivery_date'); 
            
            $table->text('notes')->nullable(); // Catatan
            $table->string('status')->default('pending'); // Status: pending, process, done
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_orders');
    }
};
