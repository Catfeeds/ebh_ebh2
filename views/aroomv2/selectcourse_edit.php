<?php
$this->display('aroomv2/page_header')?>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xform.js?v=1"></script>
<STYLE TYPE="text/css">
body:after {
	background:none;
}
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
	display: inline;
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
.coursecredit ,.examcredit{
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
.listPage .none:visited {
	background: #23a1f2 none repeat scroll 0 0;
	border: 1px solid #23a1f2;
	color: #ffffff !important;
	font-weight: bold;
}
</style>
<div class="ter_tit">
	当前位置 > <a href="<?=geturl('aroomv2/more')?>">更多应用</a> > <a href="<?=geturl('aroomv2/selectcourse/courselist')?>">选课管理</a> > 编辑选课课程
</div>
<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:788px;">
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
			if(checkfoldername() && checksummary() && checkallowgrade()){
				$("#foldervalue").submit();
			}
		});

		$("input[name='allowgrade[]']").click(function(){
			if ($(this).val() == '0' && $(this).prop('checked') == true) {
				$("input[name='allowgrade[]']").each(function(index, domEle){
					if (index != 0)
						$(domEle).prop('checked', false);
				});
			} else if ($(this).prop('checked') == true){
				$("input[name='allowgrade[]']:eq(0)").prop('checked', false);
			}
		});
	});
	var checkfoldername = function(){
		if($("#foldername").val().replace(/\s/g,"")==""){
			$("#foldernamespan").css("color","red").html("请输入课程名称");
			return false;
		}
		//$("#foldernamespan").css("color","#999").html("请输入课程名称如：高一语文上册");
		return true;
	}
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
		if ($("#summary").val().length>800) {
			$("#summary_msg").css("color","red").html("课程详细介绍应在800字以内！");
			return false;
		}else if($("#summary").val()=='课程详细介绍(800字以内)'){
			$("#summary").val("");
		};
		return true;
	}
	var checkallowgrade = function(){
		if ($("input[name='allowgrade[]']:checked").length == 0) {
			$("#allowgrade_msg").css("color","red").html("请选择适合年级");
			return false;
		}
		return true;
	}
//-->
</script>


