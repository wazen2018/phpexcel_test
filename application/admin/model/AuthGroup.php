<?php

namespace app\admin\model;

use think\Model;

class AuthGroup extends Model
{
    protected static function init()
    {
        self::event('after_delete', function ($data) {
            $groupid=$data->id;
            db('auth_group_access')->where("group_id",$groupid)->delete();
        });
    }
    //

    public static function store($data){
        if(isset($data['id'])){
            $scene='edit';
            $msg="修改";
            $action="update";
        }else{
            $scene='add';
            $msg="添加";
            $action="create";
        }
        if(isset($data['setrule'])){
            if($data['setrule']==1){
                if(isset($data['rules'])){
                    $data['rules']=implode(",",$data['rules']);
                }else{
                    $data['rules']="";
                }
            }
        }
        //验证数据的合法性
//        $valiManager=validate("Manager");
//        if(!$valiManager->scene($scene)->check($data)){
//            return returnjson(0,$valiManager->getError());
//        }
        //写入数据库
        $result=self::$action($data);
        if(!$result){
            return returnjson(0,"{$msg}失败");
        }
        return returnjson(1,"{$msg}成功");
    }

}
