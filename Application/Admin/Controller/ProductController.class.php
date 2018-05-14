<?php
namespace Admin\Controller;
use Common\Controller\AdminController;  

class ProductController extends AdminController {
	
	public function addProduct(){
		
		$product = M("product");
		$date = I('post.');
		
		if(empty($date['id'])){
			$date['creattime'] = time();
			$date['edittime'] = time();
			if($product->create($date)) {
				$result = $product->add();
				
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
			$result = $product->save($date);
			if($result){
				$Data = array("code"=>1,"msg"=>"更新成功！");
	    		$this->ajaxReturn($Data);
			}else{
				$Data = array("code"=>0,"msg"=>"更新失败！");
	    		$this->ajaxReturn($Data);
			}
		}
		
	}
	public function getProductList(){
		//需传入type
		$product = M("product");
		$date['status'] = 1;
		$result = $product->where($date)->select();
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
	public function getProduct(){
		//需传入ID
		$product = M("product");
		$date = I('post.');
		$result = $product->where($date)->find();
		if($result){
			$result['content'] = htmlspecialchars_decode($result['content']);
			$Data = array("code"=>1,"msg"=>"获取成功！","info"=>$result);
    		$this->ajaxReturn($Data);
		}else{
			$Data = array("code"=>0,"msg"=>"获取失败！");
    		$this->ajaxReturn($Data);
		}
		
	}
	public function removeProduct(){
		//需传入ID
		$product = M("product");
		$date = I('post.');
		$date['status'] = -1;
		$result = $product->save($date);
		if($result){
			$Data = array("code"=>1,"msg"=>"删除成功！");
    		$this->ajaxReturn($Data);
		}else{
			$Data = array("code"=>0,"msg"=>"删除失败！");
    		$this->ajaxReturn($Data);
		}
		
	}
	public function showHideProduct(){
		//需传入ID 和 状态
		$product = M("product");
		$date = I('post.');
		$result = $product->save($date);
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