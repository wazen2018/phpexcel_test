<?php
namespace app\admin\controller;
use think\Db;

class Index extends Common
{
    public function index()
    {
        return view();
    }
    

    public function welcome()
    {
       // dump($_SERVER);
       //读取服务器信息 5.2 
        $server=[
            'SERVER_PORT'=>$_SERVER["SERVER_PORT"],
            'SERVER_ADDR'=>$_SERVER["SERVER_ADDR"],
            'SERVER_NAME'=>$_SERVER["SERVER_NAME"],
            'OSNAME'=>php_uname(),
            'HTTP_ACCEPT_LANGUAGE'=>$_SERVER["HTTP_ACCEPT_LANGUAGE"],
            'HTTP_HOST'=>$_SERVER["HTTP_HOST"],

        ];

        //原声查询   引入db类
        $version=Db::query("select version()");
        $server['mysqlversion']=$version[0]['version()'];
        //读取配置文件 config
        $server['database']=config('database.database');
        //php版本
        $server['phpversion']=phpversion();
        //最大上传大小
        $server['max_file_uploads']=ini_get('max_file_uploads');




        $this->assign('server',$server);
        return view();
    }

    public function modify(){

        if(request()->isPost()){
         
            $data=input('post.');
            //dump($data);
            $validate=validate("Manager");
            if($validate->scene('modify')->check($data)){
                $this->error($validate->getError());
                
            }

            //判断两次新密码是否一样
            if($data['newpassword']!=$data['newpassowrd2']){
                $this->error('新密码两次输入不一样，请重新输入！');
                return;
            }
            //判断旧密码是否正确
            
            $res=Db('admin')->where('id',session('loginid','','admin'))->field('password')->find();
            
            //dump($res);die;
            if(md5($data['oldpassword'])!=$res['password']){
                $this->error('旧密码认证失败');
                return;
            }

            $r=  Db('admin')->where('id',session('loginid','','admin'))->setField('password',md5($data['newpassword']));
            if($r=1)  
             $this->success( '密码修改成功');
             else $this->error( '密码修改失败');
           // db('user')->where('status',1)->select();
            return;
        }

        return view();

    }


   
}
