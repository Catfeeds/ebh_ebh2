<?php $this->display('troomv2/page_header')?>
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts.js?v=0514"></script>
<style>
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
	<div class="kejianzs mt20">
    	<div class="ljzsbt">布置的作业总数：<span class="span1s"><?=empty($examcount)?0:$examcount?>份</span></div>
        <div class="pjdefl">平均得分率&nbsp;<?=$percentarr[$maxeid]['percent']?>%</div>
        <div class="ljzsbt zshykj zsllkj1s">
        	<span class="span1s fl">平均得分率最高的作业：</span>
            <a target="_blank" href="http://exam.ebanhui.com/eedit/<?=$roominfo['crid']?>/<?=$maxeid?>.html" class="zshykjs fl"><?=shortstr($percentarr[$maxeid]['title'],30)?></a>
        </div>
    </div>
    <div class="clear"></div>
    <div class="kejianzs">
    	<div class="pjdefl">平均得分率&nbsp;<?=$percentarr[$mineid]['percent']?>%</div>
        <div class="ljzsbt zsllkj zsllkj1s">
        	<span class="span1s fl">平均得分率最低的作业：</span>
            <a target="_blank" href="http://exam.ebanhui.com/eedit/<?=$roominfo['crid']?>/<?=$mineid?>.html" class="zshykjs "><?=shortstr($percentarr[$mineid]['title'],30)?></a>
        </div>
    </div>
    <div class="clear"></div>
    <div class="qzsjlb" style="padding-left:40px;">
		<div class="zhqks mt55">
            <div>
                <div class="nnbl fl">作业统计折线图</div>
                <div class="ziswtzy fl">
                	<div class="ziswtzyl fl pg1" onclick="page(1)"><img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/dqswfzstl.png"/></div>
                    <div class="ziswtzyc fl"><span>当前<span id="examc"></span>份作业走势图</span></div>
                    <div class="ziswtzyr fl pg2" onclick="page(2)"><img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/dqsyfzstr.png"/></div>
                </div>
            </div>
            <div class="clear"></div>
			<div class="ml20 mt30" id="chartcontainer" style="width:800px;height:400px"></div>
        </div>
	</div>
</body>
<script>

var currentpage = 0;
$(function(){
	// examlist(1);
	page(1);

})
	var pages = <?=ceil($examcount/15)?>;
	function page(index){
		if(index==1)
			currentpage++;
		else
			currentpage--;
		
		if(currentpage==0){
			currentpage = 1;
			return;
		}else if(currentpage>pages && pages!=0){
			currentpage = pages;
			return;
		}else if(pages==0){
			currentpage = 1;
			pages=1;
			
		}
		
		
		if(currentpage == 1){
			$('.pg2 img').attr('src','http://static.ebanhui.com/ebh/tpl/troomv2/images/dqsyfzstr.png');
		}else{
			$('.pg2 img').attr('src','http://static.ebanhui.com/ebh/tpl/troomv2/images/dqsyfzstr2.png');
		}
		if(currentpage == pages){
			$('.pg1 img').attr('src','http://static.ebanhui.com/ebh/tpl/troomv2/images/dqsyfzstr3.png');
		}else{
			$('.pg1 img').attr('src','http://static.ebanhui.com/ebh/tpl/troomv2/images/dqswfzstl.png');
		}
		
		examlist(currentpage);
		
	}
	function examlist(page){
		var page = page;
		
		$.ajax({
			'url':'/troomv2/classsubject/coursecount/exam.html?folderid=<?=$folderid?>',
			'data':{'page':page},
			'success':function(data){
				var data = eval("("+data+")");
				
				var titleArr = new Array();
				var percentArr = new Array();
				var percentstr = '';
				var objlength = 0;
				if(data.percentarr){
					$.each(data.percentarr,function(k,v){
						titleArr.push(v.title);
						percentArr.push(v.percent);
						objlength ++;
					});
				}
				
				$('#examc').html(objlength);
				// console.log(Object.keys(data.percentarr).length);
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
		})
	}
</script>
</html>
