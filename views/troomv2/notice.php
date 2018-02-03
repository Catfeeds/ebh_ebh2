<?php $this->display('troomv2/page_header'); ?>
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/tzds.css" rel="stylesheet" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/troomv2/css/wussyu.css"/>
	
	<div class="lefrig">
		<div class="work_mes">
			<ul>
				<li><a href="<?= geturl('troomv2/notice/send') ?>">发通知</a></li>
				<li class="workcurrent"><a href="<?= geturl('troomv2/notice') ?>">我接收的</a></li>
				<li><a href="<?= geturl('troomv2/notice/sent') ?>">我发送的</a></li>
			</ul>
		</div>
		<table class="datatab" width="100%" style="border:none;margin-top:20px;">
			<thead class="tabhead">
				<tr class="">
					<th style="text-align:left;">通知名称</th>
					<th>时间</th>
					<th>接收方</th>
					<th>浏览次数</th>
				</tr>
			</thead>
			<tbody>
				
				<?php if(!empty($notices)) { ?>
		
					<?php foreach($notices as $notice) { 
					$toname = '我';
					// $toidlist = explode(',',$notice['cids']);
					// foreach($toidlist as $toid) {
						// if(isset($classlist[$toid])) {
							// $toname = empty($toname) ? $classlist[$toid]['classname'] : $toname .',' . $classlist[$toid]['classname'];
						// }
					// }
					?>
					<tr>
						<td width="50%"><span style="width:450px;word-wrap: break-word;float:left;"><span style="color: #e2681d"><?= $notice['readed']?'':'[未读]' ?></span><a href="<?= geturl('troomv2/notice/'.$notice['noticeid']) ?>" target="_blank"><?= $notice['title'] ?></a></span></td>
						<td width="20%" style="text-align:center;"><?= date('Y-m-d H:i',$notice['dateline']) ?></td>
						<td width="20%" style="text-align: center" title="<?= $toname ?>"><?= shortstr(trim($toname,","),30) ?></td>
						<td width="10%" style="text-align:center;"><?= $notice['viewnum'] ?></td>
						
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
		$.confirm("您确定删除【"+title+"】这个通知消息吗？",function(){
			var url = "<?= geturl('troomv2/notice/del') ?>";
			$.ajax({
				type: "POST",
				url: url,
				data: {"nid":nid},
				dataType:"json",
				success: function(msg){
					if(msg == 1){
						$.showmessage({
                            img : 'success',
                            message:'删除通知成功',
                            title:'删除通知',
                            callback :function(){
                                 window.location.href="<?= geturl('troomv2/notice') ?>";
                            }
                        });
						
					}else{
						$.showmessage({
                            img : 'error',
                            message:'删除通知失败，请稍后再试或联系管理员。',
                            title:'删除通知'
                        });
					}
				}
			});
		});
	});
	$(function(){
		$('.datatab tr:last td').css('border-bottom','none');
	});
</script>
<?php $this->display('troomv2/page_footer'); ?>