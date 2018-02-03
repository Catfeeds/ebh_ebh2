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
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/myask_all.jpg) no-repeat center #fff;
	/*margin: 0 50px;*/	
}
.myxuan .comtiku{
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/myask.jpg) no-repeat center #fff;
}
.myxuan .myxuex{
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/myask_answer.jpg) no-repeat center #fff;
}
.myxuan .myshoucang{
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/myask_favorite.jpg) no-repeat center #fff;
	/*margin: 0 50px;*/
}
.myxuan .myaddqf{
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/myask_addqf.jpg) no-repeat center #fff;
}
.myxuan .myaddq{
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/myask_addq.jpg) no-repeat center #fff;
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
	当前位置 > 互动答疑
</div>
<div class="lefrig">
	<div class="myxuan">
		<ul>
		<!-- 提问 -->
		<li class="myaddq">
		<a href="<?= geturl('myroom/myask/addquestion') ?>"></a>
		</li>
		<!-- 全部问题 -->
		<li class="mytiku">
		<a href="<?= geturl('myroom/myask/all') ?>">
			<span id="allspan"></span>
		</a>
		</li>
		<!-- 我的问题 -->
		<li class="comtiku" target="_blank">
		<a href="<?= geturl('myroom/myask/myquestion') ?>">
			<span id="myquestionspan"></span>
		</a>
		</li>
		<!-- 我的回答 -->
		<li class="myxuex">
		<a href="<?= geturl('myroom/myask/myanswer')?>">
			<span id="myanswerspan"></span>
		</a>
		</li>
		<!-- 我的关注 -->
		<li class="myshoucang">
		<a href="<?= geturl('myroom/myask/myfavorit') ?>">
			<span id="myfavoritespan"></span>
		</a>
		</li>
		</ul>
	</div>
</div>
<script>

$(function(){
	$.ajax({
		'url':'<?=geturl('myroom/myask/getcountinfo')?>',
		'type':'json',
		success:function(data){
			var datas = eval('('+data+')');
			for(var name in datas){
				if(datas[name]>0 && name=='all'){
					$('#'+name+'span').html(datas[name]>99?'99+':datas[name]);
					$('#'+name+'span').css('display','block');
				}
			}
		}
	});
})
</script>
<?php 
$this->display('myroom/page_footer'); 
?>