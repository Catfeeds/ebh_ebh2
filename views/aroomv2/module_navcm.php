<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?= empty($subtitle) ? $this->get_title() : $subtitle.'-'. $this->get_title() ?></title>
<meta name="keywords" content="<?= empty($subkeywords) ? $this->get_keywords() : $subkeywords ?>" />
<meta name="description" content="<?= empty($subdescription) ? $this->get_description() : $subdescription?>" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />

<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css<?=getv()?>"/>  
</head>

<style>
table .biaoti{ font-size:14px; color:#333; font-weight:bold;}
.submitBtn{ padding:15px 20px 0 0;}
.edui-container{}
</style>

<body>
<div style="width:980px; margin:0 auto;">
<div class="ter_tit" style="width:970px;">
当前位置 > 模块管理 > 设置自定义富文本</div>
<div class="lefrig" style="border:solid 1px #cdcdcd;background:#fff;float:left;margin-top:15px;width:978px;">
<div id='atsrc' style="display: none;"></div>
<br/> 

<form id="upform">
<input type="hidden" name="action" value="information" />
<input type="hidden" name="op" value="add" />
<table  width="100%" style="border:none;margin-top:15px;">


<tr>
<td colspan=2 >
	<div style=" margin-bottom:10px; margin-top:5px;margin-left:21px;"> 
	<?php $editor = Ebh::app()->lib('UMEditor');
	$editor->createEditor('cmeditor',"940px",'700px',$custommessage);?></div>
       </td>
</tr>
</table>
<div class="clear"></div>

<div class="submitBtn" style="width:185px;">
<input id="savebtn" class="huangbtn marrig" type="button" value="保存" name="">
<a class="lanbtn" onclick="window.close();" >关闭</a>
</div>
</form>
</div>
</div>
<script type="text/javascript">


</script>
<script type="text/javascript">


$("#savebtn").click(function(){
	var index = '<?=$this->input->get('index')?>';
	var url="<?= geturl('aroomv2/module/savecustommessage')?>";
	$.ajax({
		url:url,
		type: "POST",
		data:{'custommessage':UM.getEditor('cmeditor').getContent(),'index':index},
		success:function(data){
			$.showmessage({
				img : 'success',
				message:'保存成功',
				title:'自定义文本',
				callback :function(){
					var opened=parent.window.open(' ','_self');
					opened.close();
				}
			});
			
          }
        });
      
    });
</script>
</body>
</html>