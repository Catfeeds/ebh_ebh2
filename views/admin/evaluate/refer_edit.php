<?php 
  $this->display('admin/header');
?>
<body id="main"><table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tbody><tr>
		<td><h1>测评结果参考项- 添加评语</h1></td>
		<td class="actions">
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tbody><tr>
			<td><a href="/admin/refer.html">所有评语</a></td>
			<td class="active"><a href="/admin/refer/add.html?eid=<?=$eid?>" class="add">添加评语</a></td>
			</tr>
			</tbody></table>
		</td>
	</tr>
</tbody></table>

<form method="post" action=<?php echo geturl('admin/refer/edit'); ?> onsubmit="return check()">
<input type="hidden" name="dopost" value="edit" />
<input type="hidden" name="eid" value="<?=$eid?>" />
<input type="hidden" name="rid" value="<?=$refer['rid']?>" />
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
      <?=$row['title']?>
    </td>
  </tr>

  <tr>
    <th>分值区间<span>＊</span></th>
    <td>
      <input type="text" name="startscore" value="<?=$refer['startscore']?>" /> 
      ~
      <input type="text" name="endscore" value="<?=$refer['endscore']?>" />
    </td>
  </tr>
<tr>
  <th>型号关键字<span>＊</span></th>
  <td >
  <input type="text" name="keystr"  value="<?=$refer['keystr']?>"  />
  </td>
</tr>
<tr>
  <th>计分题号<span>＊</span></th>
  <td >
  <input type="text" name="keyitemstr" id="keyitemstr" class="w300" value="<?=$refer['keyitemstr']?>" readonly  />
  	<input type="button" id="drop" value="选择"   />
	<input type="button" id="clear" value="清除" />
  </td>
</tr>

<tr>
  <th>评语<span>＊</span><p>描述符合该区间值的评语内容</p></th>
  <td colspan="2" style="padding: 0;">
       <?php echo $editor->createEditor('remarks',"1000px",'500px',$refer['remarks']); ?>
  </td>
</tr>
</tbody></table>
<div class="buttons">
<input type="submit" name="valuesubmit" value="提交保存" class="submit">
<input type="button" onclick="history.go('-1')" value="返回">
</div>
</form><br>
<div id="dialog"></div> 
<script type='text/javascript'>
	 function check(){
		var startscore = $("input[name='startscore']").val();
		var endscore =  $("input[name='endscore']").val();
		if(startscore==''||endscore==''){
			alert("请输入区间分值");
			$("input[name='startscore']").focus();
			return false;
			}
		var remarks = ue.getContent();
		if(remarks==""){
			alert("请输入评语内容");
			ue.focus();
			return false;
			}
		return true;
	  }

    
	$('#drop').click(function(){
        var str = $("#keyitemstr").val();
		$('#dialog').dialog({    
	    title: '选择题号',    
	    width:Math.ceil($(document).width()/2),
		height:450, 
	    closed: false,    
	    cache: false,    
	    href: '/admin/refer/questions.html?eid=<?=$eid?>&str='+str,    
    	modal: true   
	});
	$("#ck").trigger('click');
	});
	$('#clear').click(function(){
		$('#keyitemstr').val("");
	});
</script>	
<?php 
  $this->display('admin/footer');
?>