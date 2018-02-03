<!DOCTYPE HTML>
<html>
<head> 
<meta content="width=1000, user-scalable=no" name="viewport"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>在线作业</title>
<?php $v=getv();?>
<?php $systemsetting = Ebh::app()->room->getSystemSetting();?>
<meta name="keywords" content="<?=empty($systemsetting['metakeywords'])?'':$systemsetting['metakeywords']?>" />
<meta name="description" content="<?=empty($systemsetting['metadescription'])?'':$systemsetting['metadescription']?>" />
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<link href="http://static.ebanhui.com/exam/css/base.css<?=$v?>" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/global.css<?=$v?>">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/layout.css<?=$v?>">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/jqtransform.css<?=$v?>">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/pageztree.css<?=$v?>">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/ryrte.css<?=$v?>">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/addsmart.css<?=$v?>">
<link rel="stylesheet" href="http://static.ebanhui.com/js/dialog/css/dialog.css<?=$v?>"/>

<script type="text/javascript" src="http://static.ebanhui.com/exam/js/jquery/jquery-1.11.0.min.js<?=$v?>"></script>
<script src="http://static.ebanhui.com/exam/js/jquery/jquery-migrate-1.2.1.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/common.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/myschapter1.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/render.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/exam.js<?=$v?>"></script>
<script src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/vendor/swfobject.js?v=1"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/dialog/dialog-plus.js<?=$v?>"></script>
<!-- 引入ztree -->
<link rel="stylesheet" href="http://static.ebanhui.com/ebh/js/xztree/css/zTreeStyle/zTreeStyle.css<?=$v?>" type="text/css">
<script src="http://static.ebanhui.com/ebh/js/xztree/js/jquery.ztree.core-3.5.js<?=$v?>"></script>
<script src="http://static.ebanhui.com/ebh/js/xztree/js/jquery.ztree.excheck-3.5.js<?=$v?>"></script>
<script id="xdi" src="http://static.ebanhui.com/exam/newjs/xdi/xdi.js<?=$v?>" plugs="classdialog"></script>
<script src="http://static.ebanhui.com/exam/newjs/smartques.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js<?=$v?>"></script>

