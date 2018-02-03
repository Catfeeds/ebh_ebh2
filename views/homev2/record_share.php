<?php
$ht = $this->input->get('ht');
if ($ht == 1) {
  $this->display('homev2/header1');
} else {
  $this->display('homev2/header');
}
?>
<style>
.ghjut {width:auto;}
a.mytitle {
    float: left;
    height: 24px;
    line-height: 24px;
    margin: 10px 0 0 20px;;
    padding: 0 10px;
	color:#666;
	font-size:14px;
	font-family: 微软雅黑;
}
a.fenlan {
    background: #5E96F5 none repeat scroll 0 0;
    color: #fff;
} .content-nan {
	background:url(http://static.ebanhui.com/ebh/tpl/troomv2/images/man.png) no-repeat bottom center;
	width:16px;
	height:16px;
	float:left;
	display: block;
} .content-nv {
	background:url(http://static.ebanhui.com/ebh/tpl/troomv2/images/women.png) no-repeat bottom center;
	width:16px;
	height:16px;
	float:left;
	display: block;
}
.shum{
	overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
}
</style>
<?php $this->display('homev2/top');?>
<div class="divcontent">
<div class="topbaad">
<div class="user-main clearfix">
<div class="lefrig" style="background:#fff;margin-top:10px;">
<?php $this->display('homev2/small_menu');?>
<a class="mytitle" style="margin-left:45px" href="/homev2/profile/msg.html" >我购买的</a>
<a class="mytitle fenlan" href="/homev2/profile/share.html" >我分享的</a>
	<div class="wordent">
		<table class="datatabsim" width="100%"  style="font-size:12px;border:none;">
			<tbody class="tabheadsim" style="line-height: 24px;">
				<tr class="topsbt">
					<td align="left" width="17%" style="padding-left: 15px">购买人账号</td>
					<td align="left" width="15%">购买时间</td>
					<td align="center" width="8%">服务时长</td>
					<td align="center" width="20%">所属网校</td>
					<td align="center" width="11%">金额</td>
					<td align="center" width="9%">我的分成</td>
					<td align="center" width="20%">备注</td>
				</tr>
			</tbody>
			<?php if (!empty($payorderList)){?>
			<tbody class="tabcont">
			
				<?php foreach($payorderList as $val){?>
				<tr>
				<td><a title="<?=$val['realname']?>" href="javascript:;" style="float:left;margin-left:15px;">
							<img class="imgyuans" src="<?=getavater($val)?>">
						</a>
						<p class="ghjut ghjut1"><span class="fl"><?=$val['realname']?></span><i class="content-nv"></i></p>
						<p class="ghjut"><?=$val['username']?></p>
				</td>
					<td><?=Date('Y-m-d H:i:s',$val['dateline'])?></td>
					<td><?=!empty($val['omonth'])?$val['omonth'].'个月':$val['oday'].'天'?></td>

					<td><?php if(empty($val['rname'])){echo '精品课堂';}else{echo $val['rname'];}?></td>
					<td><span class="utrwr"><?=$val['fee']?></span></td>
					<td><span class="utrwr"><?=$val['sharefee']?></span></td>
					<td class='shum' title="开通 <?= $val['oname'] ?> 服务">开通 <?= $val['oname'] ?> 服务</td>
				</tr>
				<?php }?>
			</tbody>
			<?php }else{?>
			<tbody class="tabnone">
				<tr>
					<!--<th colspan="6" style="padding-top:10px;text-align:center"><div class="nodata"></div></th>!-->
				</tr>
			</tbody>
		<?php }?>
		</table>
	</div>
	<?=$pageStr?>
	<div style="clear:both">&nbsp;</div>
</div>
</div>
</div>
<div style="clear:both;"></div>
</div>
<?php $this->display('homev2/footer');?>