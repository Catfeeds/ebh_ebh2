<?php $this->display('troomv2/room_header');?>
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts.js?v=0514"></script>
<body>
<div class="lefrig" style="float:none; margin-top:10px; padding-bottom:120px;">
	<h1 class="tkfktitle"><?=$cwdetail['title']?></h1>
	<div class="classboxmore">
		<div class="touxiangxmfa">
			<div class="touxiangxm">
			<?php 
				if($cwdetail['sex'] == 1)
					$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
				else
					$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
				$face = empty($cwdetail['face']) ? $defaulturl:$cwdetail['face'];
				$face = str_replace('.jpg','_50_50.jpg',$face);
				$cwlength = ceil($cwdetail['cwlength']/60);
			?>
				<img class="images" src="<?=$face?>">
				<span class=""><?=$cwdetail['realname']?></span>
			</div>
			<div class="fl">
			<p class="lsfbsj"><span class="fbsj fbsj1s">上传时间：<?=Date('Y-m-d H:i',$cwdetail['dateline'])?></span><span class="fbsj"> <span class="fbsj2"></span><?= $cwdetail['viewnum']?></span><span class="fbsj">时长:<?=$cwlength?>分钟</span></p>
			<div style="clear:both;"></div>
			<p class="kkjssj">开课：<?=Date('Y-m-d H:i',$cwdetail['truedateline'])?> &nbsp;&nbsp; <?=empty($cwdetail['endat'])?'':'结束：'.Date('Y-m-d H:i',$cwdetail['endat'])?></p>
			</div>
		</div>
		<div style="clear:both;"></div>
		<div class="yixuexifa" style="border:none">
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
    <div class="clear"></div>	
    <div class="qzsjlb">
		<div class="zhqks mt35">
			<div class="nnbl">听课人数分析</div>
			<div class="ml20 mt30" id="chartcontainer1" style="width:800px;height:400px"></div>
		</div>
        <div class="zhqks mt35">
			<div class="nnbl">听课时长统计</div>
			<div class="ml20 mt30" id="chartcontainer2"></div>
		</div>
        <div class="zhqks mt35">
			<div class="nnbl">累计听课时长分布</div>
			<div class="ml20 mt30" id="chartcontainer3"></div>
		</div>
	</div>
</div>
</body>
<script>
$(function(){
	
	$('#chartcontainer1').highcharts({
		chart: {
			type: 'pie'
		},
		series:[{
			name:'百分比',
			data: [
				['已听课人数',<?=ceil($countset['studycount']/$countset['userscount']*100)?>],
				['未听课人数',<?=100-ceil($countset['studycount']/$countset['userscount']*100)?>]
				
			]
		}],
		
		title: {
			text: null
		},
		credits:{
			enabled:false 
		}
	});
	
	
	
	$('#chartcontainer2').highcharts({
		chart: {
			type: 'column'
		},
		series:[
			{
				name:'课件时长',
				data: [
					<?= $cwlength?>,<?=$countset['ltimemax']?>,<?=$countset['ltimeavg']?>,<?=$countset['ltimemin']?>
				]
			}
		],
		xAxis: {
			categories: [
				'课件时长',
				'最长时长',
				'平均时长',
				'最短时长'
            ]
        },
		yAxis: {
			min: 0,
			title: {
				text: '时<br>长<br>/<br>分<br>钟',
				rotation:0,
				margin:40,
				align:'high'
			}
		},
		plotOptions: {
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
	
	
	$('#chartcontainer3').highcharts({
		chart: {
			type: 'column'
		},
		series:[
			{
				name:'百分比',
				data: [
					<?php $datastr = '';
						foreach($distrlist as $d){
						$datastr.= $d.',';
						}
					echo rtrim($datastr,',');
					?>
					
				]
			}
		],
		xAxis: {
			categories: [
				'0-10',
				'11-20',
				'21-30',
				'31-40',
				'41-50',
				'51-60',
				'60以上'
            ]
        },
		yAxis: {
			min: 0,
			title: {
				text: '人<br>数<br>占<br>比<br>(%)',
				rotation:0,
				margin:40,
				align:'high'
				
			},
			max:100
		},
		plotOptions: {
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
		
	});
});
</script>
<?php $this->display('troomv2/room_footer'); ?>

