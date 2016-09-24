<?php

namespace App\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Validator;
use Session;

use app\Library\Org\Data;
use app\Library\Org\Auth;



class AdminNav extends Base
{
    //开启如删除
    use SoftDeletes;

    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = ['id','pid','name','mca','ico','order_number'];

    /**
     * 自动验证
     *
     * @param  array $data 需要验证的数据
     * @return bool        验证是否通过
     */
    public function validate($data)
    {
        $rules=[
            'name'=>'required',
            'mca'=>'required'

        ];
        $attributes=[
            'name'=>'菜单名',
            'mca'=>'链接'
        ];
        $validator=Validator::make($data,$rules,[],$attributes);
        if ($validator->fails()) {
            $error=$validator->messages()->first();
            Session::flash('alert-message',$error);
            Session::flash('alert-class','alert-danger');
            return false;
        }
        return true;
    }

    /**
     * 添加数据
     *
     * @param  array $map  需要添加的数据
     * @return bool        是否成功
     */
    public function deleteData($map)
    {
        //暂时的应用场景是必须传id处理
        if (empty($map['id'])) {
            Session::flash('alert-message','此接口设计的必须传id');
            Session::flash('alert-class','alert-danger');
            return false;
        }
        //查找子权限的数量
        $pids=$this
            ->where('pid', $map['id'])
            ->count();
        if ($pids !== 0) {
            Session::flash('alert-message','必须先删除子权限');
            Session::flash('alert-class','alert-danger');
            return false;
        }
        //删除数据
        $result=$this
            ->where($map)
            ->delete();
        if ($result) {
            Session::flash('alert-message','删除成功');
            Session::flash('alert-class','alert-success');
            return $result;
        }else{
            return false;
        }
    }
    
    /**
     * 获取全部菜单
     * @param  string $type  tree获取树形结构 level获取层级结构
     * @param  string $order 排序字段
     * @return array       	 结构数据
     */
    public function getTreeData($type='tree',$order='')
    {
        if (empty($order)) {
            $data=$this->get()->toArray();
        }else{
            $data=$this
                ->orderBy(DB::raw('order_number IS NULL,'.$order))
                ->get()
                ->toArray();
        }
        // 获取树形或者结构数据
        if($type=='tree'){
            $data=Data::tree($data,'name','id','pid');
        }elseif($type="level"){
            $data=Data::channelLevel($data,0,'&nbsp;','id');
            $uid=session('user.id');
            // 显示有权限的菜单
            $auth=new Auth();
            foreach ($data as $k => $v) {
                if ($auth->check($v['mca'],$uid)) {
                    foreach ($v['_data'] as $m => $n) {
                        if(!$auth->check($n['mca'],$uid)){
                            unset($data[$k]['_data'][$m]);
                        }
                    }
                }else{
                    // 删除无权限的菜单
                    unset($data[$k]);
                }
            }
        }
        return $data;
    }





}
