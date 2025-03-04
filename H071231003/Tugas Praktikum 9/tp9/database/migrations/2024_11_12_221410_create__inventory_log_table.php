<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('_inventory_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['restock', 'sold']);
            $table->integer('quantity');
            $table->date('date');
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('_inventory_log');
    }
};
