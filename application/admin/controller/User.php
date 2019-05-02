<?php
namespace app\admin\controller;

class User extends Common
{
	//员工列表
	
    public function index()
    {
		 $result=db('user')->order('id desc')->select();
		 $this->assign('list',$result);
		// dump($result);
		
        return view();
    }
	//手动员工新增
	 public function add()
	{
		
		if(request()->isPost())
		{
			$data=input('post.');
			dump($data);
			$result=db('user')->insert($data);
			
			$this->success("添加成功",'user/index');
			return;
		}
		
	    return view();
	}
	
	//编辑员工信息
	 public function edit()
	{
	    return view();
	}
	
	//批量导入员工信息
	public function groupadd()
	{
	    return view();
	}
	
}
