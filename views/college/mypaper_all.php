<?php $this->display('college/page_header'); ?>
<?php $this->widget('sendmessage_widget'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>

	</div>
	<div class="lefrig" style="background:#fff;float:left;width:1000px;font-family: 微软雅黑;">
<div class="workol" style="margin-top:0px;">
<div class="work_menu" style="width:1000px; position:relative;margin-top:0px;">
    <ul>

         <li class="workcurrent"><a href="<?= geturl('college/mypaper/all') ?>"><span>考试</span></a></li>
		 <li><a href="<?= geturl('college/mypaper/my') ?>"><span>查看结果</span></a></li>  
		  
    </ul>
	<div class="diles" >
			<?php
				$q= empty($q)?'':$q;
				if(!empty($q)){
					$stylestr = 'style="color:#000"';
				}else{
					$stylestr = "";
				}
			?>
			<input name="txtname" <?=$stylestr?> class="newsou" id="txtname" value="<?= $q?>" type="text" />
			<input type="button" onclick="searchs('txtname');return false;" class="soulico" value="">
		</div>
</div>
<script type="text/javascript">
	function searchs(strname){
		var sname = $('#'+strname).val();
		if(sname=='请输入搜索关键字'){
			sname = "";
		}
		// var tdate = $('#sdate').val(); 
		// location.href='<?= geturl('college/myexam/all')?>?q='+sname+'&d='+tdate;
		location.href='<?= geturl('college/mypaper/all')?>?q='+sname;
	}
</script>
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
		?>
		<a href="/college/mypaper/all-1-0-0-<?= $exam['uid'] ?>.html"><img title="<?= empty($exam['realname'])?$exam['username']:$exam['realname'] ?>" src="<?=$face?>" /></a></div>
													<div style="float:left;width:900px;font-family:Microsoft YaHei;">
														<p style="width:760px;word-wrap: break-word;font-size:14px;;float:left;line-height:2;">
															<?php if(!empty($exam['itemid'])){?>
																<a  href="javascript:void(0)" onclick="showBuyDialog('<?=$iname?>',<?=$exam['itemid']?>)" style="color:#777;font-weight:bold;">
																	<?= $exam['title'] ?>
																</a>
															<?php }else{?>
																<a  href="http://exam.ebanhui.com/edo/<?= $exam['eid'] ?>.html" target="<?= $target?>" style="color:#777;font-weight:bold;">
																	<?= $exam['title'] ?>
																</a>
															<?php }?>
														</p>

					<span style="float:right;width:70px;">
						
			
							<?php if($exam['astatus'] == 1) { ?>
							<a class="lviewbtn" href="http://exam.ebanhui.com/emark/<?= $exam['eid'] ?>.html" target="<?= $target?>">查看结果</a>
							<?php } else { ?>
							<?php 
								if(empty($exam['itemid'])){
									$dourl = 'http://exam.ebanhui.com/edo/'.$exam['eid'].'.html';
								?>
									<a class="previewBtn" style="font-family: 宋体;" href="<?=$dourl?>" target="<?= $target?>">考试</a>
								<?php }else{?>
									<a class="previewBtn" style="font-family: 宋体;" href="javascript:void(0)" onclick="showBuyDialog('<?=$iname?>',<?=$exam['itemid']?>)">考试</a>
								<?php }?>
							<?php } ?>
					</span>
					<div style="float:left;width:550px;">
						
						
						<span class="huirenw" style="width:auto;float:left;padding-left:0;background:none;">
							<a href="/college/mypaper/all-1-0-0-<?= $exam['uid'] ?>.html" style="float:left;"><?= empty($exam['realname']) ? $exam['username'] : $exam['realname'] ?></a>
							<a class="hrelh" href="javascript:;" tid="<?=$exam['uid']?>" tname="<?= empty($exam['realname'])?$exam['username']:$exam['realname'] ?>" title="给<?=$exam['sex'] == 1 ? '她' : '他'?>发私信"></a> 于
							<?= date('Y-m-d H:i:s',$exam['dateline']) ?> 出题，总分为：<?= $exam['score'] ?>，考试人数：<?=$exam['answercount']?>，<?php if(empty($exam['limitedtime'])){echo '不计时';}else{echo '计时：'.$exam['limitedtime'].' 分钟';}?>
						</span>
						</div>
						
					</div>

					</td>
					  </tr>

					 <?php } ?>
				 <?php } else { ?>
					<tr>
				 		<td colspan="6" class="nonejunrs" align="center" style="border-top:none;"><div class="nodata"></div></td>
				 	</tr>
				 <?php } ?>
					</tbody>
				</table>
				<?= $pagestr ?>
	    </div>



	</div>
</div>
<script type="text/javascript">

<?php if (($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) && $check != 1) { ?>
$(function(){
	if(window.parent != undefined) {
		<?php if(!empty($payitem) && !empty($payitem['isschoolfree']) && ($payitem['isschoolfree'] == 1 )) { ?>
			if(window.parent.setiinfo != undefined) {
				window.parent.opencountdiv();
			}
		<?php }else{ ?>
			if(window.parent.setiinfo != undefined){
				window.parent.opencountdiv();
			}
		<?php } ?>
		// window.parent.showDivModel(".nelame");
		window.parent.opencountdiv();
	}
});

<?php } ?>

function showBuyDialog(iname,itemid){
	if(window.parent != undefined) {
		window.parent.setiinfo(iname,"<?=$_checkurl?>"+itemid);
	}
	// window.parent.showDivModel(".nelame");
	window.parent.opencountdiv();
}
$(function(){
		var searchText = "请输入搜索关键字";
		initsearch("txtname",searchText);
});
</script>
<?php $this->display('myroom/page_footer'); ?>