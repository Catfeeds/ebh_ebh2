<?php $this->display('aroom/page_header')?>

<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/tzds.css" rel="stylesheet" />

<div class="ter_tit">
		当前位置 > 调查问卷
		</div>
	<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:788px;">
	<div class="annuato" style="line-height:28px;padding-left:20px;position: relative;">
		<div class="tiezitool"><a class="excelbtn" href = "/aroom/survey/add.html">添加问卷</a></div>
	</div>


<table class="datatab" width="100%" style="border:none">
<thead class="tabhead">
<tr>
<th>名称</th>
<th>关联到</th>
<th>时间</th>
<th>操作</th>
</tr>
</thead>
<tbody>
<?php if(!empty($surveylist)){
		foreach($surveylist as $survey){?>
		<tr>
		<td width="260px"><?=$survey['title']?></td>
		<td width="170px"><?=$survey['cwname']?></td>
		<td width="130px"><?=Date('Y-m-d H:i:s',$survey['dateline'])?></td>
		<td width="150px" ><a class="liuibtn" href="/aroom/survey/edit.html?sid=<?=$survey['sid']?>">编辑</a> <a class="liuibtn" onclick="dels(<?=$survey['sid']?>)">删除</a>
		<a class="liuibtn" href="/aroom/survey/stat.html?sid=<?=$survey['sid']?>">统计</a>
		</td>
		</tr>
	
		<?php }
}?>
</tbody>
</table>
</div>
<script>
function dels(sid){
	$.confirm("您确定要删除该问卷吗?",function(){
		$.ajax({
			type:'post',
			url:'/aroom/survey/delete.html',
			data:{'sid':sid},
			success:function(data){
				if(data==1)
					location.reload(true);
				else
					alert();
			}
		});
	});
}
</script>
<?php $this->display('aroom/page_footer')?>
