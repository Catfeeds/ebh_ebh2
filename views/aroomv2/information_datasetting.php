<?php $this->display('aroomv2/page_header'); ?>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<!--<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css?version=20150518001" rel="stylesheet" type="text/css" />-->
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<style>
.table tr.first th {
    background:url("http://static.ebanhui.com/ebh/tpl/aroomv2/images/trbj1.jpg") no-repeat !important;
    color: #777;
    font-size: 12px;
    font-weight: bold;
}
</style>
<div class="ter_tit">
当前位置 > <a href="<?=geturl('aroomv2/module')?>">门户配置</a> > <a href="<?= geturl('aroomv2/moduledit') ?>">模块内容编辑</a> > 公告管理</div>
<div class="lefrig" style="background:#fff;float:left;margin-top:10px;width:788px;">
<div class="flopadt" style="margin-top:10px;">
<a class="hongbtn jiabgbtn" href="<?= geturl('aroomv2/information/datasetting/add') ?>" >添加公告</a></div>
<table width="100%" class="datatab" style="border-left:none;border-right:none;">
	<thead class="tabhead table">
	  <tr class="first">
		<th>公告内容</th>
		<th>发布时间</th>
		<th>操作</th>
	  </tr>
	 </thead>
	 <tbody>
	
	 <?php if(!empty($sendlist)) { ?>
	 <?php foreach($sendlist as $send) { ?>
			 <tr>
			 <td width="74%"><p class="letygr"><?= $send['message'] ?></p></td>
			<td width="10%"><?= date('Y-m-d',$send['dateline']) ?></td>
			<td width="16%"><div class="teac_manage">
				<a class="seedayi" href="<?= geturl('aroomv2/information/datasetting/edit-0-0-0-'.$send['infoid'])?>" style="color:#ffaf28;" >修改</a>
				<input type="button" class="seedayi" onclick="showdeldata(<?= $send['infoid']?>)" value="删除" /></div>
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
<!--删除公告-->
<div id="deldata" class="tanchukuang" style="display:none;height:160px;">
    <div class="tishi" style="padding-top:20px;"><span>你确定要删除该公告吗？</span></div>
</div>
<script type="text/javascript">
<!--
//删除
function showdeldata(infoid){
	var button = new xButton();
	button.add({
		value:"确定",
		callback:function(){
			delsend(infoid);
			H.get('deldata').exec('close');
			return false;
		},
		autofocus:true
	});

	button.add({
		value:"取消",
		callback:function(){
			// location.reload();
			H.get('deldata').exec('close');
			return false;
		}
	});

	if(!H.get('deldata')){
		H.create(new P({
			id : 'deldata',
			title: '删除公告',
			easy:true,
			width:420,
			padding:5,
			button:button,
			content:$('#deldata')[0]
		}),'common').exec('show');
		
	}else{
		H.get('deldata').exec('show');
	}

}

	function delsend(infoid) {
		$.ajax({
			url:"<?= geturl('aroomv2/information/delsend')?>",
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
	}
//-->
</script>
<?php $this->display('aroomv2/page_footer'); ?>