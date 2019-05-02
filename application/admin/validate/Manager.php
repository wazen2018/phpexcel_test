<?php
namespace app\admin\validate;
use think\Validate;
 
class Manager extends Validate
{
  protected $rule = [
    'username'  => 'require|max:25|min:6',
    'password'   => 'require|min:6',
    'oldpassword'   => 'require|min:6',
    'password2'   => 'confirm:password',
	];
  protected $msg = [
    'username.require' => '用户名不能为空',
    'username.max'     => '用户名最多不能超过25个字符',
  	'username.min'     => '用户名最少6个字符',
    'password.require'   => '密码不能为空',
    'password.min'  => '密码最少6位',
    'email'        => '邮箱格式错误',
    'oldpassword.require'   => '密码不能为空',
    'oldpassword.min'  => '密码最少6位',
    'password2.confirm'  => '两次密码输入不一致',
  ];
  
  protected $scene = [
    'login'  =>  ['username','password'],
    'modify'  =>  ['password','oldpassword','password2',],
  ];





}
