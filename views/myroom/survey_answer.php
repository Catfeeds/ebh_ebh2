<?php $this->display('myroom/page_header'); ?>
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/tzds.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/dayi.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/survey.css" rel="stylesheet" />
<style>
.relatediv{
	margin-left:10px;
	margin-top:10px;
	font-size:14px;
	color:#999
}
</style>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<div class="ter_tit">
	当前位置 > <a href="<?= geturl('myroom/survey/surveylist') ?>" >调查问卷</a> > 查看回答
</div>
<div class="lefrig" style="margin-top:15px;">
<form id="mainform">
	<div class="survey_main fl" style="margin:0;">
		<!--标题-->
		<div class="survey_title" style="position:relative">
			<div class="h4-bg p_title" id="survey_title_<?=$survey['sid']?>"><?=$survey['title']?></div>
			<input type="hidden" id="sid" value="<?=$survey['sid']?>" />
		</div>
		<!--关联信息-->
	<?php if(!empty($relateinfo)){?>
		<div class="relatediv">
		本问卷为 <?=$relateinfo['type']?> - <span style="color:red" ><?=$relateinfo['title']?></span> 的关联问卷。
		</div>
	<?php }?>
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
						<div class="th4 q_title" id="survey_question_<?=$question['qid']?>"><?=$question['title']?></div>
					</div>
					<ul class="unstyled">
					<?php foreach ($question['optionlist'] as $option){?>
						<li><?php if($question['type'] == 1){?><input type="radio"<?php }elseif($question['type'] == 2){?><input type="checkbox"<?php }?> name="answer_<?=$question['qid']?>[]" id="survey_option_<?=$option['opid']?>" value="<?=$option['opid']?>" <?php if (isset($answer[$question['qid']]) && in_array($option['opid'], $answer[$question['qid']])) echo 'checked="checked"';?> disabled="true" /><div class="op_content"><label for="survey_option_<?=$option['opid']?>" class="op4 q_option"><?=$option['content']?></label></div></li>
					<?php }?>
					</ul>
				</div>
			</div>
		<?php } }?>

		</div>

		<div style="float:left;padding-bottom:20px" class="fontfen">
			<input style="margin-left:350px" type="button" class="tijibtn" value="返回" onclick="history.back();">
		</div>
	</div>

</form>
</div>

<?php $this->display('myroom/page_footer'); ?>