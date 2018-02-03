<?php $this->display('college/page_header'); ?>
<?php $this->widget('sendmessage_widget'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<div class="lefrig" style="background:#fff;float:left;width:1000px;min-height:600px;">
<?php
if(!empty($folder)){
	$this->assign('selidx',2);
	$this->display('college/course_nav');
}?>
<div class="workol" style="margin-top:0;">
<div class="work_menu" style="position:relative; margin-top:0;">
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

		<li class="workcurrent"><a href="<?= geturl('college/myexam/all') ?>"><span><?php if($is_zjdlr){echo '考试';}else{echo '做作业';}?></span></a></li>
		<li><a href="<?= geturl('college/myexam/my') ?>"><span>我做过的</span></a></li>
		<!--<li><a href="<?= geturl('college/myexam/box') ?>"><span>草稿箱</span></a></li>-->
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
<script type="text/javascript">
	function searchs(strname){
		var sname = $('#'+strname).val();
		if(sname=='请输入搜索关键字'){
			sname = "";
		}
		// var tdate = $('#sdate').val();
		// location.href='<?= geturl('college/myexam/all')?>?q='+sname+'&d='+tdate;
		location.href='<?= geturl('college/myexam/all')?>?q='+sname;
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

		<?php
			if(!empty($exam['itemid'])){
				$key = 'f_'.$exam['folderid'];
				$iname = array_key_exists($key, $iteminfo)?$iteminfo[$key]['iname']:"课程";
			}
			if(!empty($isapple)) {
				$dourl = 'http://www.ebanhui.com/sitecp.html?action=ctlogin&type=ebhexam&from=ebh&flag=1&rid='.$roominfo['crid'].'&k='.urlencode($key).'&eid='.$exam['eid'].'&crid='.$roominfo['crid'];
				$viewurl = 'http://www.ebanhui.com/sitecp.html?action=ctlogin&type=ebhexam&from=ebh&flag=1&rid='.$roominfo['crid'].'&k='.urlencode($key).'&eid='.$exam['eid'].'&crid='.$roominfo['crid'];
			} else {
				$dourl = 'http://exam.ebanhui.com/edo/'.$exam['eid'].'.html?crid='.$roominfo['crid'];
				$viewurl = 'http://exam.ebanhui.com/emark/'.$exam['eid'].'.html?crid='.$roominfo['crid'];
			}
		?>
													<div style="float:left;width:960px;font-family:微软雅黑; height:55px;">
														<div class="bzzytitle">
															<?php if(!empty($exam['itemid'])){?>
																<a href="javascript:void(0)" onclick="showBuyDialog('<?=$iname?>',<?=$exam['itemid']?>,<?=$exam['folderid']?>,'<?=$dourl?>')">
																	<?= $exam['title'] ?>
																</a>
															<?php }else{?>
																<a  href="<?= $dourl ?>" target="<?= $target?>" >
																	<?= $exam['title'] ?>
																</a>
															<?php }?>
														</div>

					<span style="float:right;width:90px;">


							<?php if($exam['astatus'] == 1) { ?>
							<?php } else { ?>
							<?php
								if(empty($exam['itemid'])){
								?>
								<?php if($exam['astatus'] === NULL){?>
									<a class="bjcgs"  href="<?=$dourl?>" target="<?= $target?>">做作业</a>

								<?php }else{?>
									<a class="bjcgs jxzzy"  href="<?=$dourl?>" target="<?= $target?>">继续做作业</a>

								<?php }
									}else{?>
									<a class="bjcgs" href="javascript:void(0)" onclick="showBuyDialog('<?=$iname?>',<?=$exam['itemid']?>,<?=$exam['folderid']?>,'<?=$dourl?>')">做作业<hr color="#fff" size=1 width="90%" style="position:relative;top:-22px;color:#FFFFFF\9;background: #FFFFFF;border:0\9;"/></a>
								<?php }?>
							<?php } ?>
					</span>
					<div style="float:left;width:790px;padding-left:25px;">
						<div class="fbsjkc fl ml25">
							<p class="fl" style="width:125px; color:#000;"><?=timetostr($exam['dateline']); ?></p>
							<p class="fl" style="width:144px;"><span class="fl" style="color:#999;">出题者：</span><a href="/college/myexam/all-1-0-0-<?= $exam['uid'] ?>.html" style="float:left;"><?= shortstr( empty($exam['realname']) ? $exam['username'] : $exam['realname'],8) ?></a>
							<a class="hrelh" href="javascript:;" style="height:34px;background:url(http://static.ebanhui.com/ebh/tpl/2016/images/fsxico.png) no-repeat left center;"  tid="<?=$exam['uid']?>" tname="<?= empty($exam['realname'])?$exam['username']:$exam['realname'] ?>" title="给<?=$exam['sex'] == 1 ? '她' : '他'?>发私信"></a> </p>
							<p class="fl" style="color:#999;"><span style="padding:0 10px;">|</span>总分：<?= $exam['score'] ?>分<span style="padding:0 10px;">|</span></p>
							<p class="kkjssj"><?php if(empty($exam['limitedtime'])){echo '不计时';}else{echo '计时：'.$exam['limitedtime'].' 分钟';}?>
						</div>
						</div>
					</div>
					<div class="clear"></div>
					<p class="kkjssj"><?php if(!empty($exam['cwid'])){echo '关联课件：';}else{echo '关联课程：';}?><a class="glkc" href="<?php echo '/college/myexam/all.html?folderid='.$exam['folderid']; ?>"><?php echo $exam['foldername'];?></a> <?php if(!empty($exam['cwid'])) echo '>';?> <a class="glkc" target="_blank" href="<?php echo '/myroom/mycourse/'.$exam['cwid'].'.html'; ?>"><?php echo $exam['ctitle'];?></a></p>
					</td>
					  </tr>

					 <?php } ?>
				 <?php } elseif(!$is_zjdlr) { ?>
					<tr>
				 		<td colspan="6" align="center" class="nonejunrs" style="border-top:none;"><div class="nodata"></div></td>
				 	</tr>
				 <?php } ?>
					</tbody>
				</table>
				<?= $pagestr ?>
	    </div>



	</div>
