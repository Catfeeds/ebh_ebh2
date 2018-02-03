<?php $this->display('aroomv2/page_header')?>

<script src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<body>
<div>
	<div class="ter_tit">
        当前位置 > <a href="/aroomv2/report.html">统计分析</a> > <a href="/aroomv2/teacher/viewnav.html">教师查看</a> > 教师列表
    </div>
<div>
    <div class="teachercheck">
    	<div class="teachercheck_top">
            <div class="diles diles-1">
				<input type="text" id="searchkey" value="<?=empty($q)?'请输入教师账号或姓名':$q?>" id="search" class="newsous" name="title" style="color:#999; background:#fff;" onfocus="if($(this).val()=='请输入教师账号或姓名')$(this).val('');$(this).css('color','#333')" onblur="if($.trim($(this).val())==''){$(this).val('请输入教师账号或姓名');$(this).css('color','#999')}"/>
				<input type="button" class="soulico" onclick="_search()">
			</div>
        </div>
        <div class="clear"></div>
        <div class="teachercheck_bottom">
        	<table cellpadding="0" cellspacing="0" class="tables">
            	<tr   class="first">
                	<td width="227">教师</td>
                    <td width="56">性别</td>
                    <td width="73">积分</td>
                    <td width="120">联系方式</td>
                    <td width="250">查看</td>
                </tr>
				<?php 
				$rurl = $this->uri->path;
				if(!empty($teacherlist)){
				foreach($teacherlist as $teacher){
					$face = getthumb($teacher['face'],'50_50');
					if(empty($face))
						$face = 'http://static.ebanhui.com/ebh/tpl/default/images/'.(empty($teacher['sex'])?'t_man_50_50.jpg':'t_woman_50_50.jpg');
					?>
                <tr>
                	<td width="227"><div class="fl"><img src="<?=$face?>" style="height:50px; width:50px;"/></div><p class="p2"><b><?=$teacher['realname']?><br /><?=$teacher['username']?></p></td>
                    <td width="56"><?=empty($teacher['sex'])?'男':'女'?></td>
                    <td width="73"><?=$teacher['credit']?></td>
                    <td width="120"><?=$teacher['mobile']?></td>
                    <td width="250">
                    	<a href="<?=geturl('aroomv2/teacher/courseware/'.$teacher['uid']).'?rurl='.$rurl?>">课件</a><a style="margin-left:12px;" href="<?=geturl('aroomv2/teacher/exam/'.$teacher['uid']).'?rurl='.$rurl?>">作业</a><a style="margin-left:12px;" href="<?=geturl('aroomv2/teacher/answer/'.$teacher['uid']).'?rurl='.$rurl?>">答疑</a><a style="margin-left:12px;" href="<?=geturl('aroomv2/teacher/review/'.$teacher['uid']).'?rurl='.$rurl?>">评论</a><a style="margin-left:12px;" target="_blank" href="/aroom/umanager/teacher.html?s=<?=urlencode(authcode($teacher['uid'],'ENCODE'))?>">进入老师首页</a>
                    </td>
                </tr>
                <?php }
				}else{?>
				<tr><td colspan="6" style='text-align:center'>暂无课件</td></tr>
				<?php }?>
            </table>
        </div>
    </div>
	<?=$pagestr?>
</div>
</body>
<script>
function _search(){
	var searchkey = $('#searchkey').val();
	if(searchkey == '请输入教师账号或姓名')
		searchkey = '';
	location.href = '/aroomv2/teacher/teacherlist.html?q='+searchkey;
}
function _clear(){
	$('#startdate').val('');
	$('#enddate').val('');
}
</script>
</html>

