<?php $this->display('troom/page_header'); ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/css/statch.css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<div class="ter_tit"> 当前位置 > <a href="<?= geturl('troom/weixin') ?>">微家校通</a> > 家长回复 </div>
<form id="replyform" acion="<?= geturl('troom/weixin/do_reply') ?>" method="post" name="student_send">
<div class="lefrig">
<?php if(!empty($classlist)){?>
<div class="euwqie">
  <select name="classid" class="sesel" id="classid" style="width:300px;"  onchange="getvalue(this)" >
  <?php foreach($classlist as $tclass){ ;?>
    <option value="<?=$tclass['classid']?>" <?= $tclass['classid'] == $classid ? 'selected=selected':''?> ><?= $tclass['classname'];?></option>
    <?php };?>
  </select>
   <?php };?>
</div>
<div class="uttgh" style="margin-top:10px;">
<?php if(!empty($studentlist)){?>
<ul>
<?php foreach($studentlist as $student){ 
if(empty($student['replylist']))
	continue;
?>
<li class="menu1">
<div class="menubar" isshow="1" title="点击隐藏"><span class="aspan"><input name="wx_uid[]" class="pusercheck" style="margin-top:2px;_margin-top:-2px;" type="checkbox" value="<?= $student['uid']?>"  /></span><span class="aspan"><?= $student['username']?></span><span class="aspan"><?= $student['realname']?></span><span class="aspan"><?= $student['sex']=='0'?'男':'女';?></span><span class="aspan"><?php if(empty($student['wx_names'])){?> <span style="color:red">未绑定</span><?php } else { echo $student['wx_names']; }?><input type="hidden" name="wxname_<?= $student['uid'];?>" value="<?= $student['wx_openids'] ?>"/></span>
</div>
<div class="listrpl">
<ul>
<?php foreach($student['replylist'] as $myreply){ 
	if($myreply['hasreply'] == 1) {
?>
<li class="yidude">
<input name="wx_rid[]" class="teskut puid_<?= $student['uid'] ?> usercheck" type="checkbox" value="<?= $myreply['rid'] ?>" /><span class="awerre"> <?= date("Y.m.d H:i",$myreply['dateline']);?></span><span class="weihei"><?= $myreply['msg'];?></span>
</li>
<?php } else {?>
<li class="weidude">
<input name="wx_rid[]" class="teskut puid_<?= $student['uid'] ?> usercheck" type="checkbox" value="<?= $myreply['rid'] ?>" /><span class="awerre"> <?= date("Y.m.d H:i",$myreply['dateline']);?></span><span class="weihei"><?= $myreply['msg'];?><input type="hidden" name="wx_<?= $student['uid']?>_rid[]" value="<?= $myreply['rid'] ?>" /></span>
</li>
<?php }
}
?>
</ul>
</div>
</li>
<?php } ?>
<?php foreach($studentlist as $student){ 
if(!empty($student['replylist']))
	continue;
?>
<li class="menu2">
<span class="aspan" style="width:14px"></span><span class="aspan"><?= $student['username'] ?></span><span class="aspan"><?= $student['realname'] ?></span><span class="aspan"><?= $student['sex']=='0'?'男':'女';?></span><span class="aspan"><?php if(empty($student['wx_names'])){?> <span style="color:red">未绑定</span><?php } else { echo $student['wx_names']; }?></span>
</li>
<?php } ?>
</ul>
<?php } ?>
<input type="hidden" name="content" id="content" value="">
</div>
</form>

<div class="fewuwo">
<a href="javascript:void(0);" class="lantxn" id="all_change"><span>全选</span></a>
<a href="javascript:void(0);" class="lantxn marlef" id="no_change"><span>反选</span></a>
<a href="javascript:void(0);" class="huangtxn marlef" id="del_change"><span>删除</span></a>
<a href="javascript:void(0);" class="huangtxn marlef" id="clear_change"><span>清空回复</span></a>
<a href="javascript:void(0);" class="hongsong" id="kshuifu_but">快速回复</a>
</div>
</div>
</div>

<!--弹出层  DIV-->
<div class="ekbng lefrig" id="kshuifu" style="display: none;border: solid 1px #b1d1e7;">
	<h2 class="dfjeen">快速回复</h2>
	<textarea name="diagcontent" class="textdaike"></textarea>
	<a href="javascript:void(0);" class="huangbtn" id="tihuan_bt">发送</a>
	<a href="javascript:void(0);" id="kshuifu_close" class="huibtn marlef">关闭</a>
	</div>

<div class="tancheng lefrig" id="delreply" style="display: none;border: solid 1px #b1d1e7;">
<div class="owieen">确认要删除此家长回复吗？</div>
<div class="qindiv">
<a href="javascript:void(0)" class="huangbtn" id="btndelreply">删除</a>
<a href="javascript:void(0)" id="delreply_close" class="huibtn marlef">关闭</a>
</div>
</div>

<div class="tancheng lefrig" id="clearreply" style="display: none;border: solid 1px #b1d1e7;">
<div class="owieen">确认要清空此班级下的家长回复吗？</div>
<div class="qindiv">
<a href="javascript:void(0)" class="huangbtn" id="btn_clearreply">清空</a>
<a href="javascript:void(0)" class="huibtn marlef" id="clearreply_close">关闭</a>
</div>
</div>

