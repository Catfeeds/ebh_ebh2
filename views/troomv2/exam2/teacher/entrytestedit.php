<?php $this->display('troomv2/exam2/teacher/teacher_header'); ?>
<?php $v=getv();?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/tikutop.css<?=$v?>" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/zujuan.css<?=$v?>"/>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/dtree.css<?=$v?>"/>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/js/dialog/css/dialog.css<?=$v?>"/>
<link rel="stylesheet" type="text/css" href="http://exam.ebanhui.com/static/css/play.css<?=$v?>"  />

<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/dtree.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/question3.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/formulav2.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/imgeditorv3.js<?=$v?>"></script>
<script src="http://static.ebanhui.com/exam/js/swfobject.js<?=$v?>" type="text/javascript"></script>

<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/wordutil.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/dialog/dialog-plus.js<?=$v?>"></script>
<script src="http://static.ebanhui.com/exam/newjs/xquestion20151113.js<?=$v?>"></script>
<script src="http://static.ebanhui.com/exam/js/myschapter.js<?=$v?>"></script>
<script src="http://static.ebanhui.com/exam/js/mmyschapter.js<?=$v?>"></script>
<title>题库修改</title>
<?=ckeditor()?>
<script type="text/javascript">
//window.onbeforeunload = function(){
//	if($.trim($("#paperName").text().replace(/&nbsp;/g,''))!=""){
//	 	return "你确定离开吗？";
//	 }
//};
</script>
<style>
	.mchapterverselected{
		width: 100px;
		height: 24px;
		display: block;
		overflow: hidden;
	}
	.mxchaptersver{
		width:137px;
	}
	.msecondselect{
		width: 115px;
		height: 24px;
		display: block;
		overflow:hidden
	}
	#container .right{
		right: -380px;
	}
	#sidebarLeft{
		height: 230px;
		background: url('http://static.ebanhui.com/exam/images/rightbananer4.png') no-repeat;
		padding-top: 25px;
	}
	.addfillbtn{
		    right: 4px;
	}
	.ui-dialog2-content{text-align: left;}
		#sidebarLeft{
		background: none;
	}
    .sidebot,.sidetop,.sidecont{
    	float: left;
    	width: 120px;
    	background: url("http://static.ebanhui.com/exam/images/rightbananer4.png") no-repeat;
    }
    .sidecont{
		display: block;
    	height: 210px;
		z-index: 100;
		background-position:0px -12px;
    }
    .sidebot{
    	padding-bottom: 16px;
    	background-position: 0px -230px;
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
</style>
</head>

<body>
<!-- 弹出层html -->
<div class="layerTreediv" id="layerTreediv" style="width:800px;height:500px;display:none;font-size:12px">
	<div style="width:140px; float: left;margin: 15px 0;position: relative;" class="kdhtygs mtop">
		<div style="min-width: 125px;margin-left:0;" class="kstdg mxchaptervertit">
				<span tag="0" class="mchapterverselected">请选择版本</span>
		</div>
		<div class="mxchaptersver" style="display: none;"></div>
	</div>
	<div style="position: relative;" class="mmychkselected">
		<ul class="mselectednodes" style="float:left"></ul>
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
		<img src="http://static.ebanhui.com/exam/images/entrytest.gif" class="typetestbg" />
 	   <div class="contop ">
   		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="infoPane">
			<tr>
				<td colspan="3">
				    <textarea  onchange="if(this.value.length >= 50){ return false }" id="paperName" class="titleJob  inputTxt" maxlength="50" onfocus="$(this).removeClass('paperNameEmpty')"></textarea>
				</td>
			</tr>
			<tr  class="classRoom">
				<td  width="100"><span>所属课程/课件：</span></td>
				<td id="">
					<div id="folder" folderid="" class="inputDiv" style="clear: none;float:left;font-weight:normal;text-align: left;border-style:none;margin:0; *margin-top:-19px;">
						<span id="folderspan">
							<select id="folderid" onchange="examobj.changefolder()" style=" color: #000;width:305px;float:left; margin-right:10px;padding:2px 0; height:23px;"></select>
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
 	   </div>
 	   <div class="conbottom" id="desk">
 	   		<div class="tips">
				<p><span>注：</span>word导入与新增题目说明：请先选择知识点后再操作;</p>
				<p style="text-indent: 24px;">填空题说明：填空题如果一个空有多个可选答案，答案与答案之间以 # 隔开，比如 	答案1#答案2，学生答题的时候 填写 答案1 或者 答案2 都正确</p>
	        </div>
	        <div id="viewcontent" class="font12px fontSimsum jqtransformdone">
		</div>
		
		<div id="bottomBar"></div>
	    <div id="upImgDialog" style="display:none;font-size:12px;">
	    <iframe src="" id="upImgIFrame" width="320" height="80" border="0" scrolling="no" frameborder="no"></iframe>
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
<input type="hidden" id="crid" value="<?php echo $crid;?>" />
<div id="sidebarLeft">
	<div class="sidetop">题目修改</div>
	<div class="sidecont" style="position:relative">
		<ul>
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
			<div><p><span></span></p></div>
		</div>
		<div class="center">
			 <a href="javascript:void(0);"  class="rtyiok" onclick="if($.trim($('#viewcontent').html())==''){alertnoZero();return;};examobj.checkExam(1);">检查试题</a>
			 <a href="javascript:void(0);"  class="rtyiok active" onclick="if($.trim($('#viewcontent').html())==''){alertnoZero();return;};examobj.uploadData(1);">提交试题</a>
		</div>
		<div class="righ">
			<a href="javascript:void(0);" id="goTop" class="jetytu" style="height: 55px;line-height: 55px;">返回顶部</a>
		</div>
        
    </div>
</div>

<script type="text/javascript">
<?php
if(checkbrowser()){
	$isMobile = 'true';
}else{
	$isMobile = 'false';
}
global $_SGLOBAL;
?>
var isMobile = <?php echo $isMobile;?>;
var browser = '<?php echo $_SGLOBAL["browser"];?>';
var qnumber=1;//【超级全局变量】 题目总数  变量名不可变
var qid=1;///【超级全局变量 】题目ID号，    变量名不重复
var examobj= new Exam();//【超级全局变量 】试卷类  变量名不可更改
var etype = 0;
var crid = "<?=$crid?>";
var domain = "<?=$domain?>";//examv2新添加的,用于跨域回调
var uid = "<?=$uid?>";
var kuqid = "<?=$kuqid?>";
$(function(){	
	examobj.init({crid:<?php echo $crid?>,classid:'0',folderid:'0',cwid:'0',targetID:kuqid});
	examobj.initfolder();	
	//examobj.initfolder();
	new xChapter({'callback':function(data){
    
    },'checkbox':true,'showitem':true,'bindthird':1})
	//上传图片
	H.create(new P({
		id:'upImgDialog',
		title:'上传图片',
		content:$("#upImgDialog")[0],
		width:320,
		height:200,
		easy:true,
		padding:20
	}));
	//上传课件
	H.create(new P({
		id:'upCoursewareDialog',
		title:'上传课件',
		content:$('#upCoursewareDialog')[0],
		easy:true,
		padding:10
	}));

	$(".que").hover(function(){
		$(this).addClass("light");
		},function(){
			$(this).removeClass("light");
		});
	
	
	$("#viewcontent").on("mouseover",'.que',function(){
		$(this).addClass("light");
		$(this).find('.courseware').attr('src','http://static.ebanhui.com/exam/images/courseware1.jpg');
	});
	$("#viewcontent").on("mouseout",'.que', function(){
		$(this).removeClass("light");
		$(this).find('.courseware').attr('src','http://static.ebanhui.com/exam/images/courseware.jpg');
	});
	$('#viewcontent').on("mouseover",'.changescore', function(){
		$(this).css("color",'#2AAAFF');
	});
	$('#viewcontent').on("mouseout",'.changescore', function(){
		$(this).css("color",'#333333');
	});

	$('#viewcontent').on("mouseover",'.playcourseware .playbutton', function(){
		$(this).css("color",'#F78221');
	});
	$('#viewcontent').on("mouseout",'.playcourseware .playbutton', function(){
		$(this).css("color",'#F9AB6C');
	});
	$('#viewcontent').on("mouseover", '.playcourseware .delbutton',function(){
		$(this).css("color",'#333333');
	});
	$('#viewcontent').on("mouseout",'.playcourseware .delbutton', function(){
		$(this).css("color",'#C1C1C1');
	});
	$('#viewcontent').on("click",'.qscore',function(){
		this.select();
        this.focus();
	});
	$('#viewcontent').on("mouseover",".radioBox", function(){
		$(this).addClass("light2");
		$(this).find(".qdel").show();
	});
	$('#viewcontent').on("mouseout",".radioBox", function(){
		$(this).removeClass("light2");
		$(this).find(".qdel").hide();
	});
	selectonoff();
	$('#viewcontent').on("mouseover",".checkBox", function(){
		$(this).addClass("light2");
		$(this).find(".qdel").show();
	});
	$('#viewcontent').on("mouseout",".checkBox", function(){
		$(this).removeClass("light2");
		$(this).find(".qdel").hide();
		
		
	});
	
	$('#viewcontent').on("mouseover",".delabtn", function(){
		$(this).addClass("delahbtn");
	});
	$('#viewcontent').on("mouseout",".delabtn", function(){
		$(this).removeClass("delahbtn");
	});
	$('#viewcontent').on("mouseover",".moveup,.movedown", function(){
		$(this).addClass("moveover");
	});
	$('#viewcontent').on("mouseout",".moveup,.movedown", function(){
		$(this).removeClass("moveover");
	});

	$('#viewcontent').on("mouseover",".addfillbtn", function(){
		$(this).addClass("addfillhbtn");
	});
	$('#viewcontent').on("mouseout",".addfillbtn", function(){
		$(this).removeClass("addfillhbtn");

	});
	$("#chooseword").click(function(){addfromword()});
});

</script>
<script type="text/javascript">
hearttoolbar();
$("#goTop").on('click',function(){
  	$("html,body").animate({scrollTop:0}, 500);
}); 
</script>
<div id="flvwrap" style="display:none;">
	<div id="flvcontrol"></div>
</div>
<iframe name="iframe_data" style="display:none;"></iframe>
<form id="download_form" name="download_form" target="iframe_data" method="POST"></form>
<!--------播放器代码------------>
<script type="text/javascript" defer>
var ver = 10;
$(function(){
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
<div id="wordform" style="border:none;display:none;overflow:hidden;" title="导入Word">
	<iframe width="100%" height="260px" frameborder=0 scrolling="no" id="wordformframe" src="about:blank" style="border:0;overflow:none;"></iframe>
</div>
<form style="display:none;" target="" action="/" method="post" id="preview" name="preview"></form>
<input type="hidden" id="uppid" value="" />
<input type="hidden" id="upfolderid" value="" />

<div style="display:hidden;background:#fff;" id="cwDialog">
	
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

		$('#viewcontent').on('mouseover','.scoreBar',function(){
			$(this).find('.changescore').show();
		}).on('mouseout',function(){
			$(this).find('.changescore').hide();
		});
	});
	setInterval(function(){
		examobj.fixWpos();
	},1000);
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
</script>
</body>
</html>