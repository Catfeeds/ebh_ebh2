<?php $this->display('troomv2/room_header'); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= empty($ics['title']) ? $this->get_title() : strip_tags($ics['title']) ?></title>
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
	background:#f3f3f3;
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
.fontfen .tijibtn{
	background:#5e96f5;
}
.fontfen .tijibtn:hover{
	background:#4e8bf1;
}
a.dasrbtn {
    background: #5386f9 none repeat scroll 0 0;
    border-radius: 3px;
    color: #fff;
    display: block;
    font-size: 14px;
    height: 26px;
    line-height: 26px;
    text-align: center;
    width: 70px;
	float:left;
	text-decoration:none;
	margin:103px 0 0 20px;
}
</style>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<div class="lefrig" style="margin:0 auto;float:none;">

<form id="mainform">
	<div class="survey_main fl" style="margin:0;">
		<div class="survey_title" style="position:relative">
			<div class="h4-bg p_title" id="survey_title_<?=$survey['sid']?>"><?= strip_tags($ics['title']) ?></div>
			<input type="hidden" id="sid" value="<?=$survey['sid']?>" />
		</div>
		<!--内容-->
		<div id="survey_content">

			<?php if (!empty($questions)) {
				foreach ($questions as $key => $question){?>
				<div class="topic_type" qid="<?=$question['icqid']?>">
					<div class="topic_type_menu">
						<div class="setup-group">
							<h4>Q<?=$key+1?></h4>
						</div>
					</div>
					<div class="topic_type_con">
						<div class="topic_question">
							<div class="th4 q_title" id="survey_question_<?=$question['icqid']?>"><?=$question['title']?></div>
						</div>
						<div class="red" id="tip_<?=$question['icqid']?>">请选择选项</div>
						<ul class="unstyled">
						<?php if($question['type'] != 3){ ?>
							<?php foreach ($question['options'] as $option){?>
								<?php 
									if($question['type'] == 0 || $question['type'] == 1){
										$chosen = json_decode($answers[$question['icqid']]['answercontent']);
									} 
								?>
								<li>
									<?php if($question['type'] == 0){?>
										<!-- 单选题 -->
										<input type="radio" name="answer_<?=$question['icqid']?>[]" id="survey_option_<?=$option['itemid']?>" value="<?=$option['itemid']?>" <?php if($chosen && in_array($option['itemid'], $chosen)) echo 'checked'; ?>  disabled/>
									<?php }elseif($question['type'] == 1){?>
										<!-- 多选题 -->
										<input type="checkbox" name="answer_<?=$question['icqid']?>[]" id="survey_option_<?=$option['itemid']?>" value="<?=$option['itemid']?>" <?php if($chosen && in_array($option['itemid'], $chosen)) echo 'checked'; ?>  disabled />
									<?php }elseif($question['type'] == 2){?>
										<!-- 主观题 -->
									<?php }elseif($question['type'] == 3){?>
										<!-- 文字题 -->
									<?php }?>
									<div class="op_content">
									<?php if($chosen && in_array($option['itemid'], $chosen)){?>
										<label style="color:blue" for="survey_option_<?=$option['itemid']?>" class="op4 q_option"><?=$option['content']?></label>
									<?php }else{?>
										<label for="survey_option_<?=$option['itemid']?>" class="op4 q_option"><?=$option['content']?></label>
									<?php }?>
										<?php if($question['type'] == 2){ ?>
											<div>
												<img src="<?= $option['urlpath'] ?>" width="200" height="200" style="float:left">
												<input type="hidden" name="answer_<?=$question['icqid']?>" value="http://laravelacademy.org/wp-content/uploads/2016/08/laravel-5-3-docs.jpg">
												<?php if(!empty($answers[$question['icqid']]['answercontent'])){?>
												<img src="<?= $answers[$question['icqid']]['answercontent'] ?>" width="200" height="200" style="float:left">
												<?php } ?>
											</div>
										<?php }elseif($question['type'] == 3){ ?>
											<div>
												<input type="hidden" name="answer_<?=$question['icqid']?>" value="">
												<textarea onkeyup="show(this)" rows="6" cols="80" placeholder="请输入答案..." disabled><?= $answers[$question['icqid']]['answercontent'] ?></textarea>
											</div>
											
										<?php } ?>
									</div>
								</li>
							<?php }?>
						<?php }else{ ?>
							<div>
								<input type="hidden" name="answer_<?=$question['icqid']?>" value="">
								<textarea onkeyup="show(this)" rows="6" cols="80" placeholder="请输入答案..." disabled><?= $answers[$question['icqid']]['answercontent'] ?></textarea>
							</div>
						<?php }?>
						</ul>
					</div>
				</div>
			<?php } }?>

		</div>
	</div>

</form>
<script type="text/javascript">
$(function(){
	$('.ctop').next().hide();
})
</script>
</div>