<script language="javascript" type="text/javascript">
function getvalue(ob)
{
	var opval=ob.options[ob.selectedIndex].value;
	location.href='<?= geturl('troom/weixin/parent_send') ?>?classid='+opval;
}
$(function () {
	$("#all_change").click(function () {//全选
		$(".pusercheck").prop("checked", true);
		$(".usercheck").prop("checked", true);
	});
	$("#no_change").click(function () {//反选
		$(".pusercheck").each(function () {
			$(this).prop("checked", !$(this).prop("checked"));
		});
		$(".usercheck").each(function () {
			$(this).prop("checked", !$(this).prop("checked"));
		});
	});
	$(".menubar").click(function(e){
		if($(e.target).attr("name") == "wx_uid[]")
			return ;
		if($(this).attr("isshow") == 1) {
			$(this).parent().find(".listrpl").hide();
			$(this).attr("isshow","0");
			$(this).attr("title","点击显示");
		} else {
			$(this).parent().find(".listrpl").show();
			$(this).attr("isshow","1");
			$(this).attr("title","点击隐藏");
		}
	});
	//父选择触发子选择
	$(".pusercheck").on("click",function(e){
		var suid = $(this).val();
		$(".puid_" + suid).prop("checked", $(this).prop("checked"));
	});
	$("#del_change").click(function(){
		delreply();
	});
	$("#delreply_close").click(function(){
		$("#delreply").simpledialog("close");
	});
	
	$("#btndelreply").click(function(){
		submitdelreply();
	});
	$("#clear_change").click(function(){
		$("#clearreply").simpledialog({width:448,height:359,model:true,offset:{x:0,y:200}});
		$("#clearreply").simpledialog("open");
	});
	$("#clearreply_close").click(function(){
		$("#clearreply").simpledialog("close");
	});
	$("#btn_clearreply").click(function(){
		submitclearreply();
	});
	$("#kshuifu_but").click(function(){
		myreply();
	});
	$("#kshuifu_close").click(function(){
		$("#kshuifu").simpledialog("close");
	});
	$("#tihuan_bt").click(function(){
		submitreply();
	});
});
function myreply() {
	var hascheck = false;
	var checklist = $(".pusercheck");
	for(var i = 0; i < checklist.length; i ++ ) {
		if($(checklist[i]).prop("checked")==true) {
			hascheck = true;
			break;
		}
	}
	if(!hascheck){
		alert("请选择要回复信息的学生!");
		return false;
	}
	$("#kshuifu").simpledialog({width:448,height:359,model:true,offset:{x:0,y:200}});
	$("#kshuifu").simpledialog("open");
	$(".textdaike").focus();
}
function submitreply() {
	var content = $.trim($(".textdaike").val());
	if(content == "") {
		alert("回复内容不能为空");
		$(".textdaike").focus();
		return;
	}
	$("#content").val(content);
	var url = "<?= geturl('troom/weixin/do_reply') ?>";
	$.ajax({
		url:url,
		type: "POST",
		data:$("#replyform").serialize(),
		dataType:"text",
		success: function(data){
			if(data == "ok") {
				$.showmessage({
					img : 'success',
					message:'回复成功',
					title:'回复家长信息',
					callback :function(){
						document.location.reload();
					}
				});
			} else {
				var message = '回复失败，请稍后再试或联系管理员。';
				if(data != undefined) {
					message = data;
					$.showmessage({
						img : 'error',
						message:message,
						title:'回复家长回复'
					});
				}
			}
		}
	});
}
function delreply() {
	var hascheck = false;
	var checklist = $(".usercheck");
	for(var i = 0; i < checklist.length; i ++ ) {
		if($(checklist[i]).prop("checked")==true) {
			hascheck = true;
			break;
		}
	}
	if(!hascheck){
		alert("请选择要删除的家长回复!");
		return false;
	}
	$("#delreply").simpledialog({width:448,height:359,model:true,offset:{x:0,y:200}});
	$("#delreply").simpledialog("open");
}
function submitdelreply() {
	var url = "<?= geturl('troom/weixin/do_delreply') ?>";
	var ridlist = [];
	$(".usercheck").each(function(){
		if($(this).prop("checked")==true) {
			ridlist[ridlist.length] = $(this).val();
		}
	});
	var classid = $("#classid").val();
	$.ajax({
		url:url,
		type: "POST",
		data:{"wx_rid":ridlist,"classid":classid},
		dataType:"text",
		success: function(data){
			if(data == "ok") {
				$.showmessage({
					img : 'success',
					message:'删除成功',
					title:'删除家长回复',
					callback :function(){
						$(".listrpl ul li").each(function(){
							if($(this).find(".usercheck").prop("checked")==true)
								$(this).remove();
						});
						$("#delreply").simpledialog("close");
					}
				});
			} else {
				var message = '删除失败，请稍后再试或联系管理员。';
				if(data != undefined) {
					message = data;
					$.showmessage({
						img : 'error',
						message:message,
						title:'删除家长回复'
					});
				}
			}
		}
	});
}
function submitclearreply() {
	var url = "<?= geturl('troom/weixin/do_clearreply') ?>";
	$.ajax({
		url:url,
		type: "POST",
		data:$("#replyform").serialize(),
		dataType:"text",
		success: function(data){
			if(data == "ok") {
				$.showmessage({
					img : 'success',
					message:'清空成功',
					title:'清空家长回复',
					callback :function(){
						document.location.reload();
					}
				});
			} else {
				var message = '清空失败，请稍后再试或联系管理员。';
				if(data != undefined) {
					message = data;
					$.showmessage({
						img : 'error',
						message:message,
						title:'清空家长回复'
					});
				}
			}
		}
	});
}
</script>
<?php $this->display('troom/page_footer'); ?>