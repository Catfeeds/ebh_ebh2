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
.myxuan .mynotice {
	background:url(http://static.ebanhui.com/ebh/tpl/2014/images/notice.jpg) no-repeat center #fff;
	/*margin-right:50px;*/
}
.myxuan .mymessage{
	background:url(http://static.ebanhui.com/ebh/tpl/2014/images/message.jpg) no-repeat center #fff;
	/*margin-right:50px;*/
}
</style>
<div class="ter_tit">
	当前位置 > 通知管理
</div>
<div class="lefrig">
	<div class="myxuan">
		<ul>
		<li class="mynotice">
		<a href="<?= geturl('troom/notice/send') ?>"></a>
		</li>
		<li class="mymessage">
		<a href="<?= geturl('troom/msg/send') ?>"></a>
		</li>
		</ul>
	</div>
</div>
<?php $this->display('troom/page_footer'); ?>