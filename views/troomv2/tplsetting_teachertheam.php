<?php $this->display('troomv2/page_header'); ?>

<div class="ter_tit">
当前位置 > 师资团队</div>
<div class="lefrig">
<?php $this->display('troomv2/tplsetting_menu'); ?>
<div class="annotate" style="color:#888888; margin-left: 20px; margin-bottom: 15px;">在此页面中,您可以管理教室平台下面的师资团队，您可以进行添加、修改、删除等操作。</div>
<div class="tiezitool"><a class="jiabgbtn hongbtn" style="width:110px;" href="<?= geturl('troomv2/tplsetting/teachertheam/add')?>" >添加团队成员</a></div>
<table style="margin-left:20px;">
		<tr>
			<td><span style=" height: 24px; line-height: 24px;">教师姓名：</span><input id="subject" name="uname" type="text" style=" border: 1px solid #A0B5BB; height: 20px; line-height: 20px;margin-right: 5px;width: 180px; margin-bottom: -2px;" value="<?= $q ?>"/></td>			
			<td ><a onclick="serc()" class="souhuang" id="ser">搜 索</a></td>
			<td></td>
		</tr>
		</table>
<table width="100%" class="datatab" style="margin-top:10px;">
	<thead class="tabhead">
	  <tr>
		<th>教师姓名</th>
		<th>教师介绍</th>
		<th>操作</th>
	  </tr>
	 </thead>
	 <tbody>

				  <tr>
					<td width="16%" title="$value['subject']"></a></td>
					<td width="69%" title="$value['note']"></td>
					<td width="15%"><div class="teac_manage">
						<a class="workBtn" onclick="location.href='#geturl(troomv2/setting/tplsetting/teachertheam/add-0-0-0-$value[itemid])#'" >修改</a>
						<input type="button" class="workBtn" onclick="return degroup($value['itemid'],'$value['subject']')" value="删除" /></div>
					</td>
				  </tr>
	
				 <tr><td colspan="7" align="center">暂 无 数 据</td></tr>

	  </tbody>
</table>
<div style="margin-top:10px;">
</div>
<script type="text/javascript">
<!--
	function degroup(itemid,subject) {
	var conf =  window.confirm("您确定要【" + subject + "】教师吗？");
	if (conf)
	{
		$.ajax({
			url:"#getsitecpurl()#?action=information",
			type:'post',
			data:{'itemid':itemid,'op':'del','subject':subject},
			dataType:'text',
		
			success:function(data){
				if(data=='success'){
					alert("教师删除成功！");
					document.location.href = document.location.href;
				}else{
					alert("对不起，教师删除失败，请稍后再试！");
				}
			}
		});
	}
}
//-->
</script>
<script type="text/javascript">
<!--
function serc(){
	var subject = $("#subject").val();
		subject = subject.replace(/,/g,"");
		subject = subject.replace(/\'/g,"");
		subject = subject.replace(/_/g,"");
		subject = subject.replace(/\?/g,"");
		subject = subject.replace(/\#/g,"");
		subject = subject.replace(/\%/g,"");
	var url = '#geturl(troomv2/setting/tplsetting/teachertheam-0-0-0-'+subject+')#';
 // alert(url);
	window.location.href=url;
}
	
//-->
</script>
<?php $this->display('troomv2/page_footer'); ?>