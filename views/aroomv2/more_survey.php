<?php $this->display('aroomv2/page_header'); ?>
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
}
.dialogcont .tishi p {
    padding-left: 90px; font-size: 16px; line-height: 35px;
}
.tables td a.taa{
	color: #666 !important;
    text-decoration: none;
}
</style>
<div class="ter_tit">
	当前位置 > <a href="<?=geturl('aroomv2/more')?>">更多应用</a> > 调查问卷
</div>
<div class="kechengguanli">
<div class="kechengguanli_top fr">
		<ul>
			<li class="fl "><a href="/aroomv2/survey/add.html" target="_blank">添加问卷</a></li>
		</ul>
	</div>
	<div class=" clear"></div>
	<div class="kechengguanli_bottom">
		<table cellpadding="0" cellspacing="0" class="tables">
			<tr class="first">
				<td width="250">名称</td>
				<td width="160">显示位置</td>
				<td width="125">开放时间</td>
				<td width="41">状态</td>
				<td width="150">操作</td>
			</tr>
		<?php if(!empty($surveylist)){
			foreach($surveylist as $survey){?>
			<?php
				if($survey['type'] == 2){
					$position = !empty($fnames[$survey['folderid']]) ? ($fnames[$survey['folderid']] .(!empty($survey['cwname']) ? ' > '.$survey['cwname'] : '')) : '';
				}else{
					$position = $typearr[$survey['type']];
				}
			?>
			<tr>
				<td width="250" style="word-break: break-all; word-wrap:break-word;"><a class="taa" href="/troom/survey/preview/<?=$survey['sid']?>.html" target="_blank"><?=strip_tags($survey['title'])?></a><?php if(!empty($survey['answernum'])){ echo '<span style="color:red">(已有' . $survey['answernum']. '人参与投票)</span>';}?></td>
				<td width="160" style="word-break: break-all; word-wrap:break-word;"><?=$position?></td>
				<td width="125"><?=empty($survey['startdate'])?'':date('Y-m-d H:i',$survey['startdate'])?><?=empty($survey['enddate'])?'':' 至 '.date('Y-m-d H:i',$survey['enddate'])?></td>
				<td width="41"><?=$survey['ispublish']==1?'已发布':'未发布'?></td>
				<td width="150">
					<?php if (!in_array($survey['type'], array(4, 5))) { ?>
						<a href="javascript:;" onclick="editsurvey(<?=$survey['sid']?>);">编辑</a>
					<?php } ?>
					<a href="javascript:;" onclick="delsurvey(<?=$survey['sid']?>);">删除</a>				
					<?php if(!empty($survey['answernum'])) {?>
						<a href="/aroomv2/survey/stat/<?=$survey['sid']?>.html">统计</a>
					<?php }?>
				</td>
			</tr>
			<?php }
				}else{?>
			<tr><td colspan="5" align="center">暂无记录</td></tr>
			<?php }?>
		</table>
	</div>
</div>
<?=$pagestr?>

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
		url:'<?=geturl('aroomv2/survey/getanswernum')?>',
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
			window.open("/aroomv2/survey/edit/"+current_sid+".html");
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
		url:'<?=geturl('aroomv2/survey/getanswernum')?>',
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
		url:'<?=geturl('aroomv2/survey/delete')?>',
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
<?php $this->display('aroomv2/page_footer'); ?>
