<?php $this->display('troom/page_header');?>
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/tzds.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/myind.css" rel="stylesheet" />

	<div class="ter_tit"> 当前位置 > <a href="<?= geturl('troom/mysetting') ?>">我的首页</a> > 我的通知 </div>
	<div class="lefrig">
		<table class="datable" width="100%" style="background:#fff;margin-top:15px;">
			<thead class="tabhead">
				<tr>
					<th style="text-align:left;">通知名称</th>
					<th style="text-align:left;">时间</th>
					<th style="text-align:left;">操作</th>
				</tr>
			</thead>
			<tbody>
				
				<?php if(!empty($notices)) { ?>
					<?php foreach($notices as $notice) { ?>
					<tr <?= ($notice['dateline'] + 604800) > SYSTIME? 'class="lately"':'' ?>>
						<td width="65%" style="text-align:left;"><span style="width:300px;word-wrap: break-word;float:left;"><?= $notice['title'] ?></span></td>
						<td width="27%" style="text-align:left;"><?= date('Y-m-d H:i',$notice['dateline']) ?></td>
						<td width="8%"><a class="chaqianbtn" nid="<?= $notice['noticeid'] ?>" href="<?= geturl('troom/notice/'.$notice['noticeid']) ?>" target="_blank">浏 览</a></td>
					</tr>
					<?php } ?>

				<?php } else { ?>
				 	<tr>
						<td colspan="8" align="center">暂无记录</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<?= $pagestr ?>
	</div>
<script type="text/javascript">
	$(".chaqianbtn").click(function(){
		var nid = $(this).attr("nid");
		$.ajax({
			type:'POST',
			url:'#getsitecpurl()#?action=student&op=updatenotice',
			data:{"nid":nid}
		});
	});
</script>

</body>
</html>