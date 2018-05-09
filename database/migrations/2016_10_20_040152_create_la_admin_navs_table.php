<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLaAdminNavsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('admin_navs', function(Blueprint $table)
		{
			$table->increments('id')->comment('菜单id');
			$table->integer('pid')->unsigned()->nullable()->default(0)->comment('父级id');
			$table->string('name', 15)->nullable()->default('')->comment('菜单名');
			$table->string('mca')->nullable()->default('')->comment('菜单url');
			$table->string('ico', 20)->nullable()->default('')->comment('图标');
			$table->integer('order_number')->unsigned()->nullable()->comment('排序');
			$table->timestamps();
			//增加deleted_at字段
            $table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('admin_navs');
	}

}
