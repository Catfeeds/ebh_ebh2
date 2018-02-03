<?php $this->display('troom/page_header'); ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/css/statch.css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<div class="ter_tit"> 当前位置 > <a href="<?= geturl('troom/weixin') ?>">微家校通</a> > 班级发信 </div>
<div class="lefrig">
<?php if(!empty($classlist)){?>
<div class="euwqie">
  <select name="select" class="sesel" id="classid" style="width:300px;"  onchange="getvalue(this)" >
  <?php foreach($classlist as $tclass){ ;?>
    <option value="<?=$tclass['classid']?>" <?= $tclass['classid'] == $classid ? 'selected=selected':''?> ><?= $tclass['classname'];?></option>
    <?php };?>
  </select>
</div>
<?php };?>
<form id="student_send" acion="<?= geturl('troom/weixin/do_send') ?>" method="post" name="student_send">
<div class="wenaze" style="margin-top:10px;">
<table class="datatab" width="100%" style="border:none;">
<thead class="tabhead">
<tr class="">
<th>学生帐号</th>
<th>姓名</th>
<th>性别</th>
<th>家长微信</th>
<th>消息内容</th>
</tr>
</thead>
<?php if(!empty($studentlist)){;?>
<tbody>
<?php foreach($studentlist as $student){
if(empty($student['wx_openids'])) //只显示已经绑定微信号的
	continue;
?>
<tr class="">
<td width="100px"><input class="textlk" id="wx_check" name="wx_uid[]" type="checkbox" value="<?= $student['uid'];?>" /><?= $student['username'];?></td>
<td width="60px" style="text-align:center;"><?= $student['realname'];?></td>
<td width="25px" style="text-align:center;"><?= $student['sex']=='0'?'男':'女';?></td>
<td width="95px" style="text-align:center;"><?= $student['wx_names']; ?><input type="hidden" name="binduids[]" value="<?= $student['uid'];?>"/><input type="hidden" name="wxname_<?= $student['uid'];?>" value="<?= $student['wx_openids'] ?>"/></td>
<td width="330px">
  <input id="content_<?= $student['uid'];?>" name="content_<?= $student['uid'];?>" type="text" class="wktintex" value=""/>
</td>
</tr>
<?php } ;?>
<?php foreach($studentlist as $student){
if(!empty($student['wx_openids'])) //只显示未绑定微信号的
	continue;
?>
<tr class="">
<td width="100px"><input class="textlk" id="wx_check" name="wx_uid[]" type="checkbox" value="<?= $student['uid'];?>" /><?= $student['username'];?></td>
<td width="60px" style="text-align:center;"><?= $student['realname'];?></td>
<td width="25px" style="text-align:center;"><?= $student['sex']=='0'?'男':'女';?></td>
<td width="95px" style="text-align:center;"><span style="color:red">未绑定</span></td>
<td width="330px">
  <input id="content_<?= $student['uid'];?>" name="content_<?= $student['uid'];?>" type="text" class="wktintex" value=""/>
</td>
</tr>
<?php } ;?>
</tbody>
<?php };?>
</table>
<input type="hidden" name="classid" value="<?= isset($classid)?$classid:'';?>">
</div>
<!----{/1}----->
<!----{2}------>
<div class="fewuwo">
<a href="javascript:void(0);" id="addcart" class="huangtxn"><span>追加</span></a>
<a href="javascript:void(0);" id="addcart_tihuan" class="huangtxn marlef"><span>替换</span></a>
<a href="javascript:void(0);" class="lantxn marlef" id="all_change"><span>全选</span></a>
<a href="javascript:void(0);" class="lantxn marlef" id="no_change"><span>反选</span></a>
<a href="javascript:void(0);" class="lantxn marlef" id="none_change"><span>清空页面</span></a>
<a href="javascript:void(0);" class="hongsong" id="class_send_form">立即发送</a>
</div>
<!----{/2}----->
</form>
</div>
<!--弹出层  DIV-->
<!----{3}---->
<div class="ekbng lefrig" id="zhuijia" style="display: none;border: solid 1px #b1d1e7;">
<h2 class="dfjeen">请输入您要追加的内容</h2>
<textarea name="textarea" id="textarea_zhuijia" class="textdaike"></textarea>
<a href="javascript:void(0);" class="huangbtn" id="zhuijia_bt">追加</a>
<a href="javascript:void(0);" id="zhuijia_close" class="huibtn marlef">关闭</a>
</div>
<!----{/3}---->
<!----{4}---->
<div class="ekbng lefrig" id="tihuan" style="display: none;border: solid 1px #b1d1e7;">
	<h2 class="dfjeen">请输入您要替换的内容</h2>
	<textarea name="textarea" class="textdaike" id="textarea_tihuan"></textarea>
	<a href="javascript:void(0);" class="huangbtn" id="tihuan_bt">替换</a>
	<a href="javascript:void(0);" id="tihuan_close" class="huibtn marlef">关闭</a>
	</div>
