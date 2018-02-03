<?php $this->display('troom/page_header')?>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" type="text/css" />
<STYLE TYPE="text/css">
.cqshangc {
	padding-bottom:10px;
	width: 748px;
	border: 1px solid #cdcdcd;
	float:left;
	*margin-bottom:3px;
}
.cqshangc .sckezi {
	font-size: 14px;
	font-weight: bold;
	color: #6683c7;
	height: 35px;
	width: 718px;
	border-bottom-width: 1px;
	border-bottom-style: solid;
	border-bottom-color: #cdcdcd;
	margin-left: 10px;
	padding-left: 10px;
	line-height: 35px;
}
.cqshangc .cqleftsc {
	float: left;
	width: 478px;
	font-size: 14px;
	margin-top: 15px;
	padding-left: 20px}
.inpxuanx {
	height: 32px;
	border:none;
	padding-left: 5px;
	overflow: hidden;
	font-size: 14px;
	line-height: 32px;
	display: block;
	color: #666666;
}


.cqshangc .cqrightsc {
    float: left;
    font-size: 14px;
    left: 480px;
    margin-top: 15px;
    position: absolute;
    width: 250px;
	top:136px;
}
.cqshangc .cqleftsc .pxxuanx {
	height: 32px;
	display: block;
	float: left;
	line-height: 32px;

}
.sds {
	height: 184px;
	width: 145px;
	border: 1px solid #cdcdcd;
	background-image:url(http://static.ebanhui.com/ebh/tpl/2012/images/dise.jpg);
	background-repeat: no-repeat;
	background-position: center center;
	margin-bottom: 8px;
	margin-right: auto;
	margin-left: auto;
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


</STYLE>
	<div class="ter_tit">
		当前位置 > <a href="<?=geturl('troom/subject')?>">课程管理</a> > 开设课程
		</div>
	<div class="lefrig" style="margin-top:10px;">
	
<script type="text/javascript">
<!--
	var changeimg = function(url){
		$("#folderimg").attr('src',url);
		$("#img").val(url);

		var fname = '';
		var forder = '';
		if($.trim(HTMLDeCode($("#foldername").val()))==""){
			$("#foldernamespan").css("color","red").html("请输入课程名称");
			fname =='false';
		}
		if($("#displayorder").val().replace(/\s/g,"")==null){
			$("#displayorderspan").css("color","red").html("请输入课程排序号");
			forder = 'false';
		}
		if($("#displayorder").val().match(/^(-|\+)?\d+$/)==null){
			$("#displayorderspan").css("color","red").html("课程排序号不能为空，且必须为整数！");
			forder = 'false';
		}

		if(fname!='false' && forder!='false'){
			$("#foldervalue").submit();
		}
		
	}
	$(function(){
		$(".btnlogo").click(function(){
			if(checkfoldername() && checkdisplayorder() && checksummary()){
				$("#foldervalue").submit();
				return false;
			}
		});
	});
	var checkfoldername = function(){
		if($("#foldername").val().replace(/\s/g,"")==""){
			$("#foldernamespan").css("color","red").html("请输入课程名称");
			return false;
		}
		$("#foldernamespan").css("color","#999").html("请输入课程名称如：高一语文上册");
		return true;
	}
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
	}
	var checksummary =function(){
		if ($("#summary").val().length>200) {
			$("#summary_msg").css("color","red").html("课程详细介绍应在200字以内！");
			return false;
		};
		$("#summary_msg").css("color","#999").html("课程详细介绍(200字以内)");
		return true;
	}
//-->
</script>
<?php $picstyle = 'display:none;'?>

<form id="foldervalue" action="" method="post">
<div class="cqshangc">
	<h2 class="sckezi">开设课程</h2>
	<div class="cqleftsc">
	<span class="pxxuanx">课程名称：</span>
	  <input name="foldername" id="foldername" type="text" onblur="checkfoldername()" class="inpxuanx" style="width: 327px;background: url(http://static.ebanhui.com/ebh/tpl/2012/images/inp_bg01.png) no-repeat;" value="" maxlength="20"/>
	  <p id="foldernamespan" style="margin:5px 0px 10px 80px; color:#999;">请输入课程名称如：高一语文上册</p>
	  <span class="pxxuanx">课程排序：</span>
	  <input type="text" class="inpxuanx" onblur="checkdisplayorder()" style="width: 116px;background: url(http://static.ebanhui.com/ebh/tpl/2012/images/inp_bg02.png) no-repeat;" maxlength="10" id="displayorder" name="displayorder" value="10" />
	  	  <p id="displayorderspan" style="margin:5px 0px 10px 80px; color:#999;">序列号越小越靠前</p>

	<span class="pxxuanx">课程介绍：</span>
	  <textarea name="summary" style="min-height: 100px;height:100px;" onblur="checksummary()" id="summary" class="w388 txt"></textarea>
	  
	  	  <p id="summary_msg" style="margin:5px 0px 10px 80px; color:#999;">课程详细介绍(200字以内)</p>


	<div class="xgtxBtn" style="margin-top:15px"><a href="javascript:;" class="borlanbtn btnlogo" >确 认</a></div>
	</div>
  <div class="cqrightsc">
	<input id="img" type="hidden" name="img" value="" />
	<div class="sds"><img id="folderimg" src="http://static.ebanhui.com/ebh/images/nopic.jpg" style="width:114px;height:159px;" border="0"></div>
	<input class="lanbtn100 marlef75" type="button" id="cqbc" value="修改课程封面" name="Submit">
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
		$(".xttxlist2 img").click(function(){
			$("#folderimg").attr('src',$(this).attr('src'));
			$("#img").val($(this).attr('src'));
		});
		var i= 1;
		$("#cqbc").click(function(){
			if ($("#foldername").val()=="") {$("#foldernamespan").css("color","red").html("请先输入课程名称");return ;};
			i++;
			
			if(i%2==1){
				$(".tab_menu").hide(); 
				$(".tab_box").hide();
			}else{
				$(".tab_menu").show();
				$(".tab_box").show();
				setTimeout(function(){
					$("#imgFrame").attr("src",'<?=geturl('uploadimage/img')?>');
					
					top.resetmain();

					},100)
			}
		});		
		topage(1);
	});

	var topage = function(page){
		$(".xttxlist2 ul").hide();
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
//-->
</SCRIPT>
<div class="tab_menu" style="float:left;*margin-top:-33px;<?=$picstyle?>">
	<ul>
		<li id="uploadli"  class="selected" onclick="changepanel('upload')">自定义图片</li>
		<li id="systemli" onclick="changepanel('system')">从图片库里选择</li>
	</ul>
</div>

<div class="tab_box" style="main-height:620px;float:left;<?=$picstyle?>">
	<div class="ecenter" id="upload" >
		<iframe id="imgFrame" name="imgFrame" scrolling="no" width=730 height=460 frameborder=0 src=""></iframe>
	</div>
	
	<div class="ecenter" id="system" style="display:none">
		<div class="xttxlist2" style="width:727px;float:left;">
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
	<div class="pages" style="width:360px; margin-top: 20px;">
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
</div>
</div>
</body>
<html>