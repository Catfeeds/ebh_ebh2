

<?php 
$this->assign('jquery11',true);
$this->display('aroom/page_header'); ?>
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js?v=20150731"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<style>
.scbtn{
	height:29px;
	line-height:25px;
	background:#18a8f7;
	color:#fff;
	border:1px solid #18a8f7;
	width:92px;
	letter-spacing: 3px;
	margin:7px 10px 10px 10px;
	cursor:pointer;
	float:right;
}
.binput{
	border:1px solid #cdcdcd;
	width:608px;
	height;25%;
	padding:5px;
	margin-top:10px;
}
.sjitds a.fewytg{ display:block; width:85px;}
</style>
<?php 
if(empty($myroom['cface']))
	$cface = 'http://static.ebanhui.com/ebh/tpl/default/images/face/4.jpg';
else
	$cface = $myroom['cface'];

?>
<div class="ter_tit"> 当前位置 > 我的教室 </div>
<div class="lefrig leftou">
<div class="lwtits">
<?php $domain = 'http://'.$this->uri->uri_domain().'.'.$this->uri->curdomain;?>
<h2 class="klits"><?=$myroom['crname']?><span><a href="<?=$domain?>" target="_blank"><?=$domain?></a></span></h2>
</div>
<div class="lstdr">
<div class="akgtre">
<img src="<?=$cface?>" style="width:100px;height:100px;"/>
<a class="listhffg" href="<?= geturl('troom/setting/avatarold') ?>">修改校徽</a>
</div>
<div class="kstiy">
<ul>
<li class="biatkd">学生</li>
<li class="biatkd">老师</li>
<li class="biatkd">班级</li>
<li class="biatkd">课程</li>
<li class="biatkd">课件</li>
<li class="biatkd">作业</li>
<li class="biatkd">答疑</li>
<li class="biatkd">评论</li>
<li><?= $myroom['stunum'] ?></li>
<li><?= $myroom['teanum'] ?></li>
<li><?= $classesnum?></li>
<li><?= $foldernum?></li>
<li><?= $myroom['coursenum']?></li>
<li><?= $myroom['examcount']?></li>
<li><?= $myroom['asknum']?></li>
<li><?= $reviewnum?></li>
</ul>
</div>
</div>
<div class="sjitds">
<div class="srjdys">
基本信息<a href="javascript:void(0)" class="stghft" onclick="editbasic()">编辑</a>
</div>
<p class="jwefir"><span class="kstgds fhont">服务电话</span><span class="kstgds" id="crphone"><?= shortstr($myroom['crphone'],50) ?></span></p>
<p><span class="kstgds">联系地址</span><span class="kstgds" id="craddress"><?= shortstr($myroom['craddress'],50) ?></span>
<input type="hidden" value="<?=$myroom['crphone']?>" id="fullphone"/>
<input type="hidden" value="<?=$myroom['craddress']?>" id="fulladdress"/>
	<?php if(!empty($myroom['lng']) && !empty($myroom['lat'])) { ?>
		<a class="fkwtf" id="maptip" href="javascript:void(0)" onclick="setmap()">已标注</a>
	<?php }else{?>
		<a class="fkwtf" id="maptip" href="javascript:void(0)" onclick="setmap()">未标注</a>
	<?php }?>
