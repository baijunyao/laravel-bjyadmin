<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use app\Library\Org\Data;
use app\Library\Org\Auth;

class AdminNav extends Model
{
    public function getTreeData($type='tree',$order)
    {
        $data=$this->get()->toArray();

        // 获取树形或者结构数据
        if($type=='tree'){
            $data=Data::tree($data,'name','id','pid');
        }elseif($type="level"){
            $data=Data::channelLevel($data,0,'&nbsp;','id');

            // 显示有权限的菜单
            $auth=new Auth();
            foreach ($data as $k => $v) {
                if ($auth->check($v['mca'],$_SESSION['user']['id'])) {
                    foreach ($v['_data'] as $m => $n) {
                        if(!$auth->check($n['mca'],$_SESSION['user']['id'])){
                            unset($data[$k]['_data'][$m]);
                        }
                    }
                }else{
                    // 删除无权限的菜单
                    unset($data[$k]);
                }
            }
        }
        // p($data);die;
        return $data;
        p($test);
    }
}
