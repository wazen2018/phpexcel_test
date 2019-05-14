<?php
namespace app\admin\controller;
use think\Controller;
use think\auth\Auth;

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

		/*
		
		$auth = new Auth();
        if($uid!=9){
            if(($controller . '/' . $action)!=="Index/index" && ($controller . '/' . $action)!=="Index/welcome"){
                if(!$auth->check($controller . '/' . $action, $uid)){
                    $this->error('你没有权限访问','admin/Index/welcome');
                }
            }

		}
		
		 */
		
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

	//5-14
	
	public function ischecklogin(){
        if(session('uid',"","admin") && session('account',"","admin")){
            return true;
        }
        return false;
    }
	
	
	public function _initialize_514()
    {
        //登录验证
        if(!$this->ischecklogin()){
            $this->redirect("admin/Login/index");
        }
        $uid=session("uid","","admin");
        $controller = request()->controller();
        $action = request()->action();
        $auth = new Auth();
        if($uid!=9){
            if(($controller . '/' . $action)!=="Index/index" && ($controller . '/' . $action)!=="Index/welcome"){
                if(!$auth->check($controller . '/' . $action, $uid)){
                    $this->error('你没有权限访问','admin/Index/welcome');
                }
            }

        }
    }
}
