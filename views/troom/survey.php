<?php $this->display('troom/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<style type="text/css">
.dialogcont{
    height: 100px;
    margin: 0 auto;
    text-align: center;
    width: 339px;
}
.dialogcont .tishi{
    background: url("http://static.ebanhui.com/ebh/tpl/aroomv2/images/ico.jpg") no-repeat scroll 40px center;
    height: 36px;
    margin-left: 0;
    text-align: left;
    width: 339px;
    padding: 0;
    font-weight: normal;
    color:#333;
}
.dialogcont .tishi p {
    padding-left: 90px; font-size: 16px; line-height: 35px;
}
.datatab a,.datatab a:visited {
    color: #666;
}
</style>
<div class="ter_tit">
	当前位置 > <a href="<?=geturl('troom/survey')?>" ?>调查问卷</a> > 全部问卷
</div>
<div class="lefrig" style="background:#fff;margin-top:15px;">
	<div class="work_mes">
		<ul class="extendul">
			<li class="workcurrent"><a href="/troom/survey.html"><span>全部问卷</span></a></li>
			<li><a href="/troom/survey/my.html"><span>我的问卷</span></a></li>
		</ul>
	</div>

	<div style="border-top:none;" class="clearfix" id="icategory">
		<a href="/troom/survey/add.html" target="_blank" style="color:#fff;float:right;" class="questionbutton">添加问卷</a>
	</div>

	<div class="workdata" style="float:left;margin-top:0">

		<table width="100%" cellpadding="0" cellspacing="0" class="datatab" style="border:none;">
			<tr class="first">
				<td width="250">名称</td>
				<td width="200">关联课件</td>
				<td width="88">开放时间</td>
				<td width="38">状态</td>
				<td width="150">操作</td>
			</tr>
		<?php if(!empty($surveylist)){
			foreach($surveylist as $survey){?>
			<tr>
				<td width="250" style="word-break: break-all; word-wrap:break-word;"><a href="/troom/survey/preview/<?=$survey['sid']?>.html" target="_blank"><?=strip_tags($survey['title'])?></a><?php if(!empty($survey['answernum'])){ echo '<span style="color:red">(已有' . $survey['answernum']. '人参与投票)</span>';}?></td>
				<td width="200" style="word-break: break-all; word-wrap:break-word;"><?=$survey['cwname']?></td>
				<td width="88"><?=empty($survey['startdate'])?'':date('Y-m-d',$survey['startdate'])?><?=empty($survey['enddate'])?'':' 至<br />'.date('Y-m-d',$survey['enddate'])?></td>
				<td width="38"><?=$survey['ispublish']==1?'已发布':'未发布'?></td>
				<td width="150">
				<?php if($survey['uid'] == $user['uid']){?>
					<a class="workBtn" href="javascript:;" onclick="editsurvey(<?=$survey['sid']?>);">编辑</a>
					<a class="workBtn" href="javascript:;" onclick="delsurvey(<?=$survey['sid']?>);">删除</a>
				<?php }?>
					<a class="workBtn" href="/troom/survey/stat/<?=$survey['sid']?>.html">统计</a>
				</td>
			</tr>
			<?php }
				}else{?>
			<tr><td colspan="5" align="center">暂无记录</td></tr>
			<?php }?>
		</table>
	</div>
<?=$pagestr?>
</div>

<!--编辑问卷对话框-->
<div id="dialogedit" style="display:none">
	<input type="hidden" id="current_sid" value="0" />
	<div class="dialogcont">
		<div class="tishi mt40"><p>确定要编辑该问卷吗?</p></div>
	</div>
</div>
<!--删除问卷对话框-->
<div id="dialogdel" style="display:none">
	<div class="dialogcont">
		<div class="tishi mt40"><p>确定要删除该问卷吗?</p></div>
	</div>
</div>
<script>
function editsurvey(sid) {
	$("#current_sid").val(sid);
	$.ajax({
		type:'post',
		url:'<?=geturl('troom/survey/getanswernum')?>',
		dataType:'json',
		data:{'sid':sid},
		success:function(data){
			if(data!=undefined && data!=null){
				var msg = '';
				if(data>0)
					msg = '你的问卷已收集 '+data+' 份投票，编辑问卷会删除已收集的投票。<br />';
				msg += '确定要编辑该问卷吗?';
				$("#dialogedit .tishi p").html(msg);
			}
		},
		error:function(){
			alert("服务器连接错误，请重试");
		}
	});

	var button = new xButton();
	button.add({
		value:"确定",
		callback:function(){
			H.get('dialogedit').exec('close');
			var current_sid = $("#current_sid").val();
			window.open("/troom/survey/edit/"+current_sid+".html");
			return false;
		},
		autofocus:true
	});

	button.add({
		value:"取消",
		callback:function(){
			H.get('dialogedit').exec('close');
			return false;
		}
	});
	if(!H.get('dialogedit')){
		H.create(new P({
			id : 'dialogedit',
			title: '编辑问卷',
			easy:true,
			width:400,
			padding:5,
			content:$('#dialogedit')[0],
			button:button
		}),'common');
	}

	H.get('dialogedit').exec('show');
}
function delsurvey(sid) {
	$("#current_sid").val(sid);
	$.ajax({
		type:'post',
		url:'<?=geturl('troom/survey/getanswernum')?>',
		dataType:'json',
		data:{'sid':sid},
		success:function(data){
			if(data!=undefined && data!=null){
				var msg = '';
				if(data>0)
					msg = '你的问卷已收集 '+data+' 份投票，删除问卷会删除已收集的投票。<br />';
				msg += '确定要删除该问卷吗?';
				$("#dialogdel .tishi p").html(msg);
			}
		},
		error:function(){
			alert("服务器连接错误，请重试");
		}
	});
	var button = new xButton();
	button.add({
		value:"确定",
		callback:function(){
			savedel();
			return false;
		},
		autofocus:true
	});

	button.add({
		value:"取消",
		callback:function(){
			H.get('dialogdel').exec('close');
			return false;
		}
	});
	if(!H.get('dialogdel')){
		H.create(new P({
			id : 'dialogdel',
			title: '删除问卷',
			easy:true,
			width:400,
			padding:5,
			content:$('#dialogdel')[0],
			button:button
		}),'common');
	}

	H.get('dialogdel').exec('show');
}

function savedel(){
	var current_sid = $("#current_sid").val();
	$.ajax({
		type:'post',
		url:'<?=geturl('troom/survey/delete')?>',
		dataType:'json',
		data:{'sid':current_sid},
		success:function(data){
			dialogtip();
			if(data!=undefined && data!=null && data==1){
				H.get('xtips').exec('setContent','删除成功').exec('show').exec('close',500);
				window.location.reload();
			}else{
				H.get('xtips').exec('setContent','删除失败').exec('show').exec('close',500);
			}
		},
		error:function(){
			alert("服务器连接错误，请重试");
		}
	});
}
function dialogtip(){
	if(!H.get('xtips')){
		H.create(new P({
			id:'xtips',
			easy:true,
			padding:10
		},{
			onclose:function(){
				location.reload(true);
			}
		}),'common');
	}
}
</script>
<?php $this->display('troom/page_footer'); ?>