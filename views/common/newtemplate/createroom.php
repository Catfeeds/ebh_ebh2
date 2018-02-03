<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>网校注册</title>
		<link href="http://static.ebanhui.com/portal/css/ebtert.css?v=2016092601" type="text/css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css">
		<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/newreg/css/reg.css">
		<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js"></script>

	</head>
	<style>
	.enterprise,.crname_msg,.domain_msg,.name_msg,.mobile_msg,.password_msg,.verify_msg,.read_msg,.istered{
		display:none
	}
	#fixsendHtml{
		font-size: 18px;
		font-weight: bold;
		color: #444;
	}
	#fixsendHtml p,#fixsendHtml p span{
		float: left;
	}
	#fixsendHtml p{
		height:36px;
		line-height: 36px;
	}
	</style>
	<body>
		<div class="backs">
			<div class="register">
				<div class="tongtit">
					<span class="fl">网校注册</span>
					<div class="netsacc">
						<a href="javascript:;" class="netschool curs" roomtype="education">网校版</a>
						<a href="javascript:;" class="netschools" roomtype="enterprise">企业版</a>
					</div>
				</div>
				<form id="createform" method="post">
				<div class="regacc">
					<div class="clear"></div>
					<div class="showno">
						<div class="diffblocks education isterdiv">
							<span class="isterspan">网校名称</span>
							<input class="istertxts" id="crname" needcheck="1" placeholder="例如：杭州市学军小学" value="" name="crname" type="text">
							<p id="" class="crname_msg zhengtic"></p>
							<p id="" class="crname_msg cuotic cuotic0">名称不能为空 </p>
							<p id="" class="crname_msg cuotic cuotic1">网校已经存在，请换个网校名字</p>
						</div>
						<div class="diffblocks education isterdiv">
							<span class="isterspan">网校域名</span>
							<div class="kdswaiy" style="padding:0px">
								<span class="kdtnfes">http://</span>
								<input class="school istertxts" id="domain" needcheck="1" placeholder="例如：hzxjxx" value="" name="domain" type="text">
								<span class="kdtnfes">.ebh.net</span>
							</div>
							<p id="" class="domain_msg zhengtic"></p>
							<p id="" class="domain_msg cuotic cuotic0">域名必须由5-12位字母组成 </p>
							<p id="" class="domain_msg cuotic cuotic1">域名已存在</p>
						</div>
						
						<div class="diffblocks enterprise isterdiv">
							<span class="isterspan">企业名称</span>
							<input class="istertxts" id="crname" needcheck="1" placeholder="例如：山东一诺集团" value="" name="crname" type="text">
							<p id="" class="crname_msg zhengtic"></p>
							<p id="" class="crname_msg cuotic cuotic0">名称不能为空 </p>
							<p id="" class="crname_msg cuotic cuotic1">网校已经存在，请换个网校名字</p>
						</div>
						<div class="diffblocks enterprise isterdiv">
							<span class="isterspan">企业域名</span>
							<div class="kdswaiy" style="padding:0px">
								<span class="kdtnfes">http://</span>
								<input class="school istertxts" id="domain" needcheck="1" placeholder="例如：sdynjt" value="" name="domain" type="text">
								<span class="kdtnfes">.ebh.net</span>
							</div>
							<p id="" class="domain_msg zhengtic"></p>
							<p id="" class="domain_msg cuotic cuotic0">域名必须由5-12位字母组成 </p>
							<p id="" class="domain_msg cuotic cuotic1">域名已存在</p>
						</div>
						
						<div class="isterdiv">
							<span class="isterspan">姓名</span>
							<input class="istertxts" id="realname" needcheck="1" placeholder="与身份证姓名一致" value="" name="realname" type="text">
							<p id="" class="name_msg cuotic zhengtic"></p>
							<p id="" class="name_msg cuotic cuotic0">姓名不能为空</p>
							<p id="" class="name_msg cuotic cuotic1">姓名不符合规范</p>
						</div>
						<div class="isterdiv">
							<span class="isterspan">手机号码</span>
							<input class="istertxts" id="mobile" needcheck="1" placeholder="手机号即为管理员号" value="" name="mobile" type="text">
							<p id="" class="mobile_msg zhengtic"></p>
							<p id="" class="mobile_msg cuotic cuotic0">手机号码填写不正确 </p>
							<p id="" class="mobile_msg cuotics cuotic1"></p>
						</div>
						<div class="isterdiv">
							<span class="isterspan">登录密码</span>
							<input class="istertxts" id="password" needcheck="1" placeholder="该密码为网校登录密码" value="" name="password" type="text">
							<p id="" class="password_msg zhengtic"></p>
							<p id="" class="password_msg cuotic cuotic0">请输入用户密码</p>
							<p id="" class="password_msg cuotic cuotic1">6-16个字符，区分大小写</p>
						</div>
						<div class="isterdiv">
							<span class="isterspan">验&nbsp;&nbsp;证&nbsp;&nbsp;码</span>
							<input class="yantess istertxts" id="verify" needcheck="1" title="请输入验证码" placeholder="请输入验证码" value="" name="smscode" type="text">
							<a id="getcode" class="sendyzms ml35" href="javascript:;" onclick="getcode()">获取短信验证</a>
							<a class="istered" style="" href="javascript:void(0)" onclick="fixsend()">收不到短信单击这里</a>
							<p id="" class="verify_msg zhengtics"></p>
							<p id="" class="verify_msg cuotic cuotic0">请输入验证码</p>
							<p id="" class="verify_msg cuotics cuotic1">请先填写正确的信息，只有信息全部校验通过才能获取验证码</p>
							<p id="" class="verify_msg cuotics cuotic2"></p>
						</div>
						<div class="clear"></div>
						<div class="yuecrse">
							<a class="croose yuecroose" id="readpaper" href="javascript:;">我已阅读，并同意。</a>
							<input type="hidden" id="read" value="1" needcheck="1"/>
							<a class="linkwen" target="_blank" href="/intro/schagreement.html">创建网校服务协议</a>
							<p id="" class="read_msg zhengtic">	</p>
							<p id="" class="read_msg cuotic">同意创建网校协议未勾选</p>
						</div>
						<div class="clear"></div>					
						<div class="mt15">
							<input class="logbtn" value="创建网校" type="button" onclick="docreate()">
						</div>
					</div>
					
				</div>
				</form>
			</div>
			<?php $this->display('common/newtemplate/animation');?>
		</div>
