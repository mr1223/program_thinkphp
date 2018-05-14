<?php
namespace Admin\Controller;
use Common\Controller\AdminController;  

class AccountController extends AdminController {
	public function index(){
		$account = M('account');	
		$content = I('post.');
		//type = 1 page分页 首页获取数据
		$cou['del'] = 1;
		$contents['del'] = 1;
		if($content['search']){
			$contents['nickName'] = array('like','%'.$content['search'].'%');
			$contents['phone'] = array('like','%'.$content['search'].'%');
			$contents['_logic']='OR';
		}
		
		$count = $account-> where($cou) -> count();
		$result = $account -> where($contents) -> order('create_time desc') -> page($content['page'],$content['num']) -> select();
		if($result){
			$data = array('code' => 1, 'msg' => '获取成功', 'info' => $result,'count' => $count);
			$this -> ajaxReturn($data);
		}else{
			$data = array('code' => 0, 'msg' => '获取失败');
			$this -> ajaxReturn($data);
		}
	}
	public function getAccount(){
		$account = D('account');
		$content = I('post.');
		$content['del'] = 1;
		$result = $account -> where($content) -> find();
		if($result){
			$data = array('code' => 1, 'msg' => '获取成功', 'info' => $result);
			$this -> ajaxReturn($data);
		}else{
			$data = array('code' => 0, 'msg' => '获取失败');
			$this -> ajaxReturn($data);
		}
	}
	
	public function changeAccount(){
		$account = D('account');
		$content = I('post.');
		$id['id'] = I('post.id');
		$result = $account -> where($id) -> save($content);
		if($result){
			$data = array('code' => 1, 'msg' => '状态修改成功');
			$this -> ajaxReturn($data);
		}else{
			$data = array('code' => 0, 'msg' => '状态修改失败');
			$this -> ajaxReturn($data);
		}
	}
	public function seatchAccount(){
		$account = D('account');
		$content = I('post.');
		
		$result = $account -> where($content) -> select();
		if($result){
			$data = array('code' => 1, 'msg' => '获取成功','info' => $result);
			$this -> ajaxReturn($data);
		}else{
			$data = array('code' => 0, 'msg' => '获取失败');
			$this -> ajaxReturn($data);
		}
	}
}
?>