<?php
namespace Admin\Controller;
use Common\Controller\AdminController;  

class MessageController extends AdminController {
    
    public function addCompany(){
		
		$company = M("company");
		$date["id"] = $_POST["id"];
		$date["content"] = $_POST["content"];
		if(empty($date["content"])){
			$Data = array("code"=>0,"msg"=>"公司信息为空！");
	    	$this->ajaxReturn($Data);
		}
		if(empty($date["id"])){
			
			if($company->create($date)) {
				$result = $company->add();
				
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
			$result = $company->save($date);
			if($result){
				$Data = array("code"=>1,"msg"=>"更新成功！");
	    		$this->ajaxReturn($Data);
			}else{
				$Data = array("code"=>0,"msg"=>"更新失败！");
	    		$this->ajaxReturn($Data);
			}
		}
	}
	public function getCompany(){
		$company = M("company");
		$date["id"] = 1;
		$result = $company->where($date)->find();
		if($result){
			$Data = array("code"=>1,"msg"=>"获取成功！","info"=>$result);
    		$this->ajaxReturn($Data);
		}else{
			$Data = array("code"=>0,"msg"=>"获取失败！");
    		$this->ajaxReturn($Data);
		}
	}
	public function addCulture(){
		
		$culture = M("culture");
		$date["id"] = $_POST["id"];
		$date["content"] = $_POST["content"];
		if(empty($date["content"])){
			$Data = array("code"=>0,"msg"=>"企业文化为空！");
	    	$this->ajaxReturn($Data);
		}
		if(empty($date["id"])){
			
			if($culture->create($date)) {
				$result = $culture->add();
				
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
			$result = $culture->save($date);
			if($result){
				$Data = array("code"=>1,"msg"=>"更新成功！");
	    		$this->ajaxReturn($Data);
			}else{
				$Data = array("code"=>0,"msg"=>"更新失败！");
	    		$this->ajaxReturn($Data);
			}
		}
	}
	public function getCulture(){
		$culture = M("culture");
		$date["id"] = 1;
		$result = $culture->where($date)->find();
		if($result){
			$Data = array("code"=>1,"msg"=>"获取成功！","info"=>$result);
    		$this->ajaxReturn($Data);
		}else{
			$Data = array("code"=>0,"msg"=>"获取失败！");
    		$this->ajaxReturn($Data);
		}
	}
	
	public function addHonor(){
		
		$honor = M("honor");
		$date["id"] = $_POST["id"];
		$date["content"] = $_POST["content"];
		if(empty($date["content"])){
			$Data = array("code"=>0,"msg"=>"荣誉资质为空！");
	    	$this->ajaxReturn($Data);
		}
		if(empty($date["id"])){
			
			if($honor->create($date)) {
				$result = $honor->add();
				
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
			$result = $honor->save($date);
			if($result){
				$Data = array("code"=>1,"msg"=>"更新成功！");
	    		$this->ajaxReturn($Data);
			}else{
				$Data = array("code"=>0,"msg"=>"更新失败！");
	    		$this->ajaxReturn($Data);
			}
		}
	}
	public function getHonor(){
		$honor = M("honor");
		$date["id"] = 1;
		$result = $honor->where($date)->find();
		if($result){
			$Data = array("code"=>1,"msg"=>"获取成功！","info"=>$result);
    		$this->ajaxReturn($Data);
		}else{
			$Data = array("code"=>0,"msg"=>"获取失败！");
    		$this->ajaxReturn($Data);
		}
	}
	
	
	public function addContact(){
		
		$contact = M("contact");
		$date["id"] = $_POST["id"];
		$date["content"] = $_POST["content"];
		if(empty($date["content"])){
			$Data = array("code"=>0,"msg"=>"荣誉资质为空！");
	    	$this->ajaxReturn($Data);
		}
		if(empty($date["id"])){
			
			if($contact->create($date)) {
				$result = $contact->add();
				
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
			$result = $contact->save($date);
			if($result){
				$Data = array("code"=>1,"msg"=>"更新成功！");
	    		$this->ajaxReturn($Data);
			}else{
				$Data = array("code"=>0,"msg"=>"更新失败！");
	    		$this->ajaxReturn($Data);
			}
		}
	}
	public function getContact(){
		$contact = M("contact");
		$date["id"] = 1;
		$result = $contact->where($date)->find();
		if($result){
			$Data = array("code"=>1,"msg"=>"获取成功！","info"=>$result);
    		$this->ajaxReturn($Data);
		}else{
			$Data = array("code"=>0,"msg"=>"获取失败！");
    		$this->ajaxReturn($Data);
		}
	}
	public function getLeavingList(){
		//需传入type
		$leaving = M("leaving");
		$date['status'] = 1;
		$result = $leaving->where($date)->select();
		if($result){
			foreach($result as $key => $val){
				$result[$key]['creattime'] = date('Y-m-d',$result[$key]['creattime']);
				$result[$key]['content'] = htmlspecialchars_decode($result[$key]['content']);
			}
			$Data = array("code"=>1,"msg"=>"获取成功！","info"=>$result);
    		$this->ajaxReturn($Data);
		}else{
			$Data = array("code"=>0,"msg"=>"获取失败！");
    		$this->ajaxReturn($Data);
		}
		
	}
	public function getLeaving(){
		//需传入ID
		$leaving = M("leaving");
		$date = I('post.');
		$result = $leaving->where($date)->find();
		if($result){
			$result['creattime'] = date('Y-m-d',$result['creattime']);
			$result['content'] = htmlspecialchars_decode($result['content']);
			$Data = array("code"=>1,"msg"=>"获取成功！","info"=>$result);
    		$this->ajaxReturn($Data);
		}else{
			$Data = array("code"=>0,"msg"=>"获取失败！");
    		$this->ajaxReturn($Data);
		}
		
	}
	public function removeLeaving(){
		//需传入ID
		$leaving = M("leaving");
		$date = I('post.');
		$date['status'] = -1;
		$result = $leaving->save($date);
		if($result){
			$Data = array("code"=>1,"msg"=>"删除成功！");
    		$this->ajaxReturn($Data);
		}else{
			$Data = array("code"=>0,"msg"=>"删除失败！");
    		$this->ajaxReturn($Data);
		}
		
	}
}