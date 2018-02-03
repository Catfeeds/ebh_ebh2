<?php $this->display('troom/page_header'); ?>
<style>
.lefrig .annotate a:hover {
	color:#fff;
}
.lefrig a.previewBtn:hover {font-weight:normal;}

#icategory {
    background: none repeat scroll 0 0 #F7FAFF;
    border-top: 1px solid #E1E7F5;
    padding: 6px 5px;
	_margin-bottom:-5px;
}
#icategory dt {
    float: left;
    line-height: 22px;
    padding-right: 5px;
    text-align: left;
}
#icategory dd {
    float: left;
    width: 635px;
}
.category_cont1 div a.curr, .price_cont div a:hover, .price_cont div a.curr {
	background: none repeat scroll 0 0 #FF5400;
	color: #FFFFFF;
	text-decoration: none;
}
.category_cont1 div a {
    color: #2C71AE;
    text-decoration: none;
    padding: 2px;
    cursor: pointer;
}
.category_cont1 div {
    float: left;
    height: 25px;
    line-height: 22px;
    overflow: hidden;
	padding:0 10px;
}
</style>
<div class="ter_tit">
		当前位置 > <a href="<?= geturl('troom/classexam') ?>">班级作业</a> > <a href="<?= geturl('troom/classexam/cor') ?>">批改作业</a> > <?= $myclass['classname'] ?> > <?=$d?>
</div>
<div class="lefrig" style="border:solid 1px #cdcdcd;background:#fff;float:left;margin-top:15px;width:786px;">
<div id="icategory" class="clearfix" style="border:none;">
	<dt>所属班级：</dt>
	<dd style="width:681px;">
		<div class="category_cont1">
			<div>
				<a <?php if($curclassid==0){echo 'class="curr"';}?> href="/troom/classexam/todayexams.html?d=<?=$d?>">所有班级</a>
			</div>
			<?foreach ($classDb as $class) {?>
				<div>
					<a <?php if($curclassid==$class['classid']){echo 'class="curr"';}?> href="/troom/classexam/todayexams-0-0-0-<?=$class['classid']?>.html?d=<?=$d?>"><?=$class['classname']?></a>
				</div>
			<?php }?>
        </div>
	</dd>


	<!-- <dt>所属年级：</dt>
	<dd style="width:681px;">
		<div class="category_cont1">
			<div>
				<a <?php if($grade==0){echo 'class="curr"';}?> href="/troom/linkcourse/my.html">所有年级</a>
			</div>
			<?foreach ($gradeDb as $grade) {?>
				<div>
					<a <?php if($grade==$grade['grade'].'_'.$grade['district']){echo 'class="curr"';}?> href="/troom/linkcourse/my-0-0-0-<?=$classid?>-<?=$grade['grade']?>-<?=$grade['district']?>.html"><?=$grademap[$grade['grade']]?></a>
				</div>
			<?php }?>
        </div>
	</dd> -->
</div>

