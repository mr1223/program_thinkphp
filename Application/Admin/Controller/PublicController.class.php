<?php
namespace Admin\Controller;
use Common\Controller\AdminController;  

class PublicController extends AdminController {
	
	public function getUser(){
		if(IS_POST){
			$user = M('user');
			$result = $user -> field('id,username') -> select();
			if($result){
				$data = array('code'=>1,'data'=>'获取成功','info'=>$result);
		    	$this->ajaxReturn($data);
			}else{
				$data = array('code'=>0,'data'=>'获取失败','info'=>$result);
		    	$this->ajaxReturn($data);
			}
		}
		
	}
	public function uploadImg(){
		
    	$upload = new \Think\Upload();
    	$upload->maxSize = 3145728;
    	$upload->exts = array('jpg', 'gif', 'png', 'jpeg');
    	$upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
    	$upload->savePath  =     ''; // 设置附件上传（子）目录
    	$info   =   $upload->upload();
	    if(!$info) {// 上传错误提示错误信息
	        $this->error($upload->getError());
	    }else{// 上传成功
	    	$path = __ROOT__.'/Uploads/'.$info['files']['savepath'].$info['files']['savename'];
	    	$data = array('code'=>1,'data'=>'上传成功','path'=>$path);
	    	$this->ajaxReturn($data);
	        //$this->success('上传成功！');
	    }
    	
    }
	public function verify(){
    	$Verify = new \Think\Verify();
		$Verify->entry();
    }
}
?>