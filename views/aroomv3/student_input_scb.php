<?php $this->display('aroomv2/page_header')?>

<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css?version=20160225001" rel="stylesheet" />
<title>批量导入</title>
</head>

<body>

	<div class="lefrig" style="background:#fff;margin-top:15px;width:788px;float:left;">
<div class="annuato" style="line-height:28px;padding-left:20px;position: relative;">
<a href="http://static.ebanhui.com/ebh/file/sinput_scb.xls" class="mobancun" target="_blank">导入模板下载</a>
</div>
<div class="huidis">
<div class="neileft105">

<?php if(empty($inputresult['hasresult'])){?>
<form id="inputform" action="<?=geturl('/aroomv2/student/input_scb.html?aroomv=3')?>" method="post" enctype="multipart/form-data">
  <input style="float:left;width:350px;height:30px;cursor:pointer;" type="file" name="inputfile" />
  <input name="flag" type="hidden"/>

  <input style="float:right;" class="xuetjbtn" type="button" value="提　交" />
</form>
<p style="color:red;width:300px;"><?=empty($inputresult['errormsg'])?'':$inputresult['errormsg']?></p>
<p class="pzhuyi" style="float:left;">注意<span style="color:red;">(非常重要)</span>：<br />
1.导入系统目前只支持xls格式文件，暂不支持xlsx格式文件。<br />
2.导入的excel文件必须严格按照导入模板格式。<br />
3.excel文件中的必须包含姓名、登录账号、性别、学校四个字段。<br />
</p>
<?php }?>


<?php if(!empty($inputresult) && $inputresult['hasresult']){
		if($inputresult['result'] == true){?>
<p class="ptishi">导入成功，共导入 <?=$inputresult['rowcount']?> 条学生记录。</p>
<input class="xuetjbtn" type="button" value="继续导入" onclick="window.location.href='<?=geturl('/aroomv2/student/input_scb.html?aroomv=3')?>'" />

	<?php }else{?>
<br />
<p class="ptishi" style="line-height:1.8;">很抱歉，导入失败，具体原因如下：<br />
<?=$inputresult['errormsg']?><br />
<?php if(!empty($inputresult['erroritems'])){
		foreach($inputresult['erroritems'] as $eitem){
			echo $eitem .'<br />';
}}?>

</p>
<input class="xuetjbtn" type="button" value="重新导入" onclick="window.location.href='<?=geturl('/aroomv2/student/input_scb.html?aroomv=3')?>'" />

</p>
<?php }}?>

</div>
</div>
</div>
<div id="loadparent" style="display:none;">
<div id="loadimg" style="width:100px;height:100px;margin:0 auto;margin-top:150px;"><img style="margin:0 auto;" title="加载中..." src="http://static.ebanhui.com/ebh/images/loading.gif"/>
</div>
<script type="text/javascript">
$(function(){
	$(".xuetjbtn").click(function(){
		$("#loadparent").css("display","");
		$("#inputform").submit();
	});
});
</script>
<?php $this->display('aroomv2/page_footer')?>