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
	display: none;
}
<?php if($roominfo['isschool'] != 7){?>
.myxuan .mytiku {
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/wode.jpg) no-repeat center #fff;
	/*margin: 0 50px;*/
}
.myxuan .comtiku{
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/quanxiao.jpg) no-repeat center #fff;
}                                                                                                       
.myxuan .myxuex{
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/laoshi.jpg) no-repeat center #fff;
	
}
.myxuan .myshoucang{
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/shoucang.jpg) no-repeat center #fff;
	/*margin: 0 50px;*/
}
.myxuan .mynote{
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/note.jpg) no-repeat center #fff;
	/*margin: 0 50px;*/
}
.myxuan .newkec{
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/newkec.jpg) no-repeat center #fff;
}
<?php }else{?>
.myxuan .comtiku{
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/quanxiao.jpg) no-repeat center #fff;
	/*margin:0 50px;*/
}                                                                                                       
.myxuan .myxuex{
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/laoshi.jpg) no-repeat center #fff;
}
.myxuan .myshoucang{
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/shoucang.jpg) no-repeat center #fff;
}
.myxuan .mynote{
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/note.jpg) no-repeat center #fff;
}
.myxuan .newkec{
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/newkec.jpg) no-repeat center #fff;
}
<?php }?>
</style>
<div class="ter_tit">
	当前位置 > 学习课程
</div>
<div class="lefrig">
	<div class="myxuan">
		<ul>
		<li class="newkec">
			<a href="<?= geturl('myroom/stusubject/newcourse') ?>">
				<span id="newcoursespan"></span>
			</a>
		</li>
		<?php if($roominfo['isschool'] != 7) {?>
		<!-- 我的课程 -->
		<li class="mytiku">
			<a href="<?= geturl('myroom/stusubject/mycourse') ?>">
				<span id="mycoursespan"></span>
			</a>
		</li>
		<?php } ?>
		<!-- 全校课程 -->
		<li class="comtiku" target="_blank">
			<a href="<?= geturl('myroom/stusubject/allcourse') ?>">
				<span id="allcoursespan"></span>
			</a>
		</li>
		<!-- 全校老师 -->
		<li class="myxuex">
			<a href="<?= geturl('myroom/stusubject/allteachers')?>">
				<span id="allteachersspan"></span>
			</a>
		</li>
		<!-- 课件收藏 -->
		<!--<li class="myshoucang">
			<a href="<?= geturl('myroom/favorite') ?>">
				<span id="favoritespan"></span>
			</a>
		</li>-->
		<li class="mynote">
			<a href="<?= geturl('myroom/notes') ?>">
				<span id="notesspan"></span>
			</a>
		</li>
		
		</ul>
	</div>
</div>
<script>
/*
$(function(){
	$.ajax({
		'url':'<?=geturl('myroom/stusubject/getcountinfo')?>',
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
<?php $this->display('myroom/page_footer'); ?>