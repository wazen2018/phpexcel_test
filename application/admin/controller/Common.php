<?php
namespace app\admin\controller;
use think\Controller;

class Common extends Controller
{ 
	 //预处理  加权限
	public function _initialize()
    {
       $this->checklogin();
	}
	
	
	protected function checklogin(){
		if(session('?loginname','','admin')!=1 || session('?loginid','','admin')!=1)
		{
			$this->error('未登录','login/index');
		}
		
	}
	
    public function index()
    {
        return view();
    }
	
	public function login()
	{
		$data=input('post.');
		dump($data);
		return ;
		
	}
}
