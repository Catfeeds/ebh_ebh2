<?php $this->display('admin/header');?>
<style>
.pagination-info{
	float:left;
	padding-left:50px;
}
.itspan{
	padding-left:200px;
}
.itspan a{
	font-size:26px;
	font-weigth:bold;
	width:30px;
	text-decoration:none;
}
.ittable{
	margin-top:20px;
}
.ithr {
	border:1px solid #ccc;
}
.ithr li{
	list-style-type:none;
}
.itemnum{
	margin-left:10px;
	margin-right:10px;
	width:50px;
}
.btnbg{
	background:#ccc;
}
.trbg{
	background:#63B8FF;
}
.edittrbg{
	background:#EE82EE;
}
</style>
<body id="main">
<table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1>量表管理</h1></td>
		<td class="actions">
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tr>
			<td  class="active"><a href="javascript:;">所有评语</a></td>
			<td ><a href="/admin/refer/add.html?eid=<?=$eid?>" class="add">添加评语</a></td>
			</tr>
			</table>
		</td>
	</tr>
</table>
		
    <div id="toolbar">
	<table cellspacing="0" cellpadding="0" class="toptable">
		<tr>
		<td>
		<label>请先选择要所属量表: </label>
		<select name="eid" onchange="selfunc()">
		<option value="0">请选择量表</option>
		<?php if($evaluates){foreach($evaluates as $eval){?>
		<option value="<?=$eval['eid']?>"
	
		 <?=($eval['eid']==$row['eid'])?"selected='selcted'":""?> ><?=$eval['title']?></option>
		<?php }}?>
		</select>
		<span style="color:red"> *</span>
		<span class="l-btn-empty pagination-load" onclick="location.reload()" style="display: inline-block;margin: 0;padding: 0;width: 16px;cursor:pointer">&nbsp;</span>
		</td>
		</tr>
	</table>
	</div>
	<?php if(!empty($row)){?>
    <table  cellspacing="0" cellpadding="0" style="width:80%;margin-left:10px"   class="listtable">
		<tbody class="reviewtbody">
			<tr>
			<th width="6%">选择</th>
			<th>分值区间</th>
			<th>关键字</th>
			<th>计分题号</th>
			<th>评语建议</th>
			<th width="10%">操作</th>
			</tr>
			<?php $k=1;foreach($refers as $refer){?>
			<tr>
			<td><input type="checkbox" value="<?=$refer['rid']?>" /><?=$k?></td>
			<td><?=$refer['startscore']?> ~ <?=$refer['endscore']?></td>
			<td><?=$refer['keystr']?></td>
			<td><?=$refer['keyitemstr']?></td>
			<td><?=$refer['remarks']?></td>
			<td>
			[<a href="/admin/refer/edit.html?rid=<?=$refer['rid']?>&eid=<?=$refer['eid']?>" >修改</a>] 
			[<a href="javascript:;" onclick="del('<?=$refer['rid']?>')">删除</a>]
			</td>
			</tr>
			<?php $k++;}?>
		</tbody>
	</table>	
	<?php }else{?>
	<span style="margin-left:100px;color:red;">请先选择所属量表!</span>
	<?php }?>


<script type="text/javascript">
function selfunc(){
	var eid = $("select[name=eid]").val();
	if(eid>0){
		location.href= "<?=geturl('admin/refer')?>?eid="+eid;
	}
}
function del(rid){
    if (rid){
        $.messager.confirm('确认','确定要删除该评语么？',function(r){
            if (r){
                $.post('/admin/refer/del.html',{rid:rid},function(result){
                    if (result.success){
						$.messager.show({
                            title: '成功',
                            msg: '删除成功',
							timeout:2000
                        });
						setTimeout(function(){location.reload();}, 500 );
                    } else {
                        $.messager.show({
                            title: 'Error',
                            msg: result
                        });
                    }
                },'json');
            }
        });
    }
}

</script> 
</body>
<?php
$this->display('admin/footer');
?>