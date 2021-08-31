<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
        //Admin
            [
                'full_name'=> 'Wafa Admin',
                'username'=>'Admin',
                'email'=>'admin@navgily.com',
                'password'=>Hash::make(12345),
                'role'=>'admin',
                'status'=>'active'
            ],
            //Vendor
            [
                'full_name'=> 'Wafa vendor',
                'username'=>'Vendor',
                'email'=>'vendor@gmail.com',
                'password'=>Hash::make(12345),
                'role'=>'vendor',
                'status'=>'active'
            ],
            //Customer
            [
                'full_name'=> 'Wafa Customer ',
                'username'=>'Customer',
                'email'=>'customer@gmail.com',
                'password'=>Hash::make(12345),
                'role'=>'customer',
                'status'=>'active'
            ],
        ]);
    }
}
