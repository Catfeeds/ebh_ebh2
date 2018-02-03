<?php $this->display('college/page_header'); ?>
<style>
.work_mes a.workbtns {
   background: #6489ac ;
    border-radius: 3px;
    color: #fff;
    display: inline-block;
    overflow: hidden;
    padding: 6px 20px;
    vertical-align: -2px;
	float:left;
	margin-left: 10px;
	margin-top:4px;
}

.datatab a {
    color: #81a2e2;
}
</style>
<div class="lefrig" style="background:#fff;float:left;">
<?php 
if(!empty($folder)){
	$this->assign('selidx',3);
	$this->display('college/course_nav');
}?>
<div class="workol">
	<div class="work_mes" style="width:1000px; position:relative;">
		<ul style="float:left; display:inline;">
			<li><a href="<?= geturl('college/myask/all') ?>"><span>全部问题</span></a></li>
			<li><a href="<?= geturl('college/myask/settled') ?>"><span>已解决</span></a></li>
			<li><a href="<?= geturl('college/myask/hot') ?>"><span>热门</span></a></li>
			<li><a href="<?= geturl('college/myask/recommend') ?>"><span>推荐</span></a></li>
			<li><a href="<?= geturl('college/myask/wait') ?>"><span>等待回复</span></a></li>
			<li><a href="<?= geturl('college/myask/myquestion') ?>"><span>我的问题</span></a></li>
			<li><a href="<?= geturl('college/myask/myanswer') ?>"><span>我的回答</span></a></li>
			<li class="workcurrent"><a href="<?= geturl('college/myask/myfavorit') ?>"><span>我的关注</span></a></li>
		</ul>
		<div><a href="/college/myask/addquestion.html" style="color:#fff;text-decoration: none;" class="workbtns">我要提问</a></div>
		<?php if(empty($folder)){?>
		<div class="diles" >
			<?php
				$q= empty($q)?'':$q;
				if(!empty($q)){
					$stylestr = 'style="color:#000"';
				}else{
					$stylestr = "";
				}
			?>
			<input name="txtname" <?=$stylestr?> class="newsou" id="title" value="<?= $q?>" type="text" />
			<input type="button" class="soulico" value="" id="ser">
		</div>
		<?php }?>
	</div>
			<div class="workdata" style="margin-top:0px;float:left; width:1000px;">
				<table  width="100%" class="datatab" style="border:none;">
			  
				<tbody>
                                <?php if(empty($asks)) { ?>
			  		<tr><td colspan="6" align="center" class="nonejunrs" style="border-top:none;"><div class="nodata"></div></td></tr>
                                <?php } else { ?>
                                        <?php foreach($asks as $avalue) { ?>
                                        
                       <?php 
						//var_dump($avalue);
							if(!empty($avalue['face']))
								$face = getthumb($avalue['face'],'50_50');
							else{
								if($avalue['sex']==1){
									if($avalue['groupid']==5){
										$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
									}else{
										$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
									}
								}else{
									if($avalue['groupid']==5){
										$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
									}else{
										$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
									}
								}
							
								$face = getthumb($defaulturl,'50_50');
							} 
						?>                    
				 		<tr class="kettshe">
						<td style="border-top:none;">
						<div style="float:left;margin-right:15px;"><a href="<?php if ($user['uid'] != $avalue['uid']) { ?>/sns/feeds/<?=$avalue['uid']?>.html<?php } else { ?>/sns/feeds/my.html<?php } ?>"><img class="radiust" title="<?= empty($avalue['realname'])?$avalue['username']:$avalue['realname'] ?>的个人空间" src="<?=$face?>" /></a></div>
							<div style="float:left;width:860px;font-family:simsun;">
								<p style="width:750px;word-wrap: break-word;font-size:16px;float:left;line-height:2;">
								<?php if(!empty($avalue['reward'])){?>
									<span style="color:red;font-weight:bold" title="此题悬赏<?=$avalue['reward']?>积分">
									悬赏<?=$avalue['reward']?>
									<img src="http://static.ebanhui.com/ebh/tpl/2014/images/rewardcoin.png"/>
									</span>
								<?php }?>
									<a target="blank"  href="<?= geturl('college/myask/'.$avalue['qid']) ?>" style="color:#666;font-weight:bold;">
										<?= $avalue['title'] ?>
									</a>
								</p>
								<span class="dashu">回答数<br/><?= $avalue['answercount'] ?></span>
								<div style="float:left;width:750px;">
								<?php 
									//七天内的时间用红色显示
									$today_time = strtotime('today');
									$dateline_color = (($today_time - $avalue['dateline']) <= 604800 ) ? 'color:red;' : '';
								?>
								<span style="width:220px;float:left;<?=$dateline_color?>"><?=timetostr($avalue['dateline'])?></span>
								<span class="huirenw" style="width:180px;float:left;"><?= empty($avalue['realname'])?$avalue['username']:$avalue['realname'] ?></span>
								<span class="ketek"><?= $avalue['foldername'] ?></span>
							</div>
						</div>
							</td>
				    	</tr>
                                        <?php } ?>
                                <?php } ?>
			  	</tbody>
				</table>
			</div>
    <?= $pagestr ?>
</div>
</div>

<script type="text/javascript">
    var searchtext = "请输入关键字";
$(function() {
	initsearch("title",searchtext);
	$("#ser").click(function(){
		var title = $("#title").val();
		if(title == searchtext) 
			title = "";
		var url = '<?= geturl('college/myask/myfavorit') ?>' + '?q='+title;
		<?php if(!empty($folder)){
			$itemid = $this->input->get('itemid');?>
		url += '&folderid=<?=$folder['folderid']?>';
		url += '&itemid=<?=!empty($itemid)?$itemid:''?>';
		<?php }?>
		document.location.href = url;
	});
	<?php if(!empty($folder)){?>
		$.each($('.work_mes li a,.workbtns'),function(k,v){
			$(this).attr('href',$(this).attr('href')+'?folderid=<?=$folder['folderid']?>&itemid=<?=$itemid?>');
		});
		$.each($('.huirenw a, .ketek a, .cwsp a'),function(k,v){
			$(this).attr('href',$(this).attr('href')+'&folderid=<?=$folder['folderid']?>&itemid=<?=$itemid?>');
		});
	<?php }?>
});
function delfavorit(aid) {
    var url = "<?= geturl('college/myask/delfavorit') ?>";
    $.ajax({
	url:url,
	type:'post',
	data:{'aid':aid},
	dataType:'text',
	success:function(data){
            if(data == "success")
                document.location.href = document.location.href;
            else
                alert("取消关注失败，请稍后再试");
	}
    });
}
</script>
<?php 
$this->display('myroom/page_footer');
?>