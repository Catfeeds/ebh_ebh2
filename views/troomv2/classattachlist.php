<?php $this->display('troomv2/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>

<style>
.lefrig .datatab .btnshan{background:url("http://static.ebanhui.com/ebh/tpl/2014/images/delico.jpg") no-repeat center; height:28px; line-height:28px; width:43px; }
.lefrig a.jiabgbtn, .lefrig input.jiabgbtn{ border-radius: 3px;cursor: pointer;}
</style>
					
<?php $arr = explode('.',$course['cwurl']);
		$type = $arr[count($arr)-1]; ?>
<div class="lefrig">
<?php $this->display('troomv2/course_menu');?>
<div class="tiezitool">
<a class="hongbtn jiabgbtn" style="margin-right: 15px;position: relative;top: -30px;background: #5e96f5 none !important;" href="<?= geturl('troomv2/classcourse/upattach-0-0-0-'.$course['cwid']) ?>">上传附件</a>
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
	
                                                <?php if(!empty($attlist)) { ?>
                                                <?php foreach($attlist as $att) { ?>
                                                    <?php foreach($att as $akey=>$avalue) { ?>
                                                    <tr>
                                                                <?php if($akey == 0) { ?>
									<td width="26%" style="border-bottom: none;" rowspan="<?= count($att)?>"><a target="<?= (empty($avalue['cwurl']) || $type == 'flv') ? '_blank' : '' ?>" href="<?= (empty($avalue['cwurl']) || $type == 'flv') ? geturl('troomv2/course/'.$course['cwid']) : geturl('troomv2/classcourse/'.$course['cwid']) ?>"><?= $avalue['ctitle'] ?></a></td>

                                                                <?php } ?>

								<td width="29%" style=" border-bottom: none;">

                                                                        <?php if($avalue['suffix'] == 'swf' || $avalue['suffix'] == 'mp3') { ?>
										<a href="javascript:void(0);" class="atfalsh" source="<?= (empty($source) ?$avalue['source']:$source) ?>" title="<?= $avalue['title']?>" suffix="<?= $avalue['suffix'] ?>" aid="<?= $avalue['attid'] ?>" type="button"><?= $avalue['title'] ?></a>
										<?php if($roominfo['domain'] == 'svn1') { ?>
										<br />地址： http://u1.ebh.net/file/swf/<?= $avalue['attid']?>.html
										<?php } ?>

                                                                        <?php } else if($avalue['suffix'] == 'flv') { ?>
										<a  class="atfalsh" source="<?= (empty($source) ?$avalue['source']:$source) ?>" title="<?= $avalue['title']?>" suffix="<?= $avalue['suffix'] ?>" cwid="<?= $course['cwid'] ?>" aid="<?= $avalue['attid'] ?>" href="javascript:void(0);" ><?= $avalue['title'] ?></a>
																		<?php } else{ ?>
										<a href="<?= (empty($source) ?$avalue['source']:$source).'attach.html?attid='.$avalue['attid']?>"><?= $avalue['title'] ?></a>
                                                                        <?php } ?>

								</td>
							    <td width="11%" style=" border-bottom: none;text-align:center;"><?= date('Y-m-d',$avalue['dateline']) ?></td>
							    <td width="10%" style="border-bottom: none;text-align:center;">

                                                                <?php if($avalue['status'] == 0) { ?>
										 <font color="#ff6600">未审核</font>

                                                                <?php } else if($avalue['status'] == 1) { ?>
										 <font color="#008000">审核通过</font>
                                                                <?php } else if($avalue['status'] == -1) { ?>
										 <font color="#a7a7a7">审核未通过</font>
                                                                <?php } ?>

		 						</td>
							    <td width="10%" style="border-bottom: none;text-align:center;"><?= $avalue['csize'] ?></td>
							    <td width="14%" style="border-bottom: none;text-align:center;">
									<a class="xiaust" style="margin-left:24px;" onclick="location.href='<?= geturl('troomv2/classcourse/editattach/'.$avalue['attid'])?>?classid=<?=$this->input->get('classid')?>'" style="display:inline;" href="javascript:;">
									</a>
									<a class="shansge" onclick="delattachment(<?= $avalue['attid'] ?>);" style="display:inline;" href="javascript:;">
									</a>
									
							    </td>
							</tr>
                                                    <?php } ?>
                                                <?php } ?>
                                                <?php } else { ?>
							<tr><td align="center" colspan="6" style="border-top:none;"><div style="text-align:center;" class="nodata"></div></td></tr>
                                                <?php } ?>

						</tbody>
					</table>
					<div style="margin-top:20px;"><?= $pagestr ?></div>
					</div>
	  <div class="clear"></div>

<script type="text/javascript">
<!--
function delattachment(attid){
	var d = top.dialog({
        title: '确定删除',
        content: '确认删除该附件吗？',
        okValue: '确定',
        ok: function () {
		var url = "<?= geturl('troomv2/classcourse/delattach') ?>";
		$.ajax({
			url:url,
			type:'post',
			data:{'attid':attid},
			dataType:'text',
			success:function(data){
				if($.trim(data)=='success'){
					dialog({
						skin:"ui-dialog2-tip",
						content: "<div class='TPic'></div><p>附件删除成功！</p>",
						width:350,
						onshow:function () {
							var that=this;
							setTimeout(function() {
								location.reload();
								that.close().remove();
							}, 1000);
						}
					}).show();
				}else{
					dialog({
						skin:"ui-dialog2-tip",
						content: "<div class='TPic'></div><p>附件删除失败！</p>",
						width:350,
						onshow:function () {
							var that=this;
							setTimeout(function() {
								location.reload();
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
//-->
</script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/play.js?version=20150528001"></script>
<?php $this->display('troomv2/page_footer'); ?>