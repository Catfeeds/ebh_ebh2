<?php $this->display('troom/page_header'); ?>
<style>
a.ansbth {
    color:#fff;
    background:#4fcffd;
    border:none;
    display:block;
    float:right;
    width:55px;
    height:22px;
    line-height:22px;
    margin-left:10px;
    margin-top:5px;
    text-decoration: none;
    text-align:center;
}
</style>
<div class="ter_tit" style="width:819px;">
当前位置 > 关联问题
<div class="diles" style="right:38px;">
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
<div class="lefrig" style="border:solid 1px #cdcdcd;background:#fff;float:left;margin-top:15px;width:826px;min-height:580px;">
<div class="workol">
	</div>
		
			<div class="workdata" style="float:left;margin-top:0px;">
				<table  width="100%" class="datatab" style="border:none;">			
			  		
			  	<tbody>
                                <?php if(empty($asks)) { ?>
			  		<tr><td style="border-top:none;" colspan="6" align="center">目前没有问题记录</td></tr>
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
						<div style="float:left;margin-right:15px;"><img title="<?= empty($avalue['realname'])?$avalue['username']:$avalue['realname'] ?>" src="<?=$face?>" /></div>
							<div style="float:left;width:670px;font-family:Microsoft YaHei;">
								<p style="width:550px;word-wrap: break-word;margin-bottom:10px;font-size:14px;;float:left;line-height:2;">
									<?php if($avalue['status']==1){ ?>
										<img src="http://static.ebanhui.com/ebh/tpl/default/images/title.png" style="margin-right:5px;"/>
									<?php } ?>
									 <a target="_blank" href="<?= geturl('troom/myask/'.$avalue['qid']) ?>" style="color:#777;font-weight:bold;"><?= $avalue['title'] ?></a>
								</p>
								<!-- <span style="width:55px;text-align:center;float:right;line-height:2;background:url(http://static.ebanhui.com/ebh/tpl/default/images/modu.png) no-repeat 0px 28px;">回答数<br/><?= $avalue['answercount'] ?></span> -->
								<a href="javascript:void();" class="ansbth" onclick="qcalback(<?=$avalue['qid']?>)">关联</a>
								<div style="float:left;width:550px;">
								<span style="width:180px;float:left;"><?= Date('Y-m-d H:i:s',$avalue['dateline']) ?></span>
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
</div>

<script type="text/javascript">
    var searchtext = "请输入关键字";
$(function() {
   initsearch("title",searchtext);
   $("#ser").click(function(){
       var title = $("#title").val();
       if(title == searchtext) 
           title = "";
       var url = '<?= geturl('push/question') ?>' + '?q='+title;
       document.location.href = url;
   });
});
function qcalback(qid){
	parent.window.doquestionpush(qid);
}
</script>
<?php 
$this->display('troom/page_footer'); 
?>