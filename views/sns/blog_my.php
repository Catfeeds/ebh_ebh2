<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		
		<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/sns/css/ftroomv3.css?v=201710201003" />
		<script type="text/javascript" src="http://static.ebanhui.com/snsv2/js/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="http://static.ebanhui.com/snsv2/js/blog_drag.js?v=201710261001"></script>
		<script type="text/javascript" src="http://static.ebanhui.com/snsv2/js/blog_change.js?v=20171030001"></script>
		<title></title>
	</head>
	<body>
		<div class="liert">
			<input type="hidden" id = "_curuid" name="curuid" value="<?=$snsUser['uid']?>" />
			<input type="hidden" id= "_loginuid" name="loginuid" value="<?=$user['uid']?>" />
			<div class="weaktils">
				<ul>
					<li class=""><a href="/sns/feeds.html"><span>新鲜事</span></a></li>
					<li class=""><a href="/sns/photo.html"><span>照片(<em class="reds"><?=$snsUser['photo_count']?></em>)</span></a></li>
					<li class="datek"><a href="/sns/blog.html"><span>日志(<em class="reds"><?=$snsUser['blogsnum']?></em>)</span></a></li>
					<li class=""><a href="/sns/blacklist.html"><span>我的</span></a></li>
		    		<li class="" style="float: right;"><a href="/sns/follow/fans.html"><span>粉丝<em class="ebhlan"> <?=$snsUser['fansnum']?></em></span></a></li>
		            <li class="" style="float: right;"><a href="/sns/follow.html"><span>关注<em class="ebhlan"> <?=$snsUser['followsnum']?></em></span></a></li>
					<div class="stuieu">
						<a href="/sns/blog/add.html" class="fkwejt"></a>
					</div>
				</ul>
			</div>
			<div class="liert">
				<ul>
					<?php $p=0; if(!empty($list)){foreach ($list as $blog){ 
					$blogurl = (($uid>0)?geturl("$uid/blog_view"):geturl("blog/view"))."?bid=".$blog['bid'];
					if($blog['permission'] == 0){
						$permission = '所有人可见';
					}else if($blog['permission'] == 4){
						$permission = '仅自己可见';
					}
					//不显示不对外开放的日志
					/*
					if(!empty($curuser)){
						//权限判断
						$baseinfosModel = $this->model('Baseinfos');
						$result = $baseinfosModel->checkpermission($user['uid'],$curuser['uid'],$blog['permission']);
						if(!$result){
							$p++;
							continue;
						}
					}*/
				?>
				<li class="fketgd" data="<?=$blog['bid']?>">
				<div class="dtejef">
				<?php if($blog['iszhuan']){ ?><span style="color:#9b9b9b; font-size: 14px;font-family: punctuation,微软雅黑,Tohoma;"> [转] </span><?php } ?><a href="/sns/blog/detail.html?bid=<?=$blog['bid']?>&reply=0" class="ewtkjre"><?=shortstr($blog['title'],80)?></a>
				<p class="ksetsd"> <?=$permission?> <?=date('Y-m-d H:i:s',$blog['dateline'])?> 分类：<?=$blog['catename']?></p>
				<p class="ryfbdd"><?=$blog['tutor']?></p>
				<div class="qrtuirth" style="margin:10px 0 0 0;">
				<a class="item replys" href="/sns/blog/detail.html?bid=<?=$blog['bid']?>&reply=1"><i class="ui-icons comment "></i>评论（<?=$blog['cmcount']?>）</a>		
				<a class="item transfers" data="<?=$blog['bid']?>" href="javascript:;"><i class="ui-icons forward"></i>转载（<?=$blog['zhcount']?>）</a>
				<a class="item upclicks" data="<?=$blog['bid']?>" href="javascript:;"><i class="ui-icons praise"></i>赞（<?=$blog['upcount']?>）</a>
				</div>
				<?php
				if($uid>0&&($user['uid']==$uid)){
				?>
				<div class="kejtev">
				<a href="/sns/blog/edit.html?bid=<?=$blog['bid']?>">编辑</a>
				 | 
				<a href="javascript:del(<?=$blog['bid']?>,'1');">删除</a>
				</div>
				<?php } ?>
				</div>
				</li>
				<?php } ?>
				<?php if($p == count($list)){ ?>
				<li style="text-align:center;"><div class="noarticle"></div></li>
				<?php } ?>
				<?php }else{ ?>
				<li style="text-align:center;"><div class="noarticle"></div></li>
				<?php }?>
				</ul>
				<?php if(!empty($count)&&$count>10){?>
				<div class="pages">
				<?=$pagebar?>
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
									<?php foreach($category as $cate){ ?>
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
		<div class="clear"></div>
	</body>
</html>
