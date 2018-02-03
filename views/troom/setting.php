<?php $this->display('troom/page_header'); ?>
<link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" />	
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/upload.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<script type="text/javascript">
<!--
function upsummary(){
	var summary=$("#summary").val();
	$.ajax({
		url:"<?= geturl('troom/setting/upinfo') ?>",
		type:'post',
		data:{'summary':summary},
		dataType:'text',
		success:function(data){
			if(data=='success'){
				$.showmessage({
					img		 : 'success',
					message  :  '平台介绍修改成功',
					title    :      '平台介绍修改',
					callback :    function(){
                                                $("#sy").html("<p>" +summary+ "</>");
						onclswitch(1);
					}
				});
				
			}else{
				$.showmessage({
					img		 : 'error',
					message  :  '平台介绍修改失败',
					title    :      '平台介绍修改',
					callback :    function(){
						
					}
				});
			}
		}
	});
}
//编辑简介
function onclswitch(flag){
    if(flag == 1) {
        document.getElementById("sy").style.display="";
	document.getElementById("summarydiv").style.display="none";
	document.getElementById("edit1").style.display="";
	document.getElementById("baocun").style.display="none";
    } else {
	document.getElementById("sy").style.display="none";
	document.getElementById("summarydiv").style.display="";
	document.getElementById("edit1").style.display="none";
	document.getElementById("baocun").style.display="";
    }
	top.resetmain();
}

//-->
</script>

						<script type="text/javascript">
						<!--
						$(function(){
						    window.onload = function() {
						        document.getElementById("summary").onkeyup = function() {
						        	checksummary();
						        }

						        $("#summary").bind('paste', function(e) {
						            setTimeout(function() {
						            	checksummary();
						            }, 100);
						       });
						    }
						});

						function checksummary(){
				            var len = document.getElementById("summary").value.length;
				            var tmp = 500 - len;
				            if (tmp <= 0) {
				            	document.getElementById("summary").value = document.getElementById("summary").value.substring(0, 500);
				                document.getElementById("summary_msg").innerHTML = "您还可以输入<font color='red'>0 </font>个字符";
				            } else {
				                document.getElementById("summary_msg").innerHTML = "您还可以输入 <font color='red'>" + tmp + "</font>个字符";
				            }
						}
						
						//-->
						</script>
<div class="ter_tit">
	当前位置 > 我的教室
</div>
<?php 
if(empty($myroom['cface']))
	$cface = 'http://static.ebanhui.com/ebh/tpl/default/images/face/4.jpg';
else
	$cface = $myroom['cface'];


