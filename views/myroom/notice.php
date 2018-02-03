<?php $this->display('myroom/page_header'); ?>
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/tzds.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/myind.css" rel="stylesheet" />
	<div class="ter_tit"> 当前位置 > <a href="<?= geturl('myroom/mysetting') ?>">我的首页</a> > 我的通知 </div>
	<div class="lefrig">
		<table class="datable" width="100%" style="border:solid 1px #cdcdcd;background:#fff;margin-top:15px;">
			<thead class="tabhead">
				<tr>
					<th style="text-align:left;">通知名称</th>
					<th style="text-align:left;">时间</th>
					<th style="text-align:left;">发送方</th>
					<th style="text-align:left;">操作</th>
				</tr>
			</thead>
			<tbody>

				<?php if(!empty($notices)) { ?>
					<?php foreach($notices as $notice) { 
					$sendname = $notice['type']==1? (empty($notice['realname'])? $notice['username']:$notice['realname']):'学校';
					?>
					<tr <?= ($notice['dateline']+604800)>SYSTIME ? 'class="lately"':'' ?>>
						<td width="64%" style="text-align:left;"><span style="width:480px;word-wrap: break-word;float:left;"><?= $notice['title'] ?></span></td>
						<td width="18%" style="text-align:left;"><?= date('Y-m-d H:i',$notice['dateline']) ?></td>
						<td width="10%"><?= $sendname ?></td>
						<td width="8%"><a class="chaqianbtn"  href="<?= geturl('myroom/notice/'.$notice['noticeid']) ?>" target="_blank">浏 览</a></td>
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
<?php $this->display('myroom/page_footer'); ?>