<?php $this->display('aroomv2/page_header'); ?>
<style>
#favicon_upprogressbox{	display:none!important;}
.ui-dialog{border:none; background-color: transparent;}
</style>
<link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/upload.js"></script>

<div>
    <div class="ter_tit">
        当前位置 > <a href="<?=geturl('aroomv2/systemsetting')?>">系统设置</a> > 推广设置
    </div>
    <div class=" xitongshezhis mt15">
    	<div class="titles">
            <a href="javascript:;" class="aalls  curs">基本信息设置</a>
    	</div>
		<div class="clear"></div>
        <div class="xtsznr" style="padding-top:10px; position:relative;">
            <p class="p1s">网站名称：&nbsp;<?= $roominfo['crname'] ?></p>
            <p class="p1s">
                <span>浏览器图标：限JPG、PNG、GIF格式，图片清楚，建议大小32*32</span>
                <a href="javascript:;" class="smsllqtb">什么是浏览器图标？</a>
            </p>
            <div class="smtbll">
            	<div><img src="http://static.ebanhui.com/ebh/tpl/aroomv2/images/llqtb.jpg" width="206" height="57" /></div>
                <div class="llqzs">浏览器图标</div>
            </div>
            <div class="llqtb">
            	<div class="llqtbson" style="border: 1px dashed #c0c0c0;cursor: pointer;">
							<?php $Upcontrol = Ebh::app()->lib('UpcontrolLib');
	$Upcontrol->upcontrol('favicon',12,array(),'pic',array('button_text'=>' ','button_width'=>105,'button_height'=>104,'button_image_url'=>'http://static.ebanhui.com/ebh/tpl/aroomv2/images/sctb2.jpg'));?>
				</div>
                <div class="llqtbr">
                	<p class="p1s">这是你的浏览器图标预览大小</p>
                    <p class="p1s">32*32</p>
                    <div class="tbdx"><img id="faviconimg" <?php if(empty($systemsetting['favicon'])) {?>style="display: none;" <?php }?>width="32" height="32" src="<?=empty($systemsetting['faviconimg'])?'':$systemsetting['faviconimg']?>"><input type="hidden" id="favicon" value="<?=empty($systemsetting['favicon'])?'':$systemsetting['favicon']?>"></div>
                </div>
            </div>
            <div class="clear"></div>
            <div class="bajbq">
            	<p class="p3s">备案及版权信息</p>
            	<div class="seogjc"><input class="seoinput" type="text" name="icp" id="icp" value="<?=empty($roominfo['icp'])?'浙B2-20160787&nbsp;&nbsp;Copyright &copy; 2011-'.date('Y').' ebh.net All Rights Reserved':$roominfo['icp']?>" /></div>
            </div>
        </div>
        <div class="clear"></div>
        <div class="titles mt5">
            <a href="javascript:;" class="aalls  curs">SEO设置</a>
        </div>
		<div class="xtsznr tgsznr">
            <p class="p1s" >-SEO关键词和描述信息：设置后可以让网校更好的在百度等搜索引擎被搜索到。如杭州学军中学，关键词：杭州、学军、中学，描述信息：杭州学军中学,是浙江省一级重点中学、浙江省一级普通高中特色示范学校。</p>
            <p class="p1s ps2s" style="display: none;">-IP黑名单：设置之后可以使被设置的IP地址不能对网校进行正常访问。</p>
            <p class="p1s ps2s">-网站统计：管理员可以随时知道自己网站的被访问情况，每天多少人看了哪些网页，新访客的来源是哪里，用了哪些浏览器登录和在哪些时间段登录等非常有价值的信息数据。<span style="color:#f00;">注意：网站统计分析代码只对独立域名网站有效！</span></p>
            <p class="p1s mt15">SEO关键词：设置多个关键词请用英文半角逗号","隔开。</p>
            <div class="seogjc"><input class="seoinput" type="text" name="metakeywords" id="metakeywords" value="<?=empty($systemsetting['metakeywords'])?'':$systemsetting['metakeywords']?>" /></div>
            <p class="p1s">SEO描述信息：</p>
            <div class="seogjc"><textarea class="seotextarea" name="metadescription" id="metadescription"><?=empty($systemsetting['metadescription'])?'':$systemsetting['metadescription']?></textarea></div>
            <p class="p1s" style="display: none;">IP黑名单：一行一个IP，被加入黑名单的IP将被禁止访问！暂不支持网段的封锁！</p>
            <div class="seogjc" style="display: none;"><textarea class="seotextarea" name="ipbanlist" id="ipbanlist"><?=empty($systemsetting['ipbanlist'])?'':$systemsetting['ipbanlist']?></textarea></div>
            <p class="p1s">网站统计分析代码：将程序代码复制到输入框内，推荐使用<a href="http://tongji.baidu.com/" class="bdtj" target="_blank">百度统计</a>、<a href="http://ta.qq.com/" class="bdtj" target="_blank">腾讯统计</a>、<a href="https://www.umeng.com/" class="bdtj" target="_blank">友盟统计</a>。</p>
            <div class="seogjc"><textarea class="seotextarea" name="analytics" id="analytics"><?=empty($systemsetting['analytics'])?'':$systemsetting['analytics']?></textarea></div>
            <div style="display:inline-block;">
                <a href="javascript:;" class="savebtn" style=" margin-left:300px;">保&nbsp;存</a>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
var uploadComplete = function(file){
	var upfilepath = $("#favicon\\[upfilepath\\]").val();
	if (upfilepath != '') {
		$("#faviconimg").attr("src", upfilepath);
		var index = upfilepath.lastIndexOf('.');
		var iconpath = upfilepath.substr(0, index) + '.ico';
		$("#favicon").val(iconpath);
		$("#faviconimg").show();
	}
}
var fileQueued = function(file){
	if(file['size'] > 1024*1024*2){
		alert('上传失败，图片大小不能超过2M。');
		favicon_swfu.cancelUpload(file['id']);
	}
}
var fileQueueError = function(file,code,message){
	alert('上传失败。');
}

$(".savebtn").click(function(){
	if(!H.get('xtips')){
		H.create(new P({
			id:'xtips',
			title : "信息提示",
			easy:true,
		}),'common');
	}

	var faviconimg = $("#faviconimg").attr("src");
	var favicon = $("#favicon").val();
	var icp = $("#icp").val();
	var metakeywords = $("#metakeywords").val();
	var metadescription = $("#metadescription").val();
	var ipbanlist = $("#ipbanlist").val();
	ipbanlist = ipbanlist.replace(/\n/,",");
	var analytics = $("#analytics").val();

	$.ajax({
		type: 'POST',
		url: '/aroomv2/systemsetting/saveseo.html',
		data: {faviconimg:faviconimg,favicon:favicon,icp:icp,metakeywords:metakeywords,metadescription:metadescription,ipbanlist:ipbanlist,analytics:analytics},
		dataType: 'json',
		success: function(data){
			if(data != undefined && data != null & data.status != null){
				H.get('xtips').exec('setContent','<div class="bccg2">'+data.msg+'！</div>').exec('show').exec('close',1500);
			}
		}
	});
});
</script>


<?php $this->display('aroomv2/page_footer'); ?>