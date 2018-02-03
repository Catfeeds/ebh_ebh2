<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= empty($survey['title']) ? $this->get_title() : strip_tags($survey['title']) ?></title>
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
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css?v=20151123001"/>
<style>
body{
	background:#f7f7f7;
}
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
	cursor:pointer;
}
.red {
	display: none;
    color: red;
    font-size: 14px;
    padding-bottom: 5px;
}
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
.remark{width:640px;height:100px;}
</style>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<div class="lefrig" style="margin-top:15px;">
<div class="cmain_bottom" style="height:42px;">
	<div class="study" style="border-bottom:none; padding-bottom:0;">
		<div class="study_top" style="background:#fff;">
			<div class="fl"><h3>调查问卷</h3></div>
		</div>
	</div>
</div>
<form id="mainform">
	<div class="survey_main fl" style="margin:0;">
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
				<div class="topic_type_con"<?php if($survey['type'] == 4) { echo ' style="min-height:60px;"'; } ?>>
					<div class="topic_question">
						<div class="th4 q_title" id="survey_question_<?=$question['qid']?>"><?=$question['title']?></div>
					</div>
					<div class="red" id="tip_<?=$question['qid']?>"><?=$question['type'] == 3 || $question['type'] == 4 ? '请填写此项' : '请选择选项'?></div>
					<ul class="unstyled">
                        <?php if ($question['type'] == 3) { ?>
                            <input type="text" class="completion" id="fill_<?=$question['qid']?>" name="answer_<?=$question['qid']?>" />
                        <?php } else if ($question['type'] == 4) { ?>
							<textarea class="remark" style="resize: none;" id="fill_<?=$question['qid']?>" name="answer_<?=$question['qid']?>"></textarea>
						<?php } else {
                            foreach ($question['optionlist'] as $option){
                                $otherFill = $question['type'] ==11 && preg_match('/^[a-zA-Z]\.$/', $option['content']) ? true : false; ?>
                                <li><?php if($question['type'] == 1 || $question['type'] ==11){?><input type="radio" name="answer_<?=$question['qid']?>[]" id="survey_option_<?=$option['opid']?>" value="<?=$otherFill ? '0' : $option['opid']?>" /><?php }elseif($question['type'] == 2){?><input type="checkbox" name="answer_<?=$question['qid']?>[]" id="survey_option_<?=$option['opid']?>" value="<?=$option['opid']?>" /><?php }?><div class="op_content"><label for="survey_option_<?=$option['opid']?>" class="op4 q_option"><?=$option['content']?><?php if ($otherFill) { ?>其他&nbsp;<input class="fill_txt completion" type="text" name="f_answer_<?=$question['qid']?>" /><input type="hidden" name="f_answer_o_<?=$question['qid']?>" value="<?=$option['opid']?>" /><?php } ?></label></div></li>
                            <?php }
                        } ?>
					</ul>
				</div>
			</div>
		<?php } }?>

		</div>

		<div style="float:left;padding-bottom:20px" class="fontfen">
			<input style="margin-left:460px" type="button" class="tijibtn" value="提交" onclick="save_answer();">
		</div>
        <?php if (!empty($return)) { ?>
            <input type="hidden" value="<?=htmlspecialchars($return, ENT_COMPAT)?>" id="return" />
        <?php } ?>
	</div>

</form>
</div>

<script type="text/javascript">
    function closeWebPage(){
        if (navigator.userAgent.indexOf("MSIE") > 0) {
            if (navigator.userAgent.indexOf("MSIE 6.0") > 0) {
                window.opener = null;
                window.close();
            } else {
                window.open('', '_top');
                window.top.close();
            }
        }
        else if (navigator.userAgent.indexOf("Firefox") > 0) {
            window.location.href = 'about:blank ';
        } else {
            window.opener = null;
            window.open('', '_self', '');
            window.close();
        }
    }
function save_answer(){
	var finished = true;
	var isself = window.top==window.self ? true : false;
	var localed = false;
	$.each($('.topic_type'),function(k,v){
		var qid = $(this).attr("qid");
        var txt = $("#fill_"+qid);
		if (txt.size() > 0) {
            if (txt.val() != '') {
                $("#tip_"+qid).hide();
                return;
            } else {
                finished = false;
                $("#tip_"+qid).show();
                txt.focus();
                return;
            }
        }

	if($(this).attr("type") != 4){
		if($("input[name='answer_"+qid+"[]']:checked").length == 0){
			finished = false;
			$("#tip_"+qid).show();
			if (isself) {
				$("html,body").animate({
					scrollTop: $("#survey_question_"+qid).offset().top-30
				}, 'fast');
			} else {
				window.parent.resetmain();
				$("html,body",parent.document).animate({
					scrollTop: $("#survey_question_"+qid).offset().top+$("#mainFrame",parent.document).offset().top-30
				}, 'fast');
			}
			return false;
		}
		else
			{
				$("#tip_"+qid).hide();
			}
	}else{
			if($(this).find(".q_textarea").val() == ""){
				finished = false;
				return false;
			}else{
				finished = true;
			}
	}});
	if(finished){
		var sid = $("#sid").val();
		var answer = $("#mainform").serialize();
		$.ajax({
			type: "POST",
			url: "/survey/fillsave.html",
			data: {sid:sid,answer:answer},
			dataType: "json",
			success: function(data){
				if (data != undefined && data != null && data.status == 1) {
					$.showmessage({
						img : 'success',
						message:'提交成功',
						title:'回答问卷',
						callback : function(){
						    var iReturn = $("#return");
						    if (iReturn.length == 1) {
						        var returnUrl = $.trim(iReturn.val());
                                if (returnUrl == 'blank') {
                                    closeWebPage();
                                    return;
                                }
						        if (returnUrl) {
						            location.href = returnUrl;
                                    return;
                                }
                            }
							<?php
							if(empty($survey['allowview'])){
								echo 'window.open("about:blank","_self").close()';
							} else {
								echo 'window.location.href="/survey/stat/' . $survey['sid'] . '.html"';
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

(function($) {
    var isself = window.top==window.self ? true : false;
    if (isself) {
        $(document).bind('load', function() {
            window.parent.resetmain();
        });
    }
})(jQuery);
</script>

<?php $this->display('myroom/page_footer'); ?>
