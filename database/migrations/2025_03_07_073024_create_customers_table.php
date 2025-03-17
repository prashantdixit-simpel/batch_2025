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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('customer full name');
            $table->string('email_id')->unique()->comment('customer personal email');
            $table->unsignedBigInteger('phone_number')->unique()->comment('customer personal number');
            $table->string('address')->nullable();
            $table->string('zip_code',6)->nullable();
            $table->boolean('status')->default('0')->comment('0:inactive,1:active');
            $table->date('dob')->nullable();
            $table->unsignedBigInteger('alternate_number')->nullable()->comment('customer alternate number');
            $table->enum('gender',['male','female','others'])->nullable();
            $table->decimal('wallet_balance',10,2)->default(0);
            $table->tinyInteger('marital_status')->nullable()->comment('0:Bachelor,1:Married,2:Divorced');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
