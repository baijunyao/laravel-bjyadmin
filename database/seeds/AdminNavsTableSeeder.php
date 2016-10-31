<?php

use Illuminate\Database\Seeder;

class AdminNavsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_navs')->delete();
        DB::table('admin_navs')->insert(array (
            0 => 
            array (
                'id' => 1,
                'pid' => 0,
                'name' => '系统设置',
                'mca' => 'admin/shownav/config',
                'ico' => 'cog',
                'order_number' => 1,
                'created_at' => NULL,
                'updated_at' => '2016-09-21 06:16:22',
            ),
            1 => 
            array (
                'id' => 2,
                'pid' => 1,
                'name' => '菜单管理',
                'mca' => 'admin/admin_nav/index',
                'ico' => NULL,
                'order_number' => NULL,
                'created_at' => NULL,
                'updated_at' => '2016-09-21 06:16:22',
            ),
            2 => 
            array (
                'id' => 7,
                'pid' => 4,
                'name' => '权限管理',
                'mca' => 'admin/permission/index',
                'ico' => '',
                'order_number' => 1,
                'created_at' => NULL,
                'updated_at' => '2016-09-21 06:16:22',
            ),
            3 => 
            array (
                'id' => 4,
                'pid' => 0,
                'name' => '权限控制',
                'mca' => 'admin/shownav/rule',
                'ico' => 'expeditedssl',
                'order_number' => 2,
                'created_at' => NULL,
                'updated_at' => '2016-09-21 06:16:22',
            ),
            4 => 
            array (
                'id' => 8,
                'pid' => 4,
                'name' => '角色管理',
                'mca' => 'admin/role/index',
                'ico' => '',
                'order_number' => 2,
                'created_at' => NULL,
                'updated_at' => '2016-09-21 06:16:22',
            ),
            5 => 
            array (
                'id' => 9,
                'pid' => 4,
                'name' => '管理员列表',
                'mca' => 'admin/role_user/index',
                'ico' => '',
                'order_number' => 3,
                'created_at' => NULL,
                'updated_at' => '2016-09-21 06:16:22',
            ),
            6 => 
            array (
                'id' => 16,
                'pid' => 0,
                'name' => '用户管理',
                'mca' => 'admin/shownav/user',
                'ico' => 'users',
                'order_number' => 4,
                'created_at' => NULL,
                'updated_at' => '2016-09-21 06:16:22',
            ),
            7 => 
            array (
                'id' => 17,
                'pid' => 16,
                'name' => '用户列表',
                'mca' => 'admin/user/index',
                'ico' => '',
                'order_number' => NULL,
                'created_at' => NULL,
                'updated_at' => '2016-09-21 06:16:22',
            ),
            8 => 
            array (
                'id' => 36,
                'pid' => 0,
                'name' => '文章管理',
                'mca' => 'admin/shownav/posts',
                'ico' => 'th',
                'order_number' => 6,
                'created_at' => NULL,
                'updated_at' => '2016-09-21 06:16:22',
            ),
            9 => 
            array (
                'id' => 37,
                'pid' => 36,
                'name' => '文章列表',
                'mca' => 'admin/posts/index',
                'ico' => '',
                'order_number' => NULL,
                'created_at' => NULL,
                'updated_at' => '2016-09-21 06:16:22',
            ),
        ));
        
        
    }
}
