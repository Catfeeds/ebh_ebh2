<?php $this->display('troomv2/page_header'); ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<style>
#icategory {
    background: none repeat scroll 0 0 #F7FAFF;
    border-top: 1px solid #E1E7F5;
    padding: 6px 20px;
	_margin-bottom:-5px;
}
#icategory dt {
    float: left;
    line-height: 22px;
    padding-right: 5px;
    text-align: left;
}
#icategory dd {
    float: left;
    width: 645px;
}
.category_cont1 div a.curr, .price_cont div a:hover, .price_cont div a.curr {
	background: none repeat scroll 0 0 #FF5400;
	color: #FFFFFF;
	text-decoration: none;
}
.category_cont1 div a {
    color: #2C71AE;
    text-decoration: none;
    padding: 2px;
    cursor: pointer;
}
.category_cont1 div {
    float: left;
    height: 25px;
    line-height: 22px;
    overflow: hidden;
	padding:0 10px;
}
.key_word {
	padding: 6px 20px;
	border-bottom-width: 1px;
	border-bottom-style: solid;
	height:28px;
	border-bottom-color: #cdcdcd;
}
.key_word dt {
    float: left;
    line-height: 22px;
    padding-right: 5px;
    text-align: left;
}
.pbtns {
    background: url(http://static.ebanhui.com/ebh/tpl/2012/images/sunt0518.png) repeat scroll 0 0 transparent;
    border: medium none;
    color: #333333;
    height: 20px;
    vertical-align: middle;
    width: 40px;
	cursor:pointer;
}

.datatab td {
    color: #808080;
}
.work_mes a.workbtns {
    background: #6489ac ;
    border-radius: 3px;
    color: #fff;
    display: inline-block;
    overflow: hidden;
    padding: 6px 20px;
    vertical-align: -2px;
	float:left;
	margin-left: 120px;
	*margin-left: 75px;
	margin-top:4px;
}

.datatab a {
    color: #81a2e2;
}


</style>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.min.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css" media="screen" />

<div class="lefrig">
<?php $this->display('troomv2/course_menu');?>
<div class="workol">
<?php if(!empty($asks)) { ?>
			<div class="workdata" style="margin-top:15px;float:left;width:1000px;">
				<table  width="100%" class="datatab" style="border:none;">
			 	 <thead class="tabhead" >
			  	</thead>
			  	<tbody>

					<?php foreach($asks as $akey=>$avalue) { ?>
						 <?php 
						//var_dump($avalue);
							if(!empty($avalue['face'])){
								$face = getthumb($avalue['face'],'50_50');
							}else{
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
							<?php $name=empty($avalue['realname'])?$avalue['username']:$avalue['realname'] ?>
								<div style="float:left;margin-right:15px;"><a href="http://sns.ebh.net/<?=$avalue['uid']?>/main.html" target="_blank"><img class="radiust" title="<?= empty($avalue['realname'])?$avalue['username']:$avalue['realname'] ?>的个人空间" src="<?=$face?>" /></a></div>
									<div style="float:left;width:860px;font-family:simsun;">
										<p style="width:750px;word-wrap: break-word;font-size:16px;float:left;line-height:2;">
											<?php if(!empty($avalue['reward'])){?>
											<span style="color:red;font-weight:bold" title="此题悬赏<?=$avalue['reward']?>积分">
											悬赏<?=$avalue['reward']?>
											<img src="http://static.ebanhui.com/ebh/tpl/2014/images/rewardcoin.png"/>
											</span>
											<?php }?>
											<a href="<?= geturl('troomv2/myask/'.$avalue['qid']) ?>" target="_blank" style="color:#666;font-weight:bold;font-size:16px;">
											<?php if($avalue['status']==1){ ?>
												<img src="http://static.ebanhui.com/ebh/tpl/default/images/title.png" style="margin-right:5px;"/>
												<?php } ?>
											
											<?= $avalue['title'] ?>
											</a>
										</p>

										<span class="dashu" style="background:none">回答数<br/><?= $avalue['answercount'] ?>/<?=$avalue['viewnum']?></span>
									<div style="float:left;width:750px;">
									<?php
										//七天内的时间用红色显示
										$today_time = strtotime('today');
										$dateline_color = (($today_time - $avalue['dateline']) <= 604800 ) ? 'color:red;' : '';
									?>
									<span style="width:150px;float:left;<?=$dateline_color?>"><?=timetostr($avalue['dateline'])?></span>
									<span class="huirenw" style="width:250px;float:left;"><?= empty($avalue['realname'])?$avalue['username']:$avalue['realname'] ?></span>
									
									</div>
									<?php if(!empty($avalue['cwid'])){?>
									<div style="float:left;width:600px;margin-top:5px; margin-left:150px;">
									<span class="cwsp" style="margin-left:294px"><!--<a href="/troomv2/myask/all.html?cwid=<?=$avalue['cwid']?>">--><?=shortstr($avalue['cwname'],40)?><!--</a>--></span>
									</div>
									<?php }?>
								</div>

						</td>
					</tr>
					<?php } ?>

			  	</tbody>


				</table>
				<?= $pagestr ?>
			</div>
	</div>
    <?php }else{?>
       <?=nocontent()?>
    <?php }?>
</div>
<script type="text/javascript">
$(function(){
    $('.datatab tr:last td').css('border-bottom','none');
});


</script>
<?php $this->display('myroom/page_footer'); ?>