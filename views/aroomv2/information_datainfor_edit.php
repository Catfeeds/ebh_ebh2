<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php $systemsetting = Ebh::app()->room->getSystemSetting(); ?>
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<title><?= empty($subtitle) ? $this->get_title() : $subtitle.'-'. $this->get_title() ?></title>
<meta name="keywords" content="<?= empty($subkeywords) ? $this->get_keywords() : $subkeywords ?>" />
<meta name="description" content="<?= empty($subdescription) ? $this->get_description() : $subdescription?>" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common2.js?version=20151103001"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js?v=20150731"></script>

<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/upload.js"></script>
<link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css<?=getv()?>"/> 
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xPhoto.js?v=3"></script>
<?php if($roominfo['template'] == 'plate'){ ?><script type="text/javascript" src="http://static.ebanhui.com/ebh/js/UploadImageAndThumb.js"></script><?php } ?>
<style>
table .biaoti{ font-size:14px; color:#333; font-weight:bold;}
.submitBtn{ padding:15px 20px 0 0;}
.edui-container{}
</style>
<div style="width:980px; margin:0 auto;">
<div class="ter_tit" style="width:970px;">
当前位置 > <a href="/aroomv2/information/datainfor.html">资讯管理</a> > 修改资讯</div>
<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:980px;">

<div id='atsrc' style="display: none;"></div>
<br/> 

<form id="upform">
<input type="hidden" name="action" value="information" />
<input type="hidden" name="crid" value="<?=$information['crid']?>" />
<input type="hidden" name="op" value="edit" />
<input type="hidden" name="itemid" value="<?=$information['itemid']?>" />
<input type="hidden" name="thumb" value="<?=$information['thumb']?>" id="thumb"/>
<table  width="100%" style="border:none;margin-top:15px;">
<tr >
<td width="98" style="padding_top:120px;"><span class="biaoti" style="float:right;" >资讯标题：</span></td>
<td width="880"><div><span class="error" id="su" style="color:#999999;padding-left:5px;margin-top:10px;">请输入资讯标题,最少两个字。</span></div></td>
</tr>
<tr>
<td colspan=2><input style=" border: 1px solid #A0B5BB; height: 24px; line-height: 24px;margin-left: 21px;width: 930px; margin-bottom: 10px; margin-top:5px; padding-left:5px;" value="<?=$information['subject']?>" id="subject" name="subject" type="text" maxlength="30" onblur="subjs($(this).val())" /></td>
</tr>
<tr>
<td ><span class="biaoti" style="float:right;" >资讯状态：</span></td>
<!--  -->
<td ><div><span style="color:#999999;padding-left:5px;">请选择资讯状态，如果您选择禁用，将不在前台动态资讯页显示。</span></div></td>
</tr>
<tr>
<td></td>
<td><div style="margin-top:5px; margin-bottom:10px;"><label><input type="radio" name="status" value="0" <?php if($information['status']==0){echo 'checked="checked"';}?> />禁用</label>
<label><input type="radio" name="status" value="1" <?php if($information['status']==1){echo 'checked="checked"';}?>  />启用</div></td></label>
</tr>
<?php if($roominfo['template'] == 'drag' || $roominfo['template'] == 'plate'){?>
<tr>
<td><span style="float:right;" class="biaoti">资讯分类：</span></td>
<!--  -->
<td><div><span style="color:#999999;">请选择资讯分类，对应首页导航。</span></div></td>
</tr>
<tr>
<td ></td>
<td >
<div style="margin-top:5px; margin-bottom:10px;">
<select name="navcode" style="font-size:13px;padding:5px;">
<?php
if(empty($navigatorlist)){
	$navigatorlist[] = array('code'=>'news','mame'=>'新闻资讯');
}
$navigatorlist[] = array('code'=>'deleted','name'=>'已删除分类');
	foreach($navigatorlist as $nav){
	?>
		<option value="<?=$nav['code']?>" <?=($nav['code']==$information['navcode'])?'SELECTED="true"':''?>><?=empty($nav['nickname'])?$nav['name']:$nav['nickname']?></option>
		<?php if(!empty($nav['subnav'])){
				foreach($nav['subnav'] as $subnav){ ?>
				<option value="<?=$subnav['subcode']?>" <?=$information['navcode']==$subnav['subcode']?'selected="true"':''?>><?=$subnav['subnickname']?></option>
		<?php
				}
			}
		}?>
</select>
</div></td>
</tr>
<?php }?>

<tr>
	<td ><span style="float:right;" class="biaoti">资讯图片：</span></td>
	<td >
		<div><label style="color:#999" id="guang">限JPG、PNG、GIF格式，图片清晰，单张图片小于1M，尺寸<?php if ($roominfo['template'] == 'plate') { ?>130px*78px<?php } else { ?>130px*98px<?php } ?></label></div>
	</td>
</tr>
<tr>
	<td></td>
	<?php
		$style = !empty($information['thumb'])?'style="background:url('.$this->_show_plate_news_img($information['thumb']).');"':'';
	?>
	<td>
		<?php if ($roominfo['template'] == 'plate') { ?>
			<?php if(empty($information['thumb'])){?>
				<a title="点我上传资讯图片" href="javascript:void(0)"  onclick="uploadlogo()" class="jnlihrey" <?=$style?>><img style="float:left;" id="showclog" width="130" height="78" src="http://static.ebanhui.com/ebh/tpl/newschoolindex/images/news_viewholder.jpg?v=1"/></a>
			<?php }else{?>
				<a title="点我重新上传资讯图片" href="javascript:void(0)"  onclick="uploadlogo()" class="jnlihrey" <?=$style?>><img style="float:left;" id="showclog" width="130" height="78" src="<?=$this->_show_plate_news_img($information['thumb'])?>"/></a>
			<?php }?>
		<?php } else { ?>
			<?php if(empty($information['thumb'])){?>
				<a title="点我上传资讯图片" href="javascript:void(0)"  onclick="uploadlogo()" class="jnlihrey" <?=$style?>><img style="float:left;" id="showclog" width="130" height="98" src="http://static.ebanhui.com/ebh/tpl/default/images/lstyjast.jpg"/></a>
			<?php }else{?>
				<a title="点我重新上传资讯图片" href="javascript:void(0)"  onclick="uploadlogo()" class="jnlihrey" <?=$style?>><img style="float:left;" id="showclog" width="130" height="98" src="<?=$this->_show_plate_news_img($information['thumb'])?>"/></a>
			<?php }?>
		<?php } ?>
	</td>
 </tr>
<tr>
<td ><span class="biaoti" style="float:right;" >资讯摘要：</span></td>
<td >
<div ><em class="error" id="no" style="color:#999999;">请输入资讯摘要，字数控制在5-200个字之间。</em><div>
</td>
</tr>
<tr>
<td colspan=2><textarea class="w545" id="note" name="note" rows="2" maxLength="200" style="height: 70px; width: 930px;padding:4px;float:left; margin-left:21px; margin-bottom:10px; margin-top:5px;" onblur="nots(this.value)" ><?=$information['note']?></textarea></td>
</tr>
<tr>
<td ><span class="biaoti" style="float:right;" >资讯内容：</span></td>
<td >
	<div><em class="error" id="messa" style="color:#999999;"></em></div>	
    </td>
</tr>
<tr>
<td colspan=2><div style="margin-bottom:10px; margin-top:5px;margin-left:21px;"><?php $editor->createEditor('message',"940px",'300px',$information['message']);?></div></td>
</tr>
</table>
<div class="clear"></div>

<div class="submitBtn" style="width:185px;">
<input id="savebtn" class="huangbtn marrig" type="button" value="修改资讯" name="">
<a class="lanbtn" onclick="window.close();" >关闭</a>
</div>
</form>
</div>
</div>
	<?php if ($roominfo['template'] == 'plate') {
		$config = Ebh::app()->getConfig()->load('upconfig');
		$baseurl = $config['pic']['showpath'];
	} else {
		$baseurl = '';
	}
	?>
<script type="text/javascript">
	var baseUrl = '<?=$baseurl?>';
var subje = false;
var not = false;
var mese = false;
function checkansilen(inputString){
return inputString.replace(/[\u0391-\uFFE5]/g,'**').length;
}

function subjs(subject){
if(subject == "" || checkansilen(subject)<4){
$("#su").html("请输入资讯标题,最少两个字。");
$("#su").css('color','red');
subje = false;
}
else{
$("#su").html("请输入资讯标题,最少两个字。");
$("#su").css('color','#999999');
subje = true;
}
}
function nots(note){
if(note == "" || checkansilen(note)<10){
$("#no").html("请输入资讯摘要，字数控制在5-200个字之间。");
$("#no").css('color','red');
not = false;
}
else{
$("#no").html("请输入资讯摘要，字数控制在5-200个字之间。");
$("#no").css('color','#999999');
not = true;
}
}
function mess(){
var message = ue.getContent();
if(message == ""){
$("#messa").html("请输入资讯内容。");
$("#messa").css('color','red');
mese = false;
}
else{
$("#messa").html("");
mese = true;
}
}
function submit_check(){
subjs($("#subject").val());
nots($("#note").val());
mess($("#message").val());
if(!(subje && not && mese )){
return false;
}else{return true;}
}
</script>
<script type="text/javascript">
<!--
$(function(){
$("#note").keyup(function(){
var num =$("#note").val();
if(num.length>200){
document.getElementById("note").value = document.getElementById("note").value.substring(0, 200);
}
return false;
})
})
//-->
$(function(){
	$("div.tab_menu ul li:eq(1)").attr('class','workcurrent');
});
$("#savebtn").click(function(){
      if(submit_check()) {
        var url="<?= geturl('aroomv2/information/datainfor/edit')?>";
        $.ajax({
          url:url,
          type: "POST",
          data:$("#upform").serialize(),
          dataType:"text",
          success:function(data){
            if(data == 'success') {
              $.showmessage({
                img : 'success',
                message:'编辑资讯成功',
                title:'编辑资讯',
                callback :function(){
					// document.location.href = "<?= geturl('aroomv2/information/datainfor') ?>";
					var opened=parent.window.open(' ','_self');
					opened.close();
                }
              });
            } else {
              $.showmessage({
                img : 'error',
                message:'编辑资讯失败，请稍后再试或联系管理员<br />'+data,
                title:'编辑资讯'
              });
            }
          }
        });
      }
    });

//准备一个xPhoto实例(用时调用)
function preparexPhoto(id,callback,initpicurl,upurl){
	var upurl = 'http://up.ebh.net/imghandler.html?type=pic&subtype=datainforpic';
	window.xphoto = new xPhoto({
		id:id,
		title:'资讯上传',
		callback:callback,
		initpicurl:initpicurl,
		upurl:encodeURIComponent(upurl),
		cancelcallback:function(){
			window.xphoto.doClose();
		},
		sizearr:new Array('130_98'),
		sizemsgarr:new Array('资讯尺寸为130*98')
	});
	window.xphoto.renderDialog();
}
$(function(){
	if (baseUrl) {
		//plate模板图片上传
		var upurl = 'http://up.ebh.net/uploadimageandthumb.html';
		window.xphoto = new UploadImageAndThumb({
			id:'info-photowrap',
			title:'资讯上传',
			callback: callback,
			//initpicurl:initpicurl,
			upurl:encodeURIComponent(upurl),
			cancelcallback:function(){

			},
			sizearr:new Array('320_192'),
			sizemsgarr:new Array('课程图片尺寸比例为5:3')
		});
		window.xphoto.renderDialog();
		return;
	}
	window.preparexPhoto("photouploader",callback,"<?=$information['thumb']?>");
});
function uploadlogo(){
	window.xphoto.doShow();
}
//flash消息通知处理接口(处理此函数的执行环境是父级框架,也就是说this为 parent.window)
function callback(res){
	res = $.parseJSON(res);
	if (baseUrl) {
		plateHandle(res);
		return;
	}
	msghandle(res);
};
function plateHandle(res) {
	if (!res) {
		return;
	}console.log(res);
	if (res.status != 0) {
		return;
	}
	$('#showclog').attr('src',baseUrl+res.data.thumb);
	$('a.jnlihrey').attr('title','点我重新上传');
	$("#thumb").val(res.data.url);
	window.xphoto.doClose();
}
function msghandle(res){
	if(res && res.status == 0){
		$('#showclog').attr('src',res.url);
		$('a.jnlihrey').attr('title','点我重新上传');
		$("#thumb").val(res.url);
		//$("#showlogo,#dellogo").show();
		alert("上传成功");
	}else{
		alert("上传失败");
	}
	window.xphoto.doClose();
}

//function showlogo(){
//	var src = $("#logo").val();
//	window.HTools.hShow("<img src='"+src+"'>",true);
//}
//function dellogo(){
//	$("#logo").val('');
//	$("#showlogo,#dellogo").hide();
//}

</script>
</body>
</html>