<?php $this->display('myroom/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<div class="ter_tit">
	当前位置 > <a href="<?= geturl('myroom/myexam') ?>">我的作业</a> > 待做作业
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

         <li class="workcurrent"><a href="<?= geturl('myroom/myexam/all') ?>"><span>待做作业</span></a></li>
		 <li><a href="<?= geturl('myroom/myexam/my') ?>"><span>我做过的作业</span></a></li>  
		  <li><a href="<?= geturl('myroom/myexam/box') ?>"><span>草稿箱</span></a></li> 
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
		location.href='<?= geturl('myroom/myexam/all')?>?q='+sname;
	}
</script>
	    <div class="workdata">
	    	<table width="100%" class="datatab" style="border:none;">
				<thead class="tabhead">
					<tr>
						<th>作业名称</th>
						<th>出题教师</th>
						<th>出题时间</th>
						<th>总分</th>
						<th>操作</th>
					</tr>
				</thead>
				 <tbody>

				 <?php if(!empty($exams)) { ?>
					 <?php foreach($exams as $exam) { ?>
					  <tr>
						<td style="width:275px;_width:325px;*width:325px;" title="<?= $exam['title'] ?>"><?= shortstr($exam['title'],50) ?></td>
						<td style="width:50px;"><?= empty($exam['realname']) ? $exam['username'] : $exam['realname'] ?></td>
						<td style="width:90px;_width:125px;*width:125px;"><?= date('Y-m-d H:i:s',$exam['dateline']) ?></td>
						<td style="width:40px;"><?= $exam['score'] ?></td>
						<td style="width:60px;">

						<?php $target = stripos($_SERVER['HTTP_USER_AGENT'],'android') != false ?'_parent':'_blank'; ?>
			
							<?php if($exam['astatus'] == 1) { ?>
							<a class="lviewbtn" href="http://exam.ebanhui.com/?emark/<?= $exam['eid'] ?>.html" target="<?= $target?>">查看结果</a>
							<?php } else { ?>
							<a class="previewBtn" href="http://exam.ebanhui.com/edo/<?= $exam['eid'] ?>.html" target="<?= $target?>">在线答题</a>
							<?php } ?>

						</td>
					  </tr>
					 <?php } ?>
				 <?php } else { ?>
						 <tr>
				 		<td colspan="6" align="center">暂无记录</td>
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
$(function(){
		var searchText = "请输入搜索关键字";
		initsearch("txtname",searchText);
});
</script>
<?php $this->display('myroom/page_footer'); ?>