	<?php 
	$uri = $this->uri;
	$controller = $uri->uri_control();
	$action = $uri->uri_method();
	
	$index = !empty($index) ? $index : 1;
//var_dump($controller);
//var_dump($action);
//var_dump($folderid);
    $roominfo = Ebh::app()->room->getcurroom();
    $roominfo['crid'] = empty($roominfo['crid'])?0:$roominfo['crid'];
	$classid = $this->input->get('classid');
    if(!empty($roominfo['crid'])){
    	$other_config = Ebh::app()->getConfig()->load('othersetting');
        $other_config['zjdlr'] = !empty($other_config['zjdlr']) ? $other_config['zjdlr'] : 0;
        $other_config['newzjdlr'] = !empty($other_config['newzjdlr']) ? $other_config['newzjdlr'] : array();
        $is_zjdlr = ($roominfo['crid'] == $other_config['zjdlr']) || (in_array($roominfo['crid'],$other_config['newzjdlr']));
        $is_newzjdlr = in_array($roominfo['crid'],$other_config['newzjdlr']); 
    }
	?>
	<h2 class="toaused"><?=$folder['foldername']?></h2>
<div class="work_mes">
	<ul style="float: left;">
		<li class="<?=($index ==1)?"workcurrent":""?>">
			<a href="/troomv2/classsubject/<?=$folderid?>.html?classid=<?=$classid?>">课程目录</a>
		</li>
		<li class="<?=($index ==2)?"workcurrent":""?>">
			<a href="/troomv2/courserelevant/introduce.html?folderid=<?=$folderid?>&classid=<?=$classid?>">课程介绍</a>
		</li>
		<!--判断是网校还是企业，企业$room_type变量输出1，0为网校-->
		<?php $room_type = Ebh::app()->room->getRoomType();$room_type = $room_type == 'com' ? 1 : 0;?>
		<?php if(!$is_zjdlr){ ?>
		<li class="<?=($index ==3)?"workcurrent":""?>">
			<a href="/troomv2/courserelevant/teacher.html?folderid=<?=$folderid?>&classid=<?=$classid?>"><?=($room_type==1) ? "任课讲师":"任课老师"?></a>
		</li>
		<?php }?>
		<li class="<?=($index ==4)?"workcurrent":""?>">
			<a href="/troomv2/courserelevant/exam.html?folderid=<?=$folderid?>&classid=<?=$classid?>">相关作业</a>
		</li>
		<li class="<?=($index ==5)?"workcurrent":""?>">
			<a href="/troomv2/courserelevant/interact.html?folderid=<?=$folderid?>&classid=<?=$classid?>">互动答疑</a>
		</li>
		<li class="<?=($index ==6)?"workcurrent":""?>">
			<a href="/troomv2/courserelevant/attachment.html?folderid=<?=$folderid?>&classid=<?=$classid?>">资料下载</a>
		</li>
		<li class="<?=($index ==7)?"workcurrent":""?>">
			<a href="/troomv2/courserelevant/survey.html?folderid=<?=$folderid?>&classid=<?=$classid?>">调查问卷</a>
		</li>
		<li class="<?=($index ==8)?"workcurrent":""?>">
			<a href="/troomv2/classsubject/coursecount/cw.html?folderid=<?=$folderid?>&classid=<?=$classid?>" style="color: #ff9500;<?=($index ==8)?'border-bottom:2px solid #ff9500;':''?>">统计分析</a>
		</li>
	</ul>
	<?php if ($index ==1) {?>
	<div id="courseserbox" class="courseserbox" style="float: right;margin-top: 15px;margin-right: 30px;">
		<input type="text" name="" id="searchq" style="width: 150px;height: 20px;border: 0 none;border: 1px solid #CCCCCC;float: left;" value="<?php echo empty($q)?'':$q;?>" />
		<a href="javascript:void(0)" style="float: left;margin-left: 5px;width: 50px;height: 22px;background: #338bff;text-align: center;color: #FFFFFF;font-size: 12px;line-height: 22px;cursor: pointer;" id="searcoursebtn">搜索</a>
	</div>
	<?php }?>
</div>
<script type="text/javascript">
	$("#searcoursebtn").click(function(){
		var q = $("#searchq").val();
		$("#searcoursebtn").attr("href",'/troomv2/classsubject/<?=$folderid?>.html?classid=<?=$classid?>&q='+q+'');
	});
</script>