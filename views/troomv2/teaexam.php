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
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/mytiku0708.jpg) no-repeat center #fff;

}
.myxuan .comtiku {
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/comtiku0708.jpg) no-repeat center #fff;
}
.myxuan .mychouc {
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/mychouc1126.jpg) no-repeat center #fff;
}
.myxuan .myxuex {
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/myxuex1126.jpg) no-repeat center #fff;
	/*margin:0 50px;*/
}

.myxuan .shougong {
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/phand.jpg) no-repeat center #fff;
	/*margin:0 50px;*/
}
.myxuan .zhineng{
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/pintelligent.jpg) no-repeat center #fff;

}
.myxuan .lishi{
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/precord.jpg) no-repeat center #fff;
	
}
</style>
<div class="ter_tit">
	当前位置 > 我的题库
</div>
<div class="lefrig">
	<div class="myxuan">
		<ul>
		<li class="mytiku">
		<a href="http://exam.ebanhui.com/myquestion/<?= $crid ?>.html" target="_blank"></a>
		</li>
		
		<li class="myxuex">
		<a href="http://exam.ebanhui.com/schoolquestion/<?= $crid ?>.html" target="_blank"></a>
		</li>

		<li class="comtiku" target="_blank">
		<a href="http://exam.ebanhui.com/pubquestion/<?= $crid ?>.html" target="_blank"></a>
		</li>


		<li class="mychouc">
		<a href="http://exam.ebanhui.com/favquestion/<?= $crid ?>.html" target="_blank"></a>
		</li>

		</ul>
	</div>
</div>
<?php $this->display('troomv2/page_footer'); ?>