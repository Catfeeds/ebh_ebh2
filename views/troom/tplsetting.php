<?php $this->display('troom/page_header'); ?>

<script type="text/javascript" src="/static/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="/static/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<style>
.kejian{
	margin-top:50px;
}
.danke{
	margin-left:4px; 
	_margin-left:2px;
	list-style: none;
	height:50px;
	border-bottom: 1px dashed #DCDCDC;
	padding-top:10px;
	cursor:pointer;
}
.danke .stitle{
	margin-left:10px;
}
.sum{
	font-weight:bold;
	font-size:14px;
	margin-left:10px;
	margin-top:2px;
}
.detail{
	color:#999;
	margin-left:10px;
}
.hover{
	background-color: #F2F7FF;
}
.tpls{
	width:752px;
}
.tpls li{
	float:left;
	width:220px;
	margin-left:10px;
	cursor:pointer;
}
.tpls img{
	width:200px;
	height:183px;
	cursor:pointer;
}
</style>
<div class="ter_tit">
当前位置 > 模板设置</div>
<div class="lefrig">

<?php $this->display('troom/tplsetting_menu'); ?>

<div class="annotate" style="color:#888888; margin-left: 20px;"> 您可以选择不同的模板来改变平台首页的外观，不管选择何种模板，您的平台数据都不会丢失，选择完成后请点击保存按钮。</div>
<div class="flopad"><a class="souhuang" href="/" target="_blank">打开首页</a></div>
<div class="kejian">

	<div style="font-size:14px;margin-top:10px;margin-bottom:10px;">
	请选择模板：
	</div>
	<ul class="tpls">
		
		<li>
		<img src="" />
		<span style="margin-left:10px;"><input type="radio" id="tpl$tpl['tplname']" name="mytpl" class="mytpl" value="$tpl['tplname']" /><label for="tpl$tpl['tplname']" class="sum">$tpl['tplname']</label></span>
		</li>

	</ul>
	<div style="clear:both"></div>
	<div class="settip" >
	<div style="margin-top:10px;padding-top:10px;font-size:14px;	border-top:1px solid #CDCDCD;">
	模块显示设置：勾上表示在首页显示,否则不显示。<span style="color:red">（注：此设置目前只对默认模板，即【default】模板有效）</span>
	</div>
	<ul class="liss">
		<li class="danke">
			<span class="stitle"><input type="checkbox" id="chkSummary" $tplarr['s']/><label for="chkSummary" class="sum">显示平台简介</label></span>
			<div class="detail">将平台的简介信息显示在平台首页</div>
		</li>
		<li class="danke">
			<span class="stitle"><input type="checkbox" id="chkMessage" $tplarr['m']/><label for="chkMessage" class="sum">显示平台详细介绍</label></span>
			<div class="detail">将平台的详细介绍信息显示在平台首页</div>
		</li>
		<li class="danke">
			<span class="stitle"><input type="checkbox" id="chkGuide" $tplarr['g']/><label for="chkGuide" class="sum">显示大纲导航</label></span>
			<div class="detail">将所有课件数不为0的课程作为大纲显示在平台首页</div>
		</li>
		<li class="danke">
			<span class="stitle"><input type="checkbox" id="chkFree" $tplarr['f']/><label for="chkFree" class="sum">显示免费试听</label></span>
			<div class="detail">将所有免费的课件显示在平台首页，让用户无需登录和购买即可播放课件</div>
		</li>
		<li class="danke">
			<span class="stitle"><input type="checkbox" id="chkContact" $tplarr['c']/><label for="chkContact" class="sum">显示联系方式</label></span>
			<div class="detail">将平台的联系方式，包括电话、QQ、邮箱、平台价格等信息显示在平台首页</div>
		</li>
	</ul>
	</div>
	<div style="margin-top:15px" class="xgtxBtn"><a class="lanbtn" href="javascript:;">保 存</a></div>
	
	<div class="blanktip" style="height:320px;">
	</div>

	</div>
</div>
<script type="text/javascript">
$(function(){
	$(".btnlogo").click(function(){uptplsetting();});
	$(".danke").hover(function(){$(".danke").removeClass("hover");$(this).addClass("hover")},function(){$(this).removeClass("hover");});
	$(".danke").click(function(e){
		if (e.target.tagName != 'INPUT') {
			var checkid = $(this).find("input").attr("id");
			document.getElementById(checkid).click();
			return false;
		}
	});
	$(".tpls li").click(function(e){
		if (e.target.tagName != 'INPUT') {
			var checkid = $(this).find("input").attr("id");
			document.getElementById(checkid).click();
			if (checkid == "tpldefault")
			{
				$(".settip").css("display","");
			} else {
				$(".settip").css("display","none");
				$(".blanktip").css("display","none");
			}
			return false;
		}
	});

});
function uptplsetting() {
	var crid = $crid;
	var summaryvalue = $("#chkSummary").attr("checked")?1:0;
	var messagevalue = $("#chkMessage").attr("checked")?1:0;
	var guidvalue = $("#chkGuide").attr("checked")?1:0;
	var freevalue = $("#chkFree").attr("checked")?1:0;
	var contact = $("#chkContact").attr("checked")?1:0;
	var tplselect = "";
	var tpl = $(".mytpl");
	for(var i = 0; i < tpl.length; i ++) {
		if($(tpl[i]).attr("checked") == 1) {
			tplselect = $(tpl[i]).val();
			break;
		}
	}
	var setting = {'s':summaryvalue,'m':messagevalue,'g':guidvalue,'f':freevalue,'c':contact};
	$.ajax({
		url:"#getsitecpurl()#?action=teacher",
		type:'post',
		data:{'crid':crid,'setting':setting,'op':'uptplsetting','template':tplselect,'inajax':1},
		dataType:'text',
		success:function(data){
			if(data=='success'){
				$.showmessage({img: 'success',message:'模板设置保存成功',title:'模板设置'});
			}else{
				$.showmessage({img:'error',message:'模板设置保存失败',title:'模板设置'});
			}
		}
	});
}
</script>
<?php $this->display('troom/footer'); ?>