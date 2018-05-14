<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
	
	public function getCarouselList(){
		$carousel = M('carousel');
		$date['status'] = 1;
		$date['show'] = 1;
		$result = $carousel->where($date)->order('sort desc')->select();
		if($result){
			$Data = array('code'=>1,"msg"=>"获取成功！","info"=>$result);
    		$this->ajaxReturn($Data);
		}else{
			$Data = array('code'=>0,"msg"=>'获取失败！');
    		$this->ajaxReturn($Data);
		}
	}
	
	public function getAssortList(){
		$assort = D('assort');
		$date['del'] = 1;
		$date['status'] = 1;
		//$result = $assort -> where($date) -> select();
		$result = $assort -> where($date)->order('sort desc') ->field('id,name,image,sort,color,icon,style') -> select();
		if($result){
			forEach($result as $key => $value){
				$result[$key]['style'] = htmlspecialchars_decode($result[$key]['style']);
			}
	    	$data = array('code' => 1, 'msg' => '获取成功','info' => $result);
			$this->ajaxReturn($data);
	    }else{
	    	$data = array('code' => 0, 'msg' => '获取失败');
			$this->ajaxReturn($data);
	    }
	}
	public function getIndexNewBar(){
		$stick = M('stick');	
		$comment = M('comment');
		$content['prim_stick.del'] = 1;
		$content['prim_stick.status'] = 1;
		$content['prim_stick.bar'] = 2;
		//$result = $stick -> where($content) -> select();
		
		$result = $stick
				-> join('left join prim_user u on prim_stick.uid = u.id and prim_stick.utype = 2')
				-> join('left join prim_account a on prim_stick.uid = a.id and prim_stick.utype = 1')
				-> join('left join prim_assort s on prim_stick.utype = s.id')
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
	
	public function getIndexNewList(){
		$stick = M('stick');
		$comment = M('comment');	
		$content = I('post.');
		$contents['prim_stick.del'] = 1;
		$contents['prim_stick.status'] = 1;
		$contents['prim_stick.bar'] = array('EQ',1);
		
		
		
		if(IS_POST){
			
			$result = $stick
				-> join('left join prim_user u on prim_stick.uid = u.id and prim_stick.utype = 2')
				-> join('left join prim_account a on prim_stick.uid = a.id and prim_stick.utype = 1')
				-> join('left join prim_assort s on prim_stick.tid = s.id')
				->field('prim_stick.id,prim_stick.tid,prim_stick.title,prim_stick.abstract,
					prim_stick.image,prim_stick.content,prim_stick.create_time,prim_stick.bar,
					prim_stick.count,prim_stick.utype,prim_stick.status,prim_stick.del,prim_stick.sort,
					a.nickName,a.avatarUrl,u.username,u.image userimage,s.name ')
				-> order('count desc')
				-> where($contents)
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
			
		}else{
			$data = array("code"=>0,"msg"=>"非法请求！");
		    $this->ajaxReturn($data);
		}
		
	}
	
}