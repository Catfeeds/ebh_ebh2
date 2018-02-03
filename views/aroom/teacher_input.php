<?php $this->display('aroom/page_header')?>
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
<title>批量导入</title>
</head>

<body>
<div class="ter_tit">
		当前位置 > 教师管理 > 导入教师
		</div>
	<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:788px;">
<div class="annuato" style="line-height:28px;padding-left:20px;position: relative;"><a href="http://static.ebanhui.com/ebh/file/tinput.xls" class="mobancun" target="_blank">导入模板下载</a>
</div>
<div class="huidis">
<div class="neileft105">
<?php if(empty($inputresult['hasresult'])){?>
<form id="inputform" action="<?=geturl('aroom/teacher/input')?>" method="post" enctype="multipart/form-data">
  <input style="float:left;width:350px;height:30px;cursor:pointer;" type="file" name="inputfile" />
  <input name="flag" type="hidden"/>
  <a style="float:right" href="<?=geturl('aroom/teacher')?>" class="flhui">返回</a>
  <input style="float:right;" class="xuetjbtn" type="button" value="提　交" />
</form>
<p style="color:red;width:300px;"><?=empty($inputresult['errormsg'])?'':$inputresult['errormsg']?></p>
<p class="pzhuyi" style="float:left;">注意<span style="color:red;">(非常重要)</span>：<br />
1.导入系统目前只支持xls格式文件，暂不支持xlsx格式文件。<br />
2.导入的excel文件必须严格按照导入模板格式。<br />
3.excel文件中的必须包含教师姓名、登录账号、密码、联系方式四个字段。<br />
4.登录账号只能为6-16位英文、数字、“_”的组合字符。且首字母不能为数字。<br />
5.导入的账号密码不能为123456。且长度6-16位，区分大小写。<br />
6.如果有一条数据存在问题，系统都将导入失败，请注意查看提示信息。
</p>
<?php }?>

<?php if(!empty($inputresult) && $inputresult['hasresult']){
		if($inputresult['result'] == true){?>
<p class="ptishi">导入成功，共导入 <?=$inputresult['rowcount']?> 条教师记录。</p>
<input class="xuetjbtn" type="button" value="继续导入" onclick="window.location.href='<?=geturl('aroom/teacher/input')?>'" />
<a href="<?=geturl('aroom/teacher')?>" class="flhui">返回</a>
		<?php }else{?>

<br />
<p class="ptishi" style="line-height:1.8;">很抱歉，导入失败，具体原因如下：<br />
<?=$inputresult['errormsg']?><br />
<?php if(!empty($inputresult['erroritems'])){
		foreach($inputresult['erroritems'] as $eitem){
			echo $eitem .'<br />';
}}?>

</p>
<input class="xuetjbtn" type="button" value="重新导入" onclick="window.location.href='<?=geturl('aroom/teacher/input')?>'" />
<a href="<?=geturl('aroom/teacher')?>" class="flhui" style="color:#065ed7;float:left;font-size:14px;margin:5px 0 0 10px;">返回</a>
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
<?php $this->display('aroom/page_footer')?>