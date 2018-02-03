	<?php $this->display('troomv2/exam2/teacher/teacher_header'); ?>
	<?php $v=getv();?>
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/wussyu.css<?=$v?>"/>
	<script src="http://static.ebanhui.com/exam/newjs/tremark.js<?=$v?>"></script>
	<script src="http://static.ebanhui.com/exam/newjs/exam.js<?=$v?>"></script>
	<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js<?=$v?>"></script>
	<script src="http://static.ebanhui.com/exam/js/template/template-native-debug.js<?=$v?>"></script>
	<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts.js<?=$v?>"></script>
	<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts-3d.js<?=$v?>"></script>
    <title>作业批阅</title>
	<style>
	html{
		background: #f3f3f3;
	}
	body{
		min-height: 100%;
		background: #f3f3f3;
		font-family: "微软雅黑";
	}
	.completetime i,.totalscore i{display:inline-block;height: 8px;width: 7px;line-height: 8px;margin-left:5px;background: url(http://static.ebanhui.com/ebh/tpl/default/images/orderbg.png) no-repeat 0 0;}
	.imgyuan{
		width:50px;
	}
	.Havepay{
		width: 430px;
		position: relative;
		height: 55px;
		float: left;
	}
	.Havepay div img{
		margin: 0 3px;
	}
	.Havepay .offR,.Havepay .onR{
		position: absolute;
		top: 0;
		left: 10px;
	}
	.onTxt{
		position: absolute;
		left: 330px;
	}
	.dsiters{
		margin-top: 90px;
	}
	.Havepay .onR img{
		display: none;
	}
	.averageTime{
		width: 180px;
		height: 55px;
		background: url(http://static.ebanhui.com/exam/images/Alarm.jpg) no-repeat;
		padding-left: 56px;
		float: left;
		margin-left: 10px;
	}
	.soulico {
		float:left;
		background:url(http://static.ebanhui.com/ebh/tpl/2014/images/newsolico.jpg) no-repeat;
		height:24px;
		width:26px;
		border:none;
		cursor:pointer;
	}
	.newsou {
	    width: 150px;
	    height: 22px;
	    line-height: 22px;
	    border: solid 1px #d9d9d9;
	    border-right: none;
	    color: #d2d2d2;
	    padding-left: 5px;
	    float: left;
	}
	.diles {
	    display: inline;
	    height: 30px;
	    position: absolute;
	    right: 8px;
	    top: -30px;
	    width: 185px;
	    
	}
	a.revise{
		float: left;
	    background: url(http://static.ebanhui.com/ebh/tpl/troomv2/images/xiugai.png) no-repeat;
	    width: 26px;
	    height: 27px;
	    margin-left: 12px;
	}
	a.shansge{
		margin-left: 25px;
		display: none;
	}
	.lefrig{
		float: none;
		margin: 0 auto;
	}
	a.waskes{ margin-left: 60px;} /*35*/
	a.remind{margin-left:10px ;color:cornflowerblue;}
	div.work_mes,div.workdata{
		position: relative;
		min-height: 500px;
	}
	div.work_mes{
		height: auto;
		float: left;
	}
	.extendul{
		height: 42px;
	    border-bottom: solid 1px #e3e3e3;
	}
	.mk_j_num,.mk_y_time{
		color:#ed5468;font-size: 30px; font-weight: 500; line-height: 30px;
	}
	.ui-tabs-hide
		{
		    display: none;
		}
	.completetimebP i{
		background-position: 0px -8px;
	}
	/*分页*/
	#mpage{}
		
	.pages{ height:50px; padding-top:15px; padding-right:20px;}
	.listPage{height: 30px; text-align: center; margin: 0 auto;}
	.listPage a {background:#f9f9f9;border: 1px solid #f9f9f9;display: inline-block;font-weight:bold;height: 26px;line-height:26px;margin: 0 2px;text-align: center;width: 30px;color:#767676!important;text-decoration:none;}
	.listPage a:visited {background:#f9f9f9;border: 1px solid #f9f9f9; display: block;  float: left;  height: 26px;line-height:26px; margin: 0 2px; text-align: center; width: 30px;color:#323232;text-decoration:none;}
	.listPage a:Hover {	border:1px solid #0CA6DF;text-decoration: none;}
	.listPage .none{border:1px solid #23a1f2;background:#23a1f2;color:#FFFFFF!important;font-weight:bold;}
	#next{ width:66px; height:26px; }
	#gopage{ width:26px;padding:3px 2px;  border:1px solid #CCCCCC; font-size:12px; text-align:center; float:left;}
	#page_go{ width:45px; height:20px;}
	#mpage{}
	#viewcontent{
		margin: 0;
		max-width: 1000px;
		padding: 0 20px;
	}
	a.waskes{
	background: #5e96f5 none repeat scroll 0 0;
    border: medium none;
    border-radius: 4px;
    color: #ffffff;
    display: block;
    float: left;
    height: 25px;
    line-height: 25px;
    margin-right: 20px;
    text-align: center;
    text-decoration: none;
    width: 108px;
    font-weight: 500;
	}
	.answerBar,.userAnswerBar,.scoreBar,.linkBar,.textScoreBar,.textAnswerBar{
		padding: 0;
	}
	#container{
		padding: 0;
	}
	.layoutContainer{
		width: 1000px;
	}
	#center{
		padding: 0;
	}
	.datatab td{
		padding: 10px 0 10px 20px;
		border: none;
	}
	.work_mes{
		overflow: visible;
	}
	#container .right{
		top: 62px;
		right: -325px;
	}
	.work_mes ul li.item{
		margin: 0!important;
		padding: 0;
	}
	.clear{
			clear:both; height: 0; line-height: 0; font-size: 0
		}
	.ChoiceThis{
		width: 100%; height:30px; margin-top:8px
	}
	.studentList{
		width: 965px;
		height: auto;
		
	}
	.stl_num{
		padding: 28px 32px;
		-webkit-box-shadow: inset 2px 2px 10px 1px #dcdcdc;
		 -moz-box-shadow: inset 2px 2px 10px 1px #dcdcdc;
		box-shadow: inset 2px 2px 10px 1px #dcdcdc;
	}
	.stl_num .top{
		height: 60px;
	}
	.stl_num .top .centerl{
		width: 280px;
	}
	.stl_num .top .left{
		width: 180px;
	}
	.stl_num .top .left p,.stl_num .top .centerl p{
		margin: 3px 0 0px 10px;
	}
	.stl_num .top .rightl{
		width: 440px;
	}
	.stl_num .top .rightl p{
		line-height: 60px;
		font-family: "微软雅黑";
	}
	.stl_num .top .rightl p span.getscores{
		 vertical-align:middle;   
		font-size: 30px;
		color: #F95D72;
	}
	.stl_num .userTime{
		font-size: 20px;
	}
	.stl_num .userTime img{
		width: 20px;
    	margin-bottom: 4px;
    	margin-right: 5px;
	}
	.stl_num .bottom{
		padding-bottom: 20px;
		border-bottom: 1px solid #E8E8E8;
	}
	.stl_num .bottom .left .Progressbar{
		width: 250px;
		background: #E7E7E7;
		height: 15px;
		display: inline-block;
		border-radius:7px;
		overflow:hidden;
		margin-right:10px
	}
	.stl_num .bottom .left .Progressbar div{
		width: 20px;
		background: #F95D72;
		height: 15px;
	}
	.stl_num .bottom .rightl a{
		display: inline-block;
		width: 103px;
		height: 30px;
		background: #BAC3D2;
		color:#fff;
		font-size: 14px;
		line-height: 30px;
		font-weight: 600;
		text-align: center;
		border-radius: 3px;
		margin-left: 10px;
	}
	.stl_num .answerBoxs{
		min-height: 100px;
	}
	.stl_num .bottom .rightl a.on{
		background: #6B7B94;
	}
	#correctbt{
		margin: 0 auto;
		width: 113px;
		height: 32px;
		border-radius: 3px;
		color:#fff;
		background:#5e96f5;
		font-size: 14px;
		font-weight: 600;
		text-align: center;
		line-height: 32px;
		margin-top: 10px;
	}
	.answerBoxs .answersubbtn{
		border: none;
	    background: url(http://static.ebanhui.com/exam/images/answersub01.jpg);
	    color: #fff;
	    width: 79px;
	    height: 23px;
	    line-height: 23px;
	    margin-right: 10px;
	    cursor: pointer;
	}
	.ksrdgae{
		margin: 0 20px;
		float: none;
	}
	/*.singleContainerFocused:first-child{
		border-top:none;
	}*/
	.ChoiceThis a.waskes{
		margin-left: 0;
	}
	.que{
		padding: 5px 20px 30px 20px;
	}
	.remarkxz{
		width: 96%;
	    height: 20px;
	    display: block;
	    white-space: nowrap;
	    overflow: hidden;
	    text-overflow: ellipsis;
	}
	.classlist{
		text-align: center;
		margin-top: 10px;
		line-height: 24px;
	}
	.classlist a{
		padding: 0px 10px;
	    display: inline-block;
	    height: 24px;
	    border-radius: 3px;
	    margin: 2px 3px;
	    cursor: pointer;
	}
	.classlist a.active{
		color: #fff;
		background: #5e96f5;
	}
	.classlist span{
		margin: 2px 3px;
	}
	.jisret{		
		/*overflow: hidden;
	    text-overflow: ellipsis;
	    height: 45px;
	    white-space: nowrap;*/
	}
	.selectZjs{
		position:absolute;
		right: 200px;
		top:49px;
		z-index: 66;
	}
	.selectZjs select{
		width: 142px;
		outline: 0;
		border: 1px solid #d9d9d9;
	}	
	.ui-dialog-button{position: relative;}
	.ui-dialog-button .ui-dialog-autofocus[i-id=原题]{
		position: absolute;
		top:0;
		left:-645px;
	}	
	.ui-dialog-button .ui-dialog-autofocus[i-id=全景图]{
		position: absolute;
		top:0;
		left:-710px;
	}	
	</style>

</head>

<body>
<div id="header">
	<div class="adAuto">
		<div class="magAuto top">
			<p>您好,<?php echo !empty($user['realname']) ? $user['realname'] : $user['username'] ;?></p>
		</div>
	</div>
	<div class="Ad">
		<div class="magAuto">
			<img src="http://static.ebanhui.com/exam/images/banner/stu_head_pic.jpg" />
		</div>
	</div>
</div>
<div id="container">
<div class="lefrig">
    <h2 class="jisret"></h2>
	<div class="fl" style="width: 100%;">
		<div class="fl" style="width: 100%; ">
			<p class="kishre" style="width: 100%;text-align: center;float: none;"><span class="ksrdgae pusTime">布置时间：</span><span class="ksrdgae scorelab">总分：</span><span class="ksrdgae limittime">计时：分钟</span></p>
			<div style="width: 100%;" class='classlist'>
				
			</div>
			<div class="clear"></div>
		</div>
		
		<div class="fl" style="height: 100%; width: 380px; overflow: hidden;">
			<div id='container1' class="fl" style="height: 250px;width:380px;">
				
			</div>
		</div>
		<div style="width: 620px;height: 100%;background: #fff;" class="fl">
			<div class="dsiters">
			    <div class="Havepay">
			    	<div class="offR">
			    		<img src="http://static.ebanhui.com/exam/images/offR.jpg" />
			    		<img src="http://static.ebanhui.com/exam/images/offR.jpg" />
			    		<img src="http://static.ebanhui.com/exam/images/offR.jpg" />
			    		<img src="http://static.ebanhui.com/exam/images/offR.jpg" />
			    		<img src="http://static.ebanhui.com/exam/images/offR.jpg" />
			    		<img src="http://static.ebanhui.com/exam/images/offR.jpg" />
			    		<img src="http://static.ebanhui.com/exam/images/offR.jpg" />
			    		<img src="http://static.ebanhui.com/exam/images/offR.jpg" />
			    		<img src="http://static.ebanhui.com/exam/images/offR.jpg" />
			    		<img src="http://static.ebanhui.com/exam/images/offR.jpg" />
			    	</div>
			    	<div class="onR">
						<img src="http://static.ebanhui.com/exam/images/onR.jpg" />
						<img src="http://static.ebanhui.com/exam/images/onR.jpg" />
						<img src="http://static.ebanhui.com/exam/images/onR.jpg" />
						<img src="http://static.ebanhui.com/exam/images/onR.jpg" />
						<img src="http://static.ebanhui.com/exam/images/onR.jpg" />
						<img src="http://static.ebanhui.com/exam/images/onR.jpg" />
						<img src="http://static.ebanhui.com/exam/images/onR.jpg" />
						<img src="http://static.ebanhui.com/exam/images/onR.jpg" />
						<img src="http://static.ebanhui.com/exam/images/onR.jpg" />
						<img src="http://static.ebanhui.com/exam/images/onR.jpg" />
						
			    	</div>
			    	<div class="onTxt">
			    		已交 <span class="mk_y_num">0</span>/<span class="mk_q_num">---</span><br />
			    		<p class="mk_j_num">---</p>
			    	</div>
			    	
			    </div>
			    <div class="averageTime">
			    	<div>
			    		平均答题时间<br />
			    		<p class="mk_y_time" >---</p>
			    	</div>
			    </div>
			</div>
		</div>
		
	</div>
	<div class="work_mes">
	    <ul class="extendul ui-tabs-nav">
	        <li  value="0" class="workcurrent"><a href="javascript:;">学生试题批阅</a></li>
			<li  value="1" onclick="$('#viewcontent').empty();$('#container .right').remove();examobj.initExam()"><a href="#">单题批阅</a></li>
	    </ul>
	    
    	<div class="fl ui-tabs-panel">
    		<div class="lishnrt">
				<a href="javascript:void(0);" value='0' class="hietse xhusre">全部</a>
				<a href="javascript:void(0);" value='1' class="hietse ">已交作业</a>
				<a href="javascript:void(0);" value='2' class="hietse ">未交作业</a>
		    </div>
		    <a class="jaddre" href="/troomv2/examv2/scexcelv2.html?eid=<?=$eid?>" style="right: 350px;top:45px;z-index: 66;"> 导出excel</a>
		    <div class="selectZjs">
		    	<select id ="gardesList">
		    		<option value="">全部</option>
		    	</select>
		    </div>
		    <div class="workdata fl" style="margin-top:0;">
		    	
		    	<div class="diles">
					<input name="title" class="newsou" id="title" name="uname" value="请输入学生姓名"  type="text" />
					<input id="ser" type="button" class="soulico" value="">
				</div>
				
		        <table class="datatab" width="100%" cellspacing="0" cellpadding="0" style="border:none;">
		            <tr class="first">
		                <td width="20%">个人信息</td>
		                <td width="18%">班级</td>
		                <td width="17%">提交时间</td>
		                <td width="10%" class="completetime completetimebP" style="text-align: center;cursor:pointer;">用时<i></i></td>
		                <td width="10%" class="totalscore completetimebP" style="text-align: center;cursor:pointer;">得分<i></i></td>
		                <td width="25%" style="text-align: center;">操作</td>
		            </tr>
		        </table>
		        <div id="mpage"></div>
		    </div>
		    
    	</div>
    	<div class="fl ui-tabs-panel ui-tabs-hide">
    		<div class="sheet-con" id="container">
				<div id="desk" class="layoutContainer" style=" position:relative;">
				    <div id="center">
						<div id="webEditor" class="font12px">
				            <div id="infoPane" style="padding:8px 5px 0px">
				            	
				        	</div>  
				            <div id="viewcontent" class="viewcontent jqtransformdone">
				            	
				            </div>
				            
				        </div>
				    </div>
				    <div id="bottomBar">
				    </div>
				</div>
			</div>
    	
    	</div>
    	<div class="clear"></div>
	</div>
	<div class="clear"></div>
</div>
</div>
<script type="text/html" id="t:answer">
		<tr class="">
        <td style="word-break: break-all; word-wrap:break-word;">
            <a title="" href="javascript:;" style="float:left;">
            	<% if(face == ''){%>
            		<% if(sex == '0'){ %>
            			<img class="imgyuan" src="http://static.ebanhui.com/ebh/tpl/default/images/m_man_50_50.jpg">
            		<%}else if(sex == '1'){%>
            			<img class="imgyuan" src="http://static.ebanhui.com/ebh/tpl/default/images/m_woman_50_50.jpg">
            		<%}%>
            	<%}else{%>
                	<img class="imgyuan" src="<%=face%>">
                <%}%>
            </a>
            <p class="ghjut" style="width:120px">
            	
            	<span title="<%=realname%>"><%=substrinreal(realname)%></span>
            	<% if(sex == '0'){ %>
                <img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/man.png">
                <%}else if(sex == '1'){%>
                <img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/women.png">	
                <%}%>
            </p>
            <p class="ghjut" style="width:120px;color:#999;"><%=username%></p>
        </td>
        <td>
            <p><%=classname%></p>
            <p style="color:#999;" title=""></p>
        </td>
        <% if(status == 1){ %>

        <td>
            <p><%=ansdateline%></p>
            <p style="color:#999;" title=""></p>
        </td>
        <td style="text-align: center;"><%=Mathceil(usedtime)%>分钟</td>
        <td style="text-align: center;"><%=anstotalscore%>分</td>
        <td>
      		<%if(correctrat == 100){%>
             	<a class="waskes" href="/troomv2/examv2/eview/<%=aid%>.html?eid=<%=eid%>" target="_blank">查看结果</a>
             <%}else{%>
             	<a class="waskes" href="/troomv2/examv2/papercorrect/<%=aid%>.html?eid=<%=eid%>" target="_blank">批阅</a>
             <%}%>	
			 <a class="shansge" href="javascript:;" onclick="" title="删除"></a>
        </td>
         <%}else{%>
         	
         	<td>
            <p>---</p>
            <p style="color:#999;" title=""></p>
        </td>
        <td style="text-align: center;">---</td>
        <td style="text-align: center;">---</td>
        <td>
            <span class="jierty" style="padding-left: 75px;">未交作业</span>
            
          
        </td>
         <%}%>
    </tr>
	 
</script>

<script>
//<a class="remind" href="#">提醒</a>
var eid = "<?=$eid?>";
var kcode = "<?=$k?>";
var uid = "<?=$uid?>";
<?php
if(checkbrowser()){
	$isMobile = 'true';
}else{
	$isMobile = 'false';
}
$isMobile = 'false';
global $_SGLOBAL;
?>

var isMobile = <?php echo $isMobile; ?>;
var browser = '<?php echo $_SGLOBAL["browser"];?>';
var qnumber=1;//【超级全局变量】 题目总数  变量名不可变
var qid=1;///【超级全局变量 】题目ID号，    变量名不重复
var crid = "<?=$crid?>";
var tremarkobj = new Tremark();
var examobj= new Exam();
var urlSign = top.location.search;
$(function(){
	//判断实时作业进入
	if(urlSign == "?soft=true"){
		$(".lefrig").css("margin",0);
		$("#header").hide();
	}
	$(".que").hover(function(){
		$(this).addClass("light");
		},function(){
			$(this).removeClass("light");
		});

	$(".que").live("mouseover", function(){
		$(this).addClass("light");
	});
	$(".que").live("mouseout", function(){
		$(this).removeClass("light");
	});
});

</script>
<script >
	var searchtext = "请输入学生姓名";
	var classids = $.parseJSON(GetQueryString('classids')) || [];
	var classid = [];
	initsearch("title",searchtext);
	 $("#ser").on('click',function(){
	   	getser();
	   });
	function GetQueryString(name) {
        var reg = new RegExp('(^|&)' + name + '=([^&]*)(&|$)', 'i');
        var r = window.location.search.substr(1).match(reg);
        if (r != null) {
            return unescape(r[2]);
        }
        return null;
    }
	function getser(url){
		if(typeof url == "undefined") {
			url = '/troomv2/examv2/alistAjaxbyname.html';
		}
	   var title = $("#title").val();
	   var folderid = $("a.curr").attr('tag');
	   if(title == searchtext) 
	       title = "";
	   $.ajax({
			url:url,
			method:'post',
			dataType:'json',
			data : {
				eid : eid,
				realname : title
			}
		}).done(function(res){
			var $pagedom = $(res.datas.pagestr);
			$pagedom.find('.listPage a').bind('click',function(){
				var url = $(this).attr('data');
				var estype = $('.curr').attr('data');
				if(!!url) {
					getser(url);
				}
			});
			$("#mpage").empty().append($pagedom);
			
				renderAList(res.datas.userAnswerList);
		}).fail(function(){
			console.log('req err');
		});
	}   
	function getElist(order,url) {
		if(typeof url == "undefined") {
			url = '/troomv2/examv2/alistAjax.html';
		}
		$.ajax({	
			url:url,
			method:'post',
			dataType:'json',
			data:{
				'eid':eid,
				'order' : order,
				'classid':classid,
				'sstatus':$('.lishnrt .xhusre').attr('value')
			}
		}).done(function(res){
			var $pagedom = $(res.datas.pagestr);
			$pagedom.find('.listPage a').bind('click',function(){
				var url = $(this).attr('data');
				if(!!url) {
					getElist('',url);
				}
			});
			$('.datatab tr.first').nextAll().remove();
			$("#mpage").empty().append($pagedom);
			renderAList(res.datas.userAnswerList);
			renderClassList (res.datas.classes)
		}).fail(function(){});
	}

	function getclass(order,url){
		if(typeof url == "undefined") {
			url = '/troomv2/examv2/getExamSummaryAjax.html';
		}
		$.ajax({	
			url:url,
			method:'post',
			dataType:'json',
			data:{
				'eid':eid,
				'k':kcode,
				'classid':classids.join()
			}
		}).done(function(res){
			var classcheckbut = '';
			if(res.datas.efenxisummary.class){
		    	for(var i=0;i<res.datas.efenxisummary.class.length;i++){
		    		classcheckbut+='<a classid="'+res.datas.efenxisummary.class[i].classid+'">'+res.datas.efenxisummary.class[i].classname+'</a>';
		    	}
		    }
		    classcheckbut = '关联班级:  <a classid="'+classid+'" class="active">全部</a>'+ classcheckbut;
		    $('.classlist').empty().append(classcheckbut);
		    classlistonclick();
		    $('.onR img').hide()
			$('.mk_y_time').text(Math.ceil(res.datas.efenxisummary.avgusedtime/60) + '分钟');
			$('.mk_y_num').text(res.datas.efenxisummary.answercounts);
			if(res.datas.efenxisummary.answercounts >=res.datas.alluserscount){
				$('.mk_q_num').text(res.datas.efenxisummary.answercounts);
				if(res.datas.efenxisummary.answercounts == 0){
						var mk_j_num = '0%';
				}else{
						var mk_j_num = Math.round((res.datas.efenxisummary.answercounts/res.datas.efenxisummary.answercounts)*100)+'%';
				}	
			
			}else{
				$('.mk_q_num').text(res.datas.alluserscount);
				var mk_j_num =  Math.round((res.datas.efenxisummary.answercounts/res.datas.alluserscount)*100)+'%';
			}
			var mkNumb = Math.round(((parseFloat(mk_j_num))/10));
			$('.mk_j_num').text(mk_j_num);
			$('.jisret').text(res.datas.efenxisummary.esubject);
			$('.pusTime').text('布置时间：' +res.datas.efenxisummary.dateline)
			$('.limittime').text('计时：' + res.datas.efenxisummary.limittime + '分钟')
			$('.scorelab').text('总分 ：' + res.datas.efenxisummary.totalscore + '分')
			for(var i=0;i<=(mkNumb-1);i++){
		    	var onR = $('.onR img');
		    	$(onR[i]).show();
		   }
		    var  fenxiA = [];
		    for(var i=0;i<res.datas.efenxisummary.fenxi.length;i++){
		    	var fenxi = res.datas.efenxisummary.fenxi[i];
		    	switch(fenxi.quetype)
				{
				case 'A':
				  	fenxi.quetype = '单选题';
				break;
				case 'B':
					fenxi.quetype = '多选题';
				break;
				case 'C':
					fenxi.quetype = '填空题';
				break;
				case 'D':
					fenxi.quetype = '判断题';
				break;
				case 'E':
					fenxi.quetype = '文字题';
				break;
				case 'H':
					fenxi.quetype = '主观题';
				break;
				case 'Z':
					fenxi.quetype = '文本行';
				break;
				case 'G':
					fenxi.quetype = '音频';
				break;
				case 'X':
					fenxi.quetype = '答题卡';
				break;
				case 'XTL':
					fenxi.quetype = '听力题';
				break;
				case 'XWX':
					fenxi.quetype = '完形填空';
				break;
				case 'XYD':
					fenxi.quetype = '阅读理解';
				break;
				case 'XZH':
					fenxi.quetype = '组合题';
				break;
				}
				fenxiA.push([fenxi.quetype,fenxi.count]);
		    }
		    $('#container1').highcharts({
		        chart: {
		            type: 'pie',
		            options3d: {
		                enabled: true,
		                alpha: 45,
		                beta: 0
		            },
		            style : {
					    fontFamily:"",
					    fontSize:'12px',
					    fontWeight:'bold',
					    color:'#006cee'
					  }
		        },
		        title: {
		            text: ''
		        },
		        tooltip: {
		            pointFormat: '{point.percentage:.1f}%</b>'
		        },
		        credits:{
				     enabled:false // 禁用版权信息
				},
		        plotOptions: {
		            pie: {
		                allowPointSelect: true,
		                cursor: 'pointer',
		                depth: 18,
		                size : 190,
		                dataLabels: {
		                    enabled: true,
		                    format: '{point.name}'
		                }
		            }
		        },
		        series: [{
		            type: 'pie',
		            name: '',
		            data: fenxiA
		        }]
		    });
		    var valuel = $('.ui-tabs-nav li.workcurrent').attr('value')
			if(valuel == '1'){
				$('#viewcontent').empty();
				$('#container .right').remove();
				examobj.initExam()
				
			}
		}).fail(function(){});
	}
	function getExamSummaryAjax(order,url) {
		if(typeof url == "undefined") {
			url = '/troomv2/examv2/getExamSummaryAjax.html';
		}
		$.ajax({	
			url:url,
			method:'post',
			dataType:'json',
			data:{
				'eid':eid,
				'k':kcode,
				'classid':classid
			}
		}).done(function(res){
			$('.onR img').hide()
			$('.mk_y_time').text(Math.ceil(res.datas.efenxisummary.avgusedtime/60) + '分钟');
			$('.mk_y_num').text(res.datas.efenxisummary.answercounts);
			if(res.datas.efenxisummary.answercounts >=res.datas.alluserscount){
				$('.mk_q_num').text(res.datas.efenxisummary.answercounts);
				if(res.datas.efenxisummary.answercounts == 0){
						var mk_j_num = '0%';
				}else{
						var mk_j_num = Math.round((res.datas.efenxisummary.answercounts/res.datas.efenxisummary.answercounts)*100)+'%';
				}	
			
			}else{
				$('.mk_q_num').text(res.datas.alluserscount);
				var mk_j_num =  Math.round((res.datas.efenxisummary.answercounts/res.datas.alluserscount)*100)+'%';
			}
			var mkNumb = Math.round(((parseFloat(mk_j_num))/10));
			$('.mk_j_num').text(mk_j_num);
			$('.jisret').text(res.datas.efenxisummary.esubject);
			$('.pusTime').text('布置时间：' +res.datas.efenxisummary.dateline)
			$('.limittime').text('计时：' + res.datas.efenxisummary.limittime + '分钟')
			$('.scorelab').text('总分 ：' + res.datas.efenxisummary.totalscore + '分')
			for(var i=0;i<=(mkNumb-1);i++){
		    	var onR = $('.onR img');
		    	$(onR[i]).show();
		   }
		    var  fenxiA = [];
		    for(var i=0;i<res.datas.efenxisummary.fenxi.length;i++){
		    	var fenxi = res.datas.efenxisummary.fenxi[i];
		    	switch(fenxi.quetype)
				{
				case 'A':
				  	fenxi.quetype = '单选题';
				break;
				case 'B':
					fenxi.quetype = '多选题';
				break;
				case 'C':
					fenxi.quetype = '填空题';
				break;
				case 'D':
					fenxi.quetype = '判断题';
				break;
				case 'E':
					fenxi.quetype = '文字题';
				break;
				case 'H':
					fenxi.quetype = '主观题';
				break;
				case 'Z':
					fenxi.quetype = '文本行';
				break;
				case 'G':
					fenxi.quetype = '音频';
				break;
				case 'X':
					fenxi.quetype = '答题卡';
				break;
				case 'XTL':
					fenxi.quetype = '听力题';
				break;
				case 'XWX':
					fenxi.quetype = '完形填空';
				break;
				case 'XYD':
					fenxi.quetype = '阅读理解';
				break;
				case 'XZH':
					fenxi.quetype = '组合题';
				break;
				}
				fenxiA.push([fenxi.quetype,fenxi.count]);
		    }
		    $('#container1').highcharts({
		        chart: {
		            type: 'pie',
		            options3d: {
		                enabled: true,
		                alpha: 45,
		                beta: 0
		            },
		            style : {
					    fontFamily:"",
					    fontSize:'12px',
					    fontWeight:'bold',
					    color:'#006cee'
					  }
		        },
		        title: {
		            text: ''
		        },
		        tooltip: {
		            pointFormat: '{point.percentage:.1f}%</b>'
		        },
		        credits:{
				     enabled:false // 禁用版权信息
				},
		        plotOptions: {
		            pie: {
		                allowPointSelect: true,
		                cursor: 'pointer',
		                depth: 18,
		                size : 190,
		                dataLabels: {
		                    enabled: true,
		                    format: '{point.name}'
		                }
		            }
		        },
		        series: [{
		            type: 'pie',
		            name: '',
		            data: fenxiA
		        }]
		    });
		    var valuel = $('.ui-tabs-nav li.workcurrent').attr('value')
			if(valuel == '1'){
				$('#viewcontent').empty();
				$('#container .right').remove();
				examobj.initExam()
				
			}
		}).fail(function(){});
	}
	// ---------- 渲染select班级列表 ------------
		window.selectClassBloo = true
		function renderClassList (data) {
			var gardesList = $("#gardesList")
			if (window.selectClassBloo) {
				var con = ''
				for (var i in data) {
					var item = data[i]
					con += '<option value ="' + i + '">' + item + '</option>'
				}
				gardesList.append(con)
				window.selectClassBloo = false
			}
		}
	//渲染教师布置的作业
	function renderAList(userAnswerList){
		$('.datatab tbody tr.first').nextAll().remove();
		$('.nodata').remove();
		if( !userAnswerList||  userAnswerList.length <=0){
			var error = '<div class="nodata"></div>';
			$(".workdata").append(error);
		}else{
			for(var i = 0,len = userAnswerList.length;i<len;i++) {
				var userAnswer = userAnswerList[i];
				template.helper("substrinreal", function(a){
					if(a.length > 10){
						a = a.substring(0,8) + '...';
					}else{
						a =a;
					}
					return a;
				});
				template.helper("Mathceil", function(a){
					a =Math.ceil(a/60);
					return a;
				});
				var data = {
					'aid' : userAnswer.aid,
					'ansdateline' : getLocalTime(userAnswer.ansdateline),
					'anstotalscore' : userAnswer.anstotalscore,
					'correctrat' : userAnswer.correctrat,
					'status' : userAnswer.status,
					'uid' : userAnswer.uid,
					'usedtime' : userAnswer.usedtime,
					'sex' : userAnswer.sex,
					'realname' : userAnswer.realname,
					'username' : userAnswer.username,
					'face' : userAnswer.face,
					'eid': eid,
					'classname': userAnswer.classname || '----'
				}
				var $dom = $(template('t:answer',data));
				//$('.datatab tbody tr.first').nextAll().remove();
				$(".datatab tbody").append($dom);
			}			
		}

	}
    function deleteanswer(aid,eid,uid) {
        if(!confirm('删除后学生要重新提交作业,确定要删除吗？')){
            return false
        }
            var url = '<?= geturl('troomv2/classexam/deleteanswer') ?>';
            $.post(url,{'aid':aid,'eid':eid,'uid':uid},function(data){
                if(data==1){
                    $.showmessage({
                        img		 : 'success',
                        message  :  '删除成功',
                        title    :      '删除      成功',
                        timeoutspeed    :       500,
                        callback :    function(){
                            location.reload();
                        }
                    });
                }else{
                    $.showmessage({
                        img		 : 'error',
                        message  :  '删除失败',
                        title    :      '删除      失败',
                        timeoutspeed    :       500
                    });
                }
            });
        return false;

    };
	$(function(){
		getclass();
	    tab('.lishnrt a','xhusre');
	    $('.datatab tr:last td').css('border-bottom','none');
	    $(".ui-tabs-nav li").click(function(){
	        $(".ui-tabs-nav li").eq($(this).index()).addClass("workcurrent").siblings().removeClass('workcurrent');
			$(".ui-tabs-panel").hide().eq($(this).index()).show();
		})
		$('.completetime').on('click',function(){
			$(this).toggleClass('completetimebP');
			if($(this).hasClass('completetime')){	
				if($(this).hasClass('completetimebP')){
					getElist(3);
				}else{
					getElist(2);
				}
			}
		})
		$('.totalscore').on('click',function(){
			$(this).toggleClass('completetimebP');
			if($(this).hasClass('totalscore')){	
				if($(this).hasClass('completetimebP')){
					getElist(4);
				}else{
					getElist(1);
				}
			}
		})
	})
	// ---------------- 渲染班级列表和筛选 gardesList ------------------------
	$("#gardesList").change(function(event) {		
		classid = $(this).val()		
		getElist()
	});
</script>
<script src="http://static.ebanhui.com/ebh/js/swfobject.js<?=$v?>" ></script>
 <div id="flvwrap" style="display:none;">
     <div id="flvcontrol"></div>
 </div>
  <iframe name="iframe_data" style="display:none;"></iframe>
 <form id="download_form" name="download_form" target="iframe_data" method="POST"></form>
<!--------播放器代码------------>
<script  defer="defer">

var ver = 10;

function checkUpdate() {
	return true;
}

$(function(){
    $(".adderrorbook").live("mouseover", function(){
        $(this).addClass("adderrorbookb");
    });
    $(".adderrorbook").live("mouseout", function(){
        $(this).removeClass("adderrorbookb");
    });
});
</script>

<script src="http://static.ebanhui.com/exam/newjs/play.js<?=getv()?>"></script>
<!--------播放器代码------------>
<script>
	$(function(){
		window.flash = HTools.pFlash({
			'id':"piceditor",
			'uri':"http://static.ebanhui.com/exam/flash/couseEditor.swf",
			'vars':{'showsubmit':0}
		});
		var button = new xButton();
	// -------------  注册教师批阅按钮 -------------------			
		button.add({
            value: '全景图',
            callback: function () {
            	HTools.getFlash(flash.getId()).swf.togglePanorama();
               return false;
            },
            autofocus: true
		});	
		button.add({
            value: '原题',
            callback: function () {
				var quespanel = H.get('quespanel')
            	var param = quespanel.param
            	var node = quespanel.dialog.d.node
            	if(node) {
            		if (node.style.display == 'none') {
            			quespanel.exec('show');
            		} else {
            			quespanel.exec('close');
            		}            		
            	} else {
            		H.create(new P({
						title: param.title,
						id: param.id,
						width: param.width,
						content: param.content
					}),'common').exec('show');
            	}
                return false;
            },
            autofocus: true
		});
		button.add({
            value: '提交批阅',
            callback: function () {
               H.remove('quespanel');
               HTools.getFlash(flash.getId()).swf.uploadAnswer();
               return false;
            },
            autofocus: true
		});
		button.add({
            value: '取消',
            callback: function () {
            	H.remove('quespanel');
              	H.get('piceditor').exec('close');
               	return false;
            }
		});
	// -------------------- 注册教师批阅按钮 ----------------
		H.create(new P({
			'id':"piceditor",
			'title':'在线批阅',
			'flash':flash,
			'easy':true,
			'button':button
		},{'onclose':function(){
			H.remove('quespanel');
		}}),'common');
		$('.ui-dialog-button button[i-id=原题]').hide()
		setTimeout(function(){
			tremarkobj.fixWpos();
		},1000);
	});
	//  ---------------- 覆盖 common.js 中的方法 -----------------------
		window.pplay = function (path) {		
			if (path.indexOf('d') == 0) { // 判断是否显示原题
				$('.ui-dialog-button button[i-id=原题]').show()
			} else {
				$('.ui-dialog-button button[i-id=原题]').hide()
			}
			H.get('piceditor').exec('show');
			loadSource(path);
		}
		window.renderHtml = function (html) {
			html = '<div style="width:600px;min-height:100px;overflow-y:auto;">'+html+'</div>';
			H.create(new P({
				title:'原题',
				id:'quespanel',
				width:600,
				// showcancel: false,
				content:html
			}),'common').exec('close');
		}
	//  ---------------- 覆盖 common.js 中的方法 -----------------------
	function inpascore() {
		var ascore = 0
		var inpascore = $('.ascore');
		for(var i=0;i<inpascore.length;i++){
			ascore += parseInt($(inpascore[i]).val());
		}
		$('#Sgscore').val(ascore);
		$('.getscores').text(ascore + '分');
	}
	function getLocalTime(nS) {     
	    return new Date(parseInt(nS) * 1000).toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ");      
	}
	Number.prototype.toPercent = function(){
		return (Math.round(this * 10000)/100).toFixed(0) + '%';
	}   
	function inpfocus(inp){
		var inpf = $(inp);
		if(inpf.val() == '请输入学生姓名'){
			inpf.attr('value','');
		}
	}
	function tab(tobj,cls){
		$(tobj).each(function(){
		 	$(this).on('click',function(){
		 		$(tobj).removeClass(cls);
				$(this).addClass(cls);
				getElist();
		 	})
		 }) 
	}
	function classlistonclick(){
		getElist()
		$('.classlist a').each(function(){
			$(this).click(function(){
				$('.classlist a').removeClass('active');
				$(this).addClass('active');
				classid = $(this).attr('classid');
				getElist();
				getExamSummaryAjax();
			})
		})
	}
	
</script>
</body>
</html>