?>	
<div class="lefrig" style="margin-top:10px;">
	<div class="tertiop">
		<div class="tertiop_lefke">
		<a href="<?= geturl('troom/setting/avatarold') ?>" class="potton">
		<img src="<?= $cface?>" style="width:100px;height:100px;"/>
		</a>
		<a href="<?= geturl('troom/setting/avatarold') ?>" class="gaitu">修改头像</a>
		<p>课件数量：<span><?= $myroom['coursenum']?></span></p>
		<p>学员数量：<span><?= $myroom['stunum'] ?></span></p>
		<p>教师数量：<span><?= $myroom['teanum'] ?></span></p>
		</div>
		<div class="tertiop_rigke">
			<div class="pt_tittop">平台名称：<span style="color:#3059a9;"><?= $myroom['crname'] ?></span></div>
			<div class="mashe">
				<table width="455" border="0" cellpadding="0">
				  <tr>
					<td height="28" colspan="3" style="font-size:14px;">&nbsp;平台联系方式设置：</td>
					</tr>
				  <tr>
					<td width="66"><div align="center" style="margin-right: -12px;">电话：</div></td>
					<td width="300" height="28">
					<span id="crphone_span" style="margin-left:7px;" maxlength="13"><?= $myroom['crphone'] ?></span>
					<input id="crphone" class="txtxiegai" name="crphone" type="text" value="<?= $myroom['crphone'] ?>" style="display:none;" maxlength="15"/>
					</td>
					<td width="58">
					<a id="update_crphone" href="#">修改</a>
					<a id="que_crphone" href="#" style="color:#3059a9;display:none;" >确定</a>
					</td>
				  </tr>
				  <tr>
					<td width="66"><div align="center" style="margin-right: -12px;">主页：</div></td>
					<td height="28">
					<span style="margin-left:7px;">http://</span><span id="cremail_span"><?=$myroom['cremail']?></span>
					<input id="cremail" class="txtxiegai" name="cremail" type="text" value="<?= $myroom['cremail'] ?>" style="display:none;width:250px;" maxlength="35"/> 
					</td>
					<td width="58">
					<a id="update_cremail" href="#">修改</a>
					<a id="que_cremail" href="#" style="color:#3059a9;display:none;">确定</a>
					</td>
				  </tr>

				  <tr>
					<td width="66"><div align="center" style="margin-right: -12px;">Q　Q：</div></td>
					<td height="28">
					<span id="crqq_span" style="margin-left:7px;" maxlength="12"><?= $myroom['crqq'] ?></span>
					<input id="crqq" class="txtxiegai" name="crqq" type="text" value="<?= $myroom['crqq'] ?>" style="display:none;" maxlength="12"/> 
					</td>
					<td width="58">
					<a id="update_crqq" href="#">修改</a>
					<a id="que_crqq" href="#" style="color:#3059a9;display:none;">确定</a>
					</td>
				  </tr>

				  <tr>
					<td width="66"><div align="center" style="margin-right: -12px;">微博：</div></td>
					<td height="28">
					<span id="weibosina_span" style="margin-left:7px;"><?= $myroom['weibosina'] ?></span>
					<input id="weibosina" class="txtxiegai" name="weibosina" type="text" value="<?= $myroom['weibosina'] ?>" style="display:none;" />
					</td>
					<td width="58">
					<a id="update_weibosina" href="#">修改</a>
					<a id="que_weibosina" href="#" style="color:#3059a9;display:none;">确定</a>
					</td>
				  </tr>

				  <tr>
					<td width="66"><div align="center" style="margin-right: -12px;">地址：</div></td>
					<td height="28">
					<span id="craddress_span" style="margin-left:7px;"><?= $myroom['craddress'] ?></span>
					<input id="craddress" class="txtxiegai" name="craddress" type="text" value="<?= $myroom['craddress'] ?>" style="display:none;" />
					</td>
					<td width="58">
					<a id="update_craddress" href="#">修改</a>
					<a id="que_craddress" href="#" style="color:#3059a9;display:none;">确定</a>
					</td>
				  </tr>
				<input type="hidden" id="lng" value="<?= $myroom['lng'] ?>" ><input type="hidden" id="lat" value="<?= $myroom['lat'] ?>" >
				</table>
			</div>
			<div class="zuirig">
				<div class="guiga">	
				
					<div id="littlemap" style="width:119px;height:80px;"></div>
					
                                <?php if(!empty($myroom['lng']) && !empty($myroom['lat'])) { ?>
					<span id="maptip" class="tishit">您已标注地图</span>
					<script type="text/javascript">
					var defaultZooms = 16;	//默认缩放比例
					function loadScripts() {
					  var script = document.createElement("script");
					  script.src = "http://api.map.baidu.com/api?v=1.4&callback=initializes";
					  document.body.appendChild(script);
					}
					function initializes() {
					  var mp = new BMap.Map('littlemap');
					  var points = new BMap.Point(<?= $myroom['lng'] ?>, <?= $myroom['lat'] ?>);
					  mp.centerAndZoom(points, defaultZooms);
					  mp.enableScrollWheelZoom();
					  var marker = new BMap.Marker(points);
					  mp.addOverlay(marker);
					  mp.disableDragging();  
					  mp.disableScrollWheelZoom();  
					  mp.disableDoubleClickZoom();  
					  mp.disableKeyboard(); 
					}
					$(function(){
						loadScripts();
					});
					</script>
				
                                <?php } else { ?>
				<span id="maptip" class="tishit">您未标注地图</span>
                                <?php } ?>
				</div>
			<input type="button" value="" class="biaozhubtn" onclick="setmap()" style="height: 26px; width: 72px;"/>
			<a href="javascript:setmap();" ></a>
			
			</div>
		</div>
	</div>
	<div class="ptxiang">
	<h2 class="ptjianj">平台简介:</h2>
		<div id="sy"  class="leivnt">
		<p><?= $myroom['summary'] ?></p>
		</div>
		<div class="leivnt" id="summarydiv" style="display:none;">
		<textarea name="summary" id="summary" cols="40" class="txtxiu" rows="5"><?= $myroom['summary'] ?></textarea>
		</div>
		<div  id="edit1" class="fotlian">
		<a href="javascript:void(0)" class="iekrny" onclick="showdetail()">编辑详细介绍</a>
		<a href="javascript:void(0)" class="iekrny" style="margin-right:40px;" onclick="onclswitch(0)">编辑简介</a>
		</div>
		<div  id="baocun" class="fotlian" style="display:none;">
		<span id='summary_msg' style="float:right;height:35px;line-height:35px;margin-right:10px;">请输入平台介绍(500字以内)</span>
		<a href="javascript:void(0)" class="iekrny" onclick="upsummary();">保存</a>
		<a onclick="onclswitch(1);" class="iekrny" style="margin-right:40px;cursor:pointer">返回</a>
		</div>
	</div>
	<div class="ptbiaoq">
	<h2 class="shezhih">平台标签设置:</h2>
	<div style="float: left;margin-bottom:10px;width:740px;">
	<span class="xianyou">标签：</span>
	<input id="crlabel" style="float:left;" class="txtlan" name="textarea2" type="text" value="多个标签词之间请用空格分开" />
	<input class="previewBtn marlef" style="height:28px;line-height:28px;" type="submit" name="Submit" value="添加标签" onclick="addlabel()"/>
