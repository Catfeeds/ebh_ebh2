
<?php $this->display('troomv2/page_header');?>
<style type="text/css">
.tabhead th {
    background: none repeat scroll 0 0 #fff;
    font-weight: lighter;
    text-align: left;
	color:#000;
}
.datatab td {
    border-bottom: 1px solid #f5f5f5;
    border-top: 1px solid #f5f5f5;
    color: #666666;
}
</style>
</head>

<body>
<div class="lefrig">
<div class="waitite">
	<div class="work_menu" style="position:relative;margin-top:0">
		<ul>
			<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso"><?=$pagemodulename?></span></a></li>
		</ul>
	</div>
	<a href="/troomv2/iaclassroom/add.html" value = <?php echo $isclasses?> class="jaddre">新建互动</a>
	 <div class="diles">
		<input name="uname" class="newsou" id="title" style="color:<?= $q!='请输入关键字'?'#000':'#a5a5a5'?>" value="<?=$q?>" type="text" />
		<input id="ser" type="button" onclick="_search()" class="soulico" value="" name="courseware_search">
	</div>
</div>

<table class="datatab" width="100%" style="border:none;">
<thead class="tabhead">
<tr class="">
<!--<th>缩略图</th>-->
<th>标题</th>
<th>参与的班级</th>
<th style="text-align:center;">时间</th>
<th style="text-align:center;">操作</th>
</tr>
</thead>
<tbody>
<?php foreach ($iaList as $ia) {?>
<tr id="class44" class="class">
<!--<td><img src="<?= $ia['resource']?>"></td>-->
<td width="38%"><img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/<?php echo $classname?>.jpg?v=20160608" class="tyrtrew1s tyrtrew3s" /><span class="kuerse" ><?=shortstr($ia['title'],36,'')?></span></td>
<td width="22%"><?php if(!empty($ia['classname'])){echo $ia['classname'];}else{echo '全部班级';}?></td>
<td style="text-align:center;" id="teachername_44" width="18%">
<?=date('Y-m-d H:i:s',$ia['dateline'])?>
</td>

<?php if($this->input->get('item')!=1){ ?>
<td width="22%">
<a class="waskes" target="_blank" href="/troomv2/iaclassroom/detail-1-0-0-<?=$ia['icid']?>.html">查看</a>
<a class="xiaust" title="编辑" href="/troomv2/iaclassroom/edit-1-0-0-<?=$ia['icid']?>.html"></a>
<a class="shansge" title="删除" href="javascript:void(0)" onclick="degroup(<?=$ia['icid']?>,'<?=$ia['title']?>')"></a>
</td>
<?php } ?>

</tr>
<?php }?>
<?php if(empty($iaList)){?>
	<tr><td colspan="4" align="center" style="border-bottom:none;"><div class="nodata"></div></td></tr>
<?php }?>
</tbody>
</table>
<?=$pagestr?>
</div>
<script type="text/javascript">
function degroup(icid,name) {
		var d = top.dialog({
		title: '删除确认',
		content: '您确定要删除互动 【' + name + '】 吗？',
		okValue: '确定',
		ok: function () {
		$.ajax({
			url:"/troomv2/iaclassroom/deleteAjax.html",
			type:'post',
			data:{'icid':icid},
			dataType:'text',
			success:function(data){
				if(data>0){
					document.location.href = document.location.href;
				}else{
					    var d = dialog({
						title: '提示信息',
						content: '对不起，删除失败，请稍后再试或联系我们的客服！',
						cancel: false
					});
					d.show();
					setTimeout(function () {
						d.close().remove();
					}, 2000);
				}
			}
		});
		},
		cancelValue: '取消',
		cancel: function () {}
	});
	d.showModal();
}
$('.jaddre').click(function(){
    var isclasses = $('.jaddre').attr('value');
    if(isclasses==1){
        alert('学校还未有班级,请先添加班级')
        return false;
    }
})
function _search(){
	var q = $("#title").val();
	if(q=='请输入关键字'){
		q='';
	}
	location.href='/troomv2/iaclassroom/view.html?item=<?= $this->input->get('item')?>&q='+q;
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
   $(function(){
		$('.datatab tr:last td').css('border-bottom','none');
	});
</script>
</body>
</html>
