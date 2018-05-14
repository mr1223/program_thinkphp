<?php
namespace Admin\Controller;
use Think\Controller;  

class UseController extends Controller {
	public function login(){
		
		//session(array('username'=>'session','expire'=>3600));
		if(IS_POST){
			$user = M('user');
			$authGroup = M('auth_group');
			$authGroupAccess = M('auth_group_access');
			
			
			$condition = I('post.');
			$condition['password'] = addSaltMD5($condition['password']);
			
			$result = $user->where($condition)->select();
			if($result){
				
				$id = $result[0]['id'];
				$GroupAccess['uid'] = $id;
				$resultGroupAccessId = $authGroupAccess -> where($GroupAccess) -> field('group_id') -> find();
				$Group['id'] = $resultGroupAccessId['group_id'];
				$resultGroupRules = $authGroup -> where($Group) -> field('rules') -> find();
				
				$options['username'] = $result[0]['username'];
				$options['uid'] = $id;
				$options['token'] = session_id();
				$options['secret'] = addSaltMD5($result[0]['username'].$condition['password']);
				$options['rule'] = $resultGroupRules;
				
				session('info',$options);
					
				$message = array('username'=>$result[0]['username'],'token' => $options['token']);
				$data = array('code'=>'1','data'=>'登录成功','info' => $message);
				$this->ajaxReturn($data);
			}else{
				$data = array('code'=>'0','msg'=>'账号或密码错误');
				$this->ajaxReturn($data);
			} 
		
		}else{
			$data = array('code'=>'0','msg'=>'非法请求');
			$this->ajaxReturn($data);
		}
	}
	public function loginout(){
		
		
		if(IS_POST){
			$token = I('post.token');
			session('info',null);
			
			$data = array('code'=>1,'msg'=>'退出登录成功');
			$this->ajaxReturn($data);  
		}else{
			$data = array('code'=>0,'msg'=>'非法请求');
			$this->ajaxReturn($data);
		}
	}

}
?>