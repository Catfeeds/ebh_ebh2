<?php
$this->display('troom/room_header');
if($this->input->cookie('refer'))
	$mainurl = urldecode($this->input->cookie('refer'));
else
	$mainurl = geturl('troom/mysetting');
if($room['domain'] == 'zjgxedu')
	$mainurl = geturl('troom/classsubject/courses');
else if($room['domain'] == 'lcyhg'){
	$mainurl = geturl('troom/classexam');
}
$refurl = $this->input->get('url');
if(!empty($refurl))
	$mainurl = $refurl;
$this->input->setCookie('refer','');
?>
<style>
	#QDialog{
		text-align:center;border-bottom: 1px solid #E4E4E4;
	}
	#QDialog .header{
		height:60px;line-height:60px;border: 1px solid #E4E4E4;border-bottom: 0;
	}
	#QDialog .header .leftcol{
		width:99px;display:block;float:left;border-right: 1px solid #E4E4E4;
	}
	#QDialog .header .middlecol{
		width:699px;display:block;float:left;border-right: 1px solid #E4E4E4;
	}
	#QDialog .header .rightcol{
		width:100px;display:block;float:left;
	}
	#QDialog .content{
		width:900px;min-height:60px;overflow:hidden;border: 1px solid #E4E4E4;border-bottom: 0;
	}
	#QDialog .content .leftcol{
		width:100px;line-height:60px;display:block;float:left;
	}
	#QDialog .content .middlecol{
		font: 14px Arial,sans-serif;color: #282;font-weight: bold;width:698px;line-height:60px;float:left;overflow: hidden;border-right: 1px solid #E4E4E4;border-left: 1px solid #E4E4E4;
	}
	#QDialog .content .rightcol{
		font: 14px Arial,sans-serif;color: #282;font-weight: bold;width:100px;line-height:60px;float:left;overflow: hidden;
	}
	#QDialog .content .rightcol .workBtn{
		padding: 5px 10px;
		color: #FFFFEE;
		background: #18a8f7;
		text-decoration: none;
		cursor: pointer;
		border: none;
	}
	#QDialog .content .rightcol .workBtn:hover{
		padding: 5px 10px;
		color: #FFFFFF;
		background: #18a8f7;
		text-decoration: none;
		cursor: pointer;
		border: none;
	}
	.wxselected{
		background-color: red;
	}
	.uploadbtn{
	  background: #18a8f7;
	  padding: 6px;
	  border: 1px solid #eee;
	  -moz-border-radius: 4px;
	  -webkit-border-radius: 4px;
	  border-radius: 4px;
	  color: #fff;
	}
</style>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css" media="screen" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/css/statch.css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen">
<link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" />	
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/upload.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js?v=20150731"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common2.js?version=20150528001"></script>
<script type="text/javascript">
<!--
var resetmain = function(){
	var mainFrame = document.getElementById("mainFrame");
	if(mainFrame.contentWindow.window.document.documentElement && mainFrame.contentWindow.window.document.body){
		var iframeHeight = Math.min(mainFrame.contentWindow.window.document.documentElement.scrollHeight, mainFrame.contentWindow.window.document.body.scrollHeight)+50;
	}else{
		var iframeHeight = 665;
	}
	iframeHeight = iframeHeight<665?665:iframeHeight;
	$(mainFrame).height(iframeHeight);
}

$(function(){
	var myroomitem_li =$(".myroomitem li");
	myroomitem_li.hover(function(){
		$(this).addClass("itemcurr");
	},function(){
		$(this).removeClass("itemcurr");
	})
})
function showdetail() {
	var src = "<?= geturl('troom/setting/upmessage') ?>";
	//src = src + "?t=" + Math.random();

	if ($("#dislog").attr("src") != src)
	{
		$("#dislog").attr("src",src);
	}
	
	H.create(new P({
		id:'dialogdiv',
		url:src,
		width:968,
		height:720,
		title:'平台详细介绍修改',
		easy:true
	}),'common').exec('show');

}
function closedetail(status) {
	H.get('dialogdiv').exec('close');
	$("#dislog").attr("src","about:blank");
}

