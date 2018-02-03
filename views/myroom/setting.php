<?php $this->display('myroom/page_header'); ?>
<body >
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/default/css/wangind.css" />
<!--[if lte IE 6]>  
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/DD_belatedPNG_0.0.7a.js"></script>  
<script type="text/javascript">  
  DD_belatedPNG.fix('.menubox ul li i,.bottom,.cservice img,.sukan .xinke span,.sukan .zuoye span,.sukan .zhibo span,.sukan .jieda span'); 
</script>  
<![endif]-->
<div class="ter_tit">
	当前位置 > 网校首页
	</div>
<div class="wangind">
	<div class="titop">

		<div class="lewaik">
		<?php 
					if($user['sex'] == 1)
						$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
					else
						$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
					$face = empty($user['face']) ? $defaulturl:$user['face'];
				?>
		<a href="<?= geturl('member/setting/avatar')?>" target="_parent"><img src="<?= $face?>"  style="width:120px;height:120px;*margin-bottom:-2px;"/></a>
		</div>
		<div class="rigxiang">
		<p class="stimmes">今天是&nbsp;<script language="JavaScript" type="text/javascript" src="http://static.ebanhui.com/ebh/js/rqjs.js"></script></p>	
    <span class="xueming"><?= $roominfo['crname'] ?></span>
	<div style="float:left;width:600px;">
		<span id="showdate" style="font-size:16px;border:none;width:65px;"></span>
	<span style="font-size:16px;"><?= $user['username'] ?></span>
	(<?= $user['realname'] ?>)<span class="xinqing" title="<?= $user['mysign'] ?>"><?php if(!empty($user['mysign'])) { ?>心情：<?= shortstr($user['mysign'],36)?><?php } ?></span>
</div>
	
			<div class="sukan">
			
				<!--在线作业-->
								<a style="text-decoration: none;" href="<?= geturl('myroom/exam')?>" id="zuoye" class="zuoye">
								</a>

				<!--所有课程,学新课-->
							<a style="text-decoration: none;" href="<?= geturl('myroom/subject') ?>" class="xinke" id="course">
							</a>
				
				<!--直播课程-->
					<?php if(!empty($stumodulelist) && in_array(780,$stumodulelist) && (FALSE)) { ?>
							<a style="text-decoration: none;" href="<?= geturl('myroom/online') ?>" class="zhibo" id="online">
							</a>
					<?php } ?>
				<!--我的答疑-->
							<a style="text-decoration: none;" href="<?= geturl('myroom/myask/myquestion') ?>" class="jieda" id="ask">
							</a>
			</div>
		</div>
	</div>
	<div class="timike">
		<h2><img src="http://static.ebanhui.com/ebh/tpl/default/images/titkecheng1016.jpg" /></h2>
		
		<ul>
		<?php foreach($courses as $ckey=>$course) { ?>

			<?php if($ckey % 3 ==2) { ?>
				<li style="border:none;">
			<?php } else { ?>
				<li>
			<?php } ?>
			<?php $arr = explode('.',$course['cwurl']);
				$type = $arr[count($arr)-1]; ?>
				<div style="height:120px;word-wrap: break-word;margin: 5px 15px 0;">
				<h3 class="tibiao"><a target="<?= (empty($course['cwurl']) || $type == 'flv') ? '_blank' : '' ?>" href="<?= geturl('myroom/mycourse/'.$course['cwid']) ?>" style="color:#106aae;" title="<?= $course['title'] ?>"><?= shortstr($course['title'],24,'...')?></a></h3>
				<p style="color:#a3a3a3;">讲师：<?= empty($course['realname'])?$course['username']:$course['realname'] ?></p>
				<p style="color:#a3a3a3;">时间：<?= date('Y-m-d',$course['dateline'])?></p>
				<?php if(!empty($course['summary'])) { ?>
					<p style="color:#575757;margin-top:6px;width:218px;height: 55px;position:absolute;"><span style="float:left;width:65px;height:20px;display:block;">课件摘要: </span><span style="float:left; text-indent: 57px;width:218px;margin-top:-20px;height:55px;"><?= shortstr($course['summary'],78)?></span></p>
				<?php } ?>
				</div>
				<a href="<?= geturl('myroom/mycourse/'.$course['cwid']) ?>" target="<?= (empty($course['cwurl']) || $type == 'flv') ? '_blank' : '' ?>" class="jinxuexi">进入学习</a>
			</li>
			
		<?php } ?>
		</ul>
		<?php if(count($courses) == 0) { ?>
			<div class="shaoke1"></div>
			<?php } else if(count($courses) == 1) { ?>
			<div class="shaoke2"></div>
			<?php } else if(count($courses) == 2) { ?>
			<div class="shaoke3"></div>
			<?php } ?>
	</div>
	<?php if(!empty($exams)) { ?>
		<div class="tiomzuo">
			<h2><img src="http://static.ebanhui.com/ebh/tpl/default/images/titzuoye1016.jpg" /></h2>
		<?php foreach($exams as $exam) { ?>
			 <ul>
				<li>
				<div class="lefzuo" >
				<p style="font-size:14px;color:#106aae;"><span style="margin-right:40px;"><a href="http://exam.ebanhui.com/do/<?= $exam['eid'] ?>.html" style="color:#106AAE;" target="_blank"><?= shortstr($exam['title'],60,'...')?></a></span>总分：<?= $exam['score']?>分</p>
				<p style="color:#a3a3a3;"><span style="margin-right:20px;"><?= empty($exam['realname'])?$exam['username']:$exam['realname']?></span><?= date('Y-m-d',$exam['dateline'])?></p>
				</div>
				<a href="http://exam.ebanhui.com/do/<?= $exam['eid'] ?>.html" class="datibtn" target="_blank">在线答题</a>
				</li>
			</ul>
		<?php } ?>
		</div>
	<?php } ?>
