<?php $this->display('myroom/page_header'); ?>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.huisou {
	height:26px;
	line-height:26px;
	margin:10px 0;
}
.txtsou {
	width:138px;
	height:20px;
	float:left;
}
.ewping {
	float:left;
	width:748px;
}
.ewping .ekewen {
	width:746px;
	height:26px;
	line-height:26px;
	border:solid 1px #eee;
	background:#fefefe;
}
.grades {
    color: #515151;
    height: 35px;
    line-height: 35px;
    padding-left: 6px;
}
.dfoeew {
	color: #515151;
    line-height: 24px;
    padding-left: 6px;
}
.restore {
    margin: 2px auto 10px;
    width: 627px;
}
.restore_arrow {
    color: #e4eff4;
    height: 5px;
    line-height: 10px;
    margin-left: 32px;
    overflow: hidden;
    width: 11px;
}
.restore_cont {
    background-color: #e4eff4;
    border-radius: 5px;
    color: #d0304f;
    margin-bottom: 2px;
    padding: 10px 8px;
    width: 615px;
}
.restore_cont h1 {
    color: #1f7abc;
    display: inline;
    font-size: 12px;
    font-weight: bold;
}
</style>
<script type="text/javascript">
<!--
	var searchText = "请输入搜索关键字";

	$(function(){
		initsearch("searchvalue",searchText);
		$(".showimg").parent().hover(function(){
			$(this).siblings().find("img").stop().animate({opacity:'0.3'},1000);
			$(this).addClass("hover");
		},function(){
			$(this).siblings().find("img").stop().animate({opacity:'1'},1000);
			$(this).removeClass("hover");
		});

		$("#searchbutton").click(function(){
			var search = $('#searchvalue').val();
			if($('#searchvalue').val()=='请输入搜索关键字'){
				search='';
			}
			var url = '/myroom/review/teacher.html?q='+encodeURIComponent(search);
			location.href=url;
		});
	});
//-->
</script>
<title>老师回复</title>
</head>

<body>

<div class="ter_tit">
当前位置 >
<a href="<?= geturl('myroom/review') ?>">评论交流</a>
>
<?php $q = $this->input->get('q'); ?>
老师回复（<?= $count; ?>）
	<div class="diles">
	<?php
		$q= empty($q)?'':$q;
		if(!empty($q)){
			$stylestr = 'style="color:#000"';
		}else{
			$stylestr = "";
		}
	?>
	<input name="title" <?=$stylestr?> class="newsou" id="searchvalue" value="<?= $q?>" type="text" />
	<input type="button" id="searchbutton" class="soulico" value="">
</div>
</div>
<div class="lefrig" style="background:#fff;border:solid 1px #cdcdcd;margin-top:15px;float:left;">
<div class="workol" style="float:left;width:786px;">
<div class="work_menu">
<ul>
<li>
<a href="<?= geturl('myroom/review/student') ?>">
<span>我的评论</span>
</a>
</li>
<li class="workcurrent">
<a href="<?= geturl('myroom/review/teacher') ?>">
<span>老师回复</span>
</a>
</li>
</ul>
</div>

<div class="huisou">
&nbsp;回复我的<?php if($count>0){ ?>（<?= $count; ?>）<?php } ?>
</div>
<ul>
<?php if(!empty($reviews)){ ?>
	<?php foreach($reviews as $review){ 
	//$rev = current($review['review']);
	?>
			<li class="ewping">
			<div class="ekewen">
			<?php $arr = explode('.',$review['cwurl']);
				$type = $arr[count($arr)-1]; 
				if($type != 'flv' && $review['ism3u8'] == 1)
					$type = 'flv';
				if($type == 'mp3')
					$type = 'flv';
			?>
			&nbsp;课件名称：<a target="_blank" href="<?= geturl('myroom/mycourse/'.$review['toid'])?>" style="font-weight:bold;"><?= $review['title']?></a> 主讲：<?= !empty($review['realname'])?$review['realname']:$review['nickname'] ?> <span style="float:right; margin-right: 10px;_margin-top:-25px;"><?= date('Y-m-d H:i:s',$review['dateline'])?></span>
			</div>
			<div class="grades">
			总体评分:
			<?= str_repeat('<img src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_2.gif"/>', $review['score']) ?>
			<?= str_repeat('<img src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif"/>', 5 - intval($review['score'])) ?>
			</div>
			<p class="dfoeew"><?php if($review['shield']==1){ ?><span style="color:red;">(该评论已被系统屏蔽)</span><?php }else{ ?><?= $review['subject'] ?><?php } ?></p>
			<?php if(!empty($review['replysubject'])){ ?>
				<div class="restore">
					<div class="restore_arrow">◆</div>
					<div class="restore_cont">
					<h1>老师回复：</h1>
					<?= $review['replysubject'] ?><a target="_blank" href="<?= geturl('myroom/mycourse/'.$review['toid'])?>?q=#rev" style="color:#2696f0;margin-left:10px;">继续评论</a>
					</div>
				</div>
			<?php } ?>
			</li>
	<?php } ?>
<?php }else{ ?>
	<div style="margin-left:20px;">暂无回复</div>
<?php } ?>
<?= $pagestr ?>
</ul>
</div>
</div>
<?php $this->display('myroom/page_footer'); ?>
