<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>题库列表</title>
	<script src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
	<!-- <script src="http://static.ebanhui.com/exam/js/baiduTemplate.js"></script> -->
	<style type="text/css">
		.pages{ height:50px; padding-top:15px; float:right; padding-right:20px;}
		.listPage a {background:#f9f9f9;border: 1px solid #f9f9f9;display: block;float: left;font-weight:bold;height: 26px;line-height:26px;margin: 0 2px;text-align: center;width: 30px;color:#767676!important;text-decoration:none;}
		.listPage a:visited {background:#f9f9f9;border: 1px solid #f9f9f9; display: block;  float: left;  height: 26px;line-height:26px; margin: 0 2px; text-align: center; width: 30px;color:#323232;text-decoration:none;}
		.listPage a:Hover {	border:1px solid #0CA6DF;text-decoration: none;}
		.listPage .none{border:1px solid #23a1f2;background:#23a1f2;color:#FFFFFF!important;font-weight:bold;}
		#next{ width:66px; height:26px; }
		#gopage{ width:26px;padding:3px 2px;  border:1px solid #CCCCCC; font-size:12px; text-align:center; float:left;}
		#page_go{ width:45px; height:20px;}
		.errlist span{
			margin-right: 20px;
		}

	</style>
</head>
<body>
	<div id="mpage" style="width:500px;height:40px;clear:both;"></div>
	试题类型：
	<select id="queType" name="queType">
		<option value="">全部</option>
		<option value="A">单选题</option>
		<option value="B">多选题</option>
		<option value="C">判断题</option>
		<option value="D">填空题</option>
		<option value="E">主观题</option>
	</select>

	<br/><br/>
	关联类型：
	<select id="ttype" name="ttype">
		<option value="">全部</option>
		<option value="FOLDER">课程</option>
		<option value="COURSE">课件</option>
		<option value="CHAPTER">知识点</option>
	</select>

	关联目标id:<input id="tid" type="text" name="tid"  value="241" />
	<br/><br/>
	关键字:<input id="q" type="text" name="q"  value="" />

	<div style="border:1px solid #f00;margin-top: 50px;padding:20px;">
		试题列表：
		<div id="kuqs"> 
			
		</div>
	</div>


	<!-- 单题样板 -->
	<!-- <script id="t:que" type="text/html">
	    <div style="padding:10px;">
	        <span>错题集标号编号:<%=errorid%></span>
	        <span>试题标题:<%=question.qsubject%></span>
	        <span>试题分数:<%=question.quescore%></span>
	        <span>试题md5码:<%=question.md5code%></span>
	        <span>我的分数:<%=answerQueDetail.totalscore%></span>
	    </div>
	</script> -->
	
	<script type="text/javascript">
		var crid = "<?=$crid?>";

		function getKlist(url){
			if(typeof url == "undefined") {
				url = '/college/examv2/errlistAjax.html';
			}
			$.ajax({
				url:url,
				method:'post',
				dataType:'json',
				data : {
					queType:$("#queType").val(),
					ttype:$("#ttype").val(),
					tid:$("#tid").val(),
					q:$("#q").val()
				}
			}).done(function(res){
				var $pagedom = $(res.datas.pagestr);
				$pagedom.find('.listPage a').bind('click',function(){
					var url = $(this).attr('data');
					if(!!url) {
						getKlist(url);
					}
				});
				$("#mpage").empty().append($pagedom);
				renderList(res.datas.errList);
			}).fail(function(){
				console.log('req err');
			});
		}

		function renderList(errList) {
			$("#kuqs").empty();

			for(var i = 0,length = errList.length;i<length;i++) {
				//var $dom = $(baidu.template('t:que',errList[i]));
				var data = errList[i].question;
				var answerQueDetail = errList[i].answerQueDetail;
				var $dom = $("<div style='padding:10px;' class='errlist'>"+
					"<span>作业编号:"+errList[i].errorid+"</span>"+
					"<span>作业标题:"+data.qsubject+"</span>"+
					"<span>作业分数:"+data.quescore+"</span>"+
					"<span>作业类型:"+data.md5code+"</span>"+
					"<span>答题人数:"+answerQueDetail.totalscore+"</span>"+
					//"<span>状态："+status+"</span>"+
					"");
				$dom.data('info',errList[i]);
				$("#kuqs").append($dom);
			}
		}

		$(function(){
			getKlist();
			$("#queType,#ttype,#tid").on('change',function(){
				getKlist();
			})
		});











		// -------------------添加/查看错题功能开始--------------------
		function addtoerr() {
			var url = '/college/examv2/addtobookAjax.html';
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
			var url = '/college/examv2/hasaddedAjax.html';
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
		// -------------------添加/查看错题功能结束--------------------
	</script>

	<p>请打开控制台查看更多信息</p>
	<button onclick="getKlist()">重新请求数据</button>

	<br/>
	<br/>
	<br/>
	<div>------------------------------------------------------添加错题集功能----------------------------------------------------------------------------------</div>
	
	将dqid为<input id="adddqid" type="text" name="dqid"  />的试题回答 添加到错题集 <button onclick="addtoerr()">添 加</button>
	<br />
	<br />
	<br />

	dqid为<input id="ifadddqid" type="text" name="dqid"  />的试题回答 是否已经添加到错题集 <button onclick="ifaddtoerr()">查 看</button>

</body>
</html>