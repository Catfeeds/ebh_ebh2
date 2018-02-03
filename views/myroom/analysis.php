<?php $this->display('myroom/page_header'); ?>
<?php $hzxjxx = $roominfo['domain'] == 'hzxjxx';?>
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
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/huoyue.jpg) no-repeat center #fff;
}
.myxuan .sss {
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/studypeak.jpg) no-repeat center #fff;
}
.myxuan .comtiku{
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/studycalendar.jpg) no-repeat center #fff;
	<?php if(!$hzxjxx){?>
	/*margin: 0 50px;*/
	<?php }?>
}
.myxuan .myxuex{
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/progress.jpg) no-repeat center #fff;
	
}
.myxuan .myshoucang{
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/qinfen.jpg) no-repeat center #fff;
	/*margin: 0 50px;*/
}
.myxuan .evaluate{
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/evaluate.jpg) no-repeat center #fff;
	
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
	display:none;
}
</style>
<div class="ter_tit">
	当前位置 > 学习分析表
</div>
<div class="lefrig">
	<div class="myxuan">
		<ul>
		<!-- 活跃度 -->
		<li class="mytiku">
		<a href="<?= geturl('myroom/analysis/active') ?>">
			<span id="exam"></span>
		</a>
		</li>
		<!-- 强弱项
		<li class="myxuex">
		<a href="<?= geturl('myroom/analysis/advantage')?>">
			<span id="advantage"></span>
		</a>
		</li> -->
		<!-- 勤奋度 -->
		<li class="myshoucang">
		<a href="<?= geturl('myroom/analysis/hardwork') ?>">
			<span id="hardwork"></span>
		</a>
		</li>
		<!-- 学习峰值 -->
		<?php if(!$hzxjxx){?>
		<li class="sss">
		<a href="<?= geturl('myroom/analysis/studypeak') ?>">
			<span id="studypeak"></span>
		</a>
		</li>
		<?php }?>
		<!-- 学习进度 -->
		<li class="myxuex">
			<a href="<?= geturl('myroom/progress') ?>">
			</a>
		</li>
		<!-- 我的学习表 -->
		<li class="comtiku" target="_blank">
			<a href="<?= geturl('myroom/studycalendar') ?>">
			</a>
		</li>
		<!--自我测评-->
		<li class="evaluate" target="_blank">
			<a href="<?= geturl('myroom/evaluate') ?>">
			</a>
		</li>
		</ul>
	</div>
</div>

<script>
// $(function(){
	// $.ajax({
		// 'url':'<?=geturl('myroom/myexam/getcountinfo')?>',
		// 'type':'json',
		// success:function(data){
			// var datas = eval('('+data+')');
			// for(var name in datas){
				// if(datas[name]>0){
					// $('#'+name+'span').html(datas[name]>99?'99+':datas[name]);
					// $('#'+name+'span').css('display','block');
				// }
			// }
		// }
	// });
// })
</script>
<?php 
$this->display('myroom/page_footer'); 
?>