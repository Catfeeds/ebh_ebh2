<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/sns/css/ftroomv3.css?v=20171020002" />
		<script type="text/javascript" src="http://static.ebanhui.com/snsv2/js/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="http://static.ebanhui.com/snsv2/js/blog_change.js?v=20171031001"></script>
		<script type="text/javascript" src="http://static.ebanhui.com/snsv2/js/bolg_reply.js?v=20171031001"></script>
		<script type="text/javascript" src="http://static.ebanhui.com/snsv2/js/blog_drag.js?v=20171026001"></script>
		<title></title>
	</head>
	<body>
		<div id="snsBox" style="overflow:hidden;">
		<div class="liert">
			<input type="hidden" name="bid" id="bid" value="<?=$blog['bid']?>" />
			<div class="dtejef" style="border:none;position:relative;">
			<h2 class="tifhe"><?php if($blog['iszhuan']){ ?> [转] <?php } ?><?=$blog['title']?></h2>
			<div class="bcontent  rtsdfdg"><?=$blog['content']?></div>
			<div class="qrtuirth" style="margin:10px 0 0 0;">
			<a class="item reply" data="<?=$blog['bid']?>" href="javascript:;"><i class="ui-icons comment"></i>评论（<?=$blog['cmcount']?>）</a>		
			<a class="item transfers" data="<?=$blog['bid']?>" href="javascript:;"><i class="ui-icons forward"></i>转载（<?=$blog['zhcount']?>）</a>
			<a class="item upclicks" data="<?=$blog['bid']?>" href="javascript:;"><i class="ui-icons praise"></i>赞（<?=$blog['upcount']?>）</a>
			</div>
			<?php if($snsUser['uid'] == $user['uid']){ ?>
			<div class="kejtev">
			<a href="/sns/blog/edit.html?bid=<?=$blog['bid']?>">编辑</a>
			|
			<a href="javascript:del(<?=$blog['bid']?>,'0');">删除</a>
			</div>
			<?php } ?>
			</div>
			<div class="piagne">
			<ol id="reply_list" class="reply_list">
			<?php if(!empty($blog['replys'])){foreach($blog['replys'] as $key=>$reply){?>
			<?php $reply['message'] = json_decode($reply['message'],1); ?>
			<li class="jgrety" <?php if($key == 0){ ?> style="border-top:solid 1px #e3e3e3" <?php } ?> data-cid="<?=$reply['cid']?>" data-fromuid = "<?=$reply['fromuid']?>">
			<div class="gkejrg">
			<a href="<?=geturl($reply['message']['fromuser']['uid']."/main")?>" target="_blank" class="regewgr"><img  src="<?=getavater($reply['message']['fromuser'],'40_40')?>" /></a>
			<div class="fldot">
			<p class="dfegtr">
			<?php if(($reply['fromuid']!=$reply['touid'])&&($reply['pcid']>0) ){?>
			<a href="<?=geturl($reply['message']['fromuser']['uid']."/main")?>" target="_blank">
			<span style="color:#ed8563;"><?=$reply['message']['fromuser']['realname']?></span>
			</a> 
			回复 
			<a href="<?=geturl($reply['message']['touser']['uid']."/main")?>" target="_blank">
			<span style="color:#ed8563;"><?=$reply['message']['touser']['realname']?></span>
			</a>：
			<?php }else{?>
			<a href="<?=geturl($reply['message']['fromuser']['uid']."/main")?>" target="_blank">
			<span style="color:#ed8563;"><?=$reply['message']['fromuser']['realname']?></span>
			</a> ：
			<?php }?>
			<?=emotionreplace($reply['message']['content'])?>
			</p>
			<p class="ryasc"><?=gettimestr($reply['dateline'])?></p>
			</div>
			</div>
			<!-- 自己发表的才可以删除 -->
			<?php if($reply['fromuid']==$user['uid']){?>
			<a href="javascript:;" class="sfahnt replydel">删除</a>
			<?php }?>
			<a href="javascript:;" class="hustst reply">回复</a>
			</li>
			<?php }?>
			<?php }?>
			</ol>
			<?php if($blog['cmcount']>10){?>
			<div class="weidgjr" style="text-align:left">
			<a href="javascript:;" class="getreplymore" style="margin-left:17px;color:#ed8563">查看更多评论</a>
			</div>
			<?php }?>
			</div>
			
			<!---转发--->
			<div class="overlay" style="display:none;background-color: #000;background:#000;opacity:0.2;filter:alpha(opacity=20);position: fixed; left: 0px; top: 0px; z-index: 6000; width: 100%; height:100%;"></div>
			<div class="layer win" style="width:330px;display:none">
				<div class="dialogmain">
					<div class="diayer transfermove">
						<h2 class="titleh2">转载文章</h2>
						<button class="closedbtn" title="关闭">
							<span class="none">╳</span>
						</button>
					</div>
					<div class="ldsteg" style="background:none">
						<div class="pop-copy-blog">
							<p class='form_select'>
								<label>转载到：</label>
								<select id="cateselect">
									<?php foreach($cates as $cate){ ?>
								  		<option value="<?=$cate['cid']?>"><?=$cate['catename']?></option>
									<?php } ?>
								</select>
							</p>
							<p class='form_select'>
								<label>权限：</label>
								<select id="perselect">
									<option value='0'>公开日志</option>
									<option value='4'>私密日志</option>
								</select>
							</p>
						</div>
						<div class="qz_dialog_layer_ft">
							<div class="sharepre">
								<input type="hidden" name="_bid" id="_bid" value="<?=$blog['bid']?>">
								<input type="hidden" name="islist" id="islist" value="0">
								<div class="retweeop">
									<input class="gbbtb" id="docancel" type="button" value="取消">
								</div>
								<div class="retweeop">
									<input class="gbbtb" id="dotransfers" type="button" value="确定">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!---评论--->
			<div class="bloverlay" style="display:none;background-color: #000;background:#000;opacity:0.2;filter:alpha(opacity=20);position: fixed; left: 0px; top: 0px; z-index: 6000; width: 100%; height:100%;"></div>
			<div class="layer blwin" style="display:none">
				<div class="dialogmain">
					<div class="diayer blcmmove">
						<h2 class="titleh2">评论回复</h2>
						<button class="closedbtn blclosedbtn" title="关闭">
							<span class="none">╳</span>
						</button>
					</div>
					<div class="ldsteg">
						<div class="retweet">
							<div class="retweetdtg">
								<textarea class="contentwr layercontent" onkeydown="blogreplykeysend(event);" name="_blcontent" id="_blcontent" style="resize: none;"></textarea>
							</div>
							<div class="sharepre">
								<div class="etkfds">
									<a class="atticon" href="javascript:;">
										<i></i>
											表情
										<span></span>
									</a>
								</div>
								<input type="hidden" name="reply_touid" id="reply_touid" value="0" />
								<input type="hidden" name="reply_pcid" id="reply_pcid" value="0" />
								<div class="retweeop">
									<input class="gbbtb" id="docomment" type="button" value="发表">
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
		</div>
		<script type="text/javascript">
			//Ctrl+Enter发送
			function blogreplykeysend(e){
				var _e = e?e:window.event;
				if (_e.ctrlKey && _e.keyCode == 13) {
					$('#docomment').trigger("click");
				}
			}
		</script>
	</body>
</html>
