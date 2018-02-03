<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport"  content="user-scalable=no">
<title>学习记录</title>
</head>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css<?=getv()?>" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css<?=getv()?>"/>
<style>
.lison{width:186px; height:215px;  position:relative; display:block; margin-left:12px;}
.lison:hover{cursor:pointer;}
</style>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<style>
.studujls_son li{
	cursor:pointer;
}
</style>


<body>
<div class="studyjls">
	<div style="display:inline-block; margin:11px;">
        <?php 
		if(!empty($loglist)){
		$k=0;
		$lastfolderid = 0;
		foreach($loglist as $i=>$cw){
			$deflogo = 'http://static.ebanhui.com/ebh/tpl/2014/images/defaultcwimg.jpg';
			$logo = !empty($cw['logo'])?$cw['logo']:$deflogo;
			if($cw['folderid']!=$lastfolderid){
				$lastfolderid = $cw['folderid'];
			?>
		<div class="mt25">
			<div class="title"><?=$cw['foldername']?></div>
			<div class="studujls_son">
				<ul>
			<?php }
					// if($cw['rcount']-1 == 0)
						// continue;
					if($k%5==0)
						$firstclass = 'first';
					else
						$firstclass = '';
					$k++;
					$studytime = $cw['sumtime'];
					if(!empty($cw['ctime'])){//国土的，进度按累计时长
					    $percent = !empty($is_zjdlr) ? floor($studytime/$cw['ctime']*100) : floor($cw['ltime']/$cw['ctime']*100);
					}else{
					    $percent = 0;
					}
					if($percent>90)
						$percent = 100;
					// $lengthminute = floor($cw['ltime']/60);
					// $lengthsecond = ($cw['ltime']%60);
					// $studytime = round(($cw['sumtime']-$cw['ltime'])/60,1);
					// $studyminute = floor(($cw['sumtime']-$cw['ltime'])/60);
					// $studysecond = ($cw['sumtime']-$cw['ltime'])%60;
					// if($studytime>100)
						// $studytime = ceil($studytime);
					if($studytime>=60){
						$timenumber = round($studytime/60);
						$timeunit = '分';
					}else{
						$timenumber = $studytime;
						$timeunit = '秒';
					}
					?>
					<li class=" fl " title="<?=$cw['title']?>">
					<div class="lison <?=$firstclass?>">
						<a href="/myroom/mycourse/<?=$cw['cwid']?>.html" target="_blank" class="opens"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/kustgd.png" /></a>
						<div class="kcbj"><img style="width:178px;height:103px" src="<?=$logo?>" /></div>
						<div class="shichang">时长：<?=$cw['cwlength']>=60?(round($cw['cwlength']/60).'分'):($cw['cwlength'].'秒')?></div>
						<h2><?=shortstr($cw['title'],18,'')?></h2>
						<p>首次:<?=empty($cw['startdate'])?'未学习':Date('Y-m-d　H:i',$cw['startdate'])?></p>
						<p>已学:<span class="span1s"><?=$timenumber?></span><?=$timeunit?> 共计:<span class="span1s"><?=empty($cw['rcount'])?0:$cw['rcount']?></span>次</p>
						<div class="kewate fl" ><span class="jindus"><?=$percent?>%</span><span style="width:<?=$percent?>%" class="jindu"></span></div>
					</div>
					</li>
			<?php if(empty($loglist[$i+1]) || $loglist[$i+1]['folderid']!=$lastfolderid){
				$k=0;
				?>
				</ul>
			</div>
		</div>
		<div class="clear"></div>
			<?php }
		}}else{?>
		<div class="nodata" style="width:1000px;">
		</div>
		<?php }?>
        <?=$pagestr?>
	</div>
</div>
</body>
</html>