function showimage(selector) {
	$(selector,document.getElementById('mainFrame').contentWindow.document).lightBox();
}
function showimage2(imgobj){
	H.create(new P({
		title:'原始答案',
		content:'<img src="'+imgobj.src+'"/>',
		easy:true
	}),'common').exec('show');
}
var wx = {searchtext : "请输入关键字"};
function wxsearch(){
  var uname = $("#title").val().replace(/\s+/g,"");
  if(uname == wx.searchtext){
  	$("#chooseStudent ul li :checkbox").siblings('label').removeClass('wxselected');
  	return;
  }
  $("#chooseStudent ul li :checkbox").siblings('label').removeClass('wxselected');
  $.each($("#chooseStudent ul:visible li :checkbox"),function(idx,obj){
  	if($(obj).attr('tag').replace(/\s+/g,"").indexOf(uname)!=-1){
  		window.location.hash = $(obj).attr("id");
  		$(obj).siblings("label").addClass('wxselected');
  	} 
  });
  // alert(uname);
}
//-->
//播放课件或者下载附件
function showplayDialog(source,cwid){
	if(typeof courseObj == "undefined"){
		courseObj = new Course(showCourseware,delCourseware);
	}
	if(!source || !cwid){
		return false;
	}
	courseObj.userplay(source,cwid);return false;
}
</script>

<script>
	
var showCourseware = function(source,cwid,qid,cwurl){
	H.get('upCoursewareDialog').exec('close');
    $('#showcw').html('<a id="playbutton" class="uploadbtn" onclick="course.userplay(\''+source+'\',\''+cwid+'\');return false;" href="javascript:void(0);">查看附件</a>&nbsp;<a id="delbutton" class="delbutton" title="删除解析附件" onclick="course.delCourseware(\''+qid+'\')" href="javascript:;">x</a>');
    $('#uploadcw').hide();
    $('#cwid').val(cwid);
    $('#cwsource').val(source);
}
var delCourseware = function(){
	H.get('upCoursewareDialog').exec('close');
    $("#uploadcw").show();
    $('#showcw').empty();
    $('#cwid').val(0);
    $('#cwsource').val("");
}
var course = new Course(showCourseware,delCourseware);
</script>
<div class="wrap">
<div class="cmain clearfix">
<?php $this->display('troom/room_left'); ?>
	<div class="cright">
		<iframe onload="resetmain()" id="mainFrame" name="mainFrame" scrolling="no" width=100% height=100% frameborder=0 src="<?= $mainurl ?>"></iframe>
	</div>
	</div>
<div id="dialogdiv" style="display:none">
<iframe width="100%" height="100%" frameborder="0" src="about:blank" id="dislog" name="dialog"></iframe>
</div>
<!-- =============== -->
<div style="display:none;">
	<div id="tandaandiv" class="tandaan" style="float:left;display:none;width:676px;padding:20px;">
	<div class="zhumai">
	<?php
        EBH::app()->lib('UMEditor')->xEditor('message','775px','310px');
	?>
<!--上传音频-->
	<div style="background:#fff;float:left;min-height: 53px;width:776px;">
		<div style="float:left;margin-left:15px;width:70px;margin-top:16px; ">上传音频：</div>
		<div style="float:left;margin-left:0px;width:455px;margin-top:10px; " id="audio_float">
	 		<a href="javascript:void(0)" id="startrecord" style="width:63px;height:27px;line-height:27px;background:#E3F2FF;border:solid 1px #A2D1F1;display:block;text-align:center;text-decoration: none;font-size:14px;" >录制</a>
		</div>
	
		 <div style="float:left;width:560px;height:200px;display:none" id="showrecorder">
			<object width="500" height="200" class="recoderSwf" data="http://static.ebanhui.com/ebh/flash/recoderSwf.swf" type="application/x-shockwave-flash" >
			<param value="transparent" name="wmode">
			<param value="http://static.ebanhui.com/ebh/flash/recoderSwf.swf" name="movie">
			<param value="high" name="quality">
			<param value="false" name="menu">
			<param value="always" name="allowScriptAccess">
			</object>
		  </div>  
		<div style="float:left;width:455px;height:50px;_margin-top:20px;display:none" id="audio_show">
			<div class="upprogressbox" id="image_upprogressbox" style="display: block;width:475px;background-color:#fff;">
				<div class="upfileinfo" style="width:475px;">
				<span class="upstatusinfo">
				<img src="http://static.ebanhui.com/ebh/images/upload.gif"></span>
				<span class="spanUpfilename" id="audio_name"></span>
				<span id="image_spanUppercent">100%</span>
				<span><a onclick="deleteaudio()" href="javascript:void(0);">&nbsp;删除</a></span>
				</div>
				<div class="upprogressbar" style="width:475px;"><span class="upprogressstext">上传总进度：</span>
				<span class="spanUppercentBox" id="image_spanUppercentBox">
				<span class="spanUpShowPercent" id="image_spanUpShowPercent" style="width: 100%;"></span></span>
				<span class="spanUppercentinfo" id="image_spanUppercentinfo">100%</span></div>
			</div>
		</div>
		 <div style="clear:both" id="showcourseware">&nbsp;</div>
        <div style="float:left;margin-left:15px;width:70px;margin-top:16px; ">上传附件：</div>
        <div id="courseware" style="float:left;margin-left:0px;width:455px;margin-top:10px; ">
            <!-- <a href="javascript:void(0)" id="uploadcw" onclick="course.uploadCourseware(1);">上传解析附件</a> -->
            <button class="uploadbtn" id="uploadcw" onclick="course.uploadCourseware(1);">上传附件</button>
            <span id="showcw"></span>
        </div>
        <div style="clear:both" id="showcoursewareend">
        	<a class="tijiaobtn" onclick="sendMessage()" style="margin-right:20px;">提  交</a>
        </div>
		<div style="clear:both">&nbsp;</div>
		<input type="hidden" value="" name="audio" id="audio" />
		<input type="hidden" value="" name="cwid" id="cwid" />
        <input type="hidden" value="" name="cwsource" id="cwsource" />
	</div> 
