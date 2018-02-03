<?php $this->display('troomv2/page_header'); ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<div class="lefrig">
<?php $this->widget('sendmessage_widget', array(), array('room_type' => 'troom')); ?>
<script type="text/javascript" src="http://static.ebanhui.com/exam/js/template/template-native-debug.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<?php $this->display('troomv2/course_menu');?>
<div class="workol" style="float: left;">
<?php if($examPower == '' && !empty($exams)){ ?>
 <div class="workdata" style="width:1000px;">
	    	<table width="100%" class="datatab" style="border:none;">
				 <tbody>
					<?php foreach($exams as $exam) { ?>
						<?php 
							if(!empty($exam['face'])){
								$face = getthumb($exam['face'],'50_50');
							}else{
								if($exam['sex']==1){
									if($exam['groupid']==5){
										$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
									}else{
										$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
									}
								}else{
									if($exam['groupid']==5){
										$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
									}else{
										$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
									}
								}
							
								$face = getthumb($defaulturl,'50_50');
							} 
						?>  
					  <tr class="kettshe">
					  <td style="border-top:none;">
				<div style="float:left;margin-right:15px;">
					<?php
						if(!empty($exam['itemid'])){
							$key = 'f_'.$exam['folderid'];
							$iname = array_key_exists($key, $iteminfo)?$iteminfo[$key]['iname']:"课程";
						}
						$dourl = 'http://exam.ebanhui.com/edo/'.$exam['eid'].'.html';
						$editurl = 'http://exam.ebanhui.com/eedit/'.$exam['crid']."/".$exam['eid'].'.html';
						$viewurl = 'http://exam.ebanhui.com/emark/'.$exam['eid'].'.html';
					?>
				<a href="javascript:;"><img class="radiust" style="width: 50px;height: 50px;" title="<?= empty($exam['realname'])?$exam['username']:$exam['realname'] ?>" src="<?=$face?>" /></a></div>
				<div style="float:left;width:900px;font-family:simsun;">
					<p style="width:760px;word-wrap: break-word;font-size:16px;float:left;line-height:2;">
						<a  href="javascript:;" style="color:#666;font-weight:bold;font-size:16px;">
							<?= $exam['title'] ?>
						</a>
					</p>
					<span style="float:right;width:70px;margin-top:10px">
					<?php if($exam['uid']==$user['uid']){?>
					<a class="previewBtn" style="font-family: 宋体;line-height: 28px;width:72px;height:28px;" href="<?=$editurl?>" target="_blank">作业编辑</a>
					<?php }?>
					</span>
					<div style="float:left;width:790px;">
						<span class="huirenw" style="width:auto;float:left;color:#999;padding-left:0;background:none;">
							<a href="javascript:;" style="float:left;"><?= empty($exam['realname']) ? $exam['username'] : $exam['realname'] ?></a>
							<a class="hrelh" href="javascript:;" tid="<?=$exam['uid']?>" tname="<?= empty($exam['realname'])?$exam['username']:$exam['realname'] ?>" title="给<?=$exam['sex'] == 1 ? '她' : '他'?>发私信"></a> 于
							<?= date('Y-m-d H:i:s',$exam['dateline']) ?> 出题，总分为：<?= $exam['score'] ?>，答题人数：<?=$exam['answercount']?>，<?php if(empty($exam['limitedtime'])){echo '不计时';}else{echo '计时：'.$exam['limitedtime'].' 分钟';}?>
						</span>
						</div>
					</div>
					</td>
					  </tr>
					</tbody>
					<?php } ?>
				</table>
				<?= $pagestr ?>
	   </div>
	<?php }else if($examPower == '1'){ ?>
		<div class="workdata" style="width:1000px;"></div><div id="mpage" style="height:60px;clear:both;"></div>
	<?php } else  { ?>
		<div class="nodata">
		</div>
	<?php } ?>
	</div>
