<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>预览问卷 - <?=strip_tags($survey['title'])?></title>
<meta name="keywords" content="<?= empty($subkeywords) ? $this->get_keywords() : $subkeywords ?>" />
<meta name="description" content="<?= empty($subdescription) ? $this->get_description() : $subdescription?>" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css<?=getv()?>"/>
<body>


<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/tzds.css" rel="stylesheet" />

<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/dayi.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/survey.css" rel="stylesheet" />
<style type="text/css">
    input.completion{border-top:0 none;border-left:0 none;border-right:0 none;border-bottom:1px solid #999;width:360px;padding-bottom:5px;}
    div.enchant{font-size:16px;padding:5px 18px;}
    #mainform *{
        font-family:"Microsoft YaHei",微软雅黑 !important;
    }
    input.fill_txt{width:160px;}
    .top_question{
        padding:5px 18px;
        font-size:16px;
    }
    .top_question input{margin:5px;}
    .top_tip{color:#f00;padding:0 5px;display:none;}
    .closebutton{
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
	    left: 349px;
    }
    .closebutton:hover{
    	color: #666666;
    }
</style>
<div class="lefrig clearfix" style="margin-top:30px;background:#fff;width:788px;padding-bottom:0;">
	<div class="survey_main fl" style="margin:0;position: relative;">
		<!--标题-->
		<div class="survey_title" style="position:relative">
			<div class="h4-bg p_title" id="survey_title_<?=$survey['sid']?>"><?=$survey['title']?></div>
			<input type="hidden" id="sid" value="<?=$survey['sid']?>" />
		</div>
        <?php if ($survey['type'] == 4) { ?><div class="enchant"><?=$survey['content']?></div><?php } ?>
        <div class="top_question"><?php if (!empty($survey['top_questions'])) {
                foreach ($survey['top_questions'] as $tq) {
                    if ($tq['type'] == 111) { ?>
                        <?php if($tq['layout_type'] == 0){ echo '<br />'; }?><span class="topic_type" qid="<?=$tq['qid']?>"><?=$tq['title']?><span class="top_tip" id="tip_<?=$tq['qid']?>">*</span><?php foreach($tq['optionlist'] as $option){?><input type="radio" name="answer_<?=$tq['qid']?>[]" id="t<?=$option['opid']?>" value="<?=$option['opid']?>" /><label id="survey_question_<?=$tq['qid']?>" for="t<?=$option['opid']?>"><?=$option['content']?></label></span><?php }?>
                    <?php } else if($tq['type'] == 112) { ?>
                        <?php if($tq['layout_type'] == 0){ echo '<br />'; }?><span class="topic_type" qid="<?=$tq['qid']?>"><?=$tq['title']?><span class="top_tip" id="tip_<?=$tq['qid']?>">*</span><?php foreach($tq['optionlist'] as $option){?><input type="checkbox" name="answer_<?=$tq['qid']?>[]" value="<?=$option['opid']?>" id="t<?=$option['opid']?>" /><label id="survey_question_<?=$tq['qid']?>" for="t<?=$option['opid']?>"><?=$option['content']?></label></span><?php }?>
                    <?php } else if($tq['type'] == 113) { ?>
                        <?php if($tq['layout_type'] == 0){ echo '<br />'; }?><span class="topic_type" qid="<?=$tq['qid']?>"><label  id="survey_question_<?=$tq['qid']?>"><?=$tq['title']?></label><span class="top_tip" id="tip_<?=$tq['qid']?>">*</span><input type="text" id="fill_<?=$tq['qid']?>" name="answer_<?=$tq['qid']?>" class="completion fill_txt" /></span>
                    <?php }
                }
            } ?></div>
		<!--内容-->
		<div id="survey_content">
		<?php if (!empty($survey['questionlist'])) {
			foreach ($survey['questionlist'] as $key => $question){
                $index = $survey['type'] != 4 ? $key + 1 : $question['displayorder']; ?>
			<div class="topic_type" qid="<?=$question['qid']?>">
				<div class="topic_type_menu">
					<div class="setup-group">
						<h4>Q<?=$index?></h4>
					</div>
				</div>
				<div class="topic_type_con">
					<div class="topic_question">
						<div class="th4 q_title" id="survey_question_<?=$question['qid']?>"><?=$question['title']?></div>
					</div>
					<ul class="unstyled">
						<?php if($question['type'] == 4){?>
								<textarea class="q_textarea" readonly="readonly" rows="4" cols="60" name="answer_<?=$question['qid']?>[]" id="survey_option_<?=$option['opid']?>" value="<?=$option['opid']?>" style="resize: none;border: none;border: 1px solid #dcdcdc;"></textarea>	
                        <?php } elseif ($question['type'] == 3) { ?>
                            <input type="text" class="completion" id="fill_<?=$question['qid']?>" name="answer_<?=$question['qid']?>" />
                        <?php } else {
                            foreach ($question['optionlist'] as $option){
                                $otherFill = $question['type'] ==11 && preg_match('/^[a-zA-Z]\.$/', $option['content']) ? true : false; ?>
                                <li><?php if($question['type'] == 1 || $question['type'] ==11){?><input type="radio" name="answer_<?=$question['qid']?>[]" id="survey_option_<?=$option['opid']?>" value="<?=$otherFill ? '0' : $option['opid']?>" /><?php }elseif($question['type'] == 2){?><input type="checkbox" name="answer_<?=$question['qid']?>[]" id="survey_option_<?=$option['opid']?>" value="<?=$option['opid']?>" /><?php }?><div class="op_content"><label for="survey_option_<?=$option['opid']?>" class="op4 q_option"><?=$option['content']?><?php if ($otherFill) { ?>其他&nbsp;<input class="fill_txt completion" type="text" name="f_answer_<?=$question['qid']?>" /><?php } ?></label></div></li>
                            <?php }
                        } ?>
					</ul>
				</div>
			</div>
		<?php } }?>

		</div>
		<div style="margin-top: 60px;">
			<a href="javascript:window.opener=null;window.open('','_self');window.close();" class="closebutton" style="margin-bottom: 20px;">关闭</a>
		</div>
	</div>
	
	

</div>
<?php $this->display('aroomv2/page_footer')?>