<!--结束-->
	</div>
   </div>
</div>
<script>
	function showDialog(dom,qid){
		window.dom = dom;
		if(H.get(dom)){
			H.get(dom).exec('show');
			return;
		}

		H.create(new P({
			title:"解答编辑器",
			content:$("#"+dom)[0],
			id:dom,
			width:820,
			easy:true
		},{
			'onclose':function(){
				H.get('upCoursewareDialog').exec('close');
				$("#delbutton").trigger("click");
		    	ue.reset();
				return false;
			},
			'onshow':function(){
				ue.focus();
				ue.setContent("");
				return false;
			}
		}),'common').exec('show');
	}
	function sendMessage(){
		var content = UM.getEditor('message').getContent();
		var requestWindow = document.getElementById('mainFrame').contentWindow;
		requestWindow.ue.setContent(content);
		requestWindow.callback();
		try{
			ue.reset();
			deleteaudio();
			H.get('upCoursewareDialog').exec('close');
			H.get(dom).exec('close');
		}catch(e){

		}
	}

//接受flash返回的audiosrc
function getURL(url){
	//alert(url);
	var audioname = url.substring(url.lastIndexOf('/')+1);
	$("#audio").attr("value",url);
	$("#showrecorder").hide();
	$("#audio_float").hide();
	
	$("#audio_name").html(audioname);
	$("#audio_show").show();
}
//删除录制上传的音频
function deleteaudio(){
	$("#audio_show").hide();
	$("#audio_float").show();
	$("#audio").attr("value",'');
}

