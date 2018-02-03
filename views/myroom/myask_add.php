<?php $this->display('myroom/page_header'); ?>
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/dayi.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" />	
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/upload.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js?v=20150731"></script>
<style>
.lefkty em{
	line-height:28px;
}
.wenzid{
	font-weight:bold;
	color:#777;
}
html{
	background:#f2f2f2;
}
.leftke{
	width:88px;
}
.trekt{
	border:0;
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
.ui-dialog2-content{
	text-align:left;
}
</style>
<div style="height:1500px;width:788px;float:left;">
<div class="ter_tit">
当前位置 > 提交问题
</div>
<div class="lefrig">
<div class="workol">

	<div class="tit_search" style="margin-top:0px">
<form id="askform">
<div class="biaowaim">
  <input class="titwenti" name="title" id="title" type="text" value="" maxlength="50"/>
  <div class="txtxdaru" style="float:left;width:760px;display: inline;">

  <?php $editor->xEditor('message','99%','500px'); ?>

  </div>
  
 <div class="fontfen" style="width:730px;margin-left:15px;margin-bottom:10px;margin-top:10px;height:50px;">
  <span class="wenzid" style="width:70px;">所属课程：</span>
	<div class="eeret" id="eeret1">
		<a class="ekiyt" href="javascript:void(0)">当前选择课程：<span id="show_foldername" class="show_foldername"><?= isset($folder['foldername'])?$folder['foldername']:'无';?></span></a>
		<input type="hidden" name="folderid" id="folderid"  value="<?=$folder['folderid']?>" />
	</div>
	<?php if($showTeacherSelect == true){?>
	<span class="wenzid" style="width:70px;">指定老师：</span>
	<div class="eeret" id="eeret2" style="background:url(http://static.ebanhui.com/ebh/images/xuanter.jpg) no-repeat;width:140px;">
		<a class="ekiyt" href="javascript:void(0)"><span class="show_terchername"><?=empty($teacher['realname'])?'无':$teacher['realname']?></span></a>
		<input type="hidden" name="tid" value="<?=empty($teacher['uid'])?'':$teacher['uid']?>" />
	</div>
	<?php }?>
  </div>
  
  <div class="fontfen" style="width:700px;margin-left:15px;margin-bottom:10px;height:50px;<?=empty($cw)?'display:none':''?>" id="cwblock">
  <span class="wenzid" style="width:70px;">相关课件：</span>
	<div class="eeret" id="eeret3" onclick="showcw('选择课件')">
		<a class="ekiyt"  href="javascript:void(0)">当前选择课件：<span id="show_cwname" class=""><?= isset($cw['title'])?shortstr($cw['title'],44):'无';?></span></a>
		<input type="hidden" name="cwname" id="cwname" value="<?=empty($cw['title'])?'':$cw['title']?>"/>
		<input type="hidden" name="cwid" id="cwid" value="<?=empty($cw['cwid'])?'':$cw['cwid']?>" />
	</div>
  </div>

<div class="trekt" id="teacherdiv" style="display:none">
	<?php foreach($groupInfo as $key => $onegroup){?>
	
		<div class="titkets">
			<div class="leftkes"><?=$onegroup[0]['groupname']?>：</div>
			<div class="rigleis">
				<ul>
		<?php foreach($onegroup as $group){
		if(!empty($group['face'])){
			$face = getthumb($group['face'],'50_50');
		}else{
			if(!empty($group['sex'])){
				$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
			}else{
				$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
			}
			$face = getthumb($defaulturl,'50_50');
		}
		if(!empty($group['uid'])){
			$tname = empty($group['realname'])?$group['username']:$group['realname'];
		?>
			<li class="etklys">
				<a class="auttdss" tid="<?=$group['uid']?>" tname="<?=$tname?>"><img src="<?=$face?>"></a><a class="atfwt auttdss" style="padding-top:0px" tid="<?=$group['uid']?>" tname="<?=$tname?>"><?=$tname?></a>
			</li>
		<?php }
		}?>
				</ul>
			</div>
		</div>
	<?php }?>
</div>
  <div style="float:left;margin-left:19px;width:70px;_margin-top:20px;margin-top:5px;font-weight:bold;color:#777;">相关图片：</div>
  <div style="width:680px;_margin-top:20px; float:left;">
		<ul class="sckcfm" id="logo-box">
			<li class="fl noimg" style="position:relative;">
				<a href="javascript:;" class="glitus" id="Button1"></a>
				<img r="0" src="http://static.ebanhui.com/ebh/tpl/selcur/images/kcfmadd.jpg" style="cursor:pointer;width:180px;height:110px;" id="uploadimg" >
			</li>
		</ul>
  	</div>
	<div style="background:#fff;float:left">
	 <div style="float:left;margin-left:19px;width:70px;margin-top:14px;font-weight:bold;color:#777;">我的语音：</div>
	 <div style="float:left;margin-left:0px;width:610px;margin-top:10px; " id="audio_float">
	 	<a href="javascript:void(0)" id="startrecord" style="width:63px;height:27px;line-height:27px;background:#E3F2FF;border:solid 1px #A2D1F1;display:block;text-align:center;text-decoration: none;font-size:14px;" >录制</a>
	 </div>
	
	 <div style="float:left;width:100%;height:200px;display:none" id="showrecorder">
		<object width="500" height="200" class="recoderSwf" data="http://static.ebanhui.com/ebh/flash/recoderSwf.swf" type="application/x-shockwave-flash" >
		<param value="transparent" name="wmode">
		<param value="http://static.ebanhui.com/ebh/flash/recoderSwf.swf" name="movie">
		<param value="high" name="quality">
		<param value="false" name="menu">
		<param value="always" name="allowScriptAccess">
		</object>
	  </div>  
		<div style="float:left;width:630px;height:50px;_margin-top:20px;display:none" id="audio_show">
		<div class="upprogressbox" id="image_upprogressbox" style="display: block;">
		<div class="upfileinfo">
		<span class="upstatusinfo">
		<img src="http://static.ebanhui.com/ebh/images/upload.gif"></span>
		<span class="spanUpfilename" id="audio_name"></span>
		<span id="image_spanUppercent">100%</span>
		<span><a onclick="deleteaudio()" href="javascript:void(0);">&nbsp;删除</a></span>
		</div><div class="upprogressbar"><span class="upprogressstext">上传总进度：</span>
		<span class="spanUppercentBox" id="image_spanUppercentBox">
		<span class="spanUpShowPercent" id="image_spanUpShowPercent" style="width: 100%;"></span></span>
		<span class="spanUppercentinfo" id="image_spanUppercentinfo">100%</span></div></div>
		</div>
		<input type="hidden" value="" name="audio" id="audio" />
	</div>
	
	<div style="float:left;margin-left:19px;width:72px;font-weight:bold;color:#777;margin-top:16px">积分悬赏：
	</div>
	<div style="float:left;width:610px;margin-top:14px">
	<select style="font-size:14px" name="reward">
	<?php $askreward = EBH::app()->getConfig()->load('askreward');
		foreach($askreward as $k=>$reward){
			if($user['credit']>=$reward){
	?>
		<option value="<?=$k?>"><?=$reward?>积分</option>
	<?php }}?>
		
	</select>
	</div>
	
	<div class="fontfen" id="doheight">
	<input class="tijibtn" style="margin-left:320px;width:190px;margin-right:20px;float:left;" type="button" value="提交问题" />
	</div>
</div>
</form>
</div>
</div>
<div id="coursedialogdiv" style="display:none">
	<div class="titket" style="width:720px;overflow-x:hidden;background:white;height:250px;overflow-y:auto">
	<div class="leftke" style="width:720px;overflow-x:hidden;">我的课程：</div>
		<div class="riglei" style="width:720px;overflow-x:hidden;">
		<ul>
		<?php if($myfolders){foreach($myfolders as $myfolder){?>
		<li class="etkly" style="white-space:nowrap;"><a class="atfwt auttds" tname="<?= $myfolder['tid_realname']?>" tid="<?=empty($myfolder['tid'])?0:$myfolder['tid']?>" fid=<?=$myfolder['folderid']?>><?=$myfolder['foldername']?></a></li>
		<?php }}?>
		</ul>
		</div>
	</div>
	<?php if($otherfolders){ ?>
	<div class="ewtlt" style="width:720px;overflow-x:hidden;background:white;height:250px;overflow-y:auto">
		<div class="leftke">其他课程：</div>
			<div class="riglei" style="width:720px;overflow-x:hidden;">
			<ul>
				<?php foreach($otherfolders as $key=>$otherfolder){ ?>
						<li class="etkly" style="cursor:pointer;white-space:nowrap;"><a class="atfwt auttds"  tname="<?= $otherfolder['realname']?>" tid="<?=$otherfolder['tid']?>" fid=<?=$key?>><?=$otherfolder['foldername']?></a></li>
				<?php }?>
			</ul>
			</div>
	</div>
	<?php } ?>
</div>
<script type="text/javascript">
var swf = null;
HTools.rFlash({
	id:'Button1',
	uri:'http://static.ebanhui.com/ebh/flash/MultiImageUploadaddqu.swf',
	vars:{'xmlurl':'http://static.ebanhui.com/ebh/flash/xml/webDataStudent.xml'},
	width:178,
	height:108,
});
//flash调用js提示
function calltips(type){
	var msg = '上传失败';
	switch (type){
	 	case 0 : msg = '文件过大,单张图片不能超过2m';
	 	break;
	 	case 1 : msg = '图片数量不能超过9张';
	 	break;
	 	case 2:msg = '图片上传失败,请刷新后重试';
	 	break;
	}
	//'图片数量不能超过9张'
	top.dialog({
			title: '提示信息',
			content: msg,
			width:370,
			cancel: false,
			okValue: '确定',
			ok: function () {
			}
		}).showModal();
}
//图片上传以后的处理
function callImageUpload(data){	
	if(data.success == true){
		var html = '';
		$(data.data).each(function(){
			//console.log(this.showurl);
			var showurl = this.showurl;
			var thumpc = this.thumpc;
			html += '<li class="fl hasimg"  style="position:relative;"><img r="0" src="'+thumpc+'" style="cursor:pointer;width:180px;height:110px;" ><input name="images[]" type="hidden" value="'+showurl+'"><input name="imagesname[]" type="hidden" value="'+showurl+'"><a onclick="removeimg(this);" href="javascript:void(0);" class="remove-img languan" style="display:block;"></a></li>';
		});
		$('.noimg').before(html);
		if($(".hasimg").length >= 9){
			$('.noimg').hide();
		}
	}else{
		top.dialog({
			title: '提示信息',
			content: data.message,
			width:370,
			cancel: false,
			okValue: '确定',
			ok: function () {
			}
		}).showModal();
	}
}


$(function(){
	$("#eeret1").click(function(){
		if(!H.get('artdialogcourse')){
			H.create(new P({
				id : 'artdialogcourse',
				title: '选择课程',
				easy:true,
			    width:720,
			    padding:5,
				content:$('#coursedialogdiv')[0]
			}),'common');
		}
		var folderid = $("input[name=folderid]").val();
		if(folderid){
			$("li.rtytle .atfwt,li.etkly .atfwt").each(function(){
				$(this).css('background','');
				var fid = $(this).attr('fid');
				if(fid==folderid){
					$(this).css('background','#b1d6e9');
				}
			});
		}
		H.get('artdialogcourse').exec('show');

	});
	$("li.rtytle .atfwt,li.etkly .atfwt").click(function(){
		var foldername = $(this).html();
		var folderid = $(this).attr('fid');
		var tid = $(this).attr('tid');
		$(".show_foldername").html(foldername);
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
})

$(function(){
	thtml = $('#teacherdiv')[0];
	$("#eeret2").click(function(){
		if(!H.get('artdialogteacher')){
			H.create(new P({
				id : 'artdialogteacher',
			    title: '指定老师',
			    easy:true,
			    padding:5,
			    content:$('#teacherdiv')[0]
			}),'common');
		}
		var tercherid = $("input[name=tid]").val();
		if(tercherid){
		$("li.etklys .auttdss").each(function(){
			$(this).css('color','#888');
			var tid = $(this).attr('tid');
			if(tid==tercherid){
				$(this).css('color','#18A8FE');
				}
			});
		}
		H.get('artdialogteacher').exec('show');
	});
	$("li.etklys .auttdss").click(function(){
		var terchername = $(this).attr('tname');
		var tid = $(this).attr('tid');
		$(".show_terchername").html(terchername);
		$("input[name=tid]").attr("value",tid);
		H.get('artdialogteacher').exec('close');
	});
})
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
var titletips = "请在这里输入问题标题";
$(function(){
	settips("title",titletips);
        $(".tijibtn").click(function(){
            if(checkquestion()) {
                addquestion();
            }
        });
        $("#startrecord").click(function(){
        	  $('#showrecorder').toggle();
        	  $(".recoderSwf").remove();
        	  $("#showrecorder").html('<object width="500" height="200" class="recoderSwf" data="http://static.ebanhui.com/ebh/flash/recoderSwf.swf" type="application/x-shockwave-flash" ><param value="transparent" name="wmode"><param value="http://static.ebanhui.com/ebh/flash/recoderSwf.swf" name="movie" id="recoder_url"><param value="high" name="quality"><param value="false" name="menu"><param value="always" name="allowScriptAccess"></object>');
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
function checkquestion() {
	if($.trim($("#title").val()) == "" || $.trim($("#title").val()) == titletips) {
		alert("问题的标题不能为空");
		return false;
	}
	if($.trim($("#title").val()).length < 5 || $.trim($("#title").val()) == titletips) {
		alert("问题的标题不能小于5个字！");
		return false;
	}
        var message = UM.getEditor('message').getContent();
        if(message == "") {
		alert("问题内容不能为空");
		return false;
	}
	return true;
}
function addquestion() {
    $.ajax({
                url:"<?= geturl('myroom/myask/addquestion') ?>",
                type: "POST",
                data:$("#askform").serialize(),
                dataType:"json",
                success: function(data){
                    if(data != null && data != undefined && data.status == 1) {
                         $.showmessage({
                            img : 'success',
                            message:'问题提交成功',
                            title:'提交问题',
                            callback :function(){
                                 document.location.href = "<?= geturl('myroom/myask/all') ?>";
                            }
                        });
                    } else {
                        var message = '提交问题失败，请稍后再试或联系管理员。';
                        if(data != undefined && data.message != undefined)
                            message = data.message;
                        $.showmessage({
                            img : 'error',
                            message:message,
                            title:'提交问题'
                        });
                    }
                }
            });
}
function showcw(title){
	height = 540;
	width = 650;
	var folderid = $('#folderid').val();
	url = '/myroom/myask/box_cw/'+folderid+'.html';
	var html = '<iframe scrolling="" marginheight="0" marginwidth="0" frameborder="0" width="'+width+'" height="'+height+'" src="'+url+'"></iframe>';
	H.create(new P({
		id : 'artdialogcw',
		title : title,
		width : width,
		height : height,
		content : html,
		easy:true,
		padding:5
	},{'onclose':function(){H.get('artdialogcw').exec('destroy');}}),'common').exec('show');
}
function selectcw(cwid,title){
	H.get('artdialogcw').exec('close');
	innerTextConvert($('#show_cwname')[0],shortstr(title));
	// $('#show_cwname')[0].innerText = shortstr(title);
	$('#cwid').val(cwid);
	var foldername = getInnerText($('#show_foldername')[0]);
	// var cwname = '《'+foldername+'》'+title;
	var cwname = title;
	$('#cwname').val(cwname);
}
function shortstr(str){
	var result = str.substr(0,22);
	if(result.length<str.length)
		result+= '...';
	return result;
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
function getInnerText(ele){
	if(window.navigator.userAgent.toLowerCase().indexOf("firefox")!=-1)
	{
		return ele.textContent;
	}
	else
	{
		return ele.innerText;
	}
}

//删除图片
function removeimg(obj){
	$(obj).parent().remove();
	$('.noimg').show();
}
</script>
<?php $this->display('myroom/page_footer'); ?>