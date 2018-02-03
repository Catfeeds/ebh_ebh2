<?php $this->display('troomv2/page_header'); ?>
<style type="text/css">
body{font-family: "微软雅黑";font-weight: 500;}
#icategory{
	background:#fff;
	padding:6px 10px;
}
.category_cont1 div{
	height:40px;
	line-height:40px;
}
.fbsjkc .kkjssj{
	width:auto;
	float:left;
}
.fbsjkc .cyrss{
	background: url(http://static.ebanhui.com/ebh/tpl/troomv2/images/renqi.png) no-repeat left center;
	padding-left: 15px;
}
.fbsjkc .cyrus{
	background: url(http://static.ebanhui.com/ebh/tpl/troomv2/images/renyuan.png) no-repeat left center;
	padding-left: 15px;
}
.bzzytitle a{
    font-family: 微软雅黑;
    font-weight: bold;
    color: #333;
    font-size: 16px;
}
.diles{
	top:55px;
}
.cuotiji{
	margin-right:11px !important;
}
</style>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />

<div class="lefrig">
	<div class="waitite">
	<div class="work_menu" style="position:relative;margin-top:0">
		<ul class="fl">
			<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso"><?=$pagemodulename?></span></a></li>
		</ul>
		<div style="float:right;display:inline;">
			<a class="mulubgbtns" href="http://exam.ebanhui.com/enew/<?php echo $roominfo['crid']?>.html" target="_blank" style="margin-top:6px;">布置作业</a>
			<a class="mulubgbtns" href="http://exam.ebanhui.com/smartenew/<?php echo $roominfo['crid']?>.html" target="_blank" style="margin-top:6px;">智能随机作业</a>
			<a class="mulubgbtns cuotiji" href="/troomv2/classexam/errors.html" style="margin-top:6px;">错题集</a>
		</div>
	</div>
	<div class="clear"></div>
	<div class="diles">
		<?php
			$q= empty($q)?'':$q;
			if(!empty($q)){
				$stylestr = 'style="color:#000"';
			}else{
				$stylestr = "";
			}
		?>
		<input name="title" class="newsou" <?=$stylestr?> id="title" name="uname" value="<?= $q?>"  type="text" />
		<input id="ser" type="button" class="soulico" value="">
	</div>
	</div>
	<div class="workol">
		<div id="icategory" class="clearfix" style="border-top:none;">
			<dl style="float:left;display:inline;width:595px; *width:500px;">
			<dd>
				<div class="category_cont1">
					<div><a class="curr">所有作业</a></div>
					<!--<div><a>家庭作业</a></div>
					<div><a>随堂作业</a></div>
					<div><a>考试</a></div>-->
				</div>
			</dd>
			</dl>
		</div>
		<div style="clear:both;"></div>
		<div class="workdata" style="float:left;margin-top:0px;">
			<div class="workdatabzylist">
<!--                --><?php //if($v['uid']==$user['uid']){$isme=1;}else{$isme=0;}?>
                <?php if(!empty($cexamslist)){foreach($cexamslist as $v){?>
                    <div class="workdatabzylist1" style="height: <?= ($v['uid']!=$user['uid'])?80:115 ?>px;">
                    <?php if($v['uid']==$user['uid']){?>
                    	<?php if(in_array($v['type'],array(2,3))){?>
                    		<div class="bzzytitle"><a href="http://exam.ebanhui.com/smarteedit/<?= $roominfo['crid'] ?>/<?= $v['eid'] ?>.html" target="_blank"><?php echo $v['title']?><span><?php if($v['status']==0 ) echo '(草稿)';?></span></a></div>
                        <?php }else{?>
                        	<div class="bzzytitle"><a href="http://exam.ebanhui.com/eedit/<?= $roominfo['crid'] ?>/<?= $v['eid'] ?>.html" target="_blank"><?php echo $v['title']?><span><?php if($v['status']==0 ) echo '(草稿)';?></span></a></div>
                        <?php }?>
                    	
					    
                    <?php }else{?>
                        <div class="bzzytitle"><a href="javascript:;"><?php echo $v['title']?><span><?php if($v['status']==0 ) echo '(草稿)';?></span></a></div>
                    <?php }?>
					<div class="fl" style="width:100%;">
						<div class="fbsjkc fl ml25">
							<p class="fl" style="width:<?php if($v['uid']==$user['uid']){echo 150;}else{echo 200;}?>px;"><?=timetostr($v['dateline']);?> <?php if($v['uid']!=$user['uid']) {echo empty($v['realname'])?ssubstrch($v['username'],0,8):ssubstrch($v['realname'],0,8);}?>发布</p>
							<p class="fl" style="color:#999;">总分:<?php echo $v['score']?><span style="padding:0 10px;">|</span></p>
							<p class="kkjssj">计时:<?php if(!empty($v['limitedtime'])){ echo $v['limitedtime']?>分钟<?php }else{echo '不计时';}?><span style="padding:0 10px;">|</span></p>
							<p class="kkjssj cyrss">参与人数：<?php echo $v['answercount']?>/<?php if(!empty($v['classid'])&&$v['district']==0){echo $this->model('classes')->getClassStudentCount($v);}elseif(!empty($v['grade'])){echo $this->model('classes')->getGradeStudentCount(array('grade'=>$v['grade'],'crid'=>$roominfo['crid']));}else{echo 0;}?><span style="padding:0 10px;">|</span></p>
                            <p class="kkjssj cyrus" title="<?php if(isset($v['classname_t'])) echo $v['classname_t']?>">参与人员：<?php echo $v['classname']?></p>
						</div>

						<div class="fr ml25" style="width:190px;">
                            <?php if($v['uid']==$user['uid']){?>
                            <?php if($v['status']== 1){?>
                                <?php if(!empty($v['classid'])){?>
                                    <a class="bjcgs" target="" href="<?= geturl('troomv2/classexam/all2-0-0-0-'.$v['classid'].'-'.$v['eid']) ?>" >作业批阅</a>
                                <?php }else{?>
                                    <a class="bjcgs" target="" href="<?= geturl('troomv2/classexam/all_g2-0-0-0-0-'.$v['eid']) ?>" >作业批阅</a>
                                <?php }?>
                            <?php }elseif($v['status'] == 0){?>
                                <?php if(in_array($v['type'],array(2,3))){?>
                                    <a class="bjcgs" href="http://exam.ebanhui.com/smarteedit/<?= $roominfo['crid'] ?>/<?= $v['eid'] ?>.html" target="_blank">编辑草稿</a>
                                <?php }else{?>
                                    <a class="bjcgs" href="http://exam.ebanhui.com/eedit/<?= $roominfo['crid'] ?>/<?= $v['eid'] ?>.html" target="_blank">编辑草稿</a>
                                <?php }?>
                            <?php }?>
							<a href="javascript:;" onclick="delexam(<?= $v['eid'] ?>,<?= $roominfo['crid'] ?>)" class="lasrnwe mt5 ml20" style="float:right;display:inline;"><img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/shanchu.png"></a>
                            <?php if($v['status'] == 1){?>
                                <?php if(in_array($v['type'],array(2,3))){?>
                                    <a href="http://exam.ebanhui.com/smarteedit/<?= $roominfo['crid'] ?>/<?= $v['eid'] ?>.html" class="lasrnwe mt5 ml20" style="float:right;display:inline;"><img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/xiugai.png"></a>
                                <?php }else{?>
                                    <a href="http://exam.ebanhui.com/eedit/<?= $roominfo['crid'] ?>/<?= $v['eid'] ?>.html" class="lasrnwe mt5 ml20" style="float:right;display:inline;" target="_blank"><img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/xiugai.png"></a>
                                <?php }?>
                            <?php }else{?>
                                <?php if(in_array($v['type'],array(2,3))){?>
                                    <a href="http://exam.ebanhui.com/smarteedit/<?= $roominfo['crid'] ?>/<?= $v['eid'] ?>.html" class="lasrnwe mt5 ml20" style="float:right;display:inline;" target="_blank"><img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/xiugai.png"></a>
                                <?php }else{?>
                                    <a href="http://exam.ebanhui.com/eedit/<?= $roominfo['crid'] ?>/<?= $v['eid'] ?>.html" class="lasrnwe mt5 ml20" style="float:right;display:inline;" target="_blank"><img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/xiugai.png"></a>
                                <?php }?>
                            <?php }?>
                            <?php }?>
						</div>
					</div>
					<div class="clear:both;"></div>
					<div class="glkcs ml25">
						<span class="glkcspan"><?php echo $v['ti']?></span>
						<a href="javascript:;"></a>
					</div>
					<div class="clear:both;"></div>
                    <?php if($v['uid']==$user['uid']){?>
					<div class="hsidts1s ml25" style="float:left;display:inline;width:100%;">
							<a href="http://exam.ebanhui.com/outword/<?= $roominfo['crid'] ?>/<?= $v['eid'] ?>.html" target="_blank" class="lasrnwe">导出为word</a>
<!--						<a class="lasrnwe" href="">统计分析</a>-->
                        <?php if(!empty($v['classid'])){?>
						<a href="/troomv2/classexam/classerrorbook.html?eid=<?php echo $v['eid']?>&classid=<?php echo $v['classid']?>" class="lasrnwe" >错题排名</a>
                        <?php }else{?>
						<a href="/troomv2/classexam/classerrorbook.html?eid=<?php echo $v['eid']?>&grade=<?php echo $v['grade']?>" class="lasrnwe" >错题排名</a>
                        <?php }?>
					</div>
                    <?php }?>
				</div>
                <?php }}else{?>
                    <div class="nodata"></div>
    <?php }?>
			</div>
		</div>
		<?= $pagestr ?>
	</div>
</div>
<script type="text/javascript">

var searchtext = "请输入关键字";
$(function() {
initsearch("title",searchtext);
   $("#ser").click(function(){
       var title = $("#title").val();
       var folderid = $("a.curr").attr('tag');
       if(title == searchtext)
           title = "";
       var url = '<?= geturl('troomv2/classexam') ?>' + '?folderid='+folderid+'&q='+title;
       document.location.href = url;
   });
   });
function delexam(eid,crid) {
        var url = '<?= geturl('troomv2/classexam/del') ?>';
		var d = top.dialog({
		title: '删除确认',
		content: '作业删除后，此作业下的学生答题记录也会删除，确定要删除吗？',
		okValue: '确定',
		ok: function () {
        $.ajax({
            url:url,
            type:'post',
            data:{'eid':eid},
            dataType:'text',
            success:function(data){
                if(data==1){
					top.dialog({
						skin:"ui-dialog2-tip",
						content:"<div class='TPic'></div><p>作业删除成功！</p>",
						width:350,
						onshow:function () {
							var that=this;
							setTimeout(function () {
								location.reload();
								that.close().remove();
							}, 1000);
						}
					}).show();
                }else{
					top.dialog({
						skin:"ui-dialog2-tip",
						content:"<div class='FPic'></div><p>作业删除失败，请稍后再试或联系管理员！</p>",
						width:350,
						onshow:function () {
							var that=this;
							setTimeout(function () {
								that.close().remove();
							}, 2000);
						}
					}).show();
                }
            }
        });
		},
		cancelValue: '取消',
		cancel: function () {}
	});
	d.showModal();
}
$(function(){
    $('.workdatabzylist1:last').css('border-bottom','none');
});
</script>
<?php $this->display('troomv2/page_footer'); ?>