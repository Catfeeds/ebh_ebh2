<?php $this->display('aroom/page_header')?>

<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
<title>批量导入</title>
</head>

<body>
<div class="ter_tit">
		当前位置 > 学生管理 > 导入学生
		</div>
	<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:788px;">
<div class="annuato" style="line-height:28px;padding-left:20px;position: relative;">
<a href="http://static.ebanhui.com/ebh/file/sinput.xls" class="mobancun" target="_blank">导入模板下载</a>
</div>
<div class="huidis">
<div class="neileft105">

<?php if(empty($inputresult['hasresult'])){?>
<form id="inputform" action="<?=geturl('aroom/student/input')?>" method="post" enctype="multipart/form-data">
  <input style="float:left;width:350px;height:30px;cursor:pointer;" type="file" name="inputfile" />
  <input name="flag" type="hidden"/>
  <a style="float:right" href="<?=geturl('aroom/student')?>" class="flhui">返回</a>
  <input style="float:right;" class="xuetjbtn" type="button" value="提　交" />
</form>
<p style="color:red;width:300px;"><?=empty($inputresult['errormsg'])?'':$inputresult['errormsg']?></p>
<p class="pzhuyi" style="float:left;">注意<span style="color:red;">(非常重要)</span>：<br />
1.导入系统目前只支持xls格式文件，暂不支持xlsx格式文件。<br />
2.导入的excel文件必须严格按照导入模板格式。<br />
3.excel文件中的必须包含姓名、登录账号、性别、班级四个字段。<br />
4.登录账号只能为6-16位英文、数字、“_”的组合字符。<br />
5.导入的账号默认密码都为123456。<br />
6.如果excel中缺少所在班级或者该账号已经存在系统中，则导入会失败，文件中的所有学生都不会被导入。
</p>
<?php }?>


<?php if(!empty($inputresult) && $inputresult['hasresult']){
		if($inputresult['result'] == true){?>
<p class="ptishi">导入成功，共导入 <?=$inputresult['rowcount']?> 条学生记录。</p>
<input class="xuetjbtn" type="button" value="继续导入" onclick="window.location.href='<?=geturl('aroom/student/input')?>'" />
<a href="<?=geturl('aroom/student')?>" class="flhui">返回</a>
	<?php }else{?>
<br />
<p class="ptishi" style="line-height:1.8;">很抱歉，导入失败，具体原因如下：<br />
<?=$inputresult['errormsg']?><br />
<?php if(!empty($inputresult['erroritems'])){
		foreach($inputresult['erroritems'] as $eitem){
			echo $eitem .'<br />';
}}?>

</p>
<input class="xuetjbtn" type="button" value="重新导入" onclick="window.location.href='<?=geturl('aroom/student/input')?>'" />
<a href="<?=geturl('aroom/student')?>" class="flhui" style="color:#065ed7;float:left;font-size:14px;margin:5px 0 0 10px;">返回</a>
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