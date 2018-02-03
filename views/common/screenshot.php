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
<link href="http://static.ebanhui.com/js/dialog/css/dialog.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/dialog/dialog-plus.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/vendor/swfobject.js?v=1"></script>

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
		font-family: Arial, Helvetica, Microsoft YaHei, sans-serif;
		font-weight: normal;
	}
body{
	background: #fff;
}
.classbox{
	border: 0;
}
.borlanbtn{
	margin-top: 30px;
	float: right;
	background: #5E96F5;
	border-color: #5E96F5;
	border-radius: 3px;
	font-size: 12px;
	cursor: pointer;
	border: solid 1px #108ed4;
	width: 90px;
	height: 26px;
	line-height: 26px;
	display: block;
	color: #fff;
	text-decoration: none;
	text-align: center;
	font-family: inherit;
	padding: 0;
}
.box{
	margin-top: 30px;
}
#borlanbtn{
	margin-right:20px;
	margin-top: 30px;
	float: right;
	background: #5E96F5;
	font-size: 12px;
	cursor: pointer;
	border: solid 1px #108ed4;
	width: 90px;
	height: 26px;
	line-height: 26px;
	display: block;
	color: #fff;
	text-decoration: none;
	text-align: center;
	font-family: inherit;
	padding: 0;
}
</style>
</head>
<body>
<!-- <div style="width:825px;margin:0 auto;"> -->
<div class="box">
	<div>
		<img src="<?php echo $imgsrc ?>" style="height:380px;width:665px">
		<input type="hidden" value="<?php echo $imgsrc ?>" id="imgsrc">
	</div>
	<div id="subform">
		<input type="button" onclick="editScreenShot()" class="borlanbtn" style="margin-right:40px" value="图片编辑"/>
		<div id="box">
			<div id="borlanbtn" style="z-index:1;position:relative;"></div>
		</div>
		
		<div style=''>
			<div id="borlanbtn2" ></div>
		</div>
	</div>
</div>
</body>
<script>
var flashvars = {
};
var params = {
	menu: "false",
	scale: "noScale",
	allowFullscreen: "true",
	allowScriptAccess: "always",
	bgcolor: "",
	wmode: "transparent" // can cause issues with FP settings & webcam
};
var attributes = {
	id:"borlanbtn"
};
var url = $("#imgsrc").val();
swfobject.embedSWF(
	"http://ss.ebh.net/static/flash/screenshotSave.swf?url="+url, 
	"borlanbtn", "100px", "30px", "10.0.0", 
	"", flashvars, params, attributes);
	var H = parent.window.H;
	var P = parent.window.P;
	var xButton = parent.window.xButton;
	var HTools = parent.window.HTools;
	var xFparam = {
		id:'spjtswf',
		uri:'http://'+window.location.host+'/static/flash/couseEditor.swf<?= getv() ?>'
	}
	var button = new xButton();
	button.add({
        value: '我要提问',
        callback: function () {
           	openAskQuestionDialog();
           	return false;
        },
        autofocus: true
	});

	H.create(new P({
		id:'spjt',
		title:'截图编辑',
		easy:true,
		flash:HTools.pFlash(xFparam),
		button:button
	},{'onshow':function(){
		showCallback();
	},'onclose':function(){
		// showConfirmDialog();
		var flashObj = parent.document.getElementById('flvcontrol');
		flashObj._play();
		parent.H.get('artdialogss').exec('destroy');
	}}),'common');

	function saveScreenShotToLocal(){
		var xFparam = {
			id:'spjtswf',
			uri:'http://'+window.location.host+'/static/flash/couseEditor.swf<?= getv() ?>'
		};
	}
	function editScreenShot(){
		var img = $('#imgsrc').val();
		H.get('spjt').setData("img",img);
		H.get('spjt').exec('show');
	}
	function saveComplete(){
		var flashObj = parent.document.getElementById('flvcontrol');
		flashObj._play();
		H.get('artdialogss').exec('destroy');
	}
	function saveClose(){
		var flashObj = parent.document.getElementById('flvcontrol');
		flashObj._play();
		H.get('artdialogss').exec('destroy');
	}
	function showCallback(){
		var img = H.get('spjt').getData('img');
		if(img){
			var swf = HTools.getFlash('spjtswf').swf;
			if(swf&&swf.pushImage){
				swf.pushImage(img);
			}else{
				setTimeout(function(){
					showCallback(swf);
				},200);
			}
		}
	}
	function showConfirmDialog(){
		dialog({
                id: "confirmDialog", //可选
                title: "退出编辑",
                content: "",
                okValue: "确定",
                ok: function() {
                	H.get('spjt').exec('hide');
                },
                cancelValue: "取消",
                cancel: function() {
               
                }
            }).showModal();

	}
	function openAskQuestionDialog()
	{
		var panelObj = HTools.getFlash('spjtswf').swf;
		panelObj.setScreenUpload('<?= $uppicapi ?>');
		
	}
</script>

</html>
