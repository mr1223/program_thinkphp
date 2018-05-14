<?php
return array(
	//'配置项'=>'配置值'
	/* 模板相关配置 */
    'TMPL_PARSE_STRING' => array(
        '__STATIC__' => __ROOT__ . '/Public/Static',
        '__IMG__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/Images',
        '__IMGS__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/img',
        '__CSS__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/Css',
        '__JS__'     => __ROOT__ . '/Public/' . MODULE_NAME . '/Js',
        
    ),
    'MAIL_HOST' =>'smtp.163.com',//smtp服务器的名称
	'MAIL_SMTPAUTH' =>TRUE, //启用smtp认证
	'MAIL_USERNAME' =>'panjun_1@163.com',//发件人的邮箱名
	'MAIL_PASSWORD' =>'rputt123',//163邮箱发件人授权密码
	'MAIL_FROM' =>'panjun_1@163.com',//发件人邮箱地址
	'MAIL_FROMNAME'=>'俊',//发件人姓名
	'MAIL_CHARSET' =>'utf-8',//设置邮件编码
	'MAIL_ISHTML' =>TRUE, // 是否HTML格式邮件
    
);