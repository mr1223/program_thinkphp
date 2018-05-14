<?php
	function getUid() {
		$info = session('myinfo');
		$options['openId'] = $info['openId'];
		$re = M('account') -> where($options) ->field('id') -> find();
		return $re;
	}
	function is_login(){
		$adm_uid = session('info')['token'];
		if (empty ( $adm_uid )) {
			return 0;
		} else {
			return $adm_uid;
		}
	}
	function addSaltMD5($name=0){
		$newname = md5($name);
		return $newname;
	}
	function headerSetting(){
		$origin = isset($_SERVER['HTTP_ORIGIN'])? $_SERVER['HTTP_ORIGIN'] : ''; 
		 
		$allow_origin = array(  
		    'http://localhost:8082',  
		    'http://www.wainaoke.com',
		    'https://www.wainaoke.com',
		);
		if(in_array($origin, $allow_origin)){  
		    header('Access-Control-Allow-Origin:'.$origin);  
			header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
			header('Access-Control-Allow-Methods: GET, POST, PUT');
			header('Access-Control-Allow-Credentials: true');  
		} 
	}
	function exportExcel($expTitle,$expCellName,$expTableData){
        $xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
        $fileName = $_SESSION['account'].date('_YmdHis');//or $xlsTitle 文件名称可根据自己情况设定
        $cellNum = count($expCellName);
        $dataNum = count($expTableData);
        import("Org.Util.PHPExcel");
       
        $objPHPExcel = new \PHPExcel();
        $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
        
        $objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');//合并单元格
       // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle.'  Export time:'.date('Y-m-d H:i:s'));  
        for($i=0;$i<$cellNum;$i++){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'2', $expCellName[$i][1]); 
        } 
          // Miscellaneous glyphs, UTF-8   
        for($i=0;$i<$dataNum;$i++){
          for($j=0;$j<$cellNum;$j++){
            $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+3), $expTableData[$i][$expCellName[$j][0]]);
          }             
        }  
        
        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
        header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
        $objWriter->save('php://output'); 
        exit;   
    }
    
	   /* 参数说明：
	    $lng  经度
	    $lat   纬度
	    $distance  周边半径  默认是500米（0.5Km）*/
	function returnSquarePoint($lng, $lat,$distance)
	{
	    $dlng =  2 * asin(sin($distance / (2 * 6371)) / cos(deg2rad($lat)));
	    $dlng = rad2deg($dlng);
	    $dlat = $distance/6371;
	    $dlat = rad2deg($dlat);
	    return array(
	    'left-top'=>array('lat'=>$lat + $dlat,'lng'=>$lng-$dlng),
	    'right-top'=>array('lat'=>$lat + $dlat, 'lng'=>$lng + $dlng),
	    'left-bottom'=>array('lat'=>$lat - $dlat, 'lng'=>$lng - $dlng),
	    'right-bottom'=>array('lat'=>$lat - $dlat, 'lng'=>$lng + $dlng)
	    );
	}
	//根据经纬度计算距离 其中A($lat1,$lng1)、B($lat2,$lng2)
	function getDistance($lat1,$lng1,$lat2,$lng2)
	{
	    //地球半径
	    $R = 6378137;
	  
	    //将角度转为狐度
	    $radLat1 = deg2rad($lat1);
	    $radLat2 = deg2rad($lat2);
	    $radLng1 = deg2rad($lng1);
	    $radLng2 = deg2rad($lng2);
	  
	    //结果
	    $s = acos(cos($radLat1)*cos($radLat2)*cos($radLng1-$radLng2)+sin($radLat1)*sin($radLat2))*$R;
	  
	    //精度
	    $s = round($s* 10000)/10000;
	  
	    return  round($s);
	}
	function calculateAdjacent($srcHash, $dir)
    {
        $srcHash = strtolower($srcHash);
        $lastChr = $srcHash[strlen($srcHash) - 1];
        $type = (strlen($srcHash) % 2) ? 'odd' : 'even';
        $base = substr($srcHash, 0, strlen($srcHash) - 1);
        $borders = borders;
    	$base_test = $borders[$dir];
        if (strpos($base_test[$type], $lastChr) !== false) {
            $base = calculateAdjacent($base, $dir);
        }
        $neighbors = neighbors;
        $neighbors_test = $neighbors[$dir];
        $coding = coding;
        return $base . $coding[strpos($neighbors_test[$type], $lastChr)];
    }
	function neighbors($srcHash)
    {
        $geohashPrefix = substr($srcHash, 0, strlen($srcHash) - 1);
    
        $neighbors['top'] = calculateAdjacent($srcHash, 'top');
        $neighbors['bottom'] = calculateAdjacent($srcHash, 'bottom');
        $neighbors['right'] = calculateAdjacent($srcHash, 'right');
        $neighbors['left'] = calculateAdjacent($srcHash, 'left');
         
        $neighbors['topleft'] = calculateAdjacent($neighbors['left'], 'top');
        $neighbors['topright'] = calculateAdjacent($neighbors['right'], 'top');
        $neighbors['bottomright'] = calculateAdjacent($neighbors['right'], 'bottom');
        $neighbors['bottomleft'] = calculateAdjacent($neighbors['left'], 'bottom');
    
        return $neighbors;
    }
?>