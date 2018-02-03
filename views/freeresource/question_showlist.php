<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="http://static.ebanhui.com/portal/css/ebhportal.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js?version=20150528001"></script>
<link type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/css/custom/jquery-ui.min.css" rel="stylesheet" /> 
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/jquery-ui.min.js"></script>
<title><?=empty($seoInfo['title'])?$this->get_title():$seoInfo['title']?></title>
<meta name="keywords" content="<?=empty($seoInfo['keyword'])?$this->get_keywords():$seoInfo['keyword']?>" />
<meta name="description" content="<?=empty($seoInfo['description'])?$this->get_description():$seoInfo['description']?>" />
</head>
<body>

<div class="rgjuet">
<?=$topStr?>
</div>
<?php if($showSearchInput) {?>
<div class="kbgfer">
<div class="sotuds">
<input type="text" value="<?=empty($q)?'输入名称':$q?>" id="listsearch" name="listsearch" class="txtnamte">
<a href="javascript:void(0)" onclick="_search()" class="dsoubtn"></a>
</div>
</div>
<?php }?>
<div class="gdkger">
<?php foreach ($questionList as $value) {?>
    <div class="lsfjge">
    	<h2 class="dhdreth">知识点：<?=$value['knowledgepoint']?><span style="float:right;">编号：<?=$value['serialnumber']?>&nbsp;&nbsp;年级：<?=$value['gradename']?>&nbsp;&nbsp;学科：<?=$value['subjectname']?>&nbsp;&nbsp;题型：<?=$value['questiontype']?></span></h2>
    <div class="neistts">
    	题目：<?=$value['question']?> <br />
        
        <div class="answer" style="display:none">  
            答案：<?=$value['answer']?> <br />  
            试题分析：<?=$value['analysis']?>
        </div>     
    </div>    
    <div class="bdfess">
    	<a href="javascript:void(0)" class="daanbtn">查看答案</a>
    </div>
    </div>
<?php }?>
</div>

<div>    
    <p><?=$pageStr?></p>
</div>

<script>	
	$(document).ready(function(e) {
        $("a.daanbtn").click(function(){
			if($(this).html()=="查看答案"){
			    $(this).html("收起答案");
				$(this).parent().prev("div.neistts").children("div.answer").show();	
			}
			else
			{
				$(this).html("查看答案");	
				$(this).parent().prev("div.neistts").children("div.answer").hide();
			}			
			//调用父窗口方法重设高度
			parent.window.resetmain();
		});
    });

	
<?php if($showSearchInput) {?>
	$(function(){
		initsearch("listsearch","输入名称");
	});
	function _search(){
		var q = $("#listsearch").val();
		if(q=='输入名称'){
			location.href="<?=$searchPath?>";
		}else{
			location.href="<?=$searchPath?>?q="+q;
		}
		
	}
<?php }?>
</script>

<?php
debug_info();
?>
<!-- 统计代码开始 -->
<?php EBH::app()->lib('Analytics')->get('baidu')?>
<!-- 统计代码结束 -->
</body>
</html>