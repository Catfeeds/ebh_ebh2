<?php $this->display('troom/page_header'); ?>
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/tzds.css" rel="stylesheet" />

<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/dayi.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/survey.css" rel="stylesheet" />
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts.js"></script>
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts-3d.js"></script>
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/modules/exporting.js"></script>
<style>
.relatediv{
	margin-left:10px;
	margin-top:10px;
	font-size:14px;
	color:#999
}
.op_content{
	vertical-align: top;
}
</style>
<div class="ter_tit">
	当前位置 > <a href="<?= geturl('troom/survey') ?>" >调查问卷</a> > 问卷统计
</div>
<div class="lefrig" style="margin-top:15px;">
	<div class="survey_main fl" style="margin:0;">
		<!--标题-->
		<div class="survey_title" style="position:relative">
			<div class="h4-bg p_title" id="survey_title_<?=$survey['sid']?>"><?=$survey['title']?></div>
			<input type="hidden" id="sid" value="<?=$survey['sid']?>" />
		</div>
		<!--关联信息-->
		<div class="relatediv">
		<?php if(!empty($relateinfo)){?>本问卷为 <?=$relateinfo['type']?> - <span style="color:red" ><?=$relateinfo['title']?></span> 的关联问卷。<?php }?>共收集<?=$survey['answernum']?>份投票。
		</div>
	<?php if (!empty($survey['answernum'])) {?>
		<!--内容-->
		<div id="survey_content">
		<?php if (!empty($survey['questionlist'])) {
			foreach ($survey['questionlist'] as $key => $question){?>
			<div class="topic_type" qid="<?=$question['qid']?>">
				<div class="topic_type_menu">
					<div class="setup-group">
						<h4>Q<?=$key+1?></h4>
					</div>
				</div>
				<div class="topic_type_con">
					<div class="topic_question">
						<div class="th4 q_title" id="survey_question_<?=$question['qid']?>"><?=$question['title']?><?php if($question['type'] == 1){?>（单选题）<?php }elseif($question['type'] == 2){?>（多选题）<?php }?></div>
					</div>
					<ul class="unstyled">
					<?php foreach ($question['optionlist'] as $j => $option){?>
						<li><span class="chrnum"><?=chr(65+$j)?>&nbsp;&nbsp;</span><div class="op_content"><label for="survey_option_<?=$option['opid']?>" class="op4 q_option"><?=$option['content']?> （选择人数： <?=$option['count']?>人）</label></div>

							<input type="hidden" class="data<?=$key?>" index="<?=chr(65+$j)?>" value="<?=$option['count']?>"/>
						</li>
					<?php }?>
					</ul>
				</div>
			</div>
			<div id="chartcontainer<?=$key?>" class="chartcontainer" style="height: 300px"></div>
		<?php } }?>

		</div>
	<?php }?>

		<div style="float:left;padding-bottom:20px" class="fontfen">
			<input style="margin-left:350px" type="button" class="tijibtn" value="返回" onclick="history.back();">
		</div>
	</div>


</div>


	<script type="text/javascript">
	$(function(){
		$.each($('.chartcontainer'),function(k,v){
			var data = new Array();
			$.each($('.data'+k),function(lk,lv){
				var t = [$(this).attr('index'),parseInt($(this).val())];
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
                    format: '{point.name} 选择人数: {point.y}人'
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

<?php $this->display('troom/page_footer'); ?>