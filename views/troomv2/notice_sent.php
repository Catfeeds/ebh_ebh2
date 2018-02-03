<?php $this->display('troomv2/page_header'); ?>
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/tzds.css" rel="stylesheet" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/troomv2/css/wussyu.css"/>
	
	<div class="lefrig">
		<div class="work_mes">
			<ul>
				<li><a href="<?= geturl('troomv2/notice/send') ?>">发通知</a></li>
				<li><a href="<?= geturl('troomv2/notice') ?>">我接收的</a></li>
				<li class="workcurrent"><a href="<?= geturl('troomv2/notice/sent') ?>">我发送的</a></li>
			</ul>
		</div>
		<table class="datatab" width="100%" style="border:none;margin-top:20px;">
			<thead class="tabhead">
				<tr class="">
					<th style="text-align:left;">通知名称</th>
					<th>时间</th>
					<th>接收方</th>
					<th>浏览次数</th>
					<th style="text-align:left;padding-left:30px;">操作</th>
				</tr>
			</thead>
			<tbody>
				
				<?php if(!empty($notices)) { ?>
		
					<?php foreach($notices as $notice) { 
					$toname = '';
					$toidlist = explode(',',$notice['cids']);
					foreach($toidlist as $toid) {
						if(isset($classlist[$toid])) {
							$toname = empty($toname) ? $classlist[$toid]['classname'] : $toname .',' . $classlist[$toid]['classname'];
						}
					}
					?>
					<tr>
						<td width="25%"><span style="width:300px;word-wrap: break-word;float:left;"><a href="<?= geturl('troomv2/notice/'.$notice['noticeid']) ?>" target="_blank"><?= $notice['title'] ?></a></span></td>
						<td width="13%"><?= date('Y-m-d H:i',$notice['dateline']) ?></td>
						<td width="20%" style="text-align: center" title="<?= $toname ?>"><?= shortstr(trim($toname,","),30) ?></td>
						<td width="12%" style="text-align:center;"><?= $notice['viewnum'] ?></td>
						<td width="12%">
							<a href="<?= geturl('troomv2/notice/edit/'.$notice['noticeid']) ?>" class="xiaust" title="编辑"></a>
							<a href="javascript:;" nid="<?= $notice['noticeid'] ?>" class="shansge" title="删除"></a>
						</td>
					</tr>
					<?php } ?>
				<?php } else { ?>
				 	<tr>
						<td colspan="8" align="center" style="border-bottom:none;"><div class="nodata"></div></td>
					</tr>

				<?php } ?>
			</tbody>
		</table>
	<?=$pagestr?>
	</div>

<script type="text/javascript">
	$(".shansge").click(function(){
		var title = $(this).parent().parent().find("td").first().text();
		var nid = $(this).attr("nid");
			var url = "<?= geturl('troomv2/notice/del') ?>";
			var d = dialog({
				title: '删除通知',
				content: '您确定删除【'+title+'】这个通知消息吗？',
				okValue: '确定',
				ok: function () {
			$.ajax({
				type: "POST",
				url: url,
				data: {"nid":nid},
				dataType:"json",
				success: function(msg){
					if(msg == 1){
						dialog({
							skin:"ui-dialog2-tip",
							content:"<div class='TPic'></div><p>删除通知成功</p>",
							width:350,
							onshow:function () {
								var that=this;
								setTimeout(function () {
									window.location.href="<?= geturl('troomv2/notice/sent') ?>";
									that.close().remove();
								}, 1000);
							}
						}).show();
					}else{
						dialog({
							skin:"ui-dialog2-tip",
							content:"<div class='FPic'></div><p>删除通知失败，请稍后再试或联系管理员。</p>",
							width:350,
							onshow:function () {
								var that=this;
								setTimeout(function () {
									that.close().remove();
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
	$(function(){
		$('.datatab tr:last td').css('border-bottom','none');
	});
</script>
<?php $this->display('troomv2/page_footer'); ?>