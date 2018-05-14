<?php  
namespace Common\Controller;  
use Think\Controller;  
class HomeController extends Controller{  
    function _initialize(){  
        
		$adm_uid = session('myinfo');
		
		if(!$adm_uid){
			$Data = array('code'=>'3',"msg"=>"请先去登录",'info' => $adm_uid);
		    $this->ajaxReturn($Data);
            exit(0);  
		}
    }  
}  