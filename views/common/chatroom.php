<script>
	
	<?php 
		if($course['uid'] == $user['uid']){
			$is_teacher = true;
			echo 'var is_teacher = true;';
		}else{
			$is_teacher = false;
			echo 'var is_teacher = false;';
		}
	?>
</script>

	<!--聊天室开始-->
		<div id="tall_all" style="z-index:999; position: absolute; left: 1010px;  box-shadow: 0 0 50px 4px rgba(0, 0, 0, 0.2);">
		<div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
			<ul class="layui-tab-title">
				<li class="layui-unselect <?if ($course['open_chatroom'] != 2){?> layui-this<? } ?> tab_li iconfont" style="font-size: 25px;">&#xe6ae;</li>
				<li class="layui-unselect <?if ($course['open_chatroom'] == 2){?> layui-this<? } ?> tab_li iconfont" style="font-size: 25px;">&#xe601;<span class="online_count">(0)</span></li>
				<li class="layui-unselect  tab_li iconfont" style="font-size: 25px;">&#xe636;</li>
			</ul>
			<!--内容区-->		  
			<div class="layui-tab-content">
				<div class="layui-tab-item <?if ($course['open_chatroom'] != 2){?> layui-show<? } ?>" style="background: #fff;">
					
					<div class="notice_min"  <?php if(empty($course['notice'])){?> style="display:none;" <?php } ?> ></div>
					<div class="notice_max"  <?php if(empty($course['notice'])){?> style="display:none;" <?php } ?> >
						<div class="notice_top">
							<p class="title"><span class="title_img"></span><span class="title_txt">【公告】</span></p>
							<p class="close"><span></span></p>
						</div>
						<div class="notice_content">
							<?=$course['notice']?>
						</div>
					</div>

					<!--老师发言-->	
					<div class="tall_one" id="content-list">

					</div>
					<!--用户输入-->		
					<div class="tall_text">
						<div class="tall_text_top">
							<ul class="text_function">
								<li class="layui-this layui-icon tab_li layui-unselect" id="qqface" title="表情" chatroom-event="qqface"></li>
								<li class="layui-icon layim-tool-image tab_li layui-unselect" title="上传图片" chatroom-event="group_chat_img" style="position: relative;"><input type="file" id="group_chat_img" name="Filedata" title=""/></li>
							</ul>
							<?if ($course['open_chatroom'] != 2){?>
							<div class="gag gag_back_on chat_gag" title="点击关闭群聊" <?php if($course['uid'] != $user['uid']){?> style="display:none;" <?php } ?>></div>
							<? } ?>
							<div class="text_font_num"><span>0</span>/100</div>
						</div>
						<textarea id="group-msg-input" style="width:290px;height:74px"></textarea>
						<div class="tall_text_bottom">
							<p>按Enter键发送消息</p>
							<input type="button" value="发送" chatroom-event="sendGroup" />
						</div>
					</div>
					
				</div>
				<!--在线列表-->			 
				<div class="layui-tab-item tall_content_two <?if ($course['open_chatroom'] == 2){?> layui-show<? } ?>" style="background: #fff;">
					<div class="tall_list" id="online-list">


					</div>
					<!--<div class="list_search">
						<input type="text" />
						<div class="search_img layui-icon" style="font-size: 18px; color: #ccc;">&#xe615;</div>
					</div>-->
				</div>
				<!--私聊列表-->
				<div class="layui-tab-item tall_content_three">
					<div class="privatecha_list" id="recent-list">

					</div>


				</div>	
			</div>

			<!--新消息提示-->	
			<div class="tall_news" id="new_message_tips"></div>
		</div>
		</div>
		<!--聊天室结束-->
