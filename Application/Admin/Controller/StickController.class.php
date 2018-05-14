<?php
namespace Admin\Controller;
use Common\Controller\AdminController;  

class StickController extends AdminController {
	public function index(){
		$stick = M('stick');	
		$content = I('post.');
		$contents['prim_stick.del'] = 1;
		if($content['starttime']){
			$starttime = strtotime($content['starttime']);
			$endtime = strtotime($content['endtime']);
			$contents['prim_stick.create_time'] = array(array('gt',$starttime),array('lt',$endtime));
		}
		if($content['tid']){
			$contents['prim_stick.tid'] = $content['tid'];
		}
		if($content['search']){
			$contents['prim_stick.title'] = array('like','%'.$content['search'].'%');
			//$contents['prim_stick.content'] = array('like','%'.$content['search'].'%');
			//$contents['_logic']='OR';
		}
		$desc = $content["desc"] ? $content["desc"] : "desc";
		$method = $content["method"] ?  $content["method"]." ".$desc : "create_time"." ".$desc;
		
		
		
		
		if($content['type'] == 1){
			//默认按照发布时间排序
			$result = $stick
				-> join('left join prim_user u on prim_stick.uid = u.id and prim_stick.utype = 2')
				-> join('left join prim_account a on prim_stick.uid = a.id and prim_stick.utype = 1')
				->field('prim_stick.id,prim_stick.tid,prim_stick.title,prim_stick.abstract,
					prim_stick.image,prim_stick.content,prim_stick.create_time,prim_stick.bar,
					prim_stick.count,prim_stick.utype,prim_stick.status,prim_stick.del,
					a.nickName,u.username')
				-> order($method)
				-> where($contents)
				-> page($content['page'],$content['num'])
				-> select();
		}else
		if($content['type'] == 2){
			//只查询前台用户帖子
			$result = $stick 
				-> join('right join prim_account a on prim_stick.uid = a.id and prim_stick.utype = 1')
				->field('prim_stick.id,prim_stick.tid,prim_stick.title,prim_stick.abstract,
					prim_stick.image,prim_stick.content,prim_stick.create_time,prim_stick.bar,
					prim_stick.count,prim_stick.utype,prim_stick.status,a.nickName')
				-> order($method)
				-> where($contents)
				-> page($content['page'],$content['num'])
				-> select();
		}else
		if($content['type'] == 3){
			//只查询后台用户帖子
			$result = $stick 
				-> join('right join prim_user u on prim_stick.uid = u.id and prim_stick.utype = 2')
				->field('prim_stick.id,prim_stick.tid,prim_stick.title,prim_stick.abstract,
					prim_stick.image,prim_stick.content,prim_stick.create_time,prim_stick.bar,
					prim_stick.count,prim_stick.utype,prim_stick.status,u.username')
				-> order($method)
				-> where($contents)
				-> page($content['page'],$content['num'])
				-> select();
		}
		
		//type = 1 page分页 首页获取数据
		//> join('LEFT JOIN z_Job ON z_JobType.ID = z_Job.JobType')
		$cou['del'] = 1;
		$count = $stick-> where($cou) -> count();
		//$result = $stick -> where($content) -> order('count desc') -> page($content['page'],$content['num']) -> select();
		if($result){
			$data = array('code' => 1, 'msg' => '获取成功', 'info' => $result,'count' => $count);
			$this -> ajaxReturn($data);
		}else{
			$data = array('code' => 0, 'msg' => '获取失败');
			$this -> ajaxReturn($data);
		}
	}
	public function getStick(){
		$stick = D('stick');
		$content = I('post.');
		$content['del'] = 1;
		
		
		$result = $stick -> where($content) -> find();
		if($result['utype'] == 2){
			$user = M('user') -> where('id='.$result['uid']) -> find();
			$result['username'] = $user['username'];
		}else
		if($result['utype'] == 1){
			$account = M('account') -> where('id='.$result['uid']) -> find();
			$result['nickname'] = $account['nickname'];
		}
		
		
		/*$contents['id'] = $content['id'];
		$contents['del'] = 1;
		$result = $stick 
				-> join('left join prim_user u on prim_stick.uid = u.id and prim_stick.utype = 2')
				-> join('left join prim_account a on prim_stick.uid = a.id and prim_stick.utype = 1')
				->field('prim_stick.id,prim_stick.tid,prim_stick.title,prim_stick.abstract,
					prim_stick.image,prim_stick.content,prim_stick.create_time,prim_stick.bar,
					prim_stick.count,prim_stick.utype,prim_stick.uid,prim_stick.status,a.nickName')
				-> where($contents)
				-> find();	*/
		
		//$result = $stick -> where($content) -> find();
		if($result){
			$result['content'] = htmlspecialchars_decode($result['content']);
			$result['create_time'] = date('Y-m-d',$result['create_time']);
			$data = array('code' => 1, 'msg' => '获取成功', 'info' => $result);
			$this -> ajaxReturn($data);
		}else{
			$data = array('code' => 0, 'msg' => '获取失败');
			$this -> ajaxReturn($data);
		}
	}
	public function changeStick(){
		$stick = D('stick');
		$content = I('post.');
		$id['id'] = I('post.id');
		$result = $stick -> where($id) -> save($content);
		if($result){
			$data = array('code' => 1, 'msg' => '状态修改成功');
			$this -> ajaxReturn($data);
		}else{
			$data = array('code' => 0, 'msg' => '状态修改失败');
			$this -> ajaxReturn($data);
		}
	}
	public function add(){
		$stick = D('stick');
		$content = I('post.');
		if(empty($content['id'])){
			
			if($stick->create($content)){
				$result = $stick -> add();
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
}
?>