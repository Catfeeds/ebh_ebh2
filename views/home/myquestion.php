<?php $this->display('home/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<div class="ter_tit">
当前位置 > <a href="<?= geturl('home/largedb') ?>">历史数据</a> > 我的答疑
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
<div class="weaktil">
<span class="datek">我的答疑</span>
</div>
<div class="workol">
			<div class="workdata" style="margin-top:0px;float:left;">
				<table  width="100%" class="datatab" style="border:none;">			  
			  	<tbody>			
                		<?php $tcount = 0; ?>  
                                <?php if(empty($asks)) { ?>
			  		<tr><td colspan="5" align="center" style="border:none;">目前没有问题记录</td></tr>
							<?php } else { ?>
                                        <?php foreach($asks as $akey=>$avalue) { $tcount++; ?>
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
                        <?php if($tcount == 1){ ?>
                        <td style="border-top:none;">
						<?php } else { ?>
                        <td>
                        <?php } ?>
							<div style="float:left;width:765px;font-family:Microsoft YaHei;">
								<p style="width:580px;word-wrap: break-word;margin-bottom:10px;font-size:14px;;float:left;line-height:2;">
								<?php if(!empty($avalue['crname'])){?>
									<a href="<?= substr($avalue['murl'],0,strrpos($avalue['murl'],'.'))?>/myask/<?=$avalue['qid']?>.html" style="color:#777;font-weight:bold;" 
									target="blank"> 
									<?= $avalue['title'] ?>
									</a>
								<?php }else{ ?>
									<a href="<?= $avalue['askurl'] ?>" style="color:#777;font-weight:bold;"> 
									<?= $avalue['title'] ?>
									</a>
								<?php } ?>
								</p>

								<span class="dashu">回答数<br/><?= $avalue['answercount'] ?></span>
							<div style="float:left;width:620px;">
							<span style="width:150px;float:left;"><?= Date('Y-m-d H:i:s',$avalue['dateline']) ?></span>
							<span style="width:100px;float:left;"><a href="<?=$avalue['murl']?>" target="_blank"><?= $avalue['crname'] ?></a></span>
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
       var url = '<?= geturl('home/largedb/myquestion') ?>' + '?q='+title;
       document.location.href = url;
   });
});
</script>
<?php 
$this->display('home/page_footer');
?>