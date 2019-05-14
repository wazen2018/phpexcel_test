<?php
/**
 * 
 * User: sc
 * Date: 2019/5/14
 * 
 * 
 */

namespace app\admin\controller;
use app\admin\model\AuthGroup as AuthGroupModel;
use app\admin\model\AuthRule;

class AuthGroup extends Common
{
    /**
     * 角色列表
     */
    public function index(){
        $list=AuthGroupModel::all();
        $this->assign('list',$list);
        return view();
    }

    /**
     * 添加角色（加载模板）
     */
    public function add(){

        return view();
    }
    /**
     * 编辑角色（加载模板）
     */
    public function edit($id){
        $authgroup=AuthGroupModel::get($id);
        $this->assign('authgroup',$authgroup);
        return view();
    }

    /**
     * 数据处理
     */
    public function save(){
        if(request()->isAjax()){
            $data=input('post.');
            $result=AuthGroupModel::store($data);
            return $result;
        }else{
            return returnjson(0,"添加失败");
        }
    }

    /**
     * 删除角色
     * @param $id
     * @return \think\response\Json
     */
    public function delete($id){
        $result=AuthGroupModel::destroy($id);
        if($result>0){
            return returnjson(1,"删除成功");
        }
        return returnjson(0,"删除失败");
    }
    /**
     * 加载权限分配页面
     * @return \think\response\View
     */
    public function setrule($id){
        $authgroup=AuthGroupModel::get($id);
        $this->assign('authgroup',$authgroup);
        return view();
    }
    //获取权限列表（用于无限级权限树）
    public function getRules(){
        $groupid=input("groupid");
        $list=AuthRule::getRule(0,0,$groupid);
        return json(['code'=>0,"msg"=>"获取成功","data"=>["trees"=>$list]]);
    }

    /**
     * 设置角色状态
     * @return \think\response\Json
     */
    public function setstatus(){
        $data=input("post.");
        $result=AuthGroupModel::update($data);
        if($result){
            return returnjson(1,"设置成功");
        }
        return returnjson(0,"设置失败");
    }
}