</div>
<script type="text/html" id="t:list">
	<table width="100%" class="datatab" style="border:none;">
	 	<tbody>
	 		<% for(var i=0;i<examList.length;i++){%>
	    	<tr class="kettshe">
	    		<% if(examList.length == (i+1)){%>
					<td style="border-top:none;border-bottom: none;">
				<%}else{%>
					<td style="border-top:none;">
				<%}%>
					<div style="float:left;margin-right:15px;">
						<a href="javascript:;">
							<%if(face == ''){%>
								<%if(sex == '1'){%>
									<img class="radiust" style="width: 50px;height: 50px;" title="<?= empty($user['realname'])?$user['username']:$user['realname'] ?>" src="http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg" />	
								<%}else{%>
									<img class="radiust" style="width: 50px;height: 50px;" title="<?= empty($user['realname'])?$user['username']:$user['realname'] ?>" src="http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg" />	
								<%}%>
							
							<%}else{%>
								<img class="radiust" style="width: 50px;height: 50px;" title="<?= empty($user['realname'])?$user['username']:$user['realname'] ?>" src="<%=face%>" />
							<%}%>
						</a>
					</div>
					<div style="float:left;width:900px;font-family:simsun;">
						<p style="width:760px;word-wrap: break-word;font-size:16px;float:left;line-height:2;">
							<a href="javascript:;" style="color:#666;font-weight:bold;font-size:16px;"><%=examList[i].esubject%></a>
						</p>
						<span style="float:right;width:70px;margin-top:10px">
							<%if(examList[i].etype != "TSMART"){%>
							<a class="previewBtn" style="font-family: 宋体;line-height: 28px;width:72px;height:28px;" href="/troomv2/examv2/edit/<%=examList[i].eid%>.html" target="_blank">作业编辑</a>
							<%}else{%>
								<a class="previewBtn" style="font-family: 宋体;line-height: 28px;width:72px;height:28px;" href="/troomv2/examv2/editsamrt/<%=examList[i].eid%>.html" target="_blank">作业编辑</a>
							<%}%>
						</span>
						<div style="float:left;width:790px;">
							<span class="huirenw" style="width:auto;float:left;color:#999;padding-left:0;background:none;">
								<a href="javascript:;" style="float:left;"><?php echo isset($user['realname'])?$user['realname']:$user['username'];?></a>
								 于
								<%=examList[i].datelineStr%> 出题，总分为：<%=examList[i].examscore%>，答题人数：<%=examList[i].answercount%>，
								<%if(examList[i].limittime == 0){%>
									不计时
								<%}else{%>
									<%=examList[i].limittime%>分钟
								<%}%>					
							</span>
						</div>
					</div>
				</td>
			</tr>
			<%}%>
		</tbody>
	</table>
	
</script>
<script type="text/javascript">
var exampower = '<?=$examPower?>';
var folderid = '<?=$folderid?>';
$(function(){
			function getElist(url){
			if(typeof url == "undefined") {
				url = '/troomv2/examv2/elistAjax.html';
			}
			$.ajax({
				url:url,
				method:'post',
				dataType:'json',
				data : {
					status:1,
					folderid : folderid || ''
				},
				beforeSend:function(XMLHttpRequest){
             	 var loading = '<div style="text-align:center;width:100%;"><img style="width:32px;margin:0 482px;" src="http://static.ebanhui.com/exam/images/loading-2.gif"></div>';
             	 $('.workdata').empty().append(loading);
        	 }
			}).done(function(res){
				if(res.errCode == 133){
					var cmain_bottom = '<div class="cmain_bottom " style="width: 100%;  min-height: 400px;">' +
						'<div class="study" style="margin: 0 auto;border-bottom:none;">' +
							'<div class="nodata" style="width: 205px; margin: 0 auto;"></div>'+
							'<p class="zwktrykc" style="text-align: center;"></p>'+
						'</div>'+
		        	'</div>';
		        	$('#mpage').empty();
		        	$(".workdata").empty().append(cmain_bottom);
				}else{
					$('.workdata').empty();
					var data = {
						examList : res.datas.examList,
						face :     '<?=$user['face']?>',
						sex :  '<?=$user['sex']?>'
					}
					var $dom = $(template('t:list',data));
					$(".workdata").append($dom);
					var $pagedom = $(res.datas.pagestr);
					$pagedom.find('.listPage a').bind('click',function(){
						var url = $(this).attr('data');
						var estype = $('.curr').attr('data');
						if(!!url) {
							getElist(url);
						}
					});
					$("#mpage").empty().append($pagedom);
					parent.resetmain();
				}
				
			}).fail(function(){
				console.log('req err');
			});
		}
		
	if(exampower == '1'){
		getElist();
	}
	//getElist();
    $('.datatab tr:last td').css('border-bottom','none');
    
    
});


</script>
<?php $this->display('myroom/page_footer'); ?>