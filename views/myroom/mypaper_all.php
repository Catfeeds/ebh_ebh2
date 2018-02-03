<?php $this->display('myroom/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<div class="ter_tit">
	当前位置 > <a href="<?= geturl('myroom/mypaper') ?>">在线考试</a> > 待做试卷
	<div class="diles">
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
	<div class="lefrig" style="border:solid 1px #cdcdcd;background:#fff;float:left;margin-top:15px;width:786px;">
<div class="workol">
<div class="work_menu">
    <ul>

         <li class="workcurrent"><a href="<?= geturl('myroom/mypaper/all') ?>"><span>待做试卷</span></a></li>
		 <li><a href="<?= geturl('myroom/mypaper/my') ?>"><span>我做过的试卷</span></a></li>  
		  <!--<li><a href="<?= geturl('myroom/mypaper/box') ?>"><span>草稿箱</span></a></li> -->
    </ul>
</div>
<script type="text/javascript">
	function searchs(strname){
		var sname = $('#'+strname).val();
		if(sname=='请输入搜索关键字'){
			sname = "";
		}
		// var tdate = $('#sdate').val(); 
		// location.href='<?= geturl('myroom/myexam/all')?>?q='+sname+'&d='+tdate;
		location.href='<?= geturl('myroom/mypaper/all')?>?q='+sname;
	}
</script>
 <div class="workdata">
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
					  <tr>
					  <td>
	
	<div style="float:left;margin-right:15px;">
		<?php
			if(!empty($exam['itemid'])){
				$key = 'f_'.$exam['folderid'];
				$iname = array_key_exists($key, $iteminfo)?$iteminfo[$key]['iname']:"课程";
			}
		?>
		<a href="/myroom/myexam/all-1-0-0-<?= $exam['uid'] ?>.html"><img title="<?= empty($exam['realname'])?$exam['username']:$exam['realname'] ?>" src="<?=$face?>" /></a></div>
													<div style="float:left;width:700px;font-family:Microsoft YaHei;">
														<p style="width:580px;word-wrap: break-word;margin-bottom:10px;font-size:14px;;float:left;line-height:2;">
															<?php if(!empty($exam['itemid'])){?>
																<a  href="javascript:void(0)" onclick="showBuyDialog('<?=$iname?>',<?=$exam['itemid']?>)" style="color:#777;font-weight:bold;">
																	<?= shortstr($exam['title'],50) ?>
																</a>
															<?php }else{?>
																<a  href="http://exam.ebanhui.com/edo/<?= $exam['eid'] ?>.html" target="<?= $target?>" style="color:#777;font-weight:bold;">
																	<?= shortstr($exam['title'],50) ?>
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
						
						
						<span class="huirenw" style="width:auto;float:left;">
							<a href="/myroom/myexam/all-1-0-0-<?= $exam['uid'] ?>.html"><?= empty($exam['realname']) ? $exam['username'] : $exam['realname'] ?></a> 于
							<?= date('Y-m-d H:i:s',$exam['dateline']) ?> 出题，总分为：<?= $exam['score'] ?>，考试人数：<?=$exam['answercount']?>，<?php if(empty($exam['limitedtime'])){echo '不计时';}else{echo '计时：'.$exam['limitedtime'].' 分钟';}?>
						</span>
						</div>
						
					</div>

					</td>
					  </tr>

					 <?php } ?>
				 <?php } else { ?>
					<tr>
				 		<td colspan="6" align="center" style="border-top:none;">暂无记录</td>
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
		<?php if(!empty($payitem)) { ?>
			if(window.parent.setiinfo != undefined) {
				window.parent.setiinfo("<?= $payitem['iname'] ?>","<?= empty($checkurl) ? '' : $checkurl ?>");
			}
		<? } ?>
		window.parent.showDivModel(".nelame");
	}
});

<?php } ?>
function showBuyDialog(iname,itemid){
	if(window.parent != undefined) {
		window.parent.setiinfo(iname,"<?=$_checkurl?>"+itemid);
	}
	window.parent.showDivModel(".nelame");
}
$(function(){
		var searchText = "请输入搜索关键字";
		initsearch("txtname",searchText);
});
</script>
<?php $this->display('myroom/page_footer'); ?>