<div id="fixsendHtml" style="display:none;width:440px;overflow:hidden;padding:40px 0px 60px 70px;">
	<p style="height:72px;overflow:hidden;clear:both;"><span>您可以尝试点击右侧　</span> <a href="javascript:void(0)" id="sendmsg2" onclick="getcode(1);" class="sendyzms" style="margin-left:40px;">获取短信验证</a> <span>重新获取短信验证码</span><br/> </p>
	<p>如您还无法收到短信，您可以联系以下电话</p>
	<p>服务热线 : 0571-88252183</p>
	<p>靳老师 : 13757168928 陈老师 : 13957170417</p>
</div>
<script type="text/javascript">
$(".netsacc a").click(function(){
	$('.curs').removeClass('curs');
	var roomtype = $(this).attr('roomtype');
	$('.diffblocks').hide();
	$('.diffblocks.'+roomtype).show();
	$(this).addClass('curs');
});
$("#readpaper").click(function(){
	$(this).toggleClass("yuecroose");
	$("#read").val(1-$("#read").val());
	checkread();
});
$('input[needcheck=1]').blur(function(){
	eval('check'+$(this).attr('id')+'()');
});
function checkread(){
	var read = $('#read').val();
	if(read == 0){
		$('.read_msg').hide();
		$('.read_msg.cuotic').css('display','inline');
		return false;
	} else {
		$('.read_msg').hide();
		$('.read_msg.zhengtic').css('display','inline');
		return true;
	}
}
function checkcrname(){
	var curblock = $('.diffblocks:visible');
	var crname = curblock.find('#crname').val();
	if(crname == ''){
		curblock.find('.crname_msg').hide();
		curblock.find('.crname_msg.cuotic0').css('display','inline');
		return false;
	} else {
		var ret = false;
		$.ajax({
			url: "/createroom/is_crname_exists.html",
			type:"post",
			dataType:"json",
			data:{crname:crname},
			async:false,
			success: function(res){
				if(res.status == 0){
					curblock.find('.crname_msg').hide();
					curblock.find('.crname_msg.zhengtic').css('display','inline');
					ret = true;
				} else {
					curblock.find('.crname_msg').hide();
					curblock.find('.crname_msg.cuotic1').css('display','inline');
					ret = false;
				}
	   	}
		});
		return ret;
	}
}
function checkdomain(){
	var curblock = $('.diffblocks:visible');
	var domain = curblock.find('#domain').val();
	var patrn= /^[A-Za-z]{5,12}$/;
	if (!patrn.exec(domain)){
		curblock.find('.domain_msg').hide();
		curblock.find('.domain_msg.cuotic0').css('display','inline');
		return false;
	}
	var ret = false;
	$.ajax({
		url: "/createroom/domain_check.html",
		type:"post",
		dataType:"json",
		data:{domain:domain},
		async:false,
		success: function(res){
			if(res.status == 0){
				curblock.find('.domain_msg').hide();
				curblock.find('.domain_msg.zhengtic').css('display','inline');
				ret = true;
			} else {
				curblock.find('.domain_msg').hide();
				curblock.find('.domain_msg.cuotic1').html(res.msg).css('display','inline');
				ret = false;
			}
		}
	});
	return ret;
}
function checkrealname(){
	var realname = $('#realname').val();
	if(realname == ''){
		$('.name_msg').hide();
		$('.name_msg.cuotic0').css('display','inline');
		return false;
	} 
	var patrn = /^[\u4E00-\u9FA5\uF900-\uFA2D]+$/;
	if (!patrn.exec(realname)){
		$('.name_msg').hide();
		$('.name_msg.cuotic1').css('display','inline');
		return false;
	} else {
		$('.name_msg').hide();
		$('.name_msg.zhengtic').css('display','inline');
		return true;
	}
}
function checkpassword(){
	var password = $('#password').val();
	if (password == '') {
		$('.password_msg').hide();
		$('.password_msg.cuotic0').css('display','inline');
		return false;
	} else if (password.length < 6 || password.length > 16 ) {
		$('.password_msg').hide();
		$('.password_msg.cuotic1').css('display','inline');
		return false;
	} else {
		$('.password_msg').hide();
		$('.password_msg.zhengtic').css('display','inline');
		return true;
	}
}
function checkmobile(){
	var mobile = $('#mobile').val();
	var patrn=/^1[3-8]{1}\d{9}$/; 
	if (!patrn.exec(mobile)){
		$('.mobile_msg').hide();
		$('.mobile_msg.cuotic0').css('display','inline');
		return false;
	}
	var ret = false;
	$.ajax({
		url: "/createroom/is_user_exists.html",
		type:"post",
		dataType:"json",
		data:{mobile:mobile},
		async:false,
		success: function(res){
			if(res.status == 0){
				$('.mobile_msg').hide();
				$('.mobile_msg.zhengtic').css('display','inline');
				ret = true;
			} else {
				$('.mobile_msg').hide();
				$('.mobile_msg.cuotic1').html(res.msg).css('display','inline');
				ret = false;
			}
		}
	});
	return ret;
}
function checkverify(){
	var verify = $('#verify').val();
	// console.log(verify);
	if(verify == ''){
		$('.verify_msg').hide();
		$('.verify_msg.cuotic0').css('display','inline');
		return false;
	}
	var ret = false;
	$.ajax({
		url: "/createroom/sms_check.html",
		type:"post",
		dataType:"json",
		data:getdata(),
		async:false,
		success: function(res){
			if(res.status == 0){
				$('.verify_msg').hide();
				$('.verify_msg.zhengtic').css('display','inline');
				ret = true;
			} else {
				$('.verify_msg').hide();
				$('.verify_msg.cuotic2').html(res.msg).css('display','inline');
				ret = false;
			}
		}
	});
	return ret;
}
function getdata(){
	var formdata = $('input[needcheck=1]:visible');
	var data = {};
	$.each(formdata,function(k,v){
		if($.trim($(v).val()) == $(v).attr('placeholder')){
			data[$(v).attr('name')] = "";
		}else{
			data[$(v).attr('name')] = $.trim($(v).val());
		}
	});
	return data;
}
function checkform(not){
	var notstr = '';
	var ret = true;
	if(not && not.length>0){
		notstr = ':not('+not+')'
	}
	$.each($('input[needcheck=1]'+notstr),function(k,v){
		if(!eval('check'+$(this).attr('id')+'()')){
			ret = false;
		}
	});
	return ret;
}
function getcode(fix){
	if(!checkform('#verify')){
		$('.verify_msg').hide();
		$('.verify_msg.cuotic1').css('display','inline');
		return false;
	}
	if(fix){
		var url = "/createroom/getcode.html?fix=1";
	}else{
		var url = "/createroom/getcode.html";
	}
	$.ajax({
		url: url,
		type:"post",
		dataType:"json",
		data:getdata(),
		async:false,
		success: function(res){
			if(res.status == 0){
				if(fix){
					fixsend_after(res);
				}else{
					countdown($("#getcode"));
					$('.verify_msg').hide();
					$('.verify_msg.zhengtic').html('短信校验码获取成功,请勿修改当前填写信息，否则校验码失效').css('display','inline');
				}
			}else{
				if(fix){
					fixsend_after(res);
				}else{
					countdown($("#getcode"));
					$('.verify_msg').hide();
					$('.verify_msg.cuotic2').html(res.msg).css('display','inline');
				}
			}
		}
	});
}
function docreate(){
	var ret = checkform();
	var curblock = $('.diffblocks:visible');
	if(curblock.hasClass('education'))
		property = 0;
	else 
		property = 3;
	var data = getdata();
	data['property'] = property;
	// console.log(data);
		if(property == 0){
			var cong = "恭喜您，您已成为校长您的网校名称为："
		}else{
			var cong = "恭喜您，您的企业已创建成功企业名称为："
		}
		if(ret){
			$.ajax({
				url: "/createroom/create.html",
				type:"post",
				dataType:"json",
				data:data,
				success: function(res){
					if(res.status != -1){
						dosso(res.attr.durl,function(){
							HTools.hShow(getDialogHtml(res.attr,cong));
						});
					}else{
						HTools.hShow('创建失败，原因是：'+res.msg,0,3000);
					}
				}
			});
		}
}
function countdown(dom,noinit){
	if(!noinit){
		dom.removeClass();
		dom.addClass('again').addClass('ml15');
		dom.attr('cnum',60);
		dom.html(dom.attr('cnum')+'秒后可重新获取');
		dom.removeAttr('onclick');
	}
	dom.html(dom.attr('cnum')-1+'秒后可重新获取');
	dom.attr('cnum',dom.attr('cnum')-1);
	if(dom.attr('cnum') == 58){
		$(".istered").show();
	}
	if(dom.attr('cnum') <= 0){
		dom.attr('onclick',"getcode()");
		dom.html('获取短信验证');
		dom.removeClass();
		dom.addClass('sendyzms').addClass('ml35');
		return;
	}
	setTimeout(function(){
		countdown(dom,true)
	},1000);
};
function fixsend(){
	H.create(new P({
		id:'fixsend',
		content:$("#fixsendHtml")[0],
		title:'收不到短信？',
		easy:true,
		padding:5
	})).exec('show');
}
function fixsend_after(res){
		$dom = $("#sendmsg2");
		$dom.unbind('click');
		$dom.attr('onclick','');
		$dom.bind('click',function(){
			alert('无法重复获取');
			return;
		});
		$dom.removeClass();
		$dom.addClass('kwrybtnji');
		if(res.status == 0){
			$dom.html("发送成功");
		}else{
			$dom.html("发送失败");
		}
}
//同步登录
function dosso(durl,callback){
	var img = new Image();
	img.src =durl;
	img.onload = function(){callback()};
}

