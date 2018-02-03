<!DOCTYPE HTML>
<html>
<head>
<meta content="width=1000, user-scalable=no" name="viewport"/> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>错题集</title>
	<?php $v=getv();?>
	<?php $systemsetting = Ebh::app()->room->getSystemSetting();?>
	<meta name="keywords" content="<?=empty($systemsetting['metakeywords'])?'':$systemsetting['metakeywords']?>" />
	<meta name="description" content="<?=empty($systemsetting['metadescription'])?'':$systemsetting['metadescription']?>" />
	<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
	<?php }?>
	<link href="http://static.ebanhui.com/exam/css/base.css<?=$v?>" rel="stylesheet" type="text/css" />
	<link href="http://static.ebanhui.com/ebh/tpl/troomv2/css/wussyu.css<?=$v?>" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css<?=$v?>">
    <link href="http://static.ebanhui.com/exam/css/done.css<?=$v?>" rel="stylesheet" type="text/css"/>
    <link href="http://static.ebanhui.com/exam/css/jqtransform.css<?=$v?>" rel="stylesheet" type="text/css"/>
    <link type="text/css" href="http://static.ebanhui.com/exam/css/wavplayer.css<?=$v?>" rel="stylesheet"/>
    <link type="text/css" href="http://static.ebanhui.com/js/dialog/css/dialog.css<?=$v?>" rel="stylesheet"/>
    
    <script src="http://static.ebanhui.com/exam/js/jquery/jquery-1.11.0.min.js<?=$v?>"></script>
	<script src="http://static.ebanhui.com/exam/js/jquery/jquery-migrate-1.2.1.js<?=$v?>"></script>
	<script type="text/javascript" src="http://static.ebanhui.com/exam/js/template/template-native-debug.js<?=$v?>"></script>
	<script type="text/javascript" src="http://static.ebanhui.com/wap/js/common.js<?=$v?>"></script>
	<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts.js<?=$v?>"></script>
    <script type="text/javascript" src="http://static.ebanhui.com/js/dialog/dialog-plus.js<?=$v?>"></script>
	<style type="text/css">
	.delabtn {
		background: url(http://exam.ebanhui.com/static/images/dela.png) no-repeat;
		width: 79px;
		height: 25px;
		float: right;
		cursor: pointer;
		margin-bottom: 5px
	}
	.delahbtn {
		background: url(http://exam.ebanhui.com/static/images/delah.png) no-repeat;
		width: 79px;
		height: 25px;
		float: right;
		cursor: pointer;
		margin-bottom: 5px
	}
	#errlist .que {
		clear: both;
		padding: 5px 0 25px;
		height: auto;
		margin: 0;
	}
	#errlist .que p.desc {
		font-size: 12px;
		height: 35px;
		line-height: 35px;
		color: #3a3a3a;
		display: inline-block;
		border: 1px solid #f3f3f3;
		background: #f3f3f3;
		width: 983px;
		margin: 0 5px;
		padding-left: 5px;
	}
	#errlist .que p.desc span {
		display: inline-block;
		margin-right: 25px;
	}
	#errlist .que p.desc em {
		margin-right: 8px;
	}
	.work_search ul li {
		display: inline-block;
		float: left;
		height: 55px;
		line-height: 55px;
	}
	#errlist .que .operateBar {
		display: none;
	}
	#errlist .que .optionContent img {
		vertical-align: middle;
	}
	#icategory {
		background: #fff;
		border-top: 1px solid #E1E7F5;
		padding: 6px 20px;
		_margin-bottom: -5px;
	}
	#icategory dt {
		float: left;
		line-height: 22px;
		padding-right: 5px;
		text-align: left;
		font-size: 14px;
		color: #999;
	}
	#icategory dd {
		float: left;
		width: 885px;
	}
	.price_cont div a:hover,
	.price_cont div a.curr {
		background: none repeat scroll 0 0 #FF5400;
		color: #FFFFFF;
		text-decoration: none;
	}
	.category_cont1 div a.curr,
	.category_cont1 div a:hover {
		color: #5e96f5;
		color: #fff;
	}
	.category_cont1 div a {
		color: #333;
		text-decoration: none;
		padding: 2px 5px;
		font-size: 14px;
	}
	.category_cont1 div a.curr,
	.category_cont1 div a:hover {
		color: #fff;
		text-decoration: none;
		padding: 2px 5px;
		font-size: 14px;
		background: #5e96f5 none repeat scroll 0 0;
	}
	.category_cont1 div {
		float: left;
		height: 25px;
		line-height: 22px;
		overflow: hidden;
		padding: 0 10px;
	}
	.pbtns {
		background: url(http://static.ebanhui.com/ebh/tpl/2012/images/sunt0518.png) repeat scroll 0 0 transparent;
		border: medium none;
		color: #333333;
		height: 20px;
		vertical-align: middle;
		width: 40px;
		cursor: pointer;
	}
	html {
		background: none;
		color: #000;
	}
	.waitite {
		border-bottom: none;
		background: #fff;
	}
	
	.subjectPane {
		padding-left: 10px;
	}
	
	.lefrig {
		background: none;
	}
	
	a.chakan {
		color: #5e96f5;
	}
	
	.singleContainerFocused {
		border-top: none;
	}
	
	.radioPane li {
		width: 100% !important;
	}
	.answerLabel{
		display: inline-block;
	}
	</style>
</head>
<body>
<div class="lefrig">
	<div class="waitite">
		<div class="work_menu" style="position:relative;margin-top:0">
			<ul>
				<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso">错题集</span></a></li>
			</ul>
		</div>
		<div class="diles">
			<input name="title" class="newsou" id="title" name="uname" value="请输入试题关键字"  type="text" />
			<input id="ser" type="button" class="soulico" value="">
		</div>
	</div>
	<!-- ===课程筛选开始=== -->
	<div id="icategory" class="clearfix">
		<dt>所属课程：</dt>
		<dd>
			<div class="category_cont1 categoryfolder">
				<div>
					<a class="curr"  id="allfolder" href="javascript:void(0)">全部课程</a>
				</div>					
				
			</div>
		</dd>
	</div>
			<!-- ===课程筛选结束=== -->
	<div id="icategory" class="clearfix" style="border:none;display: none;">
		<dt>所属班级：</dt>
		<dd>
			<div class="category_cont1">
				<div>
					<a class="curr">全部班级</a>
				</div>
			</div>
		</dd>
	</div>
	<div class="workol" id="errlist">	
	</div>
	<div id="mpage" style="height:60px;clear:both; background: #fff;">
	</div>
</div>
<div class="clear"></div>
<script id="t:folder" type="text/html">
	<div>
		<a href="javascript:void(0)" tid="<%=tid%>" onclick="getErrorList(<%=tid%>)"><%=foldername%></a>
	</div>
</script>
<!-- 题目模板 -->
<script id="t:que" type="text/html">
	<%if(queType == 'A'){%>
		<div class="que singleContainer singleContainerFocused" qsval="<%=i + 1%>">
		<p class="desc"><span><em>作业名称:</em><strong title="<%=esubject%>"><%=sesubject%></strong></span><span><em>添加时间:</em><strong><%=dateline%></strong></span><span><em>试题类型:</em><strong>单选</strong></span><span><em>错误数:</em><strong style="color:#f85c72;"><%=errorCount%></strong></span><a href="javascript:;" class="chakan" onclick="showAlertY('<%=qid%>','<%=queType%>','<%=choicestr%>');">查看</a></p>
		<div class="subjectPane">
			<span class="stIndex" style=""><%=i + 1 +(page * 20)%>. </span>
			<span class="inputBox" style=" width: 95%;"><%=#qsubject%>（<span class="userAnsLabel" style="color:blue;font-weight:bold;padding:0 8px;"></span>）<em class="sorceLabel">[<%=quescore%>分]</em></span>
			<span class="clearing"></span>
		</div>
		<div class="radioPane">
			<ul style="overflow: hidden;">
				<%for(var i=0;i<blanks.length;i++){%>
				<li class="radioBox">
					<p class="radioWrapper" style="display:block; margin-right: 5px; float:left;width:35px;">
					<span class="jqTransformRadioWrapper">
						<a rel="question" class="jqTransformRadio" href="javascript:void(0);"></a>
						<input type="radio" value="" name="question" class="jqTransformHidden"></span>
						<label style="cursor:pointer;" bid='<%=keycode+i%>'></label>
					</p>
					<span class="optionContent" style="display: block;width: 85%; margin-left: 36px; word-break: break-all;"><%=#replaceBr(blanks[i].bsubject)%></span>
					<span class="clearing"></span>
				</li>
				<%}%>							
			</ul>
		</div>
        <div class="answerBar">正确答案：<span class="answerLabel"><%=#choicestr%></span></div>
        <%if(extdata == ''){%>
        <%}else{%>
        	<%if(fenxi == ''){%>
        		
        	<%}else{%>
        		<div class="title answerBar"><span style="float:left;">分析：</span><div class="resolve inputBox" style="width:85%;float:left;"><p><%=#extdata.fenxi%><br></p></div><div class="clearing"></div></div>
        	<%}%>
        	<%if(jx == ''){%>
        		
        	<%}else{%>
        		<div class="title answerBar"><span style="float:left;">解答：</span><div class="resolve inputBox" style="width:85%;float:left;"><p><%=#extdata.jx%><br></p></div><div class="clearing"></div></div>
        	<%}%>
        	<%if(dp == ''){%>
        	<%}else{%>
        		<div class="title answerBar"><span style="float:left;">点评：</span><div class="resolve inputBox" style="width:85%;float:left;"><p><%=#extdata.dp%><br></p></div><div class="clearing"></div></div>
        	<%}%>
        <%}%>
		<div class="operateBar"><div class="delabtn delerror" name="84269"></div></div>
	</div>
	<%}else if(queType == 'B'){%>
	<div class="que singleContainer singleContainerFocused " qsval="<%=i + 1%>">
		<p class="desc"><span><em>作业名称:</em><strong title="<%=esubject%>"><%=sesubject%></strong></span><span><em>添加时间:</em><strong><%=dateline%></strong></span><span><em>试题类型:</em><strong>多选</strong></span><span><em>错误数:</em><strong style="color:#f85c72;"><%=errorCount%></strong></span></p>
        <div class="subjectPane">
            <span class="stIndex" style=""><%=i + 1 +(page * 20)%>. </span>
            <span class="inputBox" style=" width: 95%;"><%=#qsubject%>（<span class="userAnsLabel" style="color:blue;font-weight:bold;padding:0 8px;"></span>）<em class="sorceLabel">[<%=quescore%>分]</em></span>
            <span class="clearing"></span>
        </div>
        <div class="radioPane">
            <ul style="overflow: hidden;">
            	<%for(var i=0;i<blanks.length;i++){%>
				<li class="radioBox" >
					<span class="radioWrapper" style="display:block; float:left; margin-right: 5px;">
					<span class="jqTransformRadioWrapper">
						<a rel="question" class="jqTransformRadio" href="javascript:void(0);"></a>
						<input type="radio" value="" name="question" class="jqTransformHidden"></span>
						<label style="cursor:pointer;" bid='<%=keycode+i%>'></label>
					</span>
					<span class="optionContent" style="display: block;width: 85%;margin-left: 36px; word-break: break-all;"><%=#replaceBr(blanks[i].bsubject)%><br></span>
					<span class="clearing"></span>
				</li>
				<%}%>
			 </ul>
        </div>
        <div class="answerBar">正确答案：<span class="answerLabel"><%=#choicestr%></span></div>
        <%if(extdata == ''){%>
        <%}else{%>
        	<%if(fenxi == ''){%>
        		
        	<%}else{%>
        		<div class="title answerBar"><span style="float:left;">分析：</span><div class="resolve inputBox" style="width:85%;float:left;"><p><%=#extdata.fenxi%><br></p></div><div class="clearing"></div></div>
        	<%}%>
        	<%if(jx == ''){%>
        		
        	<%}else{%>
        		<div class="title answerBar"><span style="float:left;">解答：</span><div class="resolve inputBox" style="width:85%;float:left;"><p><%=#extdata.jx%><br></p></div><div class="clearing"></div></div>
        	<%}%>
        	<%if(dp == ''){%>
        		
        	<%}else{%>
        		<div class="title answerBar"><span style="float:left;">点评：</span><div class="resolve inputBox" style="width:85%;float:left;"><p><%=#extdata.dp%><br></p></div><div class="clearing"></div></div>
        	<%}%>
        <%}%>
		<div class="operateBar"><div class="delabtn delerror" name="84270"></div></div>
    </div>	
	<%}else if(queType == 'C'){%>
	<div class="que singleContainer singleContainerFocused" qsval="<%=i + 1%>">
		<p class="desc"><span><em>作业名称:</em><strong title="<%=esubject%>"><%=sesubject%></strong></span><span><em>添加时间:</em><strong><%=dateline%></strong></span><span><em>试题类型:</em><strong>填空</strong></span><span><em>错误数:</em><strong style="color:#f85c72;"><%=errorCount%></strong></span></p>
        <div class="blankSubject subjectPane">
            <span class="stIndex" style=""><%=i + 1 +(page * 20)%>.</span>
            <span class="inputBox" style=" width: 95%;"><%=#qsubject%>
            <span class="pointLabel sorceLabel">[<%=quescore%>分]</span></span>
            <span class="clearing"></span>
        </div>
        <div class="answerBar">正确答案：
            <span class="answerLabel"><%=#choicestr%></span>
        </div>
        <%if(extdata == ''){%>
        <%}else{%>
        	<%if(fenxi == ''){%>
        		
        	<%}else{%>
        		<div class="title answerBar"><span style="float:left;">分析：</span><div class="resolve inputBox" style="width:85%;float:left;"><p><%=#extdata.fenxi%><br></p></div><div class="clearing"></div></div>
        	<%}%>
        	<%if(jx == ''){%>
        		
        	<%}else{%>
        		<div class="title answerBar"><span style="float:left;">解答：</span><div class="resolve inputBox" style="width:85%;float:left;"><p><%=#extdata.jx%><br></p></div><div class="clearing"></div></div>
        	<%}%>
        	<%if(dp == ''){%>
        		
        	<%}else{%>
        		<div class="title answerBar"><span style="float:left;">点评：</span><div class="resolve inputBox" style="width:85%;float:left;"><p><%=#extdata.dp%><br></p></div><div class="clearing"></div></div>
        	<%}%>
        <%}%>
	   	<div class="operateBar"><div class="delabtn delerror" name="84271"></div></div>
    </div>
	<%}else if(queType == 'D'){%>
	<div class="que singleContainer singleContainerFocused" qsval="<%=i + 1%>">
		<p class="desc"><span><em>作业名称:</em><strong title="<%=esubject%>"><%=sesubject%></strong></span><span><em>添加时间:</em><strong><%=dateline%></strong></span><span><em>试题类型:</em><strong>判断</strong></span><span><em>错误数:</em><strong style="color:#f85c72;"><%=errorCount%></strong></span><a href="javascript:;" class="chakan" onclick="showAlertY('<%=qid%>','<%=queType%>','<%=choicestr%>');">查看</a></p>
		<div class="questionContainer">
            <div class="subjectPane">
	            <span class="stIndex" style=""><%=i + 1 +(page * 20)%>. </span>
	            <span class="inputBox" style=" width: 95%;">
	            <%=#qsubject%>
	            <em class="sorceLabel">[<%=quescore%>分]</em></span>
	            <span class="clearing"></span>
            </div>

            <div class="userAnswerBar">
	            <div style="float:left;"><span>对错选项：</span></div>
		            <div style="float:left;">
			            <span class="jqTransformRadioWrapper">
			            <a class="jqTransformRadio" href="javascript:void(0);"></a>
			            <input type="radio" value="true" name="" class="jqTransformHidden"></span>
			            <label for="" style="cursor:pointer;float:left;margin-right:10px;">对</label>

			            <span class="jqTransformRadioWrapper">
			            <a class="jqTransformRadio" href="javascript:void(0);"></a>
			            <input type="radio" value="false" name="" class="jqTransformHidden"></span>
			            <label for="" style="cursor:pointer;">错</label>
		        	</div>
		            <div class="clearing"></div>
	            </div>
	        </div>
            <div class="answerBar">正确答案：<span class="answerLabel"><%=choicestr=='1'?'对':'错'%></span></div>
            <%if(extdata == ''){%>
        <%}else{%>
        	<%if(fenxi == ''){%>
        		
        	<%}else{%>
        		<div class="title answerBar"><span style="float:left;">分析：</span><div class="resolve inputBox" style="width:85%;float:left;"><p><%=#extdata.fenxi%><br></p></div><div class="clearing"></div></div>
        	<%}%>
        	<%if(jx == ''){%>
        		
        	<%}else{%>
        		<div class="title answerBar"><span style="float:left;">解答：</span><div class="resolve inputBox" style="width:85%;float:left;"><p><%=#extdata.jx%><br></p></div><div class="clearing"></div></div>
        	<%}%>
        	<%if(dp == ''){%>
        		
        	<%}else{%>
        		<div class="title answerBar"><span style="float:left;">点评：</span><div class="resolve inputBox" style="width:85%;float:left;"><p><%=#extdata.dp%><br></p></div><div class="clearing"></div></div>
        	<%}%>
        <%}%>
        <div class="operateBar"><div class="delabtn delerror" name="84273"></div></div>
	</div>	
	<%}else if(queType == 'E'){%>
	<div class="que singleContainer singleContainerFocused" qsval="<%=i + 1%>"> 
		<p class="desc"><span><em>作业名称:</em><strong title="<%=esubject%>"><%=sesubject%></strong></span><span><em>添加时间:</em><strong><%=dateline%></strong></span><span><em>试题类型:</em><strong>文字</strong></span><span><em>错误数:</em><strong style="color:#f85c72;"><%=errorCount%></strong></span></p>
        <div class="subjectPane">
            <span class="stIndex" style=""><%=i + 1 +(page * 20)%>. </span>
            <span class="inputBox" style=" width: 95%;">
            <%=#qsubject%>	            <em class="sorceLabel">[<%=quescore%>分]</em></span>
            <span class="clearing"></span>
        </div>
        <div class="answerBar" style="width: 805px;display: block;">正确答案：<span class="answerLabel"><%=#choicestr%></span></div>
		<%if(extdata == ''){%>
        <%}else{%>
        	<%if(fenxi == ''){%>
        		
        	<%}else{%>
        		<div class="title answerBar"><span style="float:left;">分析：</span><div class="resolve inputBox" style="width:85%;float:left;"><p><%=#extdata.fenxi%><br></p></div><div class="clearing"></div></div>
        	<%}%>
        	<%if(jx == ''){%>
        		
        	<%}else{%>
        		<div class="title answerBar"><span style="float:left;">解答：</span><div class="resolve inputBox" style="width:85%;float:left;"><p><%=#extdata.jx%><br></p></div><div class="clearing"></div></div>
        	<%}%>
        	<%if(dp == ''){%>
        		
        	<%}else{%>
        		<div class="title answerBar"><span style="float:left;">点评：</span><div class="resolve inputBox" style="width:85%;float:left;"><p><%=#extdata.dp%><br></p></div><div class="clearing"></div></div>
        	<%}%>
        <%}%>
	</div>	
	<%}%>
</script>
<script type="text/javascript">
	var crid = "<?=$crid?>";
	var folderss = [];
	var searchtext = "请输入试题关键字";
	function getfolderList(url){
		if(typeof url == "undefined") {
			url = '/troomv2/folder/erFolderAjax.html';
		}
		
		$.ajax({
			url:url,
			method:'post',
			dataType:'json',
			data : {
				crid : crid
			}
		}).done(function(res){
			var folder = res.datas;
			var tids = [];
			for(var i=0;i<folder.length;i++){
				folderss.push(folder[i].folderid);
				tids.push(folder[i].folderid);
				var data = {
					folderid : folder[i].folderid,
					foldername : folder[i].foldername,
					tid : folder[i].folderid
				}
				var $dom = $(template('t:folder',data));
				$(".categoryfolder").append($dom);
			}
			tab('.categoryfolder div a','curr');
			getErrorList(tids)
			$('#allfolder').on('click',function(){
				getErrorList(tids)
			})
		}).fail(function(){
			console.log('req err');
		});
	};
	function getErrorList(tid,url,page){  //错题集题目解析
		if(typeof url == "undefined") {
			url = '/troomv2/examv2/errlistAjax.html';
		}
		var title = $("#title").val();
	    if(title == searchtext) 
	       title = "";
		$.ajax({
			url:url,
			method:'post',
			dataType:'json',
			data : {
				ttype : 'FOLDER',
				q : title,
				tid: tid || tidreturn()
			}
		}).done(function(res){
			$("#errlist").empty();
			$('#mpage').empty();
			if(!res.datas){
				var cmain_bottom = '<div class="cmain_bottom " style="width: 100%; min-height: 400px; background:#fff">' +
					'<div class="study" style="margin: 0 auto; width: 205px;">' +
						'<div class="nodata"></div>'+
						'<p class="zwktrykc" style="text-align: center;"></p>'+
					'</div>'+
	        	'</div>';
				$('#errlist').empty().append(cmain_bottom);
			}else{
			if(res.datas.errList){
				var errList = res.datas.errList;
			}else{
				var errList = [];
			}
			if(errList.length <= 0){
				var cmain_bottom = '<div class="cmain_bottom " style="width: 100%; min-height: 400px; background:#fff">' +
					'<div class="study" style="margin: 0 auto; width: 205px;">' +
						'<div class="nodata"></div>'+
						'<p class="zwktrykc" style="text-align: center;"></p>'+
					'</div>'+
	        	'</div>';
				$('#errlist').empty().append(cmain_bottom);
			}else{
				
				for(var i=0;i<errList.length;i++){
					if(errList[i].question.qsubject.substr(errList[i].question.qsubject.length - 4) == '<br>'){
						errList[i].question.qsubject =  errList[i].question.qsubject.substring(0,errList[i].question.qsubject.length-4);
					};
					
					if(errList[i].question.queType == 'C'){
						var qsubject =	errList[i].question.qsubject.replace(/#input#/g,'<input type="text" readonly="readonly" maxlength="2147483647" size="20" value="">');
						qsubject =	qsubject.replace(/#img#/g,'<input type="text" readonly="readonly" maxlength="2147483647" size="20" value="">');
					}else{
						var qsubject = errList[i].question.qsubject;
					}
					if(errList[i].question.queType == 'C'){
						var choicestr = [];
						for(var j=0;j<errList[i].question.blanks.length;j++){
							if(/ebh_1_data-latexebh_2_/.test(errList[i].question.blanks[j].bsubject)){
							  var bsubjecthtml = unescape(errList[i].question.blanks[j].bsubject.replace(/ebh_1_/g,' ').replace(/ebh_2_/g,'='));
							  bsubjecthtml = '<img '+ bsubjecthtml +' />';
							   choicestr.push(bsubjecthtml);
							}else{
								choicestr.push(errList[i].question.blanks[j].bsubject);
							}
						}
						var  choicestr = choicestr.join(';&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;')
					}else if(errList[i].question.queType == 'E'){
						var  choicestr = errList[i].question.blanks[0].bsubject;
					}else{
						var choicestr = errList[i].question.choicestr;
					};
					if(errList[i].question.extdata == ''){
						var extdata = '';
					}else{
					var extdata = $.parseJSON(errList[i].question.extdata);
					}
					if(errList[i].exam.esubject.length>30){
					    var  sesubject = errList[i].exam.esubject.substring(0,30)+"...";
					}else{
						var  sesubject = errList[i].exam.esubject;
					}
					var jx = extdata.jx.replace("(?:<div>|</div>)","").replace(/&nbsp;/g,'').replace(/<br>/g,'').replace(/<p>/g,'').replace(/<\/p>/g,'').replace(/\s/g, "");
					var dp = extdata.dp.replace("(?:<div>|</div>)","").replace(/&nbsp;/g,'').replace(/<br>/g,'').replace(/<p>/g,'').replace(/<\/p>/g,'').replace(/\s/g, "");
					var fenxi = extdata.fenxi.replace("(?:<div>|</div>)","").replace(/&nbsp;/g,'').replace(/<br>/g,'').replace(/<p>/g,'').replace(/<\/p>/g,'').replace(/\s/g, "");
					template.helper("replaceBr", function(a){
						return a.replace(/<br>/g,'');
					});
					var data = {
						page : (res.datas.page - 1),
						i : i,
						keycode : 65,
						queType : errList[i].question.queType,
						esubject : errList[i].exam.esubject,
						sesubject : sesubject,
						dateline : getLocalTime(errList[i].question.dateline),
						blanks : errList[i].question.blanks,
						quescore : errList[i].question.quescore,
						qsubject : qsubject,
						choicestr : choicestr,
						errorCount : errList[i].errorCount,
						extdata :extdata,
						jx : jx,
						dp : dp,
						fenxi : fenxi,
						qid :  errList[i].question.qid
					};
					var $dom = $(template('t:que',data));
					$("#errlist").append($dom);
				}
				var $pagedom = $(res.datas.pagestr);
				$pagedom.find('.listPage a').bind('click',function(){
					var url = $(this).attr('data');
					if(!!url) {
						getErrorList(tid,url,res.datas.page);
					}
				});
				$('#mpage').empty().append($pagedom)
				$('.radioBox label ').each(function(){
					$(this).text(String.fromCharCode($(this).attr('bid')));
				})
				var ii = setInterval(function(){
						var allready = true;
						$.each($('img'),function(v){
							if($(this)[0].complete == false){
								allready = false;
								return false;
							}
						});
						if(allready == true){
							parent.resetmain();
							window.clearInterval(ii);
						}
					},1000);
				resetIframeHeight();
			}	
			}
			
			
			}).fail(function(){
			console.log('req err');
		});	
	};
	function showAlertY(qid,quetype,choicestr){ //错题集查看功能
		  $.ajax({
			url:'/troomv2/examv2/answerCount.html',
			method:'post',
			dataType:'json',
			data : {
				qid : qid ,
				quetype : quetype,
				choicestr : choicestr
			}
		}).done(function(res){
			var answerDetaillist = res.datas.answerDetaillist;
			var data = [];
			for(var i=0;i<answerDetaillist.length;i++){
				if(quetype == 'D'){
					if(answerDetaillist[i].choiceStr == '10'){
						answerDetaillist[i].choiceStr = '对';
					}else if(answerDetaillist[i].choiceStr == '01'){
						answerDetaillist[i].choiceStr = '错';
					};
				}
				if(answerDetaillist[i].choiceStr == '' || answerDetaillist[i].choiceStr == '00'){
					answerDetaillist[i].choiceStr = '没填';
				}
				data.push([answerDetaillist[i].choiceStr,answerDetaillist[i].count])
			}
			if(quetype == 'D'){
				if(res.datas.simpleQue.answers == '0'){
					var datachoicestr = '错';
				}else if(res.datas.simpleQue.answers == '1'){
					var datachoicestr = '对';
				}
			}else{
				var datachoicestr = res.datas.choicestr;
			}
			top.dialog({
			    title: '学生答题情况',
			    content: "<div id='container' class='fl' style='width:670px;'></div><h1 style='font-size:32px;font-family:微软雅黑;line-height:32px;text-transform:capitalize;'>正确答案:"+datachoicestr+"</h1>",
			    width: 670,
			    height: 520
			}).showModal();
			$('#container', parent.document).highcharts({
		        chart: {
		            plotBackgroundColor: null,
		            plotBorderWidth: null,
		            plotShadow: false
		        },
		        title: {
		            text: ''
		        },
		        tooltip: {
		            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
		        },
		        plotOptions: {
		            pie: {
		                allowPointSelect: true,
		                cursor: 'pointer',
		                dataLabels: {
		                    enabled: true,
		                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
		                    style: {
		                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
		                    }
		                }
		            }
		        },
		        credits:{
				     enabled:false // 禁用版权信息
				},
		        series: [{
		            type: 'pie',
		            name: '学生答案',
		            data:data
		        }]
		    });
		}).fail(function(){
			console.log('req err');
		});
	}
	var PWin = parent.window, PDoc = PWin.document;
	var resetIframeHeight = function() {   //iframe高度
	    if (PWin && PWin != window) {
	        var d = PDoc.getElementById('mainFrame');
	        var dImgs = document.getElementsByTagName('img');
	        if (d) {
	            d.style.height = document.body.scrollHeight + 'px';
	            for (var i=0;i<dImgs.length;i++) {
	                dImgs[i].onload = function() {
	                    d.style.height = document.body.scrollHeight + 'px';
	                };
	            }
	        }
	    }
	};
		// -------------------添加/查看错题功能开始--------------------
	function addtoerr() {
		var url = '/'+crid+'/student/errorbook/addtobookAjax.html';
		$.ajax({
			url:url,
			method:'post',
			dataType:'json',
			data : {
				dqid:$("#adddqid").val()
			}
		}).done(function(res){
			if(res.errCode == '0') {
				alert('添加成功 errorid :' + res.datas.errorid);
			}else {
				alert(res.errMsg);
			}
		});
	}
	
	function ifaddtoerr() {
		var url = '/'+crid+'/student/errorbook/hasaddedAjax.html';
		$.ajax({
			url:url,
			method:'post',
			dataType:'json',
			data : {
				dqid:$("#ifadddqid").val()
			}
		}).done(function(res){
			if(res.errCode == '0') {
				if(res.datas.added == 0 ){
					alert('没有添加');
				}else {
					alert('已经添加过');
				}
			}else {
				alert(res.errMsg);
			}
			
		});
	}
	function tab(tobj,cls){
		$(tobj).each(function(){
		 	$(this).on('click',function(){
		 		$(tobj).removeClass(cls);
				$(this).addClass(cls);
		 	})
		 	
		})
	} 
	function getLocalTime(nS) {     
	    return new Date(parseInt(nS) * 1000).toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ");      
	}
	function numtostr(num) {
		var nums = [];
		var str = 'ABCDEFGHIJKLMNOPQ';
		var sstr = [];
		for(var i=0;i<num.length;i++){
			nums.push(num[i]);
			if(num[i] == '1'){
			  sstr.push(str[i]);
			}
		}
 		var sstr = sstr.join(',');
 		return sstr;
	}
	function tidreturn(){
		 var alltid = []
		 
		if($('#allfolder').hasClass('curr')){
	   		for(var i=1;i<$('.categoryfolder div a').length;i++){
	   			var curr =  $('.categoryfolder div a');
	   			var atid = $(curr[i]).attr('tid');
	   			alltid.push(atid);
	   		}
	   		return  alltid;
	   }else{
	   		var tid = $('.categoryfolder div a.curr').attr('tid');
	   		return  tid;
	   }
	}
	$(function(){
		getfolderList();
		
		initsearch("title",searchtext);
		$("#ser").on('click',function(){
		   getErrorList();
		});
		$("#queType,#ttype,#tid").on('change',function(){
			getKlist();
		})
		resetIframeHeight();
	
	});
</script>
</body>
</html>