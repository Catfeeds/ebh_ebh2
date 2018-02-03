<?php $this->display('troom/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>

<style>
.lefrig .datatab .btnshan{background:url("http://static.ebanhui.com/ebh/tpl/2014/images/delico.jpg") no-repeat center; height:28px; line-height:28px; width:43px; }
</style>
				<div id='atsrc' style="display: none;"></div>
					<div class="ter_tit">
					
<?php $arr = explode('.',$course['cwurl']);
		$type = $arr[count($arr)-1]; ?>
当前位置 > <a href="<?= geturl('troom/classsubject') ?>" ?>课程管理</a> > <a href="<?= geturl('troom/classsubject') ?>" >班级课程</a> > <a href="<?= geturl('troom/classsubject/' . $course['folderid']) ?>"><?= $course['foldername'] ?></a> >  <a href="<?= (empty($course['cwurl']) || $type == 'flv') ? geturl('troom/course/'.$course['cwid']) : geturl('troom/classcourse/'.$course['cwid']) ?>" target="<?= (empty($course['cwurl']) || $type == 'flv') ? '_blank' : '' ?>"><?= $course['title'] ?></a> > 附件管理
<div class="lefrig">
<div class="tiezitool">
<a class="hongbtn jiabgbtn" style="margin-right: 15px;margin-top: -30px;" href="<?= geturl('troom/classcourse/upattach-0-0-0-'.$course['cwid']) ?>">上传附件</a>
</div>
</div>
</div>
<div class="lefrig" style="margin-top:15px;">
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
	
                                                <?php if(!empty($attlist)) { ?>
                                                <?php foreach($attlist as $att) { ?>
                                                    <?php foreach($att as $akey=>$avalue) { ?>
                                                    <tr>
                                                                <?php if($akey == 0) { ?>
									<td style="width:190px; border-bottom: none;" rowspan="<?= count($att)?>"><a target="<?= (empty($avalue['cwurl']) || $type == 'flv') ? '_blank' : '' ?>" href="<?= (empty($avalue['cwurl']) || $type == 'flv') ? geturl('troom/course/'.$course['cwid']) : geturl('troom/classcourse/'.$course['cwid']) ?>"><?= $avalue['ctitle'] ?></a></td>

                                                                <?php } ?>

								<td style="width:200px; border-bottom: none;">

                                                                        <?php if($avalue['suffix'] == 'swf' || $avalue['suffix'] == 'mp3') { ?>
										<a href="javascript:void(0);" class="atfalsh" source="<?= (empty($source) ?$avalue['source']:$source) ?>" title="<?= $avalue['title']?>" suffix="<?= $avalue['suffix'] ?>" aid="<?= $avalue['attid'] ?>" type="button"><?= $avalue['title'] ?></a>

                                                                        <?php } else if($avalue['suffix'] == 'flv') { ?>
										<a  class="atfalsh" source="<?= (empty($source) ?$avalue['source']:$source) ?>" title="<?= $avalue['title']?>" suffix="<?= $avalue['suffix'] ?>" cwid="<?= $course['cwid'] ?>" aid="<?= $avalue['attid'] ?>" href="javascript:void(0);" ><?= $avalue['title'] ?></a>
																		<?php } else{ ?>
										<a href="<?= (empty($source) ?$avalue['source']:$source).'attach.html?attid='.$avalue['attid']?>"><?= $avalue['title'] ?></a>
                                                                        <?php } ?>

								</td>
							    <td style="width:110px; border-bottom: none;"><?= date('Y-m-d',$avalue['dateline']) ?></td>
							    <td style="width:55px; border-bottom: none;">

                                                                <?php if($avalue['status'] == 0) { ?>
										 <font color="#ff6600">未审核</font>

                                                                <?php } else if($avalue['status'] == 1) { ?>
										 <font color="#008000">审核通过</font>
                                                                <?php } else if($avalue['status'] == -1) { ?>
										 <font color="#a7a7a7">审核未通过</font>
                                                                <?php } ?>

		 						</td>
							    <td style="width:50px; border-bottom: none;"><?= $avalue['csize'] ?></td>
							    <td style="width:105px; border-bottom: none;">
								<input type="button" class="workBtn" onclick="location.href='<?= geturl('troom/classcourse/editattach/'.$avalue['attid'])?>'"  value="修改" />
								    <input type="button" class="btnshan delt" style="cursor:pointer;margin:0;" onclick="delattachment(<?= $avalue['attid'] ?>);" value="删除" />
							    </td>
							</tr>
                                                    <?php } ?>
                                                <?php } ?>
                                                <?php } else { ?>
							<tr><td align="center" colspan="6" style=" border-bottom: none;">暂无数据</td></tr>
                                                <?php } ?>

						</tbody>
					</table>
					<div style="margin-top:20px;"><?= $pagestr ?></div>
					</div>
	  <div class="clear"></div>

<script type="text/javascript">
<!--
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
//-->
</script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/play.js?version=20150528001"></script>
<?php $this->display('troom/page_footer'); ?>