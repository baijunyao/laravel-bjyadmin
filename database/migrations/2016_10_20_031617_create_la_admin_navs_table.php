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
		Schema::create('la_admin_navs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('pid')->unsigned()->nullable()->default(0);
			$table->string('name', 15)->nullable()->default('');
			$table->string('mca')->nullable()->default('');
			$table->string('ico', 20)->nullable()->default('');
			$table->integer('order_number')->unsigned()->nullable();
			$table->timestamps();
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
		Schema::drop('la_admin_navs');
	}

}
