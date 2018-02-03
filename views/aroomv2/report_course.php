<?php $this->display('aroomv2/page_header')?>
<body>
<div>
	<div class="ter_tit">
		当前位置 > <a href="/aroomv2/report.html">统计分析</a> > 课程查看
	</div>
    <div class="coucheck ">
    	<div class="coucheck_top">
        	
            <div class="diles diles-1 fr">
                <input type="text" value="<?=empty($q)?'请输入课程名称':$q?>" id="searchkey" class="newsous" name="title" style="color:#999; background:#fff;" onfocus="if($(this).val()=='请输入课程名称')$(this).val('');$(this).css('color','#333')" onblur="if($.trim($(this).val())==''){$(this).val('请输入课程名称');$(this).css('color','#999')}">
                <input type="button" value="" onclick="_search()" class="soulico" id="searchbutton">
            </div>
        </div>
        <div class="clear"></div>
        <div class="coucheck_bottom">
        	<table cellpadding="0" cellspacing="0" class="tables">
        		<tr class="first">
                    <?php if ($roominfo['template'] == 'plate') { ?>
                        <td width="403">课程名称</td>
                        <td width="283">任课教师</td>
                        <td width="66">查看</td>
                    <?php } else { ?>
                        <td width="353">课程名称</td>
                        <td width="333">任课教师</td>
                        <td width="66">查看</td>
                    <?php } ?>
            	</tr>
				<?php if(!empty($courselist)){
					foreach($courselist as $course){
						$viewnumlib = Ebh::app()->lib('Viewnum');
						$viewnum = $viewnumlib->getViewnum('folder',$course['folderid']);
						$viewnum = empty($viewnum)?$course['viewnum']:$viewnum;
						$count = !empty($course['teachers']) ? substr_count($course['teachers'],',') : -1;
					?>

				 <tr>
                	<td class="subject">
                    	<div class="fl">
                            <?php if ($roominfo['template'] == 'plate') {
                                $img = show_plate_course_cover($course['img']); ?>
                                <img style="width:147px;height:86px; padding-right:5px;" src="<?=empty($img)?'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_147_86.jpg':show_thumb($img, '147_86')?>" />
                            <?php } else { ?>
                                <img style="width:63px;height:86px; padding-right:5px;" src="<?=empty($course['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$course['img']?>" />
                            <?php } ?>
                        </div>
						<p class="fl titlecourse"><?=$course['foldername']?></p>
						<p class="datadd fl"><span class="datapeople-1" title="教研组成员数"><?= ($count==0&&empty($course['teachers']))?$count:$count+1?></span><span class="address-1"><?=$course['coursewarenum']?></span><span class="nianji-1"><?=$viewnum?></span></p>
                    </td>
                    <td><p style="word-wrap: break-word;float:left;"><?=!empty($course['teachers'])?$course['teachers']:''?></p></td>
                    <td>
                    	<a href="<?=geturl('aroomv2/report/coursewarelist/'.$course['folderid']).'?rurl='.$this->uri->path?>">查看</a>
                    </td>
                </tr>


					<?php }
				}else{?>
				<tr><td colspan="3" style="text-align:center"><?=empty($q)?'暂无数据':'没有关于 "'.$q.'" 的搜索结果'?></td></tr>
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
	if(searchkey == '请输入课程名称')
		searchkey = '';
	location.href = '/aroomv2/report/course.html?q='+searchkey;
}
</script>
</html>
