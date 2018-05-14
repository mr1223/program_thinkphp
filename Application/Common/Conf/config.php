<?php
return array(
	//'配置项'=>'配置值'
	'DB_TYPE'=>'mysql',// 数据库类型
	'DB_HOST'=>'',// 服务器地址
	'DB_NAME'=>'',// 数据库名
	'DB_USER'=>'',// 用户名
	'DB_PWD'=>'',// 密码
	'DB_PORT'=>3306,// 端口
	'DB_PREFIX'=>'',// 数据库表前缀
	'DB_CHARSET'=>'utf8',// 数据库字符集
	'AUTH_CONFIG' => array(
	  	'AUTH_ON' => true, //认证开关
	  	'AUTH_TYPE' => 1, // 认证方式，1为时时认证；2为登录认证。
	  	'AUTH_GROUP' => '', //用户组数据表名
	  	'AUTH_GROUP_ACCESS' => '', //用户组明细表
	  	'AUTH_RULE' => '', //权限规则表
	  	'AUTH_USER' => ''//用户信息表
	),
	'SESSION_OPTIONS'=>array(
    	'name'=>'session_id'
    ),
    'WX'=> array(
    	'APPID' => '',
    	'APPSECRET' => ''
    )
);