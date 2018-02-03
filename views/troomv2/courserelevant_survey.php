<?php $this->display('troomv2/page_header'); ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<style type="text/css">
.datatab{border:none;}
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
<?php if (empty($folder)){?>
<div class="cmain_bottom" style="height:42px;">
	<div class="study" style="border-bottom:none; padding-bottom:0;">
		<div class="study_top" style="background:#fff;">
			<div class="fl"><h3>调查问卷</h3></div>
		</div>
	</div>
</div>
<?php }?>

<div class="lefrig clearfix">
<?php
	$this->display('troomv2/course_menu');
?>
<?php if(!empty($surveylist)){?>
		<table width="100%" cellpadding="0" cellspacing="0" class="datatab" style="border:none;">
			<tr class="first">
				<td width="250">问卷名称</td>
				<td width="95">参与人数</td>
				<td width="125" style="">开放时间</td>
				<td width="200">关联的课件名称</td>
				<td width="50">状态</td>
				<td width="100" style="text-align: center;">操作</td>
			</tr>
		<?php if(!empty($surveylist)){
			foreach($surveylist as $survey){?>
			<tr>
				<td width="250" style="word-break: break-all; word-wrap:break-word;font-size:16px;"><a href="/troomv2/survey/preview/<?=$survey['sid']?>.html" target="_blank"><?=strip_tags($survey['title'])?></a></td>
				<td style="text-align: center;"><?php echo $survey['answernum']?></td>
				<td width="125"><?=empty($survey['startdate'])?'':date('Y-m-d',$survey['startdate'])?><?=empty($survey['enddate'])?'':' 至<br />'.date('Y-m-d',$survey['enddate'])?></td>
				<td width="200" style="word-break: break-all; word-wrap:break-word;"><?=$survey['cwname']?></td>
				<td width="50"><?=$survey['ispublish']==1?'已发布':'未发布'?></td>

			<?php if($survey['uid'] == $user['uid']){?>
				<td width="130">
					<a style="float:left;color:#2696f0;margin-right:20px;" href="/troomv2/survey/stat/<?=$survey['sid']?>.html">统计</a>
					<a class="xiaust" href="javascript:;" onclick="editsurvey(<?=$survey['sid']?>);"></a>
					<a class="shansge" href="javascript:;" onclick="delsurvey(<?=$survey['sid']?>);"></a>
				</td>
				<?php }else{?>
					<td width="130">
					<a style="float:left;color:#2696f0;margin-left:60px;" href="/troomv2/survey/stat/<?=$survey['sid']?>.html">统计</a>
				</td>
				<?php }?>
			</tr>
			<?php }
				}else{?>
			<tr><td colspan="5" align="center">暂无记录</td></tr>
			<?php }?>
		</table>
<?=$pagestr?>
<?php } else {?>
   <?=nocontent()?>
<?php }?>
</div>

<!--编辑问卷对话框-->
<div id="dialogedit" style="display:none">
	<input type="hidden" id="current_sid" value="0" />
	<div class="dialogcont">
		<div class="tishi mt40"><p>确定要编辑该问卷吗?</p></div>
	</div>
</div>
<!--删除问卷对话框-->
<script>
function editsurvey(sid) {
	$("#current_sid").val(sid);
	$.ajax({
		type:'post',
		url:"<?=geturl('troomv2/survey/getanswernum')?>",
		dataType:'json',
		data:{'sid':sid},
		success:function(data){
			if(data!=undefined && data!=null){
				var msg = '';
				if(data>0)
					msg = '你的问卷已收集 '+data+' 份投票，编辑问卷会影响已收集的投票。<br />';
				msg += '确定要编辑该问卷吗?';
				$("#dialogedit .tishi p").html(msg);
			}
		},
		error:function(){
			alert("服务器连接错误，请重试");
		}
	});

	top.dialog({
	title:"编辑问卷",
	content:"确定要编辑该问卷吗?",
	cancel:function () {
		this.close().remove();
	},
	cancelValue:"取消",
	okValue:"确定",
	ok:function(){
		var current_sid = $("#current_sid").val();
		window.open("/troomv2/survey/edit/"+current_sid+".html");
		this.close().remove();
	}
	}).showModal();
}
function delsurvey(sid) {
	$("#current_sid").val(sid);
	$.ajax({
		type:'post',
		url:"<?=geturl('troomv2/survey/getanswernum')?>",
		dataType:'json',
		data:{'sid':sid},
		success:function(data){
			if(data!=undefined && data!=null){
				var msg = '';
				if(data>0)
					msg = '你的问卷已收集 '+data+' 份投票，删除问卷会影响已收集的投票。<br />';
				msg += '确定要删除该问卷吗?';
				$("#dialogdel .tishi p").html(msg);
			}
		},
		error:function(){
			alert("服务器连接错误，请重试");
		}
	});/*
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

	H.get('dialogdel').exec('show');*/
	top.dialog({
	title:"删除问卷",
	content:"确定要删除该问卷吗？",
	cancelValue:"取消",
	cancel:function () {
		this.close().remove();
		return false;
	},
	okValue:"确定",
	ok:function(){
		this.close().remove();
		savedel();
		return false;
	}
	}).showModal();
}

function savedel(){
	var current_sid = $("#current_sid").val();
	$.ajax({
		type:'post',
		url:'<?=geturl('troomv2/survey/delete')?>',
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
$(function(){
    $('.datatab tr:last td').css('border-bottom','none');
});
</script>
<?php $this->display('troomv2/page_footer'); ?>