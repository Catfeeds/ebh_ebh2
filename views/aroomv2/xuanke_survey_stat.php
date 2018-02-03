<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<?php $systemsetting = Ebh::app()->room->getSystemSetting(); ?>
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
    <title><?= empty($survey['title']) ? $this->get_title() : (strip_tags($survey['title']) . ' - 问卷统计') ?></title>
    <meta name="keywords" content="<?= empty($subkeywords) ? $this->get_keywords() : $subkeywords ?>" />
    <meta name="description" content="<?= empty($subdescription) ? $this->get_description() : $subdescription?>" />
    <link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
    <link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css?v=20151026" rel="stylesheet" type="text/css" />
    <link href="http://static.ebanhui.com/ebh/tpl/2012/css/common.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common2.js?version=20150827001"></script>

</head>
<body>
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/tzds.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/dayi.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/survey.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css<?=getv()?>"/>
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
</style>
<div class="lefrig" style="margin-top:15px;">
    <div class="cmain_bottom" style="height:42px;">
        <div class="study" style="border-bottom:none; padding-bottom:0;">
            <div class="study_top" style="background:#fff;">
                <div class="fl"><h3>调查问卷</h3></div>
            </div>
        </div>
    </div>

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

    </div>
    <?php }else{?>
        <div class="nodata"></div>
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
</body>
<?php $this->display('myroom/page_footer'); ?>