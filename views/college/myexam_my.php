<?php $this->display('college/page_header'); ?>
<?php $this->widget('sendmessage_widget'); ?>
<div class="lefrig" style="background:#fff;float:left;width:1000px;min-height:600px">
<?php 
if(!empty($folder)){
	$this->assign('selidx',2);
	$this->display('college/course_nav');
}?>
<div class="workol" style="margin-top:0;">
<div class="work_menu" style="position:relative;margin-top:0;">
    <?php
        $roominfo['crid'] = empty($roominfo['crid'])?0:$roominfo['crid'];
        if(!empty($roominfo['crid'])){
        	$appsetting = Ebh::app()->getConfig()->load('othersetting');
	        $appsetting['zjdlr'] = !empty($appsetting['zjdlr']) ? $appsetting['zjdlr'] : 0;
	        $appsetting['newzjdlr'] = !empty($appsetting['newzjdlr']) ? $appsetting['newzjdlr'] : array();
	        $is_zjdlr = ($roominfo['crid'] == $appsetting['zjdlr']) || (in_array($roominfo['crid'],$appsetting['newzjdlr']));
	        $is_newzjdlr = in_array($roominfo['crid'],$appsetting['newzjdlr']); 
        }
    ?>
    <ul>

		<li class=""><a href="<?= geturl('college/myexam/all') ?>"><span><?php if($is_zjdlr){echo '考试';}else{echo '做作业';}?></span></a></li>
		<li class="workcurrent"><a href="<?= geturl('college/myexam/my')?>"><span>我做过的</span></a></li>
		<!--<li><a href="<?= geturl('college/myexam/box')?>"><span>草稿箱</span></a></li>-->
		<?php if($roominfo['domain'] != 'bndx' && (!$is_zjdlr)){ ?>
		<li><a href="<?= geturl('college/myerrorbook') ?>"><span>错题本</span></a></li>
		<?php } ?>
    </ul>
	<?php if(empty($folder)){?>
	<div class="diles">
		<?php
			$q= empty($q)?'':$q;
			if(!empty($q)){
				$stylestr = 'style="color:#000"';
			}else{
				$stylestr = "";
			}
		?>
		<input name="txtname" <?=$stylestr?> class="newsou" id="title" value="<?= $q?>" type="text" />
		<input type="button" onclick="searchs('title');return false;" class="soulico" value="">
	</div>
	<?php }?>
