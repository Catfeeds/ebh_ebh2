<?php $this->display('college/page_header');?>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css?v=20160429001"/>
<style>
.work_menu ul li a {
    color: #666;
    font-family: 微软雅黑;
    font-size: 16px;
}
.workcurrent a span {
    color: #4c88ff !important;
}
</style>
<body>
<div class="allcou">
	<!--<div class="title">
    	<a href="/college/activity.html" class="aall curs">所有活动</a>
        <a href="/college/activity/description.html" class="aall">说明</a>
    </div>-->
	<div class="work_menu" style="position:relative;margin-top:0;">
		<ul>
			<li class="workcurrent"><a href="/college/activity.html"><span>所有活动</span></a></li>
			<li><a href="/college/activity/description.html"><span>积分规则</span></a></li>
		</ul>
	</div>
    <div class="match">
        <?php if(!empty($aclist)) {?>
		<?php foreach($aclist as $act){
			$img = empty($act['imgurl'])?'http://static.ebanhui.com/ebh/tpl/2016/images/matchlistpic.jpg':$act['imgurl'];
			?>
    	<div class="matchlist">
        	<div class="matchlistpic fl"><a href="/college/activity/intro/<?=$act['aid']?>.html"><img src="<?=$img?>" width="180" height="136" /></a></div>
            <div class="matchlistnr fl">
                <div class="fl matchlistnrson">
                    <a href="/college/activity/intro/<?=$act['aid']?>.html" class="hdname"><?=$act['subject']?></a>
                    <span class="ybm"><?=$act['pdateline']?'(已报名)':''?></span>
                    <span class="ybm"></span>
                    <p class="mt5">时间：<span class="sjs"><?=Date('Y.m.d',$act['starttime'])?> — <?=Date('Y.m.d',$act['endtime'])?></span></p>
                    <div style="height:58px;" class="netx">摘要：<?=$act['summary']?></div>
                </div>
				<?php
				if($act['endtime']+86400<SYSTIME)
					$status = 'hdyjs';
				else
					$status = 'hdjxz';
				?>
                <div class="hdjxz fr"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/<?=$status?>.png" width="125"/></div>
                <div class="clear"></div>
                <div class="gxqcj">
                	<p class="fl"><span><?=$act['viewnum']?></span>人感兴趣</p>
                    <p class="fl ml15"><span><?=$act['parter']?></span>人参加</p>
                    <p class="fr" style=" color:#cccccc;">发布于：<?=Date('Y.m.d',$act['date'])?></p>
                </div>
            </div>
        </div>
        <div class="clear"></div>

		<?php }?>
            <?=$pagestr?>
        <?php }else {?>
            <?=nocontent()?>
        <?php }?>

    </div>
</div>
</body>
</html>
