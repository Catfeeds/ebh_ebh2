<?php 
$this->assign('notop',TRUE);
$this->display('myroom/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<div class="ter_tit">
	当前位置 > <a href="<?= geturl('myroom/sexam') ?>">我的作业</a> > 待做作业
	</div>
	<div class="lefrig">
<div class="workol">
<div class="work_menu">
    <ul>

         <li class="workcurrent"><a href="<?= geturl('myroom/sexam/all') ?>"><span>待做作业</span></a></li>
		 <li><a href="<?= geturl('myroom/sexam/my') ?>"><span>我做过的作业</span></a></li>  
		  <li><a href="<?= geturl('myroom/sexam/box') ?>"><span>草稿箱</span></a></li> 
    </ul>
</div>
<script type="text/javascript">
	function searchs(strname){
		var sname = $('#'+strname).val();
		var tdate = $('#sdate').val(); 
		location.href='<?= geturl('myroom/sexam/all')?>?q='+sname+'&d='+tdate;
	}
</script>
	    <div class="work_search">
	    	<table>
	        	<tr>
	                <td><label>作业名称</label><input name="txtname" id="txtname" value="<?= $q ?>" type="text" /></td>
	                <td style="display:inline-block;margin-left:15px;"><label>做题时间</label><input id="sdate" value="<?= $d ?>" onClick="WdatePicker()"></td>
	                <td><input type="button" onclick="searchs('txtname');return false;" class="souhuang" value="搜 索"></td>
	            </tr>
	        </table>
	    </div>
	    <div class="workdata">
	    	<table width="100%" class="datatab">
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
						<td style="width:150px;" title="<?= $exam['title'] ?>"><span style="width:270px;word-wrap: break-word;float:left;"><?= shortstr($exam['title'],30) ?></span></td>
						<td style="width:50px;"><?= empty($exam['realname']) ? $exam['username'] : $exam['realname'] ?></td>
						<td style="width:90px;"><?= date('Y-m-d H:i:s',$exam['dateline']) ?></td>
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
<?php if (($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7 ) && $check != 1) { ?>
$(function(){
	if(window.parent != undefined) {
		window.parent.showDivModel(".nelame");
	}
});
<?php } ?>
</script>
<?php $this->display('myroom/page_footer'); ?>