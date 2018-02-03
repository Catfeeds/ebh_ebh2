
<?php $this->display('troom/page_header');?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" />
<style type="text/css">
.tabhead th {
    background: none repeat scroll 0 0 #fff;
    font-weight: lighter;
    padding: 10px 6px;
    text-align: left;
}
.datatab td {
    border-bottom: 1px solid #efefef;
    border-top: 1px solid #efefef;
    color: #666666;
    padding: 10px 6px;
}
</style>
</head>

<body>
<div class="cright" style="margin-top:0;">
<div class="ter_tit">
 当前位置 > <a href="<?= geturl('troom/iaclassroom');?>">互动课堂</a> <?php if($this->input->get('item')!=1){ ?>> 互动管理 <?php }else{ ?> > 查看互动 <?php } ?>
 <div class="diles">
	<input name="uname" class="newsou" id="title" style="color:<?= $q!='请输入关键字'?'#000':'#a5a5a5'?>" value="<?=$q?>" type="text" />
	<input id="ser" type="button" onclick="_search()" class="soulico" value="" name="courseware_search">
</div>
</div>
<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:788px;">
<table class="datatab" width="100%" style="border:none;">
<thead class="tabhead">
<tr class="">
<!--<th>缩略图</th>-->
<th>标题</th>
<th>时间</th>
<th>操作</th>
</tr>
</thead>
<tbody>
<?php foreach ($iaList as $ia) {?>
<tr id="class44" class="class">
<!--<td><img src="<?= $ia['resource']?>"></td>-->
<td width="62%"><span style="width:425px;word-wrap: break-word;float:left;"><?=shortstr($ia['title'],50,'')?></span></td>
<td id="teachername_44" width="18%">
<?=date('Y-m-d H:i:s',$ia['dateline'])?>
</td>

<?php if($this->input->get('item')!=1){ ?>
<td width="15%">
<a class="workBtn" href="/troom/iaclassroom/edit-1-0-0-<?=$ia['icid']?>.html">修改</a>
<a class="workBtn" href="javascript:void(0)" onclick="degroup(<?=$ia['icid']?>,'<?=$ia['title']?>')">删除</a>
</td>
<?php }else{ ?>
<td width="10%">
<a class="workBtn" target="_blank" href="/troom/iaclassroom/detail-1-0-0-<?=$ia['icid']?>.html">查看</a>
</td>
<?php } ?>

</tr>
<?php }?>
<?php if(empty($iaList)){?>
	<tr><td colspan="3" align="center">暂无记录</td></tr>
<?php }?>
</tbody>
</table>
<?=$pagestr?>
</div>
</div>
<script type="text/javascript">
function degroup(icid,name) {
	$.confirm("您确定要删除互动 【" + name + "】 吗？",function(){
		$.ajax({
			url:"/troom/iaclassroom/deleteAjax.html",
			type:'post',
			data:{'icid':icid},
			dataType:'text',
			success:function(data){
				if(data>0){
					alert("删除成功！");
					document.location.href = document.location.href;
				}else{
					alert("对不起，删除失败，请稍后再试或联系我们的客服！");
				}
			}
		});
	});
}
function _search(){
	var q = $("#title").val();
	if(q=='请输入关键字'){
		q='';
	}
	location.href='/troom/iaclassroom/view.html?item=<?= $this->input->get('item')?>&q='+q;
}
var searchtext = "请输入关键字";
$(function() {
initsearch("title",searchtext);
   $("#ser").click(function(){
       var title = $("#title").val();
       if(title == searchtext) 
           title = "";
      
   });
   });
</script>
</body>
</html>
