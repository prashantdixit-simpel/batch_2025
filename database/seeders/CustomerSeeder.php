<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('customers')->insert([
            array('name'=>'TEST1','email_id'=>'test01@test.com','phone_number'=>rand(1111111111,9999999999)),
            array('name'=>'TEST10','email_id'=>'test10@test.com','phone_number'=>rand(1111111111,9999999999)),
            array('name'=>'TEST11','email_id'=>'test11@test.com','phone_number'=>rand(1111111111,9999999999)),
        ]);
    }
}
