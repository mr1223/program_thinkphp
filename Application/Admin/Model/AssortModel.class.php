<?php
namespace Admin\Model;
use Think\Model;
class AssortModel extends Model {
	// 定义自动验证
    protected $_validate = array(
        array('name','require','名字为空'),
        array('image','require','图标为空'),
        array('abstract','require','简介为空'),
    );
    //定义自动完成
    protected $_auto = array(
        array('edit_time','time',2,'function'),
    );
}
?>