<?php $this->display('troom/page_header'); ?>
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/tzds.css" rel="stylesheet" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
	
<style>
.datatab td{border-top:1px solid #efefef; border-bottom:1px solid #efefef; color:#999;}
</style>	
	<div class="ter_tit"> 当前位置 > <a href="<?= geturl('troom/notify') ?>">通知管理</a> > 通知列表 </div>
	<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:788px;">
		<div class="work_mes">
			<ul>
				<li class="workcurrent"><a href="<?= geturl('troom/notice') ?>"><span>通知列表</span></a></li>
				<li><a href="<?= geturl('troom/notice/send') ?>"><span>发送通知</span></a></li>
			</ul>
		</div>
		<table class="datatab" width="100%" style="border:none;">
			<thead class="tabhead">
				<tr class="">
					<th>通知名称</th>
					<th>时间</th>
					<th>接收方</th>
					<th>浏览次数</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				
				<?php if(!empty($notices)) { ?>
		
					<?php foreach($notices as $notice) { 
					$toname = '';
					$toidlist = explode(',',$notice['cids']);
					foreach($toidlist as $toid) {
						if(isset($classlist[$toid])) {
							$toname = empty($toname) ? $classlist[$toid]['classname'] : $toname .',' . $classlist[$toid]['classname'];
						}
					}
					?>
					<tr>
						<td width="20%"><span style="width:300px;word-wrap: break-word;float:left;"><a href="<?= geturl('troom/notice/'.$notice['noticeid']) ?>" target="_blank"><?= $notice['title'] ?></a></span></td>
						<td width="20%"><?= date('Y-m-d H:i',$notice['dateline']) ?></td>
						<td width="20%" title="<?= $toname ?>"><?= shortstr(trim($toname,","),30) ?></td>
						<td width="18%"><?= $notice['viewnum'] ?></td>
						<td width="19%">
							<a href="<?= geturl('troom/notice/edit/'.$notice['noticeid']) ?>" class="liuibtn" style="margin-left:0px;">修改</a>
							<a href="javascript:;" nid="<?= $notice['noticeid'] ?>" class="liuibtn delnotice">删除</a>
						</td>
					</tr>
					<?php } ?>
				<?php } else { ?>
				 	<tr>
						<td colspan="8" align="center">暂无记录</td>
					</tr>

				<?php } ?>
			</tbody>
		</table>

	</div><?=$pagestr?>

<script type="text/javascript">
	$(".delnotice").click(function(){
		var title = $(this).parent().parent().find("td").first().text();
		var nid = $(this).attr("nid");
		$.confirm("您确定删除【"+title+"】这个通知消息吗？",function(){
			var url = "<?= geturl('troom/notice/del') ?>";
			$.ajax({
				type: "POST",
				url: url,
				data: {"nid":nid},
				dataType:"json",
				success: function(msg){
					if(msg == 1){
						$.showmessage({
                            img : 'success',
                            message:'删除通知成功',
                            title:'删除通知',
                            callback :function(){
                                 window.location.href="<?= geturl('troom/notice') ?>";
                            }
                        });
						
					}else{
						$.showmessage({
                            img : 'error',
                            message:'删除通知失败，请稍后再试或联系管理员。',
                            title:'删除通知'
                        });
					}
				}
			});
		});
	});
</script>
<?php $this->display('troom/page_footer'); ?>