<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AuthRule extends Model
{
    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = ['id','pid','name','title','status','type','condition'];


    /**
     * 自动验证
     *
     * @param $data 需要验证的数据
     * @return bool 验证是否通过
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
     * @param $data 需要添加的数据
     * @return bool 是否成功
     */
    public function editData($data)
    {
        //验证是否通过
        if (!$this->validate($data)) {
            return false;
        }
        $edit_data=[
            'name'=>$data['name'],
            'mca'=>$data['mca'],
            'ico'=>$data['ico']
        ];
        //修改数据
        $result=$this
            ->where('id',$data['id'])
            ->update($edit_data);
        if ($result) {
            Session::flash('alert-message','修改成功');
            Session::flash('alert-class','alert-success');
            return $result;
        }else{
            return false;
        }
    }

    /**
     * 添加数据
     *
     * @param  $id  需要添加的数据
     * @return bool 是否成功
     */
    public function deleteData($id)
    {
        //删除数据
        $result=$this
            ->where('id',$id)
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
     * 排序
     * @param  $data 需要排序的数据
     * @return bool  是否成功
     */
    public function orderData($data)
    {
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
