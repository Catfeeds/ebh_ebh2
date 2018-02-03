<?php $this->display('myroom/page_header');?>

<script type="text/javascript">
<!--
document.onkeydown=function(event) 
{ 
	e = event ? event :(window.event ? window.event : null); 
	if(e.keyCode==13){ 
		$("#room_search_btn").click();
		e.returnValue = false;
	} 
}
//-->
</SCRIPT>

<script type="text/javascript">
var searchText = "请输入您要搜索的课件名称";

	$(function(){
		initsearch("title",searchText);
		$("#room_search_btn").click(function(){
			var search = $('#title').val();
			if($('#title').val()=='请输入您要搜索的课件名称'){
				search='';
			}
			var url = "<?= geturl('myroom/fullcourse/lists-1-0-0-'.$moduleid.'-'.$folder['folderid'])?>?q="+search;
			location.href=url;
		});
	});
	<?php if (($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) && $check != 1) { ?>
$(function(){
	if(window.parent != undefined) {
		window.parent.showDivModel(".nelame");
	}
});
<?php } ?>
</script>
<style type="text/css">
.cqliebiao {
	width: 786px;
	margin-top:15px;
	border: 1px solid #cdcdcd;
	background:#fff;
}
.liess{
	clear:both;
}
.cqliebiao *:after{display:block;clear:both;content:"";visibility:hidden;height:0;}  
.cqliebiao .cqlite {
	text-align: center;
	font-weight: bold;
	font-size: 12px;
	height: 36px;
	line-height: 36px;
	border-bottom:solid 1px #cdcdcd;
	width:786px;
	font-size:14px;
}
.cqliebiao .cqmain {
	margin-left: 12px;
	width: 770px;
	padding-bottom:10px;
}
.cqliebiao .cqmain .lanbiaot {
	font-size: 14px;
	color: #0033ff;
	font-weight: bold;
	margin-top: 12px;
	margin-bottom: 12px;
}
.cqliebiao .cqmain ul {
	width: 770px;
	float: left;
}
.cqliebiao .cqmain liess {
	width: 680px;
	overflow: hidden;
	white-space: nowrap;
	line-height: 22px;
	height: 22px;
	display: block;
}


.sa:hover {
	color: #ff5500;
	text-decoration: none;
	padding-left: 5px;
	width: 690px;
	white-space: nowrap;
	overflow: hidden;
	line-height: 25px;
	height: 25px;
	background-color: #dfe98f;
	display: block;
}
.sa:visited{
		text-decoration: none;
	padding-left: 5px;
	white-space: nowrap;
	overflow: hidden;
	width: 625px;
	line-height: 25px;
	height: 25px;
	display: block;
	float: left;
	color:#721c73;
}

.sa {
	text-decoration: none;
	padding-left: 5px;
	white-space: nowrap;
	overflow: hidden;
	width: 690px;
	line-height: 25px;
	height: 25px;
	display: block;
	float: left;
	color:#333;
}
.yema {
	position: relative;
	float: left;
	line-height: 25px;
	height: 25px;
	margin-left: 5px;
}
.zuoyeico {
	background: url("http://static.ebanhui.com/ebh/tpl/default/images/exam_ico.jpg") no-repeat;
	height: 16px;
	width: 16px;
}
.fujianico {
	background: url("http://static.ebanhui.com/ebh/tpl/default/images/attachmen_ico.jpg") no-repeat;
	height: 16px;
	width: 16px;
}
.liess i {
	display: inline;
    float: right;
    margin: 5px 5px 0 0;
}
.terlink {
	position: absolute;
	width:195px;
	height:36px;
	display:block;
	top:55px;
	left:550px;
}
</style>

<div class="ter_tit">
	当前位置 > <?php if($helpcrid != $moduleid){?><a href="<?= geturl('myroom/fullcourse-0-0-0-'.$moduleid) ?>">所有课程</a> > <?php } ?><?= $folder['foldername']?>
<div class="diles">
	<?php
		$q = $this->input->get('q');
		$q= empty($q)?'':$q;
		if(!empty($q)){
			$stylestr = 'style="color:#000"';
		}else{
			$stylestr = "";
		}
	?>
	<input name="title" <?=$stylestr?> class="newsou" id="title" value="<?=$q?>" type="text" />
	<input id="room_search_btn" name="courseware_search" type="button" class="soulico" value="">
</div>
</div>
<div class="lefrig">

<div class="cqliebiao">
<div class="cqlite">
<span><?= $folder['foldername']?> (目录)</span>
</div>
<div class="cqmain">
<?php if(!empty($sectionlist)) { ?>
<?php $i = 0; ?>
<?php foreach($sectionlist as $section) { ?>
		<h2 class="lanbiaot"><?= $section[0]['sname']?></h2>
		<ul>
	<?php foreach($section as $course) { 
	$color = $course['examnum'] > 0 ? 'style="color:red;"' : '';
	?>
	<li class="liess">
	<span style="float:left;width:42px;">
		<?php if ($course['examnum']>0) { ?>
			<i class="zuoyeico" title="此课件包含作业"></i>
		<?php } else { ?>
			<i></i>
		<?php } ?>

		<?php if($course['attachmentnum'] > 0 ) { ?>
			<i class="fujianico" title="此课件包含附件"></i>
		<?php } else { ?>
			<i></i>
		<?php } ?>
	</span>
	<?php $arr = explode('.',$course['cwurl']);
		$type = $arr[count($arr)-1]; ?>
	<a class="sa" target="<?= (empty($course['cwurl']) || $type == 'flv') ? '_blank' : '' ?>" href="<?= geturl('myroom/fullcourse/'.$course['cwid'].'-1-0-0-'.$moduleid.'-'.$folder['folderid'])?>" <?= $color ?>><?= $course['title'] ?><span>…………………………………………………………………………………………………………………………………………………………………………</span></a><em class="yema" <?= $color ?>><?= $i++ ?></em></li>
	<?php } ?>

	</ul>
	<?php } ?>
</div>

</div>

	  <?php } else { ?>
		   <div style="padding-left:15px; padding-top:4px; font-size:14px;">没有找到相关记录</div>
	  <?php } ?>
	<?= $pagestr ?>
</div>
<?php $this->display('myroom/page_footer');?>