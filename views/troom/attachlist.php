<?php $this->display('troom/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
				<div id='atsrc' style="display: none;"></div>
					<div class="ter_tit">
当前位置 > 附件管理
</div>
<div class="lefrig">
<div class="annotate">在此页面中,教师可以进行修改和删除附件的操作.
			</div>
                    <table width="100%" class="datatab">
						<thead class="tabhead">
							  <tr>
								<th width="26%">所属课件</th>
								<th width="29%">附件名称</th>
								<th width="11%">上传日期</th>
								<th width="10%">审核状态</th>
	                            <th width="10%">附件大小</th>
	                            <th width="14%">操作</th>
							  </tr>
						</thead>
						<tbody class="tabcont">
						
                                                <?php if(!empty($attlist)) { 
													if($roominfo['isschool'] == 3 || $roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {
														$coursepath = 'classcourse';
													  } else if ($roominfo['isschool'] == 2){
														$coursepath = 'classcourse';
													  }else {
														$coursepath = 'course';
													  }
												?>
                                                <?php foreach($attlist as $att) { ?>
                                                    <?php foreach($att as $akey=>$avalue) { ?>
                                                    <tr>
										<?php $arr = explode('.',$avalue['cwurl']);
												$type = $arr[count($arr)-1]; ?>
                                                                <?php if($akey == 0) { ?>
									<td style="width:190px;" rowspan="<?= count($att)?>"><a target="<?= (empty($avalue['cwurl']) || $type == 'flv') ? '_blank' : '' ?>" href="<?= (empty($avalue['cwurl']) || $type == 'flv') ? geturl('troom/course/'.$avalue['cwid']) : geturl('troom/'.$coursepath.'/'.$avalue['cwid']) ?>"><?= $avalue['ctitle'] ?></a></td>
		
                                                                <?php } ?>
						
								<input type="hidden" id="aid$v2['attid']" value="$v2['attid']" />
								<td style="width:200px;">
							
                                                                        <?php if($avalue['suffix'] == 'swf' || $avalue['suffix'] == 'mp3') { ?>
										<a href="javascript:void(0);" class="atfalsh" source="<?= (empty($source) ?$avalue['source']:$source) ?>" title="<?= $avalue['title']?>" suffix="<?= $avalue['suffix'] ?>" aid="<?= $avalue['attid'] ?>" type="button"><?= $avalue['title'] ?></a>
																		 <?php } elseif($avalue['suffix'] == 'flv') { ?>
<a class="atfalsh" href="javascript:void(0);" source="<?= (empty($source) ?$avalue['source']:$source) ?>" title="<?= $avalue['title']?>" suffix="<?= $avalue['suffix'] ?>" cwid="<?= $avalue['cwid'] ?>" aid="<?= $avalue['attid'] ?>" ><?= $avalue['title'] ?></a>
                                                                        <?php } else { ?>
										<a class="atfalsh" href="<?=(empty($source) ?$avalue['source']:$source).'attach.html?attid='.$avalue['attid']?>"><?= $avalue['title'] ?></a>
                                                                        <?php } ?>
				
								</td>
							    <td style="width:110px;"><?= date('Y-m-d',$avalue['dateline']) ?></td>
							    <td style="width:55px;">
						
                                                                <?php if($avalue['status'] == 0) { ?>
										 <font color="#ff6600">未审核</font>
					
                                                                <?php } else if($avalue['status'] == 1) { ?>
										 <font color="#008000">审核通过</font>
                                                                <?php } else if($avalue['status'] == -1) { ?>
							
										 <font color="#a7a7a7">审核未通过</font>
                                                                <?php } ?>
		
		 						</td>
							    <td style="width:50px;"><?= $avalue['csize'] ?></td>
							    <td style="width:105px;">
								<input type="button" class="workBtn" onclick="location.href='<?= geturl('troom/course/editattach/'.$avalue['attid'])?>'"  value="修改" />
								    <input type="button" class="btnshan delt" style="cursor:pointer;margin:0;" onclick="delattachment(<?= $avalue['attid'] ?>);" value="删除" />
							    </td>
							</tr>
                                                    <?php } ?>
                                                <?php } ?>
                                                <?php } else { ?>
							<tr><td align="center" colspan="6">暂无数据</td></tr>
                                                <?php } ?>

						</tbody>
					</table>
					<div style="margin-top:20px;"><?= $pagestr ?></div>
					</div>
	  <div class="clear"></div>

<script type="text/javascript">
function delattachment(attid){
	$.confirm("确认删除该附件吗？",function(){
		var url = "<?= geturl('troom/classcourse/delattach') ?>";
		$.ajax({
			url:url,
			type:'post',
			data:{'attid':attid},
			dataType:'text',
			success:function(data){
				if($.trim(data)=='success'){
					$.showmessage({
						img		 : 'success',
						message  :  '附件删除成功',
						title    :      '附件删除      成功',
						timeoutspeed    :       500,
						callback :    function(){
							location.reload();
						}
					});
				}else{
					$.showmessage({
						img		 : 'error',
						message  :  '附件删除失败',
						title    :      '附件删除      失败'
					});
				}
			}
		});
	});
}
function checkatt(){
	var path = $("#up\\[upfilepath\\]").val();
	if(path==''){
		$("#att_msg").html("<font color='red'>请上传附件文件。</font>");
		return false;	
	}
	$("#att_msg").html("请上传附件文件。");
	return true;
}

function checktit(){
	var title = $("#title").val();
	if(title==''){
		$("#atttitle_msg").html("<font color='red'>附件标题不能为空。</font>");
		return false;
	}
	$("#atttitle_msg").html("请输入附件标题。");
	return true;
}

function check_attachment(noattmsg){
	if(noattmsg == 'noatt'){
		if(checktit()!=true){
			return false;
		}
	}else{
		if(checkatt()!=true || checktit()!=true){
			return false;
		}
	}

	return true;
}
</script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/play.js"></script>
<?php $this->display('troom/page_footer'); ?>