<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->delete();
        DB::table('permissions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'pid' => 20,
                'name' => 'admin/shownav/nav',
                'display_name' => '菜单管理',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'pid' => 1,
                'name' => 'admin/admin_nav/index',
                'display_name' => '菜单列表',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'pid' => 1,
                'name' => 'admin/admin_nav/store',
                'display_name' => '添加菜单',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'pid' => 1,
                'name' => 'admin/admin_nav/update',
                'display_name' => '修改菜单',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'pid' => 1,
                'name' => 'admin/admin_nav/destroy',
                'display_name' => '删除菜单',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'pid' => 0,
                'name' => 'admin/index/index',
                'display_name' => '后台首页',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'pid' => 21,
                'name' => 'admin/permission/index',
                'display_name' => '权限列表',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'pid' => 7,
                'name' => 'admin/permission/store',
                'display_name' => '添加权限',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'pid' => 7,
                'name' => 'admin/permission/update',
                'display_name' => '修改权限',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'pid' => 7,
                'name' => 'admin/permission/destroy',
                'display_name' => '删除权限',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'pid' => 21,
                'name' => 'admin/role/index',
                'display_name' => '角色列表',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'pid' => 11,
                'name' => 'admin/role/store',
                'display_name' => '添加角色',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'pid' => 11,
                'name' => 'admin/role/update',
                'display_name' => '修改角色',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'pid' => 11,
                'name' => 'admin/role/destroy',
                'display_name' => '删除角色',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'pid' => 11,
                'name' => 'admin/role/permission_role_show',
                'display_name' => '分配权限页面',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => '2016-09-24 09:16:38',
            ),
            15 => 
            array (
                'id' => 16,
                'pid' => 19,
                'name' => 'admin/role_user/search_user',
                'display_name' => '搜索用户',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => '2016-09-24 09:18:59',
            ),
            16 => 
            array (
                'id' => 19,
                'pid' => 21,
                'name' => 'admin/role_user/index',
                'display_name' => '管理员列表',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            17 => 
            array (
                'id' => 20,
                'pid' => 0,
                'name' => 'admin/shownav/config',
                'display_name' => '系统设置',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            18 => 
            array (
                'id' => 21,
                'pid' => 0,
                'name' => 'admin/shownav/rule',
                'display_name' => '权限控制',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            19 => 
            array (
                'id' => 64,
                'pid' => 1,
                'name' => 'admin/admin_nav/order',
                'display_name' => '菜单排序',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            20 => 
            array (
                'id' => 96,
                'pid' => 6,
                'name' => 'admin/index/welcome',
                'display_name' => '欢迎界面',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            21 => 
            array (
                'id' => 104,
                'pid' => 0,
                'name' => 'admin/shownav/posts',
                'display_name' => '文章管理',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            22 => 
            array (
                'id' => 105,
                'pid' => 104,
                'name' => 'admin/posts/index',
                'display_name' => '文章列表',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            23 => 
            array (
                'id' => 106,
                'pid' => 105,
                'name' => 'admin/posts/add_posts',
                'display_name' => '添加文章',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            24 => 
            array (
                'id' => 107,
                'pid' => 105,
                'name' => 'admin/posts/edit_posts',
                'display_name' => '修改文章',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            25 => 
            array (
                'id' => 108,
                'pid' => 105,
                'name' => 'admin/posts/delete_posts',
                'display_name' => '删除文章',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            26 => 
            array (
                'id' => 109,
                'pid' => 104,
                'name' => 'admin/posts/category_list',
                'display_name' => '分类列表',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            27 => 
            array (
                'id' => 110,
                'pid' => 109,
                'name' => 'admin/posts/add_category',
                'display_name' => '添加分类',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            28 => 
            array (
                'id' => 111,
                'pid' => 109,
                'name' => 'admin/posts/edit_category',
                'display_name' => '修改分类',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            29 => 
            array (
                'id' => 112,
                'pid' => 109,
                'name' => 'admin/posts/delete_category',
                'display_name' => '删除分类',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            30 => 
            array (
                'id' => 117,
                'pid' => 109,
                'name' => 'admin/posts/order_category',
                'display_name' => '分类排序',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            31 => 
            array (
                'id' => 118,
                'pid' => 105,
                'name' => 'admin/posts/order_posts',
                'display_name' => '文章排序',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            32 => 
            array (
                'id' => 123,
                'pid' => 19,
                'name' => 'admin/role_user/add_user_to_group',
                'display_name' => '添加用户到角色',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => '2016-09-24 09:34:16',
            ),
            33 => 
            array (
                'id' => 124,
                'pid' => 19,
                'name' => 'admin/role_user/create',
                'display_name' => '添加管理员页面',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => '2016-09-24 09:36:31',
            ),
            34 => 
            array (
                'id' => 125,
                'pid' => 19,
                'name' => 'admin/role_user/edit',
                'display_name' => '修改管理员页面',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => '2016-09-24 09:37:13',
            ),
            35 => 
            array (
                'id' => 141,
                'pid' => 11,
                'name' => 'admin/role/permission_role_update',
                'display_name' => '分配权限功能',
                'description' => NULL,
                'created_at' => '2016-09-24 09:17:06',
                'updated_at' => '2016-09-24 09:17:06',
            ),
            36 => 
            array (
                'id' => 142,
                'pid' => 19,
                'name' => 'admin/role_user/delete_user_from_group',
                'display_name' => '从角色中删除用户',
                'description' => NULL,
                'created_at' => '2016-09-24 09:34:33',
                'updated_at' => '2016-09-24 09:34:33',
            ),
            37 => 
            array (
                'id' => 143,
                'pid' => 19,
                'name' => 'admin/role_user/store',
                'display_name' => '添加管理员功能',
                'description' => NULL,
                'created_at' => '2016-09-24 09:36:50',
                'updated_at' => '2016-09-24 09:36:50',
            ),
            38 => 
            array (
                'id' => 144,
                'pid' => 19,
                'name' => 'admin/role_user/update',
                'display_name' => '修改管理员功能',
                'description' => NULL,
                'created_at' => '2016-09-24 09:37:29',
                'updated_at' => '2016-09-24 09:37:29',
            ),
            39 => 
            array (
                'id' => 145,
                'pid' => 0,
                'name' => 'admin/shownav/user',
                'display_name' => '用户管理',
                'description' => NULL,
                'created_at' => '2016-10-25 09:00:32',
                'updated_at' => '2016-10-25 09:00:32',
            ),
            40 => 
            array (
                'id' => 146,
                'pid' => 145,
                'name' => 'admin/user/index',
                'display_name' => '用户列表',
                'description' => NULL,
                'created_at' => '2016-10-25 09:03:53',
                'updated_at' => '2016-10-25 09:03:53',
            ),
        ));
        
        
    }
}
