<?php $this->assign('jquery11',TRUE);?>
<?php $this->display('aroom/page_header');?>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/tzds.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/upload.js"></script>
<style>
.fiorel{
	width:80px;
}
</style>
<div class="cright" style="margin-top:0px;">
	<div class="ter_tit"> 当前位置 > <a href="<?=geturl('aroom/astunotice')?>">全校师生通知</a> > 发送通知 </div>
	<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:788px;">
		<div class="worknu">
			<ul>
				<li><a href="<?=geturl('aroom/astunotice')?>"><span>通知列表</span></a></li>
				<li class="workcurren"><a href="<?=geturl('aroom/astunotice/send')?>"><span>发送通知</span></a></li>
			</ul>
		</div>
		<form id="noticeform" method="POST" name="noticeform">
			<span class="shouaj" style="margin-top:5px;">收件人：</span>
			<div style="float:left;width: 716px;">
				<ul>
					<li class="fiorel"><label><input name="noticeto" checked style="float:left;margin-top:8px;margin-right:5px;*margin-top:4px;" type="radio" value="1" />全校师生</label></li>
					<li class="fiorel"><label><input name="noticeto" style="float:left;margin-top:8px;margin-right:5px;*margin-top:4px;" type="radio" value="2" />全校教师</label></li>
					<li class="fiorel"><label><input name="noticeto" style="float:left;margin-top:8px;margin-right:5px;*margin-top:4px;" type="radio" value="3" />全校学生</label></li>
					<?php
					if(!empty($roominfo['grade'])){
					?>
					<li class="fiorel" style="width:60px"><label><input name="noticeto" style="float:left;margin-top:8px;margin-right:5px;*margin-top:4px;" type="radio" value="5" />年级</label></li>
					<?php }?>
					<li style="display:none;float:left;width:80px" id="gradediv">
	<?php
		if($roominfo['grade']==1){
			$gradearr = array('一年级','二年级','三年级','四年级','五年级','六年级');
			for($i=1;$i<7;$i++){
				echo '<label style="display:inline-block;width:76px;"><input style="margin-top:8px;width:26px" type="checkbox" value="'.$i.'" name="grade[]"/>'.$gradearr[$i-1].'</label>';
			}
		}elseif($roominfo['grade']==7){
			$gradearr = array('初一','初二','初三');
			for($i=7;$i<10;$i++){
				echo '<label style="display:inline-block;width:76px;"><input style="margin-top:8px;width:26px" type="checkbox" value="'.$i.'" name="grade[]"/>'.$gradearr[$i-7].'</label>';
			}
		}elseif($roominfo['grade']==10){
			$gradearr = array('高一','高二','高三');
			for($i=10;$i<13;$i++){
				echo '<label style="display:inline-block;width:76px;"><input style="margin-top:8px;width:26px" type="checkbox" value="'.$i.'" name="grade[]"/>'.$gradearr[$i-10].'</label>';
			}
		}
	?>
	</li>
					<?php
					if(!empty($districtarr)){
					?>
					
					<li class="fiorel" style="width:60px"><label><input style="float:left;margin-top:8px;margin-right:5px;*margin-top:4px;" name="districtselected" type="checkbox" onclick="sel_district(this)" value="1"/>校区</label></li>
					<?php
					}
					?>
				</ul>
				<div style="display:none;width:160px;float:left" id="districtdiv">
				<?php
					if(!empty($districtarr))
					foreach($districtarr as $k=>$district){
					?>
					<label style="display:inline-block;width:100px;float:left"><input style="margin-top:8px;width:26px;margin-left:0px;" type="checkbox" value="<?=$k+1?>" name="district[]"/><?=$district?></label>
				<?php }?>
				</div>
			</div>
			
			<p style="margin-left:16px;">标题：<span id="msgtitle" style="color:#999;">不能超过30个字</span></p>
			<input id="noticetitle" style="margin-left:16px;" class="wkemtxt" name="noticetitle" type="text" maxLength="30" value="" />
			<p style="margin-left:16px;">内容：<span id="msgcontent" style="color:#999;">不能超过600个字</span></p>
			<div style="margin-left:16px;">
	    	<?php $editor->xEditor('noticecontent','746px','300px'); ?>
			</div>
			<div style="margin-top:10px;margin-left:16px;">
			<span style="float:left;width:50px;height:20px;line-height:30px;text-align:center;">附件：</span><?php $upcontrol->upcontrol('up',3,array(),'attachment'); ?>
			</div>
			<a href="#" class="lanbbtn sendnotice" style="margin-top:10px;margin-left:16px;">发 送</a>
		</form>
	</div>
</div>
<script type="text/javascript">
	
	$(".sendnotice").click(function(){
		var message = UM.getEditor('noticecontent').getContent();
		if($("#noticetitle").val().length<=0 || $("#noticetitle").val().length>30){
			$("#msgtitle").html('<font style="color:#f00;">标题不能为空且不能超过30个字</font>');
			return;
		}
		if(HTMLDeCode(message).replace(/[\s]*<[^>]+>/g,"").length<=0 || HTMLDeCode(message).replace(/[\s]*<[^>]+>/g,"").length>600){
			$("#msgcontent").html('<font style="color:#f00;">内容不能为空且不能超过600个字</font>');
			return;
		}
		var gradecheck=false;
		$("input[name='grade[]']").each(
			function(){  
			if($(this)[0].checked)
				gradecheck=true;
			}
		)
		if($("input:radio:checked").val()==5 && gradecheck==false){
			alert("如果要发送到年级,请选择年级");
			return;
		}
		var toarr = new Array('全校师生','全校教师','全校学生','','所选年级的学生');
		// var str = $("#noticeform input:radio:checked").val()==1?"全校师生":($("#noticeform input:radio:checked").val()==2?"全校教师":"全校学生");
		var str = toarr[$("#noticeform input:radio:checked").val()-1];
		$.confirm("发送确认","您确定把这个通知发送给&nbsp;<font style='color:#f00;'>"+str+"</font>&nbsp;吗?",function(){
			$.ajax({
				type:'POST',
				url:'<?=geturl('aroom/astunotice/send')?>',
				data:$("#noticeform").serialize(),
				dataType:'json',
				success:function(_json){
					if(_json.status == 0){
						alert("发送失败，请重新发送！")
						window.location.reload();
					}else{
						alert("发送成功！");
						window.location.href="<?=geturl('aroom/astunotice')?>";
					}
				}
			});
		});	
	});
	$("#noticetitle").blur(function(){
		if(!($("#noticetitle").val().length<=0 || $("#noticetitle").val().length>30)){
			$("#msgtitle").html('不超过30个字');
		}else{
			$("#msgtitle").html('<font style="color:#f00;">标题不能为空且不能超过30个字</font>');
		}
	});
	$("#noticecontent").blur(function(){
		var message = UM.getEditor('noticecontent').getContent();
		if(!(HTMLDeCode(message).replace(/[\s]*<[^>]+>/g,"").length<=0 || HTMLDeCode(message).replace(/[\s]*<[^>]+>/g,"").length>600)){
			$("#msgcontent").html('不超过600个字');
		}else{
			$("#msgcontent").html('<font style="color:#f00;">内容不能为空且不能超过600个字</font>');
		}
	});
	
	$("input:radio").click(function(){
		if(this.value == 5){
			$("#gradediv").show();
		}else{
			$("#gradediv").hide();
		}
	});
	
	function sel_district(e){
		if(e.checked){
			$("#districtdiv").show();
		}else{
			$("#districtdiv").hide();
		}
	}
</script>
<?php $this->display('aroom/page_footer')?>
