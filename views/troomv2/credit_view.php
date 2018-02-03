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
.tabhead th{
	border-bottom:1px solid #eee;
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
<!-- <div class="cmain_bottoms cmain_bottoms2 cmain_top_r " style="margin-bottom:5px;padding-bottom:0;">
<div class="esukangs">
<a class="subtop jiancha fl" target="mainFrame" href="/troomv2/tastulog.html" title="学生监察">学生监察</a>
<a class="subtop tongji fl" target="mainFrame" href="#" title="教学统计">教学统计</a> 
</div>
</div>-->
<div class="lefrigs"><div class="lefrig">
<?php 
$this->assign('data_index',4);
$this->display('troomv2/data_menu');
?>

<table class="datatab" width="100%" style="border:none;">
	<?php if(!empty($creditlist)) { ?>
<thead class="tabhead">
<tr>
	<th style="text-align:left" width="20%">日期</th>
	<th style="text-align:left"width="15%" >积分</th>
	<th style="text-align:left" width="65%">积分说明</th>
</tr>
</thead>
<tbody>
	<?php
	foreach($creditlist as $cl){
	$description = str_replace('[w]','<span style="color:blue">'.$cl['detail'].'</span>',$cl['description']);
	?>
	<tbody class="tabcont">
	
	  <tr >
		<td style="height: 35px;"><?=Date('Y-m-d H:i:s',$cl['dateline'])?></td>
		<?php if($cl['action']=='+'){?>
				<td style="height: 35px;color: green;padding-left: 10px;">
				+<?=$cl['credit']?>
				</td>
		<?php }else{?>
				<td style="height: 35px;color: red;padding-left: 10px;">
				-<?=$cl['credit']?>
				</td>
		<?php }?>
		<td style="height: 35px;"><?=$description.' '.$cl['credit'].' 积分'?></td>
	  </tr>
	</tbody>
	<?php }?>

	<?php } else { ?>
		<tr><div class="weusaz">
		<img style="float:left;" src="http://static.ebanhui.com/ebh/tpl/troomv2/images/wureazar.jpg" />
		<span class="lisretdfe">暂无积分明细...</span>
		</div></tr>
	<?php } ?>
</tbody>
</table>
	<?= $pagestr?>
</div>
</div>
<script type="text/javascript">
$(function(){
		$('.datatab tr:last td').css('border-bottom','none');
	});
</script>
</body>
</html>