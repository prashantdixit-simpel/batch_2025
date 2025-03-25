<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class CustomerOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        for($i=0;$i<10;$i++)
        {
            $order_id = DB::table('customer_orders')->insertGetId([
                'customer_id'=>Customer::all()->random()->value('id'),
                'amount'=>2000,
                'status'=>'1',
                'payment_method_id'=>5,
                'payment_status'=>1,
                'created_at'=>now(),
                'updated_at'=>now(),
            ]);
    
            DB::table('customer_order_items')->insert([
                'customer_order_id'=>$order_id,
                'item_id'=>1,
                'amount'=>1000,
                'quantity'=>2,
                'created_at'=>now(),
                'updated_at'=>now(),
            ]);
        }
    }
}
