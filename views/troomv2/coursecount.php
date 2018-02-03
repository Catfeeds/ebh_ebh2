<?php $this->display('troomv2/page_header')?>
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts.js?v=0514"></script>

<div  class="lefrig" style="padding-bottom:120px;">
<div class="waitite">
	<div class="work_menu" style="position:relative;margin-top:0">
		<ul>
			<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso">统计分析</span></a></li>
		</ul>
	</div>
	<?php $this->assign('currentindex',3);
	$this->display('troomv2/courselinkbar');?>
</div>
	<div class="qzsjlb">
		<div class="zhqks mt35">
			<div class="nnbl">资源数量（所有课程）</div>
			
			<div id="chartcontainer" style="width:700px;margin-left:100px;margin-top:45px"></div>
		</div>
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
			min: 0,
			title: {
				text: '数<br>量<br>/<br>个',
				rotation:0,
				margin:40,
				align:'high'

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
