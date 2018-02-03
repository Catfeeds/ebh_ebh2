<?php $this->display('myroom/page_header'); ?>
<style>
.myxuan {
	margin-top:15px;
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
	float: left;
	position: relative;
}
.myxuan li a span {
    background: url(http://static.ebanhui.com/ebh/tpl/default/images/dengyuan.gif) no-repeat 0 0;
    color: #FFFFFF;
    height: 30px;
    line-height: 30px;
    position: absolute;
    right: 45px;
    text-align: center;
    top: 45px;
    width: 30px;
	display: none;
}
.myxuan .mytiku {
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/progress.jpg) no-repeat center #fff;
}
.myxuan .comtiku{
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/studycalendar.jpg) no-repeat center #fff;
	margin: 0 50px;
}

</style>
<div class="ter_tit">
	当前位置 > 学习进度表
</div>
<div class="lefrig">
	<div class="myxuan">
		<ul>
		<!-- 学习进度 -->
		<li class="mytiku">
			<a href="<?= geturl('myroom/progress') ?>">
			</a>
		</li>
		<!-- 我的学习表 -->
		<li class="comtiku" target="_blank">
			<a href="<?= geturl('myroom/studycalendar') ?>">
			</a>
		</li>
		
		</ul>
	</div>
</div>

<?php $this->display('myroom/page_footer'); ?>