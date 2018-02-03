<?php $this->display('college/page_header'); ?>
<?php $this->widget('sendmessage_widget'); ?>
<style type="text/css">
	.refreshbtn {
	    background: url("http://static.ebanhui.com/ebh/tpl/2014/images/studyjl.png") no-repeat left center;
	    color: #626262;
	    font-family: "微软雅黑";
	    font-size: 14px;
	    padding-left: 25px;
	    margin-right: 10px;
	    text-decoration: none;
	}
	.rblue {
		color:#3366CC;
	}
	.cred {
		color:#f00;
	}
</style>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<div class="lefrig" style="background:#fff;float:left;width:1000px;">
<div class="workol">
	<div id="refreshbtnwrap" style="width:100%;height:20px;float:right;text-align: center;cursor: pointer;"><span class="refreshbtn" style="text-decoration: none;">刷新作业</span></div>
 	<div class="workdata" style="width:998px;">
	    	<table width="100%" class="datatab" style="border:none;">
				 <tbody>
				 <?php if(!empty($elist)) { ?>
				 	<?php
				 		$status_map = array(
				 			'0'=>'草稿',
				 			'1'=>'进行中',
				 			'3'=>'已完成'
				 		);
				 	?>
					<?php foreach($elist as $e) { ?>
						<?php
							if(count($e['alist']) == 0){
								$startname = "开始巩固";
							}else{
								$startname = "继续巩固";
							}
						?>
						<tr>
							<td style="border-top:none;">
								<div style="float:left;width:966px;font-family:simsun;margin-left:10px;">
									<p style="width:715px;word-wrap: break-word;font-size:16px;;float:left;line-height:2;"><?=$e['title']?></p>
									<span style="float:right;width:240px;">
										<?php if(empty($e['status'])){?>
											<a class="previewBtn" style="font-family: 宋体;line-height: 28px;width:72px;height:28px;margin-top:6px;float:right;" target="_blank" href="http://exam.ebanhui.com/ssmarteedit/<?=$crid?>/<?=$e['eid']?>.html">编辑草稿</a>
										<?php }?>
										<a class="previewBtn" style="font-family: 宋体;line-height: 28px;width:72px;height:28px;margin-top:6px;float:right;" href="javascript:delexam(<?=$e['eid']?>)">删 除</a>
										<?php if(!empty($e['cannew']) && !empty($e['status'])){?>
										<a class="previewBtn" style="font-family: 宋体;line-height: 28px;width:72px;height:28px;margin-top:6px;float:right;" target="_blank" href="http://exam.ebanhui.com/smartedo/<?=$e['eid']?>.html"><?=$startname?></a>
										<?php }?>
									</span>
									<div style="float:left;width:790px;">
										<span class="huirenw" style="width:auto;float:left;color:#999;padding-left:0;background:none;">
											<?=date('Y-m-d H:i',$e['dateline'])?> 出题，总分为：<?=$e['score']?>，<?php if(empty($e['limitedtime'])){echo '不计时';}else{echo '计时：'.$e['limitedtime'].' 分钟';}?> <?=$status_map[$e['status']]?>
										</span>
									</div>
									<div style="float:left;width:790px;margin-top:5px;"><span style="color:#aaa;">答题记录：</span></div>
									<?php foreach ($e['alist'] as $ak=>$a) {?>
										<div style="float:left;width:790px;">
											<span class="huirenw" style="width:auto;float:left;color:#888;padding-left:0;background:none;">
												<span class="rblue">第<?=$ak+1?>次答题</span> <?=date('Y-m-d H:i:s',$a['dateline'])?> 答题，总分：<?=$a['score']?> 得分：<?=$a['totalscore']?>，答对：<span class="cred"><?=$a['truenum']?></span> 题，答错：<span class="cred"><?=$a['falsenum']?></span> 题，答题耗时：<?=secondToStr($a['completetime'])?>
											</span>
											<span style="margin-left:10px;float:left;">
												<?php if(empty($a['status'])){?>
													<a style="text-decoration: none;" target="_blank" href="http://exam.ebanhui.com/smartedo/<?=$a['eid']?>/<?=$a['aid']?>.html" >继续答题</a>
												<?php }else{?>
													<a style="text-decoration: none;" target="_blank" href="http://exam.ebanhui.com/smartemark/<?=$a['eid']?>/<?=$a['aid']?>.html" >查看结果</a>
												<?php }?>
											</span>
										</div>
									<?php }?>
								</div>
							</td>
					</tr>
					<?php } ?>
				 <?php } else { ?>
					<tr>
				 		<td colspan="6" align="center" style="border-top:none;"><div class="nodata"></div></td>
				 	</tr>
				 <?php } ?>
				</tbody>
			</table>
				<?= $pagestr ?>
	    </div>
	</div>
</div>
<script type="text/javascript">
	function delexam(eid){
		$.ajax({
	        url:"<?=geturl('smartexam/smartexam/delexam')?>",
	        type:"post",
	        dataType:"json",
	        data: {eid:eid},
	        success:function(res){
	        	if(res.status == 0){
	        		alert('删除成功');
	        		location.reload(1);
	        	}else{
	        		location.reload(1);
	        		alert(res.msg);
	        	}
	        }
	    });
	}

	$(function(){
		$("#refreshbtnwrap").bind('click',function(){
			location.reload(1);
		}).bind('mouseover',function(){
			$(".refreshbtn").css({'color':'#f00'});
		}).bind('mouseleave',function(){
			$(".refreshbtn").css({'color':'#626262'});
		})
	});
</script>
<?php $this->display('myroom/page_footer'); ?>