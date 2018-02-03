<?php $this->display('troomv2/page_header'); ?>
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
.myxuan .mytiku {
	background:url(http://static.ebanhui.com/ebh/images/wxbg_1.jpg) no-repeat center #fff;
}
.myxuan .comtiku{
	background:url(http://static.ebanhui.com/ebh/images/wxbg_2.jpg) no-repeat center #fff;
	
}
.myxuan .myxuex{
	background:url(http://static.ebanhui.com/ebh/images/wxbg_3.jpg) no-repeat center #fff;
	/*margin: 0 50px;*/
}
.myxuan .history{
	background:url(http://static.ebanhui.com/ebh/images/wxbg_4.jpg) no-repeat center #fff;

}
</style>
<div class="ter_tit">
	当前位置 > 微信校通
</div>
<div class="lefrig">
	<div class="myxuan">
		<ul>
		<!-- 班级发送 -->
		<!-- <li class="mytiku">
		<a href="<?= geturl('troomv2/weixin/student_send_msg') ?>"></a>
		</li> -->
		<!-- 班级群发 -->
		<li class="comtiku" target="_blank">
		<a href="<?= geturl('troomv2/weixin/class_send_msg') ?>"></a>
		</li>
		<!-- 家长回复 -->
		<li class="myxuex">
		<a href="<?= geturl('troomv2/weixin/parent_send') ?>"></a>
		</li>
		<!-- 历史信息 -->
		<li class="history">
		<a href="<?= geturl('troomv2/weixin/list_msg') ?>"></a>
		</li>
		</ul>
	</div>
</div>
<?php $this->display('troomv2/page_footer'); ?>