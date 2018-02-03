<?php $this->display('myroom/page_header'); ?>
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/dayi.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" />	
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/upload.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js?v=20150731"></script>
<style>
	body{background: #fff;}
	.biaowaim{border:0;}
	.biaowaim .titwenti,.workol{margin-top:0;}
</style>
<div style="background:#fff;float:left;">

<div class="lefrig">
<div class="workol">

	<div class="tit_search" >
<form id="askform">
<div class="biaowaim">
  <input class="titwenti" name="title" id="title" type="text" value="" maxlength="50"/>
  <div class="txtxdaru" style="float:left;width:760px;display: inline;">

  <?php $editor->xEditor('message','748px','300px'); ?>

  </div>
  
 <div class="fontfen" style="width:700px;margin-left:15px;margin-bottom:10px;margin-top:10px;height:50px;">
  <span class="wenzid" style="width:70px;">课程分类：</span>
	<div class="eeret" id="eeret1">
		<a class="ekiyt" href="javascript:void(0)">当前选择课程：<span class="show_foldername">无</span></a>
		<input type="hidden" name="folderid"   value="" />
	</div>
  </div>
<?php if($showTeacherSelect == true){?>
 <div class="fontfen" style="margin-left:15px;">
  <span class="wenzid" style="width:70px;">教师选择：</span>
	<div class="eeret" id="eeret2" style="background:url(http://static.ebanhui.com/ebh/images/xuanter.jpg) no-repeat;width:140px;">
		<a class="ekiyt" href="javascript:void(0)"><span class="show_terchername">无</span></a>
		<input type="hidden" name="tid" value="" />
	</div>
	<span style="float:left;height:30px;line-height:30px;margin-top:10px;color:#999;">点击选择其他老师</span>
 </div>
<?php }?>
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
			if($group['sex']==1){
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
						<a class="auttdss" tid="<?=$group['uid']?>" tname="<?=$tname?>"><img src="<?=$face?>"></a><a class="atfwt auttdss" tid="<?=$group['uid']?>" tname="<?=$tname?>"><?=$tname?></a>
					</li>
		<?php }
		}?>
				</ul>
			</div>
		</div>
	<?php }?>
</div>
  <div style="float:left;margin-left:15px;width:70px;_margin-top:20px;">上传图片：</div>
  <div style="float:left;width:630px;height:50px;_margin-top:20px;">

        <?php $upcontrol->upcontrol('image',1,false,'askimage'); ?>
  </div>
	<div style="background:#fff;float:left">
	 <div style="float:left;margin-left:15px;width:70px;margin-top:10px; ">上传音频：</div>
	 <div style="float:left;margin-left:0px;width:600px;margin-top:10px; " id="audio_float">
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
   <div class="fontfen" id="doheight">
	<input class="tijibtn" style="margin-left:10px;margin-right:20px;float:left;" type="button" value="提交问题" />
  </div>
 
</div>
</form>
</div>
</div>
<div id="coursedialogdiv" style="display:none">
	<div class="titket" style="background:white;">
	<div class="leftke" style="width:595px;">我的课程：</div>
		<div class="riglei" style="width:600px;">
		<ul>
		<?php if($myfolders){foreach($myfolders as $myfolder){ ?>
		<li class="etkly"><a class="atfwt auttds" tname="<?= $myfolder['tid_realname']?>" tid="<?=empty($myfolder['tid'])?0:$myfolder['tid']?>" fid=<?=$myfolder['folderid']?>><?=$myfolder['foldername']?></a>
		<?php }}?>
		</ul>
		</div>
	</div>
	<?php if($otherfolders){ ?>
	<div class="ewtlt" style="width:605px;border-bottom:none;background:white;">
		<div class="leftke" style="width:80px;">其他课程：</div>
			<div class="riglei" style="width:605px;">
			<ul>
			<?php if(in_array($roominfo['crid'], $_SMS['crids'])){ ?>
				<?php foreach($otherfolders as $key=>$otherfolder){ ?>
						<li class="etkly" style="cursor:pointer"><a class="atfwt auttds"  tname="<?= $otherfolder['realname']?>" tid="<?=$otherfolder['tid']?>" fid=<?=$key?>><?=$otherfolder['foldername']?></a></li>
				<?php }?>
			<?php }else{ ?>
				<?php foreach($otherfolders as $key=>$otherfolder){ ?>
					<li class="etkly" style="cursor:pointer"><a class="atfwt auttds" fid=<?=$key?>><?=$otherfolder['foldername']?></a></li>
				<?php }?>
			<?php } ?>
			</ul>
			</div>
	</div>
	<?php } ?>
</div>
</div>

<script type="text/javascript">
$(function(){
	html = $('#coursedialogdiv')[0];
	$("#eeret1").click(function(){
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
		H.create(new P({
			id : 'artdialogcourse',
		    title: '选择课程',
		    content: html,
		    easy:true,
		    width:610,
		    padding:5
		}),'common').exec('show');
	});
    $("li.rtytle .atfwt,li.etkly .atfwt").click(function(){
		var foldername = $(this).html();
		var folderid = $(this).attr('fid');
		var tid = $(this).attr('tid');
		$(".show_foldername").html(foldername);
		$("input[name=folderid]").attr("value",folderid);
		if(true){
			if(!$(this).attr('tname')){
				var tname = $("li.rtytle .atfwt[tid="+tid+"]").attr('tname');
				var tid = $("li.rtytle .atfwt[tid="+tid+"]").attr('tid');
			}else{
				var tname = $(this).attr('tname');
				var tid = $(this).attr('tid');
			}
			$(".show_terchername").html(tname);
			$("input[name=tid]").attr("value",tid);
		}
		H.get('artdialogcourse').exec('close');
	});
})

$(function(){
	thtml = $('#teacherdiv')[0];
	$("#eeret2").click(function(){

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
		H.create(new P({
			id : 'artdialogteacher',
		    title: '指定老师',
		    content: thtml,
		    easy:true,
		    padding:5
		}),'common').exec('show');
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
                    	 parent.window.closeDialog();
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
</script>
<?php $this->display('myroom/page_footer'); ?>