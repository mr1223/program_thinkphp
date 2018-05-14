<?php
	function sendMail($to, $title, $content) {
     
        Vendor('PHPMailer.PHPMailerAutoload');     
        $mail = new \PHPMailer(); //实例化
        $mail->IsSMTP(); // 启用SMTP
        $mail->Host=C('MAIL_HOST'); //smtp服务器的名称（这里以QQ邮箱为例）
        $mail->SMTPAuth = C('MAIL_SMTPAUTH'); //启用smtp认证
        $mail->Username = C('MAIL_USERNAME'); //你的邮箱名
        $mail->Password = C('MAIL_PASSWORD') ; //邮箱密码
        $mail->From = C('MAIL_FROM'); //发件人地址（也就是你的邮箱地址）
        $mail->FromName = C('MAIL_FROMNAME'); //发件人姓名
        $mail->AddAddress($to,"尊敬的客户");
        $mail->WordWrap = 50; //设置每行字符长度
        $mail->IsHTML(C('MAIL_ISHTML')); // 是否HTML格式邮件
        $mail->CharSet=C('MAIL_CHARSET'); //设置邮件编码
        $mail->Subject =$title; //邮件主题
        $mail->Body = $content; //邮件内容
        $mail->AltBody = "这是一个纯文本的身体在非营利的HTML电子邮件客户端"; //邮件正文不支持HTML的备用显示
        return($mail->Send());
    }
    
    /** 
	 * 发送HTTP请求方法 
	 * @param  string $url    请求URL 
	 * @param  array  $params 请求参数 
	 * @param  string $method 请求方法GET/POST 
	 * @return array  $data   响应数据 
	 */  
	function getWxhttp($url, $params, $method = 'GET', $header = array(), $multi = false){  
	    
	    $opts = array(  
            CURLOPT_TIMEOUT        => 30,  
            CURLOPT_RETURNTRANSFER => 1,  
            CURLOPT_SSL_VERIFYPEER => false,  
            CURLOPT_SSL_VERIFYHOST => false,  
            CURLOPT_HTTPHEADER     => $header  
	    );  
	    // 根据请求类型设置特定参数  
	    switch(strtoupper($method)){  
	        case 'GET':  
	            $opts[CURLOPT_URL] = $url . '?' . http_build_query($params);  
	            break;  
	        case 'POST':  
	            //判断是否传输文件  
	            $params = $multi ? $params : http_build_query($params);  
	            $opts[CURLOPT_URL] = $url;  
	            $opts[CURLOPT_POST] = 1;  
	            $opts[CURLOPT_POSTFIELDS] = $params;  
	            break;  
	        default:  
	            throw new Exception('不支持的请求方式！');  
	    }  
	    // 初始化并执行curl请求 
	    $ch = curl_init();  
	    curl_setopt_array($ch, $opts);  
	    $data  = curl_exec($ch);  
	    $error = curl_error($ch);  
	    curl_close($ch);  
	    if($error) throw new Exception('请求发生错误：' . $error);  
	    return  $data;
	}  
    
?>