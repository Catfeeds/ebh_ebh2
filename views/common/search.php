<?php $this->display('common/header');?>
<?php ($q = $this->input->get('q')) or ($q = "");?>
<!--内容!-->
<div class="gkswts">
<div class="idrtgfd">
<?php if(!empty($showroom) || !empty($showall)){?>
<?php if(!empty($roomlist)){?>
<h2 class="kshtgd">网校</h2>
<ul id="room">
	<?php foreach ($roomlist as $room) {?>
	<?php 
		$roomurl = 'http://'.$room['domain'].'.ebh.net';
		$room['cface'] = empty($room['cface'])?'http://static.ebanhui.com/ebh/tpl/default/images/elist_tx.jpg':$room['cface'];
	?>
	<li class="kretdg">
		<a href="<?=$roomurl?>" target="_blank" class="khawrg"><img src="<?=$room['cface']?>" /></a>
		<div class="khstru">
			<!-- <h2 class="klstd"><a href="#">萧山<span class="lanstf">中学</span>学生网络学习班</a></h2> -->
			<h2 class="klstd"><a href="<?=$roomurl?>" target="_blank" ><?=str_replace($q,'<span class="lanstf">'.$q.'</span>',$room['crname'])?></a></h2>
			<p class="katdgs"><?=str_replace($q,'<span class="lanstf">'.$q.'</span>',$room['summary'])?></p>
			<a href="<?=$roomurl?>" target="_blank"  class="dktgf">进 入</a>
		</div>
	</li>
	<?php }?>
</ul>
<?php if(!empty($hasmore_room) && !empty($showall)){?>
	<a href="/searchs-1-0-0-2.html?q=<?=urlencode($q)?>" class="letfrg">更多网校</a>
<?php }?>
<?php if(!empty($showroom)){?>
	<?=$pagestr_room?>
<?php }?>
<?php }else{?>
	<div style="clear:both;"></div>
	<h2 class="kshtgd">网校</h2>
	<div id="tips">没有找到符合条件的网校</div>
<?php }?>
<?php }?>

<?php if(!empty($showcourse) || !empty($showall)){?>
	<?php if(!empty($courselist)){?>
		<h2 class="kshtgd">课件</h2>
		<ul id="course">
			<?php foreach($courselist as $course){?>
			
			<?php
				$defaultlogo = 'http://static.ebanhui.com/ebh/tpl/default/images/default.jpg?v=2';
				$logo = empty($course['logo']) ? $defaultlogo : getThumb($course['logo'],'96_96');
			?>

			<li class="kretdg">
				<a href="<?= geturl('course/'.$course['cwid'])?>" target="_blank" class="fretgd"><img alt="<?=$course['title']?>" src="<?=$logo?>" /></a>
				<div class="khstru" style="width:660px;">
					<h2 class="klstd"><a href="<?= geturl('course/'.$course['cwid'])?>" target="_blank"><?=str_replace($q,'<span class="lanstf">'.$q.'</span>',$course['title'])?></a></h2>
					<p class="lstgds chuts">所属课程：<?=$course['foldername']?></p>
					<p class="lstgds">摘要：<?=str_replace($q,'<span class="lanstf">'.$q.'</span>',$course['summary'])?></p>
					<p class="lstgds">主讲人：<?=$course['realname']?> | 发布时间：<?=date('Y-m-d H:i',$course['dateline'])?></p>
				</div>
				<div class="frigxue">
					<h2 class="xuemant">
						<a title="<?=$course['crname']?>" target="_blank" href="http://<?=$course['domain']?>.ebh.net"><?=$course['crname']?></a>
					</h2>
					<a href="http://<?=$course['domain']?>.ebh.net" target="_blank" class="jinrubtn">进 入</a>
				</div>
			</li>
			<?php }?>
		</ul>

		<?php if(!empty($hasmore_course) && !empty($showall)){?>
			<a href="/searchs-1-0-0-1.html?q=<?=urlencode($q)?>" class="letfrg">更多课件</a>
		<?php }?>

		<?php if(!empty($showcourse)){?>
			<?=$pagestr_course?>
		<?php }?>
	<?php }else{?>
		<div style="clear:both;"></div>
		<h2 class="kshtgd">课件</h2>
		<div id="tips">没有找到符合条件的课件</div>
	<?php }?>
<?php }?>

</div>
</div>
<script>
	$(function(){
		$("#searchhide").attr('target','_self');
	});
</script>
<?php $this->display('common/footer');?>
