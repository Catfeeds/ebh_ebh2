<?php $this->display('aroomv2/page_header'); ?>
<!--<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css?version=20150518001" rel="stylesheet" type="text/css" />-->
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/upload.js"></script>
<link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" /> 
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<style type="text/css">
body{font-family:tahoma,verdana,arial;line-height:15px;color:#666666;}
strong{font-size:12px;}
aink{color:#0066CC;}
a:hover{color:#FF6600;}
aisited{color:#003366;}
a:active{color:#9DCC00;}
</style>

<div class="ter_tit">
当前位置 > <a href="/aroomv2/information/advertisement.html">广告管理</a> > 修改广告</div>
<div class="lefrig" style="border:solid 1px #cdcdcd;background:#fff;float:left;margin-top:15px;width:786px;">

<div id='atsrc' style="display: none;"></div>
<br/>      
<form id="upform">
<input type="hidden" name="action" value="advertisement" />
<input type="hidden" name="op" value="edit" />	
<input type="hidden" name="itemid" value="<?=$ad['itemid']?>" />
<table class="addteacher_tab" width="100%" border="0" cellspacing="0" cellpadding="0" style=" border:none;">
  <tr>
<th width=100 style="text-align: right;"><span>广告标题：</span></th>
<td colspan="3">
<input onblur="subjs($(this).val())" style="padding-left: 5px;float:left;" class="uipt w295" maxlength="50" name="subject" id="subject" type="text" value="<?=$ad['subject']?>" >
<div style="margin-top:10px;float: left;width: 500px;"><span class="ts2" id="su" style="color:#999999;padding-left:2px;">请输广告标题,最少2个字。</span></div>
</td>
  </tr>
  <tr>
<th><label>广告分类：</label></th>

<td >
<select name="catid" id="catid" onchange="fenlei($(this).val())">
<option selected="selected" value="0">选择广告分类</option>
<option value="256" <?php if($ad['catid']==256){echo 'selected=selected';}?>>中央赞助广告</option>
<option value="258" <?php if($ad['catid']==258){echo 'selected=selected';}?>>顶部焦点广告</option>

</select>

<div style="margin-top:10px;"><span class="ts2" id="pindao" style="color:#999999;padding-left:5px;">顶部焦点广告为顶部最上方长条广告，中央赞助广告为中部图片。</span></div>
</td>
 </tr>
    <tr>
  <th><label>广告图片：</label></th>
<td>
<div>
<?php
  if(!empty($ad['thumb'])){?>
  <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.min.js"></script>
  
    <a class="sn" id="a" href="<?=$ad['thumb']?>">
    <img id="imageid" class="imagewidth" style="height:100px;width:588px;" src="<?=$ad['thumb']?>">
    </a>
    <script>$("#a").lightBox();</script>
  <?php }?>
  <?php
    if(empty($ad['thumb'])){
      $Upcontrol->upcontrol('thumb',1,null,'pic');
    }else{
      $Upcontrol->upcontrol('thumb',1,array('upfilepath'=>$ad['thumb']),'pic');
    }
  ?>
</div>
</td>
</tr>

  <tr>
 <th ></th>
<td colspan="2">
<div><label style="color:#999" id="guang">仅支持JPG、GIF、PNG，且文件小于5M，建议顶部焦点广告使用&nbsp;<span style="color:red;">960*139</span>&nbsp;像素的图片，中央赞助广告使用&nbsp;<span style="color:red;">478*240</span>&nbsp;像素的图片。</label></div>
</td>
  </tr>
  <tr>
<th width=100 style="text-align: right;"><span>广告链接：</span></th>
<td >
<input style="padding-left: 5px;float:left;" class="uipt w295" name="itemurl" id="itemurl" type="text" value="<?=$ad['itemurl']?>"  maxlength="100" >
<div style="margin-top:10px;float: left;width: 638px;"><span class="ts2" id="wurl" style="color:#999999;padding-left:2px;">此为广告链接，用户点击此广告图片就会跳转到您填写的链接，</span></br><span class="ts2" id="wurl" style="color:#999999;padding-left:2px;">如：您填写（http://www.ebanhui.com/），那么用户点击就会跳转到e板会首页，如果您不填写，那么默认为没有链接。</span></div>
</td>
  </tr>
<tr>
<td width="100"><span style="float:right;margin-right:1px;" >广告状态：</span></td>
<!--  -->
<td><input type="radio" name="folder" value="1"  <?php if($ad['folder']==1){echo 'checked=checked';}?> />禁用
<input type="radio" name="folder" value="2"    <?php if($ad['folder']==2){echo 'checked=checked';}?> />启用</td>
<tr>
<td></td>
<td>	<div><label style="color:#999" id="guang">请选择广告状态，如果您选择禁用，将不在首页平台简介、师资团队、动态资讯等处显示。</label></div></td>
</tr>
</tr>
  <tr>
  	<th></th>
<td colspan="3"><input id="savebtn" class="lanbtn" name="" style="cursor:pointer;margin-right:10px;" value="提交" type="button" />
<input class="lanbtn" name="" style="cursor:pointer;" value="返回" type="button" onclick="javascript:history.go(-1)"/></td>
  </tr>
 </table>
 </form>
</div>
<div id="dialog"></div> 
</div>
<script type="text/javascript">
<!--
var subje = false;
var guangg = false;
function checkansilen(inputString){
return inputString.replace(/[\u0391-\uFFE5]/g,'**').length;
}

function subjs(subject){
if(subject == "" || checkansilen(subject)<4){
$("#su").html("请输广告标题,最少2个字。");
$("#su").css('color','red');
subje = false;
}
else{
$("#su").html("请输广告标题,最少2个字。");
$("#su").css('color','#999999');
subje = true;
}
}

function fenlei(catname){
if(catname == 0){
$("#pindao").html("请选择广告分类。");
$("#pindao").css('color','red');
guangg = false;
}
else{
$("#pindao").html("顶部焦点广告为顶部最上方长条广告，中央赞助广告为中部图片。");
$("#pindao").css('color','#999999');
guangg = true;
}
}

function submit_check(){
subjs($("#subject").val());
fenlei($("#catid").val());
if(!(subje && guangg )){
return false;
}else{return true;}
}
//-->
$(function(){
	$("div.tab_menu ul li:eq(2)").attr('class','workcurrent');
});

$("#savebtn").click(function(){
      if(submit_check()) {
        var url="<?= geturl('aroomv2/information/advertisement/edit')?>";
        $.ajax({
          url:url,
          type: "POST",
          data:$("#upform").serialize(),
          dataType:"text",
          success:function(data){
            if(data == 'success') {
              $.showmessage({
                img : 'success',
                message:'修改广告成功',
                title:'修改广告',
                callback :function(){
                   document.location.href = "<?= geturl('aroomv2/information/advertisement') ?>";
                }
              });
            } else {
              $.showmessage({
                img : 'error',
                message:'修改广告失败，请稍后再试或联系管理员<br />'+data,
                title:'修改广告'
              });
            }
          }
        });
      }
    });
</script>
</body>
</html>