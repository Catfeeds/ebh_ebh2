<?php $this->display('college/page_header'); ?>
<div class="lefrig" style="background:#fff;float:left;width:1000px; min-height:600px;">
<?php 
if(!empty($folder)){
	$this->assign('selidx',2);
	$this->display('college/course_nav');
}?>
<div class="workol">
<div class="work_menu" style="position:relative;">
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
		<li><a href="<?= geturl('college/myexam/my') ?>"><span>我做过的作业</span></a></li>
		<li class="workcurrent"><a href="<?= geturl('college/myexam/box') ?>"><span>草稿箱</span></a></li>
		<?php if($roominfo['domain'] != 'bndx'){ ?>
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
				<thead class="tabhead">
					  <tr>
						<th>作业名称</th>
						<th>出题教师</th>
						<th>出题时间</th>
						<th>总分/得分</th>
						<th>答题时间</th>
                        <th>已答人数</th>
						<th>操作</th>
					  </tr>
			  	</thead>
				<tbody>
				<?php if(!empty($exams)) { ?>
					<?php foreach($exams as $exam) { ?>
						  <tr class="kettshe">
							<td style="width:240px;" title="<?= $exam['title']?>"><span style="width:200px;word-wrap: break-word;float:left;"><?= shortstr($exam['title'],30)?></span></td>
							<td style="width:60px;"><?= empty($exam['realname'])?$exam['username']:$exam['realname'] ?></td>
							<td style="width:100px;"><?= date('Y-m-d H:i',$exam['dateline'])?></td>
							<td style="width:60px;"><?= $exam['score'] ?>/<?= round($exam['totalscore'],2)?></td>
							<td style="width:100px;"><?= date('Y-m-d H:i',$exam['adateline'])?></td>
							<td style="width:60px;"><?= $exam['answercount'] ?></td>
							<td style="width:76px;">
							<?php 
								$target = stripos($_SERVER['HTTP_USER_AGENT'],'android') != false ?'_parent':'_blank'; 
								if(!empty($isapple)) {
									$dourl = 'http://www.ebanhui.com/sitecp.html?action=ctlogin&type=ebhexam&from=ebh&flag=1&rid='.$roominfo['crid'].'&k='.urlencode($key).'&eid='.$exam['eid'];
								} else {
									$dourl = 'http://exam.ebanhui.com/edo/'.$exam['eid'].'.html';
								}
							?>
								<a class="previewBtn" href="<?= $dourl ?>" target="<?= $target ?>">继续做作业</a>
							</td>
						  </tr>
					<?php } ?>
				<?php } elseif(!$is_zjdlr) { ?>
 					<tr>
						<td colspan="8" class="nonejunrs" align="center"><div class="nodata"></div></td>
					</tr>
				<?php } ?>
			  	</tbody>
		  </table>
		  <?= $pagestr ?>
    </div>
</div>
</div>
<script type="text/javascript">
<?php if (($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) && $check != 1) { 
	?>
		$(function(){
			if(window.parent != undefined) {
				<?php if(!empty($payitem)) { ?>
					if(window.parent.setiinfo != undefined) {
						window.parent.setiinfo("<?= $payitem['iname'] ?>","<?= empty($checkurl) ? '' : $checkurl ?>");
					}
				<?php } ?>
				// window.parent.showDivModel(".nelame");
				window.parent.opencountdiv();
			}
		});
		<?php } ?>
$(function(){
	var searchtext = "请输入搜索关键字";
	initsearch("title",searchtext);
	$("#ser").click(function(){
		var title = $("#title").val();
		if(title == searchtext) 
		title = "";
		var url = '<?= geturl('college/myexam/box') ?>' + '?q='+title;
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
	
	location.href='<?= geturl('college/myexam/box')?>?q='+sname;
}
</script>
<?php $this->display('myroom/page_footer'); ?>