<?php $this->display('jingpin/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>

<div class="lefrig" style="background:#fff;float:left;width:1000px;">
<?php 
if(!empty($folder)){
	$this->assign('selidx',2);
	$this->display('jingpin/course_nav');
}?>
<div class="workol">


 <div class="workdata" style="width:1000px;">
	    	<table width="100%" class="datatab" style="border:none;">
				 <tbody>
<?php $target = stripos($_SERVER['HTTP_USER_AGENT'],'android') != false ?'_parent':'_blank'; ?>
				 <?php if(!empty($exams)) { ?>
					<?php foreach($exams as $exam) { ?>
						<?php 
							if(!empty($exam['face'])){
								$face = getthumb($exam['face'],'50_50');
							}else{
								if($exam['sex']==1){
									if($exam['groupid']==5){
										$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
									}else{
										$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
									}
								}else{
									if($exam['groupid']==5){
										$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
									}else{
										$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
									}
								}
							
								$face = getthumb($defaulturl,'50_50');
							} 
						?>  
					  <tr class="kettshe">
					  <td style="border-top:none;">
	
	<div style="float:left;margin-right:15px;">
		<?php
			if(!empty($exam['itemid'])){
				$key = 'f_'.$exam['folderid'];
				$iname = array_key_exists($key, $iteminfo)?$iteminfo[$key]['iname']:"课程";
			}
			if(!empty($isapple)) {
				$dourl = 'http://www.ebanhui.com/sitecp.html?action=ctlogin&type=ebhexam&from=ebh&flag=1&rid='.$roominfo['crid'].'&k='.urlencode($key).'&eid='.$exam['eid'];
				$viewurl = 'http://www.ebanhui.com/sitecp.html?action=ctlogin&type=ebhexam&from=ebh&flag=1&rid='.$roominfo['crid'].'&k='.urlencode($key).'&eid='.$exam['eid'];
			} else {
				$dourl = 'http://exam.ebanhui.com/edo/'.$exam['eid'].'.html';
				$viewurl = 'http://exam.ebanhui.com/emark/'.$exam['eid'].'.html';
			}
		?>
		<img class="radiust" title="<?= empty($exam['realname'])?$exam['username']:$exam['realname'] ?>" src="<?=$face?>" /></div>
													<div style="float:left;width:900px;font-family:simsun;">
														<p style="width:760px;word-wrap: break-word;font-size:16px;;float:left;line-height:2;">
															<?php if(!empty($exam['itemid'])){?>
																
																	<?= $exam['title'] ?>
																
															<?php }else{?>
																
																	<?= $exam['title'] ?>
																
															<?php }?>
														</p>

					<span style="float:right;width:70px;">
						
			
							<?php if($exam['astatus'] == 1) { ?>
							
							<?php } else { ?>
							<?php 
								if(empty($exam['itemid'])){
								?>
									
								<?php }else{?>
									
								<?php }?>
							<?php } ?>
					</span>
					<div style="float:left;width:790px;">
						
						
						<span class="huirenw" style="width:auto;float:left;color:#999;padding-left:0;background:none;">
							<?= empty($exam['realname']) ? $exam['username'] : $exam['realname'] ?>
							 于
							<?= date('Y-m-d H:i:s',$exam['dateline']) ?> 出题，总分为：<?= $exam['score'] ?>，答题人数：<?=$exam['answercount']?>，<?php if(empty($exam['limitedtime'])){echo '不计时';}else{echo '计时：'.$exam['limitedtime'].' 分钟';}?>
						</span>
						</div>
						
					</div>

					</td>
					  </tr>

					 <?php } ?>
				 <?php } else { ?>
					<tr>
				 		<td colspan="6" align="center" style="border-top:none;"><div class="nodata"></div></td>
				 	</tr>
				 <?php } ?>
					</tbody>
				</table>
				<?= $pagestr ?>
	    </div>



	</div>
</div>
