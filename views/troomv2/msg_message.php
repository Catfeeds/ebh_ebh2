<?php $this->display('troomv2/page_header'); ?>
<?php $this->widget('sendmessage_widget', array(), array('room_type' => 'troom')); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.min.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css" media="screen" />
<div class="lefrig">
<div class="workol">
	<div class="work_mes">
		<ul>
			<li class="workcurrent"><a href="<?= geturl('troomv2/msg/message') ?>"><span>新私信</span></a></li>
			<li><a href="<?= geturl('troomv2/msg/question') ?>"><span>新问题</span></a></li>
			<li><a href="<?= geturl('troomv2/msg/answer') ?>"><span>新回答</span></a></li>
			<li><a href="<?= geturl('troomv2/msg/review') ?>"><span>新评论</span></a></li>
		</ul>
	</div>

			<div class="workdata" style="margin-top:0px;float:left;">
				<table  width="100%" class="datatab" style="border:none;">
			 	 <thead class="tabhead" >
			  	</thead>
			  	<tbody>
						<?php if(empty($msglist)) { ?>
			  			<tr>
							<td colspan="6" align="center" style="border-top:none;">目前没有新私信</td>
						</tr>
                         <?php } else { ?>
								<?php foreach($msglist as $value) {
                                    if ($value['type'] == 1) {
										//判断字符串是否是数组的序列化
										if (preg_match('/^a:\d+:{.*}$/s', $value['message']))
										{
											$message = unserialize($value['message']);
										}
									?>
									<tr>
										<td style="border-top:none;">
												<div style="float:left;margin-right:15px;"><img class="imgyuan
" title="系统管理员"  src="<?=getthumb('http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg','50_50')?>" /></div>
													<div style="float:left;width:905px;font-family:Microsoft YaHei;">
														<p style="width:905px;word-wrap: break-word;margin-bottom:10px;font-size:14px;;float:left;line-height:2;"><?php if(!empty($message)) {?>您在 <a style="color:#2696f0;font-weight:bold;text-decoration:underline;" href="<?= geturl('troomv2/myask/'.$value['sourceid']) ?>" ><?=$message['title']?></a> 问题的解答中获得了 <?=$message['reward']?>积分<?php } else {echo $value['message'];} ?></p>
													<div style="float:left;width:905px;">
													<?php 
														$today_start = date("Y-m-d");
														$today_time = strtotime($today_start);
														$num = $value['dateline'] - $today_time;
														if($num>=0 && $num<86400){
															$day = '今天';
														}else if($num<0 && $num>-86400){
															$day = '昨天';
														}else if($num<-86400 && $num>-86400*2){
															$day = '前天';
														}else{
															$day = Date('Y-m-d',$value['dateline']);
														}
													?>
													<span style="width:150px;float:left;color:<?= $day == '今天'?'red':''?>"><?= $day.'&nbsp&nbsp'.Date('H:i:s',$value['dateline'])?></span>
													<span class="huirenw">系统管理员</span>													
													
													</div>
												</div>

										</td>
									</tr>                                    
                                    <?php } elseif ($value['type'] == 3) {?>
										 <?php
											if(!empty($value['face'])){
												$face = getthumb($value['face'],'50_50');
											}else{
												if($value['sex']==1){
													if($value['groupid']==5){
														$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
													}else{
														$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
													}
												}else{
													if($value['groupid']==5){
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
												<div style="float:left;margin-right:15px;width:50px;"><img class="imgyuan
"  title="<?= empty($value['realname'])?$value['username']:$value['realname'] ?>" src="<?=$face?>" /></div>
													<div style="float:left;width:905px;font-family:Microsoft YaHei;">
														<p style="width:905px;word-wrap: break-word;margin-bottom:10px;font-size:14px;;float:left;line-height:2;"><?= $value['message'] ?></p>
													<div style="float:left;width:905px;">
													<?php 
														$today_start = date("Y-m-d");
														$today_time = strtotime($today_start);
														$num = $value['dateline'] - $today_time;
														if($num>=0 && $num<86400){
															$day = '今天';
														}else if($num<0 && $num>-86400){
															$day = '昨天';
														}else if($num<-86400 && $num>-86400*2){
															$day = '前天';
														}else{
															$day = Date('Y-m-d',$value['dateline']);
														}
													?>
													<span style="width:150px;float:left;color:<?= $day == '今天'?'red':''?>"><?= $day.'&nbsp&nbsp'.Date('H:i:s',$value['dateline'])?></span>
													<span class="huirenw"><?= empty($value['realname'])?$value['username']:$value['realname'] ?></span>
                                                    <a class="hrelh" href="javascript:;" tid="<?=$value['fromid']?>" tname="<?= empty($value['realname'])?$value['username']:$value['realname'] ?>" title="给<?=$value['sex'] == 1 ? '她' : '他'?>发私信"></a>												
													
													</div>
												</div>

										</td>
									</tr>
									<?php }elseif ($value['type'] == 6) {
									$message = json_decode($value['message']);
										if(!empty($value['face'])){
												$face = getthumb($value['face'],'50_50');
											}else{
												if($value['sex']==1){
													if($value['groupid']==5){
														$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
													}else{
														$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
													}
												}else{
													if($value['groupid']==5){
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
												<div style="float:left;margin-right:15px;width:50px;"><img class="imgyuan
"  title="<?= empty($value['realname'])?$value['username']:$value['realname'] ?>" src="<?=$face?>" /></div>
													<div style="float:left;width:905px;font-family:Microsoft YaHei;">
														<p style="width:905px;word-wrap: break-word;margin-bottom:10px;font-size:14px;;float:left;line-height:2;">《<?php echo $message->title;?>》收到 ”<span style="color:red;"><?php echo $value['realname'];?></span>“ 发来的赞赏<span style="color:red;margin-left:45px;"><?php echo $message->totalfee;?></span>元</p>
													<div style="float:left;width:905px;">
													<?php 
														$today_start = date("Y-m-d");
														$today_time = strtotime($today_start);
														$num = $value['dateline'] - $today_time;
														if($num>=0 && $num<86400){
															$day = '今天';
														}else if($num<0 && $num>-86400){
															$day = '昨天';
														}else if($num<-86400 && $num>-86400*2){
															$day = '前天';
														}else{
															$day = Date('Y-m-d',$value['dateline']);
														}
													?>
													<span style="width:150px;float:left;color:<?= $day == '今天'?'red':''?>"><?= $day.'&nbsp&nbsp'.Date('H:i:s',$value['dateline'])?></span>
													<span class="huirenw"><?= empty($value['realname'])?$value['username']:$value['realname'] ?></span>
                                                    <a class="hrelh" href="javascript:;" tid="<?=$value['fromid']?>" tname="<?= empty($value['realname'])?$value['username']:$value['realname'] ?>" title="给<?=$value['sex'] == 1 ? '她' : '他'?>发私信"></a>
													</div>
												</div>

										</td>
									</tr>
									<?php } ?>
                                <?php } ?>
                          <?php } ?>

			  	</tbody>


				</table>
				
			</div>
                        <?= $pagestr ?>
</div>
</div>
<script type="text/javascript">
$(function() {
   window.parent.msgcount();
});
$(function(){
		$('.datatab tr:last td').css('border-bottom','none');
	});
</script>
<?php $this->display('troomv2/page_footer'); ?>