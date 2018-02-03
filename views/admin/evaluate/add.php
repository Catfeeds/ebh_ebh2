<?php 
  $this->display('admin/header');
?>
<body id="main"><table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tbody><tr>
		<td><h1>量表管理- 添加量表</h1></td>
		<td class="actions">
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tbody><tr>
			<td><a href="/admin/evaluate.html">所有量表</a></td>
			<td class="active"><a href="/admin/evaluate/add.html" class="add">添加量表</a></td>
			</tr>
			</tbody></table>
		</td>
	</tr>
</tbody></table>

<form method="post" action="<?php echo geturl('admin/evaluate/add'); ?>" id="form">
<input type="hidden" name="dopost" value="add" />
<style type="text/css">
body{font-family:tahoma,verdana,arial;font-size:11px;line-height:15px;background-color:#FCFDFD;color:#666666;}
strong{font-size:12px;}
aink{color:#0066CC;}
a:hover{color:#FF6600;}
aisited{color:#003366;}
a:active{color:#9DCC00;}
.maintable{
	width:80%;
}
.buttons{
	text-align:left;
	margin-left:400px;
}
</style>
<table cellspacing="0" cellpadding="0" style="width:80%;margin-left:10px" class="maintable">

<tbody>
  <tr>
    <th>量表名称<span>＊</span></th>
    <td>
      <input type="text" name="title" class="w300" value="" />
    </td>
  </tr>

  <tr>
    <th>量表简介<span>＊</span><p>描述量表简介0-200字</p></th>
    <td>
      <textarea name="descr" rows="2" style="width:60%;height:120px;" cols="20" ></textarea>
    </td>
  </tr>
<tr>
  <th>量表导语<span>＊</span><p>描述量表引导语0-200字</p></th>
  <td >
  <textarea name="tutor" rows="2" style="width:60%;height:120px;" cols="20" ></textarea>
  </td>
</tr>

<tr><th>量表配图<span>＊</span><p>配图用于封面显示,不要过大,建议尺寸71*83</p></th><td>
<br>
<?php
    $Upcontrol->upcontrol('up',1,null,'pic');
?>
</td></tr>
<tr><th>试题总数量<span>＊</span><p>问题总数量。</p></th><td>
<input type="text" class="w100" name="total" value="">
</td>
</tr>
<tr><th >每道问题选项数<p>不统一可以写0或者不填</p></th>
<td>
<input type="text" class="w100 nums"  name="nums" value="0" onkeyup="this.value=this.value.replace(/\D/g,'')"  onafterpaste="this.value=this.value.replace(/\D/g,'')"  />
<span id="pitem">

</span>
</td>
</tr>
</tbody></table>
<div class="buttons">
<input type="button" name="valuesubmit" value="提交保存" class="submit">
<input type="reset" name="valuereset" value="重置">
</div>
</form><br>

<script type='text/javascript'>
 $(function(){
	 //清空缓存
	 $(".nums").val('0');
	 //动态添加选项
	 $(".nums").blur(function(){
		 var num = $(this).val();
		 var i = 0;
		 var pps = [];
		 $("#pitem").empty();
	 	 for(i;i<num;i++){
		 	pps.push('<p> 选项 <input type="text" name="item[]"/> 分值 <input type="text" name="score[]" /></p>');
			}
	 	 $("#pitem").append(pps); 
		 //alert(pps);
		 //console.log(pps);
		 });
	//表单提交验证
	 $(document).on("click",".submit",function(){
 			var title = $("input[name='title']").val();
			if(title==''){
				alert("量表名称不能为空");
				$("input[name='title']").focus();
				return false;
				}
			var descr = $("textarea[name='descr']").val();
			if(descr==''){
				alert("请输入量表简介");
				$("textarea[name='descr']").focus();
				return false;
				}
			var tutor = $("textarea[name='tutor']").val();
			if(tutor==""){
				alert("请输入量表导语");
				$("textarea[name='tutor']").focus();
				return false;
				}

			var total = $("input[name='total']").val();	
			if(total==''||isNaN(total)){
				$("input[name='total']").focus();
				alert('请输入试题总数量');
				return false;
				}  
			//选项检测
			var nums = $(".nums").val();
			if(nums>0){
				var checkitem = false;
				$("#pitem").find(":input").each(function(k,v){
					var item = $(v).val();
					if(item!=''){
						checkitem = true;
					}else{
						checkitem = false;
						return false;
						}
					});
				if(checkitem==false){
					alert('请输入选项或分数');
					return false;
					}
				}
			$("#form").submit();
		});
	});
</script>
<?php 
  $this->display('admin/footer');
?>