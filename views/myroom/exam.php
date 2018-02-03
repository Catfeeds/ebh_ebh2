<?php $this->display('myroom/page_header'); ?>

<div class="ter_tit">
	当前位置 > <a href="<?= geturl('myroom/exam') ?>">在线作业</a> > 所有习题
	</div>
	<div class="lefrig">
<div class="work_menu">
    <ul>

         <li  class="workcurrent"><a href="<?= geturl('myroom/exam') ?>"><span>所有习题</span></a></li>
		 <li><a href="<?= geturl('myroom/exam/my') ?>"><span>我做过的习题</span></a></li>
         <li><a href="<?= geturl('myroom/exam/errorbook') ?>"><span>我的错题本</span></a></li>
         
    </ul>
</div>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/table.js"></script>
<script type="text/javascript">
						function searchs(folderid,strname){
							var folderid = $('#'+folderid).val();
							var sname = $('#'+strname).val();
							location.href='<?= geturl('myroom/exam')?>?folderid='+folderid+'&q='+encodeURIComponent(sname);
						}
					</script>
                    <div class="work_search">
                    	<table>
                        	<tr>
                           	  <td><label>所属分类</label>
                              <select name="folderid" id="folderid">
                              	<option value="">请选择分类</option>
                              	
								<?php foreach($folders as $folder) { ?>
                            	  <option value="<?= $folder['folderid'] ?>" <?= $folder['folderid'] == $folderid ? 'selected="selected"':''?> ><?= $folder['foldername'] ?></option>
                                <?php } ?>
							
                           	  </select>
                           	  </td>
                                <td><label>作业名称</label><input name="q" id="txtname" value="<?= $q ?>" type="text" /></td>
                                <td><input type="button" onclick="searchs('folderid','txtname');return false;" class="souhuang" value="搜索"></td>
                            </tr>
                        </table>
                    </div>
                   
                    <div class="workdata">
                    	<table width="100%" class="datatab">
										<thead class="tabhead">
										  <tr>
											<th>作业名称</th>
											<th>所属课件</th>
											<th>出题时间</th>
											<th>总分</th>
											<th>操作</th>
										  </tr>
			  							</thead>
										 <tbody>
										 
										 <?php if(!empty($exams)) { ?>
											 <?php foreach($exams as $exam) { ?>
											  <tr>
												<td width="33%" style="color:blue;"><?= shortstr($exam['title'],80) ?></td>
												<td width="30%"><?= shortstr($exam['ctitle'],80) ?></td>
												<td width="20%"><?= date('Y-m-d H:i:s',$exam['dateline']) ?></td>
												<td width="5%"><?= $exam['score'] ?></td>
												<td width="12%">
													<?php if($exam['astatus']==1) { ?>
														<a class="previewBtn" href="http://exam.ebanhui.com/mark/<?= $exam['eid']?>.html" target="_blank"><span>查看结果</span></a>
													<?php } else { ?>
														<a class="previewBtn" href="http://exam.ebanhui.com/do/<?= $exam['eid']?>.html" target="_blank"><span>在线测评</span></a>
													<?php } ?>
												</td>
											  </tr>
											  <?php } ?>
										<?php } else { ?>
 											 <tr>
										 		<td colspan="6" align="center">暂无记录</td>
										 	</tr>
										 <?php } ?>
		  								</tbody>
		  				</table>
		  				<?= $pagestr ?>
                    </div>
</div>

</body>
</html>