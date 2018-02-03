<?php $this->display('myroom/page_header'); ?>
			
			<div class="ter_tit">
	当前位置 > <a href="<?= geturl('myroom/subject') ?>" >所有课程</a> >  <?= $folder['foldername'] ?>
</div>
<div class="lefrig">
<div class="annuato">
		<span style="float:left;height:22px;line-height:22px;">关键字：</span>
		<input name="title" id="title" type="text"  value="<?= $q ?>" style="width:350px;height:20px; float:left;line-height:22px; font-size:14px;padding-left: 5px;color:#585858;border:solid 1px #cdcdcd;">
		<input class="souhuang" id="room_search_btn"  name="courseware_search" type="button" value="搜 索" />

<?php if(!empty($folder) && !empty($folder['folderid'])) { ?>
<div class="tiezitool">
	<a href="javascript:;" id="favorite" class="previewBtn">收 藏</a>
	</div>
<?php } ?>
</div>

<script type="text/javascriptJavaScript">

document.onkeydown=function(event) 
{ 
	e = event ? event :(window.event ? window.event : null); 
	if(e.keyCode==13){ 
		$("#room_search_btn").click();
		e.returnValue = false;
	} 
}
</SCRIPT>

<script type="text/javascript">
var searchtext = "请输入您要搜索的课件名称";
$(function() {
   initsearch("title",searchtext);
		$("#room_search_btn").click(function(){
			var search = $('#title').val();
			if($('#title').val()=='请输入您要搜索的课件名称'){
				search='';
			}
			var url = "<?= geturl('myroom/subject/'.$folder['folderid'])?>?q="+search;
			location.href=url;
		});
	});
</script>
<style type="text/css">
.cqliebiao {
	width: 748px;
	border: 1px solid #cdcdcd;
}
.liess{
	clear:both;
}
.cqliebiao *:after{display:block;clear:both;content:"";visibility:hidden;height:0;}  
.cqliebiao .cqlite {
	background-color: #77c3b9;
	text-align: center;
	font-weight: bold;
	color: #FFFFFF;
	font-size: 12px;
	height: 28px;
	line-height: 28px;
	margin-top: 8px;
	margin-right: 5px;
	margin-left: 5px;
	width:735px;
}
.cqliebiao .cqmain {
	margin-left: 12px;
	width: 700px;
}
.cqliebiao .cqmain .lanbiaot {
	font-size: 14px;
	color: #0033ff;
	font-weight: bold;
	margin-top: 12px;
	margin-bottom: 12px;
}
.cqliebiao .cqmain ul {
	width: 700px;
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
	width: 625px;
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
	width: 625px;
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
    margin: 5px 0 0 0;
}
.fujianweek {
	background: url("http://static.ebanhui.com/ebh/tpl/2014/images/new.png") no-repeat;
	height: 16px;
	width: 16px;
}
</style>


<div class="cqliebiao">

<div class="cqlite">
<span><?= $folder['foldername'] ?> (目录)</span>

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
	<span style="float:left;width:50px;">
		<?php if ($course['examnum']>0 && $roominfo['isschool']==2) { ?>
			<i class="zuoyeico" title="此课件包含作业"></i>
		<?php } else { ?>
			<i></i>
		<?php } ?>

		<?php if($course['attachmentnum'] > 0 ) { ?>
			<i class="fujianico" title="此课件包含附件"></i>
		<?php } else { ?>
			<i></i>
		<?php } ?>
		<?php if($course['dateline']>strtotime("-7 days")){ ?>
			<i class="fujianweek" title="此课件为一周内新传课件" ></i>
		<?php } else { ?>
			<i></i>
		<?php } ?>
	</span>
	<?php $arr = explode('.',$course['cwurl']);
		$type = $arr[count($arr)-1]; ?>
	<a class="sa" target="<?= (empty($course['cwurl']) || $type == 'flv') ? '_blank' : '' ?>" href="<?= geturl('myroom/mycourse/'.$course['cwid'])?>" <?= $color ?>><?= $course['title'] ?><span>…………………………………………………………………………………………………………………………………………………………………………</span></a><em class="yema" <?= $color ?>><?= $i++ ?></em></li>
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


	<script type="text/javascript">
	<!--
	function tofolder(fid){
		var theurl = '<!--{eval echo geturl("myroom-1-0-0-coursewarelist-".$crid."-'+fid+'-find-")}-->';
		location.href=encodeURI(theurl);
	}
	
	function addfavorite(folderid,title,url){
		var purl = "<?= geturl('myroom/favorite/add')?>";
		$.ajax({
			type	:'POST',
			url		:purl,
			data	:{'folderid':folderid,'title':title,'url':url,'type':2},
			dataType:'text',
			success	:function(data){
				if(data=='success'){
					$("#favorite").html("已收藏");
					$("#favorite").unbind();
				}
			}
		});
	}
	
	
	
	$(function(){
		    var stu_courseware_li =$(".stu_courseware_list li");
		    stu_courseware_li.hover(function(){
				$(this).addClass("stu_current");
			},function(){
				$(this).removeClass("stu_current");
			});
	<?php if(empty($myfavorite)) { ?>
		$("#favorite").html("收藏");
		$("#favorite").unbind().click(function(){
			$("#favorite").removeAttr('onclick');
			addfavorite('<?= $folder['folderid'] ?>','<?= $folder['foldername']?>',location.href);
		});
	<?php } else { ?>
		$("#favorite").html("已收藏");
	<?php } ?>
	});
	
	//-->
	</script>

<?php $this->display('myroom/page_footer'); ?>