<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<link rel="stylesheet" href="http://static.ebanhui.com/checkin/css/common.css" />
		<link rel="stylesheet" href="http://static.ebanhui.com/checkin/css/checkinview.css" />
		<link rel="stylesheet" href="http://static.ebanhui.com/checkin/css/checkinviewGai.css" />
		<link rel="stylesheet" href="http://static.ebanhui.com/chatroom/layui/css/layui.css">
		<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css?version=20160224001" rel="stylesheet" type="text/css">
		<script src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
		<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="http://static.ebanhui.com/chatroom/js/web_socket.js"></script>
		<script type="text/javascript" src="http://static.ebanhui.com/chatroom/js/reconnecting-websocket.min.js"></script>
	</head>
	<body>
		<div class="checkinview">
			<div class="waitite">
				<div class="work_menu" style="position:relative;margin-top:0">
					<ul>
						<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso">考勤列表</span></a></li>
					</ul>
				</div>	
				<div class="clear"></div>
			</div>
			<?php if(empty($classes)){?>
			<div class="ban"></div>
			<?php } else { ?>
			<form action="/troomv2/attendance/check/<?=$cwid?>.html" class="checkin_form">
				<input type="hidden" name="export" value="0">
				<input type="text" placeholder="搜索账号及姓名" name="name" id="name" value="<?=$this->input->get('name')?>" />
				<select name="classid" id="forum" class="selectinput">
					<option value='' disabled selected style='display:none;'>选择班级</option>  
					<option value='0' <?php if(0 == $this->input->get('classid')){?>selected<?php } ?> >选择班级</option>  
					<?php foreach($classes as $class){ ?>
					<option value="<?=$class['classid']?>"  <?php if($class['classid'] == $this->input->get('classid')){?>selected<?php } ?> ><?=$class['classname']?></option>
					<?php } ?>
				</select>
				<div style="float:left;width:150px;height:24px;margin:0 6px 0 0;">
					<div style="float:left; display:inline;height: 24px;">
						<input type="text" id="startTime" name="startTime" class="readonly" readonly="readonly" style="" placeholder="选择开始时间" onclick="WdatePicker({});" value="<?=$this->input->get('startTime')?>" />&nbsp;&nbsp;&nbsp;&nbsp;
					</div>
				</div>
				<div style="float:left;width:150px;height:24px;margin:0 6px 0 0;">
					<div style="float:left; display:inline;height: 24px;">
						<input type="text" id="endTime" name="endTime" class="readonly" readonly="readonly" style="" placeholder="选择结束时间" onclick="WdatePicker({});" value="<?=$this->input->get('endTime')?>" />&nbsp;&nbsp;&nbsp;&nbsp;
					</div>
				</div>
				<select name="state" id="state" class="selectinput">
					<option value='' disabled selected style='display:none;'>选择学习状态</option>  
					<option value ="0" <?php if(0 == $this->input->get('state')){?>selected<?php } ?> >选择学习状态</option>
  					<option value ="1" <?php if(1 == $this->input->get('state')){?>selected<?php } ?> >已学习</option>
  					<option value ="2" <?php if(2 == $this->input->get('state')){?>selected<?php } ?> >未学习</option>
				</select>
				<button type="button" class="search_btn" value="搜索">搜索</button>
				<button type="button" class="export" value="导出">导出</button>
				<button class="load" value="刷新"  >刷新</button>
			</form>
			<table class="datatab" width="100%" cellspacing="0" cellpadding="0">
				<tr style="background: #eef1f6;">
					<th class="first">账号</th>
				    <th class="class_num">班级</th>
				    <th>学习状态</th>
				    <th class="into">进入课堂</th>
				    <?php if($course['live_type'] == 4){?>
				    <th>操作</th>
				    <?php } ?>
				</tr>
				<?php foreach($list as $user){ ?>
				<tr>
					<td class="user checkin_list">
						<img class="face_img" src="<?=getavater($user)?>" alt="" />
						<div class="user_view">
							<p><span><?=$user['realname']?></span>
							<?php if( $user['sex'] == 0){?>
							<img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/man.png" alt="" />
							<?php } else {?>
							<img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/women.png" alt="" />
							<?php } ?>
							</p>
							<p class="user_txt"><?=$user['username']?></p>
						</div>
					</td>
					<td class="class_num checkin_list"><?=$user['classname']?></td>
					<td class="study_stauts">
						<?php if($user['jointime'] > 0){?>
							已学习
						<?php } else {?>
							未学习
						<?php } ?>
					</td>
					<td class="into checkin_list">
						<?php if($user['jointime'] > 0){?>
							<?=date('Y-m-d H:i:s',$user['jointime'])?>
						<?php } else {?>
							--
						<?php } ?>
					</td>
					<?php if($course['live_type'] == 4){?>
					<td>
						<span class="question checkin_list" user='<?=json_encode($user)?>'>提问</span>
					</td>
					<?php } ?>
				</tr>
				<?php } ?>
				
			</table>
			<?=$pagestr?>
			<?php } ?>
		</div>
	</body>
