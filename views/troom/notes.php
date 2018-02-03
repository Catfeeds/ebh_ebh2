<?php $this->display('myroom/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
	<div class="ter_tit">
	当前位置 > 我的笔记
<div class="diles">
	<?php
		$q= empty($q)?'':$q;
		if(!empty($q)){
			$stylestr = 'style="color:#000"';
		}else{
			$stylestr = "";
		}
	?>
	<input name="uname" <?=$stylestr?> class="newsou" id="uname" value="<?=$q?>" type="text"  />
	<input onclick="ser()" id="ser" type="button" class="soulico" value="">
</div>
	</div>
	<div class="lefrig" style="margin-top:10px;">
	<div style="margin-top:15px;">
		
		<table width="100%" class="datatab">
			<thead class="tabhead">
			  <tr>
				<th>序号</th>
				<th>课件名称</th>
				<th>学习时间</th>
				<th>操作</th>
			  </tr>
			 </thead>
			 
			 <tbody>
			 <?php if(empty($notes)) {?>
			
			 	<tr><td colspan="4" align="center">暂无数据信息</td></tr>
			<?php } else { ?>
			 
				 <?php foreach($notes as $nkey=>$note) { ?>
				 <?php $arr = explode('.',$note['cwurl']);
						$type = $arr[count($arr)-1]; ?>
				 	<tr>
				  	<td><?= $nkey + 1 ?></td>
					<?php if($type == 'flv'){ ?>
					<td style="color: #3366cc;"><a style="cursor: pointer;" target="_blank" href="mycourse/<?= $note['cwid']?>.html"><?= $note['title'] ?></a></td>
					<?php }else{ ?>
					<td style="color: #3366cc;"><a style="cursor: pointer;" onclick="freeplay('<?= $note['cwsource']?>','<?= $note['cwid']?>','<?= str_replace("'"," ",$note['title'])?>')"><?= $note['title'] ?></a></td>
					<?php } ?>
					
					<?php if($type == 'flv'){ ?>
					<td><?= date('Y-m-d H:i:s',$note['fdateline']) ?></td>
					<td><a class="workBtn" style="cursor: pointer;" target="_blank" href="mycourse/<?= $note['cwid']?>.html">查看</a></td>
					<?php }else{ ?>
					<td><?= date('Y-m-d H:i:s',$note['dateline']) ?></td>
					<td><a class="workBtn" style="cursor: pointer;" onclick="freeplay('<?= $note['cwsource']?>','<?= $note['cwid']?>','<?= str_replace("'"," ",$note['title'])?>')">查看</a></td>
					<?php } ?>
				  </tr>
				  <?php } ?>
				<?php } ?>
			  </tbody>
		</table>
		
	</div>
	<?= $pagestr ?>
</div>
<script type="text/javascript">
var searchText = "请输入您要搜索笔记";
$(function(){
	initsearch("title",searchText);
});
document.onkeydown=function(event) 
{ 
	e = event ? event :(window.event ? window.event : null); 
	if(e.keyCode==13){ 
		$("#ser").click();
		e.returnValue = false;
	} 
}
function ser(){
	var uname=$.trim($("#uname").val());
	var url="<?= geturl('myroom/notes')?>?q="+uname;
	window.location.href=url;
}
</script>

<?php $this->display('common/player'); ?>
<?php $this->display('myroom/page_footer'); ?>