<?php $this->display('troomv2/room_header'); ?>

<style>
#icategory {
    background: none repeat scroll 0 0 #F7FAFF;
    border-top: 1px solid #E1E7F5;
    padding: 6px 20px;
	_margin-bottom:-5px;
}
#icategory dt {
    float: left;
    line-height: 22px;
    padding-right: 5px;
    text-align: left;
}
#icategory dd {
    float: left;
    width: 645px;
}
.category_cont1 div a.curr, .price_cont div a:hover, .price_cont div a.curr {
	background: none repeat scroll 0 0 #FF5400;
	color: #FFFFFF;
	text-decoration: none;
}
.category_cont1 div a {
    color: #2C71AE;
    text-decoration: none;
    padding: 2px;
}
.category_cont1 div {
    float: left;
    height: 25px;
    line-height: 22px;
    overflow: hidden;
	padding:0 10px;
}
.key_word {
	padding: 6px 20px;
	border-bottom-width: 1px;
	border-bottom-style: solid;
	border-bottom-color: #cdcdcd;
}
.key_word dt {
    float: left;
    line-height: 22px;
    padding-right: 5px;
    text-align: left;
}
.pbtns {
    background: url(http://static.ebanhui.com/ebh/tpl/2012/images/sunt0518.png) repeat scroll 0 0 transparent;
    border: medium none;
    color: #333333;
    height: 20px;
    vertical-align: middle;
    width: 40px;
	cursor:pointer;
}
.lefrigs{
	margin:0 auto;
	margin-top:10px;
	width:1000px;
}
.diles{
	top:10px;
}
.datatab td{
	border-bottom: none;
}
</style>
<!--<div class="cmain_bottoms cmain_bottoms2 cmain_top_r " style="margin-bottom:5px;padding-bottom:0;">
<div class="esukangs">
<a class="subtop jiancha fl" target="mainFrame" href="/troomv2/tastulog.html" title="学生监察">学生监察</a>
 <a class="subtop tongji fl" target="mainFrame" href="#" title="教学统计">教学统计</a>
</div>
</div> -->
<div class="lefrigs"><div class="lefrig">

<?php 
$this->assign('data_index',1);
$this->display('troomv2/data_menu');
?>
<table class="datatab" width="100%" style="border:none;">
	<?php if(!empty($exams)  && $examPower != '1') { ?>
<thead class="tabhead">
<tr>
<th>作业名称</th>
<th>出题时间</th>
<th>答题时间</th>
<th>用时</th>
<th>得分/总分</th>
<th>答题人数</th>
<th>操作</th>
</tr>
</thead>
<tbody>
	
	<?php foreach($exams as $exam) { 
			//var_dump($exam);
			
		$stunum = 0;
		if($classid > 0 && isset($classlist[$classid]) )  {
			$stunum = $classlist[$classid]['stunum'];
		} else {
			$stunum = isset($classlist[$exam['classid']]) ? $classlist[$exam['classid']]['stunum'] : 0;
		}
		?>
		<tr>
			<td width="20%" title="<?= $exam['title'] ?>"><?= shortstr($exam['title'],44) ?></td>
			<td width="20%" style="text-align:center"><?= date("Y-m-d H:i",$exam['dateline']) ?></td>
			<td width="20%" style="text-align:center"><?= date("Y-m-d H:i",$exam['sdateline']) ?></td>
			<td width="10%" style="text-align:center"><?= ceil($exam['completetime']/60)?>分钟</td>
			<td width="10%" style="text-align:center"><?= sprintf("%.2f", $exam['totalscore']) ?>/<?=$exam['score']  ?></td>
			<td width="10%" style="text-align:center"><?= $exam['answercount'].'/'.$stunum ?></td>
			<td width="10%" style="text-align:center">
				<a style="color:#5e98fb;" title="查看详情" target="_blank;" href="http://exam.ebanhui.com/eview/<?= $exam['aid']?>.html"><span>查看详情</span></a>
			</td>
		</tr>
		<?php } ?>
	<?php } else if($examPower == '1') { ?>
		<thead class="tabhead">
			<tr>
			<th>作业名称</th>
			<th>出题时间</th>
			<th>答题时间</th>
			<th>用时</th>
			<th>得分/总分</th>
			<th>答题人数</th>
			<th>操作</th>
			</tr>
			</thead>
			<tbody></tbody>
	<?php } else { ?>
		
		<tr><div class="weusaz"><img style="float:left;" src="http://static.ebanhui.com/ebh/tpl/troomv2/images/wureazar.jpg" /><span class="lisretdfe">暂无作业记录...</span></div></tr>
	<?php } ?>
		
</tbody>
</table>
		<?php if($examPower != '1') {?>
        <?= $pagestr ?>
        <?php } ?>
    <div id="mpage">
    	
    </div>
</div>
</div>

<script type="text/javascript">
var tip = '请输入作业名称';
var uid =  "<?=$uid?>";
var exampower = "<?=$examPower?>";

$(function(){
	initsearch('search',tip);
	$('#searchbutton').click(function(){
		if($("#search").val()=='请输入作业名称'){
			var searchvalue = '';
		}else{
			var searchvalue = $("#search").val();
		}
		if(searchvalue=='请输入作业名称'){
			searchvalue='';
		}
		if(exampower != '1'){
			var href = '<?= geturl('troomv2/statisticanalysis/scorefind/'.$uid)?>?q='+searchvalue;
			location.href = href ;
		}else{
			getstulist()
		}
		
	});
	
	function getstulist(url){
		if(typeof url == "undefined") {
			url = '/troomv2/examv2/getStuExamsAjax.html';
		}
		var title = $("#search").val();			
		if(title == tip){
			title = "";
			
		}
		$.ajax({
			url:url,
			method:'post',
			dataType:'json',
			data : {
				uid : uid,
				q : title || ''
			},
			beforeSend:function(XMLHttpRequest){
         	 var loading = '<div style="text-align:center;width:100%;"><img style="width:32px;margin:0 482px;" src="http://static.ebanhui.com/exam/images/loading-2.gif"></div>';
         	 $('.tabhead tbody').empty().append(loading);
    	 }
		}).done(function(res){
			$('.datatab tbody,#mpage').empty();
			if(res.errCode == '1111'){
				var cmain_bottom = '<div class="weusaz"><img style="float:left;" src="http://static.ebanhui.com/ebh/tpl/troomv2/images/wureazar.jpg" /><span class="lisretdfe">暂无作业记录...</span></div>';
	        	$("#mpage").append(cmain_bottom);
			}else{
				var $pagedom = $(res.datas.pagestr);
				$pagedom.find('.listPage a').bind('click',function(){
					var url = $(this).attr('data');
					var estype = $('.curr').attr('data');
					if(!!url) {
						getstulist(url);
					}
				});
				$("#mpage").append($pagedom);
				var examList =  res.datas.examList;
				for(var i=0;i<examList.length;i++){
					if(examList[i].exam.esubject.length>30){
					    var  sesubject = examList[i].exam.esubject.substring(0,30)+"...";
					}else{
						var  sesubject = examList[i].exam.esubject;
					}
					var	htmllist = '<tr>'
						+	'<td width="20%"  title="'+examList[i].exam.esubject+'">'+sesubject+'</td>'
						+	'<td width="20%" style="text-align:center">'+new Date(parseInt(examList[i].exam.dateline)* 1000).format("yyyy-MM-dd hh:mm:ss")+'</td>' 
						+	'<td width="20%" style="text-align:center">'+new Date(parseInt(examList[i].userAnswer.ansdateline)* 1000).format("yyyy-MM-dd hh:mm:ss")+'</td>'
						+	'<td width="10%" style="text-align:center">'+(Math.ceil(examList[i].userAnswer.usedtime/60) || 0)+'分钟</td>'
						+	'<td width="10%" style="text-align:center">'+examList[i].userAnswer.anstotalscore+'/'+examList[i].exam.examtotalscore+'</td>'
						+	'<td width="10%" style="text-align:center">'+examList[i].exam.answercount+'/'+(examList[i].exam.count?examList[i].exam.count:examList[i].exam.answercount)+'</td>'
						+	'<td width="10%" style="text-align:center">'
						+		'<a style="color:#5e98fb;" title="查看详情" target="_blank;" href="/troomv2/examv2/eview/'+examList[i].userAnswer.aid+'.html?eid='+examList[i].exam.eid+'"><span>查看详情</span></a>'
						+	'</td>'
						+'</tr>'
						$(".datatab tbody").append(htmllist);
				}
			}
			
		}).fail(function(){
			console.log('req err');
		});
	}
	
	$('.datatab tr:last td').css('border-bottom','none');
	if(exampower == '1'){
		getstulist()
	}
Date.prototype.format = function(format) 
	{ 
		var o = 
		{ 
		"M+" : this.getMonth()+1, //month 
		"d+" : this.getDate(), //day 
		"h+" : this.getHours(), //hour 
		"m+" : this.getMinutes(), //minute 
		"s+" : this.getSeconds(), //second 
		"q+" : Math.floor((this.getMonth()+3)/3), //quarter 
		"S" : this.getMilliseconds() //millisecond 
		}
		
		if(/(y+)/.test(format)){ 
			format = format.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length)); 
		}
		
		for(var k in o){ 
			if(new RegExp("("+ k +")").test(format)){ 
				format = format.replace(RegExp.$1, RegExp.$1.length==1 ? o[k] : ("00"+ o[k]).substr((""+ o[k]).length)); 
			} 
		} 
		return format; 
	} 
});
</script>

<?php $this->display('troomv2/page_footer'); ?>