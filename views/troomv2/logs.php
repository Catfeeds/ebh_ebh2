<?php $this->display('troomv2/page_header');?>
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
	color:#333;
	height:25px;
	padding-top:20px;
	border-bottom:1px solid #fff;
}
</style>
<div class="lefrig">
	<h1 class="tkfktitle">三角函数与解三角形三角函数与解三角形（二 )</h1>
	<div class="classboxmore" style="border-bottom:none; height:160px;">
		<div class="touxiangxmfa">
			<div class="touxiangxm">
				<img class="images" src="http://img.ebanhui.com/avatar/2015/12/23/1450852000_50_50.jpg">
				<span class=""><?= empty($course['realname'])?$course['username']:$course['realname'] ?></span>
			</div>
			<div>
			<p class="lsfbsj"><span class="fbsj fbsj1s">上传时间：2016-01-28 13:56</span><span class="fbsj"> <span class="fbsj2"></span><?= $course['viewnum']?></span><span class="fbsj">时长:36分钟</span></p>
			<div style="clear:both;"></div>
			<p class="kkjssj">开课：2016-01-28 13:56 &nbsp;&nbsp; 结束：2018-01-28 14:56</p>
			</div>
		</div>
		<div style="clear:both;"></div>
		<div class="yixuexifa">
			<p class="sexqueue0" style="margin-left:130px;margin-right:15px;">
				<span class="sexqueuefull0" style="width:20%;"></span>
			</p>
			<div style="float:left; display:inline;">
				<p class="yixuexi">已学20/100</p>
				<p class="yjxxbfb">20%</p>
			</div>
			<div class="pjxxsc">
				<p class="yixuexi">平均学习时长</p>
				<p class="yjxxbfb">38<span style="font-size:14px;">分钟</span></p>
			</div>
		</div>
	</div>	
	<div  style="clear:both;"></div>
	<div class="waitite1s">
		<div class="work_mes" >
			<ul style="width:555px; float:left">
				<li class="workcurrent"><a href="javascript:;">全部</a></li>
				<li class=""><a href="javascript:;">已学习</a></li>
				<li class=""><a href="javascript:;">未学习</a></li>
			</ul>
			<a class="mulubgbtns" href="javascript:;" style="margin-top:6px;">刷新</a>
			<a class="mulubgbtns" href="javascript:;" style="margin-top:6px;">导出</a>
		</div>
		<div class="diles">
				<?php
					$q= empty($q)?'':$q;
					if(!empty($q)){
						$stylestr = 'style="color:#000"';
					}else{
						$stylestr = "";
					}
				?>
			<input name="search" <?=$stylestr?> class="newsou" id="search" value="<?= $q ?>" type="text" />
			<input id="searchbutton" name="searchbutton" type="button" class="soulico" value="">
		</div>
	</div>
		

<table class="datatab" width="100%" style="border:none;">
<thead class="tabhead">
<tr>

<th style="text-align:left;padding-left:60px;">个人信息</th>
<th>首次学习</th>
<th>最后学习</th>
<th>学习次数<img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/xjico.png" style="padding-left:3px;"/></th>
<th>单次时长<img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/ssico.png" style="padding-left:3px;"/></th>
<th>累计时长<img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/ssico.png" style="padding-left:3px;"/></th>
</tr>
</thead>
<tbody>
	
	<?php if(!empty($logs)) { ?>
		
		<?php foreach($logs as $mylog) { ?>
		<!--<tr>
			<td width="28%"><?= $mylog['title'] ?></td>
			<td width="10%"><?= empty($mylog['realname'])?$mylog['username']:$mylog['realname'] ?></td>
			<td width="10%"><?= $this->getltimestr($mylog['ctime']) ?></td>
			<td width="12%"><?= $this->getltimestr($mylog['ltime']) ?></td>
			<td width="20%"><?= date('Y-m-d H:i:s',$mylog['startdate']) ?></td>
			<td width="20%"><?= date('Y-m-d H:i:s',$mylog['lastdate']) ?></td>
		</tr>-->
		<tr>
			<td width="28%">
				<div style="float:left;margin-right:15px;">
					<a href="javascript:;"><img src="http://img.ebanhui.com/avatar/2015/12/23/1450852000_50_50.jpg" title="我是超超级管理员" style="width:40px;height:40px; border-radius:20px;"></a>
				</div>
				<div style="width:180px;float:left;">
					<span class="renming">我是超超级管理员</span>
					<span class="xingbie1"></span>
					<div style="clear:both;"></div>
					<span class="renming1">xiaoxue</span>
				</div>
			</td>
			<td width="15%"><?= date('Y-m-d H:i:s',$mylog['startdate']) ?></td>
			<td width="15%"><?= date('Y-m-d H:i:s',$mylog['lastdate']) ?></td>
			<td width="14%" style="text-align:center;">20</td>
			<td width="14%" style="text-align:center;">20分钟</td>
			<td width="14%" style="text-align:center;">200分钟</td>
		</tr>
		<?php } ?>
		
	<?php } else { ?>
		<tr><td colspan="6" align="center">暂无记录</td></tr>
	<?php } ?>
</tbody>
</table>
</div>
<?=$pagestr?>
</body>
</html>
<script type="text/javascript">
var tip='请输入课件名称';
$(function(){
	initsearch('search',tip);
	$('#searchbutton').click(function(){
		var href = '<?= geturl('troomv2/statisticanalysis/logs-0-0-0-'.$classid) ?>';
		if($("#search").val()=='请输入课件名称'){
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

</script>
