<?php
set_time_limit(1800);
ini_set('default_socket_timeout',40);
date_default_timezone_set('PRC');
$phpFpm = 'php-fpm-5.3.29';
$dir = '/data/wwwroot/shell/';
$fileName = $dir.'www/command.txt';
$url = 'https://index.php';
if(!is_file($fileName)) {
    exec("echo '0' > {$fileName} && chmod 777 {$fileName}");
    exit;
}


$s = file_get_contents($fileName);
if( trim($s)=='1' ){
    restartPHP();
}else{
    for($i=0;$i<3;$i++){
        file_get_contents($url);
        if(strstr($http_response_header[0], '200')){
            echo 'ok';           
            break;
        }else{
            echo 'no '.$i;
            sleep(2);
            $i++;
        }
    }
    if($i>=3){
        echo 'no '.$i;
        restartPHP();
        email();
    }
}


function restartPHP(){
    global $fileName,$phpFpm,$dir;
    file_put_contents($fileName,'0');
    exec("systemctl stop {$phpFpm} && systemctl start {$phpFpm}");
    $log = date("Y-m-d H:i:s");
    file_put_contents("{$dir}/log.txt", $log."\r\n", FILE_APPEND);
}

function email(){
	global $dir;
	//引入发送邮件类
	require($dir."www/smtp.php"); 
	//使用163邮箱服务器
	$smtpserver = "smtp.exmail.qq.com";
	//163邮箱服务器端口 
	$smtpserverport = 25;
	//你的163服务器邮箱账号
	$smtpusermail = "r@.com";
	//收件人邮箱
	$smtpemailto = "xxxxxxxxxxqq.com";
	//你的邮箱账号(去掉@163.com)
	$smtpuser = "xxx@xxx.com";//SMTP服务器的用户帐号 
	//你的邮箱密码
	$smtppass = "xxxx"; //SMTP服务器的用户密码 


	//邮件主题 
	$mailsubject = "测试邮件发送";
	//邮件内容 
	$mailbody = "PHP+MySQL";
	//邮件格式（HTML/TXT）,TXT为文本邮件 
	$mailtype = "TXT";
	//这里面的一个true是表示使用身份验证,否则不使用身份验证. 
	$smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);
	//是否显示发送的调试信息 
	$smtp->debug = false;
	//发送邮件
	$smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype); 
}
