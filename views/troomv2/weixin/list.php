<?php $this->display('troomv2/page_header'); ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/css/statch.css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<style>
.datatab td {
    font-size: 13px;
    padding: 10px 10px 10px 20px;
}</style>
<div class="lefrig">
<div class="work_mes">
	<ul>
		<li class="workcurrent">
		<a href="/troomv2/weixin/list_msg.html">发信历史</a>
		</li>
		<li>
		<a href="/troomv2/weixin/parent_send.html">家长回复</a>
		</li>
		<li class="">
		<a href="/troomv2/weixin/class_send_msg.html">班级群发</a>
		</li>
	</ul>
</div>
	<form  name="student_send" method="get" action="/troomv2/weixin/list_msg.html">
	<div class="euwqie" style="background:#fff;padding:10px; margin-top:15px;float:left;">
	<span>从</span><input type="text" id="wx_start" name="startDate" class="rqitet" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" value="<?= date('Y-m-d',$starttime) ?>" /><span style="margin-left:10px;">至</span><input type="text" id="wx_end" name="endDate" class="rqitet" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" value="<?= date('Y-m-d',$endtime) ?>" />
	<a href="javascript:void(0);" id="list_wx" class="souhuang">查询</a>
	</div>
	</form>
	<div class="faltit" style="width:1000px;">
		<table class="datatab" width="100%" style="border:none;">
			<thead class="tabhead">
			<tr class="">
			<th>发信时间</th>
			<th>内容</th>
			</tr>
			</thead>
			<tbody>
			<?php if(!empty($sendList)){?>
				<?php foreach ($sendList as  $sendInfo) {?>
					<tr class="">
						<td width="18%"><?=date('Y-m-d H:i:s',$sendInfo['dateline'])?></td>
							<td width="82%">
							<span style="float:left;width:730px;"><?=shortstr($sendInfo['weixin_content'],82)?></span><a href="/troomv2/weixin/showDetail.html?batchid=<?=$sendInfo['batchid']?>&id=<?=$sendInfo['id']?>">详细>></a>
						</td>
					</tr>
				<?php }?>
			<?php }else{?>
				<tr class="">
					<td colspan=2 style="text-align:center">没有找到对应记录</td>
				</tr>
			<?php }?>
			</tbody>
		</table>
		<?=$pageStr?>
	</div>
</div>
<script type="text/javascript">

$(function() {
	$("#list_wx").click(function () {
		var startDate=$("#wx_start").val();
		var stime=new Date(startDate.replace("-", "/").replace("-", "/"));
		var endDate=$("#wx_end").val();
		var etime=new Date(endDate.replace("-", "/").replace("-", "/"));
		if(etime<stime){
			alert("结束时间不能小于开始时间");
			return false;
		}
		$("form[name=student_send]").submit();
	});
});

</script>
<?php $this->display('troomv2/page_footer'); ?>