<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Base
{
    //开启如删除
    use SoftDeletes;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @param 需要添加的数据 $data
     * @return bool
     */
    public function addData($data)
    {
        //如果传password 则加密
        if (!empty($data['password'])) {
            $data['password']=bcrypt($data['password']);
        }
        //添加数据
        $result=$this
            ->create($data)
            ->id;
        if ($result) {
            session()->flash('alert-message','添加成功');
            session()->flash('alert-class','alert-success');
            return $result;
        }else{
            return false;
        }
    }

    /**
     * 修改数据
     *
     * @param $map  where条件
     * @param $data 需要修改的数据
     * @return bool 是否成功
     */
    public function editData($map, $data)
    {
        //如果存在_token字段；则删除
        if (isset($data['_token'])) {
            unset($data['_token']);
        }

        //如果传password 则加密
        if (!empty($data['password'])) {
            $data['password']=bcrypt($data['password']);
        }

        //修改数据
        $result=$this
            ->where($map)
            ->update($data);
        if ($result) {
            session()->flash('alert-message','修改成功');
            session()->flash('alert-class','alert-success');
            return $result;
        }else{
            return false;
        }
    }

    /**
     * 删除数据
     *
     * @param  array $map   where 条件数组形式
     * @return bool         是否成功
     */
    public function deleteData($map)
    {
        //软删除
        $result=$this
            ->where($map)
            ->delete();
        if ($result) {
            session()->flash('alert-message','操作成功');
            session()->flash('alert-class','alert-success');
            return $result;
        }else{
            return false;
        }
    }

    /**
     * 搜索用户
     *
     * @param  $search_word  搜索词
     * @param  $type         类型 null:全部   1：顾问  2：学生
     * @return mixed        搜索到的用户
     */
    public function search($search_word, $type = null)
    {
        if ($type == null) {
            $data=$this->where('name', 'like', "%$search_word%")
                ->orWhere('email', 'like', "%$search_word%")
                ->orWhere('phone', 'like', "%$search_word%")
                ->get();
        }else{
            $data=$this->where('type', $type)
                ->where('name', 'like', "%$search_word%")
                ->orWhere('email', 'like', "%$search_word%")
                ->orWhere('phone', 'like', "%$search_word%")
                ->get();
        }
        return $data;
    }


}
