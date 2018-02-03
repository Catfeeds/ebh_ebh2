<?php $this->display('aroomv2/page_header')?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />

<style type="text/css">
.cqshangc {
	padding-bottom:10px;
	width: 786px;
	border-bottom: 1px solid #cdcdcd;
	float:left;
	*margin-bottom:3px;
}
.cqshangc .sckezi {
	font-size: 14px;
	font-weight: bold;
	color: #6683c7;
	height: 35px;
	border-bottom: 1px solid #cdcdcd;
	padding-left: 20px;
	line-height: 35px;
}
.cqshangc .cqleftsc {
	float: left;
	width: 500px;
	font-size: 14px;
	margin-top: 15px;
}
.inpxuanx {
	height: 32px;
	border:none;
	text-indent:8px;
	overflow: hidden;
	font-size: 14px;
	line-height: 32px;
	display: block;
	color: #666666;
}
.cqshangc .cqrightsc {
    float: left;
    font-size: 14px;
    left: 500px;
    margin-top: 15px;
    position: absolute;
    width: 250px;
	top:90px;
}
.pxxuanx {
	height: 32px;
	display: block;
	float: left;
	line-height: 32px;
	padding-left: 20px;
}
.sds {
	height: 184px;
	width: 145px;
	border: 1px solid #cdcdcd;
	background:url(http://static.ebanhui.com/ebh/tpl/2012/images/dise.jpg) no-repeat center;
	margin-bottom: 8px;
	margin-left:50px;
}
.cqshangc .cqrightsc .cqbc {
	background: url(http://static.ebanhui.com/ebh/tpl/2012/images/xgtxbtn.png) no-repeat;
	height: 33px;
	line-height:33px;
	width: 120px;
	border:none;
	font-size: 14px;
	cursor:pointer;
	float: left;
	margin-left:70px;
	_margin-left:35px;
	display: block;
	color:#fff;
}
.cqshangc .cqrightsc .cqxg {
	background:url(http://static.ebanhui.com/ebh/tpl/2012/images/xiugai_inp01.png) no-repeat;
	height:35px;
	cursor:pointer;
	width: 70px;
	float: left;
	margin-left: 60px;
	margin-right: 10px;
	border:none;
}


.sds img {
	margin-top: 6px;
	margin-left: 8px;
}


.terlie li {
    background: none repeat scroll 0 0 #FFFFFF;
    border: 1px solid #B2D9F0;
    display: block;
    float: left;
    font-size: 14px;
    height: 20px;
    line-height: 20px;
    margin-bottom: 7px;
    margin-right: 5px;
    padding-top: 3px;
}
.terlie li a.labelnode {
    color: #0078B6;
    display: inline;
    float: left;
    height: 18px;
    line-height: 18px;
    padding: 0 7px;
    text-decoration: none;
    vertical-align: 4px;
}

.terlie li a.labeldel {
    float: left;
}
.terlie .mylabel a.labeldel img {
    background: url("http://static.ebanhui.com/ebh/tpl/2012/images/closebg_01.png") no-repeat scroll 0 0 transparent;
    display: inline-block;
    height: 12px;
    margin: 3px 4px 2px 0;
    width: 12px;
}
.terlie .mylabelhover a.labeldel img {
    background: url("http://static.ebanhui.com/ebh/tpl/2012/images/closebg_02.png") no-repeat scroll 0 0 transparent;
    display: inline-block;
    height: 12px;
    margin: 3px 4px 2px 0;
    width: 12px;
}
.coursecredit ,.examcredit ,.credittime {
	background: url("http://static.ebanhui.com/ebh/tpl/2012/images/inp_bg02.png") no-repeat scroll 0 0 transparent;
	width:112px;
	height:32px;
	line-height:32px;
	border:none;
	padding-left: 10px;
}
.remindmsg {
	background: url("http://static.ebanhui.com/ebh/tpl/2012/images/inp_bg01.png") no-repeat scroll 0 0 transparent;
	width:323px;
	height:32px;
	line-height:32px;
	border:none;
	padding-left: 10px;
}
.remindtime {
	background: url("http://static.ebanhui.com/ebh/tpl/2012/images/inp_bg03.jpg") no-repeat scroll 0 0 transparent;
	width:32px;
	height:32px;
	line-height:32px;
	border:none;
	padding-left: 10px;
}

/********eker整理 2016年1月25日16:24:57***********/
.leftdiv{
	border:solid 1px #cdcdcd;
	padding-bottom:0;
	border-bottom:none;
	background:#fff;
	float:left;
	margin-top:15px;
	width:786px;
}
.labelspan{
	float:left;
	margin-top:5px;
	width:26px;
}
.mlf10{
	margin-left:10px;
}
.kuaidiv{
	float:left;
	margin-top:6px
}
.kuaidiv span{
	float:left;
}
/****确认对话框 start***/
.dialogcont{
    height: 100px;
    margin: 0 auto;
    text-align: center;
    width: 339px;
}
.dialogcont .tishi{
    background: url("http://static.ebanhui.com/ebh/tpl/aroomv2/images/ico.jpg") no-repeat scroll 40px center;
    height: 36px;
    margin-left: 0;
    text-align: left;
    width: 339px;
}
.dialogcont .tishi p {
    padding-left: 90px; font-size: 16px; line-height: 35px;
}
.tables td a.taa{
	color: #666 !important;
    text-decoration: none;
}
/****确认对话框 end***/
</style>

<div class="ter_tit">当前位置 > 系统配置</div>
<div class="lefrig leftdiv" >
<form id="myform"  method="post">
<div class="cqshangc">
	<h2 class="sckezi">作业关联方式</h2>
<div id="hitdiv">
	<div class="cqleftsc">
	<span class="pxxuanx" style="">作业关联方式：</span>
	<div  class="kuaidiv">
		<label><input  class="labelspan" type="radio" value="0" <?=empty($cfobj->exam_relate_mode)? 'checked="checked"' : ''?> name="exam_relate_mode" /><span >默认</span></label>
		<label><input class="labelspan mlf10"  type="radio" value="1" <?=!empty($cfobj)&&($cfobj->exam_relate_mode==1)? 'checked="checked"' : ''?> name="exam_relate_mode" /><span >按班级年级</span></label>
		<label><input class="labelspan mlf10"  type="radio" value="2" <?=!empty($cfobj)&&($cfobj->exam_relate_mode==2)? 'checked="checked"' : ''?> name="exam_relate_mode" /><span >按课程</span></label>
	</div>
	</div>
	<div style="margin-top:15px;" class="xgtxBtn">
	<a class="borlanbtn btnlogo" style="margin-top:15px;" href="javascript:;" onclick="showpop()">确 认</a>
	</div>
</div>
</div>
</form>
</div>

<!--确认保存对话框-->
<div id="dialogsave" style="display:none">
	<div class="dialogcont">
		<div class="tishi mt40"><p>您确定要修改设置吗？</p></div>
	</div>
</div>

<script type="text/javascript">
function showpop(){
	var button = new xButton();
	button.add({
		value:"确定",
		callback:function(){
			H.get('dialogsave').exec('close');
			saveAjax();
			return false;
		},
		autofocus:true
	});

	button.add({
		value:"取消",
		callback:function(){
			H.get('dialogsave').exec('close');
			return false;
		}
	});
	if(!H.get('dialogsave')){
		H.create(new P({
			id : 'dialogsave',
			title: '提示消息',
			easy:true,
			width:400,
			padding:5,
			content:$('#dialogsave')[0],
			button:button
		}),'common');
	}
	H.get('dialogsave').exec('show');
}

function saveAjax(){
	var formdata  = $('#myform').serialize();
	$.ajax({
		url:'<?=geturl('aroomv2/sysconfig/doajax')?>',
		type:'post',
		dataType:'json',
		data:formdata,
		success:function(json){
			dialogtip();
			if(!json.code){
				H.get('xtips').exec('setContent','保存成功!').exec('show').exec('close',1000);
			}else{
				H.get('xtips').exec('setContent','保存失败,请刷新后重试!').exec('show').exec('close',1000);
				}
			},
		error:function(){
			alert("服务器连接错误，请重试");
			}
		});
	}
function dialogtip(){
	if(!H.get('xtips')){
		H.create(new P({
			id:'xtips',
			easy:true,
			padding:10
		},{
			onclose:function(){
				location.reload(true);
			}
		}),'common');
	}
}
</script>
<?php $this->display('aroomv2/page_footer')?>