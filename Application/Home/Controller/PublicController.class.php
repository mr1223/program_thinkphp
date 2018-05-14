<?php
namespace Home\Controller;
use Think\Controller;
class PublicController extends Controller {
	
	public function getMessage(){
		$trumpet = M('trumpet');
		$content['id'] = 1;
		$result = $trumpet -> where($content) -> find();
		if($result){
			$data = array('code' => 1, 'msg' => '获取成功','info' => $result);
			$this -> ajaxReturn($data);
		}else{
			$data = array('code' => 0, 'msg' => '获取失败');
			$this -> ajaxReturn($data);
		}
	}
	
	public function sendCode(){
		$date = I('get.');
		$data = array('code'=>'0','data'=>$date);
		$this->ajaxReturn($data);
	}
	
	
	public function logo(){
		headerSetting();
		//session(array('name'=>'session','expire'=>3600));
		if(IS_POST){
			$name = I('post.name');
			$psw = I('post.psw');
			$condition['username'] = $name;
			$condition['password'] = addSaltMD5($psw);
			if(empty($name)){
				$data = array('code'=>'0','data'=>'用户名为空');
				$this->ajaxReturn($data);
			}else
			if(empty($psw)){
				$data = array('code'=>'0','data'=>'密码为空');
				$this->ajaxReturn($data);
			}else{
				$result = M('user')->where($condition)->select();
				if($result){
					session('name',$result[0]['username']);
					session('adm_uid',$result[0]['id']);  
					//session('key',session_id());
					//$sess = session();
					$message = array('name'=>$result[0]['username'],'age'=>$result[0]['age'],'key'=>session_id(),'session'=>session('name'),'sess'=>$sess);
					$data = array('code'=>'1','data'=>$message);
					$this->ajaxReturn($data);
				}else{
					$data = array('code'=>'0','data'=>'账号或密码错误');
					$this->ajaxReturn($data);
				} 
			}
		}else{
			$data = array('code'=>'0','data'=>'非法请求');
			$this->ajaxReturn($data);
		}
	}
	public function loginout(){
		headerSetting();
		session('name',null);
		session('adm_uid',null);
		$data = array('code'=>'1','data'=>'退出登录成功');
		$this->ajaxReturn($data);  
	}
	public function verify(){
    	$Verify = new \Think\Verify();
		$Verify->entry();
    }
    public function uploadImg(){
		
    	$upload = new \Think\Upload();
    	$upload->maxSize = 3145728;
    	$upload->exts = array('jpg', 'gif', 'png', 'jpeg');
    	$upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
    	$upload->savePath  =     ''; // 设置附件上传（子）目录
    	$info   =   $upload->upload();
	    if(!$info) {// 上传错误提示错误信息
	        $this->error($upload->getError());
	    }else{// 上传成功
	    	$path = __ROOT__.'/Uploads/'.$info['files']['savepath'].$info['files']['savename'];
	    	$data = array('code'=>1,'data'=>'上传成功','path'=>$path);
	    	$this->ajaxReturn($data);
	        //$this->success('上传成功！');
	    }
    	
    }
    //邮件发送的实现
    public function send(){
    	$mail = '980267269@qq.com';
    	$title = '你好';
    	$content = '内容';
    	$result = sendMail($mail,$title,$content);
    	if($result){
    		$data = array('code'=>'1','data'=>$result);
			$this->ajaxReturn($data);  
    	}else{
    		$data = array('code'=>'0','data'=>$result);
			$this->ajaxReturn($data);  
    	}
    }
    
}
?>