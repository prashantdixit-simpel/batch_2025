<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->text('description');
            $table->boolean('status')->default(1)->comment('0:inactive,1active');
            $table->timestamps();
        });


        DB::table('payment_methods')->insert([
            array('id'=>1,'title'=>'Net Banking','description'=>'Net Banking','status'=>1,'created_at'=>now(),'updated_at'=>now()),
            array('id'=>2,'title'=>'Debit Card','description'=>'Debit Card','status'=>1,'created_at'=>now(),'updated_at'=>now()),
            array('id'=>3,'title'=>'Credit Card','description'=>'Credit Card','status'=>1,'created_at'=>now(),'updated_at'=>now()),
            array('id'=>4,'title'=>'UPI','description'=>'UPIg','status'=>1,'created_at'=>now(),'updated_at'=>now()),
            array('id'=>5,'title'=>'COD','description'=>'COD','status'=>1,'created_at'=>now(),'updated_at'=>now()),

        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
