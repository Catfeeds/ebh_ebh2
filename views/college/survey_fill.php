<?php $this->assign('notop',TRUE);$this->display('college/room_header'); ?>

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
.op_content .op4{
	cursor:pointer;
}
.red {
	display: none;
    color: red;
    font-size: 14px;
    padding-bottom: 5px;
}
.fontfen .tijibtn{
	background:#5e96f5;
}
.fontfen .tijibtn:hover{
	background:#4e8bf1;
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
.closebotton{
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
    float: left;
    margin-left: 15px;
    margin-top: 9px;
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
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
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
	<div class="survey_main fl" style="margin:0;">
		<!--标题-->
		<div class="survey_title" style="position:relative;border-bottom: solid 1px #ddd;">
			<div class="h4-bg p_title" id="survey_title_<?=$survey['sid']?>"><?=$survey['title']?></div>
			<input type="hidden" id="sid" value="<?=$survey['sid']?>" />
		</div>
		<p class="stimes">发布者：<?= $survey['realname']?>　发布时间：<?= date('Y-m-d H:i',$survey['dateline']) ?></p>
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
			<div class="topic_type" qid="<?=$question['qid']?>" type="<?=$question['type']?>">
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
					<?php if($question['type'] == 4){?>
						<ul class="unstyled">
							<li>
								<textarea class="q_textarea" rows="4" cols="60" name="answer_<?=$question['qid']?>" id="survey_option_<?=$option['opid']?>" value="<?=$option['opid']?>" style="resize: none;border: none;border: 1px solid #dcdcdc;"></textarea>	
							</li>
						</ul>
					<?php }else{ ?>
						<ul class="unstyled">
							<?php foreach ($question['optionlist'] as $option){?>
								<li>
									<?php if($question['type'] == 1){?>
										<input type="radio" name="answer_<?=$question['qid']?>[]" id="survey_option_<?=$option['opid']?>" value="<?=$option['opid']?>" />
									<?php }elseif($question['type'] == 2){?>
											<input type="checkbox" name="answer_<?=$question['qid']?>[]" id="survey_option_<?=$option['opid']?>" value="<?=$option['opid']?>" />
									<?php }?>
									<div class="op_content">
										<label for="survey_option_<?=$option['opid']?>" class="op4 q_option"><?=$option['content']?></label>
									</div>
								</li>
							<?php }?>
						</ul>
					<?php }?>
				</div>
			</div>
		<?php } }?>

		</div>

		<div style="float:left;padding-bottom:20px" class="fontfen">
			<input style="margin-left:420px;float: left;" type="button" class="tijibtn" value="提交" onclick="save_answer();">
			<a href="javascript:window.opener=null;window.open('','_self');window.close();" class="closebotton">关闭</a>
		</div>
	</div>

</form>
</div>

<script type="text/javascript">
function save_answer(){
	var finished = true;
	var isself = window.top==window.self ? true : false;
	$.each($('.topic_type'),function(k,v){
		var qid = $(this).attr("qid");
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
							/*top.dialog({
					        skin:"ui-dialog2-tip",
					        width:350,
					        content: "<div class='TPic'></div><p>提交成功！</p>",
							onshow:function(){
								setTimeout(function () {
									<?php
									if(empty($survey['allowview'])){
										if($survey['type']==3){
		                                    echo 'window.location.href="/college/xuanke/mycourse.html?xkid='.$survey['xkid'].'"';

									    }elseif(empty($roominfo['iscollege']))

											echo 'window.location.href="/myroom/survey/surveylist.html"';
										else
											echo 'window.location.href="/college/survey/surveylist.html"';
									} else {
		                                echo 'window.location.href="/college/survey/stat/' . $survey['sid'] . '.html"';
									}
									?>
								}, 1000);
							}	
							}).show();*/
							<?php
								$autoclose = $this->input->get('autoclose');
								if(!empty($autoclose)){
									echo 'window.opener=null;window.open("","_self");window.close();';
								} elseif(empty($survey['allowview'])){
										if($survey['type']==3){
		                                    echo 'window.location.href="/college/xuanke/mycourse.html?xkid='.$survey['xkid'].'"';

									    }elseif(empty($roominfo['iscollege']))

											echo 'window.location.href="/myroom/survey/surveylist.html"';
										else
											echo 'window.location.href="/college/survey/surveylist.html"';
									} else {
		                                echo 'window.location.href="/college/survey/stat/' . $survey['sid'] . '.html"';
									}
									?>
				}
				else {
					top.dialog({
				        skin:"ui-dialog2-tip",
				        width:350,
				        content: "<div class='FPic'></div><p>提交失败！</p>",	
						onshow:function(){
							var that=this;
							setTimeout(function () {
								that.close().remove();
					}, 2000);
				}
				}).show();
			}
			},
		});
	}
	return false;
}
</script>

<?php $this->display('myroom/page_footer'); ?>
	

