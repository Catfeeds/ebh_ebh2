<?php $this->display('troom/page_header'); ?>
<style>
	.titket{
		border: 0;
	}
</style>
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/dayi.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" />	
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/upload.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<div style="height:1120px;width:788px;float:left;">
<div class="ter_tit">
当前位置 > 提交问题
</div>
<div class="lefrig">
<div class="workol" style="margin-top:15px;">
<div class="tit_search"  style="margin-top:0px;">
<form id="askform">
<div class="biaowaim">
  <input class="titwenti" name="title" id="title" type="text" value="" maxlength="50"/>
  <div class="txtxdaru">
  <?php $editor->xEditor('message','748px','500px'); ?>
  </div>
 <div class="fontfen" style="width:700px;margin-left:15px;margin-bottom:10px;margin-top:10px;height:50px;">
  <span class="wenzid" style="width:70px;font-weight:bold;color:#777;">课程分类：</span>
	<div class="eeret">
		<a class="ekiyt" href="javascript:void(0)">当前选择课程：<span class="show_foldername"><?=!empty($folder['foldername'])?$folder['foldername']:'无'?></span></a>
		<input type="hidden" name="folderid"   value="<?=!empty($folder['folderid'])?$folder['folderid']:''?>" />
	</div>
  </div>
  <div style="float:left;margin-left:19px;width:70px;_margin-top:20px;margin-top:5px;font-weight:bold;color:#777;">相关图片：</div>
  	<div style="float:left;width:630px;_margin-top:20px;">
        <?php $upcontrol->upcontrol('image',1,false,'askimage'); ?>
  	</div>

<div style="background:#fff;float:left">
 <div style="float:left;margin-left:19px;width:70px;margin-top:14px;font-weight:bold;color:#777;">我的语音：</div>
 <div style="float:left;margin-left:0px;width:600px;margin-top:10px; " id="audio_float">
 	<a href="javascript:void(0)" id="startrecord" style="width:63px;height:27px;line-height:27px;background:#E3F2FF;border:solid 1px #A2D1F1;display:block;text-align:center;text-decoration: none;font-size:14px;" >录制</a>
 </div>

 <div style="float:left;width:100%;height:200px;display:none" id="showrecorder">
	<object width="500" height="200" class="recoderSwf" data="http://static.ebanhui.com/ebh/flash/recoderSwf.swf" type="application/x-shockwave-flash" >
	<param value="transparent" name="wmode">
	<param value="http://static.ebanhui.com/ebh/flash/recoderSwf.swf" name="movie" id="recoder_url">
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
 	
 	
   <div class="fontfen" id="doheight" >
	<input class="tijibtn" style="margin-left:320px;width:190px;margin-right:20px;float:left;" type="button" value="提交问题" />
  </div>
</div>
</form>
</div>
</div>


<div id="coursedialogdiv" style="display:none">
	<div class="titket" style="width:550px;background:white;height:250px;overflow-y:auto">
	<div class="leftke" style="width:500px;">我的课程：</div>
		<div class="riglei" style="width:520px;">
		<ul>
		<?php if($myfolders){foreach($myfolders as $myfolder){?>
		<li class="etkly" style="white-space:nowrap;"><a class="atfwt auttds" tid="<?=empty($myfolder['tid'])?0:$myfolder['tid']?>" fid=<?=$myfolder['folderid']?>><?=$myfolder['foldername']?></a>
		<?php }}?>
		</ul>
		</div>
	</div>
	<?php if($otherfolders){ ?>
		<div class="ewtlt" style="width:550px;border-bottom:none;height:250px;background:white;overflow-y:auto">
			<div class="leftke" style="width:500px;">其他课程：</div>
				<div class="riglei" style="width:520px;">
				<ul>
				<?php foreach($otherfolders as $key=>$otherfolder){ ?>
				<li class="etkly" style="cursor:pointer;white-space:nowrap;"><a class="atfwt auttds" fid=<?=$key?>><?=$otherfolder['foldername']?></a></li>
				<?php }?>
				</ul>
				</div>
		</div>
	<?php } ?>
</div>
</div>


<script type="text/javascript">
$(function(){
	//去掉鼠标经过样式
	$('.datatab tr').mouseover(function(){
				$(this).removeClass('over3');
		});
	html = $('#coursedialogdiv')[0];
	$(".eeret").click(function(){
		if(!H.get('artdialogcourse')){
			H.create(new P({
				id : 'artdialogcourse',
			    title: '选择课程',
			    width:550,
			    padding:2,
			    easy:true,
			    content:html
			}),'common');
		}
		var folderid = $("input[name=folderid]").val();
		if(folderid){
			$(".atfwt").each(function(){
				$(this).css('background','');
				var fid = $(this).attr('fid');
				if(fid==folderid){
					$(this).css('background','#b1d6e9');
					}
			});
		}
		H.get('artdialogcourse').exec('show');
	});
	$(".atfwt").click(function(){
		var foldername = $(this).html();
		var folderid = $(this).attr('fid');
		$(".show_foldername").html(foldername);
		$("input[name=folderid]").attr("value",folderid);
		H.get('artdialogcourse').exec('close');
	});
    $("#startrecord").click(function(){
    	  $('#showrecorder').toggle();
    	  $(".recoderSwf").remove();
    	  $("#showrecorder").html('<object width="500" height="200" class="recoderSwf" data="http://static.ebanhui.com/ebh/flash/recoderSwf.swf" type="application/x-shockwave-flash" ><param value="transparent" name="wmode"><param value="http://static.ebanhui.com/ebh/flash/recoderSwf.swf" name="movie" id="recoder_url"><param value="high" name="quality"><param value="false" name="menu"><param value="always" name="allowScriptAccess"></object>');
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
                submitquestion();
            }
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
        var message = UM.getEditor('message').getContent();
        if(message == "") {
		alert("问题内容不能为空");
		return false;
	}
	return true;
}
function submitquestion() {
    $.ajax({
                url:"<?= geturl('troom/myask/addquestion') ?>",
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
                                 document.location.href = "<?= geturl('troom/myask') ?>";
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
</script>

<?php 
$this->display('troom/page_footer'); 
?>