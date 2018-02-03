<?php $this->display('troomv2/page_header'); ?>
<style type="text/css">

.myxuan {
	background: none repeat scroll 0 0 #fff;
    float: left;
    margin-top: 15px;
    width: 788px;}

.myxuan .mytiku {
    background: url(http://static.ebanhui.com/ebh/tpl/default/images/suotes.jpg) no-repeat center center #fff;
}
.myxuan li a {
    display: block;
    height: 227px;
    width: 227px;
}
</style>
<div class="ter_tit"> 当前位置 > 应用工具 </div>
<div class="lefrig" >
<div class="myxuan">
<ul>
<li class="mytiku">
<a href="<?= geturl('troomv2/slock')  ?>"></a>
</li>
</ul>
</div>
</div>
<?php $this->display('troomv2/page_footer'); ?>