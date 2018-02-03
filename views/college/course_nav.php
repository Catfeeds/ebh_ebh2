<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/listit.css?v=20160422" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css<?=getv()?>"/>

<style>
.dtkywe {
    height: 35px;
    position: absolute;
    right: 14px;
    top: 4px;
    width: 160px;
}
.work_mes a.workbtns{ margin-left:245px;}
.return {width:20px;height:20px;vertical-align: middle;margin-right:10px;}
</style>

	<div class="stktitl">
		
		<h3 class="lstfd"><a class="return" href="javascript:history.go(-1)" title="返回上级"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/return.png" /></a><?=$folder['foldername']?></h3>
		<div style="clear:both;"></div>
		<div class="diles" >
			<?php
				$q= empty($q)?'':$q;
				if(!empty($q)){
					$stylestr = 'style="color:#000"';
				}else{
					$stylestr = "";
				}
			?>
			<input name="txtname" <?=$stylestr?> class="newsou" id="title" value="<?= $q?>" type="text" />
			<input type="button" class="soulico" value="" id="ser">
		</div>
		
	</div>
	<?php 
		// $idx = $this->input->get('selidx');
		for($i=0;$i<7;$i++){
			if($i==$selidx)
				$selclass[$i] = 'class="sel"';
			else
				$selclass[$i] = '';
		}
		$itemid = $this->input->get('itemid');
		$itemstr1 = empty($itemid)?'':('?itemid='.$itemid);
		$itemstr2 = empty($itemid)?'':('&itemid='.$itemid);
        $roominfo = Ebh::app()->room->getcurroom();
        $roominfo['crid'] = empty($roominfo['crid'])?0:$roominfo['crid'];
        if(!empty($roominfo['crid'])){
            $other_config = Ebh::app()->getConfig()->load('othersetting');
            $other_config['zjdlr'] = !empty($other_config['zjdlr']) ? $other_config['zjdlr'] : 0;
            $other_config['newzjdlr'] = !empty($other_config['newzjdlr']) ? $other_config['newzjdlr'] : array();
            $is_zjdlr = ($roominfo['crid'] == $other_config['zjdlr']) || (in_array($roominfo['crid'],$other_config['newzjdlr']));
            $is_newzjdlr = in_array($roominfo['crid'],$other_config['newzjdlr']);
        }
	?>
	<div class="nav_list">
		<div class="nav_listson">
			<li><a <?=$selclass[0]?> href="<?=geturl('myroom/college/study/cwlist/'.$folder['folderid']).$itemstr1?>">课程目录</a></li>
			<li><a <?=$selclass[1]?> href="<?=geturl('myroom/college/study/introduce/undercourse/'.$folder['folderid']).$itemstr1?>">课程介绍</a></li>
			<?php if(!$is_zjdlr){?>
			<li><a <?=$selclass[5]?> href="<?=geturl('college/cwteacher').'?folderid='.$folder['folderid'].$itemstr2?>">任课教师</a></li>
			<li><a <?=$selclass[2]?> href="<?=geturl('college/myexam/all').'?folderid='.$folder['folderid'].$itemstr2?>">相关作业</a></li>
			<?php }?>
			<li><a <?=$selclass[3]?> href="<?=geturl('college/myask/all').'?folderid='.$folder['folderid'].$itemstr2?>">互动答疑</a></li>
			<li><a <?=$selclass[4]?> href="<?=geturl('college/attachment').'?folderid='.$folder['folderid'].$itemstr2?>">资料下载</a></li>
			<li><a <?=$selclass[6]?> href="<?=geturl('college/survey/surveylist').'?folderid='.$folder['folderid'].$itemstr2?>">调查问卷</a></li>
		</div>
		<?php if(!empty($showmodeselection)){?>
		<div class="dtkywe">
			<?php if(!$iszjdlr) { ?>
				<a href="javascript:void(0)" class="chousts" id="favorite">收藏</a>
			<?php } ?>
		</div>
		<?php }?>
	</div>
<script type="text/javascript">
$(function(){
	var is_zjdlr = <?=!empty($is_zjdlr) ? 'true' : 'false'?>;
	var folderid = <?=$folder['folderid']?>;
		$.ajax({
			type: "POST",
			url: "<?=geturl('myroom/college/studycount')?>",
			data: {folderid: folderid},
			dataType: "json",
			success: function(data) {
				if(data != undefined){
					if (!is_zjdlr) {
						if(data.examnum != undefined && data.examnum > 0){
							$(".nav_listson li:eq(3)").find("a").append('<span class="klerty">'+data.examnum+'</span>');
						}
						if(data.examnum != undefined && data.asknum > 0){
							$(".nav_listson li:eq(4)").find("a").append('<span class="klerty">'+data.asknum+'</span>');
						}
						if(data.examnum != undefined && data.surveynum > 0){
							$(".nav_listson li:eq(6)").find("a").append('<span class="klerty">'+data.surveynum+'</span>');
						}
					} else {
						if(data.examnum != undefined && data.asknum > 0){
							$(".nav_listson li:eq(2)").find("a").append('<span class="klerty">'+data.asknum+'</span>');
						}
						if(data.examnum != undefined && data.surveynum > 0){
							$(".nav_listson li:eq(4)").find("a").append('<span class="klerty">'+data.surveynum+'</span>');
						}
					}

				}
			}
		});
	


});
</script>