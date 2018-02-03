<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$this->get_title()?></title>
<meta name="keywords" content="<?=$this->get_keywords()?>" />
<meta name="description" content="<?=$this->get_description()?>" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2016/css/openlogin.css" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery.placeholder.js"></script>
<style type="text/css">
input, textarea { color: #000; }
.placeholder { color: #aaa; }
</style>
</head>
<body>
<div style="background:url(http://static.ebanhui.com/ebh/tpl/2012/images/bg12511.jpg) repeat; height:auto;">
<div class="topebroll">
<div style="width:1000px; margin:0 auto; position:relative">
<div class="toplogo">
<a href="/"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/login511.jpg" /></a>
</div>
</div>
</div>
</div>


<div class="wcontainer" style="background: #fff;">
	<div class="wraps">
    	<div class="wheader-wrap">
        	<h1>完善基本资料</h1>
            <div class="sns-complete-tab">
                <span class="sns-tab-active xbind" id="noaccount">无帐号</span>
                <span class="xbind" id="bindaccount">绑定已有帐号</span>  
            </div>
        </div>
        <div class="cprofile-wrap">
        	<div class="avator-wrap">
				<div class="avator-inner">
					<img width="120" height="120" src="<?=!empty($ulogo)?$ulogo:"http://static.ebanhui.com/wap/images/qqtoux.jpg"?>">
				</div>
                <div class="avatorspan"><span><?=$uname?></span></div>
			</div>
            <div class="cprofile-field-wrap">
				<form id="forms" name="form" action="/otherlogin/associate.html" method="post"  autocomplete="off">
					<input type="hidden" name="create" value="1" />
					<input type="hidden" name="type" value="<?=$type?>" />
					<input type="hidden" name="openid" value="<?=$openid?>" />
					<?php if(!empty($unionid)){?>
					<input type="hidden" name="unionid" value="<?=$unionid?>" />
					<?php }?>
					<input type="hidden" name="state" value="<?=$state?>" />
					<input type="hidden" name="sex" value="<?=isset($sex)?$sex:0?>" />
					<input type="hidden" name="face" value="<?=isset($face)?$face:''?>" />
					<input type="hidden" name="nickname" value="<?=$uname?>" />
					<input type="hidden" name="token" value="<?=createToken()?>" />
				
					<div class="wlfg-wrap">
						<label class="label-name">账号</label>
						<div class="rlf-group">
							<input type="text" id="username" name="username" class="iptxs" placeholder="请输入账号"  value="" />
							<p class="tishis"><span style="display: none;" id="username_error">6~20个字符，包括字母、数字、下划线，字母开头</span></p>
						</div>
					</div>
                    <div class="wlfg-wrap">
						<label  class="label-name">密码</label>
						<div class="rlf-group">
							<input type="password" id="password" name="password" class="iptxs ipt-pwd " value="" placeholder="请输入密码" />
							<p class="tishis"><span style="display: none;" id="password_error">密码长度6~16位</span></p>
						</div>
					</div>
                    <div class="wlfg-wrap">
						<div class="rlf-group">
							<input type="button" value="完成" class="btn-complete" />
						</div>
					</div>
				</form>
			</div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(function(){
	var formcheck = false;
	//ajax同步调用
	$.ajaxSetup({async: false});
	//验证样式
	var username = $('#username').val();
	var password = $('#password').val();
	//placeholder兼容ie
	$('input, textarea').placeholder();
	
	 $(".iptxs").bind('focus',function(){
		 $(this).addClass('input-blue');
		 }).bind("blur",function(){
			 $(this).removeClass('input-blue');
			 });
	 //监控输入数据 创建账号时
	 $('#username').bind('keyup',function(e){
		// console.log(e.keyCode)
			if($('input[name=create]').val()==1){
				var ipt = $.trim($('#username').val());
				username = ipt;
			}
		 });
	 
	$(".xbind").click(function(){
		var that = $(this);
		$(".xbind").removeClass('sns-tab-active');
		$(that).addClass('sns-tab-active');
		var spid = $(that).attr('id');
		if(spid == 'bindaccount'){
			//$('#username').focus();
			$('#username').val('');
			$("input[name=create]").val('0');
		}else{
			$('#username').val(username);
			//$('#username').focus();
			$("input[name=create]").val('1');
			}
		$('#username_error').hide();
		$('#password_error').hide();
		});


	//绑定blur事件
	$(document).on('blur','input[name=username]',function(){//验证账号
		var type = $("input[name=type]").val();
		var create = $("input[name=create]").val();
		var username = $.trim($("#username").val());
		if(username=='' ||　username=='请输入账号'){
			$("#username_error").text('6~20个字符，包括字母、数字、下划线，字母开头!!!');
			$("#username_error").show();
			formcheck =  false;
			return false;
			}
		if(!username.match(/^[a-zA-Z][a-z0-9A-Z_]{5,19}$/gi)){
			$("#username_error").text('6~20个字符，包括字母、数字、下划线，字母开头!!!');
			$("#username_error").show();
			//$('#username').focus();
			formcheck =  false;
			return false;
		}
		
		$.post('/otherlogin/check.html',{type:type,create:create,username:username,ajax:1},function(json){
			if(!json.code){
				$("#username_error").text(json.msg);
				$("#username_error").show();
				formcheck =  false;
				return false;
			}else{
				formcheck =  true;
				$("#username_error").hide();
				}
			},'json');
	}).on('blur','input[name=password]',function(){//验证密码
		var password = $(this).val();
		var username = $('#username').val();
		var type = $("input[name=type]").val();
		var create = $("input[name=create]").val();

		if(password.length < 6 || password.length > 16  ){
			$('#password_error').text('密码长度6~16位');
			$('#password_error').show();
			formcheck =  false;
			return false;
		}else{
			$('#password_error').hide();
			}
		
		if(password.length==0){
			$('#password_error').text('请输入密码');
			$('#password_error').show();
			formcheck =  false;
			return false;
			}
		
		if(password.length>0 &&　username.length>0 && create==0){
			$.post('/otherlogin/check.html',{type:type,create:create,username:username,password:password,ajax:1},function(json){
				if(!json.code){
					$("#password_error").text(json.msg);
					$("#password_error").show();
					formcheck =  false;
					return false;
				}else{
					formcheck =  true;
					$("#password_error").hide();
					}
				},'json');
			}

		}).on('click','.btn-complete',function(){//表单提交
			$("input[name=username]").trigger("blur");
			$("input[name=password]").trigger("blur");
			
			if(formcheck){
				//console.log(formcheck);
				//alert(0);
				$('#forms').submit();
				}
		});
})
</script>

<?php $this->display('common/site_footer')?>