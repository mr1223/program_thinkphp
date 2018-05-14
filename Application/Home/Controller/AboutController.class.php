<?php
namespace Home\Controller;
use Think\Controller;
class AboutController extends Controller {
	public function index(){
		
		
		$this->display();
	}
	public function add(){
		$work = M('country');
		//$country = M('country');
		if(IS_POST){
			$data['date'] = date('Y-m-d H:i:s'); //数据库更新成功字段
			$data_arr = I('post.data'); //一维数组
			//$result = $work->addAll($data_arr);

			//$result = $country->addAll($data);
			if($result){
				$res = array('code'=>'1','data'=>$result);
			}else{
				$res = array('code'=>'0','data'=>$result);
			}
			$this->ajaxReturn($res);
		}
		
		
	}
	public function contact(){
		$this->display();
	}
}
?>