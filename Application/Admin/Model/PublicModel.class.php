<?php
namespace Admin\Model;
use Think\Model;
class PublicModel extends Model {
    // 定义自动验证
    protected $_validate    =   array(
        array('name','require','用户名不能为空'),
        );
    protected $_validate    =   array(
        array('psw','require','密码不能为空'),
        );
    // 定义自动完成
    protected $_auto    =   array(
        array('time','time',1,'function'),
    );
}
?>