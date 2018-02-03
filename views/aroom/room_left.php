 <script type="text/javascript">

	function refresh(current){
		$(".menulist .current").removeClass("current");
		$(".extendlist .current").removeClass("current");
		$("#li"+current).addClass('current');
	}
  	
	$(function(){
		var firstchild = $(".menulist li");
		for(var i = 0; i < firstchild.length; i ++) {
			var firstid = $(firstchild[i]).attr("id");
			if(firstid == "licode")
				continue;
			firstid = firstid.substring(2);
			refresh(firstid);
			break;
		}
		$(".extendlist li").click(function(){$(".menulist .current").removeClass("current");$(this).addClass("current");});
	});

	</script>
<div class="cleft" style="min-height:720px;">
	<div class="leku"></div>
	<div class="menubox">
		<ul class="menulist">
		<li id="licode">
				<a href="<?=geturl('teacher/setting/rprofile')?>"  target="mainFrame" onclick="refresh('code');" ><i class="ui_ico codesuffix"></i>个人信息</a>	
			</li>
		<?php foreach($teachermenu as $tm){
				?>
				<li id="li<?=$tm['code']?>">
					<a href="<?=geturl('aroom/'.$tm['code'])?>"  target="mainFrame" onclick="refresh('<?=$tm['code']?>');" ><i class="ui_ico <?=$tm['code']?>suffix"></i><?=($room['crid']==10412&&$tm['code']=='course')?'校本资源库管理':$tm['name']?></a>	
				</li>
		<?php
		}?>
		</ul>
		
	</div>
	<div class="extendbox">
		<ul class="extendlist">
			<li><a href="<?=geturl('aroom/report/fcreport')?>" target="mainFrame" onclick="refresh('fcreport');"><i class="ui_ico fcreportsuffix"></i>课程课件统计</a></li>
			<li><a href="<?=geturl('aroom/report/tcreport')?>" target="mainFrame" onclick="refresh('tcreport');"><i class="ui_ico tcreportsuffix"></i>教师课件统计</a></li>
			<li><a href="<?=geturl('aroom/report/cereport')?>" target="mainFrame" onclick="refresh('cereport');"><i class="ui_ico cereportsuffix"></i>班级作业统计</a></li>
			<li><a href="<?=geturl('aroom/report/tereport')?>" target="mainFrame" onclick="refresh('tereport');"><i class="ui_ico tereportsuffix"></i>教师作业统计</a></li>
			<li><a href="<?=geturl('aroom/schcreditreport')?>" target="mainFrame" onclick="refresh('schcreditreport');"><i class="ui_ico schcreditreportsuffix"></i>学生学分统计</a></li>
			<li><a href="<?=geturl('aroom/allcourses')?>" target="mainFrame" onclick="refresh('allcourse');"><i class="ui_ico allcoursesuffix"></i>学校所有课程</a></li>
			<li><a href="<?=geturl('aroom/ateacourse')?>" target="mainFrame" onclick="refresh('ateacourse');"><i class="ui_ico ateacoursesuffix"></i>教师课件查看</a></li>
			
			<li><a href="<?=geturl('aroom/ateaexam')?>" target="mainFrame" onclick="refresh('ateaexam');"><i class="ui_ico ateaexamsuffix"></i>教师作业查看</a></li>
			<li><a href="<?=geturl('aroom/ateaask')?>" target="mainFrame" onclick="refresh('ateaask');"><i class="ui_ico ateaasksuffix"></i>教师答疑查看</a></li>
			<li><a href="<?=geturl('aroom/astulog')?>" target="mainFrame" onclick="refresh('astulog');"><i class="ui_ico astulogsuffix"></i>学生听课监察</a></li>
			<li><a href="<?=geturl('aroom/report/ssreport')?>" target="mainFrame" onclick="refresh('ssreport');"><i class="ui_ico ssreportsuffix"></i>学生学习统计</a></li>
			<li><a href="<?=geturl('aroom/astuexam')?>" target="mainFrame" onclick="refresh('astuexam');"><i class="ui_ico astuexamsuffix"></i>学生作业查看</a></li>
			<li><a href="<?=geturl('aroom/astuerrorbook')?>" target="mainFrame" onclick="refresh('astuerrorbook');"><i class="ui_ico astuerrorbooksuffix"></i>学校错题排行</a></li>
			<li><a href="<?=geturl('aroom/astunotice')?>" target="mainFrame" onclick="refresh('astunotice');"><i class="ui_ico astunoticesuffix"></i>全校师生通知</a></li>

			<li><a href="<?=geturl('aroom/review')?>" target="mainFrame" onclick="refresh('review');"><i class="ui_ico reviewssuffix"></i>评论查看</a></li>
			<li><a href="<?=geturl('aroom/survey')?>" target="mainFrame" onclick="refresh('survey');"><i class="ui_ico surveysuffix"></i>调察问卷</a></li>
		</ul>
	</div>
	<?php if($haspower == 1) { ?>
	<div class="extendbox">
		<ul class="extendlist">
			<li><a target="_blank" href="<?=geturl('troom')?>"><i class="ui_ico troomssuffix"></i>教师平台</a></li>
		</ul>
	</div>
	<?php } ?>

	<div class="extendbox">
		<ul class="extendlist">
			<li><a href="<?=geturl('aroom/datasetting')?>" target="mainFrame" onclick="refresh('review');"><i class="ui_ico reviewssuffix"></i>数据设置</a></li>
		</ul>
	</div>
	<?php if(!empty($room['cremail']) || !empty($room['crphone']) || !empty($room['crqq'])){ ?>
	<div class="touch">
		<ul>
			<?php if(!empty($room['cremail'])){ ?>
			<?php $cremail = str_replace('http://','',$room['cremail']);?>
			<li class="email"><a target="_blank;" href="http://<?= $cremail ?>" style="width:100px;word-wrap: break-word;"><?= $cremail ?></a></li>
			<?php } ?>
			<?php if(!empty($room['crphone'])){ ?>
			<li class="phone"><?=$room['crphone']?></li>
			<?php } ?>
			<?php if(!empty($room['crqq'])){ ?>
			<li class="qq"><a title="QQ联系" target="_blank;" href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?=$room['crqq']?>&amp;site=qq&amp;menu=yes"><?=$room['crqq']?></a></li>
			<?php } ?>
		</ul>
	</div>
	<?php } ?>
</div>
