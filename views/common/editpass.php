<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $room['crname'] ?>(e板会)</title>
<meta name="keywords" content="<?= $room['crlabel'] ?>" />
<meta name="description" content="<?= $room['summary'] ?>" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/common.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/citytpl/stores/css/wxind.css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>	

<style type="text/css">
.recest {
	width:960px;
	margin:0 auto;
}
.recest .inquiry {
	width:930px;
	height:450px;
	border:solid 1px #c8c8c8;
	background:#fff;
}
.inquiry .titinquiry {
	width:678px;
	height:61px;
	border-bottom:solid 2px #c8c8c8;
	float:left;
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/titpass.jpg) no-repeat left 14px;
}
.inquiry .titcustom {
	width:252px;
	height:61px;
	border-bottom:solid 2px #c8c8c8;
	float:left;
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/titcustom.jpg) no-repeat left 19px;
}
.lefinq {
	width:678px;
	height:387px;
	float:left;
	border-right:solid 1px #c8c8c8;
}
.neidi {
	height:32px;
	line-height:32px;
	float:left;
	width:678px;
	margin-bottom:10px;
}
.neidi .elxian {
	width:158px;
	text-align:right;
	float:left;
}
.ertyu {
	height:28px;
	line-height:28px;
	border:solid 1px #c8c8c8;
	width:298px;
	float:left;
	margin:0 15px;
	padding-left:5px;
}
.zbdsa {
	float:left;
	color:#a1a1a1;
}
.lefinq a.chabtn {
	width:90px;
	height:24px;
	line-height:24px;
	display:inlineblock;
	text-align:center;
	border:solid 1px #108ed4;
	background:#18a8f7;
	float:left;
	color:#fff;
	text-decoration:none;
	margin-left:175px;
	margin-top:25px;
}
.lefinq a.chabtn:hover {
	background:#108ed4;
}
.inquiry .rigyus {
	float:left;
	width:251px;
}
.rigyus li {
	float:left;
	padding-left:30px;
	margin-left:15px;
	display:inline;
	width:190px;
}
.rigyus .dianhua {
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/dianhuacontact.jpg) no-repeat left center;
	margin-top:35px;
}
.rigyus .youxiang {
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/youxiangcontact.jpg) no-repeat left center;
	margin-top:20px;
}
.rigyus .linkqq {
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/qqcontact.jpg) no-repeat left center;
	margin-top:25px;
	width:200px;
}
.lefinq .cuowu {
	background:#fcfcfc;
	height:80px;
	width:578px;
	float:left;
	margin-top:50px;
	padding-left:100px;
}
.cuowu p {
	line-height:1.8;
}
.cuowu .tishiico {
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/cuowuico.jpg) no-repeat left center;
	padding-left:20px;
	margin:5px 0;
}
.zhengque {
	width:578px;
	float:left;
	margin-top:35px;
	padding-left:100px;
}
.zhengque .chenggbtn {
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/zhengqueico.jpg) no-repeat left center;
	padding-left:20px;
	margin:5px 0;
}
.zhengque .sizya {
	font-size:30px;
	color:#0995df;
	font-family:微软雅黑;
}
.newspass {
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/tiicoti.jpg) no-repeat left center;
	padding-left:30px;
	margin-top:35px;
	margin-bottom:5px;
	font-size:16px;
	font-weight:bold;
	margin-left:100px;
}
.laoji {
	color:#0e9500;
	font-size:16px;
	font-weight:bold;
	margin-left:130px;
}
</style>
<?php $this->display('common/public_header'); ?>
<?php $logo = empty($room['cface']) ? 'http://static.ebanhui.com/ebh/tpl/default/images/elist_tx.jpg' : $room['cface']; ?>
<div class="toptem">
    <div class="keaie"><img width="100" height="100" src="<?= $logo ?>" alt="<?= $room['crname'] ?>"/></div>
    <div class="rigkic">
        <h2 class="kichtwo"><?= $room['crname'] ?></h2>
        <p class="dianhua"><?= $room['crphone'] ?></p>
        <p class="elanbn"><?php if (!empty($room['cremail'])) { ?><a href="http://<?= $room['cremail'] ?>" target="_blank" style="color:#2aa0e6;"><?= $room['cremail'] ?></a><?php } ?></p>
        <p class="deteme"><?= $room['craddress'] ?></p>
    </div>
</div>
<div class="recest">
<div class="inquiry">
<div class="titinquiry"></div>
<div class="titcustom"></div>
	<div class="lefinq">
        
            <div class="newspass"><?=$user['username']?>　您好，系统检测到您的账户密码过于<span style="color:red;">简单</span>
</div><span class="laoji">请修改密码后进入！请牢记您的新密码。</span>
			<div class="neidi" style="margin-top:30px;margin-bottom:5px;">
                <span class="elxian">新密码：</span><input class="ertyu" id="password" type="password" maxlength="18" onblur="checkpass()"/>
				<span class="passwordtip" style="display:none;color:red;">请确保密码在6-18位</span>
            </div>
				<p style="float:left;margin-left:175px;color:#a1a1a1;display:inline;">密码长度为6-18位，建议英文和数字组合。</p>
				
			<div class="neidi">
				<span class="elxian">确认新密码：</span><input class="ertyu" id="confirmpass" type="password" maxlength="18" onblur="checkpass()"/>
				<span class="confirmtip" style="display:none;color:red;">两次密码输入不一样</span>
            </div>
                <div><a href="javascript:void(0)" onclick="editpass()" class="chabtn">确 定</a></div>
		
                
				
		<div class="zhengque" style="display:none;">
		<p class="chenggbtn">查询成功！</p>
		<p><span id="rn"></span>同学您好，您的账号为:<span class="sizya" id="username"></span></p>
		<p>请牢记此账号用于登录学习，默认密码在告家长书中。登录后请及时修改密码。</p>
		</div>

	</div>
<div class="rigyus">
<ul>
<li class="dianhua">电话：0571-88252183</li>
<li style="margin:0px; text-indent:81px;">88252153</li>
<li class="youxiang">邮箱：ebanhui@qq.com</li>
<li class="linkqq">Q Q：<a href="http://wpa.qq.com/msgrd?v=3&uin=15335667&site=qq&menu=yes" target="_blank"><img src="http://static.ebanhui.com/ebh/tpl/default/images/linkqq.jpg" /></a><a style="margin-left:8px;" href="http://wpa.qq.com/msgrd?v=3&uin=6488479&site=qq&menu=yes" target="_blank"><img src="http://static.ebanhui.com/ebh/tpl/default/images/linkqq.jpg" /></a></li>
</ul>
</div>

</div>
</div>

    <div style="clear:both;"></div>
	<script>
		function checkpass(){
			var password = $('#password').val();
			var confirmpass = $('#confirmpass').val();
			if(password.length<6 || password.length>18){
				$('.passwordtip').show();
				return false;
			}
			else{
				$('.passwordtip').hide();
			}
			if(password != confirmpass){
				$('.confirmtip').show();
				return false;
			}else{
				$('.confirmtip').hide();
				return true;
			}
		}
		function editpass(){
			var password = $('#password').val();
			if(!checkpass())
				return ;
			$.ajax({
				url:'/editpass.html',
				type:'post',
				data:{'password':password},
				success:function(data){
					alert('密码修改成功,重新登录');
					location.href = '/';
				}
			});
		}
	</script>
    <?php
    $this->display('common/footer');
    ?>