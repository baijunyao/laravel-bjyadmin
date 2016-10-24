<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    /**
     * 定义表名
     *
     * @var string
     */
    protected $table = 'role_user';

    /**
     * 不使用created_at和updated_at
     *
     * @var
     */
    public $timestamps = false;


    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'role_id'
    ];


    
}
