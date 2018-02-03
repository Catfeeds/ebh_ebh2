<?php
$this->display('home/page_header');
?>
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/dayi.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" />	
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/upload.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<div class="topbaad">
<div class="user-main clearfix" >
	<div class="" style="height:980px;width:788px;float:left;">
		<div class="ter_tit">
	当前位置 > 我的答疑 > 修改问题
	</div>
	<div class="lefrig">
		<div class="user-cont" style="padding-left:0px;">
	<div class="crights" style="float:none;">
		<form id="askform">
			<div class="biaowaim" style="margin-top:20px;">
				<input class="titwenti" name="title" id="title" type="text" value="<?=$qdetail['title']?>" maxlength="50"/>
				<div class="txtxdaru">
					
					<?php $editor->simpleEditor('message','98%','217px',$qdetail['message']); ?>
					
				</div>
					<div class="fontfen" style=" margin-left: 15px;_margin-top:10px;">
					<span class="wenzid" style="width:60px;">分&nbsp;&nbsp;&nbsp;&nbsp;类：</span>
					<div class="lases" style="margin-left:10px;_margin-left:10px;">
						<a href="javascript:showcat();" class="lasxia">
						<span id="catname"><?=empty($qdetail['catpath'])?'请选择分类':$qdetail['catpath']?></span>
						<input type="hidden" id="catid" name="catid" value="<?=$qdetail['catid']?>"/>
						<input type="hidden" id="grade" name="grade" value="<?=$qdetail['grade']?>"/>
						<input type="hidden" id="catpath" name="catpath" value="<?=empty($qdetail['catpath'])?'':$qdetail['catpath']?>"/>
						</a>
					</div>
				
				</div>

				<div style="float:left;margin-left:15px;width:70px;_margin-top:20px;height: 30px;line-height: 30px;">上传图片：</div>
				<div style="float:left;width:630px;height:50px;_margin-top:20px;">
				
					<?php $upcontrol->upcontrol('image',1,array('upfilename'=>$qdetail['imagename'],'upfilepath'=>$qdetail['imagesrc']),'askimage'); ?>
					
				</div>
				<div style="background:#fff;float:left">
					 <div style="float:left;margin-left:15px;width:70px;margin-top:10px; ">上传音频：</div>
					 <div style="float:left;margin-left:0px;width:600px;margin-top:10px;display:<?=empty($qdetail['audiosrc'])?"inline":"none"?> " id="audio_float" >
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
					<div style="float:left;width:630px;height:50px;_margin-top:20px;display:<?=empty($qdetail['audiosrc'])?"none":"inline"?>" id="audio_show">
						<div class="upprogressbox" id="image_upprogressbox" style="display: block;">
						<div class="upfileinfo">
						<span class="upstatusinfo">
						<img src="http://static.ebanhui.com/ebh/images/upload.gif"></span>
						<span class="spanUpfilename" id="audio_name"><?=$qdetail['audioname']?></span>
						<span id="image_spanUppercent">100%</span>
						<span><a onclick="deleteaudio()" href="javascript:void(0);">&nbsp;删除</a></span>
						</div><div class="upprogressbar"><span class="upprogressstext">上传总进度：</span>
						<span class="spanUppercentBox" id="image_spanUppercentBox">
						<span class="spanUpShowPercent" id="image_spanUpShowPercent" style="width: 100%;"></span></span>
						<span class="spanUppercentinfo" id="image_spanUppercentinfo">100%</span></div></div>
					</div>
					<input type="hidden" value="<?=$qdetail['audiosrc']?>" name="audio" id="audio" />
				 </div> 
				<div class="fontfen" style="width:700px;_margin-top:20px;background:#fff;">
					
					<input class="tijibtn" type="button" value="提交问题" style="_margin-left:-595px;"/>
				</div>


				<div class="outlei" style="display:none">
					<h2 class="fenleitit">
						<span class="leibiaoti">选择分类：</span>
						<a href="javascript:;" onclick="detercat()" class="quedbtn">确认</a>
						<a href="javascript:;" onclick="closecat()" class="guanbtn"><img src="http://static.ebanhui.com/ebh/tpl/default/images/guanbibtn0514.png" /></a>
					</h2>
					<?php $i = 0;
					foreach($catlist as $cat){
					$huidi = ($i%2==1)?'huidi':'';
					$i++;
					?>
					<div class="leibie <?=$huidi?>">
						<div class="duojiaoyu"><?=$cat['name']?></div>
						<ul>
							<?php foreach($cat['subcat'] as $subcat){?>
							<li>
								<input class="xuankbt" id="xuankbt<?=$subcat['catid']?>" type="checkbox" name="checkbox" value="checkbox" onclick="choosecat(<?=$subcat['catid']?>,'<?=$subcat['keyword']?>',this)" /><?=$subcat['name']?>
							</li>
							<?php }?>
						</ul>
					</div>
					<?php }?>
					</div>
					<div class="fotjiao" style="display:none;top:434px"></div>
						<?php foreach($grade as $keyword=>$val1){?>
							<div class="fenjibie" id="grade<?=$keyword?>" style="display:none">
								<ul>
									<?php foreach($val1 as $k=>$val2){?>
										<li>
											<a class="nonelian" href="javascript:;" grade='<?=$k?>'><input class="xuankbt" type="checkbox" name="checkbox" value="checkbox" onclick="selectcat(this)" /><?=$val2?></a>
										</li>
									<?php }?>
								</ul>
							</div>
						<?php }?>
						<div class="lefjiao"  style="display:none"></div>
					</div>
				</div>
			</div>
		</form>
	</div>
	</div>
	</div>