</div>
	<h3 class="yiyou">已有标签：</h3>
		<div class="setup">
		
                <?php if(!empty($myroom['crlabel'])) { 
                    $labelarr = explode(',',$myroom['crlabel']);
                    ?>
		
		<ul class="labelul">
                <?php foreach($labelarr as $label) { ?>
		<li class="mylabel" onmouseout="this.className='mylabel'" onmouseover="this.className='mylabel mylabelhover'">
		<a class="labelnode" href="#" title="$lable" ><?= $label ?></a>
		<a class="labeldel" title="删除标签" onclick="removelabel(this)" href="javascript:void(0)">
		<img src="http://static.ebanhui.com/ebh/tpl/default/images/transparent.gif">
		</a>
		</li>
                <?php } ?>

                <?php } else { ?>
		您还没有添加任何标签！
                <?php } ?>
		</ul>
		</div>
		<div class="clear"></div>
		<div class="fotsmbq">
		什么是标签：标签是平台主要内容的关键描述，学员可以通过搜索标签来找到您的平台。一般都为简短的词，如初中、法律、经济等。所有标签的字数之和不能超过50个字。
		</div>
	</div>
</div>
<div id="divMapLayer" style="width:500px;height:350px;display:none;">
	<div style="margin-bottom:5px;">
		地址：<input type="text" value="" id="txtMapSearchKey" name="txtMapSearchKey" style="width:360px;" />&nbsp;&nbsp;<input type="button" value="" style="cursor:pointer;background:url(http://static.ebanhui.com/ebh/tpl/2012/images/dingwei1206.png) no-repeat;width:68px;height:22px;border:none;" onclick="search()" />
		
	</div>
	<div id="map" style="width:500px;height:325px"></div>
<div>
		  <div class="main_bot"></div>
		</div>
</div>
<script type="text/javascript">
<!--	
		$(function(){
			bindEvens("crphone","update_crphone","que_crphone","crphone_span","crphone");
			bindEvens("cremail","update_cremail","que_cremail","cremail_span","cremail");
			bindEvens("crqq","update_crqq","que_crqq","crqq_span","crqq");
			bindEvens("weibosina","update_weibosina","que_weibosina","weibosina_span","weibosina");
			bindEvens("craddress","update_craddress","que_craddress","craddress_span","craddress");
		});
		function bindEvens(bflag,updateid,queid,spanid,inputid){
			$("#"+updateid).click(function(){
			    show(updateid,queid,spanid,inputid);	
			});
			$("#"+queid).click(function(){
				hide(bflag,updateid,queid,spanid,inputid);
			});
			$("#"+spanid).click(function(){			
				show(updateid,queid,spanid,inputid);				
			});		
			$("#"+inputid).blur(function(){
				hide(bflag,updateid,queid,spanid,inputid);
			});
		}
		function show(updateid,queid,spanid,inputid){
			$("#"+updateid).hide();
			$("#"+queid).show();
			$("#"+spanid).hide();
			$("#"+inputid).show();			
		}
	 
		function hide(bflag,updateid,queid,spanid,inputid){
			$("#"+updateid).show();
			$("#"+queid).hide();
			$("#"+spanid).show();
			$("#"+inputid).hide();	
			savedata(bflag,updateid,queid,spanid,inputid);
		}

		function savedata(bflag,updateid,queid,spanid,inputid){
			var crphone = $("#crphone").val();
			var cremail = $("#cremail").val();
			var crqq = $("#crqq").val();
			var weibosina = $("#weibosina").val();
			var craddress = $("#craddress").val();

			var pemailreg = /^[0-9a-zA-Z]+(\.[0-9a-zA-Z\-_]*)*\.(com|net|org|cn)$/;
			var pcrqq = /^[0-9]{5,12}$/;
			var pweibosina = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
			
			if (bflag == "crqq") {
				if(!pcrqq.test( $("#crqq").val())){
					alert("请填写有效的QQ号。");
					return ;
				}
			};
			if (bflag == "weibosina") {
				if(!pweibosina.test( $("#weibosina").val())){
					alert("请填写有效的微博号。");
					return ;
				}
			};

			var lng = $("#lng").val();	
		//	alert($("#lng").val());
			var lat = $("#lat").val();
				$.ajax({
					url:"<?= geturl('troom/setting/upinfo') ?>",
					type:'post',
					data:{'crphone':crphone,'cremail':cremail,'crqq':crqq,'weibosina':weibosina,'craddress':craddress,'lng':lng,'lat':lat},
					dataType:'text',
					success:function(data){
						if(data=='success'){
							$("#"+spanid).html($("#"+inputid).val());
						}else{
						}
					}
				});
		}
