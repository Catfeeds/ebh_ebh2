<?php $this->display('college/page_header'); ?>
<?php $this->widget('sendmessage_widget'); ?>
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
</style>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.min.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css" media="screen" />

<div class="lefrig" style="width:1000px;background:#fff;float:left;margin-top:15px;">
<div class="workol">
	<div class="work_mes" style="width:1000px;">
		<ul>
			<li class="workcurrent"><a href="<?= geturl('college/msg/message') ?>"><span>新私信</span></a></li>
			<li><a href="<?= geturl('college/msg/answer') ?>"><span>新回答</span></a></li>
		</ul>
	</div>

			<div class="workdata" style="margin-top:0px;float:left;width:1000px;">
				<table  width="100%" class="datatab" style="border:none;">
			 	 <thead class="tabhead" >
			  	</thead>
			  	<tbody>
						<?php if(empty($msglist)) { ?>
			  			<tr>
							<td colspan="6" align="center" style="border-top:none; border-bottom:none;"><div class="nodata"></div></td>
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
												<div style="float:left;margin-right:15px;"><img title="系统管理员" style="width:50px; height:50px;border-radius:25px;"  src="<?=getthumb('http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg','50_50')?>" /></div>
													<div style="float:left;width:900px;font-family:Microsoft YaHei;">
														<p style="width:900px;word-wrap: break-word;margin-bottom:10px;font-size:14px;;float:left;line-height:2;"><?php if(!empty($message)) {?>您在 <a style="color:#2696f0;font-weight:bold;text-decoration:underline;" href="<?= geturl('college/myask/'.$value['sourceid']) ?>" target="_blank"><?=$message['title']?></a> 问题的解答中获得了 <?=$message['reward']?>积分<?php } else {echo $value['message'];} ?></p>
													<div style="float:left;width:900px;">
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
										//var_dump($value);
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
												<div style="float:left;margin-right:15px;"><img title="<?= empty($value['realname'])?$value['username']:$value['realname'] ?>" src="<?=$face?>" style="width:50px; height:50px;border-radius:25px;" /></div>
													<div style="float:left;width:910px;font-family:Microsoft YaHei;">
														<p style="width:910px;word-wrap: break-word;margin-bottom:10px;font-size:14px;;float:left;line-height:2;"><?= $value['message'] ?></p>
													<div style="float:left;width:910px;">
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
													<span class="huirenw"><?=empty($value['realname'])?$value['username']:$value['realname'] ?></span>
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
</body>
</html>