<?php $this->display('troomv2/page_header'); ?>
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
.h4-bg{
	width:980px;
}
.survey_main{
	width:1000px;
}
.op_content{
	width:900px;
}
.th4{
	width:915px;
}
</style>
<div class="lefrig">
	<div class="survey_main fl" style="margin:0;">
		<!--标题-->
		<div class="survey_title" style="position:relative">
			<div class="h4-bg p_title" id="survey_title_<?=$survey['sid']?>"><?=$survey['title']?></div>
			<input type="hidden" id="sid" value="<?=$survey['sid']?>" />
		</div>
		<!--关联信息-->
		<div class="relatediv">
		<?php if(!empty($relateinfo)){?>本问卷为 <?=$relateinfo['type']?> - <span style="color:red" ><?=$relateinfo['title']?></span> 的关联问卷。<?php }?>
		<?php if(!empty($survey['answernum'])){?>
			共收集 <?=$survey['answernum']?> 份投票。
		<?php }else{?>
		<div class="nodata"></div>
		<?php }?>
		</div>
	<?php if (!empty($survey['answernum'])) {?>
		<!--内容-->
		<div id="survey_content">
		<?php if (!empty($survey['questionlist'])) {
			foreach ($survey['questionlist'] as $key => $question){?>
			<?php if($question['type'] != 4){?>
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
			<?php }?>
			<div id="chartcontainer<?=$key?>" q_type="<?=$question['type']?>" class="chartcontainer" style="height: 300px"></div>
		<?php } }?>

		</div>
	<?php }?>
        <?php if(empty($survey['cid'])){?>
		<div style="float:left;padding-bottom:20px" class="fontfen">
			<input type="button" value="导出资料" class="tijibtn" style="width:87px;float:left;margin-left: 400px;" id="export" />
			
			<input style="margin-left:15px" type="button" class="tijibtn" value="返回" onclick="history.back();">
		</div>
        <?php }?>
	</div>


</div>


	<script type="text/javascript">
	$(function(){
		var sid=<?=intval($survey['sid'])?>;
		$("#export").bind('click', function() {
	       location.href = '/aroomv2/more/export.html?sid='+sid;
        });
		$.each($('.chartcontainer'),function(k,v){
			if($(this).attr('q_type') == 4){//暂时将问答题的饼状图隐藏
				$(this).css("display","none");
			}
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
$(function(){
		$('.datatab tr:last td').css('border-bottom','none');
	});
	</script>

<?php $this->display('troomv2/page_footer'); ?>