<?php

namespace app\admin\model;

use think\Model;

class AuthRule extends Model
{
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

    public static function getRuleall($pid=0,$level=0){
        $res=self::where('pid',$pid)->select();
        static $arr=[];
        foreach ($res as $v){
            $v['level']=$level;
            $arr[]=$v;
            self::getRuleall($v['id'],$level+1);
        }
        return $arr;
    }
    //判断是否有子权限
    public static function checkchild($pid){
        $res=self::get(['pid'=>$pid]);
        if($res){
            return false;
        }
        return true;
    }

    /**
     * 权限列表
     * @param int $pid
     * @param int $level
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getRule($pid=0,$level=0,$groupid){
        $rules=db("auth_group")->where('id',$groupid)->field("rules")->find();
        $rules=explode(",",$rules['rules']);
        $res=self::where('pid',$pid)->select();
        $arr=[];
        foreach ($res as $v){
            $tmp=[];
            $tmp['name']=$v['title'];
            $tmp['value']=$v['id'];
            $tmp['checked']=false;
            if(is_array($rules)){
                if(in_array($v['id'],$rules)){
                    $tmp['checked']=true;
                }
            }
            $tmp['list']=self::getRule($v['id'],$level+1,$groupid);
            $arr[]=$tmp;
        }
        return $arr;
    }
}
