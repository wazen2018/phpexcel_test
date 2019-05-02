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
}