</p>
<input type="hidden" id="lng" value="<?= $myroom['lng'] ?>" ><input type="hidden" id="lat" value="<?= $myroom['lat'] ?>" >
</div>
<div class="sjitds">
<div class="srjdys">
网校简介<a href="javascript:void(0)" class="stghft" onclick="editsummary()">编辑</a>
</div>
<p class="ljdrgd" id="summary"><?= $myroom['summary'] ?></p>
<a href="javascript:void(0)" class="fewytg" onclick="showdetail()">编辑详情介绍</a>
</div>
<div class="sjitds">
<div class="srjdys">
网校标签<a href="javascript:void(0)" onclick="showaddlabel()" class="stghft">添加</a>
</div>
<div class="setup">
                <?php if(!empty($myroom['crlabel'])) { 
                    $labelarr = explode(',',$myroom['crlabel']);
                    ?>
		<ul class="labelul">
                <?php foreach($labelarr as $label) { ?>
		<li class="mylabel" onmouseout="this.className='mylabel'" onmouseover="this.className='mylabel mylabelhover'">
		<a class="labelnode" href="javascript:void(0)" title="<?= $label ?>" ><?= $label ?></a>
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
<p class="ljdrgd">什么是标签：标签是平台主要内容的关键描述，学生可以通过搜索标签来找到您的平台。一般都为简短的词，如初中、法律、经济等。所有标签的字数之和不能超过50个字。</p>
</div>

</div>
<div class="ptbiaoq" id="addlabeldiv" style="display:none">
<input id="crlabel" style="float:left; width:94%;margin:15px" class="txtlan" type="text" value="多个标签词之间请用空格分开" /><br/><br/>
<input class="scbtn" style="" type="button" value="取消" onclick="closedialog('addlabel')"/>
<input class="scbtn" style="" type="button" value="确定" onclick="addlabel('addlabel')"/>
</div>
<div id="basicinfodiv" style="display:none;padding:10px">
<span>服务电话：</span><input value="服务电话" id="crphoneinput" class="binput" style=''/><br/>
<span>联系地址：</span><input value="联系地址" id="craddressinput" class="binput" style=''/><br/><br/>
<input class="scbtn" style="" type="button" value="取消" onclick="closedialog('basicinfo')"/>
<input class="scbtn" style="" type="button" value="确定" onclick="savebasic('basicinfo')"/>
</div>

<div id="crsummarydiv" style="display:none">
<textarea id="summaryta" style="padding:5px;width:98%;height:350px; border:1px solid #cdcdcd; line-height:23px; letter-spacing: 2px;">
</textarea>
<input class="scbtn" style="" type="button" onclick="closedialog('summary')" value="取消" />
<input class="scbtn" style="" type="button" onclick="upsummary('summary')" value="确定" />

</div>



<div id="divMapLayer" style="width:500px;height:350px;display:none;">
	<div style="margin-bottom:5px;">
		地址：<input type="text" value="" id="txtMapSearchKey" name="txtMapSearchKey" class="binput" style="width:360px;height:12px;margin-top:0px;font-size:12px" />&nbsp;&nbsp;<input type="button" value="" style="cursor:pointer;background:url(http://static.ebanhui.com/ebh/tpl/2012/images/dingwei1206.png) no-repeat;width:68px;height:22px;border:none;margin-top:5px;" onclick="search()" />
		
	</div>
	<div id="map" style="width:500px;height:325px"></div>
<div>
		  <div class="main_bot"></div>
		</div>
<input class="scbtn" style="" type="button" onclick="closedialog('divMapLayer')" value="取消" />
<input class="scbtn" style="" type="button" onclick="savemap('divMapLayer')" value="确定" />
</div>
<script>
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

	
});
function removelabel(labelobj) {
	if (labelobj != undefined && $(labelobj).parent() != "")
	{
		$(labelobj).parent().remove();
		savelabels();
	}
}
function addlabel(id) {
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
			listr += '<a href="javascript:void(0)" title="' + labelvalue + '" class="labelnode">' + labelvalue + '</a>';
			listr += '<a href="javascript:void(0)" onclick="removelabel(this)" title="删除标签" class="labeldel"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/transparent.gif" /></a>';
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
	closedialog(id);
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
		url:"<?= geturl('aroom/asetting/upinfo') ?>",
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
// function 
function showaddlabel(){
	if(!H.get('addlabel')){
		H.create(new P({
			id : 'addlabel',
			title: '添加标签',
			easy:true,
			width:720,
			padding:5,
			content:$('#addlabeldiv')[0]
		}),'common').exec('show');
		
	}else{
		H.get('addlabel').exec('show');
	}
}

function editbasic(){
	$('#crphoneinput').val($('#fullphone').val());
	$('#craddressinput').val($('#fulladdress').val());
	if(!H.get('basicinfo')){
		H.create(new P({
			id : 'basicinfo',
			title: '基本信息',
			easy:true,
			width:720,
			padding:5,
			content:$('#basicinfodiv')[0]
		}),'common').exec('show');
		
	}else{
		H.get('basicinfo').exec('show');
	}
}
function editsummary(){
	$('#summaryta').html($('#summary').html());
	if(!H.get('summary')){
		H.create(new P({
			id : 'summary',
			title: '网校简介',
			easy:true,
			width:720,
			padding:5,
			content:$('#crsummarydiv')[0]
		}),'common').exec('show');
		
	}else{
		H.get('summary').exec('show');
	}
}
function showdetail(){
	if (window.parent.showdetail != undefined)
	{
		window.parent.showdetail();
	}
}

function upsummary(id){
	var summary=$("#summaryta").val();
	$.ajax({
		url:"<?= geturl('aroom/asetting/upinfo') ?>",
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
						closedialog(id);
                        $("#summary").html("<p>" +summary+ "</>");
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
function savebasic(id){
	var crphone = $('#crphoneinput').val();
	var craddress = $('#craddressinput').val();
	if(oldaddress != craddress)
		addresschanged = true;
	oldaddress = craddress;
	$.ajax({
		url:"<?= geturl('aroom/asetting/upinfo') ?>",
		type:'post',
		data:{'crphone':crphone,'craddress':craddress},
		dataType:'text',
		success:function(data){
			if(data=='success'){
				$('#fullphone').val(crphone);
				$('#crphone').html(shortstr(crphone));
				$('#fulladdress').val(craddress);
				$('#craddress').html(shortstr(craddress));
			}else{
			}
		}
	});
	closedialog(id);
}
function closedialog(id){
	H.get(id).exec('close');
}

var ismapinit = 0;	//是否已加载地图
var defaultZoom = 16;	//默认缩放比例
var mp;	//地图变量
var marker;
function loadBdMap() {
  var script = document.createElement("script");
  script.src = "http://api.map.baidu.com/api?v=1.4&callback=initialize";
  document.body.appendChild(script);
  
}
var oldaddress = '<?=$myroom['craddress']?>';
var addresschanged = false;
function setmap(){
	if(!H.get('divMapLayer')){
		H.create(new P({
			id : 'divMapLayer',
			title: '标注地图',
			easy:true,
			height:400,
			width:505,
			padding:15,
			content:$('#divMapLayer')[0]
		}),'common').exec('show');
	}else{
		H.get('divMapLayer').exec('show');
	}
	
	if (ismapinit == 0)
	{
		
		loadBdMap();
	}
	
	if(addresschanged){
		$("#txtMapSearchKey").val($("#fulladdress").val());
		addresschanged = false;
	}
	
}

function initialize() {
	mp = new BMap.Map('map');
	if ($("#lat").val() == "" || $("#lng").val() == "")
	{
		mp.centerAndZoom("杭州市",defaultZoom);
		if ($("#fulladdress").val() != "")
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
			local.search($("#fulladdress").val());  
			$("#txtMapSearchKey").val($("#fulladdress").val());
		}
	} else {
		mp.centerAndZoom(new BMap.Point($("#lng").val(), $("#lat").val()),defaultZoom);
		marker = new BMap.Marker(new BMap.Point($("#lng").val(), $("#lat").val()),{enableDragging:true});
		mp.addOverlay(marker);
		$("#txtMapSearchKey").val($("#fulladdress").val());
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

function savemap(id){
	if (marker != null)
	{
		var curpoint = marker.getPosition();
		var lng = curpoint.lng;
		var lat = curpoint.lat;
		$("#lng").val(curpoint.lng);
		$("#lat").val(curpoint.lat);
		
		$.ajax({
			url:"<?= geturl('aroom/asetting/upinfo') ?>",
			type:'post',
			data:{'lng':lng,'lat':lat},
			dataType:'text',
			success:function(data){
				if(data=='success'){
					$("#maptip").html("已标注");
					closedialog(id);
				}else{
				}
			}
		});
	}
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
function shortstr(str){
	var result = str.substr(0,25);
	if(result.length<str.length)
		result+= '...';
	return result;
}
</script>
<?php $this->display('aroom/page_footer');?>
