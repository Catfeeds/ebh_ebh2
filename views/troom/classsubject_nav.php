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
.myxuan .mytiku {
	background:url(http://static.ebanhui.com/ebh/tpl/2014/images/bj_kecheng150430.jpg) no-repeat center #fff;
	/*margin-right:50px;*/
}
.myxuan .myxuex{
	background:url(http://static.ebanhui.com/ebh/tpl/2014/images/kc_guanli141226.jpg) no-repeat center #fff;
	/*margin-right:50px;*/
}
.myxuan .notessum{
	background:url(http://static.ebanhui.com/ebh/tpl/2014/images/tk_fankui150120.jpg) no-repeat center #fff;

}
.myxuan .chapter {
	background:url(http://static.ebanhui.com/ebh/tpl/2014/images/zhishidianliulan.jpg) no-repeat center #fff;
}
</style>
<div class="ter_tit">
	当前位置 > 课程管理
</div>
<div class="lefrig">
	<div class="myxuan">
		<ul>
		<li class="mytiku">
		<a href="<?= geturl('troom/classsubject/courses') ?>"></a>
		</li>
		<li class="myxuex">
		<a href="<?= geturl('troom/review') ?>"></a>
		</li>
		<li class="notessum">
		<a href="<?= geturl('troom/feedback') ?>"></a>
		</li>
		<?php if($this->uri->uri_domain() != 'zjgxedu') { ?>
		<li class="chapter">
		<a href="<?= geturl('troom/chapter') ?>"></a>
		</li>
		<?php } ?>
		</ul>
	</div>
</div>
<?php $this->display('troom/page_footer'); ?>