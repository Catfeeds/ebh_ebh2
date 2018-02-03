<?php $this->display('troomv2/page_header'); ?>
<?php $this->widget('sendmessage_widget', array(), array('room_type' => 'troom', 'reload' => 'yes')); ?>
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/tzds.css" rel="stylesheet" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.min.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css" media="screen" />
<div class="lefrig">

	<div class="work_mes" style="float:none; margin-bottom:15px;">
		<ul>
			<li class="workcurrent"><a href="<?= geturl('troomv2/msg/sendlist') ?>"><span>私信列表</span></a></li>
			<li><a href="<?= geturl('troomv2/msg/send') ?>"><span>写私信</span></a></li>
		</ul>
	</div>

			<div class="workdata" style="margin-top:0px;float:left;">
				<table  width="100%" class="datatab" style="border:none;">
			 	 <thead class="tabhead" >
					<tr>
						<th style="padding-left:35px;">收件人</th>
						<th style="text-align:center;">时间</th>
						<th style="padding-left:15px;">内容</th>
					  </tr>
			  	</thead>
			  	<tbody>
						<?php if(empty($msglist)) { ?>
			  			<tr>
							<td colspan="6" align="center" style="border-top:none;">目前没有已发送私信</td>
						</tr>
                         <?php } else { ?>
								<?php
								foreach($msglist as $value) {

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
										<td width="25%">
											<div style="float:left;margin-right:15px;"><img title="<?= empty($value['realname'])?$value['username']:$value['realname'] ?>" src="<?=$face?>" style="width:40px;height:40px;border-radius:20px;" /></div>
											<div style="width:120px;float:left;">
												<span style="float:left;"><?= empty($value['realname'])?$value['username']:$value['realname'] ?></span>
                                                <a class="hrelh" href="javascript:;" tid="<?=$value['toid']?>" tname="<?= empty($value['realname'])?$value['username']:$value['realname'] ?>" title="给<?=$value['sex'] == 1 ? '她' : '他'?>发私信"></a>
												<div style="clear:both;"></div>
												<span style="float:left;"><?= $value['username'] ?></span>
                                             </div>
										</td>
										<td width="25%" style="text-align:center;"><span ><?= $day.'&nbsp&nbsp'.Date('H:i:s',$value['dateline'])?></span></td>
										<td width="50%" style="text-align:left;word-wrap: break-word;font-size:14px;line-height:2;padding:0 10px;"><?= $value['message'] ?></td>
									</tr>

                                <?php } ?>
                          <?php } ?>

			  	</tbody>


				</table>

			</div>
                        <?= $pagestr ?>

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