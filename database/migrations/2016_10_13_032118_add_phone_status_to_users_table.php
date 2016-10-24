<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPhoneStatusToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //增加phone字段
            $table->bigInteger('phone')
                ->after('remember_token')
                ->unique()
                ->unsigned()
                ->nullable()
                ->comment('手机号');
            //增加status字段
            $table->tinyInteger('status')
                ->after('phone')
                ->unsigned()
                ->nullable()
                ->default(1)
                ->comment('状态');
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
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