<!----{4}---->
<!---{5}--->
<div class="tancheng lefrig" id="send_success" style="display: none">
<div class="weiico">
</div>
<div class="dkjeff">
<p class="eoljtf">消息发送成功</p>
<p class="rehuil">您发送的消息已经保存到发信历史，自动清空页面。</p>
</div>
<a href="#" class="huibtn">关闭</a>
</div>
<!----{/5}---->
<script language="javascript" type="text/javascript">
//var addpop = 0;
//var replacepop = 0;
	function getvalue(ob)
	{
		var opval=ob.options[ob.selectedIndex].value;
		location.href='<?= geturl('troom/weixin/student_send_msg') ?>?classid='+opval;
    }
	$(function() {
		$("#all_change").click(function () {//全选
			$("input[name='wx_uid[]']").prop("checked", true);
        });

		$("#none_change").click(function () {//清空
			$(".wktintex").val("");
		});

		$("#no_change").click(function () {//反选
			$("input[name='wx_uid[]']").each(function () {
				$(this).prop("checked", !$(this).prop("checked"));
			});
		});
		$("#addcart").click(function(){
			$("#zhuijia").simpledialog({width:448,height:359,model:true,offset:{x:0,y:200}});
			$("#zhuijia").simpledialog("open");
			$("#textarea_zhuijia").focus();
		});
		$("#zhuijia_close").click(function(){
			$("#zhuijia").simpledialog("close");
		});

		$('#zhuijia_bt').click(function(){
			var cur_text_area =  $('#textarea_zhuijia').val();
			$(".wktintex").each(function(){
				var oldvalue = $(this).val();
				$(this).val(oldvalue + cur_text_area);
			});
			$("#zhuijia").simpledialog("close");
		});
		$("#addcart_tihuan").click(function(){
			$("#tihuan").simpledialog({width:448,height:359,model:true,offset:{x:0,y:200}});
			$("#tihuan").simpledialog("open");
			$("#textarea_tihuan").focus();
		});
		$("#tihuan_close").click(function(){
			$("#tihuan").simpledialog("close");
		});

		$('#tihuan_bt').click(function(){
			var cur_text_area_th =  $('#textarea_tihuan').val();
			$(".wktintex").val(cur_text_area_th);
			$("#tihuan").simpledialog("close");
		});
		$("#class_send_form").click(function () {
			var hascheck = false;
			var noempty = true;
			var checklist = $(".textlk");
			for(var i = 0; i < checklist.length; i ++ ) {
				if($(checklist[i]).prop("checked")==true) {
					hascheck = true;
					break;
				}
			}
			for(var i = 0; i < checklist.length; i ++ ) {
				if($(checklist[i]).prop("checked")==true) {
					var contentid = "content_"+$(checklist[i]).val();
					if($.trim($("#"+contentid).val()) == "") {
						noempty = false;
						break;
					}
				}
			}
			if(!hascheck){
				alert("请选择要发送信息的学生!");
				return false;
			}
			if(!noempty){
				alert("消息内容不能为空!");
				return false;
			}

			var url = "<?= geturl('troom/weixin/do_send') ?>";
			$.ajax({
				url:url,
				type: "POST",
				data:$("#student_send").serialize(),
				dataType:"text",
				success: function(data){
					if(data == "ok") {
						 $.showmessage({
							img : 'success',
							message:'发送成功',
							title:'发送消息',
							callback :function(){
								 document.location.href = document.location.href;
							}
						});
					} else {
						var message = '发送失败，请稍后再试或联系管理员。';
						if(data != undefined)
							message = data;
						$.showmessage({
							img : 'error',
							message:message,
							title:'发送消息'
						});
					}
				}
			});

		});
	});
 </script>
 <?php $this->display('troom/page_footer');?>