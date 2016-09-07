<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AdminNav extends Model
{
    public function getTreeData($type='tree',$order)
    {
        $data=$this->get()->toArray();
        p($data);
    }
}
