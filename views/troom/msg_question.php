<?php $this->display('troom/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.min.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css" media="screen" />
<div class="ter_tit">
当前位置 > <a href="<?= geturl('troom/msg') ?>">我的消息</a> > 新问题

</div>
<div class="lefrig" style="background:#fff;margin-top:15px;float:left;">
<div class="workol">
	<div class="work_mes">
		<ul>
			<li><a href="<?= geturl('troom/msg/message') ?>"><span>新私信</span></a></li>
			<li class="workcurrent"><a href="<?= geturl('troom/msg/question') ?>"><span>新问题</span></a></li>
			<li><a href="<?= geturl('troom/msg/answer') ?>"><span>新回答</span></a></li>
			<li><a href="<?= geturl('troom/msg/review') ?>"><span>新评论</span></a></li>
		</ul>
	</div>

			<div class="workdata" style="margin-top:0px;float:left;">
				<table  width="100%" class="datatab" style="border:none;">
			 	 <thead class="tabhead" >
			  	</thead>
			  	<tbody>
						<?php if(empty($msglist)) { ?>
			  			<tr>
							<td colspan="6" align="center" style="border-top:none;">目前没有新问题</td>
						</tr>
                         <?php } else { ?>
									<?php foreach($msglist as $value) { ?>
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
											<?php $name=empty($value['realname'])?$value['username']:$value['realname'] ?>
												<div style="float:left;margin-right:15px;"><img title="<?= empty($value['realname'])?$value['username']:$value['realname'] ?>" src="<?=$face?>" /></div>
													<div style="float:left;width:690px;font-family:Microsoft YaHei;">
														<p style="width:520px;word-wrap: break-word;margin-bottom:10px;font-size:14px;;float:left;line-height:2;">
														<?php
                                                            $ulist = array();
                                                            $uarray = array();
                                                            if (!empty($value['ulist']))
                                                            {
                                                                parse_str($value['ulist'],$ulist);
                                                                foreach ($ulist as $ukey => $uvalue) {
                                                                    $uarray[] = $uvalue;
                                                                }
                                                            echo implode('、',$uarray) . ' 向您提出了问题 ';
    
                                                            }
                                                        ?>

                                                        	<a style="color:#2696f0;font-weight:bold;text-decoration:underline;" href="<?= geturl('troom/myask/'.$value['sourceid']) ?>" ><?= $value['message'] ?></a>
                                                        </p>
													<div style="float:right;width:150px;">
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
													<span style="width:150px;color:<?= $day == '今天'?'red':''?>"><br /><?= $day.'&nbsp&nbsp'.Date('H:i:s',$value['dateline'])?></span>
													
													
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
$(function() {
   window.parent.msgcount();
});
</script>
<?php $this->display('troom/page_footer'); ?>