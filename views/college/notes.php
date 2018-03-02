<?php $this->display('college/page_header'); ?>
	<div class="ter_tit">
	当前位置 > 我的笔记
<div class="diles">
	<?php
		$domain = $this->uri->uri_domain();
		//测试用
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
	<div >
		
		<table width="100%" class="datatab" style="border:none;">
			<thead class="tabhead">
			  <tr>
				<th width="20%">序号</th>
				<th width="40%">课件名称</th>
				<th width="30%">学习时间</th>
				<th width="10%">操作</th>
			  </tr>
			 </thead>
			 
			 <tbody>
			 <?php if(empty($notes)) {?>
			
			 	<tr><td colspan="4" align="center">
                        <?=nocontent()?>
                    </td>
                </tr>
			<?php } else { ?>
			 
				 <?php foreach($notes as $nkey=>$note) { ?>
				 <?php $arr = explode('.',$note['cwurl']);
						$type = $arr[count($arr)-1]; 
						if($type != 'flv' && $note['ism3u8'] == 1)
							$type = 'flv';
						if($type == 'mp3')
							$type = 'flv';
				?>
				 	<tr>
				  	<td><?= $nkey + 1 ?></td>
					<?php if($type == 'flv'){ ?>
					<td style="color: #3366cc;"><a style="cursor: pointer;" target="_blank" href="mycourse/<?= $note['cwid']?>.html#notes"><?= $note['title'] ?></a></td>
					<?php }else{ ?>
					<?php if($domain == 'bndx'){ ?>
					<td style="color: #3366cc;"><a style="cursor: pointer;" target="_blank" href="/myroom/mycourse/<?= $note['cwid']?>.html#notes"><?= $note['title'] ?></a></td>
					<?php }else{ ?>
					<td style="color: #3366cc;"><a style="cursor: pointer;" href="/myroom/mycourse/<?= $note['cwid']?>.html"><?= $note['title'] ?></a></td>
					<?php } ?>
					<?php } ?>
					
					<?php if($type == 'flv'){ ?>
					<td><?= date('Y-m-d H:i:s',$note['fdateline']) ?></td>
					<td><a class="workBtn" style="cursor: pointer;" target="_blank" href="mycourse/<?= $note['cwid']?>.html#notes">查看</a></td>
					<?php }else{ ?>
					<td><?= $domain == 'bndx' ? date('Y-m-d H:i:s',$note['fdateline']) : date('Y-m-d H:i:s',$note['dateline']) ?></td>
					<?php if($domain == 'bndx'){ ?>
					<td><a class="workBtn" style="cursor: pointer;" target="_blank" href="/myroom/mycourse/<?= $note['cwid']?>.html#notes">查看</a></td>
					<?php }else{ ?>
					<td><a class="workBtn" style="cursor: pointer;" href="/myroom/mycourse/<?= $note['cwid']?>.html">查看</a></td>	
					<?php } ?>					
					<?php } ?>
				  </tr>
				  <?php } ?>
				<?php } ?>
			  </tbody>
		</table>
		
	</div>
	<?= $pagestr ?>
</div>
<style>
.lefrig a.workBtn{ width:60px; height:27px; line-height:26px;}
</style>
<script type="text/javascript">
var searchText = "请输入您要搜索笔记";
$(function(){
	initsearch("uname",searchText);
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
	if(uname==searchText){
		uname = "";
	}
	var url="<?= geturl('myroom/notes')?>?q="+uname;
	window.location.href=url;
}
</script>

<?php $this->display('myroom/player'); ?>
<?php $this->display('myroom/page_footer'); ?>