<style>
	#estype,table.infoPane{
		font: 13px/1.5 微软雅黑!important;
	}
	.kdhtygs{margin: 15px 0px;}
	.ui-dialog2-content{text-align: left;}
	#selectadd{
		color: #5e96f5;
		cursor: pointer;
	}
	#classtreeul{
		max-height: 320px;
		overflow-y: auto;
	}
	
	.plusclassbox,.plusstubox{
		float: left;
		width: 378px;
		height: 90px;
		border: 1px solid #797979;
		padding: 3px 0 0 3px;
		overflow-y: auto;
	}
	.addplus{
		float: left;
		width: 28px;
		height: 28px;
		margin: 5px 0 0 5px;
		background:url(http://static.ebanhui.com/ebh/tpl/troomv2/images/tjsiehr.jpg) no-repeat;
		cursor: pointer;
	}
	.plustab{
		float: left;
		list-style: none;
		height: 12px;
		border: 1px solid #BFE4FF;
		border-radius: 3px;
		font-size: 12px;
		background: #E8F5FF;
		color: #20A0FF;
		padding: 5px;
		margin: 0 3px 3px 0px;
	}
	.plustabclass{
		float: left;
		height: 12px;
		line-height: 12px;
		margin-right: 15px;
	}
	.plustabteabox{
		width: 700px;
		float: left;
	}
	.plustabtea{
		float: left;
		height: 12px;
		line-height: 12px;
		border: 1px solid #BFE4FF;
		border-radius: 3px;
		font-size: 12px;
		background: #E8F5FF;
		color: #20A0FF;
		padding: 2px;
		margin-right: 3px;
		margin-bottom: 3px;
	}
	.plusdel{
		float: left;
		height: 12px;
		line-height: 12px;
		font-weight: bold;
		cursor: pointer;
	}
</style>
</head>
<body>
<div id="header">
	<div class="adAuto">
		<div class="magAuto top">
			<p>您好，<?php echo !empty($user['realname']) ? $user['realname'] : $user['username'] ;?></p>
		</div>
	</div>
	<div class="Ad">
		<div class="magAuto">
			<img src="http://static.ebanhui.com/exam/images/banner/stu_head_pic.jpg" />
		</div>
	</div>
</div>
<div style="display:hidden;background:#fff;" id="cwDialog">
</div>
<div id="container">
	<div class="center magAuto">
 	   <div class="contop">
 	   	<img src="http://static.ebanhui.com/exam/images/icon/randombg.png"  class="typetestbg"/>
   		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="infoPane">
			<tr>
				<td colspan="3">
				    <textarea contenteditable="true" onkeydown="limitChars('paperName', 35)" onBlur="limitChars('paperName', 35)" onchange="limitChars('paperName', 35)" onpropertychange="limitChars('paperName', 35)" id="paperName" class="titleJob  inputTxt" onfocus="$(this).removeClass('paperNameEmpty')"></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="3" class="marg10">
					<span>出卷时间：<font class="limeCja"></font></span>
				    <span>限时：</span><input type="text" id="limittime" onblur="examobj.changetime(this.value)" onkeyup="this.value=this.value.replace(/\D/g,'')" onblur="this.value= isNaN(this.value)?this.value:0;"  onafterpaste="this.value=this.value.replace(/\D/g,'')" maxlength="5" name="limittime"  class="timeLimit inputTxt" value="120" /><span>分钟</span>
					<span>总分：<font class="totalPoints totalScore"><label id="scorelab">0 分</label></font></span>
				</td>
			</tr>
			<tr  class="jobType">
				<td width="100"><span>选择作业类型：</span></td>
				<td>
                      <select id="estype">
                    </select>
				</td>
			</tr>
			<tr  class="classRoom">
				<td  width="100"><span>所属课程/课件：</span></td>
				<td id="">
					<div id="folder" folderid="" class="inputDiv" style="clear: none;float:left;font-weight:normal;text-align: left;border-style:none;margin:0; *margin-top:-19px;">
						<span id="folderspan">
							<select id="folderid" onchange="examobj.changefolder()" style=" color: #000;width:305px;float:left; margin-right:10px;padding:2px 0; height:23px;"></select>
						</span>
						<button id="courserelbutton" style="float:left; display:block; width:85px; *padding:2px 0; height:27px; *height:25px; margin-top:-2px;" onclick="Render.addCwDialog()">关联课件</button>
						<span id="courserel" style="display:none;line-height:26px;">关联课件:<span id="coursetext"></span>&nbsp;&nbsp;<a href="javascript:Render.setCwid(0)">取消关联</a></span>
					</div>
				</td>
			</tr>
			<tr class="selectclass">
				<td  width="100"><span>作业权限：</span></td>
				<td>
					<label style="margin-right:10px;"><input type="radio" name="watchper" id="watchperall" value="0" checked="checked"  style="margin-right:3px;">全部</label>
					<label style="margin-right:10px;"><input type="radio" name="watchper" id="watchperclass" value="1" style="margin-right:3px;">按班级</label>
					<label style="margin-right:10px;"><input type="radio" name="watchper" id="watchperstu" value="2" style="margin-right:3px;">按学生</label>
    				<!--<div class="top">
    					<button id="selectclassbut">选择班级</button>
    				</div>
	    			<div id="classlist">
	    			</div>-->
				</td>
			</tr>
			<tr id="plusbox_class" style="display: none;">
				<th valign="top"></th> 
				<td>
					<ul class="plusclassbox"></ul>
					<span class="addplus" onclick="addPlus(1)"></span>
					<div id="addclssbox" style="width: 0px;height: 0px;overflow: hidden;"></div>
				</td>
			</tr>
			
			<tr id="plusbox_stu" style="display: none;">
				<th valign="top"></th> 
				<td>
					<ul class="plusstubox"></ul>
					<span class="addplus" onclick="addPlus(2)"></span>
				</td>
			</tr>
		
			<tr>
				<td  width="100"><span>增加批阅人：</span></td>
				<td>
    				<div class="top">
    					<button onclick="addPlus(3)">增加</button>
    				</div>
				</td>
			</tr>
			<tr id="haveteacher" style="display: none;">
				<td  width="100"><span></span></td>
				<td>
					<div>
	    				<span style="float: left;color: #666;">已选择：</span>
	    				<span class="plustabteabox">
							<!--动态生成-->
						</span>
	    			</div>
				</td>
			</tr>
			
		</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="infoPane" >
		题目呈现形式：
			<label style="margin:0 20px;"><input style="margin-right: 20px;" name="showtype" type="radio" value="0" checked="true" />
			展开式(原题目形式) 
			</label>
			<label><input name="showtype" type="radio" value="1" style="margin-right: 20px;" />单题式 </label>
			<tr  class="checkTr">
				<td  class="offOn">
						<div class="selectonoff" style="width: auto;float: left;cursor: pointer;">
					<input type="checkbox" id="stucancorrect" />&nbsp;&nbsp;
					<span>主观题允许学生自主批改</span>
					</div>
				</td>
				<td>
					<span class="colo99">勾选后学生可以根据实际情况给自己打分，老师可以在学生自己批改的基础上再次批改</span>
				</td>
			</tr>
			<tr  class="checkTr">
				<td  class="offOn">
						<div class="selectonoff" style="width: auto;float: left;cursor: pointer;">
					<input type="checkbox" id="examtime"  />&nbsp;&nbsp;
					<span>设置作业开放时间</span>
					</div>
				</td>
				<td>
					<span class="colo99">开放时间范围外学生无法进行答题</span>
				</td>
			</tr>
			<tr  class="checkTr examtr"  style="display: none;">
				<td colspan="3" class="">
					<div>
						<input type="text" disabled="false" id="examstarttime" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',maxDate:'#F{$dp.$D(\'examendtime\')}'});" />
						至<input type="text" disabled="false" id="examendtime" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',minDate:'#F{$dp.$D(\'examstarttime\')}'});"/>
					</div>
				</td>
			</tr>
			<tr  class="checkTr">
				<td  class="offOn">
						<div class="selectonoff" style="width: auto;float: left;cursor: pointer;">
					<input type="checkbox"   id="anstime" />&nbsp;&nbsp;
					<span>设置答案开放时间</span>
					</div>
				</td>
				<td style=" position:relative;">
					<span class="colo99">在该时间之前学生无法查看答案</span>
				</td>
					
			</tr>
			<tr  class="checkTr anstr"  style="display: none;">
				<td colspan="3" class="">
					<div>
						<input type="text" disabled="false"  id="ansstarttime" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'});"/>
			
					</div>
				</td>
			</tr>
	          <tr  class="checkTr">
	                 <td  class="offOn"><input type="checkbox" id="canreexam"  checked="checked" />&nbsp;&nbsp;
	                        <label for="canreexam"><!-- 允许推送错题相关 -->允许自主巩固练习</label>
	                 </td>
	                 <td style=" position:relative;">
	                        <span class="colo99">勾选后学生可以得到错题的相关知识点题目推送</span>
	                        <div class="choose">
								<div id="choosehistory" class="choosehistory">历史作业</div>
		      				</div>
	                 </td>
	          </tr>
		</table>
 	   </div>
 	   <div class="conbottom">
 	   		
	    		<div class="capacityTxt">
                    <div class="selectedTxt">
                        <div>
                             <div class="topicAll">
                             </div>
                             <div class="divFl">
                                  <div class="left">
                                    <span>选择知识点：</span>
                                  </div>
                                  <div class="right">
                                      <div class="uretw">
                                        <div class="kdhtygs top" style="width:162px; margin: 15px 0; float: left;position: relative;">
                                            <div class="kstdg xchaptervertit" style="min-width: 125px;margin-left:0;">
                                                <span class="xchapterverselected" tag="0">请选择版本</span>
                                            </div>
                                            <div class="xchaptersver" id="chaptersver"></div>
                                        </div>
                                    </div>
                                  </div>
                             </div>
                             <div class="divFl">
                                  <div class="left"><span>选择题型：</span></div>
                                  <div class="right">
                                      <div class="etjre">
                                        <div class="etjde">
                                            <div id="quetype" class="kstdg">
                                                <span id="quetypevholder" tag="A" class="vholder"> 单选题 </span>
                                                <div class="liawtlet" style="max-height: 500px; overflow-y: auto;">
                                                    <a tag="A" class="chver_option"  href="javascript:;">单选题</a>
                                                    <a tag="B" class="chver_option"  href="javascript:;">多选题</a>
                                                    <a tag="D" class="chver_option"  href="javascript:;">判断题</a>
                                                    <a tag="C" class="chver_option"  href="javascript:;">填空题</a>
                                                    <a tag="E" class="chver_option"  href="javascript:;">文字题</a>
                                                    <a tag="H" class="chver_option"  href="javascript:;">主观题</a>
                                                    <a tag="X" class="chver_option"  href="javascript:;">答题卡</a>
                                                    <a tag="XZH" class="chver_option"  href="javascript:;">组合题</a>
                                                    <a tag="XTL" class="chver_option"  href="javascript:;">听力题</a>
                                                    <a tag="XYD" class="chver_option"  href="javascript:;">阅读理解</a>
                                                    <a tag="XWX" class="chver_option"  href="javascript:;">完形填空</a>
                                                </div>
                                            </div>
                                            <div id="dif" class="kstdg">
                                                <span id="difvholder" tag="0" class="vholder"> 容易 </span>
                                                <div class="liawtlet">
                                                    <a tag="0" class="chver_option"  href="javascript:;">容易</a>
                                                    <a tag="1" class="chver_option"  href="javascript:;">较易</a>
                                                    <a tag="2" class="chver_option"  href="javascript:;">一般</a>
                                                    <a tag="3" class="chver_option"  href="javascript:;">较难</a>
                                                    <a tag="4" class="chver_option"  href="javascript:;">困难</a>
                                                </div>
                                            </div>
                                            <span class="jetwr">选择题数<input name="textarea" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" type="text" id="quenum" value="5" class="reytre yahei" /><!--（总共63题）--></span>
                                            <span class="jetwr">每题得分<input name="textarea" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" type="text" id="score" value="1" class="reytre yahei" /></span>
                                            <a id="addbtn" href="javascript:;" class="addTopic">添加</a>
                                        </div>
                                    </div>
                                  </div>
                             </div>
                        </div>
                        <div id="quescontainer">
                        </div>
                    </div>
			  </div>
	    </div>
	    
 	</div>
</div>
<div class="rykhje">
	<div class="rtykwr">
		<div class="left">
			<div><p><span>录入者：</span><span class="author">&nbsp;<?php echo !empty($user['realname']) ? $user['realname'] : $user['username'] ;?></span></p></div>
			<div><p><span>总题数：</span><span class="gradered"><label class="questionnum">0 题</label></span></p></div>
		</div>
		<div class="center">
			 <a href="javascript:void(0);"  class="rtyiok" id="exampreview" >作业预览</a>
			 <a href="javascript:void(0);"  class="rtyiok active" id="examadd">布置作业</a>
		</div>
		<div class="righ">
			<a href="javascript:void(0);"  id="goTop" class="jetytu">返回顶部</a>
		</div>
        
    </div>
</div>
<form style="display:none;" target="" action="/" method="post" id="preview" name="preview"></form>
<!--[if lte IE 6]>
<script type="text/javascript" src="http://static.ebanhui.com/exam/js/dd_belatedpng.js<?=$v?>"></script>
<script type="text/javascript">
    DD_belatedPNG.fix('#sorollDiv1,.capacityTxt,.main .container .leftBook,.main .container .random');
</script>
<![endif]-->
<ul id="classtreeul" class="ztree" style="display: none;"></ul>
<div id="historyques" style="display: none;">
	<div class="diles">
		<input name="title" class="newsou"  id="title" name="uname" placeholder="请输入关键字" value=""  type="text" />
		<a id="ser" class="soulico" href="javascript:void(0)">搜索</a>
	</div>
	<ul class="hisquestionlist" style="max-height: 430px;overflow-y: auto;">
		<table class="datatab" width="100%"></table>
	</ul>
	<div class="page"></div>
</div>
<style>
	#historyques .diles{
		height: 30px;
	}
	#historyques .diles .newsou{
		height: 24px;
	}
	#historyques .diles .soulico{
		display: inline-block;
		color: #f6f6f7;
	    background: #525c68;
	    border-radius: 3px;
	    text-align: center;
	    height: 27px;
	    line-height: 27px;
	    width: 40px;
	}
