<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use Session;

class Base extends Model
{
    /**
     * 添加数据
     *
     * @param $data 需要添加的数据
     * @return bool 是否成功
     */
    public function addData($data)
    {
        //验证是否通过
        if (!$this->validate($data)) {
            return false;
        }
        //添加数据
        $result=$this
            ->create($data)
            ->id;
        if ($result) {
            Session::flash('alert-message','添加成功');
            Session::flash('alert-class','alert-success');
            return $result;
        }else{
            return false;
        }
    }
    
}
