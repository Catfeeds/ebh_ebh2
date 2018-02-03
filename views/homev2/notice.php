<?php $this->display('homev2/header'); ?>
<?php $this->display('homev2/top');?>
<style type="text/css">
.wordent td{ text-align: left; }
.wordent a.chaqianbtn {
    background: url(http://static.ebanhui.com/ebh/tpl/default/images/dabtn1119.jpg) no-repeat scroll 0 0;
    color: #fff;
    display: block;
    height: 23px;
    line-height: 23px;
    text-align: center;
    text-decoration: none;
    width: 44px;
}
</style>
<div class="divcontent">
    <div class="jetke">
		<div class="work_menu" style="width:1000px; position:relative;margin-top:0px;">
			<ul>
				 <li class="workcurrent"><a href="javascript:void(0)" style="font-size:16px;"><span>我的通知</span></a></li>
			</ul>
		</div>
        <div class="wordent">
       		<table border="0" cellspacing="0" cellpadding="0">
            	<tr class="topsbt">
	                <td>通知名称</td>
	                <td>时间</td>
	                <td>发送方</td>
	                <td>操作</td>
            	</tr>
				<?php if(!empty($notices)) { ?>
					<?php foreach($notices as $notice) { 
					$sendname = $notice['type']==1? (empty($notice['realname'])? $notice['username']:$notice['realname']):'学校';
					?>
					<tr <?= ($notice['dateline']+604800)>SYSTIME ? 'class="lately"':'' ?>>
						<td width="64%" style="text-align:left;"><span style="width:480px;word-wrap: break-word;float:left;"><span style="color: red"><?= $notice['readed']?'':'[未读]' ?></span><?= $notice['title'] ?></span></td>
						<td width="14%" style="text-align:left;"><?= date('Y-m-d H:i',$notice['dateline']) ?></td>
						<td width="14%"><?= $sendname ?></td>
						<td width="8%"><a class="chaqianbtn"  href="<?= geturl('homev2/notice/'.$notice['noticeid']) ?>" target="_blank">浏 览</a></td>
					</tr>
					<?php } ?>
				<?php } else { ?>
				 	<tr>
						<td colspan="4" align="center"><div class="nodata"></div></td>
					</tr>
				<?php } ?>
            </table>
            <?=$pagestr?>
        </div>

    </div>
</div>
<script type="text/javascript">
$(function(){
		$('.wordent tr:last td').css('border-bottom','none');
	});
</script>
<?php $this->display('homev2/footer');?>