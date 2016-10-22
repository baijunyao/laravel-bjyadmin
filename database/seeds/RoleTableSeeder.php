<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        DB::table('roles')->delete();
        DB::table('roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'admin',
                'display_name' => '超级管理员',
                'created_at' => NULL,
                'updated_at' => '2016-10-11 10:18:45',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'article',
                'display_name' => '文章编辑',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}
