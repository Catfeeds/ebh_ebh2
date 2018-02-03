<?php $this->display('aroomv2/page_header')?>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
<SCRIPT LANGUAGE="JavaScript">
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
	$(function(){
		$("#room_search_btn").click(function(){
			var search = $('#title').val();
			var url = '<?=geturl('aroomv2/allcourses/'.$folderdetail['folderid'].'-0-0-0')?>';
			if($('#title').val()=='输入关键字搜索'){
				search='';
			}
			search = search.replace(/,/g,"");
			search = search.replace(/\'/g,"");
			search = search.replace(/\"/g,"");
			search = search.replace(/\//g,"");
			search = search.replace(/%/g,"");
			search = search.replace(/_/g,"");
			search = search.replace(/#/g,"");
			search = search.replace(/\?/g,"");
			search = search.replace(/\\/g,"");
			// url=url.replace('searchvalue',encodeURIComponent(search));
			url = url+'?q='+search;
			location.href=url;
		});
	});
</script>
<style type="text/css">
.cqliebiao {
	width: 786px;
	background:#fff;
	border: 1px solid #cdcdcd;
}
.liess{
	clear:both;
}
.cqliebiao *:after{display:block;clear:both;content:"";visibility:hidden;height:0;}  
.cqliebiao .cqlite {
	text-align: center;
	font-weight: bold;
	font-size: 14px;
	height: 34px;
	border-bottom:solid 1px #cdcdcd;
	line-height: 34px;
	width:786px;
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
	width: 678px;
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
	width: 678px;
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
	width: 678px;
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
.searchipt {
    border: 1px solid #CDCDCD;
    color: #999999;
    float: left;
    font-size: 14px;
    height: 22px;
    line-height: 22px;
    padding-left: 5px;
    width: 300px;
}
.kejian {
	width: 748px;
	float:left;
	border: 1px solid #dcdcdc;
}
.kejian .showimg {
	margin-top: 6px;
	margin-left: 8px;
}
.kejian liss {
	width: 748px;
}
.kejian .liss .danke {
	width: 145px;
	float: left;
	margin-top: 8px;
	height: 218px;
}
.kejian .liss .danke .spne {
	text-align: center;
	width: 140px;
	height: 36px;
	overflow: hidden;
	word-wrap: break-word;
	display: block;
	color: #0033ff;
	float:left;
}
.kejian .liss .danke .sds {
	height: 184px;
	width: 145px;
	border: 1px solid #cdcdcd;
	background-image: url(http://static.ebanhui.com/ebh/tpl/2012/images/dise.jpg);
	background-repeat: no-repeat;
	background-position: center center;
	margin-bottom: 8px;
}
.showimg { background-color:#CBCBCB; float:left;}
.showimg img { background-color:#FFFFFF; border:1px solid #CDCDCD; padding:4px; position:relative; left:-4px; top:-5px;}
.hover .showimg { background-color:#0087B2;}
.hover .showimg img { border:1px solid #0087B2;}
.showimg .hover{border: 1px solid #0099cc;}
</style>


<div class="ter_tit">
		当前位置 > <a href="<?=geturl('aroomv2/allcourses')?>">学校所有课程</a> > 
			<?php if(!empty($uparr)){
				$upfoldercount = count($uparr);
				foreach($uparr as $k=>$upfolder){
				$index = $upfoldercount-$k-1;
			?>
			<a href="<?=geturl('aroomv2/allcourses/'.$uparr[$index]['folderid'])?>"><?=$uparr[$index]['foldername']?></a> > 
			<?php }}?>
			<?= $folder['foldername'] ?>
	<?php 
		$defaultColor = empty($search)?'#CBCBCB':'#000';
		$search = empty($search)?'输入关键字搜索':$search;

	?>
<div class="diles">
	<input name="title" class="newsou" id="title" type="text" onblur="if($('#title').val()==''){$('#title').val('输入关键字搜索').css('color','#d9d9d9');}" onfocus="if($('#title').val()=='输入关键字搜索'){$('#title').val('').css('color','#d9d9d9');}" value="<?= isset($search) ? $search : '输入关键字搜索' ?>" style="color:<?= $defaultColor ?>"/>
	<input type="button" class="soulico" value="" id="room_search_btn">
</div>
		</div>
	<div class="lefrig" style="margin-top:15px;">
	
	
<?php if(!empty($subfolderlist)) { ?>
<div class="kejian">
	<ul class="liss">
        <?php foreach($subfolderlist as $subfolder){ ?>
	<li class="danke" style="margin-left:4px; _margin-left:2px;list-style: none;">
	<div class="showimg"><a href="<?=geturl('aroomv2/allcourses/'.$subfolder['folderid'])?>" title="<?=$subfolder['foldername']?>"><img src="<?= empty($subfolder['img']) ? 'http://static.ebanhui.com/ebh/images/nopic.jpg' : $subfolder['img'] ?>" width="114" height="159" border="0" /></a></div>
	<span class="spne"><a href="<?= geturl('aroomv2/allcourses/'.$subfolder['folderid']) ?>" style="text-decoration: none;" title="<?= $subfolder['foldername'] ?>"><?= ssubstrch($subfolder['foldername'],0,20) ?>(<?= $subfolder['coursewarenum'] ?>)</a></span>
	</li>
        <?php } ?>

	</ul>
	</div>
<?php }?>
	<?php if(empty($subfolderlist)){?>
<div class="cqliebiao">

	<?php if(!empty($sectionlist)){?>
<div class="cqlite">
<span><?=$folderdetail['foldername']?> (目录)</span>
</div>
<div class="cqmain">
	<?php 
		$i=1;
		foreach($sectionlist as $sl){
		$flag = true;
		foreach($sl as $course){
		if($flag == true){
	?>
		<h2 class="lanbiaot"><?=empty($course['sid'])?'其他课程':$course['sname']?></h2>
		<?php $flag=false;}?>
		<ul>
	<li class="liess">
	<span style="float:left;width:42px;">
		<?php if($course['examnum']>0){?>
			<i class="zuoyeico" title="此课件包含作业"></i>
		<?php }else{?>
			<i></i>
		<?php }?>
		<?php if($course['attachmentnum']>0){?>
			<i class="fujianico" title="此课件包含附件"></i>
		<?php }else{?>
			<i></i>
		<?php }?>
	</span>
	<?php $arr = explode('.',$course['cwurl']);
		$type = $arr[count($arr)-1]; 
		if($type != 'flv' && $course['ism3u8'] == 1) {
			$type = 'flv';
		}
		if($type == 'mp3')
			$type = 'flv';
		?>
	<a class="sa"  target="<?= (empty($course['cwurl']) || $type == 'flv') ? '_blank' : '' ?>" href="<?= (empty($course['cwurl']) || $type == 'flv') ? geturl('aroomv2/course/'.$course['cwid']) : geturl('aroomv2/allcourses/course/'.$course['cwid']) ?>" $color><?=$course['title']?><span>…………………………………………………………………………………………………………………………………………………………………………</span></a><em class="yema" $color><?=$i++?></em></li>
<?php }}?>
	</ul>
</div>
</div>
	<?php }else{?>
		   <div style="padding-left:15px; padding-top:4px; font-size:14px;">没有找到相关记录</div>
	<?php }?>
<?=$pagestr?>
<?php }?>
</div>
</body>
</html>