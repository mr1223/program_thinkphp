<?php
namespace Admin\Model;
use Think\Model;
class AccountModel extends Model {
	// 定义自动验证
    protected $_validate = array(
    	array('uid','require','登陆失效，请重新登陆'),
    	array('tid','require','文章类型为空'),
        array('title','require','标题为空'),
        array('abstract','require','摘要为空'),
        array('content','require','内容为空'),
    );
    //定义自动完成
    protected $_auto = array(
        array('create_time','time',2,'function'),
    );
}
?>