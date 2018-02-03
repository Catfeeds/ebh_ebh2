<?php $this->display('aroom/page_header')?>

<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/tzds.css" rel="stylesheet" />
<div class="cright" style="margin-top:0px;">
	<div class="ter_tit"> 当前位置 > <a href="<?=geturl('aroom/astunotice')?>">全校师生通知</a> > 通知列表 </div>
	<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:788px;">
		<div class="worknu">
			<ul>
				<li class="workcurren"><a href="<?=geturl('aroom/astunotice')?>"><span>通知列表</span></a></li>
				<?php if($haspower == 1) { ?><li><a href="<?=geturl('aroom/astunotice/send')?>"><span>发送通知</span></a></li><?php } ?>
			</ul>
		</div>
		<table class="datatab" width="100%" style="border:none;">
			<thead class="tabhead">
				<tr class="">
					<th>通知名称</th>
					<th>时间</th>
					<th>类别</th>
					<th>浏览次数</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php if(!empty($noticelist)){
				$noticetype = array(1=>'全校师生',2=>'全校教师',3=>'全校学生',4=>'班级学生',5=>'部分年级学生');
					foreach($noticelist as $nl){
					?>
					<tr>
						<td width="25%"><span style="width:300px;word-wrap: break-word;float:left;"><?=$nl['title']?></span></td>
						<td width="20%"><?=Date('Y-m-d H:i',$nl['dateline'])?></td>
						<td width="15%"><?=$noticetype[$nl['ntype']]?></td>
						<td width="15%"><?=$nl['viewnum']?></td>
						<td width="18%">
							<a href="<?=geturl('aroom/astunotice/edit/'.$nl['noticeid'])?>" class="liuibtn">修改</a>
							<a href="javascript:;" nid="<?=$nl['noticeid']?>" class="liuibtn delnotice">删除</a>
						</td>
					</tr>
					<?php }}else{?>
				 	<tr>
						<td colspan="8" align="center">暂无记录</td>
					</tr>
					<?php }?>
			</tbody>
		</table>
		<?=show_page($noticecount)?>
	</div>
</div>
<script type="text/javascript">
	$(".delnotice").click(function(){
		var title = $(this).parent().parent().find("td").first().text();
		var nid = $(this).attr("nid");
		$.confirm("您确定删除【"+title+"】这个通知消息吗？",function(){
			$.ajax({
				type: "POST",
				url: "<?=geturl('aroom/astunotice/del')?>",
				data: {"nid":nid},
				dataType:"json",
				success: function(msg){
					if (msg.status!=0) {
						alert("删除成功");
						window.location.reload();
					}else{
						alert("删除失败");
						window.location.reload();
					}
				}
			});
		});
	});
</script>

<?php $this->display('aroom/page_footer')?>