</div>
    <div class="workdata" style="width:1000px;">
         <table width="100%" class="datatab" style="border:none;">
				<tbody>
					
				
				<?php if(!empty($exams)) { ?>
					<?php foreach($exams as $exam) {?>
						  <!--<tr class="kettshe">
							<td style="width:230px;" title="<?= $exam['title'] ?>"><?= shortstr($exam['title'],30) ?></td>
							<td style="width:120px;"><?= empty($exam['realname'])?$exam['username']:$exam['realname'] ?></td>
							<td style="width:120px;"><?= date('Y-m-d H:i',$exam['dateline']) ?></td>
							<td style="width:120px;"><?= date('Y-m-d H:i',$exam['adateline'])?></td>
							<td style="width:80px;"><?= ceil($exam['completetime']/60)?>分钟</td>
							<td style="width:80px;"><?= $exam['score']?>/<?= round($exam['totalscore'],2) ?></td>
							<td style="width:70px;"><?= $exam['answercount'] ?></td>
							<td style="width:84px;">
							<?php 
								$target = stripos($_SERVER['HTTP_USER_AGENT'],'android') != false ?'_parent':'_blank'; 
								if(!empty($isapple)) {
									$dourl = 'http://www.ebanhui.com/sitecp.html?action=ctlogin&type=ebhexam&from=ebh&flag=1&rid='.$roominfo['crid'].'&k='.urlencode($key).'&eid='.$exam['eid'];
									$viewurl = 'http://www.ebanhui.com/sitecp.html?action=ctlogin&type=ebhexam&from=ebh&flag=1&rid='.$roominfo['crid'].'&k='.urlencode($key).'&eid='.$exam['eid'];
								} else {
									$dourl = 'http://exam.ebanhui.com/edo/'.$exam['eid'].'.html?crid='.$roominfo['crid'];
									$viewurl = 'http://exam.ebanhui.com/emark/'.$exam['eid'].'.html?crid='.$roominfo['crid'];
								}
							?>
							<?php if($exam['astatus'] == 1) { ?>
								<a class="lviewbtn" href="<?= $viewurl ?>" target="<?= $target?>">查看结果</a>
							<?php } else { ?>
								<a class="previewBtn" href="<?= $dourl ?>" target="<?= $target?>">继续做作业</a>
							<?php } ?>

							</td>
						</tr>-->
						<tr class="kettshe">
							<td style="border-top:none;">
								<div style="float:left;width:960px;font-family:微软雅黑; height:55px;">
									<div class="bzzytitle" title="<?= $exam['title'] ?>"><?= shortstr($exam['title'],30) ?></div>
									<span style="float:right;width:90px;">
										<?php if($exam['astatus'] == 1) { ?>
											<a class="bjcgs" href="<?= $viewurl ?>" target="<?= $target?>">查看结果</a>
										<?php } else { ?>
											<a class="bjcgs jxzzy" href="<?= $dourl ?>" target="<?= $target?>">继续做作业</a>
										<?php } ?>
									</span>
									<div style="float:left;width:790px;padding-left:25px;">
										<div class="fbsjkc fl ml25">
											<p style="width:125px; color:#000;" class="fl"><?= timetostr($exam['dateline']); ?></p>
											<p class="fl" style="width:143px;"><span style="color:#999;" class="fl">出题者：</span> <a href="/college/myexam/all-1-0-0-<?= $exam['uid'] ?>.html" style="float:left;"><?= shortstr( empty($exam['realname'])?$exam['username']:$exam['realname'],8 )?></a>
											<a class="hrelh" href="javascript:;" tid="<?=$exam['uid']?>" tname="<?= empty($exam['realname'])?$exam['username']:$exam['realname'] ?>" title="给<?=$exam['sex'] == 1 ? '她' : '他'?>发私信"></a>  </p>
											<p style="color:#999;" class="fl"><span style="padding:0 10px;">|</span>总分：<?= $exam['score']?>分<span style="padding:0 10px;">|</span>得分：<?= round($exam['totalscore'],2) ?>分<span style="padding:0 10px;">|</span></p>
											<p class="kkjssj" style="padding-left:0;">答题时间：<?= date('Y-m-d H:i',$exam['adateline'])?><span style="padding:0 10px;">|</span></p>
											<p class="kkjssj" style="padding-left:0;">用时：<?= ceil($exam['completetime']/60)?>分钟</p>
										</div>
									</div>
								</div>
								<div class="clear"></div>
								<p class="kkjssj"><?php if(!empty($exam['cwid'])){echo '关联课件：';}else{echo '关联课程：';}?><a class="glkc" href="<?php echo '/myroom/college/study/cwlist/'.$exam['folderid'].'.html'; ?>"><?php echo $exam['foldername'];?></a> <?php if(!empty($exam['cwid'])) echo '>';?> <a class="glkc" target="_blank" href="<?php echo '/myroom/mycourse/'.$exam['cwid'].'.html'; ?>"><?php echo $exam['ctitle'];?></a></p>
							</td>
						</tr>
					<?php } ?>
					
				<?php } elseif(!$is_zjdlr) { ?>
 					<tr>
						<td colspan="8" class="nonejunrs" align="center" style="border-top:none;"><div class="nodata"></div></td>
					</tr>
				<?php } ?>
			  	</tbody>
		  </table>
		  <?= $pagestr ?>
    </div>
</div>
</div>
<style>
.fbsjkc a{
	color:#4c88ff !important;
}
.work_menu ul li a{
	font-family:微软雅黑;
	font-size:16px;
	color:#666;
}
.workcurrent a span{
	color:#4c88ff !important;
}

a.hrelh{
	height:34px;
	background:url(http://static.ebanhui.com/ebh/tpl/2016/images/fsxico.png) no-repeat left center;
	color: #2796f0;
    cursor: pointer;
    display: block;
    float: left;
    line-height: 24px;
    margin: 1px 0 0 8px;
    padding-left: 20px;
    text-align: center;
    text-decoration: none;
}
.kkjssj{
	background:none !important;
}
a.hrelh{
	padding-left:14px;
}
</style>
<script type="text/javascript">
<?php if (($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) && $check != 1) { ?>
$(function(){
	if(window.parent != undefined) {
		<?php if(!empty($payitem) && !empty($flag)) { ?>
			if(window.parent.setiinfo != undefined) {
				window.parent.setiinfo("<?= $payitem['iname'] ?>","<?= empty($checkurl) ? '' : $checkurl ?>");	
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
$(function(){
	var searchtext = "请输入关键字";
	initsearch("title",searchtext);
	$("#ser").click(function(){
		var title = $("#title").val();
		if(title == searchtext) 
		title = "";
		var url = '<?= geturl('college/myexam/my') ?>' + '?q='+title;
		<?php if(!empty($folder)){
			$itemid = $this->input->get('itemid');?>
		url += '&folderid=<?=$folder['folderid']?>';
		url += '&itemid=<?=!empty($itemid)?$itemid:''?>';
		<?php }?>
		document.location.href = url;
	});
	<?php if(!empty($folder)){?>
		$.each($('.work_menu li a'),function(k,v){
			$(this).attr('href',$(this).attr('href')+'?folderid=<?=$folder['folderid']?>&itemid=<?=$itemid?>');
		});
	<?php }?>
});
function searchs(strname){
	var sname = $('#'+strname).val();
	if(sname=='请输入搜索关键字'){
		sname = "";
	}
	
	location.href='<?= geturl('college/myexam/my')?>?q='+sname;
}
$(function(){
    $('.datatab td:last').css('border-bottom','none');
});
</script>
<?php $this->display('myroom/page_footer'); ?>