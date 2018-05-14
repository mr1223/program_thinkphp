<?php
namespace Home\Controller;
use Think\Controller;
class NewController extends Controller {
	public function new_list($page=0){
		headerSetting();
		$adm_uid = is_login();
		if(IS_GET){
			$new = M('new');
			$page = I('get.page');
			$type = I('get.type');
			$limit = 5;
			$content['sort_id'] = array('gt',0);
			$content['state'] = 1;
			$content['type'] = $type;
			$result = $new->where($content)->field('id,sort_id,big_headlines')->limit($limit)->page($page)->order('sort_id desc')->select();
			$data = array('code'=>'1','data'=>$result);
			$this->ajaxReturn($data);
		}else{
			$data = array('code'=>'0','data'=>'错误请求');
			$this->ajaxReturn($data);
		}
	}
	public function new_data(){
		headerSetting();
		$adm_uid = is_login();
		if(IS_GET){
			$new = M('new');
			$id = I('get.id');
			$sort_id = I('get.sort_id');
			$content['id'] = $id;
			$content['state'] = 1;
			$result = $new->where($content)->field('id,sort_id,big_headlines,sm_headings,author,FROM_UNIXTIME(create_time, "%Y-%m-%d") as create_time,content')->select();
			$prev['sort_id'] = array('lt',$sort_id);
			$prev['state'] = 1;
			$prev_result = $new->where($prev)->order('sort_id DESC')->field('id,sort_id,big_headlines,cover')->limit('1')->select();
			$next['sort_id'] = array('gt',$sort_id);
			$next['state'] = 1;
			$next_result = $new->where($next)->order('sort_id ASC')->field('id,sort_id,big_headlines,cover')->limit('1')->select();
			if($result){
				$data = array('code'=>'1','data'=>$result,'prev'=>$prev_result,'next'=>$next_result);
				$this->ajaxReturn($data);
			}else{
				$data = array('code'=>'0','data'=>'请求失败 文章不存在或已被删除');
				$this->ajaxReturn($data);
			}
		}else{
			$data = array('code'=>'0','data'=>'错误请求');
			$this->ajaxReturn($data);
		}
	}
}
?>