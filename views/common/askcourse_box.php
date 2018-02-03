<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/dayi.css" rel="stylesheet" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css" type="text/css" rel="stylesheet">
<link href="http://static.ebanhui.com/ebh/tpl/default/css/zzys.css?v=20141202" type="text/css" rel="stylesheet">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
<style>
.lefkty em{
	line-height:28px;
}
</style>

</head>

<body>
<form id="askcourse" name="askcourse" action="/askcourse.html" method="post" onsubmit="return CheckPost();">
<div class="alaku outlei" style="width:605px;top:23px; overflow-x: hidden;">
	
<?php if($user['groupid'] != 5){ ?><!--10420学生-->
	<div class="titket" style="width:605px;border-bottom:none;">
		<div class="leftke">我的课程：</div>
			<div class="riglei" style="width:605px;">
			<ul>
			<?php if(in_array($roominfo['crid'], $_SMS['crids'])){ ?>
				<?php if($myfolders){foreach($myfolders as $myfolder){?>
				<li class="etkly" style="cursor:pointer"><a class="atfwt auttds" tname="<?= $myfolder['tid_realname']?>" tid="<?=empty($myfolder['tid'])?0:$myfolder['tid']?>" fid=<?=$myfolder['folderid']?>><?=$myfolder['foldername']?></a></li>
				<?php }}?>
			<?php }else{ ?>
				<?php if($myfolders){foreach($myfolders as $myfolder){?>
				<li class="etkly" style="cursor:pointer"><a class="atfwt auttds" fid=<?=$myfolder['folderid']?>><?=$myfolder['foldername']?></a></li>
				<?php }}?>
			<?php } ?>
			</ul>
			</div>
	</div>
	<?php if($otherfolders){ ?>
	<div class="ewtlt" style="width:605px;border-bottom:none;">
		<div class="leftke">其他课程：</div>
			<div class="riglei" style="width:605px;">
			<ul>
			<?php if(in_array($roominfo['crid'], $_SMS['crids'])){ ?>
				<?php foreach($otherfolders as $key=>$otherfolder){ ?>
						<li class="etkly" style="cursor:pointer"><a class="atfwt auttds"  tname="<?= $otherfolder['realname']?>" tid="<?=$otherfolder['tid']?>" fid=<?=$key?>><?=$otherfolder['foldername']?></a></li>
				<?php }?>
			<?php }else{ ?>
				<?php foreach($otherfolders as $key=>$otherfolder){ ?>
					<li class="etkly" style="cursor:pointer"><a class="atfwt auttds" fid=<?=$key?>><?=$otherfolder['foldername']?></a></li>
				<?php }?>
			<?php } ?>
			</ul>
			</div>
	</div>
	<?php } ?>
<?php }else{ ?>
	<div class="titket" style="width:605px;border-bottom:none;">
		<div class="leftke">我的课程：</div>
			<div class="riglei" style="width:605px;">
			<ul>
			<?php if($myfolders){foreach($myfolders as $myfolder){?>
			<li class="etkly" style="cursor:pointer"><a class="atfwt auttds" fid=<?=$myfolder['folderid']?>><?=$myfolder['foldername']?></a></li>
			<?php }}?>
			</ul>
			</div>
	</div>
	<?php if($otherfolders){ ?>
	<div class="ewtlt" style="width:605px;border-bottom:none;">
		<div class="leftke">其他课程：</div>
			<div class="riglei" style="width:605px;">
			<ul>
			<?php foreach($otherfolders as $key=>$otherfolder){ ?>
			<li class="etkly" style="cursor:pointer"><a class="atfwt auttds" fid=<?=$key?>><?=$otherfolder['foldername']?></a></li>
			<?php }?>
			</ul>
			</div>
	</div>
	<?php } ?>
<?php } ?>
</div>
<div class="fotjiao" style="display:none"></div>
</form>
</body>

<script>
$(function(){
	$(".atfwt").click(function(){
		var foldername = $(this).html();
		var folderid = $(this).attr('fid');
		var tid = $(this).attr('tid');
		var tname = $(this).attr('tname');
		window.parent.document.getElementById("show_foldername").innerHTML=foldername;
		window.parent.document.getElementById("folderid").value=folderid;
		if(tid!=null){
			window.parent.document.getElementById("tid").value=tid;
		}
		if(tname!=null){
			window.parent.document.getElementById("show_terchername").innerHTML=tname;
		}
		window.parent.closecourese();
	});
})
</script>
</html>
