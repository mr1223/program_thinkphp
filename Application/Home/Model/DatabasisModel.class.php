<?php

namespace Home\Model;
use Think\Model;
class DatabasisModel extends Model {
	
	// 定义自动完成
    protected $_auto    =   array(
        array('createtime','time',1,'function'),
    );
}


?>