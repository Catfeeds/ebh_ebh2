<?php $this->display('aroom/page_header'); ?>
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/tzds.css" rel="stylesheet" />

<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/dayi.css" rel="stylesheet" />
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts.js"></script>
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts-3d.js"></script>
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/modules/exporting.js"></script>
<style>
.iradio{
	height:16px;
	width:16px;
}
.ilabel{
	margin-right:50px;
	font-size:20px;
}
h2{
	font-size:16px;
	font-weight:bold;
	margin-top:10px;
}
.contentspan{
	font-size:16px;
}
.quesdiv{
	width:756px;
	margin-left:10px;
	margin-top:10px;
}
.relatediv{
	margin-left:10px;
	margin-top:10px;
	font-size:14px;
	color:#999
}
</style>
			<div class="ter_tit">
	当前位置 > <a href="<?= geturl('aroom/survey') ?>" >调查问卷</a> > 回答问卷
</div>
<div class="lefrig">

	<div style="float:left;margin-top:20px;background:#fff;">
		<h2 style="width:788px;text-align:center"><?=$survey['title']?></h2>
		<?php if(!empty($relateinfo)){?>
		<div class="relatediv">
		本问卷为 <?=$relateinfo['type']?> - <a style="color:red" href="<?=$relateinfo['url']?>" target="_blank"><?=$relateinfo['title']?></a> 的关联问卷
		</div>
		<?php }?>
		
		<input type="hidden" name="sid" value="<?=$survey['sid']?>"/>
		
		<div id="quescontent" style="">
			<?php foreach($survey['content'] as $k=>$content){?>
			<div style="" class="quesdiv">
				<label class="contentspan"><?=($k+1)?>.</label>
				<span class="contentspan"><?=$content['title']?></span>
				<div style="margin-top:5px">
					<?php $l=0;
					foreach($content['item'] as $item){
						if(trim($item,' ') != ''){
						?>
					<label class="ilabel"> <span><?=chr(65+$l).'.'.$item?></span></label>
					<input type="hidden" class="data<?=$k?>" index="<?=chr(65+$l)?>" value="<?=!empty($content['answer'][$l])?$content['answer'][$l]:0?>"/>
					<?php $l++;}
					}?>
				</div>
			</div>
			
			<div id="chartcontainer<?=$k?>" class="chartcontainer" style="height: 300px">
			</div>
			
			<?php }?>
			
		</div>
		
		
		
	</div>

</div>


	<script type="text/javascript">
	$(function(){
		$.each($('.chartcontainer'),function(k,v){
			var data = new Array();
			$.each($('.data'+k),function(lk,lv){
				var t = [$(this).attr('index'),parseInt($(this).val())];
				// data+= t;
				data.push(t);
			});
			
			setchart($(this),data);
		})
	});
	function setchart(container,datas){
    container.highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: ''
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.y}人,{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 35,
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }
        },
        series: [{
            type: 'pie',
            name: '选择人数',
            data: datas
        }],
		credits:{
			enabled:false 
		},
		navigation: {
			buttonOptions: {
				enabled: false
			}
		}
    });
}
	</script>

<?php $this->display('myroom/page_footer'); ?>