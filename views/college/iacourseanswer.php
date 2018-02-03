
<?php $this->display('college/room_header'); ?>
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
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/selcur/css/interactive.css<?=getv()?>" />
<style>
body{
	background: #f3f3f3;
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
.addzhu {
	margin-top: 3px;
    padding: 5px 0;
	display: inline-block;
	width:180px;
	height:120px;
	position:relative;
	float:left;
}
.addzhu a.delet {
	width:20px;
	height:20px;
	display:block;
	position:absolute;
	top:-5px;
	right:-10px;
	background:url(http://static.ebanhui.com/ebh/tpl/selcur/images/delete.png) no-repeat;
}
.addzhu a.edits {
	width:20px;
	height:20px;
	display:block;
	position:absolute;
	top:22px;
	right:-10px;
	background:url(http://static.ebanhui.com/ebh/tpl/selcur/images/edit.png) no-repeat;
}
</style>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<div class="lefrig" style="margin-top:0; float:none;">
<form id="mainform">
	<div class="survey_main fl" style="margin:0;">
		<div class="survey_title" style="position:relative">
			<div class="h4-bg p_title" ><?= shortstr(strip_tags($ics['title']),50) ?></div>
			<input type="hidden" id="sid"  />
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
							<div class="th4 q_title" ><?=$question['title']?></div>
						</div>
						<div class="red" id="tip_<?=$question['icqid']?>">请选择选项</div>
						<ul class="unstyled">
						<?php if($question['type'] != 3){ ?>
							<?php if($question['type'] == 2){
								if(empty($question['options'])){
									$question['options'] =array('urlpath'=>'');
								}
							} ?>
							<?php foreach ($question['options'] as $option){?>
								<li>
									<?php if($question['type'] == 0){?>
										<!-- 单选题 -->
										<input id="option_<?php echo $question['icqid'];?>_<?php echo $option['itemid'];?>" type="radio" name="answer_<?=$question['icqid']?>[]"  value="<?=$option['itemid']?>" />
									<?php }elseif($question['type'] == 1){?>
										<!-- 多选题 -->
										<input id="option_<?php echo $question['icqid'];?>_<?php echo $option['itemid'];?>" type="checkbox" name="answer_<?=$question['icqid']?>[]"  value="<?=$option['itemid']?>" />
									<?php }elseif($question['type'] == 2){?>
										<!-- 主观题 -->
									<?php }elseif($question['type'] == 3){?>
										<!-- 文字题 -->
									<?php }?>
									<div class="op_content">
										<label for="option_<?php echo $question['icqid'];?>_<?php echo isset($option['itemid']) ? $option['itemid'] : '';?>" class="op4 q_option"><?= isset($option['content']) ? $option['content']:''?></label>

										<?php if($question['type'] == 2){ ?>
											<div>
												<?php if(!empty($option['urlpath'])){ ?>

												<div class="addzhu">
												    <a href="javascript:;">
												    	
												        <img src="<?= $option['urlpath'] ?>"  width="180" height="120"/>
												       
												    </a>
												</div> 
												<?php }?>
												<div id="div_<?=$question['icqid']?>" class="addzhu" style="margin-left:20px;display:none" >
												    <img id="img_<?=$question['icqid']?>" src="http://static.ebh.net/ebh/images/cszx04.png" width="180" height="120"/>
												    <a class="delet" href="javascript:;" onclick="removeimg('<?=$question['icqid']?>')"></a>
												    <a class="edits" href="javascript:;" onclick="edit('<?= strip_tags($question['title']) ?>','<?=$question['icqid']?>')"></a>
												</div>
												<input type="hidden" id="answer_<?=$question['icqid']?>" name="answer_<?=$question['icqid']?>" value="">
												<a href="javascript:;" class="dasrbtn" onclick="show_question('<?= isset($option['urlpath']) ? $option['urlpath']:'' ?>', '<?= strip_tags($question['title']) ?>', '<?=$question['icqid'] ?>')" id="btn_<?=$question['icqid']?>" >答题</a>
											</div>
										<?php }elseif($question['type'] == 3){ ?>
											<div>
												<input type="hidden" name="answer_<?=$question['icqid']?>" value="">
												<textarea onkeyup="show(this)" rows="6" cols="80" placeholder="请输入答案..."></textarea>
											</div>
											
										<?php } ?>
									</div>
								</li>
							<?php }?>
						<?php }else{ ?>
							<div>
								<input type="hidden" name="answer_<?=$question['icqid']?>" value="">
								<textarea onkeyup="show(this)" rows="6" cols="80" placeholder="请输入答案..."></textarea>
							</div>
						<?php }?>
						</ul>
					</div>
				</div>
			<?php } }?>

		</div>
		<div class="bottban">
			<div class="nsrtrsr">
		    	<div class="botlef1">
		        	题数：<span class="husret"><?= count($questions) ?></span>道
		        </div>
		        <div class="botlef2">
		        	<a class="tsidbtn" href="javascript:;" onclick="save_answer(this)">提交</a>
		        </div>
		        <div class="botlef3">
		        	<a class="huitop" href="#top">返回顶部</a>
		        </div>
		    </div>
		</div>
		
	</div>

</form>
</div>

<script type="text/javascript">
function save_answer(){
	this.disabled = 'disabled';
	var finished = true;
	var isself = window.top==window.self ? true : false;
	var sid = $("#sid").val();
	var answer = $("#mainform").serializeArray();
		$.ajax({
			type: "POST",
			url: "/college/iacourse/save.html",
			data: {uid:<?=$user['uid']?>,icid:<?=$ics['icid']?>,crid:<?=$ics['crid']?>,starttime:<?=$starttime?>,answer:answer},
			dataType: "json",
			success: function(data){
				if (data != undefined && data != null && data.status == 1) {
							<?php
								echo 'window.location.href="/myroom.html'.'?url=college/iacourse.html"';
							?>
				}
				else {
					top.dialog({
				        skin:"ui-dialog2-tip",
				        width:350,
				        content: "<div class='FPic'></div><p>你已经提交过了！</p>",	
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
	// }
	return false;
}

function show_question(imgsrc, title,icqid){
		height = 800;
		width = 900;
		url = '/drawingboards.html?url='+imgsrc+'&title='+title+'&icqid='+icqid; 
		title = '主观题回答';
		var html = '<iframe marginheight="0" marginwidth="0" frameborder="0" width="'+width+'" height="'+height+'" src="'+url+'"></iframe>';
		H.create(new P({
			id : 'artdialogss',
			title : title,
			width : width,
			height : height,
			content : html,
			easy:true
		},{onclose:function(){
			H.get('artdialogss').exec('destroy');
		}}),'common').exec('show');
}
function show(obj){
	$(obj).prev().val(obj.value);
}

function removeimg(icqid){
	$("#div_"+icqid).hide();
	$("#btn_"+icqid).css('display','block');
	$("#answer_"+icqid).val('');
}

function edit(title,icqid){
	var imgsrc = $("#img_"+icqid).attr('src');
	show_question(imgsrc, title,icqid);
}
$(function(){
	$('.ctop').next().hide();
});
</script>

