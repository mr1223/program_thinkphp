<?php
namespace Admin\Model;
use Think\Model;
class NewModel extends Model {
	// 定义自动验证
    protected $_validate    =   array(
        array('big_headlines','require','标题为空'),
    );
    //定义自动完成
    protected $_auto    =   array(
        array('create_time','time',1,'function'),
    );
}
?>