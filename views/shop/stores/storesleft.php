<script type="text/javascript">
<!--
	var tologinn = function(url){
		url = url.replace('__url__',encodeURIComponent(location.href));
		location.href=url;
		}
//-->
</script>
<div class="mass">
<div class="lefku">
<div class="leftop">
<div class="toptuku">
<div class="waiku">
<?php $logo=empty($room['cface'])?'http://static.ebanhui.com/ebh/tpl/default/images/elist_tx.jpg':$room['cface']?>
<img src="<?= $logo?>" width="100" height="100" />
</div>
<h3 class="hei20"><?= $room['crname']?></h3>
<ul class="user_atten clearfix user_atten_l" style="margin-left:18px;">
  <?php 
	  $classroomlib = EBH::app()->lib('Classroom');
	  $classvalue = $classroomlib -> getClassroomdetail();
?>

    <li class="S_line2" ><a href="<?= geturl('studyline')?>" style="text-decoration:none;"><strong node-type="follow"><?= $classvalue['coursenum']?></strong>课件数</a></li>
<?php 
  $examlib = EBH::app()->lib('Exam');
  $examcount = $examlib -> getexamcount($room['crid']);
?>

    <li class="S_line2" ><strong node-type="fans"><?= $examcount?></strong>作业数</li>
<li class="W_no_border" ><strong node-type="weibo"><?= $classvalue['onlinecount']?></strong><span>直播数</span></li>
</ul>
</div>
<?php if(empty($user)){?>
	<div class="btnbg">
	<a class="zhucbtn" href="<?= geturl('register')?>">注册</a>
	<?php $reurl="javascript:tologinn('".'/login.html?returnurl=__url__'."');"?>
	<a style="margin-left:1px;" class="denglbtn" href="<?= $reurl?>">登录</a>
	</div>
<?php }else{ ?>
	 <?php if($user['groupid'] == 6){ ?>
	<input style="background: url('http://static.ebanhui.com/ebh/citytpl/stores/images/gerenzhongxin1.png') no-repeat scroll 0 0 transparent;border: medium none;
    cursor: pointer;
    height: 35px;
    margin-left: 60px;
    margin-top: 11px;
    width: 124px;" type="button" name="button" value="" onclick="window.open('<?= geturl('member/setting/profile')?>')"/>
	<?php } else { ?>
	<input style="background: url('http://static.ebanhui.com/ebh/citytpl/stores/images/gerenzhongxin1.png') no-repeat scroll 0 0 transparent;border: medium none;
    cursor: pointer;
    height: 35px;
    margin-left: 60px;
    margin-top: 11px;
    width: 124px;" type="submit" name="Submit" value="" onclick="window.location.href='<?= geturl('troom.html')?>'" />
	<?php } ?>
<?php } ?>
</div>
<div class="lefmain">

<?php 
	  $sendlib = EBH::app()->lib('Sendinfo');
	  $send = $sendlib -> getSendinfo();
?>
<div class="lexia">
<p><span style="color:#0081cc;
font-weight:bold;">公告：</span><span style="word-wrap: break-word;" title="<?= $send['message']?>"><?= shortstr($send['message'],146)?></span>
</p>
</div>
<div class="zhongbu">
<p style="color:#0081cc;font-weight:bold;">网校信息：</p>
<p>建校时间：<?= date('Y-m-d',$room['dateline'])?></p>
</div>

 <div class="pingf" style="cursor:pointer;float:left;margin-left:40px;_margin-left:20px; border:none;margin-top:30px;" onclick="window.location.href='<?= geturl('cloudscore')?>'" >
  <span class="score"><?= sprintf("%01.1f", $classvalue['score'])?></span>
  <p><a href="#" style="cursor:pointer;"><span class="barbg"><span class="votebar" style="width:<?= round($classvalue['score'])?>0%;"></span></span></a></p>
  <p><span style="color:#f79f2a;"><?= $classvalue['viewnum']?></span>人参加评分</p>
  <p>(满分10分)</p>
  <?php 
  $reviewlib = EBH::app()->lib('Review');
  $rescourses = $reviewlib -> getcoureview();
?>
<?php if(!empty($user)){ ?>
  <p>我的评分<span class="xitbg"><span class="xitebar" style="width:<?= $rescourses['score']?>0%;"></span></span></p>
<?php }else{ ?>
	<p>我的评分<span class="xitbg"><span class="xitebar" style="width:0%;"></span></span></p>
<?php } ?>
  </div>
</div>
<div class="lefbottom"></div>
</div>