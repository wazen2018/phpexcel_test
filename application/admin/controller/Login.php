<?php
/*
2019-5-1 
管理员登录
session
*/
namespace app\admin\controller;
use think\Controller;

class Login extends Controller
{
    public function index()
    {
		if(session('?loginname','','admin')!=1 || session('?loginid','','admin')!=1)
		{
			return view();
		}
		else
		  $this->redirect('index/index');
		  
        
    }

	public function login()
	{
		$data=input('post.');
		
		$validate=validate('Manager');
		if (!$validate->check($data)) {
			
			 $this->error($validate->getError(),null,null,2);
		}	
	   $result=db('admin')->where('username',$data['username'])->find();
	   
	   if(!$result){
		   $this->error("用户不存在");
		}
		if(md5(trim($data['password']))!=$result['password']){
			$this->error("密码不对");
		}
		
	 //  dump($result);
	  
	  
		//Session 记录session
		session('loginname', $result['username'], 'admin');
		session('loginid', $result['id'], 'admin');
		
		//更新登录时间
		db('admin')->where('id',$result['id'])->update(['logintime' => time()]);
        db('admin')->where('id',$result['id'])->update(['isAdmin' => '1']);

 
		//echo "登录成功";
		$this->success('登录成功','index/index');
		return ;
		
	}
}
/*


		//dump($data);
		
		*/