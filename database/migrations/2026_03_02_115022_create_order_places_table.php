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
        Schema::create('order_places', function (Blueprint $table) {
          
             $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->bigInteger('phone');
//address
            $table->string('address');
            $table->string('apartment')->nullable();
            $table->string('country')->default('India');
            $table->string('city');
            $table->string('state');
            $table->string('pin');
//total detail
            $table->decimal('subtotal', 10, 2);
            $table->decimal('taxt', 10, 2);
            $table->decimal('total', 10, 2);
// payment and order status
            $table->string('payment_mode')->default('pending');
            $table->string('payment_status')->default('pending');
            $table->string('status')->default('pending');
            $table->text('order_note')->nullable();

          
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_places');
    }
};
