<?php
namespace app\admin\controller;
//use think\Request;
use think\File;
use PHPExcel;
use PHPExcel_IOFactory;

class User extends Common
{
	//员工列表
	
    public function index()
    {
		 $result=db('user')->where('state',1)->order('id desc')->select();
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
	
	//软删除
	public function del(){
		$id=input('id');
		//echo ":ID=".$id;
		if(db('user')->where('id',$id)->setField('state',0)){
			$this->success("已删除！",'user/index');
		}else{
			$this->error('删除失败！');
		}		
		return ;//view();
	}

	//批量导入员工信息
	public function upload()
	{
		if(request()->isPost()){
		   
			
		 // 获取表单上传文件 例如上传了001.jpg
		 $file = request()->file('excelfile');
		 
		 // 移动到框架应用根目录/public/uploads/ 目录下
		 if($file){
			
			 $info = $file->validate(['size'=>10485760,'ext'=>'xls,xlsx'])->move(ROOT_PATH . 'public' . DS . 'uploads');
			 if($info){
				 // 成功上传后 获取上传信息
				
				//return  json_encode($info->getSaveName());
								 
				 // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
				 $fullfilename=ROOT_PATH . 'public' . DS . 'uploads'.DS.$info->getSaveName();
				//echo json_encode($filename);
				Phpexceljob($fullfilename);
				



				// echo $excelFileType;
				 
			 }else{
				 // 上传失败获取错误信息
				 echo  $file->getError();
			 }
		 }
		}
		
		return view();
		


		
	}

	protected function Phpexceljob($fullfilename){

		vendor("PHPExcel.PHPExcel.IOFactory");
		$excelFileType = \PHPExcel_IOFactory::identify($fullfilename);
		$objReader=\PHPExcel_IOFactory::createReader($excelFileType);
		$objPHPExcel=$objReader->load($fullfilename);
		$sheet=$objPHPExcel->getSheet(0);

		// 获取表格数量
		$sheetCount = $sheet->getSheetCount();
		// 获取行数
		$rows = $sheet->getHighestRow();
		// 获取col count
		$col = $sheet->getHighestColumn();
		
		$cols=\PHPExcel_Cell::columnIndexFromString($col);


	
	}
	
}
