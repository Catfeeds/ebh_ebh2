<script type="text/javascript">
 <!--
	function getsitecpurl(){
		return '#getsitecpurl()#';
	}
 //-->
 </script>
 
 <script type="text/javascript">
$(function() {
	$('.sn').lightBox();
	//$('.spdiv a').lightBox();
});
function imgcallback(url){
	$('.sn').attr('href',url);
	$("#aid").show();
	$("#imageid").show();
}

</script>

<script type="text/javascript" src="/static/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="/static/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<link type="text/css" href="/static/css/upload.css" rel="stylesheet" />	
<link type="text/css" href="/static/tpl/default/css/teacher.css" rel="stylesheet" />
<script type="text/javascript" src="/static/js/date/WdatePicker.js"></script>
<script type="text/javascript" src="/static/js/upload.js"></script>
<script type="text/javascript" src="/include/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="/include/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css" media="screen" />
	<script type="text/javascript">
		var uploadComplete = function(file){
			var showname = file['name'].replace(file['type'],'');
			var title = $('#title');
			if(title.length>0 && title.val()==''){
				title.val(showname);
			}
			top.resetmain();
		}
	</script>
<div class="ter_tit">
当前位置 > <a href="#geturl(troom/setting/tplsetting/teachertheam)#">师资团队</a> > 添加教师</div>
<div class="lefrig">
<?php $this->display('troom/tplsetting_menu'); ?>
<div id='atsrc' style="display: none;"></div>
				<div class="annotate" style="color:#888888; margin-left: 20px;">在此页面中，您可以填写教师姓名、上传教师头像、编写教师介绍。</div>
				<br/>      
		<form action="#getsitecpurl()#" method="post" onsubmit="return submit_check()">
			<input type="hidden" name="action" value="teachertheam" />
			<input type="hidden" name="crid" value="$crid" />
			<input type="hidden" name="op" value="add" />	
		
			<table class="addteacher_tab" width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<th width=100><label>教师姓名：</label></th>
				<td colspan="3">
					<input style="padding-left: 5px;" class="uipt w295" maxlength="25" name="subject" id="subject" type="text" value=""  maxlength="30" onblur="subjs(this.value)">
					<div style="margin-top:10px;"><span class="ts2" id="su" style="color:#999999;padding-left:5px;">请输教师姓名,最少2个字。</span></div>
				</td>
			  </tr>
		
		    <tr>
			  <th><label>教师头像：</label></th>
				<td colspan="2">
					<div>
					<a class='sn' id='a' style="float:left;" href='/troom/advertisement/$value[thumb]'>
						<img id="imageid" class="imagewidth" style="height:134px;width:94px;display:none;" src="#" >
					</a>
					<input  id="txtpath" type="text" value="" name="thumb" style="width:230px; height: 20px;float:left;" onblur="touxiang(this.value)"/>
					<input class="souhuang" onclick="showdialog()" value="上传图片.." type="button" />
					<span id="showdel"><input id="aid" class="souhui"  onclick="delimage('','item','thumb','itemid');$('#aid').hide();$('#imageid').hide()" value="删除图片.." type="button" /></span><br />
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
				<td colspan="3"><input id="in" class="huangbtn marrig" name="" value="提交" type="submit" />
				<input class="lanbtn" name="" value="返回" type="button" onclick="history.go(-1);"/></td>
			  </tr>
			 </table>
		 </form>
	</div>
<div class="ter_tit">
当前位置 > <a href="#geturl(troom/setting/tplsetting/teachertheam)#">师资团队</a> > 修改教师</div>
<div class="lefrig">
				<div id='atsrc' style="display: none;"></div>
				<div class="annotate" style="color:#888888; margin-left: 20px;">在此页面中，您可以修改教室姓名、教室姓名、教室姓名等。</div>
				<br/> 
		<form action="#getsitecpurl()#" method="post"  onsubmit="return submit_check()">
			<input type="hidden" name="action" value="teachertheam" />

			<input type="hidden" name="itemid" value="$value[itemid]" />
			<input type="hidden" name="crid" value="$crid" />
			<input type="hidden" name="op" value="update" />	
		
			<table class="addteacher_tab" width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<th width=100><label>教师姓名：</label></th>
				<td colspan="3">
					<input style="padding-left: 5px;" class="uipt w295" maxlength="25" name="subject" id="subject" type="text" value=""  maxlength="30"  onblur="subjs(this.value)">
					<div style="margin-top:10px;"><span class="ts2" id="su" style="color:#999999;padding-left:5px;">请输教师姓名,最少2个字。</span></div>
				</td>
			  </tr>
		
		    <tr>
			 <th><label>广告图片：</label></th>
				<td class="newku">
					<a class='sn' style="float:left;" id='a' href=''>
						<img id="imageid" class="imagewidth" style="height:134px;width:94px;" src="" >
					</a>
					<input  id="txtpath" type="text" value="" name="thumb" style="width:230px; height: 20px;float:left;" onblur="touxiang(this.value)"/>
					<input class="souhuang" onclick="showdialog()" value="上传图片.." type="button" />
					<span id="showdel"><input id="aid" class="souhui" onclick="delimage('','item','thumb','itemid');$('#aid').hide();$('#imageid').hide()" value="删除图片.." type="button" /></span><br />
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
					<textarea style="padding-left: 5px;" name="note" id="note" cols="80" rows="5" value=""  onblur="nots(this.value)"></textarea>
					<p style="line-height:22px;color:#999999;padding-left:5px;" id="no">请输入教师的个人信息，字数控制在5-500个字之间。</p>
				</td>
			  </tr>
			  <tr>
			  	<th></th>
				<td colspan="3"><input id="in" class="centerBtn" name="" style="cursor:pointer;margin-right:10px;" value="保存" type="submit" /><input type="button" onclick="history.go(-1);" value="返回" style="cursor:pointer;text-align:center;" name="" class="centerBtn">
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
	}
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
</script>
<div id="dialog"></div> 