<?php
namespace Admin\Controller;
use Common\Controller\AdminController;  

class AssortController extends AdminController {
	protected $patchValidate = true;
	public function index(){
		$assort = D('assort');
		$options = I('post.');
		$date['del'] = 1;
		$count = $assort->count();
		$result = $assort -> where($date)->page($options['page'],$options['num']) -> select();
		//$result = $assort -> where($date) ->field('id,name,image,abstract') -> select();
		if($result){
			forEach($result as $key => $value){
				$result[$key]['create_time'] =  date('Y-m-d',$result[$key]['create_time']);
				$result[$key]['edit_time'] =  date('Y-m-d',$result[$key]['edit_time']);
			}
	    	$data = array('code' => 1, 'msg' => '获取成功','info' => $result,'count' => $count);
			$this->ajaxReturn($data);
	    }else{
	    	$data = array('code' => 0, 'msg' => '获取失败');
			$this->ajaxReturn($data);
	    }
	}
	public function add(){
		if(IS_POST){
			$assort = D('assort');
			if (!$assort->create()){
			    // 如果创建失败 表示验证没有通过 输出错误提示信息
			    $data = array('code' => 0, 'msg' => $assort->getError());
			    $this->ajaxReturn($data);
			}else{
			    // 验证通过 可以进行其他数据操作
			    $date = I('post.');
			    $cont['id'] = $date['id'];
			    if(empty($date['id'])){
			    	$date['create_time'] = time();
			    	$result = $assort -> add($date);
			    }else{
			    	$cont['id'] = $date['id'];
			    	$date['edit_time'] = time();
			    	$result = $assort -> where($cont) -> save($date);
			    }
			    if($result){
			    	$data = array('code' => 1, 'msg' => '成功');
					$this->ajaxReturn($data);
			    }else{
			    	$data = array('code' => 0, 'msg' => '失败');
					$this->ajaxReturn($data);
			    }
			}
		}else{
			$data = array('code' => 0, 'msg' => '非法请求');
			$this->ajaxReturn($data);
		}
		
	}
	public function getAssort(){
		//传入ID
		if(IS_POST){
			$assort = D('assort');
			$date = I('post.');
			$result = $assort -> where($date) -> find();
			
			if($result){
				$result['style'] =  htmlspecialchars_decode($result['style']);
				$result['create_time'] =  date('Y-m-d',$result['create_time']);
		    	$data = array('code' => 1, 'msg' => '获取成功','info' => $result);
				$this->ajaxReturn($data);
		    }else{
		    	$data = array('code' => 0, 'msg' => '获取失败');
				$this->ajaxReturn($data);
		    }
			
			
		}else{
			$data = array('code' => 0, 'msg' => '非法请求');
			$this->ajaxReturn($data);
		}
	}
	public function change(){
		//传入ID  状态
		if(IS_POST){
			$assort = D('assort');
			$date = I('post.');
			$result = $assort -> save($date);
			if($result){
		    	$data = array('code' => 1, 'msg' => '修改成功');
				$this->ajaxReturn($data);
		    }else{
		    	$data = array('code' => 0, 'msg' => '修改失败');
				$this->ajaxReturn($data);
		    }
		}else{
			$data = array('code' => 0, 'msg' => '非法请求');
			$this->ajaxReturn($data);
		}
	}
	public function del(){
		
	}
}
?>