<?php
date_default_timezone_set('PRC');
$phpFpm = 'php-fpm-5.3.29';
$dir = '/data/wwwroot/shell/';
$fileName = $dir.'www/command.txt';
if(!is_file($fileName)) {
    exec("echo '0' > {$fileName} && chmod 777 {$fileName}");
    exit;
}
$s = file_get_contents($fileName);
if( trim($s)=='1' ){
    file_put_contents($fileName,'0');
    exec("systemctl stop {$phpFpm} && systemctl start {$phpFpm}");
    $log = date("Y-m-d H:i:s");
    file_put_contents("{$dir}/log.txt", $log."\r\n", FILE_APPEND);
}
