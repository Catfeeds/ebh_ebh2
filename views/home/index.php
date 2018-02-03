<?php 
	$this->display('home/home_header');
	if($this->input->cookie('refer')) {
		$mainurl = urldecode($this->input->cookie('refer'));
	}
	else {
		
		$mainurl = geturl('home/profile/profile') ;
	}
	
	if(preg_match('/largedb/i',$mainurl)){
		$seak ='largedb'; 
	}else{
		$seak ='profile';
	} 
	$this->input->setCookie('refer','');
 ?>
<div class="wrap">
	<div class="cmain clearfix">
		<?php $this->assign('seak',$seak);?>
		<?php $this->display('home/home_left'); ?>
		<div class="cright">
		<iframe onload="resetmain('<?=$seak?>')" id="mainFrame" name="mainFrame" scrolling="no" width=100% height=100% frameborder=0 src="<?= $mainurl ?>"></iframe>
		</div>
	</div>
	<div class="clear"></div>
</div>
<script src="http://static.ebanhui.com/ebh/js/swfobject.js" type="text/javascript"></script>
 <div id="flvwrap" style="display:none;">
     <div id="flvcontrol"></div>
 </div>
<script>
var resetmain = function(){
	try{
		var mainFrame = document.getElementById("mainFrame");
		var iframeHeight = Math.min(mainFrame.contentWindow.window.document.documentElement.scrollHeight, mainFrame.contentWindow.window.document.body.scrollHeight)+1;
		iframeHeight = iframeHeight<700?700:iframeHeight;
		$(mainFrame).height(iframeHeight);
	}catch(e){
			}
}
var tofolder = function(folderid){
	var mainFrame = document.getElementById("mainFrame");
	var theurl = '<!--{eval echo geturl("myroom/coursewarelist-1-0-0-".$crid."-'+folderid+'-find")}-->';
	mainFrame.src=theurl;
	//.tofolder(folderid);
}
function showimage(selector) {
	$(selector,document.getElementById('mainFrame').contentWindow.document).lightBox();
}
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
<?php 
$this->display('home/home_footer'); 
?>