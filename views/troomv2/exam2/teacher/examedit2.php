<?php $this->display('troomv2/exam2/teacher/teacher_header'); ?>
<?php $v=getv();?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/tikutop.css<?=$v?>" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/zujuan.css<?=$v?>"/>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/dtree.css<?=$v?>"/>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/js/dialog/css/dialog.css<?=$v?>"/>
<script src="http://static.ebanhui.com/exam/js/swfobject.js<?=$v?>" ></script>
<script src="http://static.ebanhui.com/exam/newjs/dtree.js<?=$v?>"></script>
<script src="http://static.ebanhui.com/exam/newjs/exam.js<?=$v?>"></script>
<script src="http://static.ebanhui.com/exam/newjs/formulav2.js<?=$v?>"></script>
<script src="http://static.ebanhui.com/exam/newjs/imgeditorv3.js<?=$v?>"></script>
<script src="http://static.ebanhui.com/exam/newjs/wordutil.js<?=$v?>"></script>
<script src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js<?=$v?>"></script>
<script src="http://static.ebanhui.com/js/dialog/dialog-plus.js<?=$v?>"></script>
<script src="http://static.ebanhui.com/exam/newjs/xquestion.js<?=$v?>"></script>
<script src="http://static.ebanhui.com/exam/js/myschapter.js<?=$v?>"></script>
<script src="http://static.ebanhui.com/exam/js/mmyschapter.js<?=$v?>"></script>
<?=ckeditor()?>
<script type="text/javascript">
</script>
<style type="text/css">
.mchapterverselected{
	width: 100px;
	height: 24px;
	display: block;
	overflow: hidden;
}
.xchapterverselected{
	width: 125px;
	height: 24px;
	display: block;
	overflow: hidden;
}
.msecondselect{
	width: 115px;
	height: 24px;
	display: block;
	overflow:hidden
}
.mxchaptersver{
	width:137px;
}
#container .right{
	right: -380px;
}
table.datatab{
	table-layout: fixed;
}
.ui-dialog2-content,.ui-dialog2-body{
	text-align: inherit;
}
#questionlist .inputBox{
	word-wrap: break-word;
	display: inline-block;
	max-width: 100%;
}
.addzhu {
    margin-top: 3px;
    padding: 5px 0;
    display: inline-block;
    width: 180px;
    height: 120px;
    position: relative;
}
.addzhu a.delet {
    width: 14px;
    height: 14px;
    display: block;
    position: absolute;
    top: -2px;
    right: -7px;
    background: url(http://static.ebanhui.com/ebh/tpl/selcur/images/delerig.png) no-repeat;
}
#changeoption{
	color: #5e96f5;
	cursor: pointer;
}
#selectadd{
		color: #5e96f5;
		cursor: pointer;
	}
