<?php
namespace Home\Controller;
use Think\Controller;
class TestController extends Controller {
	public function index(){
		$date = array('code'=>1000,'data'=>'钩子');
	    $this->ajaxReturn($date);
	}
}