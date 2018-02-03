<?php $this->display('aroomv2/page_header')?>

<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<!--<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />-->
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/tzds.css" rel="stylesheet" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen">
<style>
.datatab td{border-top:1px solid #efefef; border-bottom:1px solid #efefef; color:#999;}
.lefrig a.liuibtn-1{color:#ff9933;}
.lefrig a.liuibtn-1:hover{ color:#ff9933; text-decoration: none;}
.tabhead th{
	font-weight:normal;
}
</style>
<div class="cright" style="margin-top:0px;">
	<div class="ter_tit"> 当前位置 > <a href="<?=geturl('aroomv2/information')?>">信息管理</a> > 通知列表 </div>
	<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:788px;">
		<div class="work_mes">
			<ul>
				<li class="workcurrent"><a href="<?=geturl('aroomv2/information/astunotice')?>"><span>通知列表</span></a></li>
				<?php if($haspower == 1) { ?><li><a href="<?=geturl('aroomv2/information/astunotice/send')?>"><span>发送通知</span></a></li><?php } ?>
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
						<td width="25%"><span style="width:300px;word-wrap: break-word;float:left;color: #3366cc; "><?=$nl['title']?></span></td>
						<td width="20%"><?=Date('Y-m-d H:i',$nl['dateline'])?></td>
						<td width="15%"><?=$noticetype[$nl['ntype']]?></td>
						<td width="15%"><?=$nl['viewnum']?></td>
						<td width="18%">
							<a href="<?=geturl('aroomv2/information/astunotice/edit/'.$nl['noticeid'])?>" class="liuibtn-1">修改</a>
							<a href="javascript:showdel(<?=$nl['noticeid']?>);" nid="<?=$nl['noticeid']?>" class="liuibtn-1 delnotice">删除</a>
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
<!--删除消息-->
<div id="delte" class="tanchukuang" style="display:none;height:130px;">
    <div class="tishi" style="height:70px;line-height: 45px;"><span>你确定要删除该通知消息吗？</span></div>
</div>
<script type="text/javascript">

//删除
function showdel(noticeid){
	var button = new xButton();
	button.add({
		value:"确定",
		callback:function(){
			del(noticeid);
			H.get('delte').exec('close');
			return false;
		},
		autofocus:true
	});

	button.add({
		value:"取消",
		callback:function(){
			// location.reload();
			H.get('delte').exec('close');
			return false;
		}
	});

	if(!H.get('delte')){
		H.create(new P({
			id : 'delte',
			title: '删除通知',
			easy:true,
			width:420,
			padding:5,
			button:button,
			content:$('#delte')[0]
		}),'common').exec('show');
		
	}else{
		H.get('delte').exec('show');
	}


}

function del(noticeid){

	$.ajax({
		type:'post',
		url:'<?=geturl('aroomv2/information/delast')?>',
		dataType:'text',
		data:{'nid':noticeid},
		success:function(res){
			if(res.status!=0){
				 $.showmessage({
						img : 'success',
						message:'删除成功',
						title:'删除通知',
						callback :function(){
							 document.location.reload();
						}
					});
			}else{
				$.showmessage({
						img : 'error',
						message:'删除失败，请稍后再试或联系管理员。',
						title:'删除通知'
					});
			}
		},
		error:function(){
			alert("服务器连接错误，请重试");
		}
	});
}

//
//	$(".delnotice").click(function(){
//		var title = $(this).parent().parent().find("td").first().text();
//		var nid = $(this).attr("nid");
//			$.ajax({
//				type: "POST",
//				url: "<?=geturl('aroomv2/information/delast')?>",
//				data: {"nid":nid},
//				dataType:"json",
//				success: function(msg){
//					if (msg.status!=0) {
//						alert("删除成功");
//						window.location.reload();
//					}else{
//						alert("删除失败");
//						window.location.reload();
//					}
//				}
//			});
//	});
</script>

<?php $this->display('aroomv2/page_footer')?>