</div>
	<div id="free-dialog" style="display:none">
		<div class="baoke">
			<img class="imgrts" src="" />
			<div class="suitrna">
				<h2></h2>
				<p class="p1"></p>
			</div>
			<div class="nasirte">
				<span class="titses">课程介绍</span>
				<div class="paewes"></div>
			</div>
			<div class="jduste">
				价格：<span class="cshortr">免费</span>
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
function freeBuy(nexturl, item) {
	//top.location.href = nexturl;
	var freeWindow = top.dialog({
		id: 'free-window',
		title: '报名',
		fixed: true,
		content: $("#free-dialog").html(),
		padding: 20,
		onshow: function() {
			var box = $(this.node);
			box.find('.ui-dialog2-footer').css('text-align', 'right');
			box.find('img.imgrts').attr('src', item.showimg);
			box.find('div.suitrna h2').html(item.iname);
			box.find('div.suitrna p.p1').html(item.crname);
			box.find('div.nasirte div.paewes').html(item.summary);
		},
		okValue: '去报名',
		ok: function() {
			var itemid = [];
			if (item['group_members']) {
				$.each(item['group_members'], function(index, ob) {
					itemid.push(ob.itemid);
				});
			} else {
				itemid.push(item.itemid);
			}
			$.ajax({
				url: '/ibuy/bpay.html',
				type: 'post',
				data: { 'itemid': itemid, 'totalfee': 0},
				dataType: 'json',
				success: function(ret) {
					if (ret.status == '0') {
						$.note(ret.msg);
						return;
					}
					//刷新页面
					document.location.reload();
				}
			});
		},
		cancelValue: '取消',
		cancel: function() {

		}
	});
	freeWindow.showModal();
}
function showBuyDialog(iname,itemid, folderid, nexturl){
	$.ajax({
		url: '/courseinfo/ajax_checkuserpermisions.html',
		type: 'post',
		dataType: 'json',
		data: { folderid: folderid, itemid: itemid },
		success: function(d) {
			if (d.errno == 1) {
				//登录失效
				top.location.reload();
				return;
			}
			if (d.errno == 0 && d.data.permission != 1 && d.data.free == 1) {
				//免费开通
				freeBuy(nexturl, d.data.item);
				return;
			}

			if(window.parent != undefined) {
				window.parent.setiinfo(iname,"<?=$_checkurl?>"+itemid);
				window.parent.opencountdiv();
			}
		}
	});
	 // window.parent.showDivModel(".nelame");
}
$(function(){
	var searchtext = "请输入关键字";
	initsearch("title",searchtext);
	$("#ser").click(function(){
		var title = $("#title").val();
		if(title == searchtext)
		title = "";
		var url = '<?= geturl('college/myexam/all') ?>' + '?q='+title;
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
$(function(){
    $('.datatab td:last').css('border-bottom','none');
});
</script>
<?php $this->display('myroom/page_footer'); ?>