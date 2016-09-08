<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use app\Library\Org\Data;
class AdminNav extends Model
{
    public function getTreeData($type='tree',$order)
    {
        $data=$this->get()->toArray();
        $test=Data::tree($data,'name','id','pid');
        p($test);
    }
}
