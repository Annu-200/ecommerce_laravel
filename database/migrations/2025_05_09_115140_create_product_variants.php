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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->decimal('price', 10,2);
            $table->decimal('regular_price', 10,2);
            $table->integer('stock_quantity')->nullable();
            $table->string('size')->nullable();
            $table->string('color')->nullable();
            $table->string('sku')->nullable();
            $table->string('thumbnail')->nullable();
            $table->json('gallery')->nullable();
            $table->foreignId('product_id')->references('product_id')->on('products')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
