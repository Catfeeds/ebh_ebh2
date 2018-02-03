<?php $this->display('troomv2/page_header'); ?>
<style>
.myxuan {
	margin-top:15px;
	background: none repeat scroll 0 0 #fff;
    border: 1px solid #ccc;
    float: left;
   
    width: 786px;
}
.myxuan li {
	width:227px;
	height:227px;
	float:left;
	margin-bottom:20px;

}
.myxuan li a {
	width:227px;
	height:227px;
	display:block;
}
.myxuan .mytiku {
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/phand.jpg) no-repeat center #fff;
}
.myxuan .comtiku{
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/pintelligent.jpg) no-repeat center #fff;
	/*margin: 0 50px;*/
}
.myxuan .myxuex{
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/precord.jpg) no-repeat center #fff;
	
}
</style>
<div class="ter_tit">
	当前位置 > 在线组卷
</div>
<div class="lefrig">
	<div class="myxuan">
		<ul>
		<!-- 手工 -->
		<li class="mytiku">
		<a href="http://exam.ebanhui.com/handpaper/<?= $crid ?>.html" target="_blank"></a>
		</li>
		<!-- 智能 -->
		<li class="comtiku" target="_blank">
		<a href="http://exam.ebanhui.com/intelligentpaper/<?= $crid ?>.html" target="_blank"></a>
		</li>
		<!-- 历史记录 -->
		<li class="myxuex">
		<a href="<?= geturl('troomv2/exampaper/paperrecord') ?>"></a>
		</li>
		</ul>
	</div>
</div>
<?php $this->display('troomv2/page_footer'); ?>