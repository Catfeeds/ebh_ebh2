<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta content="width=1000, user-scalable=no" name="viewport"/>
<title>我的题库</title>
<meta http-equiv="X-UA-Compatible" content="IE=7,IE=9">  
<meta http-equiv="X-UA-Compatible" content="IE=7,9">  
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
<!--[if lte IE 6]>  
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/DD_belatedPNG_0.0.7a.js"></script>
<script type="text/javascript">
DD_belatedPNG.fix('.bottom,.cservice img,.roomtit,.ui_ico');
</script>
<![endif]-->
<?php $v=getv();?>
<?php $systemsetting = Ebh::app()->room->getSystemSetting();?>
<meta name="keywords" content="<?=empty($systemsetting['metakeywords'])?'':$systemsetting['metakeywords']?>" />
<meta name="description" content="<?=empty($systemsetting['metadescription'])?'':$systemsetting['metadescription']?>" />
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/base.css<?=$v?>"/>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/public.bak.css<?=$v?>">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/jqtransform.css<?=$v?>">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/tikutop.css<?=$v?>"/>
<!--<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />-->
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" type="text/css" />
<!--<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/css/statch.css" />-->
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/wussyu.css<?=$v?>"/>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/kuque.css<?=$v?>"/>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/js/jquery/showmessage/css/default/showmessage.css<?=$v?>" /> 

<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/js/template/template-native-debug.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/js/myquestion2.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/quebase.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/quefix.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/js/common2.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/js/teacher.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/js/table.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/sinchoiceque.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/mulchoice.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/truefalseque.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/textque.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/textline.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/fillque.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/audio.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/subjective.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/js/jquery/showmessage/jquery.showmessage.js<?=$v?>"></script>
<script src="http://static.ebanhui.com/exam/js/myschapter.js<?=$v?>"></script>
<!-- 引入ztree -->
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/pageztree.css<?=$v?>">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/xztree/css/zTreeStyle/zTreeStyle.css<?=$v?>" >
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xztree/js/jquery.ztree.core-3.5.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xztree/js/jquery.ztree.excheck-3.5.js<?=$v?>"></script>
</head>
<body>
<script>
$(function(){
	<?php if(empty($notop)){?>
	if (top.location == self.location) {
		setCookie('ebh_refer',encodeURIComponent(self.location),10,'/','.<?=$this->uri->curdomain?>');
		//top.location='/troom.html';
    }
	<?php }?>
});
</script>
</head>

