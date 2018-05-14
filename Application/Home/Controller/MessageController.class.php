<?php
namespace Home\Controller;
use Common\Controller\HomeController;  

class MessageController extends HomeController {
	public function about(){
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
}
?>