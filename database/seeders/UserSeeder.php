<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // add super admin user
        DB::table('users')->insert([
        'name'          => 'Super Admin',
        'email'         => 'admin@site.com',
        'telephone'     => '000 000 000',
        'user_type_id'  =>  1,
        'status'        => true,
        'password'      => Hash::make('admin@1234'),
        ]);

        $usertypes = array([
            [
                'id'    =>      1,
                'name'  =>      'Super Admin'
            ],
            [
                'id'    =>      2,
                'name'  =>      'User'
            ],
            [
                'id'    =>      3,
                'name'  =>      'Public'
            ]
        ]);

        foreach($usertypes as $type){
            DB::table('user_type')->insert($type);
        }
    }
}
