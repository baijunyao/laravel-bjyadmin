<?php

namespace App\Providers;

use Auth;
use App\Models\AdminNav;
use Illuminate\Support\ServiceProvider;

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
            //分配菜单数据
            $adminNavModel = new AdminNav();
            $adminNav = $adminNavModel->getTreeData('level', 'order_number');
            $view->with('adminNav', $adminNav);
            //分配登录用户的数据
            $loginUserData = Auth::user()->toArray();
            $view->with('loginUserData', $loginUserData);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
