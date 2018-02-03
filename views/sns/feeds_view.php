<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/sns/css/ftroomv3.css?v=20171101001" />
		<script type="text/javascript" src="http://static.ebanhui.com/snsv2/js/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="http://static.ebanhui.com/sns/js/showmessage/jquery.showmessage.js"></script>
		<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js"></script>
		<script src="http://static.ebanhui.com/sns/js/artDialog/dialog-min.js"></script>	
		<script type="text/javascript" src="http://static.ebanhui.com/sns/js/lazyload/jquery.lazyload.js"></script>
		<script type="text/javascript" src="http://static.ebanhui.com/snsv2/js/echo-reply.js?v=20171025001"></script>
		<script type="text/javascript" src="http://static.ebanhui.com/snsv2/js/echo-drag.js?v=20171025001"></script>
		<script type="text/javascript" src="http://static.ebanhui.com/snsv2/js/common.sns.js?v=2017102601"></script>
		<script type="text/javascript" src="http://static.ebanhui.com/snsv2/js/feeds_view.js?v=20171031001"></script>
		<title></title>
	</head>
	<body>
		<div id="snsBox" style="overflow: hidden;">
			<?php echo $this->display('sns/feeds_view_top');?>
			<input type="hidden" id = "_curuid" name="curuid" value="<?=$snsUser['uid']?>" />
			<input type="hidden" id= "_loginuid" name="loginuid" value="<?=$user['uid']?>" />	
			<div class="weaktils">
				<ul>
					<li class="datek"><a href="/sns/feeds/<?=$snsUser['uid']?>.html"><span>新鲜事</span></a></li>
					<li class=""><a href="/sns/photo/<?=$snsUser['uid']?>.html"><span>他的照片</span></a></li>
					<li class=""><a href="/sns/blog/<?=$snsUser['uid']?>.html"><span>他的日志</span></a></li>
				</ul>
			</div>
			<div class="gtiyle">
				<ul id="feed_list">
					
				</ul>
				<div class="weidgjr" id="notice_loading" style="_padding-top:10px;_height:23px;">
					<span class="notice_loading"> <i class="loading_i"></i>正在加载中</span>
				</div>
				<div id="update-more" class="weidgjr juewg" style="">
					<span class="more_loading" id="more_loading">没有更多动态显示</span>
				</div>
			</div>
			<!-- 评论窗口 -->
			<div class="replyoverlay" style="display:none;background-color: #000;background:#000;opacity:0.2;filter:alpha(opacity=20);position: fixed; left: 0px; top: 0px; z-index: 6000; width: 100%; height:100%;">
			</div>
			<div class="layer replywin" style="display:none">
				<div class="dialogmain">
					<div class="diayer replymove">
						<h2 class="titleh2">评论回复</h2>
						<button class="closedbtn" title="关闭">
							<span class="none">╳</span>
						</button>
					</div>
					<div class="ldsteg">
						<div class="retweet">
							<div class="retweetdtg">
								<textarea class="contentwr layercontent" onkeydown="replykeysend(event);" name="replycontent" id="replycontent" style="resize: none;"></textarea>
							</div>
							<div class="sharepre">
								<div class="etkfds">
									<a class="atticon" href="javascript:;">
										<i></i>
											表情
										<span></span>
									</a>
								</div>
								<input type="hidden" name="reply_fid" id="reply_fid" value="0" />
								<input type="hidden" name="reply_touid" id="reply_touid" value="0" />
								<input type="hidden" name="reply_pcid" id="reply_pcid" value="0" />
				
								<div class="retweeop">
									<input class="gbbtb" id="doreply" type="button" title="同时按下Ctrl+Enter键即可发表" value="发表">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- 转发窗口 -->
			<div class="overlay" style="display:none;background-color: #000;background:#000;opacity:0.2;filter:alpha(opacity=20);position: fixed; left: 0px; top: 0px; z-index: 6000; width: 100%; height:100%;">
			</div>
			<div class="layer win" style="display:none">
				<div class="dialogmain">
					<div class="diayer transfermove">
						<h2 class="titleh2">转发</h2>
						<button class="closedbtn" title="关闭">
							<span class="none">╳</span>
						</button>
					</div>
					<div class="ldsteg">
						<div class="sharetab">
							<span class="tabrrent">
								<span class="tabitewd">我的空间</span>
							</span>
							<div class="transbt"></div>
						</div>
						<div class="retweet">
							<div class="retweetdtg">
								<textarea class="contentwr layercontent" onkeydown="transferkeysend(event);" name="transfercontent" id="transfercontent" style="resize: none;"></textarea>
							</div>
							<div class="sharepre">
								<div class="etkfds">
									<a class="atticon" href="javascript:;">
										<i></i>
											表情
										<span></span>
									</a>
								</div>
								<input type="hidden" name="pfid" id="pfid" value="0" />
								<div class="retweeop">
									<input class="gbbtb" id="dotransfer" type="button" value="发送">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- 表情窗口start -->
			<div class="emotionface">
				<span class="close emoclosedbtn" >×</span>
					<div class="b22">
					<table cellspacing="0" class="datamiss">
					<thead class="tabdmiss"></thead>
					</table>
					</div>
			</div>
			
		</div>
		<script type="text/javascript">
			//Ctrl+Enter发送
			function replykeysend(e){
				var _e = e?e:window.event;
				if (_e.ctrlKey && _e.keyCode == 13) {
					$('#doreply').trigger("click");
				}
			};
			function transferkeysend(e){
				var _e = e?e:window.event;
				if (_e.ctrlKey && _e.keyCode == 13) {
					$('#dotransfer').trigger("click");
				}
			};
		</script>	
	</body>
</html>
