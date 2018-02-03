<?php $this->display('aroomv2/page_header'); ?>
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
.fontfen .tijibtn{
	background:#5e96f5;
}
.fontfen .tijibtn:hover{
	background:#4e8bf1;
}
    div.tip{
        background:url(http://static.ebanhui.com/ebh/tpl/2016/images/weits.jpg) no-repeat;
        width:15px;
        height:15px;
        display:inline-block;
        margin-left:10px;
        position:relative;
        cursor:pointer;
    }
    div.tip .note{
        display:none;
        background:url(http://static.ebanhui.com/ebh/images/dialog_back.png) no-repeat center bottom;
        width:160px;
        padding:6px;
        bottom:26px;
        left:-60px;
        color:#fff;
        position:absolute;
    }
    div.tip .note div.info{
        background-color:#b3b3b3;
        text-align:left;
        padding:8px;
        margin:0;
        -webkit-border-radius:3px;
        -moz-border-radius:3px;
        border-radius:3px;
    }
    div.tip .note span{display:inline-block;}
    div.tip:hover .note{
        display:block;
    }
</style>
<div class="ter_tit">
	当前位置 > <a href="<?= geturl('aroomv2/more/survey') ?>" >调查问卷</a> > 问卷统计
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
		<?php if(!empty($relateinfo)){?>本问卷为 <?=$relateinfo['type']?> - <span style="color:red" ><?=$relateinfo['title']?></span> 的关联问卷。<?php }?>共收集<?=$survey['answernum']?>份<?=$survey['type'] == 4 ? '问卷' : '投票'?>。
		</div>
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
			<div id="chartcontainer<?=$key?>" class="chartcontainer" q_type="<?=$question['type']?>" style="height: 300px"></div>
		<?php } }?>

		</div>

		<div style="text-align:center;clear:both;padding-bottom:20px;padding-top:150px; " class="fontfen">
			<input type="button" value="导出资料" class="tijibtn" style="float:inherit" id="export" /><div class="tip"><div class="note"><div class="info">可将学生填写问卷资料导出为<span>excel</span>表格</div></div></div>
			<input style="float:inherit" type="button" class="tijibtn" value="返回" onclick="history.back();">
		</div>
	</div>


</div>


	<script type="text/javascript">
        var sid=<?=intval($survey['sid'])?>;
	$(function(){
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
	</script>

<?php $this->display('myroom/page_footer'); ?>