</div>

<script type="text/javascript">
<!--
	$("#showdate").html(tips());
	 function tips() {
		now = new Date(), hour = now.getHours()
		if (hour < 6) { return "凌晨好！"; }
            else if (hour >= 6 && hour < 9) { return ("早上好！") }
            else if (hour >= 9 && hour < 12) { return ("上午好！") }
            else if (hour >= 12 && hour < 14) { return ("中午好！") }
            else if (hour >= 14 && hour < 17) { return ("下午好！") }
            else if (hour >= 17 && hour < 19) { return ("傍晚好！") }
            else if (hour >= 19 && hour < 22) { return ("晚上好！") }
            else { return ("夜里好！") }
	 }
$(function(){
   var url = '<?= geturl('myroom/userstate')?>';
   <?php if(!empty($stumodulelist) && in_array(780,$stumodulelist)) { ?>
   var type =[1,2,780,4];
   <?php } else { ?>
	var type =[1,2,4];
   <?php } ?>
   $.ajax({
		type:'POST',
		url:url,
		data:{"type":type},
			dataType:"json",
			success:function(data) {
				if(data != undefined && data[1] != undefined && data[1] > 0) {
					var examcount = data[1] > 99 ? 99 : data[1];
					$("#zuoye").append("<span>" + examcount + "</span>");
				}
				if(data != undefined && data[2] != undefined && data[2] > 0) {
					var askcount = data[2] > 99 ? 99 : data[2];
					$("#course").append("<span>" + askcount + "</span>");
				}
				if(data != undefined && data[780] != undefined && data[780] > 0) {
					var onlinecount = data[780] > 99 ? 99 : data[780];
					$("#online").append("<span>" + onlinecount + "</span>");
				}
				if(data != undefined && data[4] != undefined && data[4] > 0) {
					var askcount = data[4] > 99 ? 99 : data[4];
					$("#ask").append("<span>" + askcount + "</span>");
				}
			}
		});
	});
	//-->
//-->
</script>
<?php $this->display('myroom/page_footer'); ?>