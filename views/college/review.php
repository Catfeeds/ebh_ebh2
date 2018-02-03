<?php $this->display('myroom/page_header'); ?>
<style>
.myxuan {
	background: none repeat scroll 0 0 #fff;
    border: 1px solid #ccc;
    float: left;
    margin-top: 15px;
    width: 786px;
}
.myxuan li a {
	width:227px;
	height:227px;
	display:block;
	float: left;
	position: relative;
}
.myxuan .mytiku {
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/stuping.jpg) no-repeat center #fff;
}
.myxuan .comtiku{
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/terhui.jpg) no-repeat center #fff;
	/*margin: 0 50px;*/
}
.myxuan .jiaoliu {
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/stuping.jpg) no-repeat center #fff;
}

.myxuan li a span {
    background: url(http://static.ebanhui.com/ebh/tpl/default/images/dengyuan.gif) no-repeat 0 0;
    color: #FFFFFF;
    height: 30px;
    line-height: 30px;
    position: absolute;
    right: 45px;
    text-align: center;
    top: 45px;
    width: 30px;
}
</style>
<div class="ter_tit">
	当前位置 > 评论交流
</div>
<div class="lefrig">
	<div class="myxuan">
		<ul>
		<!-- 学生的所有评论 -->
		<li class="mytiku">
		<a href="<?= geturl('myroom/review/student') ?>">
			<span id="allspan" style="display:none;"></span>
		</a>
		</li>
		<!-- 老师回复的评论-->
		<li class="comtiku">
		<a href="<?= geturl('myroom/review/teacher') ?>">
			<?php if($count>0 && $count<=99 ){ ?>
			<span id="myspan"><?= $count; ?></span>
			<?php }elseif($count>99){ ?>
			<span style="top:15px;">99+</span>
			<?php } ?>
		</a>
		</li>
        <!-- 交流IM直接登录 -->
        <!--<li class="jiaoliu">
		<a href="http://im.ebanhui.com/auth.html?k=<?=$this->input->cookie('auth');?>" target="_blank">
			<span></span>
		</a>
		</li>-->
		
		</ul>
	</div>
</div>
<?php 
$this->display('myroom/page_footer'); 
$this->display('myroom/player');
?>