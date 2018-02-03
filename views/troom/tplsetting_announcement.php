<?php $this->display('troom/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<div class="ter_tit">
当前位置 > 公告管理</div>
<div class="lefrig">
<?php $this->display('troom/tplsetting_menu'); ?>
<div class="annotate" style="color:#888888; margin-left: 20px;">在此页面中,您可以管理教室平台下面的公告，您可以进行添加、修改、删除等操作。</div>
<div class="flopadt">
<a class="hongbtn jiabgbtn" href="<?= geturl('troom/tplsetting/announcement/add') ?>" >添加公告</a></div>
<table width="100%" class="datatab">
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
			<a class="workBtn" href="<?= geturl('troom/tplsetting/announcement/edit-0-0-0-'.$send['infoid'])?>" >修改</a>
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
			url:"<?= geturl('troom/tplsetting/delsend')?>",
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
<?php $this->display('troom/page_footer'); ?>