</style>
<script src="http://static.ebanhui.com/exam/newjs/historyquestion.js<?=$v?>"></script>
<script>
var eid = "<?=$eid?>";
var crid = "<?=$crid?>";
var uid = "<?=$uid?>";
var k = "<?=$k?>";
var k1 = "<?=$k?>";
var smartstutas = 2;
var power = "<?=$power?>";
var examobj= new Exam();//【超级全局变量 】试卷类  变量名不可更改
var isclass = 0;
var changeclass = 1;
$(function(){
	examobj.init({crid:<?php echo $crid?>,classid:'0',folderid:'0',cwid:'0'});
	Myestype.prototype.addJobtype()
	//判断实时作业进入
	var urlSign = top.location.search;
	if(urlSign == "?soft=true"){
		$(".center").css("margin",0);
		$("#header").hide();
	}
})
</script>
<script type="text/javascript">

$DI.$(function(){
	var sIns = SmartQues.newIns();
});
$("#goTop").on('click',function(){
  	$("html,body").animate({scrollTop:0}, 500);
});
selectonoff();
var setting = {
		check: {
			enable: true,
			autoCheckTrigger: false
		},
		data: {
			simpleData: {
				enable: true
			},
			key: {
				name : 'classname'
			}
		},
		callback: {
			onClick: classzTreeOnClick
		},
		view: {
	        fontCss: setFontCss
	        
	  	}
	};
	var code;
	var zNodes = [];
	function classzTreeOnClick(event, treeId, treeNode){
		var treeObj = $.fn.zTree.getZTreeObj("classtreeul");
		treeNode.checked == true ? treeObj.checkNode(treeNode, false, false) : treeObj.checkNode(treeNode, true, false);
	};
	function setFontCss(treeId, treeNode) {
		return !treeNode.hasperson? {color:"#bfcbd9",cursor:"not-allowed",border:"1px solid #fff",height:" 17px",padding:"1px 3px 0 0"} : {};	
	};
	function selectclasstree(eclass){
		var folderid =  $('#folderid option:selected').val();
		$.ajax({
			url: '/troomv2/examv2/getTeacherClasses.html',
			dateType:'json',
			method:'POST',
			data:{
				folderid : folderid
			}
		}).done(function(res) {
			var data = JSON.parse(res);
			if(data.length){
				for(var i=0;i<data.length;i++){
					if(!data[i].hasperson){
						data[i]['chkDisabled'] = true;
					}
				}
			}
			zNodes = data;
			$.fn.zTree.init($("#classtreeul"), setting, zNodes);
			setCheck();
			$("#py").bind("change", setCheck);
			$("#sy").bind("change", setCheck);
			$("#pn").bind("change", setCheck);
			$("#sn").bind("change", setCheck);
			if(eclass){
				checkclass(eclass);
			}
		}).fail(function(res){
			console(res)
		});
	}
	$('#folderid').on('change',function(){ 
		selectclasstree();
		$('#classlist').empty();
		
		$("input[name='watchper'][value='0']").prop("checked",true);
		$("#plusbox_class").hide();
		$(".plusclassbox").empty();
		$("#plusbox_stu").hide();
		$(".plusstubox").empty();
		$("#haveteacher").hide();
		$(".plustabteabox").empty();
	}) 
	
	var wTabs = [];
	function addPlus(type){
		H.remove('addclass');
		$("#addclssbox").empty();
		var addclss = "";
		addclss += '<div id="addclass" style="display:none;">'
		addclss += '<style>.ui-dialog2{border-radius: 1px;}</style>'
		addclss += '<iframe plustype="'+type+'" id="addclassifr" src="/troomv2/examv2/classmateStuAdd.html" frameborder="0" width="660" height="610"></iframe>'
		addclss += '</div>'
		$("#addclssbox").append(addclss);
		
		H.create(new P({
	        id:'addclass',
	        title:'',
	        easy:true,
	        content:$("#addclass")[0]
	    }),'common');
		H.get('addclass').exec('show');
	};
	$(".plusclassbox").on("click",".plusdel",function(){
		$(this).parent().remove();
		if($(this).parent().hasClass("plustab_class")){
			$("#haveteacher").hide();
			$(".plustabteabox").empty();
		}
	});
	$('.plusstubox').on("click",".plusdel",function(){
		$(this).parent().remove();
		var thisUid = $(this).parent().attr("uid");
		for(var i=0;i<wTabs.length;i++){
			if(wTabs[i].uid == thisUid){
				wTabs.splice(i,1);
			}
		}
	});
	
	$("input[name='watchper']").change(function(){
		if($(this).val() == 0){
			$("#plusbox_class").hide();
			$("#plusbox_stu").hide()
		}else if($(this).val() == 1){
			$("#plusbox_class").show();
			$("#plusbox_stu").hide()
		}else{
			$("#plusbox_class").hide();
			$("#plusbox_stu").show()
		}
	});
	
	$('#selectclassbut').click(function(){
		if(!zNodes.length){
			var content = "<p style='text-align: center;line-height: 300px;'>您目前还没可关联的班级，请联系管理员为您添加班级！</p>";
		}else{
			var content = $('#classtreeul');
		}
		var d = dialog({
		    title: '选择班级',
		    content: content,
		    okValue: '确定',
		    width:'500',
		    height:'320',
		    ok: function () {
		    	var zTree = $.fn.zTree.getZTreeObj("classtreeul");
		        var nodes=zTree.getCheckedNodes(true);
		        var classnamestr = '';
		        if(nodes.length){
		        	classnamestr = '已选班级:'
		        	for(var i=0;i<nodes.length;i++){
			        	if(!i){
			        		classnamestr+= '<span classid="'+ nodes[i].classid+'" classname="'+ nodes[i].classname+'">'+nodes[i].classname+'</span>';
			        	}else{
			        		classnamestr+= '<span classid="'+ nodes[i].classid+'" classname="'+ nodes[i].classname+'">,'+nodes[i].classname+'</span>';
			        	}
			        }
		        }
		        $('#classlist').empty().append(classnamestr)
		    },
		    cancelValue: '取消',
		    cancel: function () {
		    	var zTree = $.fn.zTree.getZTreeObj("classtreeul");
		        var nodes=zTree.getNodes(true);
		        zTree.checkAllNodes(false);
		    	$('#classlist span').each(function(i){ 
					if($(this).length>0){
						var classid = $(this).attr('classid');
						var classname = $(this).attr('classname');
						for(var j=0;j<nodes.length;j++){
							if(nodes[j].classid == classid){
								zTree.checkNode(nodes[j], true, true);
							}
						}
					}
				})
		    }
		});
		d.showModal();
	})
	
	function setCheck() {
		var zTree = $.fn.zTree.getZTreeObj("classtreeul"),
		py = $("#py").attr("checked")? "p":"",
		sy = $("#sy").attr("checked")? "s":"",
		pn = $("#pn").attr("checked")? "p":"",
		sn = $("#sn").attr("checked")? "s":"",
		type = { "Y":py + sy, "N":pn + sn};
		zTree.setting.check.chkboxType = type;
		showCode('setting.check.chkboxType = { "Y" : "' + type.Y + '", "N" : "' + type.N + '" };');
	}
	function showCode(str) {
		if (!code) code = $("#code");
		code.empty();
		code.append("<li>"+str+"</li>");
	}
	function checkclass(eclass){
		var zTree = $.fn.zTree.getZTreeObj("classtreeul");
		var nodes=zTree.getNodes(true);
        var classnamestr = '';
        if(eclass.length){
        	classnamestr = '已选班级:'
        	for(var i=0;i<eclass.length;i++){
        		var classid =  eclass[i].classid;
        		var classname = eclass[i].relationname;
	        	if(!i){
	        		classnamestr+= '<span classid="'+ classid+'" classname="'+ classname+'">'+classname+'</span>';
	        	}else{
	        		classnamestr+= '<span classid="'+ classid+'" classname="'+ classname+'">,'+classname+'</span>';
	        	}
	        	for(var j=0;j<nodes.length;j++){
					if(nodes[j].classid == classid){
						zTree.checkNode(nodes[j], true, true);
					}
				}
	        }
        }
        $('#classlist').empty().append(classnamestr);
	}
	$('#choosehistory').on('click',function(){
		Historyquestion.init('TSMART');
	})
</script>

</body>
</html>