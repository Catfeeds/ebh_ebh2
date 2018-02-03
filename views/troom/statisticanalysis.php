<?php $this->display('troom/page_header'); ?>
<style>
.myxuan {
	margin-top:15px;
	background: none repeat scroll 0 0 #fff;
    float: left;
   
    width: 788px;
}
.myxuan li a {
	width:227px;
	height:227px;
	display:block;
}
.myxuan .jiancha{
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/tastulog.jpg) no-repeat center #fff;
	/*margin-right:50px;*/
}
.myxuan .mytiku {
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/classerrorbook.jpg) no-repeat center #fff;
	/*margin-right:50px;*/
}
.myxuan .comtiku{
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/schoolerrorbook.jpg) no-repeat center #fff;
	/*margin: 0 30px;*/
}
.myxuan .myxuex{
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/scorecount.jpg) no-repeat center #fff;

}
.myxuan .notessum{
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/notessum.jpg) no-repeat center #fff;
	/*margin-right:50px;*/
}
.myxuan .logs{
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/logs.jpg) no-repeat center #fff;
	/*margin-right:50px;*/
}
.myxuan .errors{
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/errors.jpg) no-repeat center #fff;
	
}
.myxuan .teacher{
	background:url(http://static.ebanhui.com/ebh/tpl/aroomv2/images/teacherstatistics_p.jpg) no-repeat center #fff;

}

</style>
<div class="ter_tit">
	当前位置 > 统计分析
</div>
<div class="lefrig">
	<div class="myxuan">
		<ul>
		<li class="jiancha">
		<a href="<?= geturl('troom/tastulog') ?>"></a>
		</li>
		<li class="mytiku">
		<a href="<?= geturl('troom/statisticanalysis/classerrorbook') ?>"></a>
		</li>
		<li class="myxuex">
		<a href="<?= geturl('troom/statisticanalysis/scorecount') ?>"></a>
		</li>
	<!--	<li class="notessum">
		<a href="<?= geturl('troom/statisticanalysis/notessum') ?>"></a>
		</li>-->
		<li class="logs">
		<a href="<?= geturl('troom/statisticanalysis/logs') ?>"></a>
		</li>
		<li class="errors">
		<a href="<?= geturl('troom/statisticanalysis/errors') ?>"></a>
		</li>
		<li class="teacher">
		<a href="<?= geturl('troom/statisticanalysis/teach') ?>"></a>
		</li>
		</ul>
	</div>
</div>
<?php $this->display('troom/page_footer'); ?>