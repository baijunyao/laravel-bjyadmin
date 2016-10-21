<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Validator;
use Session;

use app\Library\Org\Data;

use Illuminate\Database\Eloquent\Model;

class AdminNav extends Model
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
