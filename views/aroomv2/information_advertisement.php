<?php $this->display('aroomv2/page_header'); ?>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<!--<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css?version=20150518001" rel="stylesheet" type="text/css" />-->
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />

<style>
.table tr.first th {
    background:url("http://static.ebanhui.com/ebh/tpl/aroomv2/images/trbj.jpg") no-repeat !important;
    color: #777;
    font-size: 12px;
    font-weight: bold;
}
</style>
<div class="ter_tit">
当前位置 > <a href="/aroomv2/information.html">信息管理</a> >广告管理</div>
<div class="lefrig" style="border:solid 1px #cdcdcd;background:#fff;float:left;margin-top:15px;width:786px;">

<div class="flopadt" style="margin-top:10px;">
<a class="jiabgbtn hongbtn" href="/aroomv2/information/advertisement/add.html">添加广告</a>
</div><table width="100%" class="datatab" style="border-left:none;border-right:none;">
<thead class="tabhead table">
  <tr class="first">

<th>广告标题</th>
<th>广告链接</th>
<th>点击量</th>
<th>操作</th>
  </tr>
 </thead>
 <tbody>
 
 
<?php 
if(!empty($ads)){
	foreach($ads as $ad){?>
 <tr>
 
 <td width="47%"><a href="/aroomv2/information/advertisement/edit.html?itemid=<?=$ad["itemid"]?>" title="<?=$ad['subject']?>"><?=shortstr($ad['subject'],20)?></a></td>

<td width="25%"><a href="<?=$ad['itemurl']?>" target="_blank"><?=$ad['itemurl']?></a></td>
<td width="9%"><?=$ad['viewnum']?></td>
 <td width="16%">
<a class="workBtn" href="/aroomv2/information/advertisement/edit.html?itemid=<?=$ad["itemid"]?>">修改</a>
<input type="button" class="workBtn" onclick="deadverdiv(<?=$ad['itemid']?>,'<?=$ad['subject']?>')" style="cursor:pointer;vertical-align: middle;font-weight:100;" value="删除" /></div>
 </td>
 </tr>
 <?php }}else{?>
 <tr>
 <td colspan=5 style="text-align: center;">暂无广告</td>
 </tr>
 <?php } ?>
 </tbody>
  
</table>
<?=$show_page?>
</div>
</div>
<!--删除教研组-->
<div id="deladvertisement" class="tanchukuang" style="display:none;height:200px;">
    <div class="tishi"><span style="line-height:127px;">你确定要删除该广告吗？</span></div>
</div>

<script type="text/javascript">
<!--
//删除
//删除
function deadverdiv(itemid,subject){
	var button = new xButton();
	button.add({
		value:"确定",
		callback:function(){
			delgroup(itemid,subject);
			H.get('deladvertisement').exec('close');
			return false;
		},
		autofocus:true
	});

	button.add({
		value:"取消",
		callback:function(){
			// location.reload();
			H.get('deladvertisement').exec('close');
			return false;
		}
	});

	if(!H.get('deladvertisement')){
		H.create(new P({
			id : 'deladvertisement',
			title: '删除广告',
			easy:true,
			width:420,
			padding:5,
			button:button,
			content:$('#deladvertisement')[0]
		}),'common').exec('show');
		
	}else{
		H.get('deladvertisement').exec('show');
	}

}
function delgroup(itemid,subject){
	$.ajax({
		type:'post',
		url:'<?=geturl('aroomv2/information/del')?>',
		dataType:'text',
		data:{'itemid':itemid,'op':'del','subject':subject},
		success:function(data){
			if(data=='success'){
				 $.showmessage({
						img : 'success',
						message:'广告删除成功',
						title:'删除广告',
						callback :function(){
							 document.location.reload();
						}
					});
			}else{
				$.showmessage({
						img : 'error',
						message:'删除失败，请稍后再试或联系管理员。',
						title:'删除广告'
					});
			}
		}
		
	});

}

$(function(){
	$(".sn").lightBox();
});
//-->
</script>
</body>
</html>