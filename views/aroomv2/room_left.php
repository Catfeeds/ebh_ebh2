  <script type="text/javascript">

	function refresh(current){
		$(".menulist .current").removeClass("current");
		$(".extendlist .current").removeClass("current");
		$("#li"+current).addClass('current');
	}
  	
	$(function(){
		$('.extendlist li:first').addClass('current');
		// if($("#lisetting").length>0){
			// refresh('mysetting');
		// }else {
			// refresh('mysetting');
		// }
		$(".extendlist li").click(function(){
			$(".extendlist .current").removeClass("current");
			$(this).addClass("current");
		});
	});

	</script>
	

<div class="cleft">
	<div class="leku"></div>
	<div class="menubox">
			<div class="stuxinx">
				<div class="leftu">
					<?php 
						if($user['sex'] == 1)
							$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
						else
							$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
						$face = empty($user['face']) ? $defaulturl:$user['face'];
						$face = str_replace('.jpg','_78_78.jpg',$face);
					?>
					<a href="<?= geturl('teacher/setting/avatar') ?>" title="修改头像" target="mainFrame"><img style="width:78px;height:78px;" src="<?=$face?>" /></a>
				</div>
				<div class="rigpxiang">
				<?php
						$name = empty($user['realname'])?$user['username']:$user['realname'];
						$name = shortstr($name,10,'');
						?>
					<a href="<?= geturl('teacher/setting/rprofile') ?>" target="mainFrame"><p style="color:#5a83a9; font-size:15px;color:#5e96f5;" title="<?=$user['username']?>" ><?=$name?></p></a>
					<p><a href="<?= geturl('teacher/setting/pass') ?>" target="mainFrame">修改密码</a></p>
					<p class="jifenico"><a href="<?=geturl('home/score')?>" target="mainFrame" title="积分" style="color:#9e9ea0"><?=$user['credit']?></a></p>
				</div>
				<div class="ejiants" style="margin-left:10px;">
				<div class="kewate">
				<span style="width:<?=$percent?>%;"><?=$percent?>%</span>
				</div>
				<a href="<?= geturl('teacher/setting/rprofile')?>" target="mainFrame" style=" font-family:微软雅黑;line-height:16px;">完善资料 ></a>
				</div>

			</div>

	<div class="extendbox">
		<?php if(!empty($haspower) && $haspower == 3) { ?>
		<ul class="extendlist">
			<li><a target="mainFrame" href="<?= geturl('aroomv2/report') ?>"><i class="ui_ico tongjfenxiffix"></i>统计分析</a></li>
		</ul>
		<?php } else { ?>
		<ul class="extendlist">
			<li><a target="mainFrame" href="<?= geturl('aroomv2/tutorial') ?>"><i class="ui_ico tutorialffix"></i>新手指引</a></li>
			<li><a target="mainFrame" href="<?= geturl('aroomv2/asetting') ?>"><i class="ui_ico wangxiaoffix"></i>网校概况</a></li>
			<li><a target="mainFrame" href="<?= geturl('aroomv2/teacher') ?>"><i class="ui_ico jiaosguanliffix"></i>教师管理</a></li>
			<li><a target="mainFrame" href="<?= geturl('aroomv2/classes/student') ?>"><i class="ui_ico banjxueshengffix"></i>学生管理</a></li>
			<li><a target="mainFrame" href="<?= geturl('aroomv2/course') ?>"><i class="ui_ico kechguanliffix"></i>课程管理</a></li>
			<?php if(!empty($room) && $room['isschool'] != 7){ ?>
			<li><a target="mainFrame" href="<?= geturl('aroomv2/classcourses')?>"><i class="ui_ico bjkcffix"></i>班级课程</a></li>
			<?php } ?>
			<li><a target="mainFrame" href="<?= geturl('aroomv2/report') ?>"><i class="ui_ico tongjfenxiffix"></i>统计分析</a></li>
			<li><a target="mainFrame" href="<?= geturl('aroomv2/information') ?>"><i class="ui_ico xinxiguanliffix"></i>信息管理</a></li>
			<li><a target="mainFrame" href="<?=geturl('aroomv2/module')?>"><i class="ui_ico mokuaipeizhiffix"></i>门户配置</a></li>
			<li><a target="mainFrame" href="<?=geturl('aroomv2/systemsetting')?>"><i class="ui_ico xitongshezhifix"></i>系统设置</a></li>
			<li><a target="mainFrame" href="<?= geturl('aroomv2/more') ?>"><i class="ui_ico surveyffix"></i>更多应用</a></li>
			<!--<li><a target="mainFrame" href="<?= geturl('aroomv2/sysconfig') ?>"><i class="ui_ico configfix"></i>系统配置</a></li>-->
		</ul>
		<?php } ?>
	</div>
</div>
	</div>		