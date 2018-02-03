<?php $this->display('troomv2/room_header'); ?>
<?php $this->widget('sendmessage_widget', array(), array('room_type' => 'troomv2','window_type' => 'self')); ?>
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/dayi.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" />	
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/upload.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<link type="text/css" href="http://static.ebanhui.com/js/soundManager2/css/voicePlayer.css<?=getv()?>" rel="stylesheet" />
<style>
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
body{background:#f3f3f3;}
</style>
<div style="height:1500px;width:1000px;margin:0 auto;">

<form id="askform">
	<input type="hidden" name="qid" value="<?= $qid ?>" />
<div class="biaowaim">
  <input class="titwenti" style="_margin-left:2px;" name="title" id="title" type="text" value="<?= $ask['title'] ?>" maxlength="50"/>
  <div class="txtxdaru">
		
    <?php $editor->xEditor('message','970px','500px',$ask['message']); ?>

  </div>
  <div class="fontfen" style="width:920px;margin-left:15px;margin-bottom:10px;margin-top:10px;height:50px;">
  <span class="wenzid" style="width:70px;font-weight:bold;color:#777;">课程分类：</span>
	<div class="eeret">
		<a class="ekiyt" href="javascript:void(0)">当前选择课程：<span class="show_foldername"><?=empty($folder)?"无":$folder['foldername']?></span></a>
		<input type="hidden" name="folderid"   value="<?=$folder['folderid']?>" />
	</div>
  </div>
 
  <div style="float:left;margin-left:19px;width:70px;_margin-top:20px;margin-top:5px;font-weight:bold;color:#777;">上传图片：</div>
  <div style="width:850px;_margin-top:20px; float:left;">
		<ul class="sckcfm" id="logo-box">
		<?php 
		$imgsrc = array();
		if(!empty($ask['imagesrc'])){ ?>
			<?php 
				$imgsrc = explode(',',$ask['imagesrc']);
				$imgname = explode(',',$ask['imagename']);
			?>
			<?php foreach ($imgsrc as $key => $img) { ?>
			<li class="fl hasimg" style="position:relative;"><img r="0" src="<?php echo getthumb($img,'277_195');?>" style="cursor:pointer;width:180px;height:110px;" ><a onclick="removeimg(this);" href="javascript:void(0);" class="remove-img languan" style="display:block;"></a><input type="hidden" name="images[]" value="<?php echo $img;?>"></li>
		<?php } ?>
		<?php } ?>
		
		<li class="fl noimg" style="position:relative;<?php if(count($imgsrc) == 9){echo 'display: none;';}?>">
		<a href="javascript:;" class="glitus" id="Button1"></a><img r="0" src="http://static.ebanhui.com/ebh/tpl/selcur/images/kcfmadd.jpg" id="uploadimg"  style="cursor:pointer;width:180px;height:110px;" id="uploadimg" ></li>
		</ul>
  	</div>

<div id="audio"></div>
 	
	<div class="fontfen" id="doheight" >
	  	<input class="tijibtn" type="button" value="提交问题" style="width:190px;margin-right:170px;float:right;"/>
	</div>
</div>
</form>

<div id="coursedialogdiv" style="display:none">
	<div class="titket" style="width:560px;background:white;height:250px;overflow-y:auto">
		<div class="leftke" style="width:500px;">我的课程：</div>
		<div class="riglei" style="width:560px;height:200px;overflow-y:auto;">
		<ul>
		<?php if($myfolders){foreach($myfolders as $myfolder){?>
		<li class="etkly" style="white-space:nowrap;"><a class="atfwt auttds" fid=<?=$myfolder['folderid']?>><?=$myfolder['foldername']?></a>
		<?php }}?>
		</ul>
		</div>
	</div>
	<?php if($otherfolders){ ?>
		<div class="ewtlt" style="width:560px;background:white;border-bottom:none;">
			<div class="leftke" style="width:500px;">其他课程：</div>
				<div class="riglei" style="width:560px;height:220px;overflow-y:auto;">
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
<script src="http://static.ebanhui.com/js/soundManager2/js/voicePlayer.js<?=getv()?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/recorder.js<?=getv()?>"></script>
<script type="text/javascript">
<?php if(!empty($ask['audiosrc']) && !empty($ask['audioname'])){ ?>
loadaudio('audio',<?='\''.json_encode($ask['audio']).'\''?>);
<?php }else{ ?>
loadaudio('audio');	
<?php } ?>
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
/*		if(!H.get('artdialogcourse')){
			H.create(new P({
				id : 'artdialogcourse',
			    title: '选择课程',
			    padding:2,
			    width:560,
			    easy:true,
			    content:html
			}),'common');
		}*/
		dialog({
			id:"artdialogcourse",
			title:"选择课程",
			skin:"ui-dialog2-left",
			content:html,
			width:560,
			padding:10
		}).showModal();
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
	});
	$(".atfwt").click(function(){
		var foldername = $(this).html();
		var folderid = $(this).attr('fid');
		$(".show_foldername").html(foldername);
		$("input[name=folderid]").attr("value",folderid);
		dialog.get('artdialogcourse').close().remove();
	});
})

var titletips = "请在这里输入问题标题";
$(function(){
	settips("title",titletips);
        $(".tijibtn").click(function(){
        	if(checkquestion())
           editquestion(); 
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
			var d = dialog({
				title: '提示信息',
				content: '问题的标题不能为空！',
				okValue: '确定',
				cancel: false,
				ok: function () {}
			});
			d.showModal();
		return false;
	}
	if($.trim($("#title").val()).length < 5 || $.trim($("#title").val()) == titletips) {
			var d = dialog({
				title: '提示信息',
				content: '问题的标题不能少于5个字！',
				okValue: '确定',
				cancel: false,
				ok: function () {}
			});
			d.showModal();
		return false;
	}
        var message = UE.getEditor("message").getContent();
	if($.trim(message) == "") {
			var d = dialog({
				title: '提示信息',
				content: '问题内容不能为空！',
				okValue: '确定',
				cancel: false,
				ok: function () {}
			});
			d.showModal();
		return false;
	}
	return true;
}
function editquestion() {
    $.ajax({
                url:"<?= geturl('troomv2/myask/editquestion/'.$qid) ?>",
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
									document.location.href = "<?= geturl('troomv2/myask/'.$qid) ?>";
									that.close().remove();
								}, 2000);
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
						return false;
                    }else{
                        var message = '提交问题失败，请稍后再试或联系管理员。';
                        if(data != undefined && data.message != undefined)
                            message = data.message;
						dialog({
							skin:"ui-dialog2-tip",
							content:"<div class='FPic'></div><p>"+message+"</p>",
							width:350,
							onshow:function () {
								var that=this;
								setTimeout(function () {
									document.location.href = "<?= geturl('troomv2/myask/'.$qid) ?>";
									that.close().remove();
								}, 2000);
							}
						}).show();
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
<?php $this->display('troomv2/page_footer'); ?>