<?php $this->display('troomv2/page_header'); ?>
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
.work_mes ul li a{
	color:#666;
	display:block;
	padding:2px 4px !important;
	line-height:21px;
}
.workcurrent a{
	border-radius:2px;
	background:#5e96f5;
}
.workcurrent a span{
	color:#fff;
}
a.title-a{
	background: url(http://static.ebanhui.com/ebh/tpl/default/images/workcurrent.jpg) no-repeat right 0px;
}
</style>
<div class="lefrig">
	<div class="waitite">
		<div class="work_menu" style="position:relative;margin-top:0">
			<ul>
				<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso"><?=$pagemodulename?></span></a></li>
			</ul>
		</div>
		<a href="/troomv2/survey/add.html" target="_blank" style="color:#fff;right:10px;" class="jaddre">添加问卷</a>
	</div>
	<div class="work_mes" style="border-bottom:none;">
		<ul class="extendul">
			<li><a href="/troomv2/survey/my.html"><span>我发布的</span></a></li>
            <li class="workcurrent"><a href="/troomv2/survey.html"><span>其他问卷</span></a></li>
		</ul>
	</div>
	<div class="workdata" style="float:left;margin-top:0;width:1000px;">

		<table width="100%" cellpadding="0" cellspacing="0" class="datatab" style="border:none;">
			<tr class="first">
				<td width="210">问卷名称</td>
				<td width="118">发布人</td>
				<td width="60">参与人数</td>
				<td width="190" style="text-align: center;">开放时间</td>
				<td width="190">关联的课件名称</td>
				<td width="50">操作</td>
			</tr>
		<?php if(!empty($surveylist)){
			foreach($surveylist as $survey){?>
			<tr>
				<td width="210" style="word-break: break-all; word-wrap:break-word;"><img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/<?php echo $classname?>.jpg?v=20160608" class="tyrtrew2s tyrtrew3s" /><a href="/troomv2/survey/preview/<?=$survey['sid']?>.html" target="_blank" style="padding-left:5px;"><?=strip_tags($survey['title'])?></a></td>
				<td width="118"><?php echo $survey['realname']?></td>
				<td style="text-align: center;"><?php echo $survey['answernum']?></td>
				<td width="190"><?=empty($survey['startdate'])?'':date('Y-m-d',$survey['startdate'])?><?=empty($survey['enddate'])?'':' 至 '.date('Y-m-d',$survey['enddate'])?></td>
				<td width="190" style="word-break: break-all; word-wrap:break-word;"><?=$survey['cwname']?></td>
				<td width="50">
<!--				--><?php //if($survey['uid'] == $user['uid']){?>
					<a style="float:left;color:#2696f0;margin-right:20px;" href="/troomv2/survey/stat/<?=$survey['sid']?>.html">统计</a>
<!--				--><?php //}?>
				</td>
			</tr>
			<?php }
				}else{?>
			<tr><td colspan="6" align="center"><div class="nodata"></div></td></tr>
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
		url:'<?=geturl('troomv2/survey/getanswernum')?>',
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
			window.open("/troomv2/survey/edit/"+current_sid+".html");
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
		url:'<?=geturl('troomv2/survey/getanswernum')?>',
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