<?php $picstyle = 'display:none;'?>

	<form id="foldervalue" action="<?=geturl('aroomv2/selectcourse/edit')?>" method="post">

		<input type="hidden" value="<?=$coursedetail['folderid']?>" name="folderid" />

		<div class="cqshangc">
			<h2 class="sckezi">编辑选课课程</h2>
			<div class="cqleftsc">

				<span class="pxxuanx">课程名称：</span>
				<input name="foldername" id="foldername" type="text" onblur="checkfoldername()" class="inpxuanx" style="width: 332px;background: url(http://static.ebanhui.com/ebh/tpl/2012/images/inp_bg01.png) no-repeat;" value="<?=$coursedetail['foldername']?>" maxlength="20"/>
				<p id="foldernamespan" style="margin:5px 0px 10px 80px; color:#999;"></p>
				<div id="hitdiv">
					<span class="pxxuanx">课程介绍：</span>
					<textarea name="summary" style="min-height: 200px;height:200px;float:left;" onblur="checksummary()" id="summary" class="w388 txt"><?=$coursedetail['summary']?></textarea>
		  	  		<p id="summary_msg" style="margin:5px 0px 10px 80px; color:#999;"></p>

		  	  		<div style="clear:both;"></div>

					<div style="width:500px;float:left;margin-top:10px;">
						<span class="pxxuanx">主讲老师：</span>
						<div  class="inpxuanx" style="width:323px;padding-left:10px;background: url(http://static.ebanhui.com/ebh/tpl/2012/images/inp_bg01.png) no-repeat;">
							<input name="speaker" type="text"  class="inpxuanx" style="width: 310px;" value="<?=empty($coursedetail['speaker'])?'主讲老师':$coursedetail['speaker']?>" />
						</div>
					</div>
						<div style="width:500px;float:left;margin-top:10px;">
						<span class="pxxuanx">上课地点：</span>
						<div  class="inpxuanx" style="width:323px;padding-left:10px;background: url(http://static.ebanhui.com/ebh/tpl/2012/images/inp_bg01.png) no-repeat;">
							<input name="location" type="text" id="location" class="inpxuanx" style="width:310px;" value="<?=$coursedetail['location']?>" />
						</div>
					</div>
					<div style="width:500px;float:left;margin-top:10px;">
						<span class="pxxuanx">招收人数：</span>
						<div  class="inpxuanx" style="width:323px;padding-left:10px;background: url(http://static.ebanhui.com/ebh/tpl/2012/images/inp_bg01.png) no-repeat;">
							<input name="admitnum" type="text" id="admitnum" class="inpxuanx" style="width:310px;" value="<?=$coursedetail['admitnum']?>" />
						</div>
					</div>
					<div style="width:500px;float:left">
						<span class="pxxuanx">禁止报名：</span>
						<label><input style="margin-top:10px;float:left;width:26px;" type="radio" value="0" name="isforbidden"<?php if($coursedetail['isforbidden'] == 0){?> checked="checked"<?php }?> /><span style="float:left;margin-top:5px">允许报名</span></label>
						<label><input style="margin-top:10px;float:left;width:26px;" type="radio" value="1" name="isforbidden"<?php if($coursedetail['isforbidden'] == 1){?> checked="checked"<?php }?> /><span style="float:left;margin-top:5px">禁止报名</span></label>
					</div>
					<div style="float:left;width:490px;display: inline;">
						<span class="pxxuanx">适合年级：</span>
						<div style="width:84px; float:left;display:inline;"><label><input style="margin-top:5px;float:left;width:26px;" type="checkbox" value="0" name="allowgrade[]"<?php if($coursedetail['allowgrade'] == '0'){?> checked="checked"<?php }?> /><span style="float:left;margin-right:10px;display:inline;">不限</span></label></div>
						<div style="width:84px; float:left;display:inline;"><label><input style="margin-top:5px;float:left;width:26px;" type="checkbox" value="1" name="allowgrade[]"<?php if(strpos($coursedetail['allowgrade'], ',1,')!== FALSE){?> checked="checked"<?php }?> /><span style="float:left;margin-right:10px;display:inline;">一年级</span></label></div>
						<div style="width:84px; float:left;display:inline;"><label><input style="margin-top:5px;float:left;width:26px;" type="checkbox" value="2" name="allowgrade[]"<?php if(strpos($coursedetail['allowgrade'], ',2,')!== FALSE){?> checked="checked"<?php }?> /><span style="float:left;margin-right:10px;display:inline;">二年级</span></label></div>
						<div style="width:84px; float:left;display:inline;"><label><input style="margin-top:5px;float:left;width:26px;" type="checkbox" value="3" name="allowgrade[]"<?php if(strpos($coursedetail['allowgrade'], ',3,')!== FALSE){?> checked="checked"<?php }?> /><span style="float:left;margin-right:10px;display:inline;">三年级</span></label></div>
						<div style="width:84px; float:left;display:inline;"><label><input style="margin-top:5px;float:left;width:26px;" type="checkbox" value="4" name="allowgrade[]"<?php if(strpos($coursedetail['allowgrade'], ',4,')!== FALSE){?> checked="checked"<?php }?> /><span style="float:left;margin-right:10px;display:inline;">四年级</span></label></div>
						<div style="width:84px; float:left;display:inline;"><label><input style="margin-top:5px;float:left;width:26px;" type="checkbox" value="5" name="allowgrade[]"<?php if(strpos($coursedetail['allowgrade'], ',5,')!== FALSE){?> checked="checked"<?php }?> /><span style="float:left;margin-right:10px;display:inline;">五年级</span></label></div>
						<div style="width:84px; float:left;display:inline;"><label><input style="margin-top:5px;float:left;width:26px;" type="checkbox" value="6" name="allowgrade[]"<?php if(strpos($coursedetail['allowgrade'], ',6,')!== FALSE){?> checked="checked"<?php }?> /><span style="float:left;margin-right:10px;display:inline;">六年级</span></label></div>
					</div>
				    <p id="allowgrade_msg" style="margin:5px 0px 10px 80px; color:#999;"></p>

				</div>
				<?php if($roominfo['template'] == 'plate') { ?>
					<div class="cqrightsc">
						<input id="img" type="hidden" name="img" value="" /><?php $img = show_plate_course_cover($coursedetail['img']); ?>
						<div class="sdss"><img id="folderimg" src="<?=empty($img)?'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_247_147.jpg':show_thumb($img, '247_147')?>" style="width:247px;height:147px;" border="0"></div>
						<input class="lanbtn100 marlert" type="button" id="cqbc" value="修改课程封面" name="Submit">
					</div>
				<?php } else { ?>
					<div class="cqrightsc">
						<input id="img" type="hidden" name="img" value="<?=$coursedetail['img']?>" />
						<div class="sds">
							<img id="folderimg" src="<?=empty($coursedetail['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$coursedetail['img']?>" style="width:114px;height:159px;" border="0">
						</div>
						<input class="lanbtn100 marlef75" type="button" id="cqbc" value="修改课程封面" name="Submit">
					</div>
				<?php } ?>
