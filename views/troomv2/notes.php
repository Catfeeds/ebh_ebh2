<?php $this->display('troomv2/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<div class="ter_tit">
当前位置 > 学员笔记
</div>
<div class="lefrig">
<div class="annotate">
	<div class="tiezi_search">
            <form id="serform">
		<table>
		<tr>
			<td><label>关键字：</label><input id="uname" name="q" type="text"  value="<?= $q ?>"/></td>
			<td><label>时间范围：</label><input name="begintime" id="stardateline" value="<?= $begintime ?>" onClick="WdatePicker()"/></td>
			<td><label>至</label>
			<input name="endtime" id="enddateline"  value="<?= $endtime ?>" onClick="WdatePicker()"/></td>
			<td><a onclick="ser()" class="souhuang" id="ser">搜 索</a></td>
		</tr>
		</table>
            </form>
	</div>
</div>
	<div class="ecenter" style="padding:0;">
		<table width="100%" class="datatab">
			<thead class="tabhead">
			  <tr>
				<th>序号</th>
				<th>学员名称</th>
				<th>课件名称</th>
				<th>学习时间</th>
				<th>操作</th>
			  </tr>
			 </thead>
			 
			 <tbody>
			
                         <?php if(empty($notes)) { ?>
			 	<tr><td colspan="5" align="center">目前没有笔记记录</td></tr>

                         <?php } else { ?>
                                 <?php foreach($notes as $key=>$note) { ?>
				 	<tr>
				  	<td><?= $key + 1 ?></td>
				  	<td style="color: #3366cc;"><?= $note['username'] ?></td>
					<td style="color: #3366cc;"><a style="cursor: pointer;" onclick="freeplay('<?= $note['cwsource']?>','<?= $note['cwid'] ?>','<?= str_replace("'"," ",$note['title']) ?>',0,<?= $note['noteid']?>)"><?= $note['title'] ?></a></td>
					<td><?= date('Y-m-d H:i:s',$note['dateline']) ?></td>
					<td><a style="cursor: pointer;" onclick="freeplay('<?= $note['cwsource']?>','<?= $note['cwid'] ?>','<?= str_replace("'"," ",$note['title']) ?>',0,<?= $note['noteid']?>)">批阅笔记</a></td>
				  </tr>
                                 <?php } ?>
                         <?php } ?>
			  </tbody>
		</table>
		
	</div>
	<?= $pagestr ?>
	</div>
<script type="text/javascript">
document.onkeydown=function(event) 
{ 
	e = event ? event :(window.event ? window.event : null); 
	if(e.keyCode==13){ 
		$("#ser").click();
		e.returnValue = false;
	} 
}
function ser(){
	var url = '<?= geturl('troomv2/notes') ?>';
  	var param = $("#serform").serialize();
        url = url + "?" + param;
	window.location.href=url;
}
</script>
<?php $this->display('common/player'); ?>
<?php $this->display('troomv2/page_footer'); ?>