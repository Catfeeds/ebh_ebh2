<?php $this->display('aroom/room_header');
if($this->input->cookie('refer'))
	$mainurl = urldecode($this->input->cookie('refer'));
else
	$mainurl = $haspower == 2 ? geturl('aroom/tlist') : geturl('aroom/asetting');
$this->input->setCookie('refer','');
?>
<!--[if lte IE 6]>  
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/DD_belatedPNG_0.0.7a.js"></script>  
<script type="text/javascript">  
  DD_belatedPNG.fix('.menubox ul li i,.extendbox ul li i,.bottom,.cservice img,.sukan .xinke span,.sukan .zuoye span,.sukan .zhibo span,.sukan .jieda span'); 
</script>  
<![endif]-->
<script src="http://static.ebanhui.com/ebh/js/jquery/jquery.fileDownload.js?version=20150307001"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js?v=20150731"></script>
<script type="text/javascript">

var resetmain = function(){
	var mainFrame = document.getElementById("mainFrame");
	var iframeHeight = Math.min(mainFrame.contentWindow.window.document.documentElement.scrollHeight, mainFrame.contentWindow.window.document.body.scrollHeight)+50;
	iframeHeight = iframeHeight<665?665:iframeHeight;
	$(mainFrame).height(iframeHeight);
}

$(function(){
	var myroomitem_li =$(".myroomitem li");
	myroomitem_li.hover(function(){
		$(this).addClass("itemcurr");
	},function(){
		$(this).removeClass("itemcurr");
	})
})
function showdetail() {
	var src = "<?= geturl('troom/setting/upmessage') ?>";
	//src = src + "?t=" + Math.random();

	if ($("#dislog").attr("src") != src)
	{
		$("#dislog").attr("src",src);
	}
	
	H.create(new P({
		id:'dialogdiv',
		url:src,
		width:968,
		height:720,
		title:'平台详细介绍修改',
		easy:true
	}),'common').exec('show');

}
function closedetail(status) {
	H.get('dialogdiv').exec('close');
	$("#dislog").attr("src","about:blank");
}

//===========导出组件================
/**
 *依赖jquery.js common2.js?version=20150528001 jquery.fileDownload.js
 */
var exportTools = function(url){
	this.url = url;
	this.init();
}
exportTools.loadModal = function(off_on){
	if(off_on){
		if(H.get('loadDialog')){
			H.get('loadDialog').exec('setContent','正在为您导出，请耐心等待').exec('show');
		}else{
			H.create(new P({
				content:'正在为您导出，请耐心等待',
				id:'loadDialog',
				easy:true,
				padding:20
			}),'common').exec('show');
		}
	}else{
		H.get('loadDialog').exec('setContent','导出成功').exec('close',500);
	}
};
exportTools.delcookie = function(name){
    var exp = new Date();    
    exp.setTime(exp.getTime() - 1);   
    var cval=exportTools.getcookie(name);   
    if(cval!=null) document.cookie= name + "="+cval+";expires="+exp.toGMTString();   
} 
exportTools.getcookie = function(name){   
    var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));    
    if(arr != null){   
        return unescape(arr[2]);   
    }else{   
        return "";   
    }   
}
exportTools.prototype = {
	init:function(){
	},
	setUrl:function(url){
		this.url = url;
	},
	run:function(){
		this.doexport();
	},
	setSuccessCallback:function(sCallback){
		this.successCallback = sCallback;
	},
	setPrepareCallback:function(pCallback){
		this.prepareCallback = pCallback;
	},
	doexport:function (){
		var me = this;
		var tag = new Date().getTime();
		this.requrl = this.url+"&tag="+tag;
		this.prepareCallback(this.requrl);
		$.fileDownload(this.requrl,{
			'successCallback':me.successCallback,
			'cookieName':'ebh_export',
			'cookieValue':tag
		});
	},
	successCallback:function(url){
		exportTools.loadModal(0);
		exportTools.delcookie('ebh_export');
	},
	prepareCallback:function(url){
		exportTools.loadModal(1);
	} 
	
}
//===========导出组件结束================
</script>
<script>
/**
*播放视频
*/
function playflv_top(source,cwid,title,isfree,num,height,width,hasbtn,callback){
	var url = source+"attach.html?examcwid="+cwid;
	url = encodeURIComponent(url);
	if(hasbtn == undefined)
		hasbtn = 0;
	var vars = {
		source: url,
		type: "video",
		streamtype: "file",
		server: "",
		duration: "52",
		poster: "",
		autostart: "false",
		logo: "",
		logoposition: "top left",
		logoalpha: "30",
		logowidth: "130",
		logolink: "http://www.ebanhui.com",
		hardwarescaling: "false",
		darkcolor: "000000",
		brightcolor: "4c4c4c",
		controlcolor: "FFFFFF",
		hovercolor: "67A8C1",
		controltype: 1,
		classover: hasbtn
	};
	H.create(new P({
		title:'视频播放',
		easy:true,
		flash:HTools.pFlash({'id':'playflv','uri':"http://static.ebanhui.com/ebh/flash/videoFlvPlayer.swf",'vars':vars})
	}),'common').exec('show');
}
</script>
<div class="wrap">
<div class="cmain clearfix">
<?php $this->display('aroom/room_left')?>
	<div class="cright">
			<iframe onload="resetmain()" id="mainFrame" name="mainFrame" scrolling="no" width=100% height=100% frameborder=0 src="<?=$mainurl?>"></iframe>
	</div>
	</div>
<div id="dialogdiv" style="display:none">
<iframe width="100%" height="100%" frameborder="0" src="about:blank" id="dislog" name="dialog"></iframe>
</div>
<div class="clear"></div>
</div>
<?php $this->display('troom/room_footer')?>