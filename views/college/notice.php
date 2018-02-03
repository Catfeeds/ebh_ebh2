<?php $this->display('college/page_header'); ?>
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/tzds.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/myind.css" rel="stylesheet" />
	<div class="lefrig">
		<table class="datable" width="100%" style="background:#fff;">
			<thead class="tabhead">
				<tr>
					<th style="text-align:left;">通知名称</th>
					<th style="text-align:left;">时间</th>
					<th style="text-align:left;">发送方</th>
					<th style="text-align:left;">操作</th>
				</tr>
			</thead>
			<tbody>
				<!--判断是网校还是企业，企业$room_type变量输出1，0为网校-->
				<?php $room_type = Ebh::app()->room->getRoomType();$room_type = $room_type == 'com' ? 1 : 0;?>
				<?php if(!empty($notices)) { ?>
					<?php foreach($notices as $notice) { 
					$sendname = $notice['type']==1? (empty($notice['realname'])? $notice['username']:$notice['realname']):(($room_type==1) ? "公司":"学校");
					?>
					<tr <?= ($notice['dateline']+604800)>SYSTIME ? 'class="lately"':'' ?>>
						<td width="64%" style="text-align:left;"><span style="width:480px;word-wrap: break-word;float:left;"><span style="color: red"><?= $notice['readed']?'':'[未读]' ?></span><?= $notice['title'] ?></span></td>
						<td width="18%" style="text-align:left;"><?= date('Y-m-d H:i',$notice['dateline']) ?></td>
						<td width="10%"><?= $sendname ?></td>
						<td width="8%"><a class="chaqianbtn"  href="<?= geturl('college/notice/'.$notice['noticeid']) ?>" target="_blank">浏 览</a></td>
					</tr>
					<?php } ?>
				<?php } else { ?>
				 	<tr>
						<!--<td colspan="8" align="center">暂无记录</td>-->
                        <td colspan="8" align="center" style="padding:0"><?=nocontent()?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<?= $pagestr ?>
	</div>
<?php $this->display('myroom/page_footer'); ?>