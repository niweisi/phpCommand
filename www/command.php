<?php
$password = '123456';
if($_POST['pass']==$password){
    if( file_put_contents('command.txt','1') ){
        echo '200';
    }else{
        echo '400';
    }
}else{
    echo '500';
}
