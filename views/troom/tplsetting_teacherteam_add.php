<?php $this->display('troom/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/upload.js"></script>
<link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" /> 
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<div class="ter_tit">
当前位置 > <a href="/troom/tplsetting/teacherteam.html">师资团队</a> > 添加教师</div>
<div class="lefrig">
<?php $this->display('troom/tplsetting_menu'); ?>
<div id='atsrc' style="display: none;"></div>
				<div class="annotate" style="color:#888888; margin-left: 20px;">在此页面中，您可以填写教师姓名、上传教师头像、编写教师介绍。</div>
				<br/>      
		<form id="upform">
			<input type="hidden" name="action" value="teachertheam" />
			<input type="hidden" name="op" value="add" />
			<table class="addteacher_tab" width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<th width=100><label>教师姓名：</label></th>
				<td colspan="3">
					<input style="padding-left: 5px;" class="uipt w295" maxlength="25" name="subject" id="subject" type="text" value=""  maxlength="30" onblur="subjs($(this).val())">
					<div style="margin-top:10px;"><span class="ts2" id="su" style="color:#999999;padding-left:5px;">请输教师姓名,最少2个字。</span></div>
				</td>
			  </tr>
		
		    <tr>
			  <th><label>教师头像：</label></th>
				<td colspan="2">
					<div>
					
					<?php
					    $Upcontrol->upcontrol('thumb',1,array(),'thteam');
					?>
					</div>
				</td>
			</tr>
	
			  <tr>
				 <th ></th>
				<td colspan="2">
					<label style="color:#999" id="ttou">仅支持JPG、GIF、PNG，且文件小于5M，建议使用94*134像素的图片。</label>
				</td>
			  </tr>
			  <tr>
				<th><label>教师介绍：</label></th>
				<td colspan="3">
					<textarea style="padding-left: 5px;" name="note" id="note" cols="80" rows="5" value="" onblur="nots(this.value)"></textarea>
					<p style="line-height:22px;color:#999999;padding-left:5px;" id="no" >请输入教师的个人信息，字数控制在5-500个字之间。</p>
				</td>
			  </tr>
			  <tr>
			  	<th></th>
				<td colspan="3"><input id="savebtn" class="huangbtn marrig" name="" value="提交" type="button" />
				<input class="lanbtn" name="" value="返回" type="button" onclick="history.go(-1);"/></td>
			  </tr>
			 </table>
		 </form>
	</div>

<script type="text/javascript">
<!--
var subje = false;
var not = false;
var toux = false;
function checkansilen(inputString){
	return inputString.replace(/[\u0391-\uFFE5]/g,'**').length;
}
function touxiang(txtpath){
	if(txtpath == ""){
		$("#ttou").html("请您点击上传图片按钮来上传您的广告图片。");
		$("#ttou").css('color','red');
		toux = false;
	}
	else{
		$("#ttou").html("仅支持JPG、GIF、PNG，且文件小于5M，建议使用94*134像素的图片。");
		$("#ttou").css('color','#999999');
		toux = true;
	}
}
function subjs(subject){
	if(subject == "" || checkansilen(subject)<4){
		$("#su").html("请输教师姓名,最少2个字。");
		$("#su").css('color','red');
		subje = false;
	}
	else{
		$("#su").html("请输教师姓名,最少2个字。");
		$("#su").css('color','#999999');
		subje = true;
	}
}
function nots(note){
	if(note == "" || checkansilen(note)<10){
		$("#no").html("请输入教师的个人信息，字数控制在5-500个字之间。");
		$("#no").css('color','red');
		not = false;
	}
	else{
		$("#no").html("请输入教师的个人信息，字数控制在5-500个字之间。");
		$("#no").css('color','#999999');
		not = true;
	}
}


function submit_check(){
	subjs($("#subject").val());
	nots($("#note").val());
	touxiang($("#txtpath").val());
	if(!(subje && not && toux)){
		return false;
	}else{return true;}
}
//-->
</script>
<script type="text/javascript">
<!--
$(function(){
		$("#note").keyup(function(){
			var num =$("#note").val();
			if(num.length>1000){
			document.getElementById("note").value = document.getElementById("note").value.substring(0, 1000);
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
        var url="<?= geturl('troom/tplsetting/teacherteam/add')?>";
        $.ajax({
          url:url,
          type: "POST",
          data:$("#upform").serialize(),
          dataType:"text",
          success:function(data){
            if(data == 'success') {
              $.showmessage({
                img : 'success',
                message:'添加师资团队成功',
                title:'添加师资团队',
                callback :function(){
                   document.location.href = "<?= geturl('troom/tplsetting/teacherteam') ?>";
                }
              });
            } else {
              $.showmessage({
                img : 'error',
                message:'添加师资团队失败，请稍后再试或联系管理员<br />'+data,
                title:'添加师资团队'
              });
            }
          }
        });
      }
    });
</script>
<div id="dialog"></div> 