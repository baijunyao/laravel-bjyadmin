<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\AdminNav;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //分配后台通用的左侧导航数据
        view()->composer('admin/*',function($view){
            $adminNavModel = new AdminNav();
            $adminNav = $adminNavModel->getTreeData('level');
            //p($adminNav);die;
            $view->with('adminNav', $adminNav);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
