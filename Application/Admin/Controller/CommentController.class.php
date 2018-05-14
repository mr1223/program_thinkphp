<?php
namespace Admin\Controller;
use Common\Controller\AdminController;  

class CommentController extends AdminController {
	public function get(){
		$comment = M('comment');
		$content = I('post.');
		$contents['prim_comment.del'] = 1;
		$count = $comment-> where($cou) -> count();
		
		if($content['starttime']){
			$starttime = strtotime($content['starttime']);
			$endtime = strtotime($content['endtime']);
			$contents['prim_comment.create_time'] = array(array('gt',$starttime),array('lt',$endtime));
		}
		if($content['search']){
			$contents['prim_comment.content'] = array('like','%'.$content['search'].'%');
		}
		
		
		$result = $comment 
			->join('left join prim_stick s on prim_comment.aid = s.id')
			->join('left join prim_account a on prim_comment.uid = a.id')
			->field('prim_comment.id,prim_comment.pid,prim_comment.content,prim_comment.create_time,
			prim_comment.status,prim_comment.del,a.avatarUrl,a.nickName,s.title,s.image')
			-> where($contents)
			-> page($content['page'],$content['num'])
			-> select();
			if($result){
				forEach($result as $key => $value){
					$result[$key]['create_time'] = date('Y-m-d',$result[$key]['create_time']);
				}
				$data = array('code' => 1, 'msg' => '获取成功', 'info' => $result,'count' => $count);
				$this -> ajaxReturn($data);
			}else{
				$data = array('code' => 0, 'msg' => '获取失败');
				$this -> ajaxReturn($data);
			}
	}
	
	public function change(){
		
		
		if(IS_POST){
			$comment = M('comment');
			$content = I('post.');
			$result = $comment -> save($content);
			if($result){
		    	$data = array('code' => 1, 'msg' => '修改成功');
				$this->ajaxReturn($data);
		    }else{
		    	$data = array('code' => 0, 'msg' => $content);
				$this->ajaxReturn($data);
		    }
		}else{
			$data = array('code' => 0, 'msg' => '非法请求');
			$this->ajaxReturn($data);
		}
	}

}
?>