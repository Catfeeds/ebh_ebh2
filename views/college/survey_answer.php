<?php $this->assign('notop',TRUE);$this->display('college/room_header'); ?>

<?php $systemsetting = Ebh::app()->room->getSystemSetting(); ?>
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />

<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/tzds.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/dayi.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/survey.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css?v=20151123001"/>
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
.closebtn:hover{
	color: #666666;
}
.stimes{
	text-align: center;
    margin-top: 10px;
    margin-bottom: 25px;
    color: #999;
    font-size: 12px;
}
.workcurrenta a{
	text-decoration: none;
}
</style>





<div class="lefrig" style="margin-top:15px;">
	<div style="width: 1000px;position: relative;margin-top: 0;background: #FFFFFF;">
		<ul class="workcurrenta" style="width: 1000px;float: left;">
			<?php if(empty($survey['aid']) && (empty($survey['startdate']) || $survey['startdate'] < SYSTIME) && (empty($survey['enddate']) || $survey['enddate'] > SYSTIME)){?>
				<li class="workcurrent" style="float: left;padding: 9px 0px 0px 0px;margin: 0 15px;display: inline;line-height: 33px;font-size: 16px;">
					<a href="/college/survey/fill/<?=$survey['sid']?>.html">
						<span>调查</span>
					</a>
				</li>
			<?php }else{?>
				<li class="workcurrent" style="float: left;padding: 9px 0px 0px 0px;margin: 0 15px;display: inline;line-height: 33px;font-size: 16px;">
					<a href="/college/survey/answer/<?=$survey['sid']?>.html">
						<span>调查</span>
					</a>
				</li>
			<?php }?>
			<?php if (!empty($survey['allowview'])) {?>
				<li style="float: left;padding: 9px 0px 0px 0px;margin: 0 15px;display: inline;line-height: 33px;font-size: 16px;">
					<a href="/college/survey/stat/<?=$survey['sid']?>.html">
						<span>统计</span>
					</a>
				</li>
			<?php }?>
		</ul>
	</div>

<form id="mainform">
	<div class="survey_main fl" style="margin:0;position: relative;">
		<!--标题-->
		<div class="survey_title" style="position:relative;border-bottom: solid 1px #ddd;">
			<div class="h4-bg p_title" id="survey_title_<?=$survey['sid']?>"><?=$survey['title']?></div>
			<input type="hidden" id="sid" value="<?=$survey['sid']?>" />
		</div>
		<p class="stimes">发布者：<?=$survey['realname']?>　发布时间：<?= date('Y-m-d H:i',$survey['dateline']) ?></p>
		<!--关联信息-->
	<?php if(!empty($relateinfo)){?>
		<div class="relatediv">
		本问卷为 <?=$relateinfo['type']?> - <span style="color:red" ><?=$relateinfo['title']?></span> 的关联问卷。
		</div>
	<?php }?>
		<!--内容-->
		<div id="survey_content" style="padding-bottom: 40px;">
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
						<?php if ($question['type'] == 4) { ?>
							<li>
								<textarea readonly="readonly" name="answer_<?=$question['qid']?>[]" value="<?=$answer[$question['qid']]?>" id="survey_option_<?=$option['opid']?>" class="q_textarea" rows="4" cols="70" style="resize: none;border: none;border: 1px solid #dcdcdc;"><?=$answer[$question['qid']]?></textarea>
                        	</li>
                        <?php } else {?>
							<?php foreach ($question['optionlist'] as $option){?>
								<li>
									<?php if($question['type'] == 1){?>
										<input type="radio"
									<?php }elseif($question['type'] == 2){?>
										<input type="checkbox"
									<?php }?> 
										name="answer_<?=$question['qid']?>[]" id="survey_option_<?=$option['opid']?>" value="<?=$option['opid']?>" 
									<?php if (isset($answer[$question['qid']]) && in_array($option['opid'], $answer[$question['qid']])) echo 'checked="checked"';?> disabled="true" />
									<div class="op_content"><label for="survey_option_<?=$option['opid']?>" class="op4 q_option"><?=$option['content']?></label></div>
								</li>
							<?php }?>
						<?php }?>
					</ul>
				</div>
			</div>
		<?php } }?>

		</div>
		<a href="javascript:window.opener=null;window.open('','_self');window.close();" class="closebtn">关闭</a>
	</div>
	
</form>

</div>
<?php $this->display('myroom/page_footer'); ?>