//-->
	</script>
<script type="text/javascript">
/*加载地图*/
var ismapinit = 0;	//是否已加载地图
var defaultZoom = 16;	//默认缩放比例
var mp;	//地图变量
var marker;
function loadBdMap() {
  var script = document.createElement("script");
  script.src = "http://api.map.baidu.com/api?v=1.4&callback=initialize";
  document.body.appendChild(script);
}
function showdetail() {
	if (window.parent.showdetail != undefined)
	{
		window.parent.showdetail();
	}
}
function setmap() {
	$('#divMapLayer').dialog({
		autoOpen: false,
		width: 512,
		height: 455,
		title:'标注地图（您可以通过在地图上点击来标注位置）',
		resizable:false,
		modal: true,//模式对话框
		buttons: {
          "取消": function() {
                $( this ).dialog( "close" );
             },
		  "确定": function() {
				if (marker != null)
				{
					var curpoint = marker.getPosition();
					var lng = curpoint.lng;
					var lat = curpoint.lat;

					$("#lng").val(curpoint.lng);
					//alert($("#lng").val())
					$("#lat").val(curpoint.lat);
					$( this ).dialog( "close" );
					$("#maptip").css("color","blue");
					$("#maptip").html("您已标注地图");
					
					savedata();
					var littlemap = new BMap.Map('littlemap');
					var point2 = new BMap.Point(curpoint.lng, curpoint.lat);
					littlemap.centerAndZoom(point2, 16);
					littlemap.enableScrollWheelZoom();
					var marker2 = new BMap.Marker(point2);
					littlemap.addOverlay(marker2);
					littlemap.disableDragging();  
					littlemap.disableScrollWheelZoom();  
					littlemap.disableDoubleClickZoom();  
					littlemap.disableKeyboard(); 
					//littlemap.addControl(new BMap.NavigationControl({}));  //右上角，仅包含平移和缩放按钮
				}
             }
         }
	});
	$("#divMapLayer").dialog("open");
	if (ismapinit == 0)
	{
		loadBdMap();
	}
}
function initialize() {
	mp = new BMap.Map('map');
	if ($("#lat").val() == "" || $("#lng").val() == "")
	{
		mp.centerAndZoom("杭州市",defaultZoom);
		if ($("#craddress").val() != "")
		{
			var options = {  
			 onSearchComplete: function(results){  
			   if (local.getStatus() == BMAP_STATUS_SUCCESS){  
				 // 判断状态是否正确  
				 if (results.getCurrentNumPois() > 1)
				 {
					 var searchpoint = results.getPoi(0).point;
					 mp.centerAndZoom(searchpoint,defaultZoom);
				 }
			   }  
			 }  
			};  
			var local = new BMap.LocalSearch(mp,options);  
			local.search($("#craddress").val());  
			$("#txtMapSearchKey").val($("#craddress").val());
		}
	} else {
		mp.centerAndZoom(new BMap.Point($("#lng").val(), $("#lat").val()),defaultZoom);
		marker = new BMap.Marker(new BMap.Point($("#lng").val(), $("#lat").val()),{enableDragging:true});
		mp.addOverlay(marker);
		$("#txtMapSearchKey").val($("#craddress").val());
	}
//	var ncontrol = new BMap.NavigationControl();	
//	mp.addOverlay(ncontrol);	//IE6会出错
	mp.enableScrollWheelZoom();
	mp.setDefaultCursor("pointer");
	mp.addEventListener("click", setmarker);
	ismapinit = 1;
}
//点击事件
function setmarker(e) {
	$("hdnSetLng").val(e.point.lng);
	$("hdnSetLat").val(e.point.lat);
	if (marker != null)
	{
		mp.removeOverlay(marker);
	}
	marker = new BMap.Marker(new BMap.Point(e.point.lng, e.point.lat),{enableDragging:true});
	mp.addOverlay(marker);
}
function search() {
	if ($("#txtMapSearchKey").val() == "")
	{
		alert("请输入要搜索的地址！");
		$("#txtMapSearchKey").focus();
	} else {
		var options = {  
		 onSearchComplete: function(results){  
		   if (local.getStatus() == BMAP_STATUS_SUCCESS){  
			 // 判断状态是否正确  
			 if (results.getCurrentNumPois() > 1)
			 {
				 var searchpoint = results.getPoi(0).point;
				 mp.centerAndZoom(searchpoint,defaultZoom);
				 marker = new BMap.Marker(new BMap.Point(searchpoint.lng, searchpoint.lat),{enableDragging:true});
				mp.addOverlay(marker);
			 }
		   }  
		 }  
		};  
		var local = new BMap.LocalSearch(mp, options);  
		local.search($("#txtMapSearchKey").val());  
	}
}
//处理标签相关
$(function(){
	$("#crlabel").focus(function(){
		if($.trim($("#crlabel").val()) == "多个标签词之间请用空格分开") {
			$("#crlabel").css("color","#000");
			$("#crlabel").val("");
		}
	});
	$("#crlabel").blur(function(){
		if( $.trim($("#crlabel").val()) == "") {
				$("#crlabel").css("color","#CCC");
				$("#crlabel").val("多个标签词之间请用空格分开");
			}
	});
//	$(".labeldel").click(function(){
//		$(this).parent().remove();
//	}); 
});
function removelabel(labelobj) {
	if (labelobj != undefined && $(labelobj).parent() != "")
	{
		$(labelobj).parent().remove();
		savelabels();
	}
}
function addlabel() {
	var maxwords = 50;	//标签最大字数
	var labels = $.trim($("#crlabel").val());
	if (labels != "" && labels != "多个标签词之间请用空格分开")
	{
		var haschange = 0;
		if ($.trim($(".setup").text()) == "您还没有添加任何标签！")
		{
			$(".setup").html("");
			$(".setup").append("<ul class='labelul'></ul>");
		}
		var labelarr = labels.split(" ");
		for(var i = 0; i < labelarr.length; i ++) {
			var labelvalue = $.trim(labelarr[i]);
			if (labelvalue == "")
			{
				continue;
			}
			if(isexists(labelvalue))
				continue;
			var tmplabels = getlabels();
			if ((tmplabels + "," + labelvalue).length > maxwords)
			{
				alert("对不起，所有标签的字数之和不能超过50个字，超出部分标签将无法保存到系统！");
				continue;
			}
			var listr = '<li class="mylabel" onmouseover="this.className=\'mylabel mylabelhover\'" onmouseout="this.className=\'mylabel\'">';
			listr += '<a href="#" title="' + labelvalue + '" class="labelnode">' + labelvalue + '</a>';
			listr += '<a href="javascript:void(0)" onclick="removelabel(this)" title="删除标签" class="labeldel"><img src="/static/tpl/2012/images/transparent.gif" /></a>';
			listr += '</li>';

			$(".labelul").append(listr);
			haschange = 1;
		}
		if(haschange) {
			savelabels();
			$("#crlabel").css("color","#CCC");
			$("#crlabel").val("多个标签词之间请用空格分开");
		}
	}
}
function isexists(labelvalue) {
	var elabels = $(".labelnode");
	for(var i = 0; i < elabels.length; i ++) {
		if($(elabels[i]).html() == labelvalue)
			return 1;
	}
	return 0;
}
function getlabels() {
	var mylabels = "";
	var elabels = $(".labelnode");
	for(var i = 0; i < elabels.length; i ++) {
		if (i == 0)
			mylabels = $(elabels[i]).text();
		else
			mylabels = mylabels + "," + $(elabels[i]).text();
	}
	return mylabels;
}
function savelabels() {
	var mylabels = getlabels();
	$.ajax({
		url:"<?= geturl('troom/setting/upinfo') ?>",
		type:'post',
		data:{'crlabel':mylabels},
		dataType:'text',
		success:function(data){
			if(data!='success'){
				alert("对不起，标签保存失败，请联系e板会客服！");
			}
		}
	});
}
</script>
<?php $this->display('troom/page_footer'); ?>