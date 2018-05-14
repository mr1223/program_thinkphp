<?php
namespace Admin\Controller;
use Common\Controller\AdminController;  

class TypeController extends AdminController {
	
	public function addType(){
		
		$type = M("type");
		$date = I('post.');
		
		if(empty($date['id'])){
			$date['creattime'] = time();
			$date['edittime'] = time();
			if($type->create($date)) {
				$result = $type->add();
				
				if($result){
					$Data = array("code"=>1,"msg"=>"添加成功！");
		    		$this->ajaxReturn($Data);
				}else{
					$Data = array("code"=>0,"msg"=>"添加失败！");
		    		$this->ajaxReturn($Data);
				}
			}else{
				$Data = array("code"=>0,"msg"=>"添加失败！");
		    	$this->ajaxReturn($Data);
			}
			
		}else{
			$date['edittime'] = time();
			$result = $type->save($date);
			if($result){
				$Data = array("code"=>1,"msg"=>"更新成功！");
	    		$this->ajaxReturn($Data);
			}else{
				$Data = array("code"=>0,"msg"=>"更新失败！");
	    		$this->ajaxReturn($Data);
			}
		}
		
	}
	public function getTypeList(){
		//需传入type
		$type = M("type");
		$date['status'] = 1;
		$result = $type->where($date)->select();
		if($result){
			foreach($result as $key => $value){
				$result[$key]['creattime'] = date('Y-m-d',$result[$key]['creattime']);
			}
			$Data = array("code"=>1,"msg"=>"获取成功！","info"=>$result);
    		$this->ajaxReturn($Data);
		}else{
			$Data = array("code"=>0,"msg"=>"获取失败！");
    		$this->ajaxReturn($Data);
		}
		
	}
	public function getType(){
		//需传入ID
		$type = M("type");
		$date = I('post.');
		$result = $type->where($date)->find();
		if($result){
			$Data = array("code"=>1,"msg"=>"获取成功！","info"=>$result);
    		$this->ajaxReturn($Data);
		}else{
			$Data = array("code"=>0,"msg"=>"获取失败！");
    		$this->ajaxReturn($Data);
		}
		
	}
	public function removeType(){
		//需传入ID
		$type = M("type");
		$date = I('post.');
		$date['status'] = -1;
		$result = $type->save($date);
		if($result){
			$Data = array("code"=>1,"msg"=>"删除成功！");
    		$this->ajaxReturn($Data);
		}else{
			$Data = array("code"=>0,"msg"=>"删除失败！");
    		$this->ajaxReturn($Data);
		}
		
	}
	public function showHideType(){
		//需传入ID 和 状态
		$type = M("type");
		$date = I('post.');
		$result = $type->save($date);
		if($result){
			$Data = array("code"=>1,"msg"=>"状态更改成功！");
    		$this->ajaxReturn($Data);
		}else{
			$Data = array("code"=>0,"msg"=>"状态更改失败！");
    		$this->ajaxReturn($Data);
		}
		
	}
}
?>