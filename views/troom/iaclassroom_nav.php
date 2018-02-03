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
	background:url(http://static.ebanhui.com/ebh/tpl/2014/images/xj_hudong141226.jpg) no-repeat center #fff;
	/*margin-right:50px;*/
}
.myxuan .myxuex{
	background:url(http://static.ebanhui.com/ebh/tpl/2014/images/ck_hudong141226.jpg) no-repeat center #fff;
	/*margin-right:50px;*/
}
.myxuan .notessum{
	background:url(http://static.ebanhui.com/ebh/tpl/2014/images/hd_guanli141226.jpg) no-repeat center #fff;

}
</style>
<div class="ter_tit">
	当前位置 > 互动课堂
</div>
<div class="lefrig">
	<div class="myxuan">
		<ul>
		<li class="mytiku">
		<a href="<?= geturl('troom/iaclassroom/add') ?>"></a>
		</li>
		<li class="myxuex">
		<a href="<?= geturl('troom/iaclassroom/view') ?>?item=1"></a>
		</li>
		<li class="notessum">
		<a href="<?= geturl('troom/iaclassroom/view') ?>?item=2"></a>
		</li>
		</ul>
	</div>
</div>
<?php $this->display('troom/page_footer'); ?>