</div>
<div class="xgtxBtn" style="margin-top:15px;">
	<a href="javascript:;" style="margin-top:15px;" class="borlanbtn btnlogo" >确 认</a>
</div>


</div>
</form>
<SCRIPT LANGUAGE="JavaScript">
<!--
	
	var changepanel = function(panel){
		if (panel == 'system') {
			$(".pages").css("display","block");
		}else{
			$(".pages").css("display","none");
		}
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
				<?php
				 	$img = empty($coursedetail['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$coursedetail['img'];
				?>
				$("#imgFrame").attr("src",'<?=geturl('uploadimage/img')?>?initurl=<?=urlencode($img)?>');
				$(".tab_menu").show();
				$(".tab_box").show();
				top.resetmain('#areabottom');
			}
		});		
		topage(1);
	});

	var topage = function(page){
		$(".cover_page ul").hide();
		$("#page"+page).show();
		$("#prev").attr('href','javascript:topage('+(page==1?1:page-1)+')');
		$("#next").attr('href','javascript:topage('+(page==$(".listPage a").length-2?$(".listPage a").length-2:page+1)+')');
		$(".listPage a").removeClass('none');
		$("#pagelink"+page).addClass('none');
	}

//-->
</SCRIPT>
<div class="tab_menu" style="float:left;*margin-top: -14px;<?=$picstyle?>">
	<ul>
		<li id="uploadli"  class="selected" onclick="changepanel('upload')">自定义图片</li>
		<li id="systemli" onclick="changepanel('system')">从图片库里选择</li>
	</ul>
</div>

<div class="tab_box" style="border-left:none;border-right:none;<?=$picstyle?>">
	<div class="ecenter" id="upload" style="padding:0px;">
		<iframe id="imgFrame" name="imgFrame" scrolling="no" width=786 height=460 frameborder=0 src=""></iframe>
	</div>

	<div class="ecenter" id="system" style="display:none">
		<?php if ($roominfo['template'] == 'plate') { ?>
			<div class="xttxlist3 cover_page">
				<ul id="page1">
					<?php $count=0;
					foreach($imgarr as $img){
					$count++;
					if($count>20 && $count%20==1){
					?>
				</ul>
				<ul id="page<?=intval($count/20)+1?>" style="display:none;">
					<?php }?>
					<li class="xtpage"><a href="#"><img Jimg="a" width="129" height="77" d="<?=show_thumb($img, '247_147')?>" src="<?=show_thumb($img, '129_77')?>" /></a></li>
					<?php }?>
				</ul>
			</div>
			<?php if($count>20){?>
				<div class="pages" style="width:360px; margin-top: 20px;clear:both">
					<div class="listPage" style="float:right;">
						<a id="prev" href="javascript:topage(1)" style="width: 60px;">&lt;&lt;上一页</a>
						<?php for($i=0;$i<=intval($count/20);$i++){?>
							<a id="pagelink<?=$i+1?>" href="javascript:topage(<?=$i+1?>)"><?=$i+1?></a>
						<?php }?>
						<a id="next" href="javascript:topage(2)">下一页&gt;&gt;</a>
					</div>
				</div>
			<?php }?>
		<?php } else { ?>
			<div class="xttxlist2 cover_page">
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
			</div>
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
		<?php } ?>
	</div>
	
</div>


</div>
</body>
<html>