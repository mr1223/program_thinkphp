<?php
namespace Home\Controller;
use Common\Controller\HomeController;  

class FeedbackController extends HomeController {
	public function add(){
		$feedback = M('feedback');
		$content = I('post.');
		if(empty($content['content'])){
			$data = array('code' => 0, 'msg' => '内容为空');
			$this -> ajaxReturn($data);
		}
		$re = getUid();
		$content['create_time'] = time();
		$content['uid'] = $re['id'];
		if($feedback->create($content)){
			$result = $feedback -> add();
			if($result){
				$data = array('code' => 1, 'msg' => '增加成功');
				$this -> ajaxReturn($data);
			}else{
				$data = array('code' => 0, 'msg' => '增加失败');
				$this -> ajaxReturn($data);
			}
		}else{
			$data = array('code' => 0, 'msg' => '增加失败');
			$this -> ajaxReturn($data);
		}
		
	}
}
?>