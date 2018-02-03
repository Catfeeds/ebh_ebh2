<?php $this->display('troomv2/page_header'); ?>
<style type="text/css">

.myxuan{
	background: none repeat scroll 0 0 #fff;
    float: left;
    margin-top: 15px;
    width: 788px;}

.myxuan .mytiku {
    background: url(http://static.ebanhui.com/ebh/images/lvrutu0106.jpg) no-repeat center center #fff;
}
.myxuan .comtiku {
    background: url(http://static.ebanhui.com/ebh/images/jiaoantu0106.jpg) no-repeat center center #fff;
}
.myxuan .xietong {
	background: url(http://static.ebanhui.com/ebh/images/xietong_0125.jpg) no-repeat center center #fff;
	/*margin: 0 50px;*/
}
.myxuan li a {
    display: block;
    height: 227px;
    width: 227px;
}
</style>
<div class="ter_tit"> 当前位置 > 电子教案 </div>
<div class="lefrig" >
<div class="myxuan">
<ul>
<li class="mytiku">
<a href="<?=geturl('troomv2/teachingplan/add')?>"></a>
</li>
<li class="xietong">
<a href="javascript:void(0);"></a>
</li>
<li class="comtiku">
<a href="<?=geturl('troomv2/teachingplan/manage')?>"></a>
</li>
</ul>
</div>
</div>
<?php $this->display('troomv2/page_footer'); ?>