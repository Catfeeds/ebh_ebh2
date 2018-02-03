<?php $this->display('myroom/page_header'); ?>
			<div class="ter_tit">
	当前位置 > <a href="<?= geturl('myroom/stusubject') ?>" >学习课程</a> > 
	<?php if($from == 1) {?><a href="<?= geturl('myroom/stusubject/mycourse') ?>" >我的课程</a><?php } else if($from == 2) { ?><a href="<?= geturl('myroom/stusubject/allteachers') ?>" >全校老师</a><?php } else {?><a href="<?= geturl('myroom/stusubject/allcourse') ?>" >全校课程</a><?php } ?> > 
			<?php if(!empty($uparr)){
				$upfoldercount = count($uparr);
				foreach($uparr as $k=>$upfolder){
				$index = $upfoldercount-$k-1;
			?>
			<a href="<?=geturl('myroom/stusubject/'.$uparr[$index]['folderid'].'-0-0-0-'.$from)?>"><?=$uparr[$index]['foldername']?></a> > 
			<?php }}?>	
			<?= $folder['foldername'] ?>
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
			var url = "<?= geturl('myroom/stusubject/'.$folder['folderid'].'-0-0-0-'.$from)?>?q="+search;
			location.href=url;
		});
	});
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
	padding-left:10px;
	width: 770px;
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
	padding-bottom:10px;
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
	width: 690px;
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
.onlineico {
	background: url("http://static.ebanhui.com/ebh/tpl/default/images/online_ico.jpg") no-repeat;
	height: 16px;
	width: 16px;
}
.liess i {
	display: inline;
    float: right;
    margin: 5px 5px 0 0;
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

<?php if(!empty($subfolderlist)) { ?>
<div class="kejian">
	<ul class="liss">
        <?php foreach($subfolderlist as $subfolder){ ?>
	<li class="danke" style="margin-left:4px; _margin-left:2px;list-style: none;">
	<div class="showimg"><a href="<?=geturl('myroom/stusubject/'.$subfolder['folderid'].'-0-0-0-'.$from)?>" title="<?=$subfolder['foldername']?>"><img src="<?= empty($subfolder['img']) ? 'http://static.ebanhui.com/ebh/images/nopic.jpg' : $subfolder['img'] ?>" width="114" height="159" border="0" /></a></div>
	<span class="spne"><a href="<?= geturl('myroom/stusubject/'.$subfolder['folderid'].'-0-0-0-'.$from) ?>" style="text-decoration: none;" title="<?= $subfolder['foldername'] ?>"><?= ssubstrch($subfolder['foldername'],0,20) ?>(<?= $subfolder['coursewarenum'] ?>)</a></span>
	</li>
        <?php } ?>

	</ul>
	</div>
<?php }?>
<?php if(empty($subfolderlist)){?>
<div class="cqliebiao">

<div class="cqlite">
<span><?= $folder['foldername'] ?> (目录)</span>
	<div class="tiezitool" style="margin-top:-28px;">
	<a href="javascript:;" class="<?= empty($myfavorite)?'shoutie':'yishout'?>" id="favorite" style="margin-right:25px;width:45px;"></a>
	</div>
</div>

<div class="cqmain">
<?php if(!empty($onlinelist)) { 
	$i = 0;
	if(empty($user['realname'])) {
		$uname = $user['username'];
	} else {
		$u1 = substr($user['username'],0,2);
		$u2 = substr($user['username'],-2,2);
		$uname = $user['realname'].'('.$u1.'**'.$u2.')';
	}
?>
<h2 class="lanbiaot">直播课列表</h2>
		<ul>
		<?php foreach($onlinelist as $myonline) { 
		$i ++;
		$haspower = 1;
		$ourl = "";
		if($roominfo['isschool'] == 7 && $check != 1) {
			$ourl = "javascript:openonline();";
			$haspower = 0;
		} else {
			$tname = $myonline['realname'];
			$ourl = "http://chat.ebh.net/webconf/room.htm?id=".$myonline['id']."&user=".$uname."&teach=".$tname."&type=u&key=".$key;
		}
		
		?>
			<li class="liess">
	<span style="float:left;width:42px;">
		<i class="onlineico" title="直播课"></i>
			</span>
		<a class="sa" <?= empty($haspower) ? '' :'target="_blank"'?> href="<?= $ourl ?>"><span style="float:left"><?= $myonline['title'] ?>&nbsp;&nbsp;</span><span style="color:blue;font-weight:bold;float:left;"><?= date('Y年m月d日 H:i',$myonline['cdate']) ?> 开始，课长 <?= $myonline['ctime'] ?> 分钟&nbsp;&nbsp;</span>
		<?php if($myonline['status'] == 1) { ?>
		<span style="color:blue;font-weight:bold;float:left;">即将开始&nbsp;&nbsp;</span>
		<?php } else if($myonline['status'] == -1) { ?>
		<span style="color:gray;font-weight:bold;float:left;">已经过期&nbsp;&nbsp;</span>
		<?php } else { ?>
		<span style="color:gray;font-weight:bold;float:left;">正在进行&nbsp;&nbsp;</span>
		<?php } ?>
		<span>…………………………………………………………………………………………………………………………………………………………………………</span></a><em class="yema"><?= $i ?></em></li>
		<?php } ?>
		</ul>
<?php } ?>
<?php if(!empty($sectionlist)) { ?>
<?php $i = 1; ?>
<?php foreach($sectionlist as $section) { ?>
		<h2 class="lanbiaot"><?= $section[0]['sname']?></h2>
		<ul>
	<?php foreach($section as $course) { 
	$color = $course['examnum'] > 0 ? 'style="color:red;"' : '';
	?>
	<li class="liess">
	<span style="float:left;width:42px;">
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
	</span>
	<?php $arr = explode('.',$course['cwurl']);
		$type = $arr[count($arr)-1]; ?>
	<a class="sa" target="<?= ($type == 'flv') ? '_blank' : '' ?>" href="<?= geturl('myroom/mycourse/'.$course['cwid'].'-0-0-0-'.$from)?>" <?= $color ?>><?= $course['title'] ?><span>…………………………………………………………………………………………………………………………………………………………………………</span></a><em class="yema" <?= $color ?>><?= $i++ ?></em></li>
	<?php } ?>


	</ul>
	<?php } ?>
</div>

</div>


	  <?php } else { ?>
	  	<?php if(empty($onlinelist)) {?>
		  	 <div style="padding:20px 0 20px 160px; font-size:14px;"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/stuhope.jpg" /></div>
		<?php }?>
	  <?php } ?>
	<?= $pagestr ?>
</div>
<?php }?>

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
				$("#favorite").html("已收藏");
				$("#favorite").removeClass('shoutie');
				$("#favorite").addClass('yishout');
				$("#favorite").removeAttr('onclick');
			addfavorite('<?= $folder['folderid'] ?>','<?= $folder['foldername']?>',location.href);
		});
	<?php } else { ?>
		$("#favorite").html("已收藏");
			$("#favorite").removeClass('shoutie');
			$("#favorite").addClass('yishout');
	<?php } ?>
	

	});
	<?php if($roominfo['isschool'] == 7 && $check != 1) { ?>
		function openonline() {
			if(window.parent != undefined) {
				<?php if(!empty($payitem)) { ?>
					if(window.parent.setiinfo != undefined) {
						window.parent.setiinfo("<?= $payitem['iname'] ?>","<?= empty($checkurl) ? '' : $checkurl ?>");
					}
				<? } ?>
				window.parent.showDivModel(".nelame");
			}
		}
	<?php } ?>
	//-->
	</script>

<?php $this->display('myroom/page_footer'); ?>