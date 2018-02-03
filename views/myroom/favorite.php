<?php $this->display('myroom/page_header'); ?>
<style type="text/css">

.myxuan .mytiku {
    background: url(http://static.ebanhui.com/ebh/tpl/default/images/courseware.jpg) no-repeat center center #fff;
}
.myxuan .comtiku {
    background: url(http://static.ebanhui.com/ebh/tpl/default/images/soucourse.jpg) no-repeat center center #fff;
	margin: 0 30px;
}

.myxuan li {
    float: left;
    height: 227px;
    margin-bottom: 20px;
    width: 227px;
}
.myxuan li a {
    display: block;
    height: 227px;
    width: 227px;
}
</style>
<div class="ter_tit"> 当前位置 > 学习课程 </div>
<div class="lefrig">
<div class="annuato" style="line-height:28px;padding-left:20px;position: relative;"> 此页面为我的收藏页面 </div>
<div class="myxuan">
<ul>
<li class="mytiku">
<a href="<?=geturl('myroom/favorite/course')?>"></a>
</li>
<li class="comtiku">
<a href="<?=geturl('myroom/favorite/subject')?>"></a>
</li>
</ul>
</div>
</div>
<?php $this->display('myroom/page_footer'); ?>