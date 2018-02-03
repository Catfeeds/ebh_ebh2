<?php $this->display('college/page_header');?>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css?v=20160429001"/>
<style>
.joins a.dn{
	display:none;
}
</style>

<body>
<div class="allcou">
	<div class="matchtitle"><?=$actdetail['subject']?></div>
	<div class="title">
    	<a href="/college/activity/intro/<?=$actdetail['aid']?>.html" class="aall curs">活动介绍</a>
        <a href="/college/activity/rank/<?=$actdetail['aid']?>.html" class="aall">我的排名</a>
        <a href="/college/activity/credit/<?=$actdetail['aid']?>.html" class="aall">积分</a>
    </div>
    <div class="match matchs">
    	<div class="matchlist" style="border-bottom:none;">
        	<div class="matchlistpics fl"><img src="<?= empty($actdetail['imgurl'])?'http://static.ebanhui.com/ebh/tpl/2016/images/matchlistpic.jpg':$actdetail['imgurl']?>" width="300" height="226" /></div>
            <div class="matchlistnrs fl" style="width:620px;">
                <div class="fl matchlistnrson">
                    <p class="mt5">时间：<?=Date('Y.m.d',$actdetail['starttime'])?>——<?=Date('Y.m.d',$actdetail['endtime'])?></p>
					<?php if($actdetail['endtime']<SYSTIME){?>
                    <p>状态：已结束</p>
					<?php }else{?>
					<p>状态：进行中</p>
					<?php }?>
                </div>
                <div class="clear"></div>
                <div class="gxqcj">
                    <p><span style="font-weight:bold;"><?=$actdetail['parter']?></span>人参加</p>
                	<p><span style="font-weight:bold;"><?=$actdetail['viewnum']+1?></span>人感兴趣</p>
                </div>
                <div class="joins" style="position:relative;">
					<?php if($actdetail['endtime']<SYSTIME){
							$show[0] = true;
						}elseif($actdetail['pdateline']){
							$show[1] = true;
						}else{
							$show[2] = true;
						}?>
                    <a href="javascript:void(0)" class="hdjs <?=!empty($show[0])?'':'dn'?>">活动结束</a>
					
                    <a href="javascript:void(0)" class="hdjs joined <?=!empty($show[1])?'':'dn'?>">已参加</a>
					
                	<a href="javascript:void(0)" class="wycj joinin <?=!empty($show[2])?'':'dn'?>">我要参加</a>
					
                    <div class="ycjs joinsucc" style="display:none;"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/bmcg.png" width="118" height="42"/></div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <div class="hdnrs">
        	<h2>活动内容</h2>
            <div class="hdgz">
            	<?=$actdetail['message']?>
            </div>
        </div>
        <div class="hdnrs mt15">
        	<div>
            	<h2 class="fl">报名信息(<?=$actdetail['parter']?>)</h2>
                <a href="/college/activity/intro/<?=$actdetail['aid']?>.html" class="moresbm fr">查看评论>></a>
            </div>
            <div class="clear"></div>
            <div class="bmxxlist">
			<?php foreach($parterlist as $k=>$parter){
				if($k === 'count')
					break;
				$name = empty($parter['realname'])?$parter['username']:$parter['realname'];
				$name = hidename($name);
				
				$sex = empty($parter['sex']) ? 'man' : 'woman';
				$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_'.$sex.'.jpg';
				$face = empty($parter['face']) ? $defaulturl : $parter['face'];
				$facethumb = getthumb($face,'50_50');
				?>
            	<div class="fl bmxxlist1 <?=$k%12!=0?'ml30':''?>">
					<div><img src="<?=$facethumb?>" height="50" width="50"></div>
					<div class="touxiangt"><span style="color:#fff;"><?=$name?></span></div>
				</div>
			<?php }?>
                
			</div>
        </div>
        
        <div class="clear"></div>
        
    </div>
</div>
<script>
$('.joinin').click(function(){
	$.ajax({
		'url':'/college/activity/joinin.html',
		'type':'post',
		'data':{'aid':<?=$actdetail['aid']?>},
		'success':function(data){
			$('.joinsucc').fadeIn(1000).fadeOut(2000);
			$('.joinin').hide();
			$('.joined').css('display','block');
		}
	})
});
$('.moresbm').click(function(){
	
	/*
	$.ajax({
		'url':'/college/activity/getparter.html',
		'type':'post',
		'data':{'aid':<?=$actdetail['aid']?>},
		'success':function(data){
			var parterlist = eval(data);
			
		}
	});
	*/
});
</script>
</body>
</html>