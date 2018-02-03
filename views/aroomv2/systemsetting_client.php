<?php $this->display('aroomv2/page_header'); ?>

<div>
    <div class="ter_tit">
        当前位置 > <a href="<?=geturl('aroomv2/systemsetting')?>">系统设置</a> > 账号登录限制
    </div>
    <div class=" xitongshezhis mt15">
    	<div class="titles">
            <a href="<?=geturl('aroomv2/systemsetting/login')?>" class="aalls">登录限制设置</a>
            <a href="<?=geturl('aroomv2/systemsetting/client')?>" class="aalls  curs">限制情况查看</a>
    	</div>
        <div class="xtsznr">
            <div class="tssuk">
                <div class="diles dile1s">
                    <input id="searchkey" value="<?=empty($q)?'请输入学生姓名或登录账号':$q?>" class="newsou1s"  type="text" onfocus="if($(this).val()=='请输入学生姓名或登录账号')$(this).val('');$(this).css('color','#333')" onblur="if($.trim($(this).val())==''){$(this).val('请输入学生姓名或登录账号');$(this).css('color','#999')}">
                    <input class="soulico1s" type="button" onclick="_search()">
                </div>
            </div>
        </div>
		<div class="clear"></div>
		<div class="dlsbjl">
			<table cellpadding="0" cellspacing="0" class="dlsbables">
				<tr class="first">
					<td width="20%" class="zhanghao">账号</td>
					<td width="20%">姓名</td>
					<td width="40%">已绑定登录设备数量</td>
					<td width="20%" class="caozuo">操作</td>
				</tr>
			<?php if(!empty($clientlist)) {
				foreach ($clientlist as $client) {?>
                <tr>
					<td class="zhanghao"><?=$client['username']?></td>
					<td><?=$client['realname']?></td>
					<td><span><?=$client['clientnum']?></span><a href="javascript:;" class="ckqb" onclick="showclient(<?=$client['uid']?>)">（查看全部）</a></td>
					<td class="caozuo"><a href="javascript:;" class="qcdlsb" onclick="clearclient(<?=$client['uid']?>)">取消登录限制</a></td>
				</tr>
			<?php } } else {?>
                <tr>
					<td colspan="4" align="center">暂无登录设备</td>
				</tr>
			<?php }?>
			</table>
		</div>

		<?=$pagestr?>
    </div>
</div>

<!--清除设备-->
<div id="dialogclear" style="display:none;height:120px;">
    <div class="seeallbot">
    	<input type="hidden" id="clear_uid" value="0" />
    	<p class="zhxms zhxm1s">取消后该学生将解除登录限制<br>是否取消?</p>
    </div>
</div>

<!--修改域名-->
<div id="dialogview" style="display:none;">
    <div class="seeallbot" style="min-height: 180px;">
    	<p class="zhxms">
            <span>账号：</span>
            <span id="info_username"></span> 
            <span class="ml10">姓名：</span>
            <span id="info_realname"></span>
        </p>
        <p class="sblb">
        	<span id="info_clients"></span>
        </p>
    </div>
</div>
<script>
function _search(){
	var searchkey = $('#searchkey').val();
	if(searchkey == '请输入学生姓名或登录账号')
		searchkey = '';
	location.href = '/aroomv2/systemsetting/client.html?q='+searchkey;
}

//查看全部登录设备
function showclient(uid){
	$("#info_username").html();
	$("#info_realname").html();
	$("#info_clients").html();
	$.ajax({
		type: 'POST',
		url: '/aroomv2/systemsetting/showclient.html',
		data: {uid:uid},
		dataType: 'json',
		success: function(data){
			if(data != undefined && data != null & data.status == 1){
				$("#info_username").html(data.info['username']);
				$("#info_realname").html(data.info['realname']);
				$("#info_clients").html(data.info['clients']);
			}
		}
	});
	if(!H.get('dialogview')){
		H.create(new P({
			id : 'dialogview',
			title: '查看全部',
			easy:true,
			width:412,
			padding:5,
			content:$('#dialogview')[0]
		}),'common');
	}

	H.get('dialogview').exec('show');


}

//取消登录限制
function clearclient(uid) {
	if(!H.get('xtips')){
		H.create(new P({
			id:'xtips',
			easy:true,
			padding:10
		}),'common');
	}

	$("#clear_uid").val(uid);
	var button = new xButton();
	button.add({
		value:"确认",
		callback:function(){
			doclear();
			return false;
		},
		autofocus:true
	});

	button.add({
		value:"取消",
		callback:function(){
			H.get('dialogclear').exec('close');
			return false;
		}
	});
	if(!H.get('dialogclear')){
		H.create(new P({
			id : 'dialogclear',
			title: '取消登录限制',
			easy:true,
			width:412,
			padding:5,
			content:$('#dialogclear')[0],
			button:button
		}),'common');
	}

	H.get('dialogclear').exec('show');
}

function doclear() {
	var uid = $("#clear_uid").val();
	$.ajax({
		url:"/aroomv2/systemsetting/clearclient.html",
		type:'post',
		data:{'uid':uid},
		dataType:'json',
		success:function(data){
			if(data != undefined && data != null & data.status == 1){
				H.get('xtips').exec('setContent',data.msg).exec('show').exec('close',500);
				setTimeout(function(){
					window.location.reload();
				},500);
			}else{
				H.get('xtips').exec('setContent',data.msg).exec('show').exec('close',500);
			}
		}
	});

}
</script>


<?php $this->display('aroomv2/page_footer'); ?>