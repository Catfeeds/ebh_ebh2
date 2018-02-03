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
	<?php $this->assign('index',2);
	$this->display('college/activity_menu');?>
    <div class="match matchs">
    	<div class="cjpamjf">
        	<div class="paimingico"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/paimingico.png" width="149" height="149"/></div>
            <div class="cjpmhf">
                <p><span class="span1s">参加人数：</span><span class="span2s"><?=$actdetail['parter']?></span></p>
                <p><span class="span1s">我的排名：</span><span class="span2s"><?=empty($myrank)?'--':$myrank?></span></p>
                <p><span class="span1s">我的积分：</span><span class="span2s"><?=empty($actdetail['credit'])?0:$actdetail['credit']?></span></p>
            </div>
        </div>
    	<div style="width:940px;">
			<table class="datatabss xmpmjf" border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr style="background:#fff;">
					<th width="40%">姓名</th>
					<th width="40%">排名</th>
					<th width="20%">积分</th>
				</tr>
				<?php foreach($parterlist as $k=>$parter){
					if($k === 'count')break;
					$name = empty($parter['realname'])?$parter['username']:$parter['realname'];
					$name = hidename($name);
					
					$sex = empty($parter['sex']) ? 'man' : 'woman';
					$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_'.$sex.'.jpg';
					$face = empty($parter['face']) ? $defaulturl : $parter['face'];
					$facethumb = getthumb($face,'50_50');
					$rank = ($page-1)*20+$k+1;?>
				<tr <?=$user['uid'] == $parter['uid']?'style="background:#F2FBFF"':''?>>
					<td class="<?=$rank<=3?'td1':''?>">
						<?php if($rank<=3){?>
                    	<div class="fl mingci"><?=$k+1?></div>
						<?php }?>
                    	<div class="toxiangs fl <?=$rank<=3?'ml15':''?>"><img src="<?=$facethumb?>" height="40" width="40"></div>
                        <div class="fl ml10"><?=$name?></div>
                    </td>
					<td>No.<?=$rank?></td>
					<td><?=$parter['credit']?></td>
				</tr>
				<?php }?>
                
			</table>
		</div>
		<?=$pagestr?>
    </div>
</div>
</body>
</html>
