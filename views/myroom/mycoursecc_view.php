<?php $this->display('myroom/page_header'); ?>
<style>
.appraise dl dd {
    border-left: 0px solid #eeeeee;
    border-top: 1px solid #eeeeee;
    float: left;
    height: auto !important;
    min-height: 98px;
    width: 650px;
}
</style>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
<script src="http://static.ebanhui.com/ebh/js/reviewspage.js" type="text/javascript"></script>
		<script type="text/javascript">
			
		

		$(function(){
			//分页开始加载
			var page = 1;
			var cwid = $("#cwid").attr("value");
			var url = "/courseebhp/getajaxpage.html";
			page_load(page,url);
		})
		
		</script>
		<script src="http://static.ebanhui.com/ebh/js/swfobject.js" type="text/javascript"></script>

<input type="hidden" value="<?=$course['cwid']?>" id="cwid" /><!--课件cwid-->
<input type="hidden" value="<?=$user['groupid']?>" id="groupid" /><!--用户groupid用于判断老师还是学生-->
<input type="hidden" value="<?=$course['uid']?>" id="courseuid" /><!--课件教师id-->
<input type="hidden" value="<?=$user['uid']?>" id="useruid" /><!--用户id-->
		<div class="ter_tit">
	当前位置 > <a href="<?= geturl('myroom/stusubjectcc') ?>" >高考冲刺</a> > <a href="<?= geturl('myroom/stusubjectcc/'.$course['folderid'])?>"><?= $course['foldername'] ?></a> > <?= $course['title']?>
