<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport"  content="user-scalable=no">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2016/css/openlogin.css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
<title>用户登录</title>
</head>

<body>
<div class="loginbg">
	<form id="form1" method="post" name="form1" onsubmit="form_submit(); return false;">
	<input type="hidden" name="loginsubmit" value="1" />
	<div class="userdiv">
		<label>账号</label>
		<input class="userlog" name="username" type="text" id="username" value="" placeholder="请输入用户名" />
	</div>
	<div class="passdiv">
		<label>密码</label>
		<input class="passlog" name="password" type="password" id="password" value="" placeholder="请输入密码" />
	</div>
    <div class="dhsure">
        <input id="cookietime" type="checkbox" name="checkbox"  value="1" style="vertical-align: sub;width:16px;height:16px;"/>
        <label class="rybtnat" for="cookietime">下次自动登录</label>
        <div class="derase">
        	<a class="chusnr" href="/forget.html">忘记密码？</a>
        </div>
    </div>
    <input class="signbtn" value="登录" name="Submit" type="submit" />
    <div class="aerire">
    <span class="fl">用其他账号登录：</span>
        <a class="md-qq" href="/otherlogin/qq.html"></a>
        <a class="md-sina" href="/otherlogin/sina.html"></a>
        <a class="zhustr" href="/register.html">立即注册</a>
    </div>
	</form>
	<div id="mod_login_tip" class="errorLayer" style="visibility: visible; position: absolute; left: 90px; z-index: 1010; display:none;">
		<div class="login_top"></div>
		<div class="login_mid">
			<div id="mod_login_close" class="tips_close">x</div>
			<div class="conn">
				<p id="mod_login_title" class="bigtxt"></p>
			</div>
		</div>
		<div class="login_bot"></div>
	</div>
</div>
<script>
$(function() {
    $("#mod_login_close").click(function() {
        $("#mod_login_tip").fadeOut();
    });
    $(".lefad .toptu .biantu,.lefad .toptu .maitu,.lefad .bottomtu .biantu,.lefad .bottomtu .maitu,.lefad .bottomtu .biantu2,.lefad .toptu,.lefad .bottomtu ").hover(function() {
        $(this).addClass("hover-trigger");
        $(this).siblings().stop().animate({
            opacity: '0.5'
        },
        1000);
    },
    function() {
        $(this).removeClass("hover-trigger ");
        $(this).siblings().stop().animate({
            opacity: '1'
        },
        1000);
    });
});
//错误提示
function tipname_message(message, high) {
    if ($("#mod_login_tip").is(":visible")) {
        $("#mod_login_tip").animate({
            "top": high
        },
        " slow", "swing",
        function() {
            $("#mod_login_tip").fadeOut("fast",
            function() {
                $("#mod_login_title").text(message);
                $("#mod_login_tip").fadeIn("slow");
            });
        });
    } else {
        $("#mod_login_title").text(message);
        $("#mod_login_tip").css("top", high).fadeIn("slow");
    }
}
function form_submit() {
    //清空之前错误提示
    $("#mod_login_tip").fadeOut();
    if ($('#username').val() == '' || $('#username').val() == '请输入用户名') {
        tipname_message('用户名不能为空', 95);
        //alert('用户名不能为空');
        $('#username').focus();
        return;
    }
    if ($("#password").val() == '') {
        tipname_message('密码不能为空', 160);
        $('#password').focus();
        return;
    }
    var returnurl = "<?= ($this->input->get('returnurl ') == NULL) ? '' : urlencode($this->input->get('returnurl '))?>";
    var type = "<?=($this->input->get('type ')==NULL) ? '' :$this->input->get('type ') ?>";
    var url = "/slogin.html?inajax=1";
    if(returnurl) url+='&returnurl='+returnurl;
    if(type) url+='&type='+type;
    
     $.ajax({
        url: url,
        data: $("#form1").serialize(),
        type: 'POST',
        dataType: 'json',
        success: function(json) {
            if (json['code'] == 1) {
                if ((json['durl'] != undefined) && (json['durl']!='')) {
                    dosso(json['durl'], json["returnurl"]);
                } else {
                    location.href = json["returnurl"];
                }
            } else {
                tipname_message(json["message"], 95);
            }
            return false;
        }
    });
}
function dosso(durl, returnurl, callback) {
    var img = new Image();
    img.src = durl;
    $(img).appendTo("body");
    if (img.complete) { // 如果图片已经存在于浏览器缓存，直接调用回调函数
        if (returnurl != undefined && returnurl != "") {
            location.href = returnurl;
        } else if (typeof(callback) == 'function') {
            callback();
        }
        return; // 直接返回，不用再处理onload事件
    }
    img.onload = function() { //图片下载完毕时异步调用callback函数。
        if (returnurl != undefined && returnurl != "") {
            location.href = returnurl;
        } else if (typeof(callback) == 'function') {
            callback();
        }
    };
}
</script>
