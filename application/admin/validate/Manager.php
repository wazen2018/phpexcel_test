<?php
namespace app\admin\validate;
use think\Validate;
 
class Manager extends Validate
{
  protected $rule = [
    'username'  => 'require|max:25|min:6',
    'password'   => 'require|min:4',
	];
  protected $msg = [
    'username.require' => '用户名不能为空',
    'username.max'     => '用户名最多不能超过25个字符',
	'username.min'     => '用户名最少6个字符',
    'password.require'   => '密码不能为空',
    'password.min'  => '密码最少4位',
    'email'        => '邮箱格式错误',];

	protected $data = [
    'name'  => 'thinkphp',
    'age'   => 10,
    
	];




}
