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
.op_content .op4{
	cursor:pointer;
}
.red {
	display: none;
    color: red;
    font-size: 14px;
    padding-bottom: 5px;
}
</style>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<div class="ter_tit">
	当前位置 > <a href="<?= geturl('myroom/survey/surveylist') ?>" >调查问卷</a> > 回答问卷
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
					<div class="red" id="tip_<?=$question['qid']?>">请选择选项</div>
					<ul class="unstyled">
					<?php foreach ($question['optionlist'] as $option){?>
						<li><?php if($question['type'] == 1){?><input type="radio" name="answer_<?=$question['qid']?>[]" id="survey_option_<?=$option['opid']?>" value="<?=$option['opid']?>" /><?php }elseif($question['type'] == 2){?><input type="checkbox" name="answer_<?=$question['qid']?>[]" id="survey_option_<?=$option['opid']?>" value="<?=$option['opid']?>" /><?php }?><div class="op_content"><label for="survey_option_<?=$option['opid']?>" class="op4 q_option"><?=$option['content']?></label></div></li>
					<?php }?>
					</ul>
				</div>
			</div>
		<?php } }?>

		</div>

		<div style="float:left;padding-bottom:20px" class="fontfen">
			<input style="margin-left:350px" type="button" class="tijibtn" value="提交" onclick="save_answer();">
		</div>
	</div>

</form>
</div>

<script type="text/javascript">
function save_answer(){
	var finished = true;
	$.each($('.topic_type'),function(k,v){
		var qid = $(this).attr("qid");
		if($("input[name='answer_"+qid+"[]']:checked").length == 0){
			finished = false;
			$("#tip_"+qid).show();
			window.parent.resetmain();
			$("html,body",parent.document).animate({
				scrollTop: $("#survey_question_"+qid).offset().top+$("#mainFrame",parent.document).offset().top-30
			}, 'fast');
			return false;
		}
		else
		{
			$("#tip_"+qid).hide();
		}
	});
	if(finished){
		var sid = $("#sid").val();
		var answer = $("#mainform").serialize();
		$.ajax({
			type: "POST",
			url: "/myroom/survey/fillsave.html",
			data: {sid:sid,answer:answer},
			dataType: "json",
			success: function(data){
				if (data != undefined && data != null && data.status == 1) {
					$.showmessage({
						img : 'success',
						message:'提交成功',
						title:'回答问卷',
						callback : function(){
							<?php
							if(empty($survey['allowview'])){
								echo 'window.location.href="/myroom/survey/surveylist.html"';
							} else {
								echo 'window.location.href="/myroom/survey/stat/' . $survey['sid'] . '.html"';
							}
							?>
						}
					});
				}
				else {
					$.showmessage({
						img : 'error',
						message:'提交失败',
						title:'回答问卷'
					});
				}

			},
			error: function(){
				alert("服务器连接错误，请重试");
			}
		});
	}
	return false;
}
</script>

<?php $this->display('myroom/page_footer'); ?>