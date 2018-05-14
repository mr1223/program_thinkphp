<?php
namespace Admin\Controller;
use Common\Controller\AdminController;  

class NewController extends AdminController {
	
	public function addNews(){
		
		$new = M("news");
		$date = I('post.');
		
		if(empty($date['id'])){
			$date['creattime'] = time();
			$date['edittime'] = time();
			if($new->create($date)) {
				$result = $new->add();
				
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
			$result = $new->save($date);
			if($result){
				$Data = array("code"=>1,"msg"=>"更新成功！");
	    		$this->ajaxReturn($Data);
			}else{
				$Data = array("code"=>0,"msg"=>"更新失败！");
	    		$this->ajaxReturn($Data);
			}
		}
		
	}
	public function getNewsList(){
		//需传入type
		$new = M("news");
		$date = I('post.');
		$date['status'] = 1;
		$result = $new->where($date)->select();
		if($result){
			foreach($result as $key => $val){
				$result[$key]['content'] = htmlspecialchars_decode($result[$key]['content']);
			}
			$Data = array("code"=>1,"msg"=>"获取成功！","info"=>$result);
    		$this->ajaxReturn($Data);
		}else{
			$Data = array("code"=>0,"msg"=>"获取失败！");
    		$this->ajaxReturn($Data);
		}
		
	}
	public function getNews(){
		//需传入ID
		$new = M("news");
		$date = I('post.');
		$result = $new->where($date)->find();
		if($result){
			$result['content'] = htmlspecialchars_decode($result['content']);
			$Data = array("code"=>1,"msg"=>"获取成功！","info"=>$result);
    		$this->ajaxReturn($Data);
		}else{
			$Data = array("code"=>0,"msg"=>"获取失败！");
    		$this->ajaxReturn($Data);
		}
		
	}
	public function removeNew(){
		//需传入ID
		$new = M("news");
		$date = I('post.');
		$date['status'] = -1;
		$result = $new->save($date);
		if($result){
			$Data = array("code"=>1,"msg"=>"删除成功！");
    		$this->ajaxReturn($Data);
		}else{
			$Data = array("code"=>0,"msg"=>"删除失败！");
    		$this->ajaxReturn($Data);
		}
		
	}
	public function showHideNew(){
		//需传入ID 和 状态
		$new = M("news");
		$date = I('post.');
		$result = $new->save($date);
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