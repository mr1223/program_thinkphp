<?php

namespace Home\Model;
use Think\Model;
class MessageModel extends Model {
	
	// 定义自动完成
    protected $_auto    =   array(
        array('createtime','time',1,'function'),
        array('password','^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{8,16}$','密码格式不正确！',0,'regex',1),
    );	
}


?>