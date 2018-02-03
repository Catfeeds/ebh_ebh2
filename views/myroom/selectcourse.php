<?php $this->display('myroom/page_header'); ?>
<style type="text/css">
.span2 {color: #666;font-size: 14px;font-weight: bold;}
.lefrig a.hongjinbtn:visited{color:#fff;}
.lefrig a.souhui{margin:0;}
.lefrig a.souhui:hover,.lefrig a.souhui:visited {color:#fff;}
</style>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<div class="ter_tit">
	当前位置 > 在线选课
	<div class="diles">
	<?php
		$q= empty($q)?'':$q;
		if(!empty($q)){
			$stylestr = 'style="color:#000"';
		}else{
			$stylestr = "";
		}
	?>
		<input name="txtname" <?=$stylestr?> class="newsou" id="txtname" value="<?= $q?>" type="text" />
		<input type="button" onclick="searchs('txtname');return false;" class="soulico" value="">
	</div>
</div>
<div class="lefrig">
	<div style="height:auto;line-height:28px;padding-left:20px;border:solid 1px #cdcdcd;background:#fff;position: relative;text-align:center;" class="annuato">
		<?php if (empty($regtime['begintime'])){?>
		<span style="color: red; font-weight: bold;">报名未开始！</span>
		<?php }else{?>
		报名时间：<span style="color: red; font-weight: bold;"><?=empty($regtime['begintime'])?'':date("Y-m-d H:i:s", $regtime['begintime'])?> 至 <?=empty($regtime['endtime'])?'':date("Y-m-d H:i:s", $regtime['endtime'])?></span>
		<input type="hidden" id="old_folderid" name="old_folderid" value="<?=empty($regcourse)?0:$regcourse['folderid']?>" />
		<?php }?>
		<br />
		<?php
		if (!empty($regcourse)){ echo '您已报名的课程：&nbsp;<span style="color:blue;font-weight:bold;">' . $regcourse['foldername'] . '</span>&nbsp;'; } else { echo '您还未报名，请选择课程报名！'; }
		?>（每学期只能报一门课程）。
	</div>
	<div class="workol">
<script type="text/javascript">
	function searchs(strname){
		var sname = $('#'+strname).val();
		if(sname=='请输入搜索关键字'){
			sname = "";
		}
		location.href='<?= geturl('myroom/selectcourse')?>?q='+sname;
	}
</script>
		<div class="workdata" style="border:solid 1px #cdcdcd;background:#fff;margin-top:0;width:786px;">

	    	<table width="100%" class="datatab" style="border:none;">
				 <tbody>

				<tr class="first">
					<td width="43">课程</td>
					<td width="179">&nbsp;</td>
					<td width="100">教师</td>
					<td width="100">地点</td>
					<td width="60">计划数</td>
					<td width="60">报名数</td>
					<td width="160">操作</td>
				</tr>

				<?php if (!empty($courselist)) { foreach($courselist as $course){
					?>
                <tr>
                	<td><img style="float:left;width:43px;height:60px;" src="<?=empty($course['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$course['img']?>" /></td>
                	<td><span class="span2"><?=$course['foldername']?></span></td>
                    <td><?=$course['speaker']?></td>
                    <td><?=$course['location']?></td>
                    <td><?=$course['admitnum']?></td>
                    <td><?=$course['regnum']?></td>
                    <td>
                    	<a class="previewBtn" style="font-family: 宋体;" href="javascript:;" onclick="showcoursedetail(<?=$course['folderid']?>)">查看</a>
                    <?php
                    	if (empty($regtime['begintime']) || $regtime['begintime'] > SYSTIME)
                    	{
                    		echo '<a class="souhui" style="font-family: 宋体;" href="javascript:;">未开始</a>';
                    	}
                        elseif (!empty($regtime['endtime']) && $regtime['endtime'] < SYSTIME)
                        {
                        	echo '<a class="souhui" style="font-family: 宋体;" href="javascript:;">已结束</a>';
                        }
                       	elseif (!empty($regcourse) && $regcourse['folderid'] == $course['folderid'])
                        {
                        	echo '<a class="previewBtn" style="font-family: 宋体;" href="javascript:;" onclick="unregcourse(' . $course['folderid'] . ')">取消报名</a>';
                        }
                        elseif ($course['isforbidden'] == 1)
                        {
                        	echo '<a class="souhui" style="font-family: 宋体;" href="javascript:;">禁止报名</a>';
                        }
                        elseif ($course['admitnum'] <= $course['regnum'])
                        {
                        	echo '<a class="souhui" style="font-family: 宋体;" href="javascript:;">已报满</a>';
                        }
                    	else
                    	{
                    		echo '<a class="hongjinbtn" style="font-family: 宋体;" href="javascript:;" onclick="regcourse(' . $course['folderid'] . ')">报名</a>';
                    	}
                    ?>
                    </td>
                </tr>
                <?php }?>



				<?php } else { ?>
					<tr>
				 		<td colspan="7" align="center" style="border-top:none;">暂无课程</td>
				 	</tr>
				<?php } ?>
				</tbody>
			</table>
			<?= $pagestr ?>
	    </div>


	</div>
</div>
<!--课程详情-->
<div id="dialogdetail" style="display:none;">
<div style="width:500;height:255px;overflow-y: auto;">
	<div style="width:400px;margin:0 auto;">
	    <div style="margin-top: 15px;">
	        <div id="course_summary"></div>
	    </div>
	</div>
</div>
</div>
<script type="text/javascript">
function showcoursedetail(folderid)
{
	var button = new xButton();
	button.add({
		value:"关闭",
		callback:function(){
			H.get('dialogdetail').exec('close');
			return false;
		},
		autofocus:true
	});
	if(!H.get('dialogdetail')){
		H.create(new P({
			id : 'dialogdetail',
			title: '课程介绍',
			easy:true,
			width:500,
			padding:5,
			content:$('#dialogdetail')[0],
			button:button
		}),'common');
	}

	$(".ui-dialog-title").html("课程介绍");
	$("#course_summary").html("");
	H.get('dialogdetail').exec('show');
	$.post("<?=geturl('myroom/selectcourse/getdetail')?>", {"folderid": folderid}, function(data){
		if(data != undefined && data.code != undefined && data.code ==1){
			$(".ui-dialog-title").append('<span style="font-weight:normal">（'+data.course_name+'）</span>');
			$("#course_summary").html(data.course_summary);
		}
	}, "json");
}
function regcourse(folderid)
{
	var old_folderid = $("#old_folderid").val();
	if (old_folderid != 0 && old_folderid != folderid)
	{
		if (!confirm("您已经选择了其他课程，确定要更换吗？")) {
			return false;
		}
	}
	$.ajax({
		url:"<?=geturl('myroom/selectcourse/regcourse')?>",
		type:'post',
		data:{'folderid':folderid},
		dataType:'json',
		success:function(data){
			if(data != undefined && data.code != undefined && data.code ==1){
				$.showmessage({
					img : 'success',
					message:data.message,
					title:'在线选课',
					callback :function(){
						window.location.reload();
				}});
			}else{
				$.showmessage({
					img : 'error',
					message:data.message,
					title:'在线选课'
				});
			}
		}

	});
}
function unregcourse(folderid)
{
	$.ajax({
		url:"<?=geturl('myroom/selectcourse/unregcourse')?>",
		type:'post',
		data:{'folderid':folderid},
		dataType:'json',
		success:function(data){
			if(data != undefined && data.code != undefined && data.code ==1){
				$.showmessage({
					img : 'success',
					message:data.message,
					title:'在线选课',
					callback :function(){
						window.location.reload();
				}});
			}else{
				$.showmessage({
					img : 'error',
					message:data.message,
					title:'在线选课'
				});
			}
		}

	});
}
$(function(){
	var searchText = "请输入搜索关键字";
	initsearch("txtname",searchText);

<?php if (($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) && $check != 1) { ?>
	if(window.parent != undefined) {
		window.parent.showDivModel(".nelame");
	}
<?php }?>
});
</script>
<?php $this->display('myroom/page_footer'); ?>