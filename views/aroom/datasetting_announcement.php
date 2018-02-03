<?php $this->display('troom/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<div class="ter_tit">
当前位置 > 公告管理</div>
<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:788px;">
<?php $this->display('aroom/datasetting_menu'); ?>
<div class="flopadt">
<a class="hongbtn jiabgbtn" href="<?= geturl('aroom/datasetting/announcement/add') ?>" >添加公告</a></div>
<table width="100%" class="datatab" style="border-left:none;border-right:none;">
	<thead class="tabhead">
	  <tr>
		<th>公告内容</th>
		<th>发布时间</th>
		<th>操作</th>
	  </tr>
	 </thead>
	 <tbody>
	
	 <?php if(!empty($sendlist)) { ?>
	 <?php foreach($sendlist as $send) { ?>
			 <tr>
			 <td width="74%"><?= $send['message'] ?></td>
			<td width="10%"><?= date('Y-m-d',$send['dateline']) ?></td>
			 <td width="16%"><div class="teac_manage">
			<a class="workBtn" href="<?= geturl('aroom/datasetting/announcement/edit-0-0-0-'.$send['infoid'])?>" >修改</a>
						<input type="button" class="workBtn" onclick="return delsend(<?= $send['infoid']?>)" value="删除" /></div>
			 </td>
			 </tr>
	  <?php } ?>
	  </tbody>
	  <?php } else { ?>
	  <tr><td colspan="4" align="center">暂 无 数 据</td></tr>
	  <?php } ?>
</table>
<div style="margin-top: 10px;">
<?= $pagestr ?>
</div>
</div>
<script type="text/javascript">
<!--
	function delsend(infoid) {
	$.confirm("您确定要删除这条公告吗？",function(){

		$.ajax({
			url:"<?= geturl('aroom/datasetting/delsend')?>",
			type:'post',
			data:{'infoid':infoid},
			dataType:'text',
			success:function(data){
				if(data=='success'){
					 $.showmessage({
                            img : 'success',
                            message:'公告删除成功',
                            title:'删除公告',
                            callback :function(){
                                 document.location.reload();
                            }
                        });
				}else{
					$.showmessage({
                            img : 'error',
                            message:'删除失败，请稍后再试或联系管理员。',
                            title:'删除公告'
                        });
				}
			}
		});
	});
}
//-->
</script>
<?php $this->display('aroom/page_footer'); ?>