<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/listit.css?v=20160422" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css"/>

<style>
body{
	background: white;
}
.dtkywe {
    height: 35px;
    position: absolute;
    right: 14px;
    top: 4px;
    width: 160px;
}
.work_mes a.workbtns{ margin-left:245px;}
</style>

	
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
	?>
	<div class="nav_list">
		<div class="nav_listson">
			<li><a <?=$selclass[0]?> href="<?=geturl('ke/study/cwlist/'.$folder['folderid']) ?>">课程目录</a></li>
			<li><a <?=$selclass[1]?> href="<?=geturl('ke/study/introduce/undercourse/'.$folder['folderid'])?>">课程介绍</a></li>
			<li><a <?=$selclass[5]?> href="<?=geturl('jingpin/cwteacher').'?folderid='.$folder['folderid'] ?>">任课教师</a></li>
			<!-- <li><a <?=$selclass[2]?> href="<?=geturl('jingpin/myexam/all').'?folderid='.$folder['folderid']?>">相关作业</a></li>
			<li><a <?=$selclass[3]?> href="<?=geturl('jingpin/myask/all').'?folderid='.$folder['folderid']?>">互动答疑</a></li> -->
			<li><a <?=$selclass[4]?> href="<?=geturl('jingpin/attachment').'?folderid='.$folder['folderid']?>">资料下载</a></li>
			<!-- <li><a <?=$selclass[6]?> href="<?=geturl('ke/surveylist').'?folderid='.$folder['folderid']?>">调查问卷</a></li> -->
		</div>
	</div>
<script type="text/javascript">

</script>