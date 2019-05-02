<?php
namespace app\admin\validate;
use think\Validate;
 
class User extends Validate
{
  protected $rule = [
    'name'  => 'require|max:20|min:2',
    'age'   => 'number|between:1,120',
		'ticheng'   => 'number|between:0,40',
		'phone'   => 'min:11|max:11',
		'qq'   => 'number|min:6',
	];
  protected $msg = [
    'name.require' => '姓名不能为空',
    'name.max'     => '用户名最多不能超过25个字符',
	   'name.min'     => '用户名最少2个字符',
     'age.number'   => '年龄必须是数字',
		 'age.between'  => '年龄只能在1-120之间',
		 'ticheng.number'   => '提成必须是数字',
		 'ticheng.between'   => '提成只能从0到40',
    'phone.min'  => '手机号码为11位',
		'phone.max'  => '手机号码为11位',
    'email'        => '邮箱格式错误',
		];
	
	protected $scence=[];
	
	

	protected $data = [
    'name'  => 'thinkphp',
    'age'   => 10,
    
	];




}
