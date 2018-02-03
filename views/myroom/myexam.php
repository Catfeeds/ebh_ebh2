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
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/myexam_do.jpg) no-repeat center #fff;
}
.myxuan .comtiku{
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/myexam_done.jpg) no-repeat center #fff;
	/*margin: 0 50px;*/
}
.myxuan .myxuex{
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/myexam_box.jpg) no-repeat center #fff;
	
}
.myxuan .myshoucang{
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/myerrorbook.jpg) no-repeat center #fff;
	
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
	当前位置 > 我的作业
</div>
<div class="lefrig">
	<div class="myxuan">
		<ul>
		<!-- 全部问题 -->
		<li class="mytiku">
		<a href="<?= geturl('myroom/myexam/all') ?>">
			<span id="allspan"></span>
		</a>
		</li>
		<!-- 我的问题 -->
		<li class="comtiku" target="_blank">
		<a href="<?= geturl('myroom/myexam/my') ?>">
			<span id="myspan"></span>
		</a>
		</li>
		<!-- 我的回答 -->
		<li class="myxuex">
		<a href="<?= geturl('myroom/myexam/box')?>">
			<span id="boxspan"></span>
		</a>
		</li>
		<!-- 我的关注 -->
		<li class="myshoucang">
		<a href="<?= geturl('myroom/myerrorbook') ?>">
			<span id="myerrorbookspan"></span>
		</a>
		</li>
		
		</ul>
	</div>
</div>
<script>
/*
$(function(){
	$.ajax({
		'url':'<?=geturl('myroom/myexam/getcountinfo')?>',
		'type':'json',
		success:function(data){
			var datas = eval('('+data+')');
			for(var name in datas){
				if(datas[name]>0){
					$('#'+name+'span').html(datas[name]>99?'99+':datas[name]);
					$('#'+name+'span').css('display','block');
				}
			}
		}
	});
})*/
</script>
<?php 
$this->display('myroom/page_footer'); 
$this->display('myroom/player');
?>