$("#startrecord").click(function(){
  	$('#showrecorder').toggle();
  	$(".recoderSwf").remove();
  	$("#showrecorder").html('<object width="500" height="200" class="recoderSwf" data="http://static.ebanhui.com/ebh/flash/recoderSwf.swf" type="application/x-shockwave-flash" ><param value="transparent" name="wmode"><param value="http://static.ebanhui.com/ebh/flash/recoderSwf.swf" name="movie" id="recoder_url"><param value="high" name="quality"><param value="false" name="menu"><param value="always" name="allowScriptAccess"></object>');
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

</script>

<script src="http://static.ebanhui.com/ebh/js/swfobject.js" type="text/javascript"></script>
 <div id="flvwrap" style="display:none;">
     <div id="flvcontrol"></div>
 </div>
<script>
/**
*播放视频
*/
function playflv_top(source,cwid,title,isfree,num,height,width,hasbtn,callback){
	var url = source+"attach.html?examcwid="+cwid;
	url = encodeURIComponent(url);
	if(hasbtn == undefined)
		hasbtn = 0;
	var vars = {
		source: url,
		type: "video",
		streamtype: "file",
		server: "",
		duration: "52",
		poster: "",
		autostart: "false",
		logo: "",
		logoposition: "top left",
		logoalpha: "30",
		logowidth: "130",
		logolink: "http://www.ebanhui.com",
		hardwarescaling: "false",
		darkcolor: "000000",
		brightcolor: "4c4c4c",
		controlcolor: "FFFFFF",
		hovercolor: "67A8C1",
		controltype: 1,
		classover: hasbtn
	};
	H.create(new P({
		title:'视频播放',
		easy:true,
		flash:HTools.pFlash({'id':'playflv','uri':"http://static.ebanhui.com/ebh/flash/videoFlvPlayer.swf",'vars':vars})
	}),'common').exec('show');
}
</script>
<script>
	//学生类
	var Student = function(suid,classid,weixin_name){
		this.init(suid,classid,weixin_name);
	}
	Student.prototype = {
		constructor:Student,
		init:function(suid,classid,weixin_name){
			this.suid  = suid;
			this.classid = classid;
			this.weixin_name = weixin_name;
			this.msg = "";
		},
		setMessage:function(msg){
			this.msg = msg;
			return this;
		},
		getMessage:function(){
			return this.msg;
		}
	}

	//消息类
	var Message = function(content){
		this.content = content;
	}

	//超级班级容器类(用来放班级容器)
	var SuperContainer = function(){
	}
	SuperContainer.prototype = {
		constructor:SuperContainer,
		add:function(key,value){
			this[key] = value;
		},
		remove:function(key){
			delete this[key];
		},
		get:function(key){
			return this[key];
		}
	}

	//班级容器类,专门放该班级的学生
	var Classx = function(classid,total){
		this.total = total;
		this.classid = classid;
		this.curnum = 0;
		this.stroage = new Object();
		this.isAllStu = false;
		this.msg = "";
	}

	Classx.prototype = {
		constructor:Classx,
		get:function(key){
			return this.stroage[key];
		},
		add:function(key,value){
			if(!this.stroage[key]){
				this.curnum++;
			}
			this.stroage[key] = value;
			return this.check();
		},
		remove:function(key){
			if(this.stroage[key]){
				this.curnum--;
			}
			delete this.stroage[key];
			return this.check();
		},
		check:function(){
			if(this.total == this.curnum){
				return this.isAllStu = true;
			}else{
				return this.isAllStu = false;
			}
		},
		setMessage:function(msg){
			this.msg = msg;
		},
		getMessage:function(){
			return this.msg;
		}
	}
	



</script>

<script>
	var pagecontext = document.getElementById('mainFrame').contentWindow.document;
	function setStuEvent(id){
		$("#"+id+" :checkbox[suid]").bind('click',function(){
			var classid = $(this).attr('classid');
			var total = $(":checkbox[isclass=1][classid="+classid+"][id]").attr('total');
			var checkedTotal = $(":checkbox[suid][classid="+classid+"]:checked").length;
			if($(this).prop('checked') == true && (total == checkedTotal)){
				$(":checkbox[isclass=1][classid="+classid+"]").prop('checked','checked');
				srender(this,1);
			}else{
				$(":checkbox[isclass=1][classid="+classid+"]").prop('checked',false);
				srender(this);
			}
			checkIfChooseAll();
		});
	}

	function setClassEvent(id){
		$("#"+id+"[isclass=1]").bind('click',function(){
			var classid = $(this).attr('classid');
			if($(this).prop('checked') == true){
				$(":checkbox[classid='"+classid+"']").prop('checked','checked');
				crender(this);
			}else{
				$(":checkbox[classid='"+classid+"']").prop('checked',false);
				crender(this);
			}
		});
	}

	

	function getWeixinData(){
		var msg =document.getElementById('mainFrame').contentWindow.getWeixinContent();
		if(msg == ""){
			return "fail_to_load_msg";
		}
		var s = new SuperContainer();
		//循环班级
		$.each($("#chooseClass :checkbox[isclass=1]:checked"),function(key,obj){
			var classid = $(obj).attr('classid');
			var total = $(obj).attr('total');
			s.get(classid) || s.add(classid,new Classx(classid,total));
			s.get(classid).isAllStu = true;
			s.get(classid).setMessage(new Message(msg));
		});

		//循环学生
		$.each($(".xuanque :checkbox[isclass=1]").not(":checked"),function(key,obj){
			var classid = $(obj).attr('classid');
			var total = $(obj).attr('total');
			var $checkedStu  = $(":checkbox[suid][classid="+classid+"]:checked");
			if($checkedStu.length == 0){
				return ;
			}
			s.get(classid) || s.add(classid,new Classx(classid,total));
			s.get(classid).setMessage(new Message(msg));
			$.each($checkedStu,function(skey,sobj){
				var suid = $(sobj).attr('suid');
				var classid = $(sobj).attr('classid');
				var weixin_name = $(sobj).attr('weixin_name');
				s.get(classid).add(suid,new Student(suid,classid,weixin_name).setMessage(new Message(msg)));
			});
		});
		return s;
	}

	function srender(e,tag){
		var classid = $(e).attr('classid');
		var suid = $(e).attr('suid');
		var checked = $(e).prop('checked');
		var name = $(e).attr('tag');
		var key_prefix = 'stu_'+classid+'_';
		if(tag==1){
			$("*[xid^="+key_prefix+"]").remove();
			$("*[xid^="+key_prefix+"]",document.getElementById('mainFrame').contentWindow.document).remove();
			$("#wrap").append(createHtml('class_'+classid,$(":checkbox[isclass][classid="+classid+"]").attr('tag'),'class',classid));
			$("#wrap2",document.getElementById('mainFrame').contentWindow.document).append(createHtml('class_'+classid,$(":checkbox[isclass][classid="+classid+"]").attr('tag'),'class',classid));
			return;
		}
		if(checked){
			$("#wrap").append(createHtml(key_prefix+suid,name,'stu',suid));
			$("#wrap2",document.getElementById('mainFrame').contentWindow.document).append(createHtml(key_prefix+suid,name,'stu',suid));
			return;
		}else{
			$("*[xid=class_"+classid+"]").remove();
			$("*[xid=class_"+classid+"]",document.getElementById('mainFrame').contentWindow.document).remove();
			$("*[xid^="+key_prefix+"]").remove();
			$("*[xid^="+key_prefix+"]",document.getElementById('mainFrame').contentWindow.document).remove();
			$.each($(":checkbox[suid][classid="+classid+"]:checked"),function(key,obj){
				$("#wrap").append(createHtml(key_prefix+$(obj).attr('suid'),$(obj).attr('tag'),'stu',$(obj).attr('suid')));
				$("#wrap2",document.getElementById('mainFrame').contentWindow.document).append(createHtml(key_prefix+$(obj).attr('suid'),$(obj).attr('tag'),'stu',$(obj).attr('suid')));
			});
		}
	}

	function crender(e){
		var classid = $(e).attr('classid');
		var checked = $(e).prop('checked');
		var name = $(e).attr('tag');
		if(checked){
			$("*[xid^=stu_"+classid+"]").remove();
			$("*[xid^=stu_"+classid+"]",document.getElementById('mainFrame').contentWindow.document).remove();
			$("#wrap").append(createHtml('class_'+classid,name,'class',classid));
			$("#wrap2",document.getElementById('mainFrame').contentWindow.document).append(createHtml('class_'+classid,name,'class',classid));
			checkIfChooseAll();
		}else{
			$("*[xid=class_"+classid+"]").remove();
			$("*[xid=class_"+classid+"]",document.getElementById('mainFrame').contentWindow.document).remove();
			$("#chooseAllClass").prop('checked',false);
			checkIfChooseAll();
		}
	}

	function createHtml(id,name,type,trueid){
		if(type=='class'){
			return '<li xid='+id+' onclick="triggerEvent('+trueid+',\'class\')" class="lantewu"><a href="javascript:void(0)" class="languan"></a>'+name+'</li>';
		}else{
			return '<li xid='+id+' onclick="triggerEvent('+trueid+',\'stu\')" class="lvtewu"><a href="javascript:void(0)" class="lvguan"></a>'+name+'</li>';
		}
		
	}
	
	function triggerEvent(trueid,type){
		if(type=='class'){
			if($(":checkbox[isclass=1][classid="+trueid+"][id]").length==0){
				$("#wrap li[xid=class_"+trueid+"]").remove();
				$("#wrap2",document.getElementById('mainFrame').contentWindow.document).find("li[xid=class_"+trueid+"]").remove();
				$(":checkbox[xxid=class_choose_"+trueid+"]").prop('checked',false);
				checkIfChooseAll();
				return;
			}
			$(":checkbox[isclass=1][classid="+trueid+"][id]").trigger('click');
			checkIfChooseAll();
		}else{
			$(":checkbox[suid="+trueid+"]").trigger('click');
		}
	}

	function checkIfChooseAll(){
		if($("input[xxid^=class_choose_]").not(":checked").length == 0){
				$("#chooseAllClass").prop('checked',true);
		}else{
			$("#chooseAllClass").prop('checked',false);
		}
	}
	function getClassAndStudentsInfo(classid){
		if($("#class_choose_"+classid).length > 0){
			$("ul[id^=class_choose_ul_]").hide();
			$("#class_choose_ul_"+classid).show();
			$("div.xuanque :checkbox[isclass=1]").hide();
			$("div.xuanque :checkbox[isclass=1][classid="+classid+"]").show();
			return ;
		}
		$.ajax({
		  type: "GET",
		  url: "<?=geturl('troom/weixin/student_send_msg')?>?inajax=1&classid="+classid,
		  dataType: "json",
		  success:function(data){
		  	renderSelect(data);
		  }
		});
	}

	function renderSelect(data){
		var checkedStr = "";
		if($("#wrap li[xid=class_"+data.classid+"]").length > 0){
			checkedStr = "checked=checked";
		}
		var html = new Array();
		html.push('<ul id="class_choose_ul_'+data.classid+'">');
		$.each(data.studentlist,function(skey,svalue){
			html.push('<li>');
			html.push('<input '+checkedStr+' type="checkbox" class="teatle" id="label_'+svalue['uid']+'"  suid="'+svalue['uid']+'" classid="'+data.classid+'" weixin_name="'+svalue['wx_openids']+'" tag="'+(svalue['realname']||svalue['username'])+'">');
			html.push('<label class="namester" for="label_'+svalue['uid']+'" >'+(svalue['realname']||svalue['username'])+'</label>');
			html.push('</li>');
		});
		html.push('</ul>');
		$("ul[id^=class_choose_]").hide();
		$('#chooseStudent').append(html.join(''));

		$("div.xuanque :checkbox[isclass=1]").hide();
		if($("div.xuanque :checkbox[isclass=1][classid="+data.classid+"]").length == 0){
			var html = '<input '+checkedStr+' id="class_choose_'+data.classid+'" class="teatle" type="checkbox" isclass="1" classid="'+data.classid+'" total="'+data.stucount+'" tag="'+data.classname+'">';
			$("div.xuanque").prepend(html);
		}else{
			$("div.xuanque :checkbox[isclass=1][classid="+data.classid+"]").show();
		}

		setStuEvent("class_choose_ul_"+data.classid);
		setClassEvent("class_choose_"+data.classid);
	}

	function classChoseEvent(e){
	    var classid = $(e).attr('classid');
	    if($(e).prop('checked') == true){
	      $(":checkbox[classid='"+classid+"']",parent.document).prop('checked','checked');
	      crender(e);
	    }else{
	      $(":checkbox[classid='"+classid+"']",parent.document).prop('checked',false);
	      crender(e);
	    }
	}
</script>
<!-- ============= -->

<!-- ====关联课件弹出窗口======= -->
<script>
	function linkDialog(eid){
		window.link_eid = eid;
		$("#course_forlink").attr('src','/troom/linkcourse/coursesDialog.html');
		H.create(new P({
			title:'关联课件',
			id:'link',
			content:$("#course_forlink")[0],
			easy:true,
			padding:5
		}),'common').exec('show');
	}

	function showLinkListDialog(folderid){
		$("#course_forlink_list").attr('src','/troom/linkcourse/'+folderid+'.html');
		H.create(new P({
			title:'关联课件',
			id:'link_linklist',
			content:$("#course_forlink_list")[0],
			easy:true,
			padding:5
		}),'common').exec('show');
	}

	function closeLinkDialog(info){
		$.showmessage({
			message:info,
			callback:function(){
				H.remove('link_linklist');
				H.remove('link');
				document.getElementById('mainFrame').contentWindow.location.reload();
			}
		});
	}
</script>
<div style="display:none;width:790px;height:auto;overflow-x:hidden;">
<iframe  width=788 height=570 src="#" id="course_forlink" frameborder="0"></iframe>
</div>
<div style="display:none;width:790px;height:auto;overflow-x:hidden;">
<iframe  width=810 height=580 src="#" id="course_forlink_list" frameborder="0"></iframe>
</div>
<!-- =========================== -->
<div class="clear"></div>
</div>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xPhoto.js?v=3"></script>
<script>

//准备一个xPhoto实例(用时调用)
function preparexPhoto(id,callback,initpicurl,upurl){
	var upurl = 'http://up.ebh.net/imghandler.html?type=pic&subtype=courselogo';
	window.xphoto = new xPhoto({
		id:id,
		title:'封面上传',
		callback:callback,
		initpicurl:initpicurl,
		upurl:encodeURIComponent(upurl),
		cancelcallback:function(){
			window.xphoto.doClose();
		},
		sizearr:new Array('178_103'),
		sizemsgarr:new Array('封面尺寸为178*103')
	});
	window.xphoto.renderDialog();
}
</script>
<?php 
$this->display('troom/room_footer'); 
$this->display('common/player'); 
?>