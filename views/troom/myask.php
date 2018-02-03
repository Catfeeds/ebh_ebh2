<?php $this->display('troom/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.min.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css" media="screen" />
<div class="ter_tit">
当前位置 > <a href="<?= geturl('troom/myask') ?>">师生答疑</a> > 全部问题
<div class="diles">
	<?php
		$q= empty($q)?'':$q;
		if(!empty($q)){
			$stylestr = 'style="color:#000"';
		}else{
			$stylestr = "";
		}
	?>
	<input name="title" <?=$stylestr?> class="newsou" id="title" value="<?=$q?>" type="text" />
	<input id="ser" type="button" class="soulico" value="">
</div>
</div>
<div class="lefrig" style="background:#fff;margin-top:15px;float:left;">
<div class="workol">
	<div class="work_mes">
		<ul class="extendul">
			<li><a href="<?= geturl('troom/myask/askme') ?>"><span>提给我的</span></a></li>
			<li><a href="<?= geturl('troom/myask') ?>"><span>课程问题</span></a></li>
			<li><a href="<?= geturl('troom/myask/classquestion') ?>"><span>班级问题</span></a></li>
			<li class="workcurrent"><a href="<?= geturl('troom/myask/allquestion') ?>"><span>全部问题</span></a></li>
			<li><a href="<?= geturl('troom/myask/myquestion') ?>"><span>我的问题</span></a></li>
			<li><a href="<?= geturl('troom/myask/myanswer') ?>"><span>我的回答</span></a></li>
			<li><a href="<?= geturl('troom/myask/myfavorit') ?>"><span>我的关注</span></a></li>
			<!-- 新增 -->
			<li><a href="<?= geturl('troom/myask/settled') ?>"><span>已解决</span></a></li>
			<li><a href="<?= geturl('troom/myask/hot') ?>"><span>热门</span></a></li>
			<li><a href="<?= geturl('troom/myask/recommend') ?>"><span>推荐</span></a></li>
			<li><a href="<?= geturl('troom/myask/wait') ?>"><span>等待回复</span></a></li>
		</ul>
	</div><a class="questionbutton" style="color:#fff;float:right;" href="<?= geturl('troom/myask/addquestion') ?>">提&nbsp;&nbsp;问</a>
			<div class="workdata" style="float:left;margin-top:0">
				<table  width="100%" class="datatab" style="border:none;">
				
				<tbody>
	
                                <?php if(empty($asks)) { ?>
			  		<tr><td style="border-top:none;" colspan="5" align="center">目前没有问题记录</td></tr>
                                <?php } else { ?>
			  	
                        <?php foreach($asks as $akey=>$avalue) { ?>
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
							<?php $name=empty($avalue['realname'])?$avalue['username']:$avalue['realname'] ?>
							<div style="float:left;margin-right:15px;"><a href="http://sns.ebh.net/<?=$avalue['uid']?>/main.html" target="_blank"><img title="<?= empty($avalue['realname'])?$avalue['username']:$avalue['realname'] ?>的个人空间" src="<?=$face?>" /></a></div>
							<div style="float:left;width:670px;font-family:Microsoft YaHei;">
								<p style="width:550px;word-wrap: break-word;margin-bottom:10px;font-size:14px;;float:left;line-height:2;">
								<?php if(!empty($avalue['reward'])){?>
									<span style="color:red;font-weight:bold" title="此题悬赏<?=$avalue['reward']?>积分">
									悬赏<?=$avalue['reward']?>
									<img src="http://static.ebanhui.com/ebh/tpl/2014/images/rewardcoin.png"/>
									</span>
								<?php }?>
								<!--如果是老师已经回答过的标题为蓝色-->
								<a href="<?= geturl('troom/myask/'.$avalue['qid']) ?>" style="color:<?= in_array(intval($avalue['qid']),$myanswered)?'#2696f0':'#777' ?>;font-weight:bold;">
								<?php if($avalue['status']==1){ ?>
								<img src="http://static.ebanhui.com/ebh/tpl/default/images/title.png" style="margin-right:5px;" title="已有最佳答案"/>
								<?php } ?>
								<?= $avalue['title'] ?></a>
								</p>
								<span style="width:55px;text-align:center;float:right;line-height:2;background:url(http://static.ebanhui.com/ebh/tpl/default/images/modu.png) no-repeat 0px 28px;">回答数<br/><?= $avalue['answercount'] ?></span>
								<div style="float:left;width:550px;">
								<?php 
									//七天内的时间用红色显示
									$today_time = strtotime('today');
									$dateline_color = (($today_time - $avalue['dateline']) <= 604800 ) ? 'color:red;' : '';
                                ?>
                                <span style="width:150px;float:left;<?=$dateline_color?>"><?=timetostr($avalue['dateline'])?></span>
								<span class="huirenw" style="width:100px;float:left;"><?= empty($avalue['realname'])?$avalue['username']:$avalue['realname'] ?></span>
								<span style="width:200px;float:left;background:url(http://static.ebanhui.com/ebh/tpl/default/images/label.png) no-repeat;padding-left:24px;"><?= $avalue['foldername'] ?></span>
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
<script type="text/javascript">
var searchtext = "请输入关键字";
$(function() {
   initsearch("title",searchtext);
   $("#ser").click(function(){
       var title = $("#title").val();
       if(title == searchtext) 
           title = "";
       var url = '<?= geturl('troom/myask/allquestion') ?>' + '?q='+title;
       document.location.href = url;
   });
});
</script>
<?php $this->display('troom/page_footer'); ?>