<?php

namespace app\admin\controller;
use app\admin\model\AuthRule;
class Rule extends Common
{
    /**
     * 权限列表
     */
    public function index(){
        $list=AuthRule::getRuleall();
        $this->assign('list',$list);
        return view();
    }

    /**
     * 添加权限（加载模板）
     */
    public function add(){
        $rule=AuthRule::getRuleall();
        $this->assign('rule',$rule);
        return view();
    }
    /**
     * 编辑角色（加载模板）
     */
    public function edit($id){
        $authrule=AuthRule::get($id);
        $rule=AuthRule::getRuleall();
        $this->assign('rule',$rule);
        $this->assign('authrule',$authrule);
        return view();
    }

    /**
     * 数据处理
     */
    public function save(){
        if(request()->isAjax()){
            $data=input('post.');
            $result=AuthRule::store($data);
            return $result;
        }else{
            return returnjson(0,"添加失败");
        }
    }

    /**
     * 删除权限
     * @param $id
     * @return \think\response\Json
     */
    public function delete($id){
        if(AuthRule::checkchild($id)){
            $result=AuthRule::destroy($id);
            if($result>0){
                return returnjson(1,"删除成功");
            }
            return returnjson(0,"删除失败");
        }else{
            return returnjson(0,"有子权限不能删除");
        }


    }
    /**
     * 设置权限状态
     * @return \think\response\Json
     */
    public function setstatus(){
        $data=input("post.");
        $result=AuthRule::update($data);
        if($result){
            return returnjson(1,"设置成功");
        }
        return returnjson(0,"设置失败");
    }
}
