<?php
namespace App\Models;

use DB;
use app\Library\Org\Data;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
            // 显示有权限的菜单

        }
        return $data;
    }
}
