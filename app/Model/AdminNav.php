<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

use app\Library\Org\Data;
use app\Library\Org\Auth;
use app\Library\Org\Test;

class AdminNav extends Model
{



    /**
     * 获取全部菜单
     * @param  string $type tree获取树形结构 level获取层级结构
     * @return array       	结构数据
     */
    public function getTreeData($type='tree',$order='')
    {
        if (empty($order)) {
            $data=$this->get()->toArray();
        }else{
            $prefix=config('database.connections.mysql.prefix');
            $sql="SELECT * FROM {$prefix}admin_navs ORDER BY order_number IS NULL,{$order}";
            $data=DB::select($sql);
            $data=dbObjectToArray($data);
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
