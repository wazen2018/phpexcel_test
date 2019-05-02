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
			//dump($data);
			$validate=validate('User');
			if(!$validate->scene('add')->check($data))
			{
				$this->error($validate->getError());
			}
			
			$result=db('user')->insert($data);
			$this->success("添加成功",'user/index');
			return;
		}
		
	    return view();
	}
	
	//编辑员工信息
	 public function edit()
	{ 
		//提交按钮 
		if(request()->isPost()){
			$data=input('post.');
			//dump($data);

			//编辑验证
			$validate=validate('User');
			if(!$validate->scene('edit')->check($data))
			{
				$this->error($validate->getError());
			}
			//dump($data);die;
			//更新数据
			if(db('user')->update($data)){
				$this->success("更改成功！",'user/index');
			}else{
				$this->error('更改失败！');
			}

			return;
		}

		//从员工列表过来 带着id
		$id=input('id');
		
		$res=db('user')->where('id',$id)->find();
		//dump($res);
		if(!$res){
			$this->error("该用户id异常！");
		}
		$this->assign('user',$res);
			
		
		return view();
	    
	}
	
	//批量导入员工信息
	public function groupadd()
	{
	    return view();
	}
	
}
