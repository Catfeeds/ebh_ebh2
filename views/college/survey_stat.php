<?php $this->assign('notop',TRUE);$this->display('college/room_header'); ?>

<?php $systemsetting = Ebh::app()->room->getSystemSetting(); ?>
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>

<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/tzds.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/dayi.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/survey.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css?v=20151123001"/>
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts.js"></script>
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts-3d.js"></script>
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/modules/exporting.js"></script>
<style>
.lefrig{width:1000px; margin:0 auto;}
.survey_main{ width:1000px; border: none;}
.h4-bg{ width: 980px;}
.th4{ width: 919px;}
.op_content{ width: 906px;}
.relatediv{
	margin-left:10px;
	margin-top:10px;
	font-size:14px;
	color:#999
}
.op_content .op4{
	vertical-align: top;
}
.sursta{
	width: 53px;
	height: 35px;
	margin-top: 5px;
	text-align: center;
	line-height: 30px;
	border-radius: 3px;
}
.border_three{
	border: 1px solid #D1DBE5;
	border-bottom: 0 none;
	color: #20A0FF !important;
}
.border_one{
	border-bottom: 1px solid #D1DBE5;
}
.stimes{
	text-align: center;
    margin-top: 10px;
    margin-bottom: 25px;
    color: #999;
    font-size: 12px;
}
.closebtn{
	background-color: #f9f9f9;
    border: 1px solid #ddd;
    display: block;
    text-align: center;
    color: #666666;
    width: 90px;
    height: 32px;
    line-height: 32px;
    text-decoration: none;
    border-radius: 3px;
    position: absolute;
    bottom: 20px;
    left: 455px;
}
.workcurrenta a{
	text-decoration: none;
}
</style>
<div class="lefrig" style="margin-top:15px;">

	<div style="width: 1000px;position: relative;margin-top: 0;background: #FFFFFF;">
		<ul class="workcurrenta" style="width:1000px;float: left;">
			<?php if(empty($survey['aid']) && (empty($survey['startdate']) || $survey['startdate'] < SYSTIME) && (empty($survey['enddate']) || $survey['enddate'] > SYSTIME)){?>
				<li class="" style="float: left;padding: 9px 0px 0px 0px;margin: 0 15px;display: inline;line-height: 33px;font-size: 16px;">
					<a href="/college/survey/fill/<?=$survey['sid']?>.html">
						<span>调查</span>
					</a>
				</li>
			<?php }else{?>
				<li class="" style="float: left;padding: 9px 0px 0px 0px;margin: 0 15px;display: inline;line-height: 33px;font-size: 16px;">
					<a href="/college/survey/answer/<?=$survey['sid']?>.html">
						<span>调查</span>
					</a>
				</li>
			<?php }?>
			
			<?php if (!empty($survey['allowview'])) {?>
				<li class="workcurrent" style="float: left;padding: 9px 0px 0px 0px;margin: 0 15px;display: inline;line-height: 33px;font-size: 16px;">
					<a href="/college/survey/stat/<?=$survey['sid']?>.html">
						<span>统计</span>
					</a>
				</li>
			<?php }?>
		</ul>
	</div>




	<div class="survey_main fl" style="margin:0;position: relative;">
		<!--标题-->
		<div class="survey_title" style="position:relative;border-bottom: solid 1px #ddd;">
			<div class="h4-bg p_title" id="survey_title_<?=$survey['sid']?>"><?=$survey['title']?></div>
			<input type="hidden" id="sid" value="<?=$survey['sid']?>" />
		</div>
		<p class="stimes">发布者：<?=$survey['realname']?>　发布时间：<?= date('Y-m-d H:i',$survey['dateline']) ?></p>
		<!--关联信息-->
		<div class="relatediv">
		<?php if(!empty($relateinfo)){?>本问卷为 <?=$relateinfo['type']?> - <span style="color:red" ><?=$relateinfo['title']?></span> 的关联问卷。<?php }?>共收集<?=$survey['answernum']?>份投票。
		</div>
	<?php if (!empty($survey['answernum'])) {?>
		<!--内容-->
		<div id="survey_content" style="margin-bottom: 100px;">
		<?php if (!empty($survey['questionlist'])) {
			$ttypeids = array(1, 2, 111, 112);
			foreach ($survey['questionlist'] as $key => $question){
				$type = intval($question['type']);
				if (!in_array($type, $ttypeids)) {
					continue;
				}
		?>
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
		<a href="javascript:window.opener=null;window.open('','_self');window.close();" class="closebtn" style="margin-bottom: 20px;">关闭</a>
	</div>
		
	<?php } else {?>
		<a href="javascript:window.opener=null;window.open('','_self');window.close();" class="closebtn" style="margin-bottom: 20px;">关闭</a>
	<?php }?>	
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

<?php $this->display('myroom/page_footer'); ?>
