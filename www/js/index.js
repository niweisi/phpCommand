$(document).ready(function(){
    $("#cover").hide();
    var commandTXTurl = 'command.txt';
    var commandPHPurl = 'command.php';
    var data = {
        a:random()
    }
    if(Ajax(commandTXTurl,'error','get',data)){
            alert("服务器链接失败！");
    }
    $("#submit").click(function(){
        $("#cover").show();
        var password = $("#password").val();
        var str = Ajax(commandPHPurl,'success','post',{pass:password});
        if(str!=''){
            if(str == '200'){
                alert("重启命令发送成功！"+str);
            }else if(str == '500'){
                alert("密码输入错误！"+str);
            }else if(str == '400'){
                alert("重启命令发送失败！"+str);
            }
        }else{
            alert("服务器链接失败！");
        }
        $("#cover").hide();
    });
});
function random(){
    return Math.floor(Math.random()*9000+2);
}
function Ajax(url,state,type,data){
    var result_success = '';
    var result_error = '';
    $.ajax({
        url:url,
        type:type,
        data:data,
        cache: false,
        async: false,
        success:function(data, textStatus){
            result_success  = data;
        },
        error:function(xhr,status,statusText){
            result_error  = xhr.status;
        }
    });
    if(state=='success'){
        result = result_success;
    }else if(state=='error'){
        result = result_error;
    }

    return result;
}