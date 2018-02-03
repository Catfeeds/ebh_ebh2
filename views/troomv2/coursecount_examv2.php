<?php $this->display('troomv2/page_header')?>
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts.js?v=0514"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/js/template/template-native-debug.js"></script>
<style>
	.kejianzs{
		width: 600px;
		
	}
	.examnumber{
		width: 260px;
		padding: 0px 0px 0px 40px;
    	float: left;
	}
	#totalexam{
		width: 600px;
    	float: left;
	}
	.zshykjs {
		width:240px;
		overflow:hidden;
		text-overflow:ellipsis;
		white-space:nowrap;
	}
</style>
<div class="lefrig" style="padding-bottom:120px;">
	
	<?php $this->assign('index',8);
	$this->display('troomv2/course_menu');
	$this->assign('currentindex',1);
	$this->display('troomv2/coursecount_menu');?>
    <div class="clear"></div>
    <div class="examnumber">
    	<div class="ljzsbt">布置的作业总数：<span class="span1s" id="examnum">份</span></div>
    </div>
    <div id="totalexam">
    </div>
    
    <div class="qzsjlb" style="padding-left:40px;">
		<div class="zhqks mt55">
            <div>
                <div class="nnbl fl">作业统计折线图</div>
                <div class="ziswtzy fl">
                	
                </div>
            </div>
            <div class="clear"></div>
			<div class="ml20 mt30" id="chartcontainer" style="width:800px;height:400px"></div>
        </div>
	</div>
</body>
<script type="text/html" id="total">
	<div class="kejianzs">
        <div class="pjdefl">平均得分率&nbsp;<%=maxscoreRat%>%</div>
        <div class="ljzsbt zshykj zsllkj1s">
        	<span class="span1s fl">平均得分率最高的作业：</span>
            <a target="_blank" href="/troomv2/examv2/edit/<%=max.maxeid%>.html" class="zshykjs fl" title="<%=maxesubject%>"><%=maxesubject%></a>
        </div>
    </div>
    <div class="clear"></div>
    <div class="kejianzs">
    	<div class="pjdefl">平均得分率&nbsp;<%=minscoreRat%>%</div>
        <div class="ljzsbt zsllkj zsllkj1s">
        	<span class="span1s fl">平均得分率最低的作业：</span>
            <a target="_blank" href="/troomv2/examv2/edit/<%=min.mineid%>.html" class="zshykjs fl" title="<%=minesubject%>"><%=minesubject%></a>
        </div>
    </div>
    <div class="clear"></div>
</script>
<script>
var folderid = <?=$folderid?>;
$(function(){
	getanalysis();
	getavgscorerat();
})
	function getanalysis(){ //平均得分最高最低的作业
		$.ajax({
			type:"post",
			url:"/troomv2/examv2/analysis.html",
			async:true,
			'data':{'folderid':folderid},
			'success':function(res){
					var res = $.parseJSON(res);
					var maxesubject = res.datas.max;
					var minesubject = res.datas.min;
					if(maxesubject && minesubject){
						if(maxesubject.maxesubject.length>30){
						    var  maxesubjects = maxesubject.maxesubject.substring(0,30)+"...";
						    var  minesubjects = minesubject.minesubject.substring(0,30)+"...";
						}else{
							var  maxesubjects = maxesubject.maxesubject || '';
							var  minesubjects = minesubject.minesubject || '';
						}
						var maxmin = {
							maxscoreRat : Math.round(maxesubject.maxscoreRat*100),
							minscoreRat : Math.round(minesubject.minscoreRat*100),
							max :  maxesubject,
							maxesubject : maxesubjects,
							minesubject : minesubjects,
							min :  minesubject
						}
						var $dom = $(template('total',maxmin));
						$('#totalexam').empty().append($dom);
					}
			}
		});
	}
	function getavgscorerat(page){
		$.ajax({
			type:"post",
			url:"/troomv2/examv2/avgscorerat.html",
			async:true,
			'data':{
				'folderid':folderid,
				'page': page ||''
			},
			'success':function(res){
				var res = $.parseJSON(res);
				var examList = res.datas.examList;
				var pageInfo = res.datas.pageInfo;
				$('#examnum').text(pageInfo.totalElement+'份'); //布置的作业总数
				
				// 分页
				var pagehtml = '';
				if(pageInfo.number > 1){
					var prevsize =parseInt(pageInfo.number) - 1;
					pagehtml+='<div class="ziswtzyl fl pg1" style="cursor:pointer;" onclick="getavgscorerat('+prevsize+')" ><img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/dqswfzstl.png"/></div>';
				}else{
					pagehtml+='<div class="ziswtzyl fl pg1" ><img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/dqsyfzstr3.png"/></div>';
				}; 
				if(pageInfo.size > pageInfo.totalElement){
					pagehtml += '<div class="ziswtzyc fl"><span>当前<span id="examc">'+pageInfo.totalElement +'</span>份作业走势图</span></div>';
				}else{
					pagehtml += '<div class="ziswtzyc fl"><span>当前<span id="examc">'+pageInfo.size +'</span>份作业走势图</span></div>';
				}
				
				
				if(pageInfo.number < pageInfo.totalPages){
					var nextsize = parseInt(pageInfo.number) + 1;
					 pagehtml+='<div class="ziswtzyr fl pg2" style="cursor:pointer;" onclick="getavgscorerat('+nextsize+')" ><img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/dqsyfzstr2.png"/></div>'	
				}else{
					pagehtml+='<div class="ziswtzyr fl pg2" ><img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/dqsyfzstr.png"/></div>'
				};
				$('.ziswtzy').empty().append(pagehtml);
				
				
				//作业统计折线图 
				var titleArr = [];
				var percentArr = [];
				for(var i=0;i<examList.length;i++){
					if(examList[i].avgscoreRat == 'NaN'){
						var avgscoreRat =  0;
					}else{
						var avgscoreRat =  Math.ceil(examList[i].avgscoreRat *100);
					}
					var esubject = examList[i].esubject;
					titleArr.push(esubject)
					percentArr.push(avgscoreRat)
				}
				$('#chartcontainer').highcharts({
					title: {
						text:''
					},
					
					xAxis: {
						title:{
							text:''
						},
						categories: titleArr,
						labels: {
							enabled: false
						}
					},
					yAxis: {
						min:0,
						max:110,
						title: {
							text: '<br>作<br>业<br>得<br>分<br>率<br>%',
							rotation:0,
							align:'high',
							margin:20,
							style: {
								fontFamily:"Microsoft YaHei",
								fontSize:'13px'
							}
						}
						
					},
					credits: {
						text: ''
					},
					tooltip: {
						valueSuffix: '%'
					},
					series: [{
						name: '得分率',
						data: percentArr
					}]
				});
			}
		});
	}
</script>
</html>
