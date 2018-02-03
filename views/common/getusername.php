<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $systemsetting = Ebh::app()->room->getSystemSetting(); ?>
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<title><?= $room['crname'] ?></title>
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
	float:left;
}
.recest .inquiry {
	width:930px;
	height:480px;
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
	height:418px;
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
.kstgfd {
	width:960px;
	margin:0 auto;
}
.toptem {
	height:auto;
}
.toptem .rigkic {width:800px;}
.toptem .rigkic .dianhua {width:580px;overflow: hidden;background:url(http://static.ebanhui.com/ebh/citytpl/stores/images/dzumico0626.jpg) no-repeat 0 10px;word-wrap: break-word;}
.toptem .rigkic .elanbn {width:180px;background:url(http://static.ebanhui.com/ebh/citytpl/stores/images/homepage.jpg) no-repeat 0 10px;}
.toptem .rigkic .deteme {width:780px;background:url(http://static.ebanhui.com/ebh/citytpl/stores/images/tadaico0626.jpg) no-repeat 0 10px;}
</style>
<?php $this->display('common/public_header'); ?>
<?php $logo = empty($room['cface']) ? 'http://static.ebanhui.com/ebh/tpl/default/images/elist_tx.jpg' : $room['cface']; ?>
<?php
if(preg_match('/^[a-zA-Z0-9_\-]{1,}@[a-zA-Z0-9_\-]{1,}\.[a-zA-Z0-9_\-.]{1,}$/',$room['cremail'])){
	$pre = 'mailto:';
}elseif(substr($room['cremail'],0,7)!='http://'){
	$pre = 'http://';
}else{
	$pre = '';
}
?>
<div class="kstgfd">
<div class="toptem">
    <div class="keaie"><a href="/"><img width="100" height="100" src="<?= $logo ?>" alt="<?= $room['crname'] ?>"/></a></div>
    <div class="rigkic">
        <a href="/"><h2 class="kichtwo"><?= $room['crname'] ?></h2></a>
		 <p class="elanbn"><?php if (!empty($room['cremail'])) { ?><a href="<?= $pre.$room['cremail'] ?>" target="_blank" style="color:#2aa0e6;"><?= $room['cremail'] ?></a><?php } ?></p>
        <p class="dianhua"><?= $room['crphone'] ?></p>

        <p class="deteme"><?= $room['craddress'] ?></p>
    </div>
</div>
<div class="recest">
<div class="inquiry">
<div class="titinquiry"></div>
<div class="titcustom"></div>
	<div class="lefinq">
          <div style="float:left;margin-top: 12px;font-size:14px;text-align: center;width:678px;"><span style="color:red;font-weight:bold;">注：</span>如果你已经取得账号并且修改过密码，那么用你的账号及你的密码 <a href="/" style="text-decoration:underline;color:red;font-weight:bold;">登录</a> 或者 <a href="/forget.html" style="text-decoration:underline;color:red;font-weight:bold;">取回密码</a></div>                      
            <div class="neidi" style="margin-top:15px;">
                <span class="elxian">所在学校：</span>
				
				<select class="ertyu" id="crname" onchange="hided()" style="font-size:24px;width:305px;">
					<?php
					foreach($crlist as $classroom){
					?>
					<option value="<?=$classroom['crname']?>"><?=$classroom['crname']?></option>
					<?php
					}
					?>
				</select>
				<span class="zbdsa">请选择您的学校</span>
				
            </div>
			
            <div class="neidi">
                
			</div>
			
                <div class="neidi">
                    <span class="elxian">姓 名：</span><input class="ertyu" id="realname" type="text"  style="font-size:18px;font-weight:bold;color:red" onchange="hided()"/><span class="zbdsa">请输入真实姓名</span>
                </div>
                <a href="javascript:void(0)" onclick="_search()" class="chabtn">查 询</a>
								
                <div class="cuowu" style="display:none;">
                    <p class="tishiico">错误信息！</p>
                    <p>没有您的账户信息或查询失败，请核对学校，姓名是否正确。</p>
                    <p>如仍然查询失败请联系客服。</p>
                </div>
				
		<div class="zhengque" style="display:none;">
		<p class="chenggbtn">查询成功！</p>
		<?php
		$defaultpass = '123456';
		/*
		if($room['domain'] == 'sxyz') {
			$defaultpass = '20140909';
		} else if($room['domain'] == 'rqzx') {
			$defaultpass = '20140913';
		} else if($room['domain'] == 'jsez') {
			$defaultpass = '20140930';
		} else if($room['domain'] == 'nhgj') {
			$defaultpass = '20140913';
		} else if($room['domain'] == 'cczx') {
			$defaultpass = '20141030';
		} else if($room['domain'] == 'crzzx') {
			$defaultpass = '20141031';
		} else if($room['domain'] == 'sy') {
			$defaultpass = '20140707';
		} else if($room['domain'] == 'sykt') {
			$defaultpass = '20140707';
		}*/
		if(!empty($roomdetail['defaultpass']))
			$defaultpass = $roomdetail['defaultpass'];
		?>
		<div style=""><p style="float:left"><span id="rn" style="color:red;font-size:14px;"></span> 同学您好，您的账号为:<span class="sizya" id="username"></span></p><a id="logbtn" href="" class="huangbtn">立即登录</a></div>
		<p style="width:500px;float:left">请牢记此账号用于登录学习，<span id="default">默认</span>密码  <span id="password" style="color:red;font-size:30px;"><?= $defaultpass ?></span>  。登录后请及时修改密码。</p>
		<p style="width:500px;float:left"><span style="color:red;font-size:25px;font-weight:bold">登录成功后请回到网校首页选课报名。</span></p>
		</div>

	</div>
<div class="rigyus">
<ul>
<?php if($room['domain'] == 'anhui') { ?>
<li class="dianhua">电话：0556-5358377</li>
<li style="margin:0px; text-indent:81px;">5275114</li>
<li class="youxiang">邮箱：543349578@qq.com</li>
<li class="linkqq"><span style="float:left;width:35px;text-align:right;">Q Q：</span><a style="float:left;margin-right:5px;" href="http://wpa.qq.com/msgrd?v=3&uin=543349578&site=qq&menu=yes" target="_blank"><img src="http://static.ebanhui.com/ebh/tpl/default/images/linkqq.jpg" /></a></li>
<?php } else { ?>
<li class="dianhua">电话：0571-88252183</li>
<li style="margin:0px; text-indent:81px;">88252153</li>
<li class="youxiang">邮箱：ebanhui@qq.com</li>
<li class="linkqq"><span style="float:left;width:35px;text-align:right;">Q Q：</span><a style="float:left;margin-right:5px;" href="http://wpa.qq.com/msgrd?v=3&uin=6488479&site=qq&menu=yes" target="_blank"><img src="http://static.ebanhui.com/ebh/tpl/default/images/linkqq.jpg" /></a>
<a style="float:left;" href="http://wpa.qq.com/msgrd?v=3&uin=15335667&site=qq&menu=yes" target="_blank"><img src="http://static.ebanhui.com/ebh/tpl/default/images/linkqq.jpg" /></a></li>
<?php } ?>
</ul>
</div>

</div>
</div>
</div>
    <div style="clear:both;"></div>
	<script>
		function _search(){
			var crname = $('#crname').val();
			var realname = $('#realname').val();
			// var sex = $('input[name="sex"]:checked').val();
			var defaultpass = '<?=$defaultpass?>';
			$.ajax({
				url:'/getusername.html',
				type:'post',
				data:{'crname':crname,'realname':realname},
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
						if(res.password){
							$('#default').hide();
							$('#password').html(res.password);
						}
						else{
							$('#default').show();
							$('#password').html(defaultpass);
						}
						$('#logbtn').attr('href','login.html?returnurl=/&un='+res.username+'&sharp=subject');
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