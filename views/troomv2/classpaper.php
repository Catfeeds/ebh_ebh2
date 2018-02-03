<?php $this->display('troomv2/page_header'); ?>
<style type="text/css">

.myxuan {
	margin-top:15px;
	background: none repeat scroll 0 0 #fff;
    float: left;
   
    width: 788px;
}

.myxuan .mytiku {
    background: url(http://static.ebanhui.com/ebh/tpl/2014/images/paperbuzhi150827.jpg) no-repeat center center #fff;
}
.myxuan .smartpaper {
    background: url(http://static.ebanhui.com/ebh/tpl/2014/images/smartpaper.jpg) no-repeat center center #fff;
}
.myxuan .xietong {
	background: url(http://static.ebanhui.com/ebh/tpl/2014/images/paperpigai150827.jpg) no-repeat center center #fff;
	/*margin: 0 50px;*/
}
.myxuan li a {
    display: block;
    height: 227px;
    width: 227px;
}
</style>
<div class="ter_tit"> 当前位置 > 在线考试 </div>
<div class="lefrig">
<div class="myxuan">
<ul>
<li class="mytiku">
<a target="_blank;" href="http://exam.ebanhui.com/enew/<?= $roominfo['crid'] ?>.html?type=1"></a>
</li>
<li class="smartpaper">
<a target="_blank;" href="http://exam.ebanhui.com/smartenew/<?= $roominfo['crid'] ?>.html?type=3"></a>
</li>
<li class="xietong">
<a href="<?=geturl('troomv2/classpaper/cor')?>"></a>
</li>
</ul>
</div>
</div>
<?php $this->display('troomv2/page_footer'); ?>