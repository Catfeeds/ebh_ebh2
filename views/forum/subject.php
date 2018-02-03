<?php $this->display('forum/head');?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/forum/css/common.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/forum/css/details.css?v=20170525001" />
<style type="text/css">
	.fabubtntime{
		display: none;
	    width: 78px;
	    height: 32px;
	    line-height: 32px;
	    text-align: center;
	    background: #999;
	    color: #fff;
	    border-radius: 5px;
	    position: absolute;
	    right: 13px;
	    bottom: 15px;
	}
</style>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/qqFace/js/jquery.qqFace.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/forum/js/jquery-browser.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xform.js?v=1"></script>
<input type="hidden" id="sid" value="<?=$subject['sid']?>">
<input type="hidden" id="uid" value="<?=$user['uid']?>">
<input type="hidden" id="max_page" value="1">
<input type="hidden" id="forum_chat" value="<?=$forum['open_chatroom']?>">			
		<div class="details">
			<div class="postedtop">
				<img src="<?=$forum['image']?$forum['image']:'http://static.ebanhui.com/forum/img/community1.jpg'?>" class="postedtopimg" />
                <div class="postedson">
                	<h2 class="posttitle"><?=$forum['name']?></h2>
                    <p class="joinposted joinedbtn" data-fid="<?=$forum['fid']?>" <?php if(!$joininfo){?>style="display:none;" <?php }?>>
                        <span class="joinpostedson">已加入</span>
                        <span class="canceled">取消</span>
                    </p>
                    <p class="post_join joinbtn" data-fid="<?=$forum['fid']?>" <?php if($joininfo){?>style="display:none;" <?php }?> >
                    	<span class="join_img"></span>
       					加入
                    </p>
                    <p class="attentionpost">
                        <span class="attention">关注：</span>
                        <span class="attentionnum"><?=$forum['follow_count']?></span>
                        <span class="attention">帖子：</span>
                        <span class="attentionnum"><?=$forum['subject_count']?></span>
                    </p>
                    <p class="communitybrief">社区简介：<?=$forum['notice']?></p>
                    <p class="moderator">版主：<?php if(isset($forum['manager_name'])){echo implode(',', $forum['manager_name']);}?></p>
                </div>
			</div>
			<div class="master" sid="<?=$subject['sid']?>">
				<div class="floor_left">
					<?php
						$userData['face'] = $subject['face'];
						$userData['sex'] = $subject['sex'];
						$userData['groupid'] = $subject['groupid'];
						$avatar = getavater($userData);
					?>
					<img src="<?=$avatar ?>" />
					<span>楼主</span>
				</div>
				<?php if(!$is_manager && $subject['uid'] == $user['uid']){?>
				<div class="master_cancel"><span></span>删除</div>
				<?php } ?>
				<div class="floor_right">
					<p class="topic"><?=$subject['title']?></p>
					<p class="floor_labe">
						<span class="txt_name"><?=$subject['realname']?></span>
						<span class="txt_time"><?=date('Y-m-d H:i:s',$subject['dateline'])?></span>
					</p>
					<div class="content_txt">
						<?=$subject['content']?>
					</div>	
				</div>
				<div class="master_icon">
					<div class="reply">
						<span class="reply_img"></span>
						<span class="reply_num"><?=$subject['reply_count']?></span>
					</div>
					<div class="browse">
						<span class="browse_img"></span>
						<span class="browse_num"><?=$subject['view_count']?></span>
					</div>
				</div>
			</div>
			<!--评论列表开始-->
			<div class="tourist">
				
				
				
			</div>
			<div class="pages">
   				<div class="listPage" id="pageBox">
				    
   				</div>
  			</div>
				<div id="comment_floor" name="comment_floor">
					<div class="text_top"><span></span>回复楼主</div>
					<div class="text_content">
						<?php $editor->xEditor('content','974px','185px'); ?>
					</div>
					<div class="text_btn" id="reply_btn">发布</div>
					<div class="fabubtntime" id="fabubtntime">发布 <span id="fabunum"></span>s</div>
				</div>
				<div class="fixed"><a href="#comment_floor" name="comment_floor"></a></div>

			</div>
		<script id="tourist_tpl" type="text/html">
		{{each list as value i}}
		<div class="tourist_noce" rid="{{ value.rid }}">
			<div class="floor_left">
				<img src="{{ get_avatar(value.face,value.sex,value.groupid) }}" />
				<p><span>{{ (page - 1) * 20 + i + 1}}</span>楼</p>
			</div>
			<div class="floor_right">
				<p class="floor_labe">
					<span class="txt_name">{{ value.realname }}</span>
					<span class="txt_time">{{ value.dateline | dateFormat:'yyyy年 MM月 dd日 hh:mm:ss'}}</span>
					<p>
						<div class="content_txt">
							{{# value.content }}
						</div>
						<div class="reply_btn" onclick="reply({{ value.rid }},0,this);">
							<a href="#comment_{{ value.rid }}">
							<span class="btn_img"></span>
							回复
							</a>
						</div>
					</div>
					<div class="floor_cancel" style="display:{{ if value.uid != uid }}none{{/if}}"><span></span>删除</div>
					<div class="comment" id="comment_id_{{ value.rid }}">
						{{ if value.children.length > 0 }}
						{{each value.children as childrenreply ii}}
						<div class="comment_once" rid="{{ childrenreply.rid }}">
							<img class="head_img" src="{{ get_avatar(childrenreply.face,childrenreply.sex,childrenreply.groupid) }}" />
							<div class="comment_labe">
								<span class="comment_name">{{ childrenreply.realname }}</span>
								{{ if childrenreply.touid > 0}}
								<span>回复</span>
								<span class="comment_name">{{ childrenreply.to_realname }}</span>
								{{/if}}
								:
								<span class="comment_text">{{#  replace_em(childrenreply.content) }}</span>
								<span class="comment_delete" style="display:{{ if childrenreply.uid != uid }}none{{/if}}">删除</span>
								
							</div>
							<div class="comment_reply">
								<span class="comment_time">{{ childrenreply.dateline | dateFormat:'yyyy年 MM月 dd日 hh:mm:ss'}}</span>
								<span class="comment_btn" onclick="reply({{ value.rid }},{{ childrenreply.uid }},this);" >回复</span>
							</div>
							<div class="once_content">

							</div>
						</div>
						{{/each}}
						{{/if}}
					</div>
					{{ if value.reply_count > 5 }}
					<div class="more">
						<div class="more_content">
							<div class="more_surplus">还有<span class="more_num">{{ value.reply_count - 5}}</span>条回复</div>
							<div class="more_btn" onclick="moreReply({{ value.rid }},1,this);">点击查看</div>
						</div>
					</div>
					
					{{/if}}
					<div id="comment_{{ value.rid }}" class="comment_content" name="comment_{{ value.rid }}">
						
					</div>
				</div>
				{{/each}}
		</script>


		<script id="reply_tpl" type="text/html">
		{{each list as value i}}
		<div class="comment_once" rid="{{ value.rid }}">
			<img class="head_img" src="{{ get_avatar(value.face,value.sex,value.groupid) }}" />
			<div class="comment_labe">
				<span class="comment_name">{{ value.realname }}</span>
				{{ if value.touid > 0}}
				<span>回复</span>
				<span class="comment_name">{{ value.to_realname }}</span>
				{{/if}}
				:
				<span class="comment_text">{{#  replace_em(value.content) }}</span>
				<span class="comment_delete" style="display:{{ if value.uid != uid }}none{{/if}}">删除</span>
			</div>
			<div class="comment_reply">
				<span class="comment_time">{{ value.dateline | dateFormat:'yyyy年 MM月 dd日 hh:mm:ss'}}</span>
				<span class="comment_btn" onclick="reply({{ value.prid }},{{ value.uid }},this);" >回复</span>
			</div>
			<div class="once_content">

			</div>
		</div>
		{{/each}}
		{{ if total > 20}}

		<div class="pages">
	   		<div class="listPage">
	   			{{# makePage(total,page,rid) }}
	   		</div>
	  	</div>
	  	{{/if}}
		</script>
		<!--加入社区-->
		<div id="join_tips">是否要加入该社区</div>
		<!--取消加入-->
		<div id="canceled_tips">是否要退出该社区</div>
		<!--删除回复-->
		<div id="comment_delete_tips">是否删除该条回复</div>
		<!--删除提示-->
		<div id="delete_tips" style="display:none;">是否删除此贴</div>		
	</body>
	<script type="text/javascript" src="http://static.ebanhui.com/forum/js/template.js"></script>
	<script type="text/javascript" src="http://static.ebanhui.com/forum/js/details.js?v=20170525001"></script>
	<script type="text/javascript" src="http://static.ebanhui.com/forum/js/front.js?v=20170407001"></script>
</html>

