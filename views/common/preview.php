<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $title ?></title>
<meta name="keywords" content="<?= empty($subkeywords) ? $this->get_keywords() : $subkeywords ?>" />
<meta name="description" content="<?= empty($subdescription) ? $this->get_description() : $subdescription?>" />
<style type="text/css" media="screen">
   html, body	{ height:100%; }
   body { margin:0; padding:0; overflow:auto; }
   #flashContent { display:none; }
.lefrig .previewBtn{
	border: none;
	display: block;
	float: right;
	font-size: 14px;
	margin-right: 4px;
	width: 120px;
	height: 38px;
	line-height: 38px;
	text-align: center;
	color: #FFFFFF;
	background: #18a8f7;
	text-decoration: none;
	cursor: pointer;
}
.lefrig a.previewBtn {border:none;display:block;float:right;font-size: 14px;margin-right:4px;width: 120px;height: 38px;line-height: 38px;text-align:center;color:#FFFFFF;background:#18a8f7;text-decoration:none;cursor: pointer;}
.lefrig a.previewBtn:hover{background:#0d9be9;color:#fff;text-decoration: none;}
.lefrig a.previewBtn:visited {color:#fff;}
</style>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
    <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/flexpaper.js"></script>
    <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/flexpaper_handlers.js"></script>
	<script type="text/javascript">
	$(function(){
		$('#documentViewer').FlexPaperViewer(
			{ config : {
				jsDirectory : 'http://static.ebanhui.com/ebh/js/',
				SWFFile : '<?= $url ?>',

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
</head>
<body>
<div style="width:960px;height:800px;margin:0 auto;" class="lefrig">
<div id="documentViewer" class="flexpaper_viewer" style="width:960px;height:800px;"></div>
<br />
<a class="previewBtn" href="<?= $downurl ?>" target="_blank">下载文档</a>
</div>
<?php
debug_info();
?>
<!-- 统计代码开始 -->
<?php EBH::app()->lib('Analytics')->get('baidu')?>
<!-- 统计代码结束 -->
</body>
</html>
