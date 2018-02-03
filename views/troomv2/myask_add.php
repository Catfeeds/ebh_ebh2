<?php $this->display('troomv2/page_header'); ?>

<style>
	.titket{
		border: 0;
	}
.workdata{
	width:998px;
}
.ter_tit{
	width:1000px;
}
.biaowaim{
	width:1000px !important;
}
.biaowaim .titwenti{
	width:960px !important;
}
#ui-dialog2-body, .leftke{
	text-align:left;
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
    background:url(http://static.ebanhui.com/ebh/tpl/troomv2/images/hrsire.png) no-repeat;
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
</style>
<link type="text/css" href="http://static.ebanhui.com/js/soundManager2/css/voicePlayer.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/dayi.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" />	
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/upload.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<div style="height:1500px;width:1000px;float:left;">
<div class="lefrig">
<div class="workol" style="margin-top:15px;">
<div class="tit_search"  style="margin-top:0px;">
<form id="askform">
<div class="biaowaim">
  <input class="titwenti" name="title" id="title" type="text" value="" maxlength="50"/>
  <div class="txtxdaru">
  <?php $editor->xEditor('message','970px','500px'); ?>
  </div>
 <div class="fontfen" style="width:920px;margin-left:15px;margin-bottom:10px;margin-top:10px;height:50px;">
  <span class="wenzid" style="width:70px;font-weight:bold;color:#777;">课程分类：</span>
	<div class="eeret">
		<a class="ekiyt" href="javascript:void(0)">当前选择课程：<span class="show_foldername"><?=!empty($folder['foldername'])?$folder['foldername']:'无'?></span></a>
		<input type="hidden" name="folderid"   value="<?=!empty($folder['folderid'])?$folder['folderid']:''?>" />
	</div>
  </div>
  <div style="float:left;margin-left:19px;width:70px;_margin-top:20px;margin-top:5px;font-weight:bold;color:#777;">相关图片：</div>
  	<div style="width:850px;_margin-top:20px; float:left;">
		<ul class="sckcfm" id="logo-box">
			
			<li class="fl noimg" style="position:relative;">
			<a href="javascript:;" class="glitus" id="Button1"></a>
			<img r="0" src="http://static.ebanhui.com/ebh/tpl/selcur/images/kcfmadd.jpg" style="cursor:pointer;width:180px;height:110px;" id="uploadimg" ></li>
		</ul>
  	</div>
	<div id="audiodiv"></div>
   <div class="fontfen" id="doheight" >
	<input class="tijibtn" style="width:190px;margin-right:170px;float:right;" type="button" value="提交问题" />
  </div>
</div>
</form>
</div>
</div>


<div id="coursedialogdiv" style="display:none">
	<div class="titket" style="width:550px;background:white;overflow-y:auto;float:none;height:250px;">
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
		<div class="ewtlt" style="width:550px;border-bottom:none;background:white;overflow-y:auto;float:none;height:480px;">
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
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/recorder.js<?=getv()?>">
</script>
<script src="http://static.ebanhui.com/js/soundManager2/js/voicePlayer.js<?=getv()?>"></script>
<script type="text/javascript">
loadaudio('audiodiv');
var swf = null;
HTools.rFlash({
	id:'Button1',
	uri:'http://static.ebanhui.com/ebh/flash/MultiImageUploadaddqu.swf',
	vars:{'xmlurl':'http://static.ebanhui.com/ebh/flash/xml/webDataTeacher.xml'},
	width:178,
	height:108
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
			$(".hasimg").each(function(k,v){
				if(k >= 9){
					$(this).remove();
				}
			});
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
	//去掉鼠标经过样式
	$('.datatab tr').mouseover(function(){
				$(this).removeClass('over3');
		});
	html = $('#coursedialogdiv')[0];
	$(".eeret").click(function(){
		var d=dialog({
			id:"artdialogcourse",
			title:"选择课程",
			content:html
			});
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
		d.showModal();
	});
	$(document).on("click",".atfwt",function(){
		var foldername = $(this).html();
		var folderid = $(this).attr('fid');
		$(".show_foldername").html(foldername);
		$("input[name=folderid]").attr("value",folderid);
		dialog.get("artdialogcourse").close().remove();
	});
})
var titletips = "请在这里输入问题标题";
var flag = true;
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
			var d = top.dialog({
			title: '提示',
			content: '问题的标题不能为空！',
			cancel: false,
			okValue: '确定',
			ok: function () {        
			}
		});
		d.showModal();
		return false;
	}
	if($.trim($("#title").val()).length < 5 || $.trim($("#title").val()) == titletips) {
			var d = top.dialog({
			title: '提示',
			content: '问题的标题不能少于5个字！',
			cancel: false,
			okValue: '确定',
			ok: function () {        
			}
		});
		d.showModal();
		return false;
	}
        var message = UE.getEditor('message').getContent();
        if(message == "") {
			var d = top.dialog({
			title: '提示',
			content: '问题内容不能为空！',
			cancel: false,
			okValue: '确定',
			ok: function () {        
			}
		});
		d.showModal();
		return false;
	}
	return true;
}
var submit_enabled = true;
function submitquestion() {
	if (submit_enabled === false) {
		return false;
	}
	submit_enabled = false;
    $.ajax({
        url:"<?= geturl('troomv2/myask/addquestion') ?>",
        type: "POST",
        data:$("#askform").serialize(),
        dataType:"json",
        success: function(data){
            if(data != null && data != undefined && data.status == 1) {
				dialog({
					skin:"ui-dialog2-tip",
					content:"<div class='TPic'></div><p>问题提交成功！</p>",
					width:350,
					onshow:function () {
						var that=this;
						setTimeout(function () {
							document.location.href = "<?= geturl('troomv2/myask/allquestion') ?>";
							that.close().remove();
						}, 1000);
					}
				}).show();
            } else if(data != null && data != undefined && data.status == -1){
            	var str = '';
            	$.each(data.Sensitive,function(name,value){
            		str+=value+'&nbsp;';
            	});
            	var d = dialog({
					title: '提示',
					content: '问题包含敏感词汇'+str+'！请修改后重试...',
					cancel: false,
					okValue: '确定',
					ok: function () {        
					}
				});
				d.showModal();
				submit_enabled = true;
				return false;
            }else{
                var message = '提交问题失败，请稍后再试或联系管理员。';
                if(data !== undefined && data.message !== undefined){
                	message = data.message;
                }
                if(message==="请选择分类"){
	                top.dialog({
						skin:"ui-dialog2-tip",
						content:"<div class='PPic'></div><p>"+message+"</p>",
						width:350,
						onshow:function () {
							var that=this;
							setTimeout(function () {
								submit_enabled = true;
								that.close().remove();
							}, 1000);
						}
					}).show();
                }else{
	                top.dialog({
						skin:"ui-dialog2-tip",
						content:"<div class='PPic'></div><p>"+message+"</p>",
						width:350,
						onshow:function () {
							var that=this;
							setTimeout(function () {
								submit_enabled = true;
								that.close().remove();
							}, 1000);
						}
					}).show();
	            }
            }
        }
    });
}
//删除图片
function removeimg(obj){
	$(obj).parent().remove();
	$('.noimg').show();
}
</script>

<?php 
$this->display('troomv2/page_footer'); 
?>