<body>
	<div class="lefrig">
		<div class="waitite">
			<div class="work_menu" style="position:relative;margin-top:0">
				<ul>
					<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso"><?=$pagemodulename?></span></a></li>
				</ul>
				<div style="float:right;display:inline;margin-right: 200px;">
					<a class="mulubgbtns" href="/troomv2/kuque/entrytest.html" target="_blank">录入试题</a>
				</div>
			</div>
			<div class="diles">
				<input name="title" class="newsou"  id="title" name="uname" value="请输入搜索关键词"  type="text" />
				<input id="ser" type="button" class="soulico" value="">
			</div>
			<div class="clear"></div>
		</div>
		<div class="workol">
			<div id="icategory" class="clearfix" style="border-top:none;">
				<dl style="float:left;display:inline;width:595px; *width:500px;">
				<dd>
					<div class="category_cont1">
						<div><a href="/troomv2/kuque.html" class="curr">我的题库</a></div>
						<div><a href="/troomv2/kuque/schquestion.html" class="network">网校题库</a></div>
						<div><a href="/troomv2/kuque/vFavquestion.html" class="myshouc">我收藏的</a></div>
						<div><a href="/troomv2/kuque/kufenxi.html" >题库分析</a></div>                     
					</div>
				</dd>
				</dl>
			</div>
			<div style="clear:both;"></div>
			<div id="questioncont">
				<div class="workdata" style="float:left;margin-top:0px;">
					<h2 class="ferygur">
				        <span>课程知识点</span>
				    </h2>
				    <div class="kdhtygs top" style="width:162px; float: left; margin: 15px 0 15px 20px;position: relative;">
				    	<div class="kstdg xchaptervertit" style="min-width: 125px;">
				            <span class="xchapterverselected" tag="0">请选择版本</span>
				        </div>
				        <div class="xchaptersver" id="chaptersver"></div>
				    </div>
				    <h2 class="ferygur" style="margin-bottom: 15px;">
				        <span>题型过滤</span>
				    </h2>
				    <div class="kstytwr">
				    	<ul>
				    		<li class="kedtg">
				            	<input id="myallque" type="radio"  value="0" checked="checked" name="myquetype">
								<label for="myallque">全部</label>
				            </li>
				        	<li class="kedtg">
				            	<input id="myxque" type="radio"  value="X" name="myquetype">
								<label for="myxque">答题卡</label>
				            </li>
				            <li class="kedtg">
				                <input id="myxtlque" type="radio"  value="XTL" name="myquetype">
				                <label for="myxtlque">听力题</label>
				            </li>
				            <li class="kedtg">
				                <input id="myxwxque" type="radio"  value="XWX" name="myquetype">
				                <label for="myxwxque">完形填空</label>
				            </li>
				            <li class="kedtg">
				                <input id="myxyudque" type="radio"  value="XYD" name="myquetype">
				                <label for="myxyudque">阅读理解</label>
				            </li>
				            <li class="kedtg">
				                <input id="myxzhque" type="radio"  value="XZH" name="myquetype">
				                <label for="myxzhque">组合题</label>
				            </li>
				        	<li class="kedtg">
				            	<input id="myaque" type="radio"  value="A" name="myquetype">
								<label for="myaque">单选题</label>
				            </li>
				        	<li class="kedtg">
				            	<input id="mybque" type="radio"  value="B" name="myquetype">
								<label for="mybque">多选题</label>
				            </li>
				        	<li class="kedtg">
				            	<input id="mydque" type="radio"  value="D" name="myquetype">
								<label for="mydque">判断题</label>
				            </li>
				        	<li class="kedtg">
				            	<input id="mycque" type="radio"  value="C" name="myquetype">
								<label for="mycque">填空题</label>
				            </li>
				        	<li class="kedtg">
				            	<input id="myeque" type="radio"  value="E" name="myquetype">
								<label for="myeque">文字题</label>
				            </li>
				            <li class="kedtg">
				            	<input id="myxhque" type="radio"  value="H" name="myquetype">
								<label for="myxhque">主观题</label>
				            </li>
				        </ul>
				    </div>
				    <div class="questionlist" id="myquestionlist">
				    </div>
				    <div id="mpage" style="height:60px;clear:both;"></div>
				</div>
			</div>
		</div>
	</div>
	<div style="clear: both;"></div>
    <input type="hidden" id="crid" value="<?=$crid?>" />
    <input type="hidden" id="pubtype" value="1" />
    <input type="hidden" id="mfolderid" value="0" />
    <input type="hidden" id="mchapterid" value="0" />
    <input type="hidden" id="nxchapterid" value="0" />
    <input type="hidden" id="nxsecchapterid" value="0" />
    <input type="hidden" id="nxtopchapterid" value="0" />
<script type="text/javascript">
var myque = new Myquestion();
var crid = "<?=$crid?>";
var qid=1;///【超级全局变量 】题目ID号，    变量名不重复
var qnumber=1;//【超级全局变量】 题目总数  变量名不可变
var question = 1;
$(function(){
    new xChapter({'callback':function(data){
        $("#mfolderid").val(data.folderid);
        $("#mchapterid").val(data.chapterid);
        $("#nxchapterid").val(data.lastchapterid);
        $("#nxsecchapterid").val(data.secchapterid);
        $("#nxtopchapterid").val(data.topchapterid);
      	myque.getpubquestion(1);
    },'checkbox':false,'bindthird':1});
    myque.getpubquestion(1);
	myque.init();

});
</script>
</body>
</html>
