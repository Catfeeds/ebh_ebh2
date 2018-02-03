<?php $this->display('myroom/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/table.js"></script>
<div class="ter_tit">
	当前位置 > <a href="<?= geturl('myroom/exam') ?>">在线作业</a> > 我的错题本
	</div>
	<div class="lefrig">
<div class="work_menu">
    <ul>
		 <li><a href="<?= geturl('myroom/exam')?>"><span>所有习题</span></a></li>
         <li><a href="<?= geturl('myroom/exam/my') ?>"><span>我做过的习题</span></a></li>
         <li class="workcurrent"><a href="<?= geturl('myroom/exam/errorbook') ?>"><span>我的错题本</span></a></li>
         
    </ul>
</div>

						<?php
							$qtype=array('A'=>'单选','B'=>'多选','C'=>'填空','D'=>'判断','E'=>'文字');
							$truefalse=array(1=>'对',0=>'错');
							?>
                    <div class="workdata">
                    	<table width="100%" class="datatab">
										<thead class="tabhead">
										  <tr>
											<th>作业名称</th>
											<th>题目</th>
											<th>题型</th>
											<th>所填答案（选项）</th>
											<th>添加时间</th>
											<th>操作</th>
										  </tr>
			  							</thead>
										 <tbody>
										 <?php if(!empty($errors)) { ?>
											 <?php foreach($errors as $error) {?>
											  <tr>
												<td width="140px" style="color:blue;"><?= shortstr($error['title'],80) ?></td>
												<td width="140px"><?= shortstr($error['subject'],80) ?><span style="color:#768898">(第<?= $error['qid']?>题)</td>
												<td width="25px"><?= $qtype[$error['type']] ?></td>
												<td width="">
													<?php if(is_array($exam['erroranswers'])) { ?>
														<?php foreach($exam['erranswers'] as $answer) { ?>
															<?= $answer ?> &nbsp;
														<?php } ?>
													<?php } else { ?>
														<?php if($error['type'] == 'D') { ?>
															<?= $truefalse[$error['erranswers']] ?>
														<?php } else { ?>
															<?= $error['erranswers'] ?>
														<?php } ?>
													<?php } ?>
												</td>
												<td width="120px"><?= date('Y-m-d H:i:s',$error['dateline']) ?></td>
												<td width="">
													<a class="workBtn" href="http://exam.ebanhui.com/mark/<?= $error['exid'] ?>.html#<?= $error['qid'] ?>" target="_blank"><span>查看试卷</span></a>
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
<?php $this->display('myroom/page_footer'); ?>