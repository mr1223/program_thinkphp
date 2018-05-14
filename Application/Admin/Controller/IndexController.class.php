<?php
namespace Admin\Controller;
use Common\Controller\AdminController;  

class IndexController extends AdminController {
	
    public function index(){
		/*headerSetting();
		$adm_uid = is_login();
		if($adm_uid){
			$data['uid'] = $adm_uid;
			$result = M('test')->where($data)->select();
			if($result){
				$Data = array('code'=>'1',"data"=>$result,'uid'=>$adm_uid);
		    	$this->ajaxReturn($Data);
			}else{
				$Data = array('code'=>'0',"data"=>"暂无数据",'uid'=>$adm_uid);
		    	$this->ajaxReturn($Data);
			}
		}else{
			$Data = array('code'=>'3',"data"=>"请先去登录",'uid'=>$adm_uid);
		    $this->ajaxReturn($Data);
		}*/
		$this->display();
    }
    public function addPhone(){
    	$phone = M('phone');
		$date = I('post.');
		$date['id'] = 1;
		$result = $phone->save($date);
		if($result){
			$Data = array("code"=>1,"msg"=>"更新成功！");
    		$this->ajaxReturn($Data);
		}else{
			$Data = array("code"=>0,"msg"=>"更新失败！");
    		$this->ajaxReturn($Data);
		}
    }
    public function getPhone(){
    	$phone = M('phone');
		$date['id'] = 1;
		$result = $phone->where($date)->find();
		if($result){
			$Data = array("code"=>1,"msg"=>"查找成功！","info"=>$result);
    		$this->ajaxReturn($Data);
		}else{
			$Data = array("code"=>0,"msg"=>"查找失败！");
    		$this->ajaxReturn($Data);
		}
    }
    public function addCarousel(){
		
		$carousel = M('carousel');
		$date = I('post.');
		if(empty($date['title'])){
			$Data = array('code'=>0,"msg"=>'名字为空！');
	    	$this->ajaxReturn($Data);
		}
		if(empty($date['sort'])){
			$Data = array('code'=>0,"msg"=>'排序为空！');
	    	$this->ajaxReturn($Data);
		}
		if(empty($date['image_src'])){
			$Data = array('code'=>0,"msg"=>'图片为空！');
	    	$this->ajaxReturn($Data);
		}
		if(empty($date['id'])){
			$date['status'] = 1;
			$date['reveal'] = 1;
			if($carousel->create($date)) {
				$result = $carousel->add();
				if($result){
					$Data = array('code'=>1,"msg"=>'添加成功！');
		    		$this->ajaxReturn($Data);
				}else{
					$Data = array('code'=>0,"msg"=>'添加失败！');
		    		$this->ajaxReturn($Data);
				}
			}else{
				$Data = array('code'=>0,"msg"=>'添加失败！');
		    	$this->ajaxReturn($Data);
			}
			
		}else{
			$result = $carousel->save($date);
			if($result){
				$Data = array('code'=>1,"msg"=>'更新成功！');
	    		$this->ajaxReturn($Data);
			}else{
				$Data = array('code'=>0,"msg"=>'更新失败！');
	    		$this->ajaxReturn($Data);
			}
		}
		
		
    }
    public function getCarousel(){
		
		$carousel = M('carousel');
		$date = I('post.');
		if(empty($date['id'])){
			$Data = array('code'=>0,"msg"=>'未获取到id！');
	    	$this->ajaxReturn($Data);
		}else{
			
			$result = $carousel->where($date)->find();
			if($result){
				$Data = array('code'=>1,"msg"=>'获取成功！',"data"=>$result);
	    		$this->ajaxReturn($Data);
			}else{
				$Data = array('code'=>0,"msg"=>'获取失败！');
	    		$this->ajaxReturn($Data);
			}
			
		}
	}
	public function getCarouselList(){
		
		$carousel = M('carousel');
		$date['status'] = 1;
		$result = $carousel->where($date)->select();
		if($result){
			$Data = array('code'=>1,"msg"=>"获取成功！","info"=>$result);
    		$this->ajaxReturn($Data);
		}else{
			$Data = array('code'=>0,"msg"=>'获取失败！');
    		$this->ajaxReturn($Data);
		}
	}
	public function removeCarousel(){
		
		$carousel = M('carousel');
		$date = I('post.');
		if(empty($date['id'])){
			$Data = array('code'=>0,"msg"=>'未获取到id！');
	    	$this->ajaxReturn($Data);
		}else{
			$date['status'] = -1;
			$result = $carousel->save($date);
			if($result){
				$Data = array('code'=>1,"msg"=>'删除成功！');
	    		$this->ajaxReturn($Data);
			}else{
				$Data = array('code'=>0,"msg"=>'删除失败！');
	    		$this->ajaxReturn($Data);
			}
			
		}
	}
	public function showhideCarousel(){
		
		$carousel = M('carousel');
		$date = I('post.');
		if(empty($date['id'])){
			$Data = array('code'=>0,"msg"=>'未获取到id！');
	    	$this->ajaxReturn($Data);
		}else{
			
			$result = $carousel->save($date);
			if($result){
				$Data = array('code'=>1,"msg"=>'状态更新成功！');
	    		$this->ajaxReturn($Data);
			}else{
				$Data = array('code'=>0,"msg"=>'状态更新失败！');
	    		$this->ajaxReturn($Data);
			}
			
		}
	}
    /*public function referer_data(){
    	headerSetting();
    	$adm_uid = is_login();
		if(!empty($adm_uid)){
			$cur_date = strtotime(date('Y-m-d'));
			$content['createtime'] = array('egt',$cur_date);
			$sup_cookie['createtime'] = array('egt',$cur_date);
			$sup_cookie['supportcookie'] = 1;
			$count =  M('Databasis')->where($content)->count();
			$cookie =  M('Databasis')->where($sup_cookie)->count();
			$result['count'] = $count;
			$result['cookie'] = $cookie;
			$Data = array('code'=>'1',"data"=>$result);
	    	$this->ajaxReturn($Data);
		}else{
    		$Data = array('code'=>'0',"data"=>"请先去登录");
	    	$this->ajaxReturn($Data);
    	}
    	
    }*/
}