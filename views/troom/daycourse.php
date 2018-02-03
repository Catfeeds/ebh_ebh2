<?php $this->display('troom/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
	<div class="ter_tit">
		当前位置 > <a href="<?= geturl('troom/classsubject') ?>" ?>课程管理</a> > <a href="<?= geturl('troom/classsubject/courses') ?>">班级课程</a>
			
		</div>
	<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:788px;">

	
	<?php if(empty($subfolderlist)){?>
		<table width="100%" class="datatab" style="border:none;">
			<tbody class="tabhead">
			<tr>
			<th width="18%">所属目录</th>
			<th width="25%">课件名称</th>
			<th width="12%">上传日期</th>
			<th width="12%">所属教师</th>
			<th width="33%" style="text-align:center">操作</th>
			</tr>
			</tbody>
			<tbody>
		  	
                            <?php if(!empty($sectionlist)) { ?>
                                <?php foreach($sectionlist as $section) { 
                                    foreach($section as $ckey=>$course) {
                                    ?>
				  <tr>
				  
                                        <?php if($ckey == 0) { ?>
						<td rowspan="<?= count($section) ?>"><?= $course['sname'] ?></td>
                                        <?php } ?>
					
					
				    <td>
					<?php $arr = explode('.',$course['cwurl']);
							$type = $arr[count($arr)-1]; 
							if($type != 'flv' && $course['ism3u8'] == 1)
								$type = 'flv';
							if($type == 'mp3')
								$type = 'flv';
					?>
                                        <?php if(!empty($course['attachmentnum'])) { ?>
					    		<img alt="此课件包含附件"  src="http://static.ebanhui.com/ebh/tpl/default/images/fujian.gif"/>(<?= $course['attachmentnum'] ?>)
                                        <?php } ?>
				    	<a target="<?= (empty($course['cwurl']) || $type == 'flv') ? '_blank' : '' ?>" href="<?= (empty($course['cwurl']) || $type == 'flv') ? geturl('troom/course/'.$course['cwid']) : geturl('troom/classcourse/'.$course['cwid']) ?>"><?= $course['title'] ?></a>
				    </td>
				    <td><?= date('Y-m-d',$course['dateline']) ?></td>
				    <td>
					 	<?= $course['realname'] ?>
				    </td>
				    <td>
						<?php if(!empty($course['attachmentnum'])) { ?>
					 			<a class="previewBtn" href="<?= geturl('troom/classattachlist-0-0-0-'.$course['cwid'])?>">附件管理</a>
                                                        <?php } else { ?>
					 			<a class="previewBtn" href="<?= geturl('troom/classcourse/upattach-0-0-0-'.$course['cwid']) ?>">上传附件</a>
					 		<?php } ?>
	<input type="button" class="previewBtn" style="cursor:pointer;vertical-align: middle;font-weight:100;" onclick="window.open('http://exam.ebanhui.com/enew/<?=$roominfo['crid']?>/0/<?=$course['folderid']?>/<?=$course['cwid']?>.html','_blank')" value="布置作业" />
					    		<input type="button" class="replyBtn" style="cursor:pointer;vertical-align: middle;font-weight:100;" onclick="location.href='<?= geturl('troom/classcourse/edit-0-0-0-'.$course['cwid'])?>'" value="修改" />
				    		<input type="button" class="replyBtn" style="cursor:pointer;vertical-align: middle;font-weight:100;"  onclick="delkj(<?= $course['cwid'] ?>,'<?= str_replace('\'','\\\'',$course['title']) ?>')" value="删除" />
					</td>
				
				  </tr>
                                    <?php } ?>
                                <?php } ?>
	
                            <?php } else { ?>

		  		<tr>
		  			<td colspan="7" align="center" width="100%" >暂无记录</td>
		  		</tr>
                            <?php } ?>

		</tbody>
	</table>
	<?php }?>
	
</div>

  	<script type="text/javascript">
		function delkj(cwid,title){
			$.confirm("确认删除课件[ " + title +" ]吗？",function(){
				var url = "/troom/classcourse/del.html";
                                $.ajax({
                                    type: "POST",
                                    url: url,
                                    data: {'cwid':cwid},
                                    dataType:"json",
                                    success: function(data){
                                      if(data.status == 1) {
                                           $.showmessage({
                                               img : 'success',
                                               message:'课件删除成功',
                                               title:'课件删除成功',
                                               callback :function(){
                                                   location.reload();
                                               }
                                          });
                                      } else {
                                          $.showmessage({
                                               img : 'error',
                                               message:'课件删除失败',
                                               title:'课件删除失败'
                                          });
                                      }
                                    }
                                 }); 
			});
		
		}
	</script>
<?php $this->display('troom/page_footer'); ?>