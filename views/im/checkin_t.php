<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>点名</title>
		<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/chatroom/css/common.css"/>
		<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/chatroom/css/checkin.css?v=20180123001"/>
		<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js"></script>
		<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/js/dialog/css/dialog.css?v=20170531141918"/>
	</head>
	<style>
		.ui-dialog-content{text-align:center;}
	</style>
	<body>
		<div id="view">
			<div class="progress">
				<div class="sign_bak" style="width:<?=intval(count($checkinlist)/(count($checkinlist)+count($uncheckinlist)) * 100)?>%;"><span class="txt1"><?=intval(count($checkinlist)/(count($checkinlist)+count($uncheckinlist)) * 100)?>%</span></div>
			</div>
			<div class="table">
				<div class="signed clicked" index="0">已签到(<span class="check_count"><?=count($checkinlist)?></span>)</div>
				<div class="signed" index="1">未签到(<span class="uncheck_count"><?=count($uncheckinlist)?></span>)</div>
			</div>
			<div class="signed_box" id="checked_box" style="display:block;">
				<?php
					if(!empty($checkinlist)){
						foreach($checkinlist as $user){
				?>
				<div class="once" id="user_box_<?=$user['uid']?>" online="<?php if(!$user['online']){ ?>0<?php }else{ ?>1<?php } ?>" title="<?=!empty($user['realname']) ? $user['realname'] : $user['username']?> (<?=$user['online'] ? '在线' : '离线'?>) <?=$user['classname']?> <?=$user['mobile']?>">
					<img src="<?=getavater($user)?>"/>
						<p class="name <?php if(!$user['online']){ ?>online<?php } ?>"><?=!empty($user['realname']) ? $user['realname'] : $user['username']?></p>
				</div>
				
				<?php } }?>
				
			</div>
			<div class="signed_box" id="unchecked_box">
				<?php
					if(!empty($uncheckinlist)){
						foreach($uncheckinlist as $user){
				?>
				<div class="once" id="user_box_<?=$user['uid']?>" online="<?php if(!$user['online']){ ?>0<?php }else{ ?>1<?php } ?>" title="<?=!empty($user['realname']) ? $user['realname'] : $user['username']?> (<?=$user['online'] ? '在线' : '离线'?>) <?=$user['classname']?> <?=$user['mobile']?>">
					<img src="<?=getavater($user)?>"/>
						<p class="name <?php if(!$user['online']){?>online<?php } ?>"  ><?=!empty($user['realname']) ? $user['realname'] : $user['username']?></p>
				</div>
				
				<?php } }?>
			</div>
			<div class="_bottom">
				<div class="btn_box">
					<div class="call_btn start_btn" onclick="startCheckin();">开始点名</div>
					<div class="call_btn restart_btn" onclick="restartCheckin()" style="display:none;">重新点名</div>
					<div class="export" onclick="exportData()">导出</div>
					<div class="send_msg <?php if($send_count >= 2){ ?>send_message_disable<?php } ?>">短信通知</div>
				</div>
			</div>
			
			
		</div>
	</body>
	<script type="text/javascript">
		var sendCount = <?=$send_count?>;
		$(function(){
			$(".signed").on("click",function(){
				var num = $(this).attr("index");
				$(".signed").removeClass("clicked");
				$(".signed_box").hide();
				$(this).addClass("clicked");
				$(".signed_box").eq(num).show();
			})
		});
	</script>
	<script type="text/javascript">
       $('.send_msg').on('click',function(){
		   if(sendCount >= 2){
			   return;
		   }
		    var d = dialog({
			  title: '提示',
			  content: '确定要发送提醒短信给未签到的人吗？',
			  okValue: '确定',
			  ok: function () {
				  $.ajax({
					url:'/im/checkin/sms/<?=$cwid?>.html',
					dataType:'json',
					success:function(data){
						if(data.code == 0){
							sendCount++;
							if(sendCount >= 2){
								$('.send_msg').addClass('send_message_disable');
							}
							var dialog1=dialog({
								skin:"ui-dialog2-tip",
								width:350,
								content: "<div class='TPic'></div><p>发送成功！</p>",
								onshow:function(){
									setTimeout(function () {
										dialog1.close().remove();
										if(window.H.get('wxDialog') != null){
											window.H.get('wxDialog').exec('close');
										}
									}, 1000);
								}
							}).show();
						}
					}
				  });
			  },
			  cancelValue: '取消',
			  cancel: function () {}
			});
			d.showModal();
	   });

    </script>
	
	<script>
		var onopen = function(){
			var login_data = {
				type: 'login',
				room_id:<?=$cwid?>,
				auth: '<?=$key?>',
				cmd:'checkin'
			}
			ws.send(JSON.stringify(login_data));
		}
		//消息响应
		var onmessage = function(e){
			var data = eval("(" + e.data + ")");
			switch (data['type']) {
				case 'ping':
					var pong = {};
					pong.type = 'pong';
					ws.send(JSON.stringify(pong));
				break;
				case 'init':
					if(data.room_config.checkin){
						$('.start_btn').hide();
						$('.restart_btn').show();
					}else{
						$('.start_btn').show();
						$('.restart_btn').hide();
					}
				break;
				case 'startcheckin':
					//开始签到事件
					$('.start_btn').hide();
					$('.restart_btn').show();
				break;
				case 'recheckin':
					//重新签到事件
					location.reload();
				break;
				case 'login':
					//用户登录事件
					//$('#user_box_' + data.userinfo.uid).parent.append()
					$('#user_box_' + data.userinfo.uid).find('.name').removeClass('online');
					$('#user_box_' + data.userinfo.uid).attr('online','1');
					$('#user_box_' + data.userinfo.uid).parent().find('.once[online=0]').first().before($('#user_box_' + data.userinfo.uid));
				break;
				case 'leave':
					//用户离开事件
					$('#user_box_' + data.uid).find('.name').addClass('online');
					$('#user_box_' + data.uid).attr('online','0');
				break;
				case 'checkin':
					setUserChecked(data.uid);
				break;
			}
		}
		<?php 
				$websocket_config = Ebh::app()->getConfig()->load('websocket');	
		?>
		var WebSocketAddr = '<?=$websocket_config[0]?>';
		var ws = new WebSocket(WebSocketAddr);
		ws.onopen = onopen;
		// 当有消息时根据消息类型显示不同信息
		ws.onmessage = onmessage;
		
		//开始签到
		var startCheckin = function(){
			var data = {type:'startcheckin',cmd:'checkin'};
			ws.send(JSON.stringify(data));
		}
		//开始签到
		var restartCheckin = function(){
			var data = {type:'recheckin',cmd:'checkin'};
			ws.send(JSON.stringify(data));
		}
		//设置用户为已签到
		var setUserChecked = function(uid){
			$('#checked_box').append($('#user_box_'+uid));
			var checked_length  = $('#checked_box').children().length;
			var unchecked_length = $('#unchecked_box').children().length;
			$('.check_count').html(checked_length);
			$('.uncheck_count').html(unchecked_length);
			var persent = parseInt((checked_length/(checked_length+unchecked_length)) * 100);
			$('.sign_bak').css('width',persent+'%')
			$(".txt1").html(persent+'%');
			
		}
		var exportData = function(){
			location.href = '/im/checkin/export/<?=$cwid?>.html';
		}
	</script>
</html>