//创建网校成功之后的弹出层
function getDialogHtml(obj,cong){
	var date1 = new Date();
        var date2 = new Date(date1);
        date2.setDate(date1.getDate()+7);
        var starttime = date1.getFullYear()+"-"+(date1.getMonth()+1)+"-"+date1.getDate();
        var endtime = date2.getFullYear()+"-"+(date2.getMonth()+1)+"-"+date2.getDate();
        
		var html = new Array();
		html.push('<div class="lsgegdr">');
		html.push('<div class="suctitle">创建成功</div>');
		html.push('<div class="kshtht">'+cong+'');
		html.push('<p class="oschoolname">'+obj.crname+'</p>');
		html.push('</div>');
		html.push('<div class="ljustd">');
		html.push('<p class="sitename">网址：http://'+obj.domain+'.ebh.net</p>');
		html.push('<span class="accpsd" style="margin-right:34px;">账号：'+obj.mobile+'</span>');
		html.push('<span class="accpsd">密码：'+obj.password+'</span>');
		html.push('</div>');
		html.push('<div class="usefullife">有效期：');
		html.push('<span>'+starttime+'</span><span>至</span><span>'+endtime+'</span>');
		html.push('</div>');
		html.push('<p class="timetip">（到期后请购买正式版继续享受服务，联系人：靳老师：</p>');
		html.push('<p class="timetip">13757168929，陈老师：13957170417）</p>');
		html.push('<a class="lstjdy" href="http://'+obj.domain+'.ebh.net/homev2.html">进入个人中心 &gt;&gt;</a>');
		html.push('</div>');
		return html.join('');
}
</script>
<?php
$this->display('common/newtemplate/footer');
?>