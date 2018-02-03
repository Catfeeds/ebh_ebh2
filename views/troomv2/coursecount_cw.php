<?php $this->display('troomv2/page_header')?>
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts.js?v=0514"></script>
<style>
	.zshykjs {
		width:240px;
		overflow:hidden;
		text-overflow:ellipsis;
		white-space:nowrap;
	}
</style>
<div class="lefrig" style="padding-bottom:120px;">
	
	<?php $this->assign('index',8);
	$this->display('troomv2/course_menu');
	$this->assign('currentindex',0);
	$this->display('troomv2/coursecount_menu');?>
    <div class="clear"></div>
	<div class="kejianzs mt20">
    	<div class="ljzsbt">课件总数：<span class="span1s"><?=$countset['allcount']?>个</span></div>
        <div class="fbsj2 fbsj2s"><?=$maxviewnum['viewnum']?></div>
        <div class="ljzsbt zshykj">
        	<span class="span1s fl">最受欢迎课件：</span>
            <a target="_blank" href="/troomv2/course/<?=$maxviewnum['cwid']?>.html" class="zshykjs fl"><?=shortstr($maxviewnum['title'],30)?></a>
        </div>
    </div>
    <div class="clear"></div>
    <div class="kejianzs">
    	<div class="ljzsbt spkjzcs">视频课件总时长：<span class="span1s"><?=empty($countset['alllength'])?0:secondToStr($countset['alllength'])?></span></div>
        <div class="fbsj2 fbsj2s"><?=$minviewnum['viewnum']?></div>
        <div class="ljzsbt zsllkj">
        	<span class="span1s fl">最受冷落课件：</span>
            <a target="_blank" href="/troomv2/course/<?=$minviewnum['cwid']?>.html" class="zshykjs fl"><?=shortstr($minviewnum['title'],30)?></a>
        </div>
    </div>
    <div class="clear"></div>
    <div class="qzsjlb" style="padding-left:40px;">
		<div class="zhqks mt55">
			<div class="nnbl">资源数量（本课程）</div>
			<div id="chartcontainer" style="width:700px;margin-left:100px;margin-top:45px"></div>
		</div>
	</div>
</body>
<script>
$(function(){
	$('#chartcontainer').highcharts({
		chart: {
			type: 'column'
		},
		series:[{
			name:'数量',
			data: [
				<?= $countset['flvcount']?>,<?= $countset['livecount']?>,<?= $countset['attcount']?>
			]
		}],
		xAxis: {
			categories: [
				'视频课',
				'直播课',
				'附件'
            ]
        },
		yAxis: {
			allowDecimals:false,
			min: 0,
			title: {
				text: '数<br>量<br>/<br>个',
				rotation:0,
				align:'high',
				margin:20
			}
		},
		plotOptions: {
			series: {
				colorByPoint: true
			},
			column: {
				dataLabels: {
					enabled: true
				}
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
		/*    
		navigation: {
			buttonOptions: {
				enabled: false
			}
		}
		*/
	});
});
</script>
</html>
