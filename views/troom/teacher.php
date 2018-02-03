<?php $this->display('troom/page_header'); ?>
<script type="text/javascript">
    var searchtext = "请输入学员帐号";
$(function(){
    initsearch("searchvalue",searchtext);
	$(".locking").click(function(){
		var _tid = $(this).attr("tid");
		var _type = $(this).attr("stype");
                var url = '<?= geturl('troom/teacher/upinfo') ?>';
		$.ajax({
			type:'post',
			url:url,
			dataType:'json',
			data:{'tid':_tid,'status':_type},
			success:function(data){
				if(data.status == 1){
					window.location.reload();
				}else{
					alert(data.message);
				}
			},
			error:function(){
				alert("服务器连接错误，请重试");
			}
		});
	});
});

	$(function(){
		$('#searchbutton').click(function(){
			var href = '<?= geturl('troom/teacher') ?>';
			var searchvalue = $("#searchvalue").val();
			if(searchvalue==searchtext){
				searchvalue='';
			}
                        href += "?q=" + searchvalue;
			location.href = href;
		});

	});
	function deltea(_tid,tname){
		var len = $(".datatab tbody tr").length;
		$.confirm("您确认要删除教师[ " +  tname + " ]吗？",function(){
                    var url = '<?= geturl('troom/teacher/upinfo') ?>';
			$.ajax({
				type:'post',
				url:url,
				dataType:'json',
				data:{'tid':_tid,'type':'del'},
				success:function(data){
					if(data.status == 1){
						window.location.reload();
					}else{
						alert(data.message);
					}
				},
				error:function(){
					alert("服务器连接错误，请重试");
					window.location.reload();
				}
			});
		});
	}
</script>

<div class="ter_tit">
	当前位置 > 教师管理
</div>
<div class="lefrig">
<div class="annotate">在此页面中,可显示教室下面的教师列表,添加的教师可以对电子教师的课件、学员进行管理，还可以对这些教师进行管理。</div>

<div class="annuato">
		<span style="float:left;height:28px;line-height:28px;">关键字：</span>
		<input type="text" name="search" value="<?= $q ?>" id="searchvalue" style="width:350px;" class="shurulan">
		<input class="souhuang" id="searchbutton" type="button" name="searchbutton" value="搜索" />
				<div class="tiezitool">
					<a class="hongbtn jiabgbtn" onclick="location.href='<?= geturl('troom/teacher/add') ?>'">添加教师</a>
				</div>
		</div>

<table width="100%" class="datatab">
	<thead class="tabhead">
	  <tr>
		<th></th>
		<th>账号</th>
		<th>教师姓名</th>
		<th>课件数</th>
		<th>加入时间</th>
		<th>状态</th>
		<th>修改操作</th>
	  </tr>
	 </thead>
	 <tbody>
	
         <?php if(!empty($teachers)) { ?>
                <?php foreach($teachers as $teacher) { 
                    $sex = empty($teacher['sex']) ? 't_man' : 't_woman';

                    $defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/'.$sex.'.jpg';
                    $face = empty($teacher['face']) ? $defaulturl : $teacher['face'];
                    $facethumb = getthumb($face,'40_40');
                    $style = $teacher['tstatus'] == 1 ? '' : 'style="color:#a7a7a7;"';
                    ?>
				  <tr>

					<td width="6%" <?= $style ?>><div class="avatar"><a href="<?= geturl('troom/teacher/'.$teacher['uid']) ?>">
					<img width="28px" height="28px" src="<?= $facethumb ?> " <?= $style ?> border="0" /></a></div></td>
					<td width="15%"><a href="<?= geturl('troom/teacher/'.$teacher['uid']) ?>" <?= $style ?>><?= $teacher['username'] ?></a></td>
					<td width="22%" <?= $style ?>><span style="float:left;width:150px;word-wrap: break-word;"><?= $teacher['realname'] ?></span></td>
					<td width="9%" <?= $style ?>><?= $teacher['coursenum'] ?></td>
					<td width="17%" <?= $style ?>><?= date('Y-m-d',$teacher['cdateline']) ?></td>
					<td width="8%"><em class="" crid="$value[crid]" tid="$value[tid]">
					
                                                <?php if($teacher['tstatus'] == 1) { ?>
						<font color="green" >正常</font>
                                                <?php } else { ?>
						<font color="#cccccc">锁定</font>
                                                <?php } ?>
					</em>
					</td>
					<td width="20%"><div class="teac_manage">
                                                <?php if($roominfo['uid'] != $teacher['uid']) { ?>
							<input type="button" tid="<?= $teacher['uid'] ?>" stype="<?= $teacher['tstatus'] == 1 ? 0 : 1 ?>" class="btnsuo locking" style="cursor:pointer;vertical-align: middle;font-weight:100;" value="<?= $teacher['tstatus'] == 1 ? '锁定' : '解锁' ?>" />
						<a class="workBtn" style="margin:0;" onclick="location.href='<?=geturl('troom/teacher/edit/'.$teacher['uid'])?>'">修改</a>
						<a style="margin-left:5px;" class="btnshan" href="javascript:;" onclick="deltea(<?=$teacher['uid']?>,'<?=empty($teacher['realname'])?$teacher['username']:$teacher['realname'] ?>')">删除</a>
                                                <?php } ?>
					</td>
				  </tr>
                <?php } ?>
	  </tbody>
         <?php } else { ?>
	  <tr><td colspan="7" align="center">暂 无 数 据</td></tr>
         <?php } ?>
</table>
<?= $pagestr ?>
</div>
<?php $this->display('troom/page_footer'); ?>