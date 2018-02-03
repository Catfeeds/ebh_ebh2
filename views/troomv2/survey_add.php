<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<?php $systemsetting = Ebh::app()->room->getSystemSetting(); ?>
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<title>设计问卷 - 调查问卷</title>
<meta name="keywords" content="<?= empty($subkeywords) ? $this->get_keywords() : $subkeywords ?>" />
<meta name="description" content="<?= empty($subdescription) ? $this->get_description() : $subdescription?>" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css<?=getv()?>"/>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js?v=20150731"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/dialog/dialog-plus.js"></script>
</head>
<body>


<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/tzds.css" rel="stylesheet" />

<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/dayi.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/survey.css?version=20151217001" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/js/dialog/css/dialog.css?v=20160913002"/>
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
.affix {
	position: fixed;
	top: 0px;
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

/*新增的选择被调查对象样式*/
.classlist_div{
	display: none;
}
.classlist_ul{
	float: left;
	width: 518px;
	height: 98px;
	margin: 10px 0 0 20px;
	border: 1px solid #cccccc;
	padding: 10px;
	overflow-y: auto;
}
.classlist_ul li{
	list-style: none;
	float: left;
	position: relative;
	width: 66px;
	height: 24px;
	line-height: 24px;
	color: #fff;
	text-align: center;
	font-size: 12px;
	margin: 0 10px 10px 0; 
}
.classlist_ul li .tabliname{
	float: left;
	width: 100%;
	text-overflow: ellipsis;
	white-space: nowrap;
	overflow: hidden;
}
.classlist_ul .colF39800{
	background: #F39800;
}
.classlist_ul .colAFC44B{
	background: #AFC44B;
}
.classlist_ul li .delLi{
	width: 16px;
	height: 16px;
	border-radius: 50%;
	position: absolute;
	top: -8px;
	right: -8px; 
	text-align: center;
	line-height: 10px;
	color: #fff;
	border: 1px solid #ccc;
	cursor: pointer;
}
.addclassBtn{
	float: left;
	width: 28px;
	height: 28px;
	margin: 10px 0 0 10px;
	background:url(http://static.ebanhui.com/ebh/tpl/troomv2/images/tjsiehr.jpg) no-repeat;
	cursor: pointer;
}
</style>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/mysurveyadd.js?<?=getv()?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<div class="lefrig clearfix" style="margin-top:30px;background:#fff;padding-top:20px;width:1000px;">
	<div class="survey_main fl">
        <input type="hidden" name="xkid" id="xkid" value="<?php echo $xkid?>">
		<!--标题-->
		<div class="survey_title" style="position:relative">
			<div class="h4-bg T_edit p_title" id="survey_title_0">请输入标题</div>
			<input type="hidden" id="sid" value="0" />
		</div>
		<!--内容-->
		<div id="survey_content">

		</div>
	</div>

	<div id="sidebar" class="survey_toolbar fl" data-spy="affix">
		<h4>题型</h4>
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
				<a href="javascript:;" qtype="4">
					<i class="basic-too12-icon-active"></i>
					问答题
				</a>
			</li>
		</ul>

	</div>

	<div>
        <?php if(empty($xkid)){?>
		<fieldset class="relatefs">
			<legend class="relatelgd">问卷调查显示位置</legend>
			<div>
				<label>
					<input type="radio" class="relateradio" name="relate" onclick="relatedisplay(0)" value="0"checked="checked"/>网校主页
				</label>
				<label>
					<input type="radio" class="relateradio" name="relate" onclick="relatedisplay(1)" value="1"/>学生学习主页
				</label>
				<label>
					<input type="radio" class="relateradio" name="relate" onclick="relatedisplay(2)" value="2"/>相关课件页
				</label>
			</div>
			<div>
				<label>
					<input type="radio" class="relateradio" name="relate" onclick="relatedisplay(3)" value="3" disabled="disabled" />选课问卷
				</label>
				<label>
					<input type="radio" class="relateradio" name="relate" onclick="relatedisplay(4)" value="4" disabled="disabled" />开通服务问卷
				</label>
				<label>
					<input type="radio" class="relateradio" name="relate" onclick="relatedisplay(5)" value="5" />登录前问卷
				</label>
			</div>
			<div class="relatecw">
				<div class="eeret" id="eeret1">
					<a class="ekiyt" href="javascript:void(0)">当前选择课程：<span id="show_foldername" class="show_foldername">无</span></a>
					<input type="hidden" name="folderid" id="folderid"  value="" />
				</div>
				<div class="eeret" id="eeret3" onclick="showcw('选择课件')">
					<a class="ekiyt"  href="javascript:void(0)">当前选择课件：<span id="show_cwname" class="">无</span></a>
					<input type="hidden" name="cwname" id="cwname" value=""/>
					<input type="hidden" name="cwid" id="cwid" value="" />
				</div>
			</div>
		</fieldset>

		<fieldset class="relatefs">
			<legend class="relatelgd">是否允许查看统计结果</legend>
			<div>
				<label>
					<input type="radio" class="relateradio" name="allowview" value="1" checked="checked" />允许
				</label>
				<label>
					<input type="radio" class="relateradio" name="allowview" value="0" />不允许
				</label>
			</div>
		</fieldset>

		<fieldset class="relatefs">
			<legend class="relatelgd">是否允许匿名投票</legend>
			<div>
				<label>
					<input type="radio" class="relateradio" name="allowanonymous" value="1" checked="checked" />允许
				</label>
				<label>
					<input type="radio" class="relateradio" name="allowanonymous" value="0" />不允许
				</label>
			</div>
		</fieldset>
		
		<fieldset class="relatefs choseobj" style="display: none;">
			<legend class="relatelgd">选择被调查对象</legend>
			<div>
				<label class="allschool">
					<input type="radio" class="relateradio" name="lookinto" value="0" checked="checked" />全校
				</label>
				<label class="notallschool">
					<input type="radio" class="relateradio" name="lookinto" value="1" />指定班级\年级
				</label>
			</div>
			<div class="classlist_div">
				<ul class="classlist_ul">
					<!--动态生成-->
				</ul>
				<span class="addclassBtn" onclick="addclassFun()"></span>
				<div id="addclss_id" style="width: 0px;height: 0px;overflow: hidden;"></div>
			</div>
		</fieldset>
        <?php }?>

		<fieldset class="relatefs">
			<legend class="relatelgd">开放时间</legend>
			<div style="margin-left: 20px;">
                <input id="startdate" class="qisties" readonly="readonly" type="text" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',minDate:'<?=Date('Y-m-d',SYSTIME)?>', 'isShowClear':true});" value="<?=date('Y-m-d H:i',SYSTIME);?>"/>
                <span class="sjzjf">&mdash;</span>
				<input id="enddate" class="qisties" readonly="readonly" type="text"  onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',minDate:'#F{$dp.$D(\'startdate\')}', 'isShowClear':true});" value="<?=date('Y-m-d H:i',SYSTIME+604800);?>"/>
			</div>
		</fieldset>

		<div class="btndiv" style="">
			<a href="javascript:void(0)" class="subbtn" onclick="submit()" value="">发布问卷</a>
		</div>

	</div>

</div>

<!--上传图片对话框-->
<div id="upImgDialog" style="display:none">
	<iframe id="upframe" name="upframe" scrolling="auto" marginheight="0" marginwidth="0" frameborder="0" width="500" height="200" src="/troomv2/survey/uploadimage.html"></iframe>
</div>

<!--高级编辑对话框-->
<div id="seEditDialog" style="display:none">
	<?php $editor->xEditor('message','700px','300px');?>
</div>

<!--课件关联-->
<div id="coursedialogdiv" style="display:none">
	<div class="titket" style="width:550px;background:white;height:250px;overflow-y:auto">
	<div class="leftke" style="width:500px;">课程列表：</div>
		<div class="riglei" style="width:520px;">
		<ul>
		<?php if($courselist){
			foreach($courselist as $course){?>
		<li class="etkly" style="white-space:nowrap;"><a class="atfwt auttds" fid=<?=$course['folderid']?>><?=$course['foldername']?></a></li>
		<?php }
		}?>
		</ul>
		</div>
	</div>
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
var cacheTabs = {};
var ifgrade = '<?=$roominfo['grade']?>'
if(ifgrade == 0){
	$(".notallschool").hide();
}else{
	$(".notallschool").show();
}
$("input[name='lookinto']").change(function(){
	if($(this).val() == 0)
		$(".classlist_div").hide();
	else
		$(".classlist_div").show();
});

$(".classlist_ul").on("click",".delLi",function(){
	$(this).parent().remove();
	if($(this).parent().hasClass("gradeli")){
		var delgrade = $(this).parent().attr('grade');
		delete cacheTabs[delgrade]
	}else{
		var delgrade = $(this).parent().attr('grade');
		var delclassid = $(this).parent().attr('classid');
		for(var i in cacheTabs[delgrade]){
			if(delclassid == cacheTabs[delgrade][i].classid){
				cacheTabs[delgrade].splice(i,1);
				break;
			}
		}
	}
});

function addclassFun(type){
	H.remove('addclass_dialog');
	$("#addclss_id").empty();
	var addclss = "";
	addclss += '<div id="addclass_dialog" style="display:none;">'
	addclss += '<style>.ui-dialog2{border-radius: 1px;}</style>'
	addclss += '<iframe id="addclassifr" src="/troomv2/survey/addclass.html" frameborder="0" width="660" height="610"></iframe>'
	addclss += '</div>'
	$("#addclss_id").append(addclss);
	H.create(new P({
        id:'addclass_dialog',
        title:'',
        easy:true,
        content:$("#addclass_dialog")[0]
    }),'common').exec('show');
};

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
	title_content = title_content.replace(/<[^>]+>/g, '')
	title_content = title_content.replace(/&nbsp;/g, '');
	title_content = $.trim(title_content);
	if(title_content == '请输入标题' || title_content == ''){
		$("html,body").animate({
			scrollTop: $(".p_title").offset().top-50
		}, 'fast');
		var d = dialog({
		title: '提示信息',
		content: '请输入标题！',
		cancel: false,
		okValue: '确定',
		ok: function () {}
		});
		d.showModal();
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
		if($(this).find("ul.unstyled li").length == 0){
			var qid = $(this).attr("qid");
			$(this).before('<div style="padding:8px 15px; background:#fcecec; color:#f2395b;" class="topic_type_error">请至少添加1个选项</div>');
			$("html,body").animate({
				scrollTop: $("#survey_question_"+qid).offset().top-50
			}, 'fast');
			check_question = false;
			return false;
		}
	});
	if ( ! check_question){
		return;
	}

	var relatetype = $('input[name=relate]:checked').val();
	if(relatetype == 2){
		if((!$('#folderid').val()) || (!$('#cwid').val())){
		top.dialog({
			title:"提示信息",
			content:"已勾选关联课件，请选择关联课件",
			cancel:false,
			okValue:"确定",
			ok:function(){
			    $('#startdate').focus();
			    this.close().remove();
			}
		}).showModal();
			return;
		}
	}

	var startdate = $('#startdate').val();
	var enddate = $('#enddate').val();
	if(startdate == ''){
		top.dialog({
		title:"提示信息",
		content:"请填写开始日期",
		cancel:false,
		okValue:"确定",
		ok:function(){
		    $('#startdate').focus();
		    this.close().remove();
		}
		}).showModal();
		return;
	}
	if(enddate == ''){
		top.dialog({
		title:"提示信息",
		content:"请填写结束日期",
		cancel:false,
		okValue:"确定",
		ok:function(){
			$('#enddate').focus();
		    this.close().remove();
		}
		}).showModal();
		return;
	}
	if(startdate > enddate){
		top.dialog({
		title:"提示信息",
		content:"结束日期不能早于开始日期",
		cancel:false,
		okValue:"确定",
		ok:function(){
			$('#enddate').focus();
		    this.close().remove();
		}
		}).showModal();
		return;
	}

	//组合试卷主体内容
	var content = new Array();
	$.each($('.topic_type'),function(k,v){
		var q = new Object();
		q.title = $(this).find('.q_title').html();
		q.type = $(this).attr('qtype');
		q.item = Array();
		$.each($('.topic_type:eq('+k+') .q_option'),function(ik,iv){
			q.item.push($(this).html());
		});
		content.push(q);
	});

	var isroomclass = $('input[name=lookinto]:checked').val();
	var classids = [];
	if(relatetype == 5){
		if(isroomclass != 0){
			jQuery.each(cacheTabs, function(i, val) {
				for(var j in cacheTabs[i]){
					classids.push(cacheTabs[i][j].classid)
				}
			});
			if(!classids.length){
				top.dialog({
					title:"提示信息",
					content:"请选择班级/年级",
					cancel:false,
					okValue:"确定",
					ok:function(){
					    this.close().remove();
					}
				}).showModal();
				return;
			}
		}else{
			classids = [];
		}
	}
	
	if (submitFlag) {
		submitFlag = false;
	} else {
		return false;
	}
	$.ajax({
		type:'post',
		url:'/troomv2/survey/create.html',
		data:{
			'title':title_content,
			'content':content,
			'relatetype':relatetype,
			'folderid':$('#folderid').val(),
			'cwid':$('#cwid').val(),
			'allowview':$("input[name='allowview']:checked").val(),
			'allowanonymous':$("input[name='allowanonymous']:checked").val(),
			xkid:$('#xkid').val(),
			'startdate':startdate,
			'enddate':enddate,
			'isroomclass': isroomclass,
			'classids':classids
		},
		success:function(data){
			submitFlag = true;
			if(data==1){
				dialog({
					skin:"ui-dialog2-tip",
					content:"<div class='TPic'></div><p>发布成功！</p>",
					width:350,
					onshow:function () {
						var that=this;
						setTimeout(function () {
							window.close();
							window.opener.location.reload();
							that.close().remove();
						}, 2000);
					}
				}).show();
			}
			else
				top.dialog({
				title:"提示信息",
				content:data,
				cancel:false,
				okValue:"确定",
				ok:function(){
					this.close().remove();
				}
				}).showModal();
		}
	});
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
	url = '/troomv2/survey/box_cw/'+folderid+'.html';
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
	if(type == 5){
		$("input[name='allowanonymous']").attr('disabled','disabled');
		$("input[name='allowanonymous']").get(1).checked=true;
		$(".choseobj").show();
	}else{
		$("input[name='allowanonymous']").removeAttr('disabled');
		$(".choseobj").hide();
	}
}
</script>
<?php $this->display('troomv2/page_footer')?>