<?php
namespace Home\Controller;
use Common\Controller\HomeController;  

class StickController extends HomeController {
	public function index(){
		$stick = D('stick');	
		$content = I('post.');
		//type = 1 page分页 首页获取数据
		if(empty($content['type']) || empty($content['page'])){
			$data = array("code"=>0,"msg"=>"参数为空！");
	    	$this->ajaxReturn($data);
		}else
		if($content['type'] == 1  && $content['page'] == 1){
			$num = 10;
			$count = $stick -> order('count desc') -> page($content['page'],$num) -> select();
			$list = $stick -> order('count desc') -> page($content['page'],$num - count($count)) -> select();
		}
	}
	public function getUserNewList(){
		$stick = M('stick');
		$comment = M('comment');
		$account = M('account');
		$content = I('post.');
	
		
		
		if(IS_POST){
			$resultAccount = getUid();
			$options['prim_stick.uid'] = $resultAccount['id'];
			$options['prim_stick.utype'] = 1;
			$options['prim_stick.del'] = 1;
			$result = $stick
				-> join('left join prim_account a on prim_stick.uid = a.id')
				-> join('left join prim_assort s on prim_stick.utype = s.id')
				->field('prim_stick.id,prim_stick.tid,prim_stick.title,prim_stick.abstract,
					prim_stick.image,prim_stick.content,prim_stick.create_time,prim_stick.bar,
					prim_stick.count,prim_stick.utype,prim_stick.status,prim_stick.del,prim_stick.sort,
					a.nickName,a.avatarUrl')
				-> order('create_time desc')
				-> page($content['page'],$content['num'])
				-> where($options)
				-> select();
		
		
			if($result){
				forEach($result as $key => $value){
					$cou['aid'] = $result[$key]['id'];
					$result[$key]['comments'] = $comment-> where($cou) -> count();
					$result[$key]['create_time'] = date('Y-m-d',$result[$key]['create_time']);
					$result[$key]['content'] = htmlspecialchars_decode($result[$key]['content']);
					$result[$key]['bar'] = 1;
				}
				$data = array("code"=>1,"msg"=>"获取成功！",'info' => $result);
		    	$this->ajaxReturn($data);
			}else{
				$data = array("code"=>0,"msg"=>"获取失败！");
		    	$this->ajaxReturn($data);
			}
			
		}else{
			$data = array("code"=>0,"msg"=>"非法请求！");
		    $this->ajaxReturn($data);
		}
		
	}
	
	public function add(){
		$stick = D('stick');
		$content = I('post.');
		if(empty($content['id'])){
			if(empty($content['title'])){
				$data = array('code' => 0, 'msg' => '标题为空');
				$this -> ajaxReturn($data);
			}
			if(empty($content['content'])){
				$data = array('code' => 0, 'msg' => '内容为空');
				$this -> ajaxReturn($data);
			}
			if(empty($content['tid'])){
				$data = array('code' => 0, 'msg' => '文章类型为空');
				$this -> ajaxReturn($data);
			}
			if(empty($content['image']) || $content['image'] == 'undefined'){
				$content['image'] = '/Uploads/Image/available.png';
			}
		
			$re = getUid();
			$content['create_time'] = time();
			$content['uid'] = $re['id'];
			
			
			if($stick->create($content)){
				$result = $stick -> add();
				if($result){
					$data = array('code' => 1, 'msg' => '增加成功','info' => $result);
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
			$content['edit_time'] = time();
			$id['id'] = $content['id'];
			$result = $stick -> where($id) -> save($content);
			if($result){
				$data = array('code' => 1, 'msg' => '编辑成功');
				$this -> ajaxReturn($data);
			}else{
				$data = array('code' => 0, 'msg' => '编辑失败');
				$this -> ajaxReturn($data);
			}
		}
	}
	
	public function getdetail(){
		$stick = D('stick');
		$comment = M('comment');
		$praise = M('praise');
		$content = I('post.');
		$option['prim_stick.id'] = $content['id'];
		if(empty($content['id'])){
			$data = array('code' => 0, 'msg' => 'id获取失败');
			$this -> ajaxReturn($data);
		}else{
			$stick->where($content)->setInc('count',1); // 浏览量加1
			$re = getUid();
			
			$result = $stick
				->join('left join prim_account a on prim_stick.uid = a.id and prim_stick.utype = 1')
				->join('left join prim_user u on prim_stick.uid = u.id and prim_stick.utype = 2')
				->join('left join prim_assort s on prim_stick.utype = s.id')
				->join('left join prim_praise p on prim_stick.id = p.pid and p.tid = 1 and p.uid = prim_stick.uid and p.utype = 1')
				->field('prim_stick.id,prim_stick.tid,prim_stick.title,prim_stick.abstract,
					prim_stick.image,prim_stick.content,prim_stick.create_time,prim_stick.bar,
					prim_stick.count,prim_stick.utype,prim_stick.status,prim_stick.del,prim_stick.sort,
					prim_stick.imagesList,prim_stick.address,prim_stick.phone,
					a.nickName,a.avatarUrl,u.username,u.image userimage,s.name,p.status praise')
				->where($option)
				->find();
				
				
			$op['prim_stick.tid'] = $result['tid'];
			$op['prim_stick.del'] = 1;
			$op['prim_stick.status'] = 1;
			$op['prim_stick.bar'] = 1;
			$op['prim_stick.id'] = array('NEQ',$result['id']);
			$article = $stick
				-> join('left join prim_user u on prim_stick.uid = u.id and prim_stick.utype = 2')
				-> join('left join prim_account a on prim_stick.uid = a.id and prim_stick.utype = 1')
				-> join('left join prim_assort s on prim_stick.utype = s.id')
				->field('prim_stick.id,prim_stick.tid,prim_stick.title,prim_stick.abstract,
					prim_stick.image,prim_stick.content,prim_stick.create_time,prim_stick.bar,
					prim_stick.count,prim_stick.utype,prim_stick.status,prim_stick.del,prim_stick.sort,
					a.nickName,a.avatarUrl,u.username,u.image userimage,s.name')
				-> order('create_time desc')
				-> page(1,3)
				-> where($op)
				-> select();
			
			
			
			$options['prim_comment.aid'] = $content['id'];
			$commont = $comment
				->join('left join prim_account a on prim_comment.uid = a.id and prim_comment.utype = 1')
				->join('left join prim_user u on prim_comment.uid = u.id and prim_comment.utype = 2')
				->join('left join prim_praise p on prim_comment.id = p.pid and p.tid = 2 and p.uid = prim_comment.uid and p.utype = 1')
				->field('prim_comment.id,prim_comment.aid,prim_comment.pid,prim_comment.uid,
				prim_comment.utype,prim_comment.content,prim_comment.create_time,
				a.avatarUrl,a.nickName,u.image userimage,u.username,p.status praise')
				->where($options)
				->select();
			forEach($commont as $key => $value) {
				if(intval($commont[$key]['pid']) > 0){
					$co['prim_comment.id'] =  $commont[$key]['pid'];
					$parent = $comment
						->join('left join prim_account a on prim_comment.uid = a.id and prim_comment.utype = 1')
						->join('left join prim_user u on prim_comment.uid = u.id and prim_comment.utype = 2')
						->field('prim_comment.content,prim_comment.utype,a.nickName,u.username')
						->where($co)
						->find();
					$commont[$key]['parent'] = $parent;
				}
				if(empty($commont[$key]['praise'])){
					$commont[$key]['praise'] = -1;
				}
				$commont[$key]['create_time'] = date('Y-m-d',$commont[$key]['create_time']);
				$comentPraise['pid'] = $commont[$key]['id'];
				$comentPraise['uid'] = $re['id'];
				$comentPraise['utype'] = 1;
				$comentPraise['tid'] = 2;
				$commont[$key]['praisenum'] = $praise-> where($comentPraise) -> count();;
			}
			forEach($article as $key => $value){
				$cou['aid'] = $article[$key]['id'];
				$article[$key]['comments'] = $comment-> where($cou) -> count();
				$article[$key]['create_time'] = date('Y-m-d',$article[$key]['create_time']);
			}
			if($result){
				if(empty($result['praise'])){
					$result['praise'] = -1;
				}
				$result['content'] = htmlspecialchars_decode($result['content']);
				$result['create_time'] = date('Y-m-d',$result['create_time']);
				$data = array('code' => 1, 'msg' => '获取成功','info' => $result,'comment' => $commont,'article' => $article);
				$this -> ajaxReturn($data);
			}else{
				$data = array('code' => 0, 'msg' => 'id获取失败');
				$this -> ajaxReturn($data);
			}
		}
	}
	public function assortBarList(){
		$stick = M('stick');	
		$comment = M('comment');
		$data = I('post.');
		$content['prim_stick.del'] = 1;
		$content['prim_stick.status'] = 1;
		$content['prim_stick.bar'] = 3;
		$content['prim_stick.tid'] = $data['id'];
		
		$result = $stick
				-> join('left join prim_user u on prim_stick.uid = u.id and prim_stick.utype = 2')
				-> join('left join prim_account a on prim_stick.uid = a.id and prim_stick.utype = 1')
				-> join('left join prim_assort s on prim_stick.tid = s.id')
				->field('prim_stick.id,prim_stick.tid,prim_stick.title,prim_stick.abstract,
					prim_stick.image,prim_stick.content,prim_stick.create_time,prim_stick.bar,
					prim_stick.count,prim_stick.utype,prim_stick.status,prim_stick.del,prim_stick.sort,
					a.nickName,a.avatarUrl,u.username,u.image userimage,s.name')
				-> order('sort desc')
				-> where($content)
				-> page($content['page'],$content['num'])
				-> select();
		
		
		if($result){
			forEach($result as $key => $value){
				$cou['aid'] = $result[$key]['id'];
				$result[$key]['comments'] = $comment-> where($cou) -> count();
				$result[$key]['create_time'] = date('Y-m-d',$result[$key]['create_time']);
				$result[$key]['content'] = htmlspecialchars_decode($result[$key]['content']);
			}
			$data = array("code"=>1,"msg"=>"获取成功！",'info' => $result);
	    	$this->ajaxReturn($data);
		}else{
			$data = array("code"=>0,"msg"=>"获取失败！");
	    	$this->ajaxReturn($data);
		}
		
	}
	public function assortNewList(){
		$stick = M('stick');	
		$comment = M('comment');
		$data = I('post.');
		$content['prim_stick.del'] = 1;
		$content['prim_stick.status'] = 1;
		$content['prim_stick.bar'] = 1;
		$content['prim_stick.tid'] = $data['id'];
		$order = $data['methods'] ? $data['methods'].' desc' : 'count desc';
		
		
		$result = $stick
				-> join('left join prim_user u on prim_stick.uid = u.id and prim_stick.utype = 2')
				-> join('left join prim_account a on prim_stick.uid = a.id and prim_stick.utype = 1')
				-> join('left join prim_assort s on prim_stick.tid = s.id')
				->field('prim_stick.id,prim_stick.tid,prim_stick.title,prim_stick.abstract,
					prim_stick.image,prim_stick.content,prim_stick.create_time,prim_stick.bar,
					prim_stick.count,prim_stick.utype,prim_stick.status,prim_stick.del,prim_stick.sort,
					a.nickName,a.avatarUrl,u.username,u.image userimage,s.name')
				-> order($order)
				-> where($content)
				-> page($content['page'],$content['num'])
				-> select();
		
		
		if($result){
			forEach($result as $key => $value){
				$cou['aid'] = $result[$key]['id'];
				$result[$key]['comments'] = $comment-> where($cou) -> count();
				$result[$key]['create_time'] = date('Y-m-d',$result[$key]['create_time']);
				$result[$key]['content'] = htmlspecialchars_decode($result[$key]['content']);
			}
			$data = array("code"=>1,"msg"=>"获取成功！",'info' => $result);
	    	$this->ajaxReturn($data);
		}else{
			$data = array("code"=>0,"msg"=>"获取失败！");
	    	$this->ajaxReturn($data);
		}
		
	}
}