<?php $this->display('myroom/page_header'); ?>
<div class="ter_tit">
当前位置 > <a href="<?= geturl('myroom/myask') ?>">互动答疑</a> > 我的关注
<div class="diles">
	<?php
		$q= empty($q)?'':$q;
		if(!empty($q)){
			$stylestr = 'style="color:#000"';
		}else{
			$stylestr = "";
		}
	?>
	<input name="uname" <?=$stylestr?> class="newsou" id="title" value="<?=$q?>" type="text" />
	<input id="ser" type="button" class="soulico" value="">
</div>
</div>
<div class="lefrig" style="border:solid 1px #cdcdcd;background:#fff;float:left;margin-top:15px;">
<div class="workol">
	<div class="work_mes">
		<ul>
			<li><a href="<?= geturl('myroom/myask/all') ?>"><span>全部问题</span></a></li>
			<li><a href="<?= geturl('myroom/myask/settled') ?>"><span>已解决</span></a></li>
			<li><a href="<?= geturl('myroom/myask/hot') ?>"><span>热门</span></a></li>
			<li><a href="<?= geturl('myroom/myask/recommend') ?>"><span>推荐</span></a></li>
			<li><a href="<?= geturl('myroom/myask/wait') ?>"><span>等待回复</span></a></li>
			<li><a href="<?= geturl('myroom/myask/myquestion') ?>"><span>我的问题</span></a></li>
			<li><a href="<?= geturl('myroom/myask/myanswer') ?>"><span>我的回答</span></a></li>
			<li class="workcurrent"><a href="<?= geturl('myroom/myask/myfavorit') ?>"><span>我的关注</span></a></li>
		</ul>
	</div>
			<div class="workdata" style="margin-top:0px;float:left;">
				<table  width="100%" class="datatab" style="border:none;">
			  
				<tbody>
                                <?php if(empty($asks)) { ?>
			  		<tr><td colspan="6" align="center" style="border-top:none;">目前没有我的关注</td></tr>
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
				 		<tr>
						<td style="border-top:none;">
						<div style="float:left;margin-right:15px;"><a href="http://sns.ebh.net/<?=$avalue['uid']?>/main.html" target="_blank"><img title="<?= empty($avalue['realname'])?$avalue['username']:$avalue['realname'] ?>的个人空间" src="<?=$face?>" /></a></div>
							<div style="float:left;width:690px;font-family:Microsoft YaHei;">
								<p style="width:580px;word-wrap: break-word;margin-bottom:10px;font-size:14px;;float:left;line-height:2;">
								<?php if(!empty($avalue['reward'])){?>
									<span style="color:red;font-weight:bold" title="此题悬赏<?=$avalue['reward']?>积分">
									悬赏<?=$avalue['reward']?>
									<img src="http://static.ebanhui.com/ebh/tpl/2014/images/rewardcoin.png"/>
									</span>
								<?php }?>
									<a target="blank"  href="<?= geturl('myroom/myask/'.$avalue['qid']) ?>" style="color:#777;font-weight:bold;">
										<?= $avalue['title'] ?>
									</a>
								</p>
								<span class="dashu">回答数<br/><?= $avalue['answercount'] ?></span>
								<div style="float:left;width:600px;">
								<?php 
									//七天内的时间用红色显示
									$today_time = strtotime('today');
									$dateline_color = (($today_time - $avalue['dateline']) <= 604800 ) ? 'color:red;' : '';
								?>
								<span style="width:150px;float:left;<?=$dateline_color?>"><?=timetostr($avalue['dateline'])?></span>
								<span class="huirenw" style="width:100px;float:left;"><?= empty($avalue['realname'])?$avalue['username']:$avalue['realname'] ?></span>
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
       var url = '<?= geturl('myroom/myask/myfavorit') ?>' + '?q='+title;
       document.location.href = url;
   });
});
function delfavorit(aid) {
    var url = "<?= geturl('myroom/myask/delfavorit') ?>";
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