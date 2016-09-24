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

    /**
     * 修改数据
     *
     * @param $data 需要修改的数据
     * @return bool 是否成功
     */
    public function editData($data)
    {
        //验证是否通过
        if (!$this->validate($data)) {
            return false;
        }
        //如果存在_token字段；则删除
        if (isset($data['_token'])) {
            unset($data['_token']);
        }
        //修改数据
        $result=$this
            ->where('id',$data['id'])
            ->update($data);
        if ($result) {
            Session::flash('alert-message','修改成功');
            Session::flash('alert-class','alert-success');
            return $result;
        }else{
            return false;
        }
    }

    /**
     * 排序
     * @param  $data 需要排序的数据
     * @return bool  是否成功
     */
    public function orderData($data)
    {
        //如果存在_token字段；则删除
        if (isset($data['_token'])) {
            unset($data['_token']);
        }
        //判断是否有需要排序的字段
        if (empty($data)) {
            Session::flash('alert-message','没有需要排序的数据');
            Session::flash('alert-class','alert-success');
            return false;
        }
        //循环修改数据
        foreach ($data as $k => $v){
            $v = empty($v) ? null : $v;
            $edit_data=[
                'order_number'=>$v
            ];
            //修改数据
            $result=$this
                ->where('id',$k)
                ->update($edit_data);
        }
        if ($result) {
            Session::flash('alert-message','修改成功');
            Session::flash('alert-class','alert-success');
            return $result;
        }else{
            return false;
        }
    }

}
