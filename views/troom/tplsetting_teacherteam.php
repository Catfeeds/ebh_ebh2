<?php $this->display('troom/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<div class="ter_tit">
当前位置 > 师资团队</div>
<div class="lefrig">
<?php $this->display('troom/tplsetting_menu'); ?>
<div class="annotate" style="color:#888888; margin-left: 20px; margin-bottom: 15px;">在此页面中,您可以管理教室平台下面的师资团队，您可以进行添加、修改、删除等操作。</div>
<div class="tiezitool"><a class="jiabgbtn hongbtn" style="width:110px;" href="<?= geturl('troom/tplsetting/teacherteam/add')?>" >添加团队成员</a></div>
<table style="margin-left:20px;">
		<tr>
			<td><span style=" height: 24px; line-height: 24px;">教师姓名：</span><input id="subject" name="uname" type="text" style=" border: 1px solid #A0B5BB; height: 20px; line-height: 20px;margin-right: 5px;width: 180px; margin-bottom: -2px;" value="<?=$q?>"/></td>			
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
		<?php foreach($teachers as $teacher){?>
				  <tr>
					<td width="16%" title="<?=$teacher['subject']?>"><?=shortstr($teacher['subject'],16)?></td>
					<td width="69%" title="<?=$teacher['note']?>"><?=shortstr($teacher['note'],40)?></td>
					<td width="15%"><div class="teac_manage">
						<a class="workBtn" href="/troom/tplsetting/teacherteam/edit.html?itemid=<?=$teacher['itemid']?>" >修改</a>
						<input type="button" class="workBtn" onclick="return degroup(<?=$teacher['itemid']?>,'<?=$teacher['subject']?>')" value="删除" /></div>
					</td>
				  </tr>
		<?php }?>
		<?if(empty($teachers)){?>
				 <tr><td colspan="7" align="center">暂 无 数 据</td></tr>
		<? }?>
	  </tbody>
</table>
<?=$show_page?>
<script type="text/javascript">
function degroup(itemid,subject) {
	$.confirm("您确定要删除【" + subject + "】教师吗？",function(){
		$.ajax({
				url:"/troom/tplsetting/teacherteam/del.html",
				type:'post',
				data:{'itemid':itemid,'op':'del','subject':subject},
				dataType:'text',
			
				success:function(data){
					if(data=='success'){
						$.showmessage({
				            img : 'success',
				            message:'资讯教师成功',
				            title:'删除教师',
				            callback :function(){
				                 document.location.reload();
				            }
				         });
					}else{
						$.showmessage({
				            img : 'success',
				            message:'资讯教师失败,请稍后再试',
				            title:'删除教师',
				            callback :function(){
				                 document.location.reload();
				            }
				         });
					}
				}
		});
	});
}
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
	var url = '/troom/tplsetting/teacherteam-0-0-0.html?q='+subject;
	window.location.href=url;
}
	
//-->
</script>