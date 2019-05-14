<?php

namespace app\admin\model;

use think\Model;

class Manager extends Model
{
    protected static function init()
    {
        self::event('after_delete', function ($data) {
            $uid=$data->id;
            db('auth_group_access')->where("uid",$uid)->delete();
        });
    }
    public function setPasswdAttr($value)
    {
        if($value!="" && $value!=null){
            return md5($value);
        }

    }
    //
    protected $resultSetType = 'collection';
    //自动写入时间戳
    protected $autoWriteTimestamp = true;
    //获取所有的管理员数据
    public static function getlistall(){
        $list=self::all(function($query){
            $query->order('id', 'Asc');
        })->toArray();
        return $list;
    }
    //添加/修改管理员
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
        if($data['passwd']==$data['repasswd'] && $data['passwd']==""){
            unset($data['passwd']);
            unset($data['repasswd']);
        }
        //验证数据的合法性
        $valiManager=validate("Manager");
        if(!$valiManager->scene($scene)->check($data)){
//            return ['code'=>0,'msg'=>$valiManager->getError()];
            return returnjson(0,$valiManager->getError());
        }
        //写入数据库
        unset($data['repasswd']);
//        $result=db('manager')->insert($data);
        $result=self::$action($data);
        if(!$result){
//            return ['code'=>0,'msg'=>"{$msg}失败"];
            return returnjson(0,"{$msg}失败");
        }
//        return ['code'=>1,'msg'=>"{$msg}成功"];
        $uid=$result->id;
        $datas=['uid'=>$uid,'group_id'=>$data['groupid']];
        //判断中间表中是否存在记录
        $res=db("auth_group_access")->where("uid",$uid)->find();
        if($res){
            db("auth_group_access")->where('uid',$uid)->update(['group_id'=>$data['groupid']]);
        }else{
            db("auth_group_access")->insert($datas);
        }

        return returnjson(1,"{$msg}成功");
    }
    //修改管理员
//    public static function updatemanager($data){
//        //验证数据的合法性
//        $valiManager=validate("Manager");
//        if(!$valiManager->scene('edit')->check($data)){
//            return ['code'=>0,'msg'=>$valiManager->getError()];
//        }
//        //写入数据库
//        unset($data['repasswd']);
//        $result=self::update($data);
//        if(!$result){
//            return ['code'=>0,'msg'=>"修改失败"];
//        }
//        return ['code'=>1,'msg'=>"修改成功"];
//    }
    //删除管理员
    public static function del($id){
//        $result=db('manager')->delete($id);
        $result=self::destroy($id);
        if($result){
//            return ['code'=>1,'msg'=>'删除成功'];
            return returnjson(1,"删除成功");
        }
//        return ['code'=>0,'msg'=>'删除失败'];
        return returnjson(0,"删除失败");
    }
    //设置管理员状态
    public static function setstatus($id){
//        $status=db("manager")->where("id",$id)->value("status");
        $status=self::where('id',$id)->value('status');
        $data['status']=1;
        $msg="已停用";
        if($status==0){
            $data['status']=1;
            $msg="已启用";
        }else{
            $data['status']=0;
            $msg="已停用";
        }
//        $result=db("manager")->where('id',$id)->update($data);
        $result=self::where('id',$id)->update($data);
        if($result){
//            return ['code'=>1,'msg'=>$msg];
            return returnjson(1,$msg);
        }
        return ['code'=>0,'msg'=>"操作失败"];
        return returnjson(0,"操作失败");
    }

    /**
     * 用户登录验证
     */
    public static function login($data){
        $vali=validate("Manager");
        if(!$vali->scene("login")->check($data)){
            return returnjson(0,$vali->getError());
        }
        $res=self::get(['account'=>$data['account']]);
        if(!$res){
            return returnjson(0,"账号不存在");
        }
        if(md5($data['passwd'])==$res['passwd']){
            session("uid",$res['id'],'admin');
            session("account",$res['account'],'admin');
            return returnjson(1,"登录成功");
        }
        return returnjson(0,"密码不正确");
    }
}
