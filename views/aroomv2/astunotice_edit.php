<?php $this->assign('jquery11',TRUE);?>
<?php $this->display('aroomv2/page_header');?>
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
	<div class="ter_tit"> 当前位置 > <a href="<?=geturl('aroomv2/astunotice')?>">全校师生通知</a> > 修改通知并发送 </div>
	<div class="lefrig" style="border:solid 1px #cdcdcd;background:#fff;float:left;margin-top:15px;width:786px;">
		<div class="worknu">
			<ul>
				<li><a href="<?=geturl('aroomv2/astunotice')?>"><span>通知列表</span></a></li>
				<li class="workcurren"><a href="<?=geturl('aroomv2/astunotice/send')?>"><span>发送通知</span></a></li>
			</ul>
		</div>
		<form id="noticeform" method="POST" name="noticeform">
			<input type="hidden" value="<?=$noticedetail['noticeid']?>" name="noticeid"/>
			<span class="shouaj" style="margin-top:5px;">收件人：</span>
			<div style="float:left;width: 716px;">
				<ul>
					<li class="fiorel"><label><input name="noticeto" style="float:left;margin-top:8px;margin-right:5px;*margin-top:4px;" type="radio" value="1" />全校师生</label></li>
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
					
					<li class="fiorel" style="width:60px"><label><input style="float:left;margin-top:8px;margin-right:5px;*margin-top:4px;" name="districtselected" type="checkbox" onclick="sel_district(this)" value="1" id="needdistrict"/>校区</label></li>
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
				<script type="text/javascript">
					$("#noticeform input:radio[value=<?=$noticedetail['ntype']?>]").attr("checked","checked");
					$(function(){
						if(<?=$noticedetail['ntype']?>==5){
							var grades = '<?=$noticedetail['grades']?>';
							var gradearr = grades.split(',');
							$("input[name='grade[]']").each(
								function(){
									if(in_array($(this).val(),gradearr))
										$(this).click();
								}
							)
							$("#gradediv").show();
						}
						var districtselected = false;
						if('<?=$noticedetail['districts']?>'!=""){
							var districts = '<?=$noticedetail['districts']?>';
							var districtarr = districts.split(',');
							$('#needdistrict').click();
							$("input[name='district[]']").each(
								function(){
									if(in_array($(this).val(),districtarr)){
										districtselected = true;
										$(this).click();
									}
								}
							)
						}
					})
					function in_array(search,array){
						for(var i in array){
							if(array[i]==search){
								return true;
							}
						}
						return false;
					}
				</script>
			</div>
			
			<p style="margin-left:16px;">标题：<span id="msgtitle" style="color:#999;">不能超过30个字</span></p>
			<input style="margin-left:16px;" id="noticetitle" class="wkemtxt" name="noticetitle" type="text" maxLength="30" value="<?=$noticedetail['title']?>" />
			<p style="margin-left:16px;">内容：<span id="msgcontent" style="color:#999;">不能超过600个字</span></p>
			<div style="margin-left:16px;">
			<?php $editor->xEditor('noticecontent','746px','300px',$noticedetail['message']); ?>
			</div>
	    	<div style="margin-top:10px;margin-left:16px;">
			<span style="float:left;width:50px;height:20px;line-height:30px;text-align:center;">附件：</span><?php $upcontrol->upcontrol('up',3,$attfile,'attachment'); ?>
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
		$.confirm("确定发送","您确定要发送修改后这个消息通知吗?",function(){
			$.ajax({
				type:'POST',
				url:'<?=geturl('aroomv2/astunotice/edit')?>',
				data:$("#noticeform").serialize(),
				dataType:'json',
				success:function(_json){
					if(_json.status == 0){
						alert("发送失败，请重新发送！");
						window.location.reload();
					}else{
						alert("发送成功！");
						window.location.href="<?=geturl('aroomv2/astunotice')?>";
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
<?php $this->display('aroomv2/page_footer')?>