<script type="text/javascript">
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
	var message = UM.getEditor('message').getContent();
	if($.trim(message) == "") {
		alert("问题内容不能为空");
		return false;
	}
	if($.trim($('#catid').val())==''){
		alert("请选择分类");
		return false;
	}
	return true;
}
var choosecat = function(catid,showid,dom){
	var curcatid = $("#catid").val();
	var curgrade = $("#grade").val();
	if(dom.checked==true||_checked==true){
		_catid = catid;
		var catname = $.trim($('#xuankbt'+_catid).parent('li').text());
		var catname1 = $.trim($('#xuankbt'+_catid).parents('.leibie').find('.duojiaoyu').text());
		_catpath = catname1+'/'+catname;

		
		var posi = getPosition(dom);
		var outHeight = $('.outlei').height();
		var outTop = getPosition($('.outlei')[0]).y;
		var toolHeight = $('#grade'+showid).height();
		if (outHeight<=toolHeight){
			$('#grade'+showid).css('top',outTop+'px');
		} else {
			if(posi.y-outTop>outHeight-toolHeight){
				$('#grade'+showid).css('top',(outTop+outHeight-toolHeight)+'px');
			}else{
				if(posi.y+toolHeight>outTop+outHeight){
					$('#grade'+showid).css('top',(outTop+outHeight-toolHeight)+'px');
				}else{
					$('#grade'+showid).css('top',posi.y+'px');
				}
			}
		}
		$('.fenjibie').hide();
		$('.xuankbt').removeAttr('checked');
		dom.checked = true;
		$('#grade'+showid).show().css('left',(posi.x+40)+'px').attr('catid',catid);
		_checked=false;
	}else{
		$('.xuankbt').removeAttr('checked');
		_catid = '';
		_catpath = '';
		_checked=false;
	}
	_grade = '';
}

var _catid = '<?=$qdetail['catid']?>';
var _grade = '<?=$qdetail['grade']?>';
var _catpath = '<?=$qdetail['catpath']?>';
var selectcat = function(dom){
	if(dom.checked==true||_checked2==true){
		$('.xuankbt').not(dom).removeAttr('checked');
		_catid = $(dom).parents('.fenjibie').attr('catid');
		_grade = $(dom).parents('.nonelian').attr('grade');
		var gradename = $.trim($(dom).parents('.nonelian').text());
		var catname = $.trim($('#xuankbt'+_catid).parent('li').text());
		var catname1 = $.trim($('#xuankbt'+_catid).parents('.leibie').find('.duojiaoyu').text());
		_catpath = catname1+'/'+catname+'/'+gradename;
		$('#xuankbt'+_catid).prop('checked','checked');
		_checked2=false;
	}
	else{
		var catname = $.trim($('#xuankbt'+_catid).parent('li').text());
		var catname1 = $.trim($('#xuankbt'+_catid).parents('.leibie').find('.duojiaoyu').text());
		_grade = '';
		_catpath = catname1+'/'+catname;
		_checked2=false;
	}
}
var detercat = function(){
	$('#catname').html(_catpath);
	$('#catid').val(_catid);
	$('#grade').val(_grade);
	$('#catpath').val(_catpath?_catpath:'/');
	closecat();
}
var closecat = function(){
	$('.outlei').hide();
	$('.fenjibie').hide();
	$('.fotjiao').hide();
}
function showcat() {
	var curcatid = $("#catid").val();
	var curgrade = $("#grade").val();
	$(".outlei").css("display","inline");
	$(".fotjiao").css("display","inline");
	if(curcatid != "") {
		$('.xuankbt').not($('#xuankbt'+curcatid)[0]).removeAttr('checked');
		$('#xuankbt'+curcatid).prop('checked','checked');
		if(curgrade!=''){
			_checked = true;
			$('#xuankbt'+curcatid).click();
			_checked2=true;
			$(".nonelian[grade='"+curgrade+"']").find('.xuankbt').click();
			// $(".nonelian[grade='"+curgrade+"']").find('.xuankbt').prop('checked','checked');
		}
	}
}

function addquestion() {
    $.ajax({
                //url:"<?= geturl('home/largedb/edit') ?>",
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
								document.location.href = "<?= geturl('home/largedb/aqindex') ?>";
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

</div>
<?php
$this->display('home/page_footer');
?>