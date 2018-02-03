<?php $this->display('college/page_header');?>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css?v=20160429001"/>


<style>
.joins a.dn{
	display:none;
}
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
	<?php $this->assign('index',1);
	$this->display('college/activity_menu');?>
    <div class="match matchs">
    	<div class="matchlist" style="border-bottom:none;">
        	<div class="matchlistpics fl"><img src="<?= empty($actdetail['imgurl'])?'http://static.ebanhui.com/ebh/tpl/2016/images/matchlistpic.jpg':$actdetail['imgurl']?>" width="300" height="226" /></div>
            <div class="matchlistnrs fl" style="width:620px;">
                <div class="fl matchlistnrson">
                    <p class="mt5">时间：<?=Date('Y.m.d',$actdetail['starttime'])?>——<?=Date('Y.m.d',$actdetail['endtime'])?></p>
					<?php if($actdetail['endtime']+86400<SYSTIME){?>
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
					<?php if($actdetail['endtime']+86400<SYSTIME){
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
                <a href="/college/activity/parter/<?=$actdetail['aid']?>.html" class="moresbm fr">更多>></a>
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
        <div class="hdnrs mt25">
			<h2>评论</h2>
            <div class="pilunlist">
				<?php foreach($areviewlist as $k=>$review){
					$sex = empty($review['sex']) ? 'man' : 'woman';
					$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_'.$sex.'.jpg';
					$face = empty($review['face']) ? $defaulturl : $review['face'];
					$facethumb = getthumb($face,'50_50');
					$reviewtext = empty($review['isshield'])?emotionreplace($review['review']):'[已屏蔽]';
					$name = empty($review['realname'])?$review['username']:$review['realname'];
					$name = hidename($name);
					?>
            	<div class="pilunlist1">
                	<div class="pilunlist1son">
                    	<div class="toxiangs fl"><img src="<?=$facethumb?>" height="50" width="50"></div>
                        <div class="wxename fl ml5 info<?=$review['cid']?>">
                        	<div style="width:880px;">
                            	<span class="names fl name"><?=$name?></span>
                                <span class="datime fl date">&nbsp;<?=Date('Y-m-d',$review['date'])?></span>
                                <span class="datime fr floor"><?=($page-1)*10+$k+1?>F</span>
                            </div>
                            <div class="clear"></div>
							<?php if(!empty($review['upid']) && !empty($upreviewarr[$review['upid']])){
								$upreview = $upreviewarr[$review['upid']];
								$upreviewtext = empty($upreview['isshield'])?emotionreplace($upreview['review']):'[已屏蔽]';
								$name = empty($upreview['realname'])?$upreview['username']:$upreview['realname'];
								$name = hidename($name);
								?>
							<div class="pingls info<?=$review['upid']?>">
                            	<p>
                                	<span style="font-family: Arial; color:#ffb400;" class="floor"><?=$upreview['floor']?>F&nbsp;</span>
                                    <span class="name">&nbsp;<?=$name?>&nbsp;</span>
                                    <span>&nbsp;发布于</span>
                                    <span style="font-family: Arial;" class="date"><?=Date('Y-m-d',$upreview['date'])?></span>
                                </p>
                                <p class="plnrs review"><?=$upreviewtext?></p>
                            </div>
							<?php }?>
                            <p class="plnrs review"><?=$reviewtext?></p>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <?php $user = Ebh::app()->user->getloginuser();?>
                    <?php if($review['uid'] == $user['uid']){?>
                    <a href="javascript:void(0)" class="moresbm yinyong" cid="<?=$review['cid']?>" upid="<?=$review['upid']?>" onclick="del(<?=$review['cid']?>,this)">删除</a>
                    <?php }else{?>
                    <a href="javascript:void(0)" class="moresbm yinyong yinyong1" cid="<?=$review['cid']?>" upid="<?=$review['upid']?>">引用</a>
                    <?php }?>	
                </div>
				<?php }?>
                
            </div>
        </div>
		<?=$pagestr?>
        <div class="clear"></div>
		<?php $this->display('college/publish');?>
        
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
            setTimeout(function(){
                location.reload();
            },2500)
		}
	})
});
function del(cid,obj){
	top.dialog({
    title: '信息提示',
    content: '确认删除评论吗？',
	width:350,
    okValue: '确定',
    ok: function () {
		this.close().remove();
        $.ajax({
		'url':'/college/activity/review_del.html',
		'type':'post',
		'data':{'cid':cid},
		'success':function(data){
			var jsonobj = eval("("+data+")");
			if(jsonobj.success == 1){
				/*top.dialog({
                    skin:"ui-dialog2-tip",
                    width:350,
                    content: "<div class='TPic'></div><p>删除成功！</p>",
					onshow:function(){
						var that=this;
						setTimeout(function () {
							that.close().remove();
				            location.reload();
							}, 1000);
					}
				}).showModal();*/
	            location.reload();
			}else{
				top.dialog({
                    skin:"ui-dialog2-tip",
                    width:350,
                    content: "<div class='FPic'></div><p>删除失败！</p>",
					onshow:function(){
						var that=this;
						setTimeout(function () {
							that.close().remove();
				            location.reload();
							}, 1000);
					}
				}).showModal();
			}
		}
	});
        return false;
    },
		cancelValue: '取消',
		cancel: function () {}
	}).showModal();
}
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
var upid;
$('.yinyong1').click(function(){
	upid = $(this).attr('upid');
	if(upid == 0)
		upid = $(this).attr('cid');
	// alert();
	// console.log($('.info'+upid+' .review'));
	$('.queteinfo .review').html($('.info'+upid+' .review').html());
	$('.queteinfo .name').html('&nbsp;&nbsp;'+$('.info'+upid+' .name').html());
	$('.queteinfo .floor').html($('.info'+upid+' .floor').html());
	$('.queteinfo .date').html($('.info'+upid+' .date').html());
	$('.queteinfo').show();
	$('#textarea2').focus();
	top.resetmain();
	top.window.scrollTo(0,document.body.scrollHeight);
});
$('.delets').click(function(){
	$('.queteinfo').hide();
	upid = 0;
});
</script>
</body>
</html>