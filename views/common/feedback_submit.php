<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $course['title']?></title>
<meta name="keywords" content="<?= empty($subkeywords) ? $this->get_keywords() : $subkeywords ?>" />
<meta name="description" content="<?= empty($subdescription) ? $this->get_description() : $subdescription?>" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
<style>
.waifg {
	width:825px;margin-left:10px;float:left;margin-bottom:10px;
}
.waifg h2 {
margin:20px 0;font-size:14px;font-weight:bold;float:left;
}
.ekwt {
width:825px;float:left;
}
.ewjtt {
float:left;width:150px;margin-left:15px;
}
.ektrr {
float:left;margin-top:4px;
height:20px;
width:20px;
}
.eryekx {
float:left;height:25px;line-height:35px;margin-left:6px;font-size:20px;
}
.cright {float:none;display: block;margin: 0 auto;width:825px;margin-bottom:20px;min-height:500px;}
.classbox {width:825px;background: #FFF;height:500px}
.fyinput{
	height: 32px;
	text-indent: 8px;
	overflow: hidden;
	font-size: 14px;
	line-height: 32px;
	display: block;
	color: #666666;
	width: 800px;
	
}
.tijibtn {
		float: left;
		background: #18a8f7;
		width: 190px;
		height: 32px;
		display: inline;
		float: left;
		line-height: 32px;
		text-align: center;
		margin-left: 330px;
		margin-top: 240px;
		color: #fff;
		font-size: 14px;
		text-decoration: none;
		cursor: pointer;
		border: none;
	}
body{
	background: #fff;
}
.classbox{
	border: 0;
}
</style>
</head>
<body>
<div style="width:825px;margin:0 auto;">
<div class="cright">
	<div class="lefrig" style="margin-top:10px;float:none;">
		<div class="classbox" style="padding-bottom: 10px;">
		<div id="subform">
		<form action="/feedback/add.html" method="POST" onsubmit="return checkform()" id="fbform">
			<input type="hidden" name="cwid" value="<?=$course['cwid']?>"/>
			<div class="waifg">
			<h2>听课反馈:</h2>
			<div class="ekwt">
				<label class="ewjtt"><input type="radio" class="ektrr" name="feedback" value="0"/><span class="eryekx">听懂</span></label>
				<label class="ewjtt"><input type="radio" class="ektrr" name="feedback" value="1"/><span class="eryekx">一知半解</span></label>
				<label class="ewjtt"><input type="radio" class="ektrr" name="feedback" value="2"/><span class="eryekx">听不懂</span></label>
			</div>
			<h2>难易度:</h2>
			<div class="ekwt">
				<label class="ewjtt"><input type="radio" class="ektrr" name="difficulty" value="0"/><span class="eryekx">容易</span></label>
				<label class="ewjtt"><input type="radio" class="ektrr" name="difficulty" value="1"/><span class="eryekx">一般</span></label>
				<label class="ewjtt"><input type="radio" class="ektrr" name="difficulty" value="2"/><span class="eryekx">较难</span></label>
			</div>
			<h2>课程质量:</h2>
			<div class="ekwt">
				<label class="ewjtt"><input type="radio" class="ektrr" name="quality" value="0"/><span class="eryekx">很好</span></label>
				<label class="ewjtt"><input type="radio" class="ektrr" name="quality" value="1"/><span class="eryekx">不错</span></label>
				<label class="ewjtt"><input type="radio" class="ektrr" name="quality" value="2"/><span class="eryekx">一般</span></label>
				<label class="ewjtt"><input type="radio" class="ektrr" name="quality" value="3"/><span class="eryekx">声音不佳</span></label>
				<label class="ewjtt"><input type="radio" class="ektrr" name="quality" value="4"/><span class="eryekx">图像不佳</span></label>
			</div>
			<h2>讲课水平:</h2>
			<div class="ekwt">
				<label class="ewjtt"><input type="radio" class="ektrr" name="level" value="0"/><span class="eryekx">很精彩</span></label>
				<label class="ewjtt"><input type="radio" class="ektrr" name="level" value="1"/><span class="eryekx">还不错</span></label>
				<label class="ewjtt"><input type="radio" class="ektrr" name="level" value="2"/><span class="eryekx">一般般</span></label>
				<label class="ewjtt"><input type="radio" class="ektrr" name="level" value="3"/><span class="eryekx">有气无力</span></label>
			</div>
			<h2>附言:</h2>
			<div class="ekwt">
			<input type="text" class="fyinput" name="text" maxlength="100"/>
			</div>
			<!--
			<div class="ekwt">
				<textarea style="width:950px;height:150px;font-size:20px;resize:none" name="text"></textarea>
			</div>-->
			<input type="button" onclick="submitform()" class="borlanbtn" style="margin-top:30px;" value="提交反馈"/>
			</div>
		</form>
		</div>
		<div id="subsucc" style="display:none">
			<input type="button" class="tijibtn" value="查看结果" onclick="window.open('/feedback/<?=$course['cwid']?>.html')"/>
		</div>
		</div>
		
	</div>
</div>
</div>
</body>
<script>
	function checkform(){
		var fradio = document.getElementsByName('feedback');
		var dradio = document.getElementsByName('difficulty');
		var qradio = document.getElementsByName('quality');
		var lradio = document.getElementsByName('level');
		checkf = haschecked(fradio);
		checkd = haschecked(dradio);
		checkq = haschecked(qradio);
		checkl = haschecked(lradio);
		if(checkf && checkd &&checkq &&checkl)
			return true;
		
		alert('每一种反馈类型都需要选择');
		return false;
		
	}
	function haschecked(radios){
		var res=false;
		for (var x=0; x<radios.length; x++) {
			if(radios[x].checked)
				res = true;
		}
		return res;
	}
	function submitform(){
		if(!checkform())
			return false;
		$.ajax({
			type : 'post',
			url : '/feedback/add.html',
			data : $('#fbform').serialize(),
			async : false,
			success : function(data){
				// window.open('/feedback/<?=$course['cwid']?>.html');
				$('#subform').hide();
				$('#subsucc').show();
			}
		});
		// parent.closedialog();
		
		
	}
</script>

</html>
