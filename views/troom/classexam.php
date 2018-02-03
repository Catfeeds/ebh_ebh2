<?php $this->display('troom/page_header'); ?>
<style type="text/css">

.myxuan {
	margin-top:15px;
	background: none repeat scroll 0 0 #fff;
    float: left;
   
    width: 788px;
}

.myxuan .mytiku {
    background: url(http://static.ebanhui.com/ebh/tpl/2014/images/buzhi141226.jpg) no-repeat center center #fff;
}
.myxuan .smartexam {
    background: url(http://static.ebanhui.com/ebh/tpl/2014/images/smartexam.jpg) no-repeat center center #fff;
}
.myxuan .comtiku {
    background: url(http://static.ebanhui.com/ebh/tpl/2014/images/guanlian141226.jpg) no-repeat center center #fff;
}
.myxuan .xietong {
	background: url(http://static.ebanhui.com/ebh/tpl/2014/images/pigai141226.jpg) no-repeat center center #fff;
	/*margin: 0 50px;*/
}
.myxuan li a {
    display: block;
    height: 227px;
    width: 227px;
}
</style>
<div class="ter_tit"> 当前位置 > 班级作业 </div>
<div class="lefrig">
<div class="myxuan">
<ul>
<li class="mytiku">
<a target="_blank;" href="http://exam.ebanhui.com/enew/<?= $roominfo['crid'] ?>.html"></a>
</li>
<li class="smartexam">
<a target="_blank;" href="http://exam.ebanhui.com/smartenew/<?= $roominfo['crid'] ?>.html"></a>
</li>
<li class="xietong">
<a href="<?=geturl('troom/classexam/cor')?>"></a>
</li>
<li class="comtiku">
<a href="<?=geturl('troom/linkcourse/my')?>"></a>
</li>
</ul>
</div>
</div>
<?php $this->display('troom/page_footer'); ?>