<?php
namespace Admin\Controller;
use Common\Controller\AdminController;  

class TestController extends AdminController {
	public function index(){
		$this->display();
	}
	public function aress(){
		$active = M('active');
		$longitude = I('get.long');
		$latitude = I('get.lat');
		$geohash = new GeoHash();
		$hash = $geohash->encode($latitude, $longitude);
		$pre_hash = substr($hash, 0, 5);
		//取出相邻八个区域
		$neighbors = $geohash->neighbors($pre_hash);
		array_push($neighbors, $pre_hash);
		
		$values = '';
		foreach ($neighbors as $key=>$val) {
		  $values .= '\'' . $val . '\'' .',';
		}
		$values = substr($values, 0, -1);
		//$sql = SELECT * FROM 'bj_active' WHERE LEFT('geohash',5) IN ('wm6n0','wm6j8','wm6jc','wm3vz','wm3yp','wm6n1','wm6j9','wm3vx','wm6jb');
		/*$array = getAround($latitude, $longitude, 200000000);
		$condition['place_lat']  = array(array('EGT',$array['minLat']),array('ELT',$array['maxLat']),'or');//(`latitude` >= minLat) AND (`latitude` <=maxLat) 
		$condition['place_long'] = array(array('EGT',$array['minLng']),array('ELT',$array['maxLng']),'or');//(`longitude` >= minLng) AND (`longitude` <= maxLng)*/
		/*$array = returnSquarePoint($longitude, $latitude,0.5);
		$map = array(
		   "place_lat" => array(array('EGT',$array['right-bottom']['lat']),array('ELT',$array['left-top']['lat']),'or'),
		   "place_long" => array(array('EGT',$array['left-top']['lng']),array('ELT',$array['right-bottom']['lng']),'or'),
		   "statu" => array("eq",1),
		);
		$content = $active->where($map)->select();*/
		$date = array('code'=>'0','data'=>$sql,'map'=>$values);
	    $this->ajaxReturn($date);
		/*$map = array(
		   "latitude" => array(array('EGT',$array['right-bottom']['lat']),array('ELT',$array['left-top']['lat']),'or'),
		   "longitude" => array(array('EGT',$array['left-top']['lng']),array('ELT',$array['right-bottom']['lng']),'or'),
		   "statu" => array("eq",1),
		);*/
	}
	//附近的人实现
	public function adess(){
		$number = 5;
		import("Org.Util.Geohash");
		$active = M('active');
		$longitude = I('get.long');
		$latitude = I('get.lat');
		$geohash = new \GeoHash();
		$hash = $geohash->encode($latitude, $longitude);
		$pre_hash = substr($hash, 0, $number);
		$neighbors = neighbors($pre_hash);
		array_push($neighbors, $pre_hash);
		$values = '';
		foreach ($neighbors as $key=>$val) {
		  $values .= '\'' . $val . '\'' .',';
		}
		$values = substr($values, 0, -1);
		$sqls = "SELECT * FROM bj_active WHERE LEFT(place," . $number . ") IN (".$values.")";
		//$sqls = "select * from bj_active where left ('place',5)  IN (".$values.")";
		$sql = 'select * from bj_active where place like "'.$pre_hash.'%"';
		$content = $active->query($sql); 
		//$datas = $mysql->queryAll($sql);
		//算出实际距离
		foreach($content as $key=>$val)
		{
		    $distance = getDistance($latitude,$longitude,$val['place_lat'],$val['place_long']);
		  
		    $content[$key]['distance'] = $distance;
		  
		    //排序列
		    $sortdistance[$key] = $distance;
		}
		//距离排序
		array_multisort($sortdistance,SORT_ASC,$content);
		$date = array('code'=>'0','data'=>$content,'map'=>$sqls,'neighbors'=>$neighbors);
	    $this->ajaxReturn($date);
	}
	public function test(){
		header('Access-Control-Allow-Origin: *');  
		header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
		header('Access-Control-Allow-Methods: GET, POST, PUT');
		header('Access-Control-Allow-Credentials: true');  
		$content = I('post.');
		$date = array('code'=>'0','data'=>$content);
		//写入本地txt文件
		$filename = 'file.txt';
		$word = $content;  //双引号会换行 单引号不换行
		file_put_contents($filename, var_export($word, true));
		//file_put_contents($filename, $word);
	    $this->ajaxReturn($date);
	}	
}
?>