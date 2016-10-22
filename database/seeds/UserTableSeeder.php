<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->delete();
        DB::table('users')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'name' => 'baijunyao',
                    'email' => 'baijunyao@baijunyao.com',
                    'password' => '$2y$10$q/2hpiC3nqv6UCeL4mm.nOK/z/dIv4lRryN4aKI0erJSTH6dFFkgW',
                    'remember_token' => NULL,
                    'phone' => NULL,
                    'created_at' => '2016-10-22 07:35:12',
                    'updated_at' => '2016-10-22 07:35:12',
                    'deleted_at' => NULL,
                ),
            1 =>
                array (
                    'id' => 2,
                    'name' => 'test',
                    'email' => 'test@baijunyao.com',
                    'password' => '$2y$10$q/2hpiC3nqv6UCeL4mm.nOK/z/dIv4lRryN4aKI0erJSTH6dFFkgW',
                    'remember_token' => NULL,
                    'phone' => NULL,
                    'created_at' => '2016-10-22 07:35:12',
                    'updated_at' => '2016-10-22 07:35:12',
                    'deleted_at' => NULL,
                ),
        ));

    }
}
