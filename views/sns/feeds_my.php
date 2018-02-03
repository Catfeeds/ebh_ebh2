<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/sns/css/ftroomv3.css?v=20171101002" />
		<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/sns/js/artDialog/ui-dialog.css" />
		<script type="text/javascript" src="http://static.ebanhui.com/snsv2/js/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="http://static.ebanhui.com/sns/js/showmessage/jquery.showmessage.js"></script>
		<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js"></script>
		<script src="http://static.ebanhui.com/sns/js/artDialog/dialog-min.js"></script>	
		<script type="text/javascript" src="http://static.ebanhui.com/sns/js/lazyload/jquery.lazyload.js"></script>
		<script type="text/javascript" src="http://static.ebanhui.com/snsv2/js/echo-reply.js?v=20171025001"></script>
		<script type="text/javascript" src="http://static.ebanhui.com/snsv2/js/echo-drag.js?v=20171025001"></script>
		<script type="text/javascript" src="http://static.ebanhui.com/snsv2/js/common.sns.js?v=20171025001"></script>
		<script type="text/javascript" src="http://static.ebanhui.com/snsv2/js/feeds_my.js?v=20171027001"></script>
		<title></title>
	</head>
	<body>
		<div id="snsBox" style="overflow: hidden;">
			<input type="hidden" id = "_curuid" name="curuid" value="<?=$snsUser['uid']?>" />
			<input type="hidden" id= "_loginuid" name="loginuid" value="<?=$user['uid']?>" />
			<input type="hidden" id="_type" name="_type" value="myschool">
			<input type="hidden" id="_newCount" name="_newCount" value="0">	
			<div class="weaktils">
			<ul>
				<li class="datek"><a href="/sns/feeds.html"><span>新鲜事</span></a></li>
				<li class=""><a href="/sns/photo.html"><span>照片(<em class="reds"><?=$snsUser['photo_count']?></em>)</span></a></li>
				<li class=""><a href="/sns/blog.html"><span>日志(<em class="reds"><?=$snsUser['blogsnum']?></em>)</span></a></li>
				<li class=""><a href="/sns/blacklist.html"><span>我的</span></a></li>
	    		<li class="" style="float: right;"><a href="/sns/follow/fans.html"><span>粉丝<em class="ebhlan"> <?=$snsUser['fansnum']?></em></span></a></li>
	            <li class="" style="float: right;"><a href="/sns/follow.html"><span>关注<em class="ebhlan"> <?=$snsUser['followsnum']?></em></span></a></li>
			</ul>
			</div>
			<div class="rshuit">
				<div class="mafe" style="display:none">
					<span class="close" id="emotionclosed">×</span>
					<div id="b2">
						<div>
							<table cellspacing="0" class="datamis">
								<thead class="tabdmis">
						
								</thead>
							</table>
						</div>
					</div>
				</div>
				<textarea class="gieges" name="textarea2" id="textarea2" onkeydown="keySend(event);"></textarea>
				<a href="javascript:;" class="biage"></a>
				<form id="imgForm" enctype="multipart/form-data" target="hide_creation_upload_iframe" action="/publish/upload.html" method="post" style="display:block">
				<a href="javascript:;" class="glitus" id="Button1"><object type="application/x-shockwave-flash" data="http://www.ebh.net/static/flash/MultiImageUploadv2.swf?version=2388497630" id="Button1_swf_1145229564" style="visibility: visible;" width="50" height="15"><param name="menu" value="false"><param name="scale" value="noScale"><param name="allowFullscreen" value="true"><param name="allowScriptAccess" value="always"><param name="bgcolor" value="#fff"><param name="quality" value="high"><param name="wmode" value="Opaque"><param name="flashvars" value="xmlurl=http://www.ebh.net/static/flash/xml/webData.xml"></object></a>
				</form>
				<a href="javascript:;" id="publishbtn" class="dthnbtn" title="同时按下Ctrl+Enter键即可发表">发 表</a>
				<div class="ketggs">
			      	<ul id="imgthumlist">
			    
				  	</ul>
			  	</div>
	
			</div>
			<div class="juewg">
				<div class="felef">最近访客</div>

				<ul>
					<?php 
						$visitorCount = 0;
						foreach($snsUser['visitor']['list'] as $visitor){
						$visitor = unserialize($visitor);
					?>
					<li class="rejerh">
						<a href="/sns/feeds/<?=$visitor['uid']?>.html">
						<span class="fetmin"><?=$visitor['name']?></span>
						<img class="kuan50" src="<?=$visitor['face']?>">
						<span class="ketged"><?=date('m-d',$visitor['time'])?></span></a>
					</li>
					<?php 
						$visitorCount++;
						if($visitorCount >=15){
							break;
						}
					} ?>
					
				</ul>
			</div>
			<div class="juewg">
				<div class="feed_tab_hover">
					<span class="feed_hover_text">全部动态</span>
					<i class="ui-icon"></i>
					
				</div>
				<div class="weidgjr" id="notice_show" style="">
					<a class="yansed" id="notice_count" href="javascript:;" data="1"> </a>
				</div>
				<div class="gergs friend_feed_control">
						<a href="javascript:;" data="myschool" class="fewjgf">全部动态</a>
						<a href="javascript:;" data="myfollow" class="fewjgf">我的关注</a>
						<a href="javascript:;" data="myclass" class="fewjgf">我的班级</a>
					</div>
			</div>
			<div class="gtiyle">
				<ul id="feed_list" style="overflow:hidden;">
					
				</ul>
			</div>
			<div class="weidgjr" id="notice_loading" style="_padding-top:10px;_height:23px;">
				<span class="notice_loading"> <i class="loading_i"></i>正在加载中</span>
			</div>
			<div class="weidgjr" id="data_null" style="_padding-top:10px;_height:23px;">
				<span class="notice_loading">无更多内容</span>
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
			//创建文本域索引
			var dataindex = 0;
			//处理开始
			function ajaxstart(){
				$('#publishbtn').text('');
				$('#publishbtn').addClass('load');
			}
	
			//处理结束
			function ajaxend(){
				$('#publishbtn').text('发表');
				$('#publishbtn').removeClass('load');
			}
			
				//获取已上传图片张数
				function getImagelen(){
					var len = $('#imgthumlist li').length;
					return len;
				}
	
				//flash调用js提示
				function calltips(type){
					var msg = '上传失败';
					switch (type){
					 	case 0 : msg = '文件过大,单张图片不能超过2m';
					 	break;
					 	case 1 : msg = '图片数量不能超过9张';
					 	break;
					 	case 2:msg = '图片上传失败,请刷新后重试';
					 	break;
					}
					//'图片数量不能超过9张'
					top.$.showmessage({
						img : 'error',
						message:msg,
						title:'通知信息'
					});
				};
				
				//删除图片
				function imgclosed(o){
					var inputindex = o.getAttribute('data-index');
					var inputsel = '#imgForm input[data-index='+inputindex+']';
					var gid = $(inputsel).val();
					$.ajax({
						type: "POST",	
						url:'/sns/publish/delimg.html',
						data:{gid:gid},
						success: function(data){
							$(inputsel).remove();
							$(o).parent().remove();
						},			
						dataType:'json'
					})	
				};
				//flash图片上传完成回调
				function callImageUpload(data){
					var input = html = '';
					var curlen = $('#imgthumlist li').length;
					if(data.success){
						var totallen = data.gid.length + curlen;
						if(totallen > 9){
							data.gid.length = 9 - curlen;
							top.$.showmessage({
								img : 'error',
								message:'图片数量不能超过9张',
								title:'通知信息'
							});
						}
						for(var i=0;i<data.gid.length;i++){
							html += "<li class=\"ghelds\">";
							html += "<img width='100px' height='100px' src='"+data.thum[i]+"'>";
							html += "<a href=\"javascript:void(0);\" onclick=\"imgclosed(this);\" class=\"bhrti\" data-index=\""+dataindex+"\"></a>";
							html += "</li>";
							input += "<input name=\"imgid\" value=\""+data.gid[i]+"\" data-index=\""+dataindex+"\" oriurl=\""+data.path[i]+"\" type=\"hidden\">";
							$('#imgthumlist').append(html);
							$('#imgForm').append(input);
							dataindex++
							input = html = '';
						}
					}else{
						top.$.showmessage({
							img : 'error',
							message:'图片上传失败',
							title:'通知信息'
						});
					}
					ajaxend();
				};
				function keySend(e){
					var _e = e?e:window.event;
					if (_e.ctrlKey && _e.keyCode == 13) {
						$('#publishbtn').trigger("click");
					}
				};
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
						$('#dotransfer').trigger("click")
					}
				};
			
			//发表
			
		</script>
	</body>
</html>
