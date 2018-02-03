<?php $this->display('college/page_header'); ?>
<style type="text/css">
.result{ margin:0 auto; width:435px;}
.result p{ font-family:"微软雅黑"; font-size:20px; font-weight:bold; margin-top:10px; padding-left:25px;}
.result .p1 {background:url("http://static.ebanhui.com/ebh/tpl/2014/images/sh_bj1.png") no-repeat scroll left center;
    color: #faa945;}
.result .span1 {
    color: #faa945;
    font-size: 13px;
    font-weight: bold;
    line-height: 27px;
    padding-left: 50px;
}
.result .p3{ color:#ff667f; background:url("http://static.ebanhui.com/ebh/tpl/2014/images/sh_bj3.png") no-repeat left center; }
</style>
<div class="lefrig" style="background:#fff;float:left;width:1000px;">
<div class="workol" style="margin-top:0;">
		<div class="work_menu" style="position:relative;">
			<ul>
				<li><a href="<?=geturl('examapply/apply')?>"><span>认证申请</span></a></li>
				<li class="workcurrent"><a href="<?=geturl('examapply/exam/examlist')?>"><span>认证考核</span></a></li>
				<li><a href="<?=geturl('examapply/exam/examresult')?>"><span>查看结果</span></a></li>
			</ul>
		</div>
<?php
if(empty($apply) || $apply['status'] == -1){
	echo '<div class="result"><div><p class="p3">您还没有提交认证申请，请先提交认证申请。</p></div></div>';
	exit;
} elseif (!empty($apply) && $apply['status'] == 0){
	echo '<div class="result"><div><p class="p1">您的申请已提交，等待审核...</p><span class="span1">(审核周期在15个工作日内)</span></div></div>';
	exit;
} elseif (!empty($apply) && $apply['status'] == 2){
	echo '<div class="result"><div><p class="p3">您的申请未通过审核，请修改后再次提交。</a></p></div></div>';
	exit;
}
?>
 <div class="workdata" style="width:998px;">
	    	<table width="100%" class="datatab" style="border:none;">
				 <tbody>
<?php $target = stripos($_SERVER['HTTP_USER_AGENT'],'android') != false ?'_parent':'_blank'; ?>
				 <?php if(!empty($exams)) { ?>
					<?php foreach($exams as $exam) { ?>
					  <tr>
					  <td style="border-top:none;">
	
	<div style="float:left;margin-right:15px;">
		<?php
			if(!empty($exam['itemid'])){
				$key = 'f_'.$exam['folderid'];
				$iname = array_key_exists($key, $iteminfo)?$iteminfo[$key]['iname']:"课程";
			}
		?>
		<img width="50" src="<?=$folderimg[$exam['folderid']]?>" /></div>
													<div style="float:left;width:900px;font-family:Microsoft YaHei;">
														<p style="width:825px;word-wrap: break-word;font-size:14px;;float:left;line-height:2;">
															<?php if(!empty($exam['itemid'])){?>
																<a  href="javascript:void(0)" onclick="showBuyDialog('<?=$iname?>',<?=$exam['itemid']?>)" style="color:#777;font-weight:bold;">
																	<?= $exam['title'] ?>
																</a>
															<?php }elseif(empty($exam['isfinish'])){?>
																<a  href="javascript:void(0)" onclick="alert('需完成课程内所有课件学习才可以进行考核,请继续学习！');window.location.href='/myroom/college/study.html'" style="color:#777;font-weight:bold;">
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
								if(!empty($exam['itemid'])){?>
									<a class="previewBtn" style="font-family: 宋体;" href="javascript:void(0)" onclick="showBuyDialog('<?=$iname?>',<?=$exam['itemid']?>)">考试</a>
								<?php }elseif(empty($exam['isfinish'])){?>
									<a class="previewBtn" style="font-family: 宋体;" href="javascript:void(0)" onclick="alert('需完成课程内所有课件学习才可以进行考核,请继续学习！');window.location.href='/myroom/college/study.html'">考试</a>

								<?php }else{?>
									<a class="previewBtn" style="font-family: 宋体;" href="http://exam.ebanhui.com/edo/<?= $exam['eid'] ?>.html" target="<?= $target?>">考试</a>
								<?php }?>
							<?php } ?>
					</span>

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
<script type="text/javascript">

<?php if (($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) && $check != 1) { ?>
$(function(){
	if(window.parent != undefined) {
		<?php if(!empty($payitem)) { ?>
			if(window.parent.setiinfo != undefined) {
				window.parent.setiinfo("<?= $payitem['iname'] ?>","<?= empty($checkurl) ? '' : $checkurl ?>");
			}
		<?php } ?>
		window.parent.showDivModel(".nelame");
	}
});

<?php } ?>

function showBuyDialog(iname,itemid){
	if(window.parent != undefined) {
		window.parent.setiinfo(iname,"<?=empty($_checkurl)?'':$_checkurl?>"+itemid);
	}
	window.parent.showDivModel(".nelame");
}
</script>
<?php $this->display('myroom/page_footer'); ?>