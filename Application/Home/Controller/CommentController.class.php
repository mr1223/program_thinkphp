<?php
namespace Home\Controller;
use Common\Controller\HomeController;  

class CommentController extends HomeController {
	public function getToMyComment(){
		//我收到的评论
		$comment = M('comment');
		$content = I('get.');
		$re = getUid();
		//$cont['prim_comment.tuid'] = $re['id'];
		$cont['prim_comment.tuid'] = 1;
		$cont['prim_comment.tutype'] = 1;
		$result = $comment
			->join('left join prim_stick s on prim_comment.aid = s.id')
			->join('left join prim_account a on prim_comment.uid = a.id')
			->field('prim_comment.id,prim_comment.pid,prim_comment.content,prim_comment.create_time,
			a.avatarUrl,a.nickName,s.title,s.image')
			->where($cont)
			->select();
			
		if($result){
			forEach($result as $key => $value){
				$result[$key]['create_time'] = date('Y-m-d',$result[$key]['create_time']);
			}
			
			$data = array('code' => 1, 'msg' => '获取成功','info' => $result);
			$this -> ajaxReturn($data);
		}else{
			$data = array('code' => 0, 'msg' => 'id获取失败');
			$this -> ajaxReturn($data);
		}
	}
	public function getMyComment(){
		//我发出的评论
		$comment = M('comment');
		$content = I('post.');
		$re = getUid();
		$cont['prim_comment.uid'] = $re['id'];

		
		$result = $comment
			->join('left join prim_account a on prim_comment.uid = a.id')
			->join('left join prim_stick s on prim_comment.aid = s.id')
			->field('prim_comment.id,prim_comment.pid,prim_comment.content,prim_comment.create_time,
			a.avatarUrl,a.nickName,s.id,s.title,s.image')
			->order('create_time desc')
			->where($cont)
			->select();
			
		if($result){
			forEach($result as $key => $value){
				if($result[$key]['pid'] > 0){
					$conts['prim_comment.id'] = $result[$key]['pid'];
					$result[$key]['parent'] = $comment
					->join('left join prim_account a on prim_comment.uid = a.id')
					->join('left join prim_stick s on prim_comment.aid = s.id')
					->field('prim_comment.id,prim_comment.pid,prim_comment.content,prim_comment.create_time,
					a.avatarUrl,a.nickName,s.title,s.image')
					->where($conts)
					->find();
				}
				$result[$key]['create_time'] = date('Y-m-d h:m:s',$result[$key]['create_time']);
			}
			
			$data = array('code' => 1, 'msg' => '获取成功','info' => $result);
			$this -> ajaxReturn($data);
		}else{
			$data = array('code' => 0, 'msg' => 'id获取失败');
			$this -> ajaxReturn($data);
		}
	}
	
	public function add(){
		$comment = M('comment');
		$stick = M('stick');
		$content = I('post.');
		if(empty($content['id'])){
			if(empty($content['aid'])){
				$data = array('code' => 0, 'msg' => '文章ID为空');
				$this -> ajaxReturn($data);
			}
			
			if(empty($content['content'])){
				$data = array('code' => 0, 'msg' => '评论内容为空');
				$this -> ajaxReturn($data);
			}
			
			if($content['pid'] > 0){
				$commentData['id'] = $content['pid'];
				$results = $comment -> where($commentData) -> find();
			}else{
				$stickData['id'] = $content['aid'];
				$results = $stick -> where($stickData) -> find();
			}
			
			$re = getUid();
			$content['tuid'] = $results['uid'];
			$content['tutype'] = $results['utype'];
			$content['create_time'] = time();
			$content['regip'] = get_client_ip();
			$content['uid'] = $re['id'];
			if($comment->create($content)){
				$result = $comment -> add();
				if($result){
					$list['prim_comment.id'] = $result;
					$commont = $comment
						->join('left join prim_account a on prim_comment.uid = a.id and prim_comment.utype = 1')
						->join('left join prim_user u on prim_comment.uid = u.id and prim_comment.utype = 2')
						->field('prim_comment.id,prim_comment.aid,prim_comment.pid,prim_comment.uid,
						prim_comment.utype,prim_comment.content,prim_comment.create_time,
						a.avatarUrl,a.nickName,u.image userimage,u.username')
						->where($list)
						->find();
					if(intval($commont['pid']) > 0){
						$co['prim_comment.id'] =  $commont['pid'];
						$parent = $comment
							->join('left join prim_account a on prim_comment.uid = a.id and prim_comment.utype = 1')
							->join('left join prim_user u on prim_comment.uid = u.id and prim_comment.utype = 2')
							->field('prim_comment.content,prim_comment.utype,a.nickName,u.username')
							->where($co)
							->find();
						$commont['parent'] = $parent;
					}
					$commont['create_time'] = date('Y-m-d',$commont['create_time']);
					
					$data = array('code' => 1, 'msg' => '增加成功','comments' => $commont,'result' => $list,'test' => $results);
					$this -> ajaxReturn($data);
				}else{
					$data = array('code' => 0, 'msg' => '增加失败');
					$this -> ajaxReturn($data);
				}
			}else{
				$data = array('code' => 0, 'msg' => '增加失败');
				$this -> ajaxReturn($data);
			}
			
		}else{
			$id['id'] = $content['id'];
			$result = $comment -> where($id) -> save($content);
			if($result){
				$data = array('code' => 1, 'msg' => '编辑成功');
				$this -> ajaxReturn($data);
			}else{
				$data = array('code' => 0, 'msg' => '编辑失败');
				$this -> ajaxReturn($data);
			}
		}
	}
	
	public function getdetail(){}
}
?>