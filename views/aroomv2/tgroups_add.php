<?php $this->display('aroomv2/page_header')?>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen">
<style type="text/css">
.cqshangc {
	padding-bottom:10px;
	width: 786px;
	border-bottom: 1px solid #cdcdcd;
	float:left;
	*margin-bottom:3px;
}
.cqshangc .sckezi {
	font-size: 14px;
	font-weight: bold;
	color: #6683c7;
	height: 35px;
	border-bottom: 1px solid #cdcdcd;
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


</style>
	<div class="ter_tit">
		当前位置 > <a href="<?=geturl('aroomv2/tgroups')?>">分组管理</a> > 添加分组
		</div>
	<div class="lefrig" style="border:solid 1px #cdcdcd;padding-bottom:0;border-bottom:none;background:#fff;float:left;margin-top:15px;width:786px;">
	
<script type="text/javascript">
</script>

<form id="groupvalue" action="<?=geturl('aroomv2/tgroups/addGroup')?>" method="post">

<div class="cqshangc">
	<h2 class="sckezi">添加分组</h2>
	<div class="cqleftsc">
	<span class="pxxuanx">分组名称：</span>
	  <input name="groupname" id="groupname" type="text" onblur="checkgroupname()" class="inpxuanx" style="width: 333px;background: url(http://static.ebanhui.com/ebh/tpl/2012/images/inp_bg01.png) no-repeat;" value="" maxlength="20"/>
	  <p id="groupnamespan" style="margin:5px 0px 10px 80px; color:#999;">请输入分组名称如：语文组</p>
	  <span class="pxxuanx">分组排序：</span>
	  <input type="text" class="inpxuanx" onblur="checkdisplayorder()" style="width: 122px;background: url(http://static.ebanhui.com/ebh/tpl/2012/images/inp_bg02.png) no-repeat;" maxlength="10" id="displayorder" name="displayorder" value="10" />
	  	  <p id="displayorderspan" style="margin:5px 0px 10px 80px; color:#999;">序列号越小越靠前</p>

	<span class="pxxuanx">分组介绍：</span>
	  <textarea name="summary" style="min-height: 100px;height:100px;float:left;" onblur="checksummary()" id="summary" class="w388 txt"></textarea>
	  
	  	  <p id="summary_msg" style="margin:5px 0px 10px 80px; color:#999;">分组详细介绍(256字以内)</p>


	<div class="xgtxBtn" style="margin-top:15px"><a href="javascript:void(0);" class="borlanbtn btnlogo" >确 认</a></div>
	</div>

</div>
</form>
</div>
</div>
<script type="text/javascript">
	$(function(){
		$(".btnlogo").click(function(){
			if(checkgroupname() && checkdisplayorder() && checksummary()){
				$.ajax({
				   type: "POST",
				   dataType: "json",
				   url: "<?=geturl('aroomv2/tgroups/editGroupAjax')?>",
				   data: $("#groupvalue").serialize(),
				   success: function(res){
				    if(res.status=="1"){
						$.showmessage({
							message:res.msg,
							callback :function(){
	                          document.location=document.referrer;
	                        }});
						}else{
							$.showmessage({message:res.msg});
						}	
				   }
				});
				return false;
			}
		});
	});
	var checkgroupname = function(){
		if($("#groupname").val().replace(/\s/g,"")==""){
			$("#groupnamespan").css("color","red").html("请输入分组名称");
			return false;
		}
		$("#groupnamespan").css("color","#999").html("请输入分组名称如：语文组");
		return true;
	}
	var checkdisplayorder = function(){
		if($("#displayorder").val().replace(/\s/g,"")==null){
			$("#displayorderspan").css("color","red").html("请输入分组排序号");
			return false;
		}
		if($("#displayorder").val().match(/^(-|\+)?\d+$/)==null){
			$("#displayorderspan").css("color","red").html("分组排序号不能为空，且必须为整数！");
			return false;
		}
		$("#displayorderspan").css("color","#999").html("序列号越小越靠前");
		return true;
	}
	var checksummary =function(){
		if ($("#summary").val().length>256) {
			$("#summary_msg").css("color","red").html("分组详细介绍应在256字以内！");
			return false;
		};
		$("#summary_msg").css("color","#999").html("分组详细介绍(256字以内)");
		return true;
	}
//-->
</script>
</body>
<html>