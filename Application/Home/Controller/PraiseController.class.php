<?php
namespace Home\Controller;
use Common\Controller\HomeController;  

class PraiseController extends HomeController {
	public function add(){
		$praise = M('praise');
		$content = I('post.');
		if(IS_POST){
			if(empty($content['pid'])){
				$data = array('code' => 0, 'msg' => 'ID为空');
				$this -> ajaxReturn($data);
			}
			if(empty($content['tid'])){
				$data = array('code' => 0, 'msg' => '类型为空');
				$this -> ajaxReturn($data);
			}
			$re = getUid();
		
			
			$cont['pid'] = $content['pid'];
			$cont['tid'] = $content['tid'];
			$cont['uid'] = $re['id'];
			
			$datas = $praise -> where($cont) -> find();
			if(!$datas){
				$content['uid'] = $re['id'];
				$content['create_time'] = time();
				if($praise->create($content)){
					$result = $praise -> add();
					if($result){
						$data = array('code' => 1, 'msg' => '成功');
						$this -> ajaxReturn($data);
					}else{
						$data = array('code' => 0, 'msg' => '失败');
						$this -> ajaxReturn($data);
					}
				}else{
					$data = array('code' => 0, 'msg' => '失败');
					$this -> ajaxReturn($data);
				}
			}else{
				$content['edit_time'] = time();
				$id['id'] = $datas['id'];
				$result = $praise -> where($id) -> save($content);
				if($result){
					$data = array('code' => 1, 'msg' => '成功');
					$this -> ajaxReturn($data);
				}else{
					$data = array('code' => 0, 'msg' => '失败');
					$this -> ajaxReturn($data);
				}
			}

		}else{
			$data = array("code"=>0,"msg"=>"非法请求！");
		    $this->ajaxReturn($data);
		}
	}
}