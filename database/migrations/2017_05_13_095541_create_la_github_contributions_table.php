<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLaGithubContributionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('github_contributions', function(Blueprint $table)
		{
			$table->increments('id')->comment('活跃统计id');
			$table->string('name', 10)->default('')->comment('姓名');
			$table->string('nickname',40)->default('')->comment('github用户名');
			$table->text('content')->comment('统计的详情');
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
		Schema::drop('github_contributions');
	}

}
