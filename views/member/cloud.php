<?php
$this->display('common/header');
?>
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/join.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" type="text/css" />
<div class="topbaad">
<div class="user-main clearfix">
<?php
$this->assign('menuid',1);
$this->display('member/left');
?>
<div class="cright_cher">
		<div class="ter_tit">
		当前位置 > 云教学网校
		</div>
	<div class="lefrig" style="background:#fff;width:788px;float:left;">
		<div class="annuato" style="line-height:24px;height:24px;border:none;margin:0;padding-left:20px;position: relative;">
		<a class="questionbutton" href="<?=geturl('cloudlist')?>" style="right:25px;top: 10px;position: absolute;margin:0px;width:130px;" >查找云教学网校</a>
		</div>
	<?php
		if(count($roomlist)==0){
	?>
		<div class="nojoin">
			<p>您还没有加入任何云教学网校,<a href="<?=geturl('cloudlist')?>" style="color:#ff5501;" target="_blank">立刻加入>></a>畅享知识海洋...</p>
		</div>
	<?php
	}
		else{
			foreach($roomlist as $room){
				if(strstr($_SERVER['HTTP_HOST'], '.ebh.net') == '.ebh.net'){
					$flg = '.ebh.net';
				}else{
					$flg = '.ebanhui.com';
				}
				$room['murl'] = 'http://'.$room['domain'].$flg.'/myroom.html';
				
	?>
		<div class="lc_detail">
			<ul>
				<li class="agess" onmouseover="this.className='agess1'" onmouseout="this.className='agess'">
				<div class="cuor">
				<a href="<?php echo $room['murl']?>" title="<?php echo $room['crname']?>">
				<?php $logo=empty($room['cface'])?'http://static.ebanhui.com/ebh/tpl/default/images/elist_tx.jpg':$room['cface'];?>
				<img src="<?=$logo?>" width="100" height="100" style="margin-top:2px; margin-left:2px;"></a></div>
				<h2 class="courtit">
				<a href="<?php echo $room['murl']?>" title="<?php echo $room['crname']?>"><?php echo $room['crname']?></a>
				</h2>
				<p class="yunjsh" style="word-break:break-all;"><?php echo ssubstrch($room['summary'],0,150)?></p>
				<a class="add" style=" color:#FFF;text-decoration: none;" href="<?php echo $room['murl']?>">进入学习</a>
				<p class="due">服务到期时间：<span style="color:#1061a7; font-weight:bold; margin-right:20px;"><?php echo empty($room['enddate'])?'无限制':Date('Y-m-d',$room['enddate'])?></span>课时数：<span style="color:#1061a7; font-weight:bold; margin-right:20px;">( <?php echo $room['coursenum']?> 课时 )</span></p>
				</li>
			
			</ul>
		</div>
	<?php
		}
	}
	?>
	</div>
</div>
</div>
</div>
<?php
$this->display('common/footer');
?>