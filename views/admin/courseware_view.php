<?php $this->display('admin/header');?>
<body id="main"><table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1 style="width:550px;">课件管理 -  查看课件信息</h1></td>
		<td class="actions" >
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tr>
            <td ><a href="/admin/courseware.html">浏览课件信息</a></td>
            <td ><a href="/admin/courseware/add.html" class="add">添加课件</a></td>
			</tr>
			</table>
		</td>
	</tr>
</table>
<style type="text/css">
body{font-family:tahoma,verdana,arial;font-size:11px;line-height:15px;background-color:#FCFDFD;color:#666666;margin-left:20px;}
strong{font-size:12px;}
aink{color:#0066CC;}
a:hover{color:#FF6600;}
aisited{color:#003366;}
a:active{color:#9DCC00;}
</style>
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
<tr><th>课件标题</th><td><?=$c['title']?></td></tr>
<tr><th>所属教师</th><td><?=$c['username']?></td></tr>
<tr><th>所属分类</th><td><?=$c['name']?></td></tr>
<tr><th>所属年级</th><td><?=$c['grade']?></td></tr>
<tr><th>课件版本</th><td><?=$c['edition']?></td></tr>
<tr><th>课件摘要</th><td><?=$c['summary']?></td></tr>
<tr><th>原作者</th><td></td></tr>
<tr><th>标签</th><td><?=$c['tag']?></td></tr>
<tr><th>封面</th><td><img src="<?=$c['logo']?>" /></td></tr>
<tr><th>添加时间</th><td><?=date('Y-m-d H:i:s',$c['dateline'])?></td></tr>
<tr><th>课件详情</th><td><?=$c['message']?></td></tr>
<tr><th>课件文件名</th><td><?=$c['cwname']?></td></tr>
<?php $images = unserialize($c['images']);?>
<tr><th>课件播放</th><td><img src="<?=$images['image194194']?>" style="width: 200px;height: 200px;"/>
	<input type="button" value="播放" onclick="study('<?=$c["cwsource"]?>',<?=$c['cwid']?>,'<?=$c["title"]?>',0)" /></td></tr>
<tr><th>定价</th><td><?=$c['verifyprice']?></td></tr>
<tr><th>排序</th><td><?=$c['displayorder']?></td></tr>
<?php 
	$statusInfo = array('_-1'=>'已退审',
						'_0'=>'待审核',
						'_1'=>'正常',
						'_-2'=>'已禁用',
						'_-3'=>'已删除'
					);
?>
<tr><th>状态</th><td><?=$statusInfo['_'.$c['status']]?></td></tr>
</a>
</table>
<div class="buttons">
<input type="reset"	 name="valuereset" value="返回" onclick='window.location.href="<?=geturl('admin/courseware')?>"'>
 
</div>
</form>

</body>

<?php $this->display('admin/footer');?>