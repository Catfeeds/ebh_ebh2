<?php $this->display('aroom/page_header')?>

<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
<style>
.datatab td {
    border-bottom: 1px solid #efefef;
    border-top: 1px solid #efefef;
    color: #666666;
    padding: 10px 6px;
}
</style>
	<div class="ter_tit">
		当前位置 > <a href="<?=geturl('aroom/astulog')?>">学生听课监察</a> > 听课监察
		<div class="diles">
	<input name="title" class="newsou" id="search" <?php if(!empty($search)){?>value="<?=str_replace("''","'",$search)?>" style="color:#000"<?php }else{?>value="输入关键字搜索"<?php }?>  onblur="if($('#search').val()==''){$('#search').val('输入关键字搜索').css('color','#CBCBCB');}" onfocus="if($('#search').val()=='输入关键字搜索'){$('#search').val('').css('color','#000');}" />
	<input type="button" class="soulico" value="" id="searchbutton">
</div>
		</div>
	<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:788px;">
	<div class="annuato" style="line-height:28px;padding-left:20px;position: relative;">该学生共学习课件&nbsp;<span style="color:blue;font-weight:bold;"><?=$logcount?></span>&nbsp;个
<a href="<?=geturl('aroom/astulog')?>" class="tfanhui" style="left: 640px;_top:13px;position: absolute;width:90px;">返回上一页</a>
</div>
<table class="datatab" width="100%" style="border:none;">
<thead class="tabhead">
<tr>
<th>课件名称</th>
<th>课件时长</th>
<th>学习持续时间</th>
<th>首次学习时间</th>
<th>末次学习时间</th>
</tr>
</thead>
<tbody>
	<?php if(!empty($loglist)){
		foreach($loglist as $ll){
	?>
		<tr>
			<td width="30%"><?=$ll['title']?></td>
			<td width="15%"><?=$ll['ctime']?></td>
			<td width="15%"><?=$ll['ltime']?></td>
			<td width="20%"><?=Date('Y-m-d H:i:s',$ll['startdate'])?></td>
			<td width="20%"><?=Date('Y-m-d H:i:s',$ll['lastdate'])?></td>
		</tr>
	<?php }}else{?>
		<tr><td colspan="5" align="center">暂无记录</td></tr>
	<?php }?>
</tbody>
</table>
</div>
<script type="text/javascript">


$(function(){
	$('#searchbutton').click(function(){
		var href = '<?=geturl('aroom/astulog/astuloglist-0-0-0-'.$uid.'-searchvalue')?>';

		if($("#search").val()=='输入关键字搜索'){
			var searchvalue = '';
		}else{
			var searchvalue = $("#search").val();
		}
//		if(searchvalue=='输入关键字搜索'){
//			searchvalue='';
//		}
		searchvalue = replaceAll(searchvalue,'-',' ');
		searchvalue = replaceAll(searchvalue,"/",' ');
		searchvalue = replaceAll(searchvalue,'\\',' ');
		searchvalue = replaceAll(searchvalue,'"',' ');
		href=href.replace('searchvalue',encodeURIComponent(searchvalue));
		location.href = href;
	});

});

function replaceAll(str,find,rp){
	while(true){
		if(str.indexOf(find) == -1){
			break;
		}
		str = str.replace(find,rp);
	}
	return str;
}

</script>
<?php $this->display('aroom/page_footer')?>