<div class="workdata" style="float:left;margin:0;">
	<table width="100%" class="datatab" style="border:none;">
		<thead class="tabhead">
		  <tr>
			<th width="38%" style="width:334px\0;">作业名称</th>
			<th width="18%" style="width:180px\0;text-align:center;">时间</th>
			<th width="10%" style="width:60px\0;text-align:center;">分数</th>
			<th width="12%" style="width:120px\0;text-align:center;">答题人数</th>
			<th width="23%" style="width:170px\0;text-align:center;">操作&nbsp;&nbsp;&nbsp;</th>
		  </tr>
		</thead>
		 <tbody>
		 
		 <?php if(!empty($exams)) { ?>
	
			<?php foreach($exams as $exam) {?>
			<?php 
				if($exam['grade'] == 0){
					$relationName = '班级';
					//获取班级学生个数
            		// $stunum = array_key_exists('c_'.$exam['classid'], $classDb)?$classDb['c_'.$exam['classid']]['stunum']:0;
            		// $classname = array_key_exists('c_'.$exam['classid'], $classDb)?'<a href="/troom/classexam/todayexams-0-0-0-'.$exam['classid'].'.html?d='.$d.'">'.$classDb['c_'.$exam['classid']]['classname'].'</a>':$exam['classid'];
					$classids = array($exam['classid']);
				}else{
					$relationName = '班级';
					$isclass = 0;
					$gkey = 'g_'.$exam['grade'].'_'.$exam['district'];
            		// $stunum = array_key_exists($gkey, $gradeDb)?$gradeDb[$gkey]['stunum']:0;
            		// if(empty($gradeClassDb[$exam['grade'].'_'.$exam['district']])){
            			// $classname = '该教师不教'.$exam['district'].'地区的'.$grademap[$exam['grade']];
            		// }else{
            			// $classname = implode(',', $gradeClassDb[$exam['grade'].'_'.$exam['district']]);
            		// }
            		$mapkey = $exam['grade'].'_'.$exam['district'];
            		$classids = array_key_exists($mapkey, $gradeClassMapDb)?$gradeClassMapDb[$mapkey]:array();
				}
            	
           		$key = 'cw_'.$exam['cwid'];
            ?>
	              <?php foreach ($classids as $classid){?>
	              <?php 
	              		if( ($classid != $curclassid) && ($curclassid > 0) ){
	              			continue;
	              		}
	              		$classname = array_key_exists('c_'.$classid, $classDb)?'<a href="/troom/classexam/todayexams-0-0-0-'.$classid.'.html?d='.$d.'">'.$classDb['c_'.$classid]['classname'].'</a>':$classid;
	              		$stunum = array_key_exists('c_'.$classid, $classDb)?$classDb['c_'.$classid]['stunum']:0;
	              ?>
				  <tr>
				  	<td colspan=5 width="100%" name="<?= $exam['eid'] ?>">
					  	<div style="width:770px;float:left;">
						<span style="width:280px;float:left;word-wrap: break-word;font-weight:bolder;"><?= shortstr($exam['title'],60) ?></span>
						<span style="width:154px;float:left;text-align:center;"><?= date('Y-m-d H:i:s',$exam['dateline']) ?></span>
						<span style="width:70px;float:left;text-align:center;"><?= $exam['score'] ?></span>
						<span style="width:100px;float:left;text-align:center;"><?= $stunum.'/'.$exam['answercount'] ?></span>
						
							<?php if($exam['uid'] == $uid) { ?>
							<?php if($exam['status'] == 1){?>
								<a class="workBtn" href="http://exam.ebanhui.com/eedit/<?= $roominfo['crid'] ?>/<?= $exam['eid'] ?>.html" target="_blank">编辑</a>
							<? }?>
							<a class="workBtn" href="javascript:void(0)" onclick="delexam(<?= $exam['eid'] ?>,<?= $roominfo['crid'] ?>)">删除</a>
							<?php } ?>
							<?php if($exam['status'] == 0) { ?>
							<a class="previewBtn" href="http://exam.ebanhui.com/eedit/<?= $roominfo['crid'] ?>/<?= $exam['eid'] ?>.html" target="_blank">编辑草稿</a>
							<?php } else { ?>
							<a class="previewBtn" href="<?= geturl('troom/classexam/all-0-0-0-'.$classid.'-'.$exam['eid']) ?>" >作业批阅</a>
							<?php } ?>
						</div>
					<!-- ========= -->
					  	<p style="margin-top:10px;float:left;">
							<span style="width:699px;float:left;word-wrap: break-word;color:#999999;">所属<?=$relationName?>：<?= $classname ?></span>
					  	</p>
				  	<!-- ============== -->
				  	<?php  if(false && array_key_exists($key, $coursewareDb)){?>
					  <p style="margin-top:10px;float:left;">
						<span style="width:699px;float:left;word-wrap: break-word;color:#666666;"><span style="color:#999999">所属课件：</span><?= shortstr($coursewareDb[$key]['title'],60) ?></span>
						<?php if($exam['uid'] == $uid){?>
							<a class="lviewbtn" href="javascript:void(0)" onclick="unlinkDialog(<?=$exam['eid']?>)">取消</a>
					  	<?php }?>
					  </p>
				  	<?php }?>
					</td>
				  </tr>
			 	 <?php }?>
			  <?php } ?>

		 <?php } else { ?>
			<tr>
				<td colspan="8" align="center">暂无记录</td>
			</tr>

		 <?php } ?>
		 
		</tbody>
	</table>
	<div style="margin-top:20px;"><?= $pagestr ?></div>
</div>
</div>
</div>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<script type="text/javascript">
$(document).ready(function(){
	var cur_eid = $(".datatab tbody tr:eq(0) td:eq(0)").attr("name");
	var cid = $("#claid").val();
});

function delexam(eid,crid) {
	$.confirm("作业删除后，此作业下的学生答题记录也会删除，确定要删除吗？",function(){
		var url = '<?= geturl('troom/classexam/del') ?>';
		$.ajax({
			url:url,
			type:'post',
			data:{'eid':eid},
			dataType:'text',
			success:function(data){
				if(data==1){
					$.showmessage({
						img		 : 'success',
						message  :  '作业删除成功',
						title    :      '作业删除      成功',
						timeoutspeed    :       500,
						callback :    function(){
							location.reload();
						}
					});
				}else{
					$.showmessage({
						img		 : 'error',
						message  :  '作业删除失败',
						title    :      '作业删除      失败',
						timeoutspeed    :       500
					});
				}
			}
		});
	});
	
}function linkDialog(eid){
	parent.window.linkDialog(eid);
}

function unlinkDialog(eid){
	if(parseInt(eid)!=eid){
		$.showmessage({message:'参数不正确,取消关联失败！'});return;
	}
	var url = '/troom/linkcourse/dolink.html';
	$.ajax({
	    type:'POST',
	    url: url ,
	    data: {cwid:0,eid:eid},
	    success: function(result){
	    	$.showmessage({
					message:result.info,
					callback :function(){
                       location.reload();
                    }});
		},
	    dataType: 'json'
	});
}
</script>
<?php $this->display('troom/page_footer'); ?>