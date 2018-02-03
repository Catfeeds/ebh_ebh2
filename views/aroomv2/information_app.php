<?php $this->display('aroomv2/page_header'); ?>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<!--<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css?version=20150518001" rel="stylesheet" type="text/css" />-->
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/upload.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<style>
.upprogressbox, .upfileinfo, .upprogressbar{
	width:400px;
}
.upprogressbox{
	height:55px;
	background:none;
}
.tinputs{
	border: 1px solid #eee;
	color:#666;
    height: 22px;
    line-height: 22px;
    padding: 0 5px;
    width: 128px;}
.datatab tr.first th {
    background:url("http://static.ebanhui.com/ebh/tpl/aroomv2/images/trbj1.jpg") no-repeat !important;
    color: #777;
    font-size: 12px;
    font-weight: bold;
}	
</style>
<div class="ter_tit">
当前位置 > <a href="<?=geturl('aroomv2/module')?>">门户配置</a> > <a href="/aroomv2/moduledit.html">模块内容编辑</a> >应用管理</div>
<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:788px;">

<div class="flopadt" style="margin-top:10px;">
<a href="javascript:void(0)" class="jiabgbtn hongbtn" style="margin-right:20px;" onclick="saveapp()">保存</a>
<a href="javascript:void(0)" class="jiabgbtn hongbtn" style="margin-right:10px;" onclick="addapp()">添加应用</a>
</div>
<form id="mainform" action="/aroomv2/information/saveapp.html" method="post">
<table width="100%" class="datatab" style="border-left:none;border-right:none;">
<thead class="tabhead">
	<tr class="first">
		<th>图标，大小32*32</th>
		<th>名称</th>
		<th>下载链接</th>
		<th>操作</th>
	</tr>
</thead>
<tbody>


<?php 
if(!empty($applist)){
	$Upcontrol = Ebh::app()->lib('UpcontrolLib');
	foreach($applist as $k=>$app){?>
<tr>
	<td width="57%">
	<?php 
	$Upcontrol->upcontrol('img'.$k,1,array('upfilepath'=>$app['img']),'pic');?>
	<input type="hidden" name="index[]" value="<?=$k?>">
	</td>
	<td width="18%"><input class="tinputs" name="title<?=$k?>" value="<?=$app['title']?>"></a></td>
	<td width="18%"><input class="tinputs" name="url<?=$k?>" value="<?=$app['url']?>"></td>
	<td width="7%">
		<a class="seedayi newappcancel" href="javascript:void(0)" >删除</a>
	</td>
</tr>
<?php }}else{?>
<tr class="noapp">
<td colspan=4 style="text-align: center;">暂无应用</td>
</tr>
<?php } ?>
</tbody>
 
</table>
</form>
</div>
</div>


<script type="text/javascript">
<!--
var appnum = <?=(empty($applist)?-1:$k)+1?>;


function addapp(){
	var newapp = '<tr>'
	+'<td><script type="text/javascript">var img'+appnum+'_swfu;$(document).ready(function(){var img'+appnum+'_settings = {flash_url : "http://static.ebanhui.com/ebh/flash/upload.swf",upload_url: "http://c1.ebanhui.com/uploadimage.html?uptype=pic",post_params: {"PHPSESSID" : ""},file_size_limit : "500 MB",file_types : "*.jpg;*.jpeg;*.png;*.gif",file_types_description : "图片文件",file_upload_limit : 100,file_queue_limit : 10,custom_settings : {progressTarget : "img'+appnum+'_upprogressbox",cancelButtonId : "img'+appnum+'_btnCancel"},debug: false,button_image_url: "http://static.ebanhui.com/ebh/images/TestImageNoText_65x29.png",button_width: "65",button_height: "29",button_placeholder_id: "img'+appnum+'_spanuploadbutton",button_text: \'<span class="theFont">上传</span>\',button_text_style: ".theFont { font-size: 14; }",button_text_left_padding: 12,button_text_top_padding: 3,file_queued_handler : fileQueued,file_queue_error_handler : fileQueueError,file_dialog_complete_handler : fileDialogComplete,upload_start_handler : uploadStart,upload_progress_handler : uploadProgress,upload_error_handler : uploadError,upload_success_handler : uploadSuccess,upload_complete_handler : uploadComplete,queue_complete_handler : queueComplete};img'+appnum+'_swfu = new SWFUpload(img'+appnum+'_settings);});;</script><div id="img'+appnum+'_upprogressbox" class="upprogressbox" ><div class="upfileinfo"><span class="upstatusinfo"><img src="http://static.ebanhui.com/ebh/images/upload.gif"/></span><span id="img'+appnum+'_spanUpfilename" class="spanUpfilename">	</span><span id="img'+appnum+'_spanUppercent"></span><span id="img'+appnum+'_spanShowButton"><a href="" target="_blank">&nbsp;查看</a></span><span><a href="javascript:" onclick="deleteUpload(\'img'+appnum+'\')">&nbsp;删除</a></span></div><div class="upprogressbar"><span class="upprogressstext">上传总进度：</span><span id="img'+appnum+'_spanUppercentBox" class="spanUppercentBox"><span id="img'+appnum+'_spanUpShowPercent" class="spanUpShowPercent"></span></span><span id="img'+appnum+'_spanUppercentinfo"  class="spanUppercentinfo">0%</span><span id="img'+appnum+'_spanUpInfo" class="spanUpInfo"></span></div></div><div><span id="img'+appnum+'_spanuploadbutton"></span></div><input type="hidden" id="img'+appnum+'[upfilename]" name="img'+appnum+'[upfilename]" value=""/><input type="hidden" id="img'+appnum+'[upfilepath]" name="img'+appnum+'[upfilepath]" value=""/><input type="hidden" id="img'+appnum+'[upfilesize]" name="img'+appnum+'[upfilesize]" value=""/>	<input type="hidden" name="index[]" value="'+appnum+'">'
	+'<td><input class="tinputs" name="title'+appnum+'"></td>'
	+'<td><input class="tinputs" name="url'+appnum+'"></td>'
	+'<td><a class="seedayi newappcancel" href="javascript:void(0)">删除</a></td>'
	+'</tr>';
	// console.log(newapp);
	$('.datatab').append(newapp);
	appnum++;
	top.resetmain();
	$('.noapp').remove();
}

$('.newappcancel').live('click',function(){
	$(this).parents('tr').remove();
});

function saveapp(){
	$.showmessage({
		img : 'success',
		message:'保存成功',
		title:'保存',
		callback :function(){
			$('#mainform').submit();
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