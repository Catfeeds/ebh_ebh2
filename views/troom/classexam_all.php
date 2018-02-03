<?php $this->display('troom/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen">
<style>
.ter_tit a.previewBtn {display:block;float:right;margin-right:10px;margin-top:5px;*margin-top:-30px;width:67px;height:22px;line-height:22px;text-align:center;color:#FFFFFF;background:#18a8f7;text-decoration:none;cursor: pointer;}
.ter_tit a.previewBtn:hover {background:#0d9be9;color:#fff;text-decoration: none;}

.completetime i{display:inline-block;height: 8px;width: 7px;line-height: 8px;margin-left:5px;background: url(http://static.ebanhui.com/ebh/tpl/default/images/orderbg.png) no-repeat 0 <?= $sort==1?"-7px":"0"?>;}
.totalscore i{display:inline-block;height: 8px;width: 7px;line-height: 8px;margin-left:5px;background: url(http://static.ebanhui.com/ebh/tpl/default/images/orderbg.png) no-repeat 0 <?= $sort==3?"-7px":"0"?>;}

</style>

<div class="ter_tit">
	当前位置 > <a href="<?= geturl('troom/classexam') ?>" >班级作业</a> > <a href="<?= geturl('troom/classexam/my-0-0-0-'.$myclass['classid']) ?>"><?= $myclass['classname'] ?></a> > 作业批阅
	<a href="/troom/classexam/examexcel-0-0-0-<?= $myclass['classid'];?>-<?= $myexam['eid'];?>.html" class="addbtnas previewBtn">导 出</a>
	<a  id="docorrect" class="addbtnas previewBtn">批量评语</a>
	<a href="javascript:location.reload();" class="addbtnas previewBtn">刷 新</a>
</div>

<div class="lefrig">
		<!--弹窗-->
		<div class="clear"></div>
		<div style="margin-top:15px;display: none;overflow: hidden;color:#969696;background:#fff;padding:10px;" class="formdiv">
		<form action="<?= geturl('troom/classexam/correct') ?>" method="post" id="form" >
		<input type="hidden" name="dopost" value="correct" />
		<input type="hidden" name="aidarr" id="aidarr"  value="" /> 
		<input type="hidden" name="classid" value="<?=$myclass['classid']?>" />
		<input type="hidden" name="eid" value="<?=$myexam['eid']?>" />
		<input type="hidden" name="totalscore" id="totalscore"  value="<?=$myexam['score']?>" />
		<input type="hidden" name="status" id="status" value="<?=($myexam['answercount']==$myexam['correctcount'])?1:0?>" />
		<h2 style="font-size:14px;font-weight:bold;color:#666;">批量设置评语</h2>
		<p style="margin-left:20px;height:39px;line-height:39px;">分数区间：<input type="text" name="startscore" id="startscore" style="border: 1px solid #a0b5bb;width:62px;text-align:center;height:20px;line-height:20px;" /> 到 <input type="text" name="endscore" id="endscore" style="border: 1px solid #a0b5bb;width:62px;text-align:center;height:20px;line-height:20px;" /> (<span style="color:red;">*</span> 总分 <?=$myexam['score'] ?>分)
		<span><label><input type="checkbox" style="vertical-align:middle;" id="doall" /> 全部</label></span>
		</p>
		<p><span style="float:left;width:80px;text-align: right;">评语：</span><textarea style="height:150px;width:500px;" name="remark" id="remark"></textarea></p>
		<p><input type="button" value="提 交" style="cursor:pointer;margin-left:80px;margin-top:6px;height:28px;line-height:28px;width:87px;" class="replyBtn"></p>
		</form>
		</div>
		<!--弹窗-->
	<div class="workol" style="background:none; margin-top:15px;">
		<table width="100%" class="datatab">
			<thead class="tabhead">
			  <tr class="">
			<th>作业名称</th>
			<th>时间</th>
			<th>分数</th>
			<th>题数</th>
			<th>答题人数</th>
			<th>批阅人数</th>
			  </tr>
			</thead>
			 <tbody>
				  <tr>
					<td width="40%"><?= shortstr($myexam['title'],60) ?></td>
					<td width="20%"><?= date('Y-m-d H:i:s',$myexam['dateline']) ?></td>
					<td width="10%"><?= $myexam['score'] ?></td>
					<td width="10%"><?= $myexam['quescount'] ?></td>
					<td width="10%"><?= $myclass['stunum'].'/'.$myexam['answercount'] ?></td>
					<td width="10%"><?= $myexam['answercount'].'/'.$myexam['correctcount'] ?></td>
				  </tr>
				<tr>
			</tbody>
		</table>

		
<script type="text/javascript">
$(function(){
	//批量批阅表单显示
	$("#docorrect").click(function(){
		$('#form')[0].reset()
		$(".formdiv").toggle();
	});
	//修改分值区间描红
	$("#endscore,#startscore").change(function(){
		doSelect();
	});
	//选择全部
	$("#doall").change(function(){
		var checked = $(this).attr("checked");
		var totalscore =$("#totalscore").val();
		if(checked){
			$("#startscore").attr("value",0);
			$("#startscore").attr("readonly",true);
			
			$("#endscore").attr("value",totalscore);
			$("#endscore").attr("readonly",true);
			$("#startscore, #endscore").css({'background-color':'#ccc'});
		}else{
			$("#startscore, #endscore").attr("value",0);
			$("#startscore, #endscore").attr("readonly",false);
			$("#startscore, #endscore").css({'background-color':''});
		}
		doSelect();
	})

	//表单提交
	$(".replyBtn").click(function(){
		var startscore = $.trim($("input[name=startscore]").val());
		var endscore = $.trim($("input[name=endscore]").val());
		var remark = $.trim($("#remark").val());
		var totalscore = $.trim($("#totalscore").val());
		var aidarr = $("#aidarr").val();
		if(aidarr==''){
			alert('你已经完成所有评语设置!\n或者等有新作业提交时再来设置!');
			return false;
		}
		if(startscore==''||endscore==''||remark==''){
			alert('请完整填写分数区间或评语!');
			return false;
		}
		if(/^\d+$/.test(startscore)==false || /^\d+$/.test(endscore)==false){
			alert('分数区间必须是数字!');
			return false;	
		}
		if(startscore>endscore){
			alert('分数区间开始值不大于截止值');
			return false;	
		}
		if(startscore>totalscore||endscore>totalscore){
			alert('分数区间值不能大于作业总分'+totalscore);
			return false;	
		}
		var formdata = $("#form").serialize();
		if(!confirm("确定批量设置评语吗?")){
			return false;
			}
		$.post('<?= geturl('troom/classexam/correct') ?>',formdata,function(json){
			if(json.code){
				alert('成功设置 '+json.nums+' 份作业评语');
				location.reload();
			}else{
				alert('批量设置评语失败!\n你可以修改分值区间重新设置!');
				}
			},'json');
	});
});

/**
 * 对应区间内的作业描红
 */
function doSelect(){
	var startscored = $("#startscore").val();
	var endscore = $("#endscore").val();
	var aidArr = new Array();
	$(".classexams tr").each(function(){
			var score = $(this).find('td').eq(4).html();
			score = parseFloat(score);
			var comment = $(this).find('td').eq(5).html();
			var aid = $(this).attr("aid");
			
			//alert(score);
	if(score>=startscored && score<=endscore){
		var size = $(this).find('td').eq(7).find('a').size();
		if(size==1){
			//alert(comment);
			if(comment==''){
				$(this).css({'background-color':'#f2e7e6'});
				aidArr.push(aid);
			}
		}else if(size==2){
			$(this).css({'background-color':'#f2e7e6'});
			aidArr.push(aid);
		}
	}else{
			$(this).css({'background-color':''});
			}
	});

	$("#aidarr").attr('value',aidArr.join(','));
	
}
</script>
		<div class="workdata" style="width:788px;">
			<table width="100%" class="datatab">
				<thead class="tabhead">
				  <tr>
					<th width="15%">账号</th>
					<th width="13%">姓名</th>
					<th width="14%">答题时间</th>
					<th width="10%" style="cursor:pointer;" class="completetime">用时<i></i></th>
					<th width="7%" style="cursor:pointer;" class="totalscore">得分<i></i></th>
					<th width="20%">评语</th>
					<th width="7%">答题</th>
					<th width="14%">操作</th>
				  </tr>
				</thead>
				<tbody class="classexams">

				<?php if(!empty($answers)) { ?>
					 <?php foreach($answers as $answer) { ?>
					 <tr aid="<?=$answer['aid']?>">
						<td><span class="huirenw"><?= $answer['username'] ?></span></td>
						<td><?= (empty($answer['realname'])?$answer['username']:$answer['realname']).'('.($answer['sex']==1?'女':'男').')' ?></td>
						<td><?= (empty($answer['dateline'])|| $answer['status']==0)?'':(date('Y-m-d H:i',$answer['dateline'])) ?></td>
						<td><?= (!empty($answer['aid']) && $answer['status']!=0)?ceil($answer['completetime']/60).' 分钟':''?> </td>
						<td><?= round($answer['totalscore'],2) ?></td>
						<td title="<?= $answer['remark'] ?>"><?= shortstr($answer['remark'],30) ?></td>
						<td><?= (!empty($answer['aid']) && $answer['status']!=0)?'已提交':'<span style="color:red">未提交</span>' ?></td>
						<td>
						<?php if (!empty($answer['aid']) && $answer['status']!=0) { ?>
			
							<?php if(!empty($answer['tid'])) { ?>
							<a class="workBtn" href="http://exam.ebanhui.com/eview/<?=$answer['aid']?>.html" target="_blank">查看</a>
							<?php } else { ?>
						
							<a class="workBtn" href="http://exam.ebanhui.com/etmark/<?=$answer['aid']?>.html" target="_blank">批阅</a>
							<a class="workBtn"  onclick="return deleteanswer('<?=$answer['aid']?>','<?=$answer['eid']?>','<?=$answer['uid']?>')">删除</a>
							<?php } ?>
						<?php } ?>
						</td>
					 </tr>
					 <?php } ?>
					  <?php } else { ?>
						<tr>
							<td colspan="8" align="center">暂无记录</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<div style="margin-top:20px;"></div>
		</div>
		<script type="text/javascript">
			var order = '<?= $sort ?>';
			$(".completetime").click(function(){	
				if(order=="1") {
					location.href='<?= geturl('troom/classexam/all-0-2-0-'.$myclass['classid'].'-'.$myexam['eid']) ?>';
				}else{
					location.href='<?= geturl('troom/classexam/all-0-1-0-'.$myclass['classid'].'-'.$myexam['eid']) ?>';
				}
			});
			$(".totalscore").click(function(){
				if(order=="3") {
					location.href='<?= geturl('troom/classexam/all-0-4-0-'.$myclass['classid'].'-'.$myexam['eid']) ?>';
				}else{
					location.href='<?= geturl('troom/classexam/all-0-3-0-'.$myclass['classid'].'-'.$myexam['eid']) ?>';
				}
			});

			function deleteanswer(aid,eid,uid) {
				$.confirm("删除后学生要重新提交作业,确定要删除吗？",function(){
					var url = '<?= geturl('troom/classexam/deleteanswer') ?>';
					$.post(url,{'aid':aid,'eid':eid,'uid':uid},function(data){
							if(data==1){
								$.showmessage({
									img		 : 'success',
									message  :  '删除成功',
									title    :      '删除      成功',
									timeoutspeed    :       500,
									callback :    function(){
										location.reload();
									}
								});
							}else{
								$.showmessage({
									img		 : 'error',
									message  :  '删除失败',
									title    :      '删除      失败',
									timeoutspeed    :       500
								});
							}
						});

				});
				return false;
				
			}
			
</script>
</div>
</div>
<?php $this->display('troom/page_footer'); ?>