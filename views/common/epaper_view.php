<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  style="background-color:#f5f5f5;">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $title ?>-精品试题库-e板会</title>
<meta name="keywords" content="e板会,云教育,教育界的淘宝,开教育店,在线教育,无线互联网教育,在线考试,课后作业,电子教室,网络课堂,同步学堂,补课系统,答疑系统,播放器,课件制作软件,微课,微课大师,微课制作软件,微课比赛,小学,初中,高中,大学,语文,英语,数学,地理,物理,化学,生物,历史,政治,名师讲坛,远程教育,考试辅导,考研,外语,英语" />
<meta name="description" content="e板会-全球领先的网络在线资源有偿分享增值服务平台,打造教育界的淘宝,让每个人都能开云教育知识店,提供在线教育,无线互联网教育,同步学习,补课系统,答疑系统,播放器,课件制作软件,微课,微课大师,微课制作软件下载,微课比赛,小学,初中,高中,大学,语文,英语,数学,地理,物理,化学,生物,历史,政治,名师讲坛,远程教育,考试辅导,考研,外语,英语等教学" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2014/css/epaper/base.css" media="screen" />
<?php if($attchInfo['previewtype'] == 1) {?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/flexpaper.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/flexpaper_handlers.js"></script>
<script type="text/javascript">
	$(function(){
		$('#documentViewer').FlexPaperViewer(
			{ config : {
				jsDirectory : 'http://static.ebanhui.com/ebh/js/',
				SWFFile : "/epaper/outputSwf/<?=$lid?>.html",

				Scale : 1.0,
				ZoomTransition : 'easeOut',
				ZoomTime : 0.5,
				ZoomInterval : 0.2,
				FitPageOnLoad : true,
				FitWidthOnLoad : true,
				FullScreenAsMaxWindow : false,
				ProgressiveLoading : false,
				MinZoomSize : 0.2,
				MaxZoomSize : 5,
				SearchMatchAll : false,
				InitViewMode : 'Portrait',
				RenderingOrder : 'flash',
				StartAtPage : '',

				ViewModeToolsVisible : true,
				ZoomToolsVisible : true,
				NavToolsVisible : true,
				CursorToolsVisible : true,
				SearchToolsVisible : true,
				WMode : 'window',
				localeChain: 'zh_CN'
			}}
		);
	});
	</script>
<?php } ?>
<style type="text/css">
.topreg {
width:100%;
border-top:solid 2px #25a0cc;
}
.neigtop {
width:950px;
margin:0 auto;
background:url(http://static.ebanhui.com/ebh/images/epaper/banner.jpg) repeat-x;
height:47px;
padding-top:36px;
padding-left:10px;
}
.maiwfle {
background-color:#fff;
width:958px;
margin:10px auto 0;
border:solid 1px #fff;
}
.maiwfle a.lvbtnl {
width:120px;
height:38px;
display:block;
background-color:#82c617;
line-height:38px;
text-align:center;
font-size:14px;
text-decoration:none;
margin:20px 0 5px 20px;
}
.maiwfle a.lvbtnl:hover {
background-color:#83d601;
color:#3D3D3D;
}
</style>
</head>
<body>
<div class="topreg">
<div class="neigtop">
<!-- <img src="http://static.ebanhui.com/ebh/images/epaper/titjinp.jpg" /> -->
</div>
<div class="maiwfle">
<a href="/epaper/attach.html?lid=<?=$lid?>" class="lvbtnl">下载试卷</a>
<div style="border-top:solid 2px #82c617;width:918px;margin:0 20px">
<?php if($attchInfo['previewtype'] == 1) { ?>
<div id="documentViewer" class="flexpaper_viewer" style="width:918px;height:800px;"></div>
<br />
<?php } else { ?>
            <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="918" height="600" id="Main">
                <param name="movie" value="/epaper/outputSwf/<?=$lid?>.html" />
                <param name="quality" value="high" />
                <param name="bgcolor" value="#869ca7" />
                <param name="allowScriptAccess" value="sameDomain" />
                <param name="allowFullScreen" value="true" />
                <!--
                <param name="wmode" value="opaque" />
                -->
                <!--[if !IE]>-->
                <object type="application/x-shockwave-flash" data="/epaper/outputSwf/<?=$lid?>.html" width="918" height="600">
                    <param name="quality" value="high" />
                    <param name="bgcolor" value="#869ca7" />
                    <param name="allowScriptAccess" value="sameDomain" />
                    <param name="allowFullScreen" value="true" />
                <!--<![endif]-->
                <!--[if gte IE 6]>-->
                	<p> 
                		Either scripts and active content are not permitted to run or Adobe Flash Player version
                		10.0.0 or greater is not installed.
                	</p>
                <!--<![endif]-->
                    <a href="http://www.adobe.com/go/getflashplayer">
                        <img src="/static/images/get_flash_player.gif" alt="Get Adobe Flash Player" />
                    </a>
                <!--[if !IE]>-->
                </object>
                <!--<![endif]-->
            </object>
<?php } ?>

</div>
</div>
</div>

</body>
</html>
</body>
</html>