</div>
<div class="lefrig" style="margin-top:10px;">
			<div class="classbox">
				<h1>课件名:<?= $course['title']?></h1>
				<div class="classboxmore">
						
					<p>主讲：<?= empty($course['realname'])?$course['username']:$course['realname'] ?>    <span>时间：<?= date('Y.m.d',$course['dateline'])?></span><span>人气：<?= $course['viewnum']?></span></p>
					<p>摘要：<?= $course['summary'] ?></p>
					<p style="padding:10px;margin-left:-10px;">
					<?php if(preg_match('/.*(\.ebh|\.ebhp)$/',$course['cwurl'])) {?>
						<?php if(empty($hasnobtn) || $hasnobtn != TRUE) { ?>
						<input name="" onclick="freeplay('<?= $course['cwsource'] ?>',<?= $course['cwid'] ?>,'<?= str_replace("\""," ",str_replace("'"," ",$course['title']))?>')" class="huangbtn marrig" value="开始听课" type="button" />
						<!--<a href="<?= geturl('myroom/course/'.$course['cwid']) ?>" class="huangbtn marrig" target="_blank">网页播放</a>-->
						<?php } ?>
					<?php } elseif (!empty($course['cwurl']) && !preg_match('/.*(\.flv)$/',$course['cwurl'])) { ?>
						<a href="<?= $course['cwsource'].'attach.html?cwid='.$course['cwid']?>" class="huangbtn marrig">下 载</a>
						<?php if($course['ispreview']) { ?>
						<a class="huangbtn marrig" href = "<?= $course['cwsource'].'preview/'.$course['cwid'].'.html' ?>" target="_blank">预 览</a>
						<?php } ?>
					<?php } ?>
					<?php if(empty($hasnobtn) || $hasnobtn != TRUE) { ?>
					<input name="" class="lanbtn marrig" onclick="javascript:history.back();" value="返 回" type="button" />
					<?php } ?>
					<?php if(preg_match('/.*(\.ebh|\.ebhp)$/',$course['cwurl'])) {?>
						<?php if(empty($hasnobtn) || $hasnobtn != TRUE) { ?>
						<a href="<?= geturl('myroom/course/'.$course['cwid']) ?>" class="huangbtn marrig" target="_blank" style="float:right;margin-right:50px;">网页播放</a>
						<?php } ?>
					<?php } ?>
					</p>
				</div>
			</div>
			<?php if(preg_match("/.*(\.flv)$/",$course['cwurl'])) { ?>
				<div style=" position: relative;height:600px;z-index:601;float:left;">
				<div id="flvcontrol" style="width:700px;height:400px;"></div>
				</div>
			<?php } ?>
				<div id='atsrc' style="display: none;"></div>
			<div class="introduce" style="padding-top:10px;">
				<div class="intitle">
					<h2>课件介绍<?php if(preg_match("/.*(\.flv)$/",$course['cwurl'])){ ?><div class="tieziss"><a href="javascript:void(0)" onclick="document.getElementById('flvcontrol').callflashvideo()" class="borlanbtn">提交学习时间</a></div><?php } ?></h2>
				</div>
			  	<div class="incont">
					<?= $course['message'] ?>
				</div>
			</div>
			<a name="fujian" href="javascript:void(0);"></a>
			
			<?php if (!empty($attachments)) { ?>
			<div class="introduce">
				<div class="intitle">
					<h2>附件下载</h2>
				</div>
						
				<div class="incont">
						<table width="100%" class="datatab">
							<thead class="tabhead">
								<tr>
									<th>附件名称</th>
									<th>上传时间</th>
									<th>附件大小</th>
									<th>操作</th>
							 	</tr>
							  </thead>
								<tbody>
								 <?php foreach ($attachments as $atta) { ?>
								  <tr>
								  
								  
							    <?php if ($atta['suffix'] != 'ebh' || $atta['suffix'] != 'ebhp') { ?>
								  	<?php if ($atta['suffix'] != 'swf' && $atta['suffix'] != 'mp3' && $atta['suffix'] != 'flv') { ?>
										<td width="55%"><span style="width:400px;word-wrap: break-word;float:left;"><a href="<?= (empty($source) ?$atta['source']:$source) . 'attach.html?attid=' . $atta['attid'] ?>" ><?= $atta['title'] . '.' . $atta['suffix'] ?></a></span></td>
									<?php } else { ?>
										<td width="55%"><span style="width:400px;word-wrap: break-word;float:left;"><a href="javascript:void(0);" class="atfalsh" source="<?= (empty($source) ?$atta['source']:$source) ?>" title="<?= $atta['title']?>" suffix="<?= $atta['suffix'] ?>" cwid="<?= $course['cwid'] ?>" aid="<?= $atta['attid'] ?>" ><?= $atta['title'] . '.' . $atta['suffix'] ?></a></span></td>
									<?php } ?>
								<?php } ?>
									<td><?= date('Y-m-d H:i', $atta['dateline']) ?></td>
									<td></td>
									<?php if ($atta['suffix'] != 'ebh' || $atta['suffix'] != 'ebhp') { ?>
									<td>
										<?php if ($atta['suffix'] != 'swf' && $atta['suffix'] != 'mp3' && $atta['suffix'] != 'flv') { ?>
											<input class="previewBtn" onclick="location.href = '<?= (empty($source) ?$atta['source']:$source) . 'attach.html?attid=' . $atta['attid'] ?>'" name="" value="下载附件" type="button" />
											<?php if($atta['ispreview']) { ?>
											<a  class="previewBtn" href = "<?= (empty($source) ?$atta['source']:$source).'preview/att/'.$atta['attid'].'.html' ?>" target="_blank">预 览</a>
											<?php } ?>
										<?php } else { ?>
						   					<a class="atfalsh" href="javascript:void(0);" source="<?= (empty($source) ?$atta['source']:$source) ?>" title="<?= $atta['title']?>" suffix="<?= $atta['suffix'] ?>" cwid="<?= $course['cwid'] ?>" aid="<?= $atta['attid'] ?>" >播 放</a>
										<?php } ?>
									</td>
									<?php } ?>
								  </tr>
								  <?php } ?>
							  </tbody>
						</table>
				</div>
			</div>
			<?php } ?>
		

<script defer="defer" type="text/javascript">


	
</script>
<div style="display:none;" class="Offl" id="showdiv"></div>
<?php if(preg_match("/.*(\.ebhp)$/",$course['cwurl'])){?>
	<?php $this->display('myroom/player'); ?>
<?php }else{ ?>
	<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/play2.js"></script>
<?php } ?>
<?php $this->display('myroom/page_footer'); ?>