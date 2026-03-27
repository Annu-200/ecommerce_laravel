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
          
            $table->id('product_id');
            $table->string('product_name');
            $table->smallInteger('status')->defualt(1);
            $table->string('slug')->unique();
            $table->text('pro_description');
            $table->string('short_description')->nullable();

            $table->foreignId('brand_id')->references('id')
            ->on('brands')->onDelete('cascade')->onUpdate('cascade');

            $table->foreignId('subcat_id')->references('subcat_id')->on('subcategories')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products_table_');
    }
};
