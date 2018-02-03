 <?php $this->display('troom/page_header'); ?>
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/default/css/feedback.css" />
			<div class="ter_tit">
	当前位置 > <a href="<?= geturl('troom/classsubject') ?>"> 课程管理</a> > 听课反馈 

</div>
<div class="lefrig">


<script type="text/javascript">

document.onkeydown=function(event) 
{ 
	e = event ? event :(window.event ? window.event : null); 
	if(e.keyCode==13){ 
		$("#room_search_btn").click();
		e.returnValue = false;
	} 
}
</script>

<div class="cqliebiao">

<!--<div class="cqlite">
<span>听课反馈</span>

</div>-->
 
<div class="cqmain">
<?php if(!empty($courses)) { ?>
<?php $i = 1;$curcourse=null; ?>
	<?php foreach($courses as $course) { 
	$color = $course['examnum'] > 0 ? 'style="color:red;"' : '';	
	?>

	<?php if(empty($curcourse)||$curcourse['folderid']!=$course['folderid']) { ?>
		<a href="<?= geturl('troom/classsubject/'.$course['folderid']) ?>" >
		<h2 class="lanbiaot">
		<?php if(in_array(intval($course['folderid']),$folders)){ ?><?= $course['foldername'] ?><?php } ?>(<?= $course['sname']?>)
		</h2>
		</a>
	<?php }?>
	<ul>

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
		$type = $arr[count($arr)-1]; 
	?>
	
	<a class="sa" target="<?= (empty($cw['cwurl']) || in_array($type,array('flv','mp4','avi'))) ? '_blank' : '' ?>" href="<?= geturl('troom/feedback/courses/'.$course['cwid'])?>" <?= $color ?>><?= $course['title'] ?><span>…………………………………………………………………………………………………………………………………………………………………………</span></a>
	

	<em class="yema" <?= $color ?>><?= $i++ ?></em></li>
	<?php $curcourse = $course; ?>

	</ul>
	<?php } ?>
</div>


	  <?php } else { ?>
	  	<?php if(empty($onlinelist)) {?>
		  	 <div style="padding:20px 0 20px 160px; font-size:14px;"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/stuhope.jpg" /></div>
		<?php }?>
	  <?php } ?>
</div>


<?php $this->display('troom/page_footer'); ?>