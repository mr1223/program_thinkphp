<?php  
namespace Common\Controller;  
use Think\Controller;  
class AdminController extends Controller{  
    function _initialize(){  
    	headerSetting();
		$adm_uid = is_login();
		if(!$adm_uid){
			$Data = array('code'=>'3',"msg"=>"请先去登录");
		    $this->ajaxReturn($Data);
            exit(0);  
		}
	
		$authRule = M('auth_rule');
		$content['name'] = __ACTION__;
		$resultRule = $authRule ->where($content) -> field('id') -> find(); 
		if($resultRule){
			$ruleId = $resultRule['id'];
			$info = session('info');
			
			$result = strpos($info['rule']['rules'],$resultRule['id']);
			
			if(!$result){
				$data = array('code' => 0,'msg' => '没有权限 ','link' => $info);
				$this -> ajaxReturn($data);
			}
		}
		
    	/*$Auth = new \Think\Auth();
	  	//需要验证的规则列表,支持逗号分隔的权限规则或索引数组
	  	$name = MODULE_NAME . '/' . ACTION_NAME;
	  	//当前用户id
	  	$uid = '1';
	  	//分类
	  	$type = MODULE_NAME;
	  	//执行check的模式
	  	$mode = 'url';
	  	//'or' 表示满足任一条规则即通过验证;
	  	//'and'则表示需满足所有规则才能通过验证
	  	$relation = 'and';
	  	if ($Auth->check($name, $uid, $type, $mode, $relation)) {
	  		$data = array('code' => 1);
	  		$this -> ajaxReturn($data);
	   		die('认证：成功');
	  	} else {
	  		$data = array('code' => 0);
	  		$this -> ajaxReturn($data);
	   		die('认证：失败');
	  	}*/
    	
        
    }  
}  