<script src="http://static.ebanhui.com/chatroom/layui/layui.js"></script>
<style>
	.layim-chat-system, .layim-send-set {
		display: none!important;
	}
	body .layui-layer-title {
		font-family: 'Microsoft YaHei';
	}
	
	.layer-con {
		text-align: center;
		line-height: 137px;
		font-family: 'Microsoft YaHei';
		font-size: 14px;
	}
	.historical div {
		margin: 0 auto;
		width: 240px;
	}
	.historical span {
		margin-top: -5px;
		display: inline-block;
		width: 70px;
		border-bottom: 1px solid #ccc;
	}
	.historical .viewhist {		
		width: 100px;
		border-bottom: 0;
		font-size: 12px;
		text-align: center;
		color: #20A0FF;
		cursor: pointer;
	}
	.layim-chat-tool .layim-tool-face{
		display: none;
	}
</style>
<style id="layuiSuspend">
	body .layui-layim-min{
		/*right: 0!important;*/
		top: 500px!important;
		/*left: auto!important;*/
	}	
</style>
<script>

	$(function() {
		<?php if($course['live_type'] == 4){?>// 判断是否是伪直播
		// ---------------- 以上提问 --------------------
		var ws // websocket对象
		var chatTtem // 当前聊天窗口
		var stopClass = false; // 是否停止上课
		var room_id = <?= $this->uri->itemid?> // 房间id
		var stuList = <?=json_encode($list)?>; // 学生信息表
		var me = <?=json_encode($userinfo)?>; // 当前班主任信息
		var sruId = ''
		var toAvatar = '' // 学生头像
		var onopenStute = false
		<?php 
			$websocket_config = Ebh::app()->getConfig()->load('pushwebsocket');  
		?>
		layui.use('layim', function(layim) {
            var question = {
            	init: function () {
            		var self = this
            		self.initLayim() // 初始化layim
            		self.initMine() // 初始化本人信息
            	    self.initWebSocket() // 初始化webSocket
            		self.bindEvent() // 绑定物理操作事件
            	},
            	initLayim: function () { // 初始化layim，声明layim监听事件
            		var self = this
            		layim.config({ // 关闭简约模式				
						brief: false
					})            		
					layim.on('sendMessage', function(res) {// 发送消息						
						var mine = res.mine
						var to = res.to
						var data = {
							type: to.type,
							uid: to.id, 
							msg: mine.content,
							username: mine.username,
				      		avatar: mine.avatar 
						};
						if (onopenStute) {
							ws.send(JSON.stringify(data));
						} else {
							layer.open({
		            			title:'提示',
							  	type: 1, 
							  	shade: 0,
							  	area: ['260px', '180px'],
							  	content: '<div class="layer-con">消息发送失败，请稍后再试</div>' 
							})
						}						
					})
					layim.on('chatChange', function(obj) {
					    chatTtem = obj.elem
					    if (chatTtem.find('.historical').length < 1) {
					   		chatTtem.find('ul').prepend('<div class="historical"><div><span></span><span class="viewhist">查看历史消息</span><span></span></div></div>') // 获取历史数据 todolist 
					    }
					})
            	},
            	initMine: function () { // 初始化本人信息
					var cache = layim.cache() // 本地缓存数据
					cache.mine = {  // 初始化班主任信息
						"username": me.realname, //我的昵称
						"id": me.uid, //我的ID
						"status": "online", //在线状态 online：在线、hide：隐身
						"sign": "", //我的签名
						"avatar": me.face || (me.sex == 0? 'http://static.ebanhui.com/ebh/tpl/default/images/t_man_50_50.jpg' : 'http://static.ebanhui.com/ebh/tpl/default/images/t_woman_50_50.jpg')//我的头像
					}
            	},
            	initWebSocket: function () { // 初始化webSocket
            		var self = this
            		ws = new ReconnectingWebSocket('<?=$websocket_config[0]?>');
					ws.onopen = self.onopen; 
					ws.onerror = self.onerror;
		            ws.onmessage = self.onmessage;
            	},
            	onopen: function () { // 连接建立时发送登录信息
            		onopenStute = true
            		var data = {
				    	type: 'login',
				    	auth: '<?=$this->input->cookie('auth');?>',
				    	room_id: room_id
				    }

		            ws.send(JSON.stringify(data));
            	},
            	onmessage: function (e) { // 服务端发来消息时
            		var data = eval('('+ e.data +')');		  
				    var obj = {}   
				    switch (data['type']) {
				    	case 'ping':
				    		obj = {type:'pong'};
				      		ws.send(JSON.stringify(obj))
				      		break;
				      	case 'repeat_login':
		                	ws.close();
		                    layer.msg('当前账号已在别处上线，您被迫下线。');
		                    break;
				      	case 'randomask': // 私聊				      		
				      		switch (data.status) {
				      			case 101: // 学生不在线
				      				var from =  data.from
				      				if (from.uid == me.uid) {
						      			obj = {
							      			username: '系统消息',
							      			avatar: 'http://static.ebanhui.com/ebh/tpl/default/images/m_man_120_120.jpg', // 替换为系统头像
							      			id: data.to.uid,
							      			type: data.type,
							      			content: '学生暂未上线，请稍后联系'
								        }
								        layim.getMessage(obj)
								    }
				      			break
				      			case 102: // 不在上课时间
					      			var from =  data.from
					      			if (from.uid == me.uid) {
						      			obj = {
							      			username: '系统消息',
							      			avatar: 'http://static.ebanhui.com/ebh/tpl/default/images/m_man_120_120.jpg', // 替换为系统头像
							      			id: data.to.uid,
							      			type: data.type,
							      			content: '请在上课时间内提问'
								        }
								        layim.getMessage(obj)
								        stopClass = true
								    }
				      			break
				      			case 0:  // 老师接收学生信息
				      				if (data.dtype == 'userchat') { // 学生回答
				      					var user = data.from
				      					var to =  data.to
				      					if (to.uid == me.uid) {
							      			obj = {
								      			username: user.realname,
								      			avatar: user.avatar || toAvatar,
								      			id: user.uid,
								      			type: data.type,
								      			content: data.msg
									        }
									        sruId = user.uid
									        // layim.chat(obj);
									        layim.getMessage(obj)
								        }
				      				} else if (data.dtype == 'system') { // 系统返回，学生是否在线
				      					toAvatar = data.to.avatar
				      				}		
				      			break
				      		}
					        
				      		break;
				    }
            	},
            	onerror: function (e) { // 服务端链接错误
            		console.log(e)
            		onopenStute = false
            	},
            	bindEvent: function () { // 绑定物理操作事件
            		var self = this
            		var your = {
            			type: 'randomask'
            		}
				    $('.question.checkin_list').on('click', function () { // 点击发起提问
				    	var user = eval('(' + $(this).attr('user') + ')');
				    	your = {
					        name: user.realname,// 老师姓名
					        type: 'randomask', // 聊天类型
					        avatar: user.face ? user.face : user.sex == '1' ? 'http://static.ebanhui.com/ebh/tpl/default/images/m_woman_120_120.jpg' : 'http://static.ebanhui.com/ebh/tpl/default/images/m_man_120_120.jpg' ,
					        id: user.uid // 老师ID
					     }
					    self.ajaxGetChatRecord(your, false)					   
					    if (chatTtem.find('.historical').find('.viewhist').eq(0).text() == '查看历史消息') { // 判断是否获取历史记录 
					   		self.ajaxGetChatRecord(your, true)
					    }
					})

					$(document).on("click", '.viewhist', function () { // 点击历史消息，获取记录
						if (chatTtem.find('.historical').find('.viewhist').eq(0).text() == '查看历史消息') { // 判断是否获取历史记录 
							your.id = sruId
							self.ajaxGetChatRecord(your, true)
						}
					})					
					// var top = parseInt(parent.$('#mainFrame').offset().top)
					// var ht = parseInt(parent.$(parent.window).height())
					// var scroll = parseInt(parent.$(parent.window).scrollTop())
				 //    var docHeight = parseInt($('html').height())
 				// 	var layuiSuspend = $('#layuiSuspend')
 				// 	// console.log(docHeight)
					// layuiSuspend.html('body .layui-layim-min{top: ' + (ht - top + scroll - 54) + 'px!important;}')						
					// $(parent.window).scroll(function(event) {
					// 	var scrollTop = parseInt($(this).scrollTop())
					// 	if (scrollTop <= (docHeight - 523)) {
					// 		layuiSuspend.html('body .layui-layim-min{top: ' + (ht - top + scrollTop - 54) + 'px!important;}')
					// 	} else {
					// 		layuiSuspend.html('body .layui-layim-min{top: ' + (ht - top + (docHeight - 523 -54)) + 'px!important;}')
					// 	}
					// });
            	},
            	ajaxGetChatRecord: function (your, bloo) { // 获取聊天记录 todolist
            		var self = this
            		if (bloo) { // 是否异步获取服务端聊天记录
            			var viewhist = chatTtem.find('.viewhist')
	            		viewhist.css('color', '#20A0FF')
	            		viewhist.html('获取中...')
            			$.ajax({ 
            				type: "post",
							url: "/im/im/getHistory.html",
							dataType: "json",
							data: {
								cwid: <?=$cwid?>,
								uid: your.id
							},	             
							success:function(res){
								var local = layui.data('layim')[me.uid]; //获取当前用户本地数据
								var timestamp = 999999999999999999
								if (JSON.stringify(local) != '{}' && local) {
									var chatlog = local.chatlog
									if (chatlog) {
										timestamp = chatlog[your.type + your.id][0].timestamp
									}
								}
																
								var chatData = res								
								viewhist.css('color', '#ccc')
								if (chatData.length < 1) {
									viewhist.html('暂无历史消息')
								} else {
									var student = ''
									for (var j = 0, jen = stuList.length; j < jen; j++) {
										var jtem = stuList[j]
										if (your.id == jtem.uid) {
											student = jtem;
											break;
										}
									}									
									viewhist.html('以上为历史消息') 									
									var chatHtml = '' 
									for (var i = 0, len = chatData.length; i < len; i++) {
										var item = chatData[i]
										if (item.type) { //  去除老数据，线上可以删掉
											if (item.dateline * 1000 > timestamp) { // 历史记录中筛选出本地聊天的记录
												continue;
											}
											if (item.type == 'system') {
												chatHtml += '<li>'
												         +    '<div class="layim-chat-user">'
												         +      '<img src="http://static.ebanhui.com/ebh/tpl/default/images/m_man_120_120.jpg">'
												         +      '<cite>系统消息<i>' + self.getTimeFormat(item.dateline) + '</i></cite>'
												         +    '</div>'
												         +    '<div class="layim-chat-text">' + item.msg + '</div>'
												         +  '</li>'
											} else if(item.from == me.uid) { // 判断是否是本人的聊天记录
												chatHtml += '<li class="layim-chat-mine">'
												         +    '<div class="layim-chat-user">'
												         +      '<img src="' + (me.face || (me.sex == 0? 'http://static.ebanhui.com/ebh/tpl/default/images/t_man_50_50.jpg' : 'http://static.ebanhui.com/ebh/tpl/default/images/t_woman_50_50.jpg')) + '">'
												         +      '<cite><i>' + self.getTimeFormat(item.dateline) + '</i>' + me.realname + '</cite>'
												         +    '</div>'
												         +    '<div class="layim-chat-text">' + item.msg + '</div>'
												         +  '</li>'
											} else {
												chatHtml += '<li>'
												         +    '<div class="layim-chat-user">'
												         +      '<img src="' + (student.face || (student.sex == 0 ? 'http://static.ebanhui.com/ebh/tpl/default/images/m_man_120_120.jpg' : 'http://static.ebanhui.com/ebh/tpl/default/images/m_woman_120_120.jpg')) + '">'
												         +      '<cite>' + student.realname + '<i>' + self.getTimeFormat(item.dateline) + '</i></cite>'
												         +    '</div>'
												         +    '<div class="layim-chat-text">' + item.msg + '</div>'
												         +  '</li>'
											}
											// todolist： 去除本地数据、2、解绑事件
										}
									}
									chatTtem.find('ul').prepend(chatHtml); // 插入聊天记录
									// 聊天界面滚动到底部
									var layimMain = chatTtem.find('.layim-chat-main');
									var scrollHeight = layimMain.prop("scrollHeight");
									chatTtem.find('.layim-chat-main').scrollTop(scrollHeight, 200);
								}				
							}
            			})
            		} else {

            			var local = layui.data('layim')[me.uid]; //获取当前用户本地数据  	
            			if(local) {
	            			delete local.chatlog; 
							//向localStorage同步数据
							layui.data('layim', {
							  key: me.uid,
							  value: local
							});		
						}	              			         			
						
            			self.initChatPopup(your)
            		}            		
            	},
            	initChatPopup: function (your) {
            		layim.chat(your); // 打开聊天窗口 
            		$('.layim-chat-textarea').find('textarea').attr('maxlength', 100);
       //      		if (stopClass) { // 非上课时间禁止发送信息，并弹框提示。
       //      			var sendBtn = $('.layim-send-btn')
       //      			sendBtn.attr('layim-event', '0') // 是否禁止发送
       //      			sendBtn.css('background-color','#ccc') 
       //      			sendBtn.on('click', function() {
       //      				layer.open({
		     //        			title:'提示',
							//   	type: 1, 
							//   	shade: 0,
							//   	area: ['260px', '180px'],
							//   	content: '<div class="layer-con">请在上课时间内!</div>' 
							// })
       //      			})
       //      		}     		
            	},
            	getTimeFormat: function (date) { // 时间格式转换
            		if (date) {
				        var now = new Date(date * 1000),
				        year = now.getFullYear(),
				        month = (now.getMonth() + 1) < 10 ? '0' + (now.getMonth() + 1) : now.getMonth() + 1,
				        date = now.getDate() < 10 ? '0' + now.getDate() : now.getDate()
				        hour = now.getHours() < 10 ? '0' + now.getHours() : now.getHours(),
				        minute = now.getMinutes() < 10 ? '0' + now.getMinutes() : now.getMinutes(),
				        second = now.getSeconds() < 10 ? '0' + now.getSeconds() : now.getSeconds();
					       
	            		return year + "-" + month + "-" + date + '  '+ hour + ":" + minute + ":" + second
            		} else {
            			return ''
            		}
            	}
            }

            question.init() // 提问初始化入口
		});
		// ---------------- 以上提问 --------------------
		<?php }?>		
		var mainFrame = parent.document.getElementById('mainFrame');
		var allH = document.body.offsetHeight + 50;
		mainFrame.style.height = allH + "px";
		$('.search_btn').on('click',function(){
			$('input[name="export"]').val(0);
			$('.checkin_form').submit();
		});
		$('.load').on('click',function(){
			$('input[name="export"]').val(0);
			$('.checkin_form').submit();
		});
		$('.export').on('click',function(){
			$('input[name="export"]').val(1);
			$('.checkin_form').submit();
		});
		$('.selectinput').change(function(){
			$('input[name="export"]').val(0);
			$('.checkin_form').submit();
		});
	})  
</script>	
</html>
