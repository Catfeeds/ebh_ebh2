<?php $this->display('college/page_header'); ?>
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/dayi.css?v=20160325" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" />	
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/upload.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js?v=20150731"></script>
<link type="text/css" href="http://static.ebanhui.com/js/soundManager2/css/voicePlayer.css" rel="stylesheet" />
<style>
<?php
    $roominfo = Ebh::app()->room->getcurroom();
    $roominfo['crid'] = empty($roominfo['crid'])?0:$roominfo['crid'];
    if(!empty($roominfo['crid'])){
        $other_config = Ebh::app()->getConfig()->load('othersetting');
        $other_config['zjdlr'] = !empty($other_config['zjdlr']) ? $other_config['zjdlr'] : 0;
        $other_config['newzjdlr'] = !empty($other_config['newzjdlr']) ? $other_config['newzjdlr'] : array();
        $is_zjdlr = ($roominfo['crid'] == $other_config['zjdlr']) || (in_array($roominfo['crid'],$other_config['newzjdlr']));
        $is_newzjdlr = in_array($roominfo['crid'],$other_config['newzjdlr']);
    }
?>
<?php if(!empty($imgsrc)){ ?>
body{
	margin-left: 15px;
}
<?php } ?>
.lefkty em{
	line-height:28px;
}
.wenzid{
	font-weight:bold;
	color:#777;
}
html{
	background:<?=!$is_zjdlr?'#f2f2f2':'none'?>;
}
.leftke{
	width:88px;
	text-align:left;
}
.trekt{
	border:0;
}
.biaowaim .titwenti{ width:965px;}
.etklys{
	width:68px;
}
a.remove-img {
    border: 0 none;
    display: none;
    height: 17px;
    position: absolute;
    right: 5px;
    text-decoration: none;
    top: 5px;
    width: 17px;
}
a.remove-img:link {
    border: 0 none;
    display: none;
    height: 17px;
    text-decoration: none;
    width: 17px;
}
a.remove-img:visited {
    border: 0 none;
    display: none;
    height: 17px;
    text-decoration: none;
    width: 17px;
}
a.remove-img:hover {
    border: 0 none;
    display: none;
    height: 17px;
    text-decoration: none;
    width: 17px;
}
a.remove-img:active {
    border: 0 none;
    display: none;
    height: 17px;
    text-decoration: none;
    width: 17px;
}
.languan{
	background:url(http://static.ebanhui.com/ebh/tpl/troomv2/images/hrsire.png) no-repeat;
}
.sckcfm li {
    height: 110px;
    margin-bottom: 10px;
    margin-right: 10px;
}
.glitus{
	display: block;
    height: 108px;
    left: 1px;
    opacity: 0;
	filter: progid:DXImageTransform.Microsoft.Alpha(opacity=0);
    position: absolute;
    top: 1px;
    width: 178px;
}
</style>
<div style="height:1500px;width:788px;float:left;<?php if(!empty($imgsrc)) echo 'height:900px' ?>">

<div class="lefrig" style="width:998px;">
<div class="workol" style="margin-top:0px">

	<div class="tit_search" style="margin-top:0px">
<form id="askform" >
<div class="biaowaim" style="width:1000px;border:none;">
  <input class="titwenti" name="title" id="title" type="text" value="" maxlength="30"/>
  <div class="txtxdaru" style="float:left;width:983px;display: inline;">

  <?php $editor->xEditor('message','99%','500px'); ?>

  </div>
  <div style="clear:both;"></div>
 
<div style="clear:both;"></div>
	<div class="fontfen" id="doheight">
	<input class="tijibtn" style="margin-left:404px;width:190px;margin-right:20px;float:left;" type="button" value="发表文章" />
	</div>
</div>
</form>
</div>
</div>

<script type="text/javascript">
function checkquestion() {
	if($.trim($("#title").val()) == "" || $.trim($("#title").val()) == titletips) {
		top.dialog({
			title: '提示信息',
			content: '标题不能为空！',
			width:370,
			cancel: false,
			okValue: '确定',
			ok: function () {
			}
		}).showModal();	
		return false;
	}
        var message = UE.getEditor('message').getContent();
        if(message == "") {
			top.dialog({
				title: '提示信息',
				content: '内容不能为空！',
				width:370,
				cancel: false,
				okValue: '确定',
				ok: function () {
				}
			}).showModal();	
			return false;
		}
	return true;
}
var titletips = "请输入文章标题，30字以内";
$(function(){
	settips("title",titletips);
    $(".tijibtn").click(function(){
        addquestion();
    });
});
function settips(id,tips) {
	if($.trim($("#"+id).val()) == "") {
		$("#"+id).val(tips);
		$("#"+id).addClass("titwentigray");
	}
	$("#"+id).click(function(){
		if($.trim($(this).val()) == tips) {
			$(this).val("");
			$(this).removeClass("titwentigray");
		}
	});
	$("#"+id).blur(function(){
		if($.trim($(this).val()) == "") {
			$(this).val(tips);
			$(this).addClass("titwentigray");
		}
	});
}
function addquestion() {
	if (!checkquestion()) {
		return false;
	}
	$.ajax({
		url:"<?= geturl('college/myarticle/addArticle') ?>",
		type: "POST",
		data:$("#askform").serialize(),
		dataType:"json",
		success: function(data){
			if (data.code == 1) {
			var d=	top.dialog({
				title: '提示信息',
				content: '发表成功',
				width:370,
				cancel: false,
					okValue: '确定',
					ok: function () {
						window.location.href = '/college/myarticle.html';
					}
				}).showModal();
				setTimeout(function(){
					d.close().remove();
					window.location.href = '/college/myarticle.html';
				},2000);
				
			} else {
				top.dialog({
				title: '提示信息',
				content: '发表失败',
				width:370,
				cancel: false,
					okValue: '确定',
					ok: function () {
					}
				}).showModal();
			}
        }
	});
}
function shortstr(str){
	var result = str.substr(0,22);
	if(result.length<str.length)
		result+= '...';
	return result;
}
</script>
<?php $this->display('myroom/page_footer'); ?>