<?php $this->display('troomv2/room_header');?>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/troomv2/css/wussyu.css"/>
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts.js?v=0514"></script>
<style>
.waifg {
	width:928px;margin-left:10px;float:left;margin-bottom:10px;
}
.waifg h2 {
margin:20px 0;float:left;margin-left:40px;
}
.ekwt {
width:928px;float:left;
}
.ewjtt {
float:left;width:150px;margin-left:15px;
}
.ektrr {
float:left;margin-top:4px;
}
.eryekx {
float:left;height:20px;line-height:20px;margin-left:6px;font-size:14px;
}
.cright {float:none;display: block;margin: 0 auto;width:980px;margin-bottom:20px;}
.classbox {width:1000px;background: #FFF;}
</style>
</head>
<body>
<div class="cright">
<div style="width:980px;margin:0 auto;">
<div class="cright">
	<div class="lefrig" style="margin-top:10px;">
		<div class="classbox">
		<h1 class="tkfktitle"><?= $course['title']?></h1>
		<div class="classboxmore">
			<div class="touxiangxmfa">
				<div class="touxiangxm">
					<?php 
						$base_url ='http://static.ebanhui.com/ebh/tpl/default/images/'; 
						$defaulturl = ($course['sex'] == 1) ? $base_url."t_woman.jpg" : $base_url."t_man.jpg";
						$face = empty($course['face']) ? $defaulturl : $course['face'];
						$face = getthumb($face,'50_50');
						$cwlength = ceil($course['cwlength']/60);
					?>
					<img class="images" src="<?=$face?>">
					<span class=""><?= empty($course['realname'])?$course['username']:$course['realname'] ?></span>
				</div>
				<p class="lsfbsj" style="<?=(!empty($course['truedateline']) || !empty($course['endat']))?'':'line-height:50px'?>"><span class="fbsj fbsj1s">上传时间：<?=date("Y-m-d H:i",$course['dateline'])?></span><span class="fbsj"> <span class="fbsj2"></span><?=max(0,$course['viewnum'])?></span>
				<span class="fbsj">时长:<?=$cwlength?>分钟</span>
				</p>
				
				<p class="kkjssj"><?=!empty($course['truedateline'])?'开课：'.date('Y-m-d H:i',$course['truedateline']):''?> <?=!empty($course['truedateline'])&&!empty($course['endat'])?'&nbsp;':''?> <?=!empty($course['endat'])?'结束：'.date('Y-m-d H:i',$course['endat']):''?></p>
				
			</div>
			<div style="clear:both;"></div>
			<div class="yixuexifa">
			<p class="sexqueue0" style="margin-left:130px;margin-right:15px;">
				<span class="sexqueuefull0" style="width:<?=ceil($countset['studycount']/$countset['userscount']*100)?>%;"></span>
			</p>
			<div style="float:left; display:inline;">
				<p class="yixuexi">已学<?=$countset['studycount']?>/<?=$countset['userscount']?></p>
				<p class="yjxxbfb"><?=ceil($countset['studycount']/$countset['userscount']*100)?>%</p>
			</div>
			<div class="pjxxsc">
				<p class="yixuexi">平均学习时长</p>
				<p class="yjxxbfb"><?=$countset['ltimeavg']?><span style="font-size:14px;">分钟</span></p>
			</div>
		</div>
		</div>
			<input type="hidden" name="cwid" value="<?=$course['cwid']?>"/>
			<?php if(!empty($nodata)){?>
			<div class="nodata"></div>
			<?php }else{?>
			<div class="waifg">
			<h2>听课反馈:</h2>
			<div class="ekwt">
				<div class="mt50" id="chartcontainer1" style="height:300px;margin-left:100px;"></div>
			</div>
			<h2>难易度:</h2>
			<div class="ekwt">
				<div class="mt50" id="chartcontainer2" style="height:300px;margin-left:100px;"></div>
			</div>
			<h2>课程质量:</h2>
			<div class="ekwt">
				<div class="mt50" id="chartcontainer3" style="height:300px;margin-left:100px;"></div>
			</div>
			<h2>讲课水平:</h2>
			<div class="ekwt">
				<div class="mt50" id="chartcontainer4" style="height:300px;margin-left:100px;"></div>
			</div>
			</div>
			<?php }?>
		</div>
	</div>
</div>
</div>
</div>
<script type="text/javascript">
$(function(){
	<?php if(empty($nodata)){?>

	tochart('1',<?=$feedback['datas']?>);
	tochart('2',<?=$difficulty['datas']?>);
	tochart('3',<?=$quality['datas']?>);
	tochart('4',<?=$level['datas']?>);
	<?php }?>
});
function tochart(index,datas){
	var dataarr = new Array();
	$.each(datas,function(k,v){
		dataarr.push([k,v]);
	})
	$('#chartcontainer'+index).highcharts({
		chart: {
			type: 'pie'
		},
		series:[{
			name:'反馈次数',
			data: dataarr
		}],
		yAxis: {
			allowDecimals:false,
			title:{
				text:null
			}
		},
		title: {
			text: null
		},
		credits:{
			enabled:false 
		},
		legend:{
			enabled:false
		}
	});
}
</script>
</body>
</html>
