<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminNav extends Model
{

    /**
     * 获取全部菜单
     * @param  string $type  tree获取树形结构 level获取层级结构
     * @param  string $order 排序字段
     * @return array       	 结构数据
     */
    public function getTreeData($type='tree',$order='')
    {
        $data = $this
            ->where('pid', 0)
            ->get();
        foreach ($data as $k => $v) {
            $data[$k]->child = $this
                ->where('pid', $v->id)
                ->get();
        }
        return $data;
    }
}
