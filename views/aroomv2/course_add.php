<?php
$this->assign('jquery11',true);
$this->display('aroomv2/page_header')?>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xform.js?v=1"></script>

<style type="text/css">
.cqshangc {
	padding-bottom:10px;
	width: 788px;
	float:left;
	*margin-bottom:3px;
}
.cqshangc .sckezi {
	font-size: 14px;
	font-weight: bold;
	color: #6683c7;
	height: 35px;
	border-bottom: 1px solid #cdcdcd;
	padding-left: 20px;
	line-height: 35px;
}
.cqshangc .cqleftsc {
	float: left;
	width: 500px;
	font-size: 14px;
	margin-top: 15px;
}
.inpxuanx {
	height: 32px;
	border:none;
	text-indent:8px;
	overflow: hidden;
	font-size: 14px;
	line-height: 32px;
	display: block;
	color: #666666;
}
.cqshangc .cqrightsc {
    float: left;
    font-size: 14px;
    left: 500px;
    margin-top: 15px;
    position: absolute;
    width: 250px;
	top:90px;
}
.pxxuanx {
	height: 32px;
	display: block;
	float: left;
	line-height: 32px;
	padding-left: 20px;
}
.sds {
	height: 184px;
	width: 145px;
	border: 1px solid #cdcdcd;
	background:url(http://static.ebanhui.com/ebh/tpl/2012/images/dise.jpg) no-repeat center;
	margin-bottom: 8px;
	margin-left:50px;
}
.cqshangc .cqrightsc .cqbc {
	background: url(http://static.ebanhui.com/ebh/tpl/2012/images/xgtxbtn.png) no-repeat;
	height: 33px;
	line-height:33px;
	width: 120px;
	border:none;
	font-size: 14px;
	cursor:pointer;
	float: left;
	margin-left:70px;
	_margin-left:35px;
	display: block;
	color:#fff;
}
.cqshangc .cqrightsc .cqxg {
	background:url(http://static.ebanhui.com/ebh/tpl/2012/images/xiugai_inp01.png) no-repeat;
	height:35px;
	cursor:pointer;
	width: 70px;
	float: left;
	margin-left: 60px;
	margin-right: 10px;
	border:none;
}


.sds img {
	margin-top: 6px;
	margin-left: 8px;
}


.terlie li {
    background: none repeat scroll 0 0 #FFFFFF;
    border: 1px solid #B2D9F0;
    display: block;
    float: left;
    font-size: 14px;
    height: 20px;
    line-height: 20px;
    margin-bottom: 7px;
    margin-right: 5px;
    padding-top: 3px;
}
.terlie li a.labelnode {
    color: #0078B6;
    display: inline;
    float: left;
    height: 18px;
    line-height: 18px;
    padding: 0 7px;
    text-decoration: none;
    vertical-align: 4px;
}

.terlie li a.labeldel {
    float: left;
}
.terlie .mylabel a.labeldel img {
    background: url("http://static.ebanhui.com/ebh/tpl/2012/images/closebg_01.png") no-repeat scroll 0 0 transparent;
    display: inline-block;
    height: 12px;
    margin: 3px 4px 2px 0;
    width: 12px;
}
.terlie .mylabelhover a.labeldel img {
    background: url("http://static.ebanhui.com/ebh/tpl/2012/images/closebg_02.png") no-repeat scroll 0 0 transparent;
    display: inline-block;
    height: 12px;
    margin: 3px 4px 2px 0;
    width: 12px;
}
.coursecredit ,.examcredit ,.credittime {
	background: url("http://static.ebanhui.com/ebh/tpl/2012/images/inp_bg02.png") no-repeat scroll 0 0 transparent;
	width:112px;
	height:32px;
	line-height:32px;
	border:none;
	padding-left: 10px;
}
.remindmsg {
	background: url("http://static.ebanhui.com/ebh/tpl/2012/images/inp_bg01.png") no-repeat scroll 0 0 transparent;
	width:323px;
	height:32px;
	line-height:32px;
	border:none;
	padding-left: 10px;
}
.remindtime {
	background: url("http://static.ebanhui.com/ebh/tpl/2012/images/inp_bg03.jpg") no-repeat scroll 0 0 transparent;
	width:32px;
	height:32px;
	line-height:32px;
	border:none;
	padding-left: 10px;
}
</style>
	<div class="ter_tit">
        当前位置 &gt; <a href="<?=geturl('aroomv2/course')?>">课程管理</a> &gt; <a href="<?=geturl('aroomv2/course/courses')?>">本校课程</a> &gt; 开设课程
		</div>
	<div class="lefrig" style="padding-bottom:0;border-bottom:none;background:#fff;float:left;margin-top:15px;width:788px;">
	
<script type="text/javascript">
<!--
<?php if ($roominfo['template'] == 'plate') { ?>
var changeimg = function(url, showurl){
	$("#folderimg").attr('src',showurl);
	$("#img").val(showurl);
	$("#cqbc").click();
}

<?php } else { ?>
var changeimg = function(url){
	$("#folderimg").attr('src',url);
	$("#img").val(url);
	$("#cqbc").click();
}
<?php } ?>
	$(function(){
		$(".btnlogo").click(function(){
			if(checkfoldername() && checksummary() && checkcollege()){
				$("#foldervalue").submit();
				return false;
			}
		});
	});
	var checkfoldername = function(){
		if($("#foldername").val().replace(/\s/g,"")=="" || $("#foldername").val()=='如：高一语文上册'){
			$("#foldernamespan").css("color","red").html("请输入课程名称");
			return false;
		}
	//	$("#foldernamespan").css("color","#999").html("请输入课程名称如：高一语文上册");
		return true;
	}
	/*
	var checkdisplayorder = function(){
		if($("#displayorder").val().replace(/\s/g,"")==null){
			$("#displayorderspan").css("color","red").html("请输入课程排序号");
			return false;
		}
		if($("#displayorder").val().match(/^(-|\+)?\d+$/)==null){
			$("#displayorderspan").css("color","red").html("课程排序号不能为空，且必须为整数！");
			return false;
		}
		$("#displayorderspan").css("color","#999").html("序列号越小越靠前");
		return true;
	}*/
	var checkfprice = function(){
		if($("#fprice").val().replace(/\s/g,"")==null){
			$("#fpricespan").css("color","red").html("请输入课程价格");
			return false;
		}
		if(isNaN(parseFloat($("#fprice").val()))) {
			$("#fpricespan").css("color","red").html("课程价格不能为空，且为大于等于零的数！");
			return false;
		}
		var fprice = parseFloat($("#fprice").val());
		$("#fprice").val(fprice);
		$("#fpricespan").css("color","#999").html("课程价格，0表示免费开放");
		return true;
	}
	var checksummary =function(){
		if ($("#summary").val().length>200) {
			$("#summary_msg").css("color","red").html("课程详细介绍应在200字以内！");
			return false;
		}
		else if($("#summary").val()=='课程详细介绍(200字以内)'){
			$("#summary").val("");
		};
		//$("#summary_msg").css("color","#999").html("课程详细介绍(200字以内)");
		return true;
	}
//-->
</script>
<?php $picstyle = 'display:none;'?>

<form id="foldervalue" action="" method="post">

<div class="cqshangc">
	<h2 class="sckezi">开设课程</h2>
	<div id="hitdiv">
	<div class="cqleftsc">
		<span class="pxxuanx">课程名称：</span>

		  <input name="foldername" id="foldername" type="text" onblur="checkfoldername()" class="inpxuanx" style="width: 333px;background: url(http://static.ebanhui.com/ebh/tpl/2012/images/inp_bg01.png) no-repeat;" value="" maxlength="20" x_hit="如：高一语文上册"/>
		
		  <p id="foldernamespan" style="margin:5px 0px 10px 80px; color:#999;"></p>
		<!--
		  <span class="pxxuanx">课程排序：</span>
		  <input type="text" class="inpxuanx" onblur="checkdisplayorder()" style="width: 122px;background: url(http://static.ebanhui.com/ebh/tpl/2012/images/inp_bg02.png) no-repeat;" maxlength="10" id="displayorder" name="displayorder" value="10" />
			  <p id="displayorderspan" style="margin:5px 0px 10px 80px; color:#999;">序列号越小越靠前</p>
	-->
	
		<span class="pxxuanx">课程介绍：</span>
		  <textarea name="summary" style="min-height: 100px;height:100px;float:left;" onblur="checksummary()" id="summary" class="w388 txt" value="" x_hit="课程详细介绍(200字以内)"></textarea>
		  
			  <p id="summary_msg" style="margin:5px 0px 10px 80px; color:#999;"></p>
	<?php if(false && $roominfo['isschool'] ==7) { ?>
	<span class="pxxuanx">是否免费：</span>
	<div style="float:left;margin-top:6px">
		<input type="checkbox" name="isfree" checked="checked" id="fon" style="margin-top:1px"/><label for="fon" style="margin-left:8px">免费开放则勾选此选项</label>
	  </div>  
	<?php } ?>
	
	<div style="clear:both;"></div>
	<span class="pxxuanx" style="">课件显示方式：</span>
	<div style="float:left;margin-top:6px">
		<label><input style="margin-top:5px;float:left;width:26px;" type="radio" value="0" name="showmode" checked="checked" /><span style="float:left;">默认</span></label>
		<label><input style="margin-top:5px;float:left;width:26px;margin-left:10px;" type="radio" value="1" name="showmode" /><span style="float:left;">网格模式</span></label>
		<label><input style="margin-top:5px;float:left;width:26px;margin-left:10px;" type="radio" value="2" name="showmode" /><span style="float:left;">列表模式</span></label>
		<label><input style="margin-top:5px;float:left;width:26px;margin-left:10px;" type="radio" value="3" name="showmode" /><span style="float:left;">详情模式</span></label>
	</div>


	<?php
		if(!empty($roominfo['grade'])){
	?>
	
	<div style="float:left;width:490px;display: inline;">
	<span style="font-size:14px;display: inline;height: 28px;line-height: 28px;vertical-align: middle;float: left;padding-left: 34px;">年　级：</span>
	
	<label><input style="margin-top:5px;float:left;width:26px;" type="radio" value="0" name="grade" checked=""/><span style="float:left;margin-right:10px;">不选</span></label>
	<?php
		if($roominfo['grade']==1){
			$gradearr = array('一年级','二年级','三年级','四年级','五年级','六年级');
			for($i=1;$i<7;$i++){
				echo '<label><div style="width:84px; float:left;display:inline;"><input style="margin-top:5px;float:left;width:26px;" type="radio" value="'.$i.'" name="grade"/><span style="float:left;margin-right:10px;display:inline;">'.$gradearr[$i-1].'</span></div></label>';
			}
		}elseif($roominfo['grade']==7){
			$gradearr = array('初一','初二','初三');
			for($i=7;$i<10;$i++){
				echo '<label><div style="width:84px; float:left;display:inline;"><input style="margin-top:5px;float:left;width:26px;" type="radio" value="'.$i.'" name="grade"/><span style="float:left;margin-right:10px;">'.$gradearr[$i-7].'</span></div></label>';
			}
		}elseif($roominfo['grade']==10){
			$gradearr = array('高一','高二','高三');
			for($i=10;$i<13;$i++){
				echo '<label><div style="width:84px; float:left;display:inline;"><input style="margin-top:5px;float:left;width:26px;" type="radio" value="'.$i.'" name="grade"/><span style="float:left;margin-right:10px;">'.$gradearr[$i-10].'</span></div></label>';
			}
		}
		
	?>
	</div>
<?php }?>

	<div style="width:500px;float:left">
		<span class="pxxuanx">课程权限：</span>
		<label><input style="margin-top:10px;float:left;width:26px;" type="radio" value="0" name="power" checked=""/><span style="float:left;margin-top:5px">老师学生都有权限</span></label>
		<label><input style="margin-top:10px;float:left;width:26px;" type="radio" value="1" name="power" /><span style="float:left;margin-top:5px">只有老师有权限</span></label>
		<label><input style="margin-top:10px;float:left;width:26px;" type="radio" value="2" name="power" /><span style="float:left;margin-top:5px">没有权限</span></label>
	</div>
	
	<?php if($roominfo['isschool']==7){?>
	<div style="width:500px;float:left">
		<span class="pxxuanx">允许本校学生：</span>
		<label><input style="margin-top:10px;float:left;width:26px;" type="checkbox" value="1" name="isschoolfree"/><span style="float:left;margin-top:5px"> </span></label>
		
	</div>
	<div style="width:500px;float:left">
	<span class="pxxuanx">主讲老师：</span>
	<div  class="inpxuanx" style="width:323px;padding-left:10px;background: url(http://static.ebanhui.com/ebh/tpl/2012/images/inp_bg01.png) no-repeat;">
	<input name="speaker" type="text" class="inpxuanx" style="width:310px;" value="" x_hit="主讲老师"/>
</div>
	
	</div>
	</div>
	<div style="float:left;width:700px;margin-top:20px">
		<div style="float:left;margin-left:20px;font-size:14px">详细介绍：</div>
	
	<div style="margin:30px 20px "><?php $editor->xEditor('detail','740px','450px');?></div>
	<?php }?>
		</div>

	<?php if($roominfo['iscollege']) { ?>
	<div style="float:left;width:786px;margin-top:20px;font-size: 14px;">
		<h2 class="sckezi">学分设置</h2>
		<div style="width:500px;float:left;margin-top:10px;">
			<span class="pxxuanx">课程学分：</span>
			<div  class="inpxuanx" style="width:323px;padding-left:10px;background: url(http://static.ebanhui.com/ebh/tpl/2012/images/inp_bg01.png) no-repeat;">
				<input name="credit" type="text" id="credit" class="inpxuanx" style="width:310px;" value="10" x_hit="课程学分"/>
			</div>
		</div>
		<div style="width:500px;float:left">
			<span class="pxxuanx">获取方式：</span>
			<label><input style="margin-top:10px;float:left;width:26px;" type="radio" value="0" name="creditmode" class="creditmode" checked="checked"/><span style="float:left;margin-top:5px">按学习进度</span></label>
			<label><input style="margin-top:10px;float:left;width:26px;" type="radio" value="1" name="creditmode" class="creditmode" /><span style="float:left;margin-top:5px">按累计学习时长</span></label>
		</div>

	
	<!--
		<div style="float:left;margin-left:20px;font-size:14px">详细介绍：</div>
	
	<div style="margin:30px 20px "><?php $editor->xEditor('detail','740px','450px');?></div>
	!-->
		  <p id="creditspan" style="margin:5px 0px 10px 80px; color:#999;"></p>
	<div style="width:500px;float:left;margin-top:10px;" class="creditrule">
		<span class="pxxuanx">学分规则：</span>
		<label style="width:400px;float:left;"><span style="float:left;margin-top:5px;">课件占比%：</span><input type="text" class="coursecredit" name="coursecredit" value="100"/></label>
		<label style="width:400px;float:left;padding-left:92px;margin-top:10px;"><span style="float:left;margin-top:5px">作业占比%：</span><input class="examcredit" type="text" name="examcredit" value="0"/></label>
	</div>
	<div style="width:500px;float:left;margin-top:10px;display:none;" class="dcredittime">
		<span class="pxxuanx">累计时长（分钟）：</span>
		<label style="width:340px;float:left;"><input type="text" id="credittime" class="credittime" name="credittime" /></label>
	</div>
<div style="width:786px;float:left;"><h2 class="sckezi">学习设置</h2></div>
	<div style="width:500px;float:left">
		<span class="pxxuanx">学习模式：</span>
		<label><input style="margin-top:10px;float:left;width:26px;" type="radio" value="0" name="playmode" checked="checked"/><span style="float:left;margin-top:5px">不限制</span></label>
		<label><input style="margin-top:10px;float:left;width:26px;" type="radio" value="1" name="playmode" /><span style="float:left;margin-top:5px">逐课学习</span></label>
	</div>
	<div style="width:700px;float:left;color:#999;padding-left:20px;">
		如果选择逐课学习，则学生只能按照顺序学习课程，即只有学了前面的课才能继续学习后续课程
	</div>
	<div style="width:500px;float:left;">
		<span class="pxxuanx">学习提醒：</span>
		<label><input style="margin-top:10px;float:left;width:26px;" type="radio" value="0" name="isremind" class="isremind" checked="checked"/><span style="float:left;margin-top:5px">不提醒</span></label>
		<label><input style="margin-top:10px;float:left;width:26px;" type="radio" value="1" name="isremind" class="isremind" /><span style="float:left;margin-top:5px">提醒</span></label>
	</div>
	<div class="remindinfo" style="display:none;">
		<div style="width:700px;float:left;">
			<span class="pxxuanx" style="width:700px;margin-bottom:10px;">提醒时间：第 <input name="remindtime[]" class="remindtime" type="text" value="" maxlength="3"  onblur="remindtimeblur(this)"/>分钟 提醒文字：<input name="remindmsg[]" type="text" class="remindmsg" value="" maxlength="100" />&nbsp;<a href="javascript:void(0);" onclick="addremind()" >添加</a>
			</span>
		</div>
	</div>

	<?php } ?>

	</div>
	<div class="xgtxBtn" style="margin-top:15px;"><a href="javascript:;" style="margin-top:15px;" class="borlanbtn btnlogo" >确 认</a></div>

		<?php if ($roominfo['template'] == 'plate') { ?>
			<!--plate模板封面-->
			<div class="cqrightsc">
				<input id="img" type="hidden" name="img" value="" />
				<div class="sdss"><img id="folderimg" src="http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_247_147.jpg" style="width:247px;height:147px;" border="0"></div>
				<input class="lanbtn100 marlert" type="button" id="cqbc" value="修改课程封面" name="Submit">
			</div>
		<?php } else { ?>
			<div class="cqrightsc">
				<input id="img" type="hidden" name="img" value="" />
				<div class="sds"><img id="folderimg" src="http://static.ebanhui.com/ebh/images/nopic.jpg" style="width:114px;height:159px;" border="0"></div>
				<input class="lanbtn100 marlef75" type="button" id="cqbc" value="修改课程封面" name="Submit">
			</div>
		<?php } ?>



	<?php if($roominfo['isschool']==7){?>
	</div>
	<?php }?>
	
	<div class="tab_menu" style="float:left;*margin-top:-14px;<?=$picstyle?>">
	<ul>
		<li id="uploadli"  class="selected" onclick="changepanel('upload')">自定义图片</li>
		<li id="systemli" onclick="changepanel('system')">从图片库里选择</li>
	</ul>
</div>

<div class="tab_box" style="main-height:620px;float:left;border:none;border-top:solid 1px #cdcdcd;<?=$picstyle?>">
	<div class="ecenter" id="upload" style="padding:0;" >
		<iframe id="imgFrame" name="imgFrame" scrolling="no" width=786 height=460 frameborder=0 src=""></iframe>
	</div>
	
	<div class="ecenter" id="system" style="display:none">
		<?php if ($roominfo['template'] == 'plate') { ?>
			<!--plate模板封面图库-->
			<div class="xttxlist3 cover_page" >
				<ul id="page1">

					<?php $count=0;
					foreach($imgarr as $img){
					$count++;
					if($count>20 && $count%20==1){
					?>
				</ul>
				<ul id="page<?=intval($count/20)+1?>" style="display:none;">
					<?php }?>
					<li class="xtpage"><a href="#"><img d="<?=show_thumb($img, '247_147')?>" Jimg="a" width="129" height="77" src="<?=show_thumb($img, '129_77')?>" /></a></li>
					<?php }?>
				</ul>
			<?php if($count>20){?>
				<div class="pages" style="width:360px; margin-top: 20px;clear:both;">
					<div class="listPage" style="float:right;">
						<a id="prev" href="javascript:topage(1)" style="width: 60px;">&lt;&lt;上一页</a>
						<?php for($i=0;$i<=intval($count/20);$i++){?>
						<a id="pagelink<?=$i+1?>" href="javascript:topage(<?=$i+1?>)"><?=$i+1?></a>
						<?php }?>
						<a id="next" href="javascript:topage(2)">下一页&gt;&gt;</a>
					</div>
				</div>
			<?php }?>
		</div>
		<?php } else { ?>
			<div class="xttxlist2 cover_page" style="width:727px;float:left;">
				<ul id="page1">

					<?php $count=0;
					foreach($imgarr as $img){
					$count++;
					if($count>20 && $count%20==1){
					?>
				</ul>
				<ul id="page<?=intval($count/20)+1?>" style="display:none;">
					<?php }?>
					<li><a href="#"><img Jimg="a" width="114" height="159" src="<?=$img?>" /></a></li>
					<?php }?>
				</ul>

	<?php if($count>20){?>
	<div class="pages" style="width:360px; margin-top: 20px;clear:both;">
		<div class="listPage" style="float:right;">
			<a id="prev" href="javascript:topage(1)" style="width: 60px;">&lt;&lt;上一页</a>
			<?php for($i=0;$i<=intval($count/20);$i++){?>
			<a id="pagelink<?=$i+1?>" href="javascript:topage(<?=$i+1?>)"><?=$i+1?></a>
			<?php }?>
			<a id="next" href="javascript:topage(2)">下一页&gt;&gt;</a>
		</div>
	</div>
	<?php }?>
				</div>
		<?php } ?>
	</div>
</div>
</div>
</form>
<SCRIPT LANGUAGE="JavaScript">
<!--
	
	var changepanel = function(panel){
		$(".tab_menu li").removeClass("selected");
		$("#"+panel+"li").addClass("selected");
		$(".ecenter").hide();
		$("#"+panel).show();
		top.resetmain();
	}
	$(function(){
		var i= 1;
		$(".cover_page img").click(function(){
			if ($(this).attr('d')) {
				$("#folderimg").attr('src',$(this).attr('d'));
				$("#img").val($(this).attr('d'));
			} else {
				$("#folderimg").attr('src',$(this).attr('src'));
				$("#img").val($(this).attr('src'));
			}
			$(".tab_menu").hide(); 
			$(".tab_box").hide();
			top.gotoHash('#areatop');
			i++;
		});
		
		$("#cqbc").click(function(){
			if ($("#foldername").val()=="") {$("#foldernamespan").css("color","red").html("请先输入课程名称");return ;};
			i++;
			
			if(i%2==1){
				$(".tab_menu").hide(); 
				$(".tab_box").hide();
				top.resetmain('#areatop');
			}else{
				$(".tab_menu").show();
				$(".tab_box").show();
				setTimeout(function(){
					<?php
				 		$img = empty($coursedetail['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$coursedetail['img'];
					?>
					$("#imgFrame").attr("src",'<?=geturl('uploadimage/img')?>?initurl=<?=urlencode($img)?>');
					
					top.resetmain('#areabottom');

					},100)
			}
		});		
		topage(1);
		initcollect();
	});

	var topage = function(page){
		$(".cover_page ul").hide();
		$("#page"+page).show();
		$("#prev").attr('href','javascript:topage('+(page==1?1:page-1)+')');
		$("#next").attr('href','javascript:topage('+(page==$(".listPage a").length-2?$(".listPage a").length-2:page+1)+')');
		$(".listPage a").removeClass('none');
		$("#pagelink"+page).addClass('none');
	}
	
	// $(function(){
	//     window.onload = function() {
	//         document.getElementById("summary").onkeyup = function() {
	//             var len = this.value.length;
	//             var tmp = 200 - len;
	//             if (tmp <= 0) {
	//                 this.value = this.value.substring(0, 200);
	//                 document.getElementById("summary_msg").style.color='red';
	//                 document.getElementById("summary_msg").innerHTML = "您还可以输入 0 个字符";
	//             } else {
	//             	document.getElementById("summary_msg").style.color='red';
	//                 document.getElementById("summary_msg").innerHTML = "您还可以输入 " + tmp + " 个字符";
	//             }
	//         }
	//     }
	// });

	var _xform = new xForm({
			domid:'hitdiv',
			errorcss:'cuotic',
			okcss:'zhengtic',
			showokmsg:false
		});
	function initcollect() {
		$("#credit").blur(function() {
			checkcredit();
		});
		$(".isremind").click(function(){
			if($(this).val() == 1) {
				$(".remindinfo").show();
			} else {
				$(".remindinfo").hide();
			}
			top.resetmain();
		});
		$(".coursecredit").blur(function(){
			var ccredit = $.trim($(this).val());
			if(!isPInt(ccredit,true) || parseInt(ccredit) > 100) {
//				alert("课件占比必须为0到100的整数");
//				$(this).val("");
//				$(this).focus();
				return;
			}
			var iccredit = parseInt(ccredit);
			var iecredit = 100 - iccredit;
			$(".examcredit").val(iecredit);
		});
		$(".examcredit").blur(function() {
			var ecredit = $.trim($(this).val());
			if(!isPInt(ecredit,true) || parseInt(ecredit) > 100) {
//				alert("作业占比必须为0到100的整数");
//				$(this).val("");
//				$(this).focus();
				return;
			}
			var iecredit = parseInt(ecredit);
			var iccredit = 100 - iecredit;
			$(".coursecredit").val(iccredit);
		});
		$(".creditmode").click(function(){
			if($(this).val() == 1) {
				$(".dcredittime").show();
				$(".creditrule").hide();
			} else {
				$(".dcredittime").hide();
				$(".creditrule").show();
			}
			top.resetmain();
		});
//		$(".credittime").blur(function() {
//			checkcredittime();
//		});
	}
	function addremind() {
		var htmlstr = '<div style="width:700px;float:left;"><span class="pxxuanx" style="width:700px;margin-bottom:10px;">提醒时间：第 <input name="remindtime[]" type="text" class="remindtime" value="" maxlength="3" onblur="remindtimeblur(this)"/>分钟 提醒文字：<input name="remindmsg[]"  class="remindmsg" type="text" value="" '
		+ 'maxlength="100"/>&nbsp;<a href="javascript:void(0);" onclick="addremind()" >添加</a>&nbsp;<a href="javascript:void(0);" onclick="delremind(this)" >删除</a>'
		+ '</span></div>';
		$(".remindinfo").append(htmlstr);
		top.resetmain();
	}
	function delremind(obj) {
		$(obj).parent().parent().remove();
		top.resetmain();
	}
	function remindtimeblur(obj) {
		var rtime = $.trim($(obj).val());
		var flag = isPInt(rtime);
		if(!flag) {
			alert("提醒时间必须为正整数");
			$(obj).val("");
			$(obj).focus();
			return false;
		}
		return true;
	}
	function isPInt(num,flag) {
		var minnum = 1;
		if(flag) {
			minnum = 0;
		}
		if(num == "" || isNaN(num) || parseInt(num) < minnum) {
			return false;
		}
		return true;
	}
	function checkremindtime() {
		if($(".isremind").length ==0)
			return true;
		if($(".isremind:checked").val() == 0)
			return true;
		var robj = $(".remindtime");
		for(var i = 0; i < robj.length; i ++) {
			if(!remindtimeblur(robj[i])) {
				return false;
			}
		}
		return true;
	}
	function checkcredit() {
		if($("#credit").length ==0)
			return true;
		var scredit = $.trim($("#credit").val());
		var flag = isPInt(scredit,true);
		if(!flag) {
			alert("课程学分必须为大于或等于零的整数");
			$("#credit").val("");
			$("#credit").focus();
			return false;
		}
		return true;
	}
	function checkcredittime() {
		if($("#credittime").length ==0)
			return true;
		if($(".creditmode:checked").val() != 1)
			return true;
		var scredittime = $.trim($("#credittime").val());
		var flag = isPInt(scredittime);
		if(!flag) {
			alert("累计时长必须为正整数");
			$("#credittime").val("");
			$("#credittime").focus();
			return false;
		}
		return true;
	}
	function checkcoursecredit() {
		if($(".coursecredit").length ==0)
			return true;
		if($(".creditmode:checked").val() != 0)
			return true;
		var ccredit = $.trim($(".coursecredit").val());
		if(!isPInt(ccredit,true) || parseInt(ccredit) > 100) {
			alert("课件占比必须为0到100的整数");
			$(".coursecredit").val("");
			$(".coursecredit").focus();
			return false;
		}
		var iccredit = parseInt(ccredit);
		var iecredit = 100 - iccredit;
		$(".examcredit").val(iecredit);
		return true;
	}
	function checkexamcredit() {
		if($(".examcredit").length ==0)
			return true;
		if($(".creditmode:checked").val() != 0)
			return true;
		var ecredit = $.trim($(".examcredit").val());
		if(!isPInt(ecredit,true) || parseInt(ecredit) > 100) {
			alert("作业占比必须为0到100的整数");
			$(".examcredit").val("");
			$(".examcredit").focus();
			return false;
		}
		var iecredit = parseInt(ecredit);
		var iccredit = 100 - iecredit;
		$(".coursecredit").val(iccredit);
		return true;
	}
	function checkcollege() {
		if(checkcredit() &&	checkremindtime() && checkcoursecredit() && checkexamcredit() && checkcredittime()) {
			return true;
		}
		return false;
	}


//-->
</SCRIPT>

</div>
</body>
<html>