#sidebarLeft{
	background: none;
}
.sidebot,.sidetop,.sidecont{
	float: left;
	width: 120px;
	background: url("http://static.ebanhui.com/exam/images/icon/m700.png") no-repeat;
}
.sidecont{
	display: block;
	height: 660px;
	z-index: 100;
	background-position:0px -12px;
}
.sidebot{
	padding-bottom: 16px;
	background-position: 0px -675px;
}
.sidetop{
	cursor: pointer;
	text-align: center;
    font-size: 15px;
    font-family: 微软雅黑;
    line-height: 40px;
    background-position: 0px -5px;
   	color: #666;
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
<!-- 弹出层html -->
<div class="layerTreediv" id="layerTreediv" style="width:800px;height:500px;display:none">
	<div style="width:140px; float: left;margin: 15px 0;position: relative;" class="kdhtygs mtop">
		<div style="min-width: 125px;margin-left:0;" class="kstdg mxchaptervertit">
				<span tag="0" class="mchapterverselected">请选择版本</span>
		</div>
		<div class="mxchaptersver" style="display: none;"></div>
	</div>
	<div style="margin-top: 10px;position: relative;" class="mmychkselected">
		<ul class="mselectednodes" style="float:left">您选择的知识点:</ul>
	</div>
	<a class="kldtubtn savechapterli" href="javascript:void(0)">确 定</a>
</div>
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
<div id="container" class="sheet-con">
	<div class="center magAuto layoutContainer">
		<img src="http://static.ebanhui.com/exam/images/icon/smallbg.png" class="typetestbg" />
 	   <div class="contop">
   		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="infoPane">
			<tr>
				<td colspan="3">
				    <textarea contenteditable="true" onkeydown="limitChars('paperName', 35)"  onchange="limitChars('paperName', 35)" onpropertychange="limitChars('paperName', 35)" id="paperName" class="titleJob  inputTxt" onBlur="limitChars('paperName', 35)"  onfocus="$(this).removeClass('paperNameEmpty')"></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="3" class="marg10">
					<span>出卷时间：<font id="volumetime"></font></span>
					<span>限时：</span><input type="text" id="limittime" onkeyup="this.value=this.value.replace(/\D/g,'')"  onafterpaste="this.value=this.value.replace(/\D/g,'')" onblur="examobj.changetime(this.value)" maxlength="5" name="limittime"  class="timeLimit inputTxt" value="" /><span>分钟</span>
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
					<div id="folder" folderid="" class="inputDiv" style="clear: none;float:left;font-weight:normal;text-align: left;border-style:none;margin:0;*margin-top:-19px;">
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
			
			
			<tr  class="learnPoint">
				<td  width="100"><span>选择知识点：</span></td>
				<td>
					<div class="kdhtygs top" style="position:relative;" >
	    				<div class="kstdg xchaptervertit">
	            			<span class="xchapterverselected" tag="0">请选择版本</span>
	        			</div>
	        			<div class="xchaptersver" id="chaptersver"></div>
					</div>
				</td>
			</tr>
		</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="infoPane">
		题目呈现形式：
			<label style="margin:0 20px;"><input style="margin-right: 20px;" name="showtype" type="radio" value="0" checked="true" />
			展开式(原题目形式) 
			</label>
			<label><input name="showtype" type="radio" value="1" style="margin-right: 20px;" />单题式 </label>
			<tr  class="checkTr">
				<td  class="offOn">
						<div class="selectonoff" style="width: auto;float: left;cursor: pointer;">
						<input type="checkbox"  id="stucancorrect"  />&nbsp;&nbsp;
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
					<input type="checkbox"  id="examtime"  />&nbsp;&nbsp;
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
						<input type="text" disabled="false" id="examstarttime" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',maxDate:'#F{$dp.$D(\'examendtime\')}'});" />
						至<input type="text" disabled="false" id="examendtime" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',minDate:'#F{$dp.$D(\'examstarttime\')}'});"/>
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
					<div class="choose">
						<div id="choosehistory" class="choosehistory" >历史作业</div>
      					<div id="chooseword" class="chooseword" >从word导入</div>
          				<div id="choosequestion" class="choosequestion" >从题库选取</div>
					</div>
				</td>
					
			</tr>
			<tr  class="checkTr anstr"  style="display: none;"> 
				<td colspan="3" class="">
					<div>
						<input type="text" disabled="false"  id="ansstarttime" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'});"/>
					</div>
				</td>
			</tr>
		</table>
 	   </div>
 	   <div class="conbottom"  id="desk">
 	   		<div class="tips">
				<p><span>注：</span>word导入与新增题目说明：请先选择知识点后再操作;</p>
				<p style="text-indent: 24px;">填空题说明：填空题如果一个空有多个可选答案，答案与答案之间以 # 隔开，比如 	答案1#答案2，学生答题的时候 填写 答案1 或者 答案2 都正确</p>
	        </div>
	        <div id="viewcontent" class="font12px fontSimsum jqtransformdone">
	        	<div id="loadimg" style="width:100px;height:100px;margin:0 auto;"><img style="margin:0 auto;" title="加载中..." src="http://static.ebanhui.com/exam/images/loading.gif"/></div>
			</div>
			<div id="bottomBar"></div>
		    <div id="upImgDialog" style="display:none;font-size:12px;">
		    <iframe src="http://exam.ebanhui.com/upimg.php" id="upImgIFrame" width="320" height="80" border="0" scrolling="no" frameborder="no"></iframe>
		    <div id="msg" style="width:280px; height:20px;margin-top:20px;">注意:请上传gif,jpg,jpeg,png格式大小在20M内。</div>
		    </div>
			<div id="upCoursewareDialog" style="display:none;font-size:12px;">
		    <iframe src="" id="upcourseware" width="331" height="130" border="0" scrolling="no" frameborder="no"></iframe>
		    </div>
		    <input id="focusobj" type="hidden" value=""/>
			<input id="focussubobj" type="hidden" value=""/> 
	    </div>
 	</div>
</div>
<div style="position: absolute; z-index: 9999; display: none; width:360px; left: 220px; top: 186px; height:50px;" class="box_window" id="locListDiv">
<div class="content"><p class="t_c" id="alertmsg"></p></div>
<div class="c_b"></div></div>
<div id="show"></div>
<div id="sidebarLeft">
	<div class="sidetop">题型选择</div>
		<div class="sidecont" style="position:relative">
		<ul>
		<li class="xuanx xuany"><a href="javascript:void(0);" onclick="examobj.addWordque({pannel:'viewcontent',type:'X'});"><img src="http://static.ebanhui.com/exam/images/datika.jpg" /></a></li>
		<li class="xuanx xuany"><a href="javascript:void(0);" onclick="examobj.addWordque({pannel:'viewcontent',type:'XTL'});"><img src="http://static.ebanhui.com/exam/images/datikatl.jpg" /></a></li>
		<li class="xuanx xuany"><a href="javascript:void(0);" onclick="examobj.addWordque({pannel:'viewcontent',type:'XWX'});"><img src="http://static.ebanhui.com/exam/images/datikawx.jpg" /></a></li>
		<li class="xuanx xuany"><a href="javascript:void(0);" onclick="examobj.addWordque({pannel:'viewcontent',type:'XYD'});"><img src="http://static.ebanhui.com/exam/images/datikayd.jpg" /></a></li>
		<li class="xuanx xuany"><a href="javascript:void(0);" onclick="examobj.addWordque({pannel:'viewcontent',type:'XZH'});"><img src="http://static.ebanhui.com/exam/images/datikazh.jpg" /></a></li>
		<li class="xuanx xuany"><a href="javascript:void(0);" onclick="examobj.addSinchoice({pannel:'viewcontent'});"><img src="http://static.ebanhui.com/exam/images/danxuan2.jpg" /></a></li>
		<li class="xuanx xuany"><a href="javascript:void(0);" onclick="examobj.addMulchoice({pannel:'viewcontent'});"><img src="http://static.ebanhui.com/exam/images/duoxuan2.jpg" /></a></li>
		<li class="xuanx xuany"><a href="javascript:void(0);" onclick="examobj.addTruefalse({pannel:'viewcontent'});"><img src="http://static.ebanhui.com/exam/images/panduan2.jpg" /></a></li>
		<li class="xuanx xuany"><a href="javascript:void(0);" onclick="examobj.addFillque({pannel:'viewcontent'});"><img src="http://static.ebanhui.com/exam/images/tiankong2.jpg" /></a></li>
		<li class="xuanx xuany"><a href="javascript:void(0);" onclick="examobj.addTextque({pannel:'viewcontent'});"><img src="http://static.ebanhui.com/exam/images/wenzi2.jpg" /></a></li>
		<li class="xuanx"><a href="javascript:void(0);" onclick="examobj.addSubjective({pannel:'viewcontent'});"><img src="http://static.ebanhui.com/exam/images/zhuguanti2.jpg" /></a></li>
		<li class="xuanx"><a href="javascript:void(0);" onclick="inputsubjective()"><img src="http://static.ebanhui.com/exam/images/inputsubjective.jpg" /></a></li>
		<li class="xuanx xuany"><a href="javascript:void(0);" onclick="examobj.addTextline({pannel:'viewcontent'});"><img src="http://static.ebanhui.com/exam/images/wenben2.jpg" /></a></li>
		<li class="xuanx xuany"><a href="javascript:void(0);" onclick="examobj.addAudio({pannel:'viewcontent'});"><img src="http://static.ebanhui.com/exam/images/Auto2.jpg" /></a></li>
		
		<li class="xuanx"><a href="javascript:void(0);" onclick="uploadImg(0);"><img src="http://static.ebanhui.com/exam/images/charu2.jpg" /></a></li><!-- 图片 -->
		<li class="xuanx"><a href="javascript:void(0);" onclick="uploadImg(1);"><img src="http://static.ebanhui.com/exam/images/charuflash2.png" /></a></li><!-- 动画 -->
		<li class="xuanx"><a href="javascript:void(0);" onclick="uploadImg(2);"><img src="http://static.ebanhui.com/exam/images/charuaudio2.png" /></a></li><!-- 音频 -->
		<li class="xuanx"><a href="javascript:void(0);" onclick="uploadImg(3);"><img src="http://static.ebanhui.com/exam/images/charuatt2.png" /></a></li><!-- 附件 -->
		<li class="xuanx"><a href="javascript:void(0);" onclick="addformula();"><img src="http://static.ebanhui.com/exam/images/charuformula2.jpg" /></a></li><!-- 公式 -->
		<li class="xuanx"><a href="javascript:void(0);" onclick="createImgEditor();"><img src="http://static.ebanhui.com/exam/images/imgeditor.png" /></a></li><!-- 公式 -->
		<li class="xuanx"><a href="javascript:void(0);" onclick="setcss(1);"><img src="http://static.ebanhui.com/exam/images/xiahua2.jpg" /></a></li>
		<li class="xuanx"><a href="javascript:void(0);" onclick="setcss(2);"><img src="http://static.ebanhui.com/exam/images/shangbiao2.jpg" /></a></li>
		<li class="xuanx"><a href="javascript:void(0);" onclick="setcss(3);"><img src="http://static.ebanhui.com/exam/images/xiabiao2.jpg" /></a></li>
		</ul>
	</div>
	<div class="sidebot"></div>
</div>
<div class="rykhje">
	<div class="rtykwr" style="margin: 0 auto;">
		<div class="left">
			<div><p><span>录入者：</span><span class="author">&nbsp;<?php echo !empty($user['realname']) ? $user['realname'] : $user['username'] ;?></span></p></div>
			<div><p><span>总题数：</span><span class="gradered"><label class="questionnum ">0 题</label></span></p></div>
		</div>
		<div class="center">
			 <a href="javascript:void(0);"  class="rtyiok btnSave" onclick="if($.trim($('#viewcontent').html())==''){alertnoZero();return;};examobj.uploadData(0);">保存草稿</a>
			 <a href="javascript:void(0);"  class="rtyiok"  onclick="if($.trim($('#viewcontent').html())==''){alertnoZero();return;};examobj.uploadData(1,true);">作业预览</a>
			 <a href="javascript:void(0);" id="buctn"  class="rtyiok active" >布置作业</a>
		</div>
		<div class="righ">
			<a href="javascript:void(0);" style="height: 58px; line-height: 58px;" id="goTop"  class="jetytu">返回顶部</a>
		</div>
        
    </div>
</div>

<input type="hidden" id="crid" value="<?php echo $crid;?>" />
 <div id="flvwrap" style="display:none;">
     <div id="flvcontrol"></div>
 </div>
  <iframe name="iframe_data" style="display:none;"></iframe>
 <form id="download_form" name="download_form" target="iframe_data" method="POST"></form>

<script type="text/javascript">
<?php
if(checkbrowser()){
	$isMobile = 'true';
}else{
	$isMobile = 'false';
}
global $_SGLOBAL;
?>
var isMobile = <?php echo $isMobile; ?>;
var browser = '<?php echo $_SGLOBAL["browser"];?>';

var qnumber=1;//【超级全局变量】 题目总数  变量名不可变
var qid=1;///【超级全局变量 】题目ID号，    变量名不重复
var examobj= new Exam();//【超级全局变量 】试卷类  变量名不可更改
var eid = "<?=$eid?>";
var crid = "<?=$crid?>";
var domain = "<?=$domain?>";//examv2新添加的,用于跨域回调
var uid = "<?=$uid?>";
var k = "<?=$k?>";
var k1 = "<?=$k?>";
var power = "<?=$power?>";
var isclass = 0;
var changeclass = 1;
$(function(){
	examobj.init({targetID:<?php echo $eid?>,crid:<?php echo $crid?>});
	hearttoolbar();
	Myestype.prototype.addJobtype();
	//判断实时作业进入
	var urlSign = top.location.search;
	if(urlSign == "?soft=true"){
		$(".layoutContainer").css("margin",0);
		$("#header").hide();
	}
	//上传图片
	H.create(new P({
		id:'upImgDialog',
		title:'上传图片',
		content:$("#upImgDialog")[0],
		width:320,
		height:200,
		easy:true,
		padding:20
	}),'common');
	
	//上传课件
	H.create(new P({
		id:'upCoursewareDialog',
		title:'上传课件',
		content:$('#upCoursewareDialog')[0],
		easy:true,
		padding:10
	}));

	$(".que").live("mouseover", function(){
		$(this).addClass("light");
		$(this).find('.courseware').attr('src','http://static.ebanhui.com/exam/images/courseware1.jpg');
	});
	$(".que").live("mouseout", function(){
		$(this).removeClass("light");
		$(this).find('.courseware').attr('src','http://static.ebanhui.com/exam/images/courseware.jpg');
	});
	$('.changescore').live("mouseover", function(){
		$(this).css("color",'#2AAAFF');
	});
	$('.changescore').live("mouseout", function(){
		$(this).css("color",'#333333');
	});

	$('.playcourseware .playbutton').live("mouseover", function(){
		$(this).css("color",'#F78221');
	});
	$('.playcourseware .playbutton').live("mouseout", function(){
		$(this).css("color",'#F9AB6C');
	});
	$('.playcourseware .delbutton').live("mouseover", function(){
		$(this).css("color",'#333333');
	});
	$('.playcourseware .delbutton').live("mouseout", function(){
		$(this).css("color",'#C1C1C1');
	});
	$('.qscore').live("click",function(){
		this.select();
        this.focus();
	});
	$(".radioBox").live("mouseover", function(){
		$(this).addClass("light2");
		$(this).find(".qdel").show();
	});
	$(".radioBox").live("mouseout", function(){
		$(this).removeClass("light2");
		$(this).find(".qdel").hide();
		
		
	});

	$(".checkBox").live("mouseover", function(){
		$(this).addClass("light2");
		$(this).find(".qdel").show();
	});
	$(".checkBox").live("mouseout", function(){
		$(this).removeClass("light2");
		$(this).find(".qdel").hide();
	});
	selectonoff();
	$(".delabtn").live("mouseover", function(){
		$(this).addClass("delahbtn");
	});
	$(".delabtn").live("mouseout", function(){
		$(this).removeClass("delahbtn");

	});
	$(".moveup,.movedown").live("mouseover", function(){
		$(this).addClass("moveover");
	});
	$(".moveup,.movedown").live("mouseout", function(){
		$(this).removeClass("moveover");
	});
	$(".addfillbtn").live("mouseover", function(){
		$(this).addClass("addfillhbtn");
	});
	$(".addfillbtn").live("mouseout", function(){
		$(this).removeClass("addfillhbtn");

	});
	
});
</script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/pubquestion3.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/myquestion3.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/favquestion3.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/schoolquestion3.js<?=$v?>"></script>
<script type="text/javascript">

</script>
<!--------播放器代码------------>
<script type="text/javascript" defer>
var pub = new Pubquestion();
var myque = new Myquestion();
var favque = new Favquestion();
var schoolque = new Schoolquestion();
var ver = 10;
$(function(){
	$('.choosequestion').live('mouseover',function(){
		$(this).addClass('choosequestion2');
	}).live('mouseout',function(){
		$(this).removeClass('choosequestion2');
	});
	$('.cloosequestion').live('mouseover',function(){
		$(this).addClass('cloosequestion2');
	}).live('mouseout',function(){
		$(this).removeClass('cloosequestion2');
	});
	$('#choosequestion').click(function(){
		Xques.doshow("<?=$crid?>");
	});
	$(".datatab tr").live('mouseover',function(){
		$(this).addClass("over3");
	}).live('mouseout',function(){
		$(this).removeClass("over3");
	}) //移除该行的class 
	$('#closequestion').live('click',function(){
		$('#choosequestion').removeClass('cloosequestion').removeClass('cloosequestion2').addClass('choosequestion');
		$('#sorollDiv2').hide();
	});
	$('body').keydown(function(){
		$("#editorDialog").hide();
		Fillque.stroage.clear();
	});
});
function checkUpdate() {
	return true;
}
</script>
<?php 
echo getplayobj();
?>
<!--------播放器代码------------>
<div id="formula" style="border:none;display:none;" title="公式编辑器">
	<iframe width="97%" height="97%" scrolling="" id="formulaframe" src="about:blank" style="border:none;"></iframe>
</div>
<div id="wordform" style="border:none;display:none;overflow:hidden;" title="导入Word">
	<iframe width="100%" height="260px" scrolling="no" id="wordformframe" src="about:blank" frameborder=0 style="border:0;overflow:none;"></iframe>
</div>
<form style="display:none;" target="" action="/" method="post" id="preview" name="preview"></form>
<div style="display:hidden;background:#fff;" id="cwDialog">
</div>
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
	$(function(){
		window.flash = HTools.pFlash({
			'id':"piceditor",
			'uri':"http://static.ebanhui.com/exam/flash/couseEditor.swf",
			'vars':{'showsubmit':0,'showscorepanel':0,'showopen':0}
		});
		H.create(new P({
			'id':"piceditor",
			'title':'题目查看',
			'flash':flash,
			'easy':true
		},{'onclose':function(){
			H.remove('quespanel');
		}}));
		$('.chooseword').live('mouseover',function(){
			$(this).addClass('chooseword2');
		}).live('mouseout',function(){
			$(this).removeClass('chooseword2');
		});
		$("#chooseword").click(function(){addfromword()});
		setInterval(function(){
			examobj.fixWpos();
		},1000);
		
		$('#viewcontent').on('mouseover','.scoreBar',function(){
			$(this).find('.changescore').show();
		}).on('mouseout',function(){
			$(this).find('.changescore').hide();
		});
		$(".sidetop").mousedown(function(e){//e鼠标事件 
	        var offset = $(this).offset();//DIV在页面的位置
	        var x = e.pageX - offset.left;//获得鼠标指针离DIV元素左边界的距离
	        var y = e.pageY - offset.top;//获得鼠标指针离DIV元素上边界的距离
	        $(document).bind("mousemove",function(ev){ //绑定鼠标的移动事件，因为光标在DIV元素外面也要有效果，所以要用doucment的事件，而不用DIV元素的事件  
	            $("#sidebarLeft").stop();//加上这个之后   
	            var _x = ev.pageX - x ;//获得X轴方向移动的值 
	            var _y = ev.pageY - y - 10;//获得Y轴方向移动的值  
	            $("#sidebarLeft").animate({left:_x + "px",top:_y+"px"},10);  
	            changesidebarth() 
	        });    
	    });  
	    $(document).mouseup(function()  {  
	        $(this).unbind("mousemove");  
	    })      
		$(document).on('click','div.resolve[contenteditable=true],div.dianpin[contenteditable=true],div.fenxi[contenteditable=true]',function(e){
			var me = this;
			$(this).ckeditor();
			setTimeout(function(){
				$(me).removeAttr('title');
				window.scrollBy(0,1);
			},200);
		});
	});
	$("#goTop").on('click',function(){
	  	$("html,body").animate({scrollTop:0}, 500);
	}); 
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
			zNodes = data || [];
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
		Historyquestion.init('COMMON');
	})
</script>
</body>
</html>