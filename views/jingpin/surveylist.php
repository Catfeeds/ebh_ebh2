<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= empty($subtitle) ? $this->get_title() : $subtitle.'-'. $this->get_title() ?></title>
<meta name="keywords" content="<?= empty($subkeywords) ? $this->get_keywords() : $subkeywords ?>" />
<meta name="description" content="<?= empty($subdescription) ? $this->get_description() : $subdescription?>" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css?v=20160524001" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css?v=20160524001" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common2.js?version=20150827001"></script>

<script type="text/javascript">
<!--
<?php if($this->uri->uri_domain() != 'jx') { ?>
	$(function(){
		if($.isFunction(top.resetmain)){
			top.resetmain();
		}
	});
<?php } ?>
//-->
</script>
</head>
<body>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css<?=getv()?>" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css?v=20151123001"/>
<style type="text/css">

.datatab{border:none;}
</style>
<?php if (empty($folder)){?>
<div class="cmain_bottom" style="height:42px;">
	<div class="study" style="border-bottom:none; padding-bottom:0;">
		<div class="study_top" style="background:#fff;">
			<div class="fl"><h3>调查问卷</h3></div>
		</div>
	</div>
</div>
<?php }?>

<div class="lefrig clearfix" style="background:#fff;">
<?php
if(!empty($folder)){
	$this->assign('selidx', 6);
?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/listit.css?v=20160422" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css"/>

<style>
.dtkywe {
    height: 35px;
    position: absolute;
    right: 14px;
    top: 4px;
    width: 160px;
}
body{
	background: white;
}
.work_mes a.workbtns{ margin-left:245px;}
</style>

	<div class="stktitl">
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
		</div>
		
	</div>
	<?php 
		// $idx = $this->input->get('selidx');
		for($i=0;$i<7;$i++){
			if($i==6)
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
			<li><a <?=$selclass[2]?> href="<?=geturl('jingpin/myexam/all').'?folderid='.$folder['folderid']?>">相关作业</a></li>
			<li><a <?=$selclass[3]?> href="<?=geturl('jingpin/myask/all').'?folderid='.$folder['folderid']?>">互动答疑</a></li>
			<li><a <?=$selclass[4]?> href="<?=geturl('jingpin/attachment').'?folderid='.$folder['folderid']?>">资料下载</a></li>
			<li><a <?=$selclass[6]?> href="<?=geturl('ke/surveylist').'?folderid='.$folder['folderid']?>">调查问卷</a></li>
		</div>
	</div>
<?php }
?>
<?php if(!empty($surveylist)){?>
	<table class="datatab" width="100%">
		<thead class="tabhead">
			<tr>
			<th>名称</th>
			<th>关联课件</th>
			<th>发布时间</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($surveylist as $survey){?>
			<tr>
				<td width="315" style="word-break: break-all; word-wrap:break-word;"><?php if(empty($survey['aid'])){?><a href="/college/survey/fill/<?=$survey['sid']?>.html" target="_blank" style="color:#666;"><?php }else{?><a href="/college/survey/answer/<?=$survey['sid']?>.html" target="_blank" style="color:#666;"><?php }?><?=strip_tags($survey['title'])?></a></td>
				<td width="315" style="word-break: break-all; word-wrap:break-word;"><?=$survey['cwname']?></td>
				<td width="161"><?=date('Y-m-d H:i:s',$survey['dateline'])?></td>
			</tr>
		<?php }?>

		</tbody>
	</table>
<?php } else {?>
	<div style="text-align:center" class="nodata">
	</div>
<?php }?>
<?=$pagestr?>
</div>
<script type="text/javascript">
var searchtext = "请输入关键字";
$(function() {
	initsearch("title",searchtext);
	$("#ser").click(function(){
       var title = $("#title").val();
       if(title == searchtext) 
           title = "";
       var url = '<?= geturl('college/survey/surveylist') ?>' + '?q='+title;
	   <?php if(!empty($folder)){
			$itemid = $this->input->get('itemid');?>
		url += '&folderid=<?=$folder['folderid']?>';
		url += '&itemid=<?=!empty($itemid)?$itemid:''?>';
	   <?php }?>
       document.location.href = url;
	});
});

</script>
</body>
</html>