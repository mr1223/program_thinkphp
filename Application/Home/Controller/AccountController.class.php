<?php
namespace Home\Controller;
use Think\Controller;
class AccountController extends Controller {
	public function index(){
		if(IS_POST){
			$account = M('account');
			//获取接口信息
			$options = I('post.');
			$options['rawData'] = $_POST['rawData'];
			$options['userInfo'] = $_POST['userInfo'];
			
			$js_code = $options['code'];
			$signature  = $options['signature'];
			//调用微信  获取openid等信息
			$appid = C('WX.APPID');
			$appsecret = C('WX.APPSECRET');  
			$url = "https://api.weixin.qq.com/sns/jscode2session";
			$datas['appid']=$appid;  
			$datas['secret']=$appsecret;  
			$datas['js_code']=$js_code;  
			$datas['grant_type']='authorization_code';  
			$httpstr = getWxhttp($url, $datas, 'POST', array("Content-type: text/html; charset=utf-8"));  
			$httpstr = json_decode($httpstr,true);  
			$session_key = $httpstr["session_key"];
			//数字签名校验
			$signature2 = sha1($options['rawData'].$session_key);  
		    if($signature != $signature2){  
		        $result = array(
		        	'code' => 0,
		        	'msg' => '数字签名校验错误 '
		        );
				$this->ajaxReturn($result);
		    }  
		   
			// 获取信息，对接口进行解密  
		    Vendor("WX.wxBizDataCrypt");  
		    $encryptedData = $options['encryptedData'];  
		    $iv = $options['iv'];  
		    if(empty($signature) || empty($encryptedData) || empty($iv)){  
		        $result = array('code' => 0,'msg' => '传递信息不全 ');
				$this->ajaxReturn($result);
		    }  
		   
			//vendor('Vendor.WX.wxBizDataCrypt',realpath('./'),'.php');//引入微信解密文件
			//微信数据解密
			include_once "WX/wxBizDataCrypt.php";  
			$data = '';
		    $pc = new \WXBizDataCrypt($appid,$session_key);  
		    $errCode = $pc->decryptData($encryptedData,$iv,$data);  
		
		    
		    if($errCode != 0){
		    	$result = array('code' => 0,'msg' => '解密数据失败 ');
				$this->ajaxReturn($result);
		      
		    }else {  
		        $data = json_decode($data,true);  
		        $data['token'] = addSaltMD5(session_id().$data['nickName']);
		        session('myinfo',$data);  
		        $sessionID = session_id();
		        $data['referer'] = 1;
		  		$cont['openId'] = $data['openId'];
		  		$sOpenid = $account -> where($cont)->find();
		  		
		  		
		  		
		  		$info = session('myinfo');
		  		$info['session_id'] = $sessionID;
		  		$info['openId'] = '';
		  		$info['watermark'] = '';
		  		if($sOpenid){
		  			$data['edit_time'] = time();
		  			$result = $account -> where($cont) -> save($data);
		  			if($result){
		  				$result = array('code' => 1,'msg' => '更新成功 ', 'token' => $data['token'],'info' => $info);
						$this->ajaxReturn($result);
		  			}else{
		  				$result = array('code' => 0,'msg' => '更新失败 ');
						$this->ajaxReturn($result);
		  			}
		  		}else{
		  			$data['regip'] = get_client_ip();
		  			$data['create_time'] = time();
		  			$result = $account -> add($data);
		  			if($result){
		  				$result = array('code' => 1,'msg' => '保存成功 ', 'token' => $data['token']);
						$this->ajaxReturn($result);
		  			}else{
		  				$result = array('code' => 0,'msg' => '保存失败 ');
						$this->ajaxReturn($result);
		  			}
		  		}
		  		
		         
		       
		    } 
		  
		}else{
			$data = array('code' => 0, 'msg' => '非法请求');
			$this->ajaxReturn($data);
		}
		
		
	}
	public function add(){
		$work = M('country');
		//$country = M('country');
		if(IS_POST){
			$data['date'] = date('Y-m-d H:i:s'); //数据库更新成功字段
			$data_arr = I('post.data'); //一维数组
			//$result = $work->addAll($data_arr);

			//$result = $country->addAll($data);
			if($result){
				$res = array('code'=>'1','data'=>$result);
			}else{
				$res = array('code'=>'0','data'=>$result);
			}
			$this->ajaxReturn($res);
		}
		
		
	}
	public function contact(){
		$this->display();
	}
}
?>