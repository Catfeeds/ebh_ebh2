<?php $this->display('troom/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/jquery-ui-1.8.1.custom.min.js"></script>
<link type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/css/default/jquery-ui-1.8.1.custom.css" rel="stylesheet" />	
<style type="text/css">
.fotwaim {
	border:solid 1px #d8d8d8;
	padding-top:25px;
	width:745px;
	float:left;
}
.fotwaim li.kemule {
	width:148px;
	height:120px;
	float:left;
}
.fotwaim li.kemule img {
	float:left;
	margin-left:45px;
	display:inline;
}
.fotwaim li.kemule span {
	width:148px;
	float:left;
	text-align:center;
	font-size:14px;
	color:#414141;
	margin-top:10px;
}
</style>
<div class="ter_tit">
当前位置 > <a href="<?= geturl('troom/reslibs')?>">精品试题库</a> > <?=$gradeName?> 
<div class="diles">
	<input name="uname" class="newsou" id="keyword" value="<?=$keyword?>" type="text" />
	<input onclick="dosearch()" id="ser" type="button" class="soulico" value="">
</div>
</div>

<div class="lefrig">
	<div class="workdata">
		<table  width="100%" class="datatab" style="width:788px;">
		 <thead class="tabhead" >
		 <tr>
			<th width="65%">试卷名称</th>
			<th width="15%">浏览/下载</th>
			<th width="20%">操作</th>
		</tr>
		</thead>
		<tbody>
		<?php if(empty($epList)){ ?>
			<tr><td colspan="3" align="center">目前没有试题</td></tr>
		<?php }else{ ?>
			<?php foreach ($epList as $onePaper){?>
				<tr>
					<td><?=$onePaper['libname']?></td>
					<td><?=$onePaper['viewnum']?>/<?=$onePaper['downnum']?></td>
					<td><a class="previewBtn" href="/epaper/<?=$onePaper['lid']?>.html" target="_blank">预览</a><a class="previewBtn" href="/epaper/attach.html?lid=<?=$onePaper['lid']?>">下载</a></td>
				</tr>
			<?php }?>
			</tbody>
			</table>
			<?=$showpage?>
		<?php } ?>
		</tbody>
		</table>
		
	</div>
</div>
<script type="text/javascript">
<!--
	function dosearch(){
		var keyword = $('#keyword').val();
		if(keyword=='输入您要搜索的试卷'){
			window.location.href="/<?=$uriPath?>.html";
		}else{
			window.location.href="/<?=$uriPath?>.html?keyword="+keyword;
		}
		
	}
	$(function(){
		$('#keyword').focus(function(){
			if($(this).val()=='输入您要搜索的试卷'){
				$(this).css('color','#000');
				$(this).val('');
			}
		}).blur(function(){
			if($(this).val()==''){
				$("#keyword").css('color','#d2d2d2');
				$(this).val('输入您要搜索的试卷');
			}
		});
		$('#keyword').trigger('blur');
	});
	$(function(){
		if($("#keyword").val()=='输入您要搜索的试卷'){
			$("#keyword").css('color','#d2d2d2');
		}else{
			$("#keyword").css('color','#000');
		}
	});
//-->
</script>
<?php $this->display('troom/page_footer'); ?>