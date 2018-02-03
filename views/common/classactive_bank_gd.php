<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>银行转账</title>
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
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/titinquiry.jpg) no-repeat left 14px;
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
	height:34px;
	line-height:34px;
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
	width:200px;
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
.lefinq a.huangbtn ,.lefrig input.huangbtn{width:87px;height:32px;line-height:32px;display:block;background:#f39800;color:#fff;font-weight:bold;font-size:14px;text-align:center;text-decoration: none;float:left;border:none;cursor: pointer;margin-left:10px;margin-top:8px;}
.lefinq a.huangbtn:hover ,.lefrig input.huangbtn:hover{background:#e48f01;text-decoration: none;}
.tishit {
	margin:60px 0 20px 30px;
	font-weight:bold;
	font-size:14px;
}
.redhao {
	color:red;
	font-size:24px;
	font-weight:bold;
	margin-left:30px;
}
.huname {
	margin:12px 0 20px 30px;
	font-size:16px;
}
.tipip {
	font-size:14px;
	margin-left:30px;
	line-height:1.8;
}
.titinquirybank{
	width:678px;
	height:61px;
	border-bottom:solid 2px #c8c8c8;
	float:left;
	background:url(http://static.ebanhui.com/ebh/images/active_bank.jpg) no-repeat left 14px;
}
</style>
<?php $this->display('common/public_header'); ?>
<?php $logo = empty($room['cface']) ? 'http://static.ebanhui.com/ebh/tpl/default/images/elist_tx.jpg' : $room['cface']; ?>
<div class="toptem">
    <div class="keaie"><a href="/"><img width="100" height="100" src="<?= $logo ?>" alt="<?= $room['crname'] ?>"/></a></div>
    <div class="rigkic">
        <a href="/"><h2 class="kichtwo"><?= $room['crname'] ?></h2></a>
        <p class="dianhua"><?= $room['crphone'] ?></p>
        <p class="elanbn"><?php if (!empty($room['cremail'])) { $homeurl = stripos($room['cremail'],'http://') !== FALSE ?  $room['cremail'] : 'http://'.$room['cremail'];?><a href="<?= $homeurl ?>" target="_blank" style="color:#2aa0e6;"><?= $homeurl ?></a><?php } ?></p>
        <p class="deteme"><?= $room['craddress'] ?></p>
    </div>
</div>
<div class="recest">
<div class="inquiry">

<div class="titinquirybank"></div>
<div class="titcustom"></div>

	

	<div class="lefinq">
      <h3 class="tishit">您好，您可以转账到以下账号开通课程：</h3>
		<p class="redhao">账号：6217 7883 0670 0492 922 </p>
		<p class="huname">账户名：黄俊  开户行：安徽广德农村商业银行横山路支行</p>
		<p class="tipip">转账成功后，请妥善保留缴费小票的凭证，并及时将您的网校登录账号，姓名，要开通的课程通过短信发送至本班班主任登记（短信内容：我是**班***，网校账号***，参加在线课堂**科学习，汇款**元，汇款单号*****），有疑问可拨打客服电话。</p>
	</div>

<div class="rigyus">
<ul>
<li class="dianhua">电话：400-116-9116</li>
<li style="margin:0px; text-indent:52px;">13955351760</li>
<li class="youxiang">邮箱：709968237@qq.com</li>
<li class="linkqq"><span style="float:left;width:35px;text-align:right;">Q Q：</span><a style="float:left;margin-right:5px;" href="http://wpa.qq.com/msgrd?v=3&uin=709968237&site=qq&menu=yes" target="_blank"><img src="http://static.ebanhui.com/ebh/tpl/default/images/linkqq.jpg" /></li>
</ul>
</div>
</div>
</div>

    <div style="clear:both;"></div>
	<script>
		function _search(){ 
			var crname = $('#crname').val();
			var realname = $('#realname').val();
			var sex = $('input[name="sex"]:checked').val();
			
			$.ajax({
				url:'/getusername.html',
				type:'post',
				data:{'crname':crname,'realname':realname,'sex':sex},
				success:function(data){
					if(data == 0){
						$('.zhengque').css('display','none');
						$('.cuowu').css('display','block');
					}else{
						res = eval('('+(data)+')');
						$('.cuowu').css('display','none');
						$('.zhengque').css('display','block');
						$('#username').html(res.username);
						$('#rn').html(res.realname);
						$('#logbtn').attr('href','login.html?returnurl=/member.html&un='+res.username);
					}
				}
			});
		}
		function hided(){
			$('.zhengque').css('display','none');
			$('.cuowu').css('display','none');
		}
	</script>
    <?php
    $this->display('common/footer');
    ?>