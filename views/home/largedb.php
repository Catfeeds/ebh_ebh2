<?php $this->display('home/page_header'); ?>
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
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/largedb_study_20141203.jpg) no-repeat center #fff;
}
.myxuan .comtiku{
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/largedb_zy_20141203.jpg) no-repeat center #fff;
	/*margin: 0 50px;*/
}
.myxuan .myxuex{
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/largedb_dy_20141203.jpg) no-repeat center #fff;
	
}
.myxuan .myshoucang{
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/largedb_pl_20141203.jpg) no-repeat center #fff;
	
}
.myxuan .mydyzq{
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/largedb_dyzq.jpg) no-repeat center #fff;
	/*margin: 0 50px;*/
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
	当前位置 > <a href="<?= geturl('home/profile') ?>">个人信息</a> > 历史数据
</div>
<div class="lefrig">
	<div class="myxuan">
		<ul>
		<!-- 学习数据 -->
		<li class="mytiku">
		<a href="<?= geturl('home/largedb/study') ?>">
			<span id="xuexispan"></span>
		</a>
		</li>
		<!-- 作业数据 -->
		<li class="comtiku" target="_blank">
		<a href="<?= geturl('home/largedb/exam') ?>">
			<span id="zuoyespan"></span>
		</a>
		</li>
		<!-- 答疑数据 -->
		<li class="myxuex">
		<a href="<?= geturl('home/largedb/myquestion')?>">
			<span id="myquestionspan"></span>
		</a>
		</li>
		<!-- 评论数据 -->
		<li class="myshoucang">
		<a href="<?= geturl('home/largedb/mycomment') ?>">
			<span id="mycommentspan"></span>
		</a>
		</li>
        <!-- 答疑专区 -->
        <li class="mydyzq">
		<a href="<?= geturl('home/largedb/aqindex') ?>">
			<span id="myaqspan"></span>
		</a>
		</li>
		
		</ul>
	</div>
</div>
<script>
/**
 *去掉读取条目数据
 $(function(){
	$.ajax({
		'url':'<?=geturl('home/largedb/getcountinfo')?>',
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
})
*
**/
</script>
<?php 
$this->display('home/page_footer');
?>