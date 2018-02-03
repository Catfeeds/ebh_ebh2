<?php
$this->display('troomv2/page_header');
$roominfo = Ebh::app()->room->getcurroom();
?>
<body>
<style type="text/css">
    .tables tr:hover{
        background: #fff;
    }
	.tables tr.first td{
		background:none !important;
	}
</style>
<div class="lefrig">
	<div class="waitite">
		<div class="work_menu" style="position:relative;margin-top:0">
			<ul>
				<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso"><?=$pagemodulename?></span></a></li>
			</ul>
		</div>
        <div class="diles">
			<input type="text" id="searchkey" value="<?=empty($q)?'请输入课程名称':$q?>" id="search" class="newsou" name="title" style="color:#999;background:#fff;" onfocus="if($(this).val()=='请输入课程名称')$(this).val('');$(this).css('color','#333')" onblur="if($.trim($(this).val())==''){$(this).val('请输入课程名称');$(this).css('color','#999')}"/>
			<input type="button" class="soulico" onclick="_search()">
		</div>
	</div>
        <div class="selectcourse_bottom mt15">
        	<table cellpadding="0" cellspacing="0" class="tables">
            	<tr  class="first">
                    <td width="400">课程</td>
                    <td width="60">计划数</td>
                    <td width="60">报名数</td>
                    <td width="86">历年报名数</td>
                    <td width="120">操作</td>
                </tr>
			<?php if (!empty($courselist)) {
				$gradearr = array(1=>'一年级',2=>'二年级',3=>'三年级',4=>'四年级',5=>'五年级',6=>'六年级');
				foreach($courselist as $course){
				?>
                <tr>
                	<td>
                        <?php if ($roominfo['template'] == 'plate') { ?>

                        <?php } else { ?>
                            <div class="fl"><img style="width:57px;height:80px; padding-right:5px;" src="<?=empty($course['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$course['img']?>" /></div>
                        <?php } ?>
                    	<p class="fl" style="width:258px;line-height:23px;"><span class="span2"><?=$course['foldername']?></span><br/><span style="color:#808080;">教师：<?=$course['speaker']?></span><br/>
                        <span style="color:#808080;">地点：<?=$course['location']?></span><br/>
                        <span style="color:#808080;">年级：<?php if (empty($course['allowgrade'])) { echo '不限制';} else {
                    		$gradestr = trim($course['allowgrade'], ',');
                    		$grades = explode(',', $gradestr);
                    		foreach ($grades as $key => $value) {
                    			$grades[$key] = array_key_exists($value, $gradearr) ? $gradearr[$value] : '';
                    		}
                    		echo implode('、', $grades); } ?></span></p>
                    </td>
                    <td><?=$course['admitnum']?></td>
                    <td><?=$course['regnum']?></td>
                    <td><?=$course['totalnum']?></td>
                    <td>
                        <a href="<?=geturl('troomv2/selectcourse/student/'.$course['folderid']).'?rurl='.$this->uri->path?>" class="workBtn" style="width:78px;color:#fff;text-decoration:none;">查看报名学生</a>
                    </td>
                </tr>
            	<?php
            	}
            } else { ?>
				<tr style="background:#fff;">
			 		<td colspan="5" align="center" style="border-top:none;"><div class="nodata"></div></td>
			 	</tr>
			<?php } ?>
            </table>
        </div>
 	<?=$pagestr?>
</div>
</body>
<script>
function _search(){
	var searchkey = $('#searchkey').val();
	if(searchkey == '请输入课程名称')
		searchkey = '';
	location.href = '<?=geturl('troomv2/selectcourse/courselist')?>?q='+searchkey;
}
</script>
</html>
