<?php $this->display('troomv2/room_header');?>
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
</style>
<!--<div class="cmain_bottoms cmain_bottoms2 cmain_top_r " style="margin-bottom:5px;padding-bottom:0;">
<div class="esukangs">
<a class="subtop jiancha fl" target="mainFrame" href="/troomv2/tastulog.html" title="学生监察">学生监察</a>
<a class="subtop tongji fl" target="mainFrame" href="#" title="教学统计">教学统计</a> 
</div>
</div> -->
<div class="lefrigs"><div class="lefrig">
<?php 
$this->assign('data_index',3);
$this->display('troomv2/data_menu');
?>

<table class="datatab" width="100%" style="border:none;">
	
	<?php if(!empty($logs)) { ?>
<thead class="tabhead">
<tr>
<th>课件名称</th>
<th>学生姓名</th>
<th>课件时长</th>
<th>学习持续时间</th>
<th>首次学习时间</th>
<th>末次学习时间</th>
</tr>
</thead>
<tbody>
		
		<?php foreach($logs as $mylog) { ?>
		<tr>
			<td width="28%"><?= $mylog['title'] ?></td>
			<td width="10%" style="text-align:center"><?= empty($mylog['realname'])?$mylog['username']:$mylog['realname'] ?></td>
			<td width="10%" style="text-align:center"><?= $this->getltimestr($mylog['ctime']) ?></td>
			<td width="12%" style="text-align:center"><?= $this->getltimestr($mylog['ltime']) ?></td>
			<td width="20%" style="text-align:center"><?= date('Y-m-d H:i:s',$mylog['startdate']) ?></td>
			<td width="20%" style="text-align:center"><?= date('Y-m-d H:i:s',$mylog['lastdate']) ?></td>
		</tr>
		<?php } ?>
		
	<?php } else { ?>
		<tr><div class="weusaz"><img style="float:left;" src="http://static.ebanhui.com/ebh/tpl/troomv2/images/wureazar.jpg" /><span class="lisretdfe">暂无学习记录...</span></div></tr>
	<?php } ?>
</tbody>
</table>
        <?php echo $pagestr?>
</div>
</div>
</body>
</html>
<script type="text/javascript">
var tip='请输入课件名称或姓名';
$(function(){
	initsearch('search',tip);
	$('#searchbutton').click(function(){
		var href = '<?= geturl('troomv2/statisticanalysis/studylogs/'.$uid) ?>';
		if($("#search").val()=='请输入课件名称或姓名'){
			var searchvalue = '';
		}else{
			var searchvalue = $("#search").val();
		}
		if(searchvalue=='请输入课件名称'){
			searchvalue='';
		}

		location.href = href+"?q="+searchvalue;
	});

});
$(function(){
		$('.datatab tr:last td').css('border-bottom','none');
	});
</script>
