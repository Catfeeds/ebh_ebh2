<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php $systemsetting = Ebh::app()->room->getSystemSetting(); ?>
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<title>互动课堂修改</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css<?=getv()?>"/>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js?v=20150731"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.form.js?v=20150731"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/selcur/css/lnclass.css<?=getv()?>" />
</head>
<body style=" background:#f3f3f3;">


<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/tzds.css" rel="stylesheet" />

<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/dayi.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/survey.css?version=20161121001" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/selcur/css/interactive.css<?=getv()?>" />
<style>
/*关联课件 css*/
.relatefs{
	width:758px;
	float:left;
	display:block;
	padding:15px;
	margin-bottom:10px;
	font-size:14px;
}

.relatecw{
	display:none;
}
.btndiv{
	float:left;
	margin-left:20px;
	width:750px;
	padding-bottom:20px;
	padding-top:10px;
}
.btndiv a.prvbtn{
  background: #f57b24;
  width: 100px;
  height: 22px;
  display: inline;
  float: left;
  line-height: 22px;
  text-align: center;
  color: #fff;
  text-decoration: none;
  margin-left: 20px;
  cursor: pointer;
  border: none;
}
.btndiv a.subbtn{
  background: #18a8f7;
  width: 100px;
  height: 22px;
  display: inline;
  float: left;
  line-height: 22px;
  text-align: center;
  color: #fff;
  text-decoration: none;
  margin-left: 20px;
  cursor: pointer;
  border: none;
}
.relatelgd{
	padding:6px;
	font-size:18px;
	font-weight:bold;
	font-family:'Microsoft YaHe';
	color:#444;
}
.relatefs div label {
	width:160px;
	margin-left:20px;
	float:left;
	display:inline;
	cursor: pointer;
}
.relatefs input[type="radio"]{margin:0 5px;}
.qisties {
    background: rgba(0, 0, 0, 0) url("http://static.ebanhui.com/ebh/tpl/troomv2/images/riliico.jpg") no-repeat scroll left center;
    border: 1px solid #d5d5d5;
    height: 24px;
    line-height: 24px;
    padding-left: 25px;
    width: 120px;
}
.sjzjf {
    color: #999;
    line-height: 25px;
}
.addzhu {
	margin-top: 3px;
    padding: 5px 0;
	display: inline-block;
	width:180px;
	height:120px;
	position:relative;
}
.addzhu a.delet {
	width:14px;
	height:14px;
	display:block;
	position:absolute;
	top:-2px;
	right:-7px;
	background:url(http://static.ebanhui.com/ebh/tpl/selcur/images/delerig.png) no-repeat;
}
.assignbtn:hover{
	color:#fff;
	text-decoration: none;
}
.awaybtn:hover{
	color:#999;
	text-decoration: none;
}
.gusnre{
	padding-top:10px;
	height:210px;
}
</style>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/iacourseadd.js?v=004"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
	<div class="leersd clearfix" style="margin-bottom:70px;">
		<div class="survey_main fl">
			<!--标题-->
			<div class="survey_title" style="position:relative">
				<div class="h4-bg T_edit p_title" id="survey_title_0" style="display: block;"><?php echo $iainfo['title']?></div>
				<input id="sid" value="0" type="hidden">
			</div>
			<!--参与课程-->
			<div class="juisrre">
				<span class="flsred">参与课程：</span>
				<div style="float:left;" class="folderlist">
					<?php if(!empty($iainfo['folderids'])){ ?>
						<?php 
							$folderid = json_decode($iainfo['folderids'],true);
							$foldername = json_decode($iainfo['foldernames'],true);
						?>
					<?php foreach ($folderid as $k => $fid) { ?>
					<div class="lantewu" fid="<?php echo $fid;?>"><a class="languan" onclick="removefolder(this)" href="javascript:void(0)"></a><?php echo $foldername[$k]?></div>
					<?php }?>
					<?php }?>
				</div>
				<a class="flsred" id="addhude" href="javascript:void(0)"><img src="http://static.ebanhui.com/ebh/tpl/selcur/images/addhude.jpg"></a>
			</div>
			<!--内容-->
			<div id="survey_content">
			<?php if(empty($question)){?>
				<img style="margin-left:70px;" src="http://static.ebanhui.com/ebh/tpl/selcur/images/mosrets.jpg">
			<?php }else{ ?>
				<?php foreach ($question as $ques) { ?>
					<?php if($ques[0]['type'] == 2){?>
				<div class="topic_type" qid="<?php echo $ques[0]['order'];?>" qtype="3">
					<div class="topic_type_menu">
						<div class="setup-group">
							<h4>Q<?php echo $ques[0]['order'];?></h4>
							<a href="javascript:;" title="上移本题" class="sq_up" style="display: none;">
								<i class="up-icon-active"></i>
							</a>
							<a href="javascript:;" title="下移本题" class="sq_down" style="display: none;">
								<i class="down-icon-active"></i>
							</a>
							<a href="javascript:;" title="删除题目" class="sq_del" style="display: none;">
								<i class="del-icon-active"></i>
							</a>
						</div>
					</div>
					<div class="topic_type_con">
						<div class="topic_question">
							<div class="th4 T_edit q_title" id="survey_question_<?php echo $ques[0]['order'];?>" style="display: block;">
								<?php echo $ques[0]['title'];?>
							</div>
						</div>
						<ul class="unstyled">
							<div class="addzhu">
							<a href="javascript:;" id="qid_<?php echo $ques[0]['order'];?>" onclick="subjectiveupload(<?php echo $ques[0]['order'];?>);">
								<?php if(!empty($ques[0]['urlpath'])){?>
								<img src="<?php echo $ques[0]['urlpath'];?>" style="width:180px;height:120px;">
								<?php }else{?>
								<img src="http://static.ebanhui.com/ebh/tpl/selcur/images/addmor.jpg" style="width:180px;height:120px;">
								<?php }?>
							</a>
							<?php if(!empty($ques[0]['urlpath'])){?>
							<a class="delet" href="javascript:;" style="" onclick="delimg(<?php echo $ques[0]['order'];?>)">
							<?php }else{?>
							<a class="delet" href="javascript:;" style="display:none;" onclick="delimg(<?php echo $ques[0]['order'];?>)">
							<?php }?>
							</a>
							</div>
						</ul>
					</div>
				</div>
				<?php }else if($ques[0]['type'] == 0){?>
				<div class="topic_type" qid="<?php echo $ques[0]['order'];?>" qtype="1">
					<div class="topic_type_menu">
						<div class="setup-group">
							<h4>Q<?php echo $ques[0]['order'];?></h4>
							<a href="javascript:;" title="上移本题" class="sq_up" style="display: none;">
								<i class="up-icon-active"></i>
							</a>
							<a href="javascript:;" title="下移本题" class="sq_down" style="display: none;">
								<i class="down-icon-active"></i>
							</a>
							<a href="javascript:;" title="添加选项" class="sop_add" style="display: none;">
								<i class="add-icon-active"></i>
							</a>
							<a href="javascript:;" title="删除题目" class="sq_del" style="display: none;">
								<i class="del-icon-active"></i>
							</a>
						</div>
					</div>
					<div class="topic_type_con">
						<div class="topic_question">
							<div class="th4 T_edit q_title" id="survey_question_<?php echo $ques[0]['order'];?>"><?php echo $ques[0]['title'];?></div>
						</div>
						<ul class="unstyled">
						<?php foreach ($ques as $option) {?>
							<li>
								<input name="radio" type="radio">
								<div class="op_content">
									<div id="survey_option_<?php echo $option['qid'];?>" class="op4 T_edit q_option"><?php echo $option['content'];?></div>
								</div>
							</li>
						<?php }?>
						</ul>
					</div>
				</div>
				<?php }else if($ques[0]['type'] == 1){?>
				<div class="topic_type" qid="<?php echo $ques[0]['order'];?>" qtype="2">
					<div class="topic_type_menu">
						<div class="setup-group">
							<h4>Q<?php echo $ques[0]['order'];?></h4>
							<a href="javascript:;" title="上移本题" class="sq_up" style="display: none;">
								<i class="up-icon-active"></i>
							</a>
							<a href="javascript:;" title="下移本题" class="sq_down" style="display: none;">
								<i class="down-icon-active"></i>
							</a>
							<a href="javascript:;" title="添加选项" class="sop_add" style="display: none;">
								<i class="add-icon-active"></i>
							</a>
							<a href="javascript:;" title="删除题目" class="sq_del" style="display: none;">
								<i class="del-icon-active"></i>
							</a>
						</div>
					</div>
					<div class="topic_type_con">
						<div class="topic_question">
							<div class="th4 T_edit q_title" id="survey_question_<?php echo $ques[0]['order'];?>">多选题</div>
						</div>
						<ul class="unstyled">
						<?php foreach ($ques as $options) {?>
							<li>
								<input name="checkbox" type="checkbox">
								<div class="op_content">
									<div id="survey_option_<?php echo $options['qid'];?>" class="op4 T_edit q_option"><?php echo $options['content'];?></div>
								</div>
							</li>
						<?php }?>
						</ul>
					</div>
				</div>
				<?php }else{ ?>
				<div class="topic_type" qid="<?php echo $ques[0]['order'];?>" qtype="4">
					<div class="topic_type_menu">
						<div class="setup-group">
							<h4>Q<?php echo $ques[0]['order'];?></h4>
							<a href="javascript:;" title="上移本题" class="sq_up" style="display: none;">
								<i class="up-icon-active"></i>
							</a>
							<a href="javascript:;" title="下移本题" class="sq_down" style="display: none;">
								<i class="down-icon-active"></i>
							</a>
							<a href="javascript:;" title="删除题目" class="sq_del" style="display: none;">
								<i class="del-icon-active"></i>
							</a>
						</div>
					</div>
					<div class="topic_type_con">
						<div class="topic_question">
							<div class="th4 T_edit q_title" id="survey_question_<?php echo $ques[0]['order'];?>"><?php echo $ques[0]['title']?></div>
						</div>
						<ul class="unstyled">
						</ul>
					</div>
				</div>
				<?php } ?>
				<?php } ?>
				<?php } ?>
			</div>
		</div>

		<div id="sidebar" class="survey_toolbar fl" data-spy="affix">
			<div class="talieer">
				<h4>添加题型</h4>
				<ul class="ul-tool collapse" style="display: block;">
					<li class="moduleL">
						<a href="javascript:;" qtype="1">
							<i class="basic-too11-icon-active"></i>
							单选题
						</a>
					</li>
					<li class="moduleL">
						<a href="javascript:;" qtype="2">
							<i class="basic-too12-icon-active"></i>
							多选题
						</a>
					</li>
					<li class="moduleL">
						<a href="javascript:;" qtype="3">
							<i class="zhust"></i>
							主观题
						</a>
					</li>
					<li class="moduleL">
						<a href="javascript:;" qtype="4">
							<i class="wentis"></i>
							文字题
						</a>
					</li>
				</ul>
			</div>
			
		</div>
	</div>
</div>
<div id="seEditDialog" style="display:none">
	<?php $editor->xEditor('message','700px','300px');?>
</div>
<div id="form">
	<form id="form1" method="post" style="display:none;">
		<input type="file" id="uploadfile" name="upfile" />
	</form>
</div>
<!--上传图片对话框-->
<div id="upImgDialog" style="display:none">
	<iframe id="upframe" name="upframe" scrolling="auto" marginheight="0" marginwidth="0" frameborder="0" width="500" height="200" src="/troomv2/iacourse/uploadimage.html"></iframe>
</div>
<!--主观题上传图片对话框-->
<div id="upImgDialogtype" style="display:none">
	<iframe id="upframetype" name="upframetype" scrolling="auto" marginheight="0" marginwidth="0" frameborder="0" width="500" height="200" src="/troomv2/iacourse/uploadimage.html"></iframe>
</div>
<!--尾部-->
<div class="bottban" style="position:fixed;bottom:0;">
	<div class="nsrtrsr">
		<div class="botlef1">
			题数：
			<span class="husret"> <?php echo $iainfo['questioncount'];?> </span>
			道
		</div>
		<div class="botlef2">
			<a class="tsidbtn" href="javascript:;" onclick="submit();">保存</a>
			<!--没内容用这个按钮<a class="husiebtn" href="javascript:;">保存</a>-->
		</div>
		<div class="botlef3">
			<a class="huitop" href="javascript:smoothscroll();">返回顶部</a>
		</div>
	</div>
</div>
<div class="waistfe" id="folderdiv" style="display:none;">
	<p class="lianp">请选择课程，课程下的学员将参加互动</p>
    <div class="gusnre">
    <?php if($roominfo['isschool'] == 7){?>
    	<?php if(!empty($packege)){?>
    		<?php foreach ($packege as $key => $pack) {?>
		    	<h2 class="hanstit" style="font-weight:bold;"><?php echo $key;?></h2>
		    	<?php foreach ($pack as $pk) {?>
		    		<?php if(isset($pk['foldername'])){?>
		    		<?php if(in_array($pk['folderid'],$folderid)){?>
		        <div class="denst denhover" fid=<?php echo $pk['folderid'];?>><?php echo $pk['foldername'];?></div>
		        	<?php }else{?>
		        <div class="denst" fid=<?php echo $pk['folderid'];?>><?php echo $pk['foldername'];?></div>	
		        	<?php }?>
		        	<?php }?>
		        <?php }?>
        	<?php }?>
        <?php }?>
    <?php }else{?>
    	<?php if(!empty($folders)){?>
    		<?php foreach ($folders as $folder) {?>
    			<?php if(in_array($folder['folderid'],$folderid)){?>
    			<div class="denst denhover" fid=<?php echo $folder['folderid'];?>><?php echo $folder['foldername'];?></div>
    			<?php }else{?>
    				<div class="denst" fid=<?php echo $folder['folderid'];?>><?php echo $folder['foldername'];?></div>
    			<?php }?>
    		<?php }?>
    	<?php }?>
    <?php }?>
    </div>
    <a class="assignbtn" href="javascript:;" onclick="H.get('folderDialog').exec('close');">确定</a>
	<a class="awaybtn" href="javascript:;" onclick="H.get('folderDialog').exec('close');">取消</a>
</div>
<script>
$(function(){
	//Affix
	var ost = $('#sidebar').offset().top;
	$(window).scroll(function() {
		var st = document.documentElement.scrollTop || document.body.scrollTop;
		if (st >= ost)
			$('#sidebar').addClass('affix');
		else
			$('#sidebar').removeClass('affix');
	});
});
//弹出弹窗
$("#addhude").on('click',function(){
    var html = $('#folderdiv')[0];
	H.create(new P({
		id : 'folderDialog',
		title: '添加课程',
		content:html,
		easy:true
	}),'common').exec('show');
})
//选择课程点击添加class
$(".denst").on('click',function(){
	if($(this).hasClass('denhover')){
		$(this).removeClass('denhover');
	}else{
		$(this).addClass('denhover');
	}
});
//确认选择课程
$(".assignbtn").on('click',function(){
	var folderarr = new Array();
	var folder = new Array();
	$(".denst").each(function(){
		if($(this).hasClass('denhover')){
			folder.push($(this).html(),$(this).attr('fid'));
			folderarr.push(folder);
			folder = new Array();
		}
	});
	var hash = {};  
	var result = [];  
	for(var i = 0, len = folderarr.length; i < len; i++){  
	    if(!hash[folderarr[i]]){  
	        result.push(folderarr[i]);  
	        hash[folderarr[i]] = true;  
	    }  
	}
	var html = '';
	$.each(result,function(i,n){
		html+='<div class="lantewu" fid="'+n[1]+'"><a class="languan" onclick="removefolder(this)" href="javascript:void(0)"></a>'+n[0]+'</div>';
	});
	$(".folderlist").html(html);

});
//删除课程
function removefolder(obj){
	$(obj).parent().remove();
	var fid = $(obj).parent().attr('fid');
	$(".gusnre .denst").each(function(){
		if($(this).attr('fid') == fid){
			$(this).removeClass('denhover');
		}
	});
}
$(function(){
	var ost = $('#sidebar').offset().top;
	$(window).scroll(function() {
		var st = document.documentElement.scrollTop || document.body.scrollTop;
		if (st >= ost)
			$('#sidebar').addClass('affix');
		else
			$('#sidebar').removeClass('affix');
	});
});
var submitFlag = true;
function submit(){
	$(".topic_type_error").remove();
	var sid = $('#sid').val();
	var title_content = '';
	if($("#input_title_"+sid).html() != undefined){
		title_content = $("#input_title_"+sid).html();
	} else {
		title_content = $('.p_title').html();
	}
	title_content = $.trim(title_content);
	if(title_content == '单击此处添加标题' || title_content == ''){
		$("html,body").animate({
			scrollTop: $(".p_title").offset().top-50
		}, 'fast');
		alert('请输入标题');
		setTimeout(function() {
			$('.p_title')[0].click();
		}, 200);
		return;
	}
	//至少添加1个题目
	if ($('.topic_type').length == 0){
		$("#survey_content").append('<div style="padding:8px 15px; background:#fcecec; color:#f2395b;" class="topic_type_error">请至少添加1个题目</div>');
		$("html,body").animate({
			scrollTop: $("#survey_content").offset().top-50
		}, 'fast');
		return;
	}
	//至少添加1个选项
	var check_question = true;
	$.each($('.topic_type'),function(k,v){
		if($(this).attr('qtype') == 1 || $(this).attr('qtype') == 2){
			if($(this).find("ul.unstyled li").length == 0){
				var qid = $(this).attr("qid");
				$(this).before('<div style="padding:8px 15px; background:#fcecec; color:#f2395b;" class="topic_type_error">请至少添加1个选项</div>');
				$("html,body").animate({
					scrollTop: $("#survey_question_"+qid).offset().top-50
				}, 'fast');
				check_question = false;
				return false;
			}
		}
		
	});
	if ( ! check_question){
		return;
	}
	//组合试卷主体内容
	var content = new Array();
	$.each($('.topic_type'),function(k,v){
		var q = new Object();
		q.title = $(this).find('.q_title').html();
		q.type = $(this).attr('qtype');
		q.item = Array();
		if(q.type == 1 || q.type == 2){
			$.each($('.topic_type:eq('+k+') .q_option'),function(ik,iv){
				q.item.push($(this).html());
			});
		}else if(q.type == 3){
			var imgsrc = $('.topic_type:eq('+k+') .addzhu img').attr('src');
				if(imgsrc != 'http://static.ebanhui.com/ebh/tpl/selcur/images/addmor.jpg'){
					q.item.push(imgsrc);
				}
		}
		content.push(q);
	});
	//选择的课程列表
	var folders = new Array();
	var foldflag = false;
	$(".folderlist .lantewu").each(function(){
		var folder = new Array();
		folder.push($(this).attr('fid'));
		folder.push($(this).text());
		folders.push(folder);
		if($(this).attr('fid') != undefined || $(this).attr('fid') != ''){
			foldflag = true;
		}
	});
	if(!foldflag){
		alert('请至少添加1个关联课件');
		return false;
	}
	//题目数量
	var quesnum = $(".husret").html();
	if (submitFlag) {
		submitFlag = false;
	} else {
		return false;
	}
	$.ajax({
		type:'post',
		url:'/troomv2/iacourse/edit/'+<?php echo $icid;?>+'.html',
		data:{'title':title_content,'content':content,'folderid':folders,'quesnum':quesnum},

		success:function(data){
			submitFlag = true;
			if(data == 1){
				$.showmessage({
					message:'修改成功！',
					timeoutspeed:1000,
					callback:function(){
						window.opener.location.reload();
						window.close();
					}
				});
			}
			
		}
	});
}
function innerTextConvert(ele,text){
	if(window.navigator.userAgent.toLowerCase().indexOf("firefox")!=-1)
	{
		ele.textContent=text;
	}
	else
	{
		ele.innerText=text;
	}
}
function shortstr(str){
	var result = str.substr(0,18);
	if(result.length<str.length)
		result+= '...';
	return result;
}
qqid = '';
function subjectiveupload(qid){
	qqid = 'qid_'+qid;
	var button = new xButton();
			button.add({
				value:"确定",
				callback:function(){
					var upfilepath = $(window.frames["upframetype"].document).find("#up\\[upfilepath\\]").val();
					if(upfilepath != '' && upfilepath != undefined){
						$("#"+qqid+' img').attr('src',upfilepath);
						$("#"+qqid).next().show();
					}
					qqid = '';
					H.get('upImgDialogtype').exec('close');
					return false;
				},
				autofocus:true
			});
			button.add({
				value:"取消",
				callback:function(){
					H.get('upImgDialogtype').exec('close');
					return false;
				}
			});
			if(!H.get('upImgDialogtype')){
				H.create(new P({
					id : 'upImgDialogtype',
					title: '上传图片',
					width:500,
	                height:200,
					content:$('#upImgDialogtype')[0],
					easy:true,
					padding:20,
					button:button
				},{
					onclose:function(){
						$("#upframetype")[0].contentWindow.deleteUpload('up');
						return false;
					}
				}),'common');
			}
			H.get('upImgDialogtype').exec('show');
            return false;
}
$("#eeret1").click(function(){
	html = $('#coursedialogdiv')[0];
	H.create(new P({
		id : 'artdialogcourse',
		title: '选择课程',
		content:html,
		easy:true
	}),'common').exec('show');
});

$("li.rtytle .atfwt,li.etkly .atfwt").click(function(){
		var foldername = $(this).html();
		var folderid = $(this).attr('fid');
		var tid = $(this).attr('tid');
		$(".show_foldername").html(shortstr(foldername));
		$("input[name=folderid]").attr("value",folderid);
		if(true){
			if(!$(this).attr('tname')){
				var tname = '无';
				var tid = '';
			}else{
				var tname = $(this).attr('tname');
				var tid = $(this).attr('tid');
			}
			$(".show_terchername").html(tname);
			$("input[name=tid]").attr("value",tid);
			H.get('artdialogcourse').exec('close');
			$('#cwblock').show();
			innerTextConvert($('#show_cwname')[0],'无');
			$('#cwid').val('');
			$('#cwname').val();
			
		}
});

function innerTextConvert(ele,text){
	if(window.navigator.userAgent.toLowerCase().indexOf("firefox")!=-1)
	{
		ele.textContent=text;
	}
	else
	{
		ele.innerText=text;
	}
}

function showcw(title){
	height = 540;
	width = 650;
	var folderid = $('#folderid').val();
	url = '/aroomv2/survey/box_cw/'+folderid+'.html';
	var html = '<iframe scrolling="" marginheight="0" marginwidth="0" frameborder="0" width="'+width+'" height="'+height+'" src="'+url+'"></iframe>';
	H.create(new P({
		id : 'artdialogcw',
		title : title,
		width : width,
		height : height,
		content : html,
		easy:true
	},{
		'onclose':function(){
			H.remove('artdialogcw');
		}
	}),'common').exec('show');
}
function selectcw(cwid,title){
	H.get('artdialogcw').exec('close');
	innerTextConvert($('#show_cwname')[0],shortstr(title));
	// $('#show_cwname')[0].innerText = shortstr(title);
	$('#cwid').val(cwid);
	// var cwname = '《'+foldername+'》'+title;
	var cwname = title;
	$('#cwname').val(cwname);
}
function shortstr(str){
	var result = str.substr(0,18);
	if(result.length<str.length)
		result+= '...';
	return result;
}
function relatedisplay(type){
	if(type==2){
		$('.relatecw').show();
	}else{
		$('.relatecw').hide();
	}
	
}
function delimg(qid){
	$("#qid_"+qid+' img').attr('src','http://static.ebanhui.com/ebh/tpl/selcur/images/addmor.jpg');
	$("#qid_"+qid).next().hide();
}
function smoothscroll(){  
    var currentScroll = document.documentElement.scrollTop || document.body.scrollTop;  
    if (currentScroll > 0) {  
         window.requestAnimationFrame(smoothscroll);  
         window.scrollTo (0,currentScroll - (currentScroll/5));  
    }  
}
</script>
</body>
</html>