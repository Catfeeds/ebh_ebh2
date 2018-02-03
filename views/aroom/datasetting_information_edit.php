<?php $this->display('troom/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<div class="ter_tit">
当前位置 > <a href="/aroom/setting/datasetting/information.html">资讯管理</a> > 发布资讯</div>
<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:788px;">
<?php $this->display('aroom/datasetting_menu'); ?>
<div id='atsrc' style="display: none;"></div>
<br/> 
<div class="work_menu" style="margin-top: -18px;">
<ul>
<li ><a href="/aroom/datasetting/information.html"><span>资讯列表</span></a></li>
<li class="workcurrent"><a href="/aroom/datasetting/information/add.html"><span>发布资讯</span></a></li>
</ul>
</div>

<form id="upform">
<input type="hidden" name="action" value="information" />
<input type="hidden" name="crid" value="<?=$information['crid']?>" />
<input type="hidden" name="op" value="edit" />
<input type="hidden" name="itemid" value="<?=$information['itemid']?>" />
<table  width="100%" style="border:none;margin-top:15px;">
<tr >
<td width="20%" style="padding_top:120px;"><span style="float:right;" >资讯标题：</span></td>
<td width="80%"><input style=" border: 1px solid #A0B5BB; height: 20px; line-height: 20px;margin-right: 5px;width: 300px; margin-bottom: -1px;" value="<?=$information['subject']?>" id="subject" name="subject" type="text" maxlength="30" onblur="subjs($(this).val())" /></td>
</tr>
<tr>
<td></td>
<td ><div style="margin-top:8px;margin-bottom:8px;"><span class="error" id="su" style="color:#999999;padding-left:5px;margin-top:10px;">请输入资讯标题,最少两个字。</span></div></td>
</tr>
<tr>
<td width="20%"><span style="float:right;" >资讯状态：</span></td>
<!--  -->
<td width="80%"><input type="radio" name="folder" value="0" <?if($information['folder']==0){echo 'CHECKED=CHECKED';}?>  />禁用
<input type="radio" name="folder" value="1"   <?if($information['folder']==1){echo 'CHECKED=CHECKED';}?>  />启用</td>
</tr>
<tr>
<td></td>
<td><div style="margin-top:8px;margin-bottom:8px;"><span style="color:#999999;padding-left:5px;">请选择资讯状态，如果您选择禁用，将不在前台动态资讯页显示。</span></div></td>
</tr>
<tr>
<td width="20%"><span style="float:right;padding-bottom:60px;" >资讯摘要：</span></td>
<td width="80%">
<textarea class="w545" id="note" name="note" rows="2" maxLength="100" style="height: 70px; width: 385px;padding:4px;float:left;" onblur="nots(this.value)" ><?=$information['note']?></textarea></td>
</tr>
<tr>
<td></td>
<td><div style="margin-top:8px;margin-bottom:8px;"><em class="error" id="no" style="color:#999999;margin-left:-12px;">请输入资讯摘要，字数控制在5-100个字之间。</em><div></td>
</tr>
<tr>
<td width="20%"><span style="float:right;padding-bottom:190px;" >资讯内容：</span></td>
<td width="80%">       
	<div><?php $editor->createEditor('message',"110%",'300px',$information['message']);?></div>
       </td>
</tr>
<tr>
<td></td>
<td><div><em class="error" id="messa" style="color:#999999;"></em></div></td>
</tr>
</table>
<div class="clear"></div>

<div class="submitBtn" style="width:185px;">
<input id="savebtn" class="huangbtn marrig" type="button" value="发布资讯" name="">
<a class="lanbtn" onclick="history.go(-1);" >返回</a>
</div>
</form>
</div>
<script type="text/javascript">

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
$("#no").html("请输入资讯摘要，字数控制在5-100个字之间。");
$("#no").css('color','red');
not = false;
}
else{
$("#no").html("请输入资讯摘要，字数控制在5-100个字之间。");
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
if(num.length>100){
document.getElementById("note").value = document.getElementById("note").value.substring(0, 100);
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
        var url="<?= geturl('aroom/datasetting/information/edit')?>";
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
                   document.location.href = "<?= geturl('aroom/datasetting/information') ?>";
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
</script>
</body>
</html>