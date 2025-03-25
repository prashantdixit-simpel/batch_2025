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
        Schema::create('customer_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->decimal('amount',10,2);
            $table->tinyInteger('status')->default(1)->comment('1:pending,2:accepeted,3:packing,4:shipped,5:out for delivery,6:delivered,7:cacelled');
            $table->integer('payment_method_id');
            $table->tinyInteger('payment_status')->comment('1:pending,2completed,3:failed');
            $table->string('trx_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_orders');
    }
};
