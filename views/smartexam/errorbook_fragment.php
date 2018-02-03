<style type="text/css">
	.que{
		overflow:hidden;
	}
	.blankSubject,.subjectPane{
		padding-left: 10px;
	}
</style>
<?php $qtype=array('A'=>'单选','B'=>'多选','C'=>'填空','D'=>'判断','E'=>'文字','H'=>'主观题'); ?>
<?php if(!empty($errors)) { ?>
	<?php foreach($errors as $k=>$error) {
		$error['title'] = str_replace("<br>","",$error['etitle']);
		$page = $this->uri->uri_page();
		if(empty($page) || !is_numeric($page))
			$page = 1;
		$k = $k+1+($page-1)*$pagesize;
		$error['erranswers'] = base64str(unserialize($error['erranswers']));
		if(!empty($error['ques'][0])){
			$error['ques'] = is_array($error['ques'][0])?$error['ques'][0]:$error['ques'];
		}
		subjectfix($error);
	?>
	
		<?php if($error['quetype']=='A') { ?>
			<div class="que singleContainer singleContainerFocused" qsval="<?= $k ?>" id="que">
				<p class="desc"><span><em>作业名称:</em><strong title="<?= $error['title'] ?>"><?= shortstr($error['title'],35)?></strong></span><span><em>添加时间:</em><strong><?= date('Y-m-d H:i',$error['dateline'])?></strong></span><span><em>试题类型:</em><strong><?= $qtype[$error['quetype']]?></strong></span></p>
				<div class="subjectPane">
					<span class="stIndex" style="float:left;"><?= $k ?>. </span>
					<span class="inputBox" style="float:left; width:650px;"><?= $error['ques']['subject']?>（<span class="userAnsLabel" id="txtanswer" style="color:blue;font-weight:bold;padding:0 8px;"></span>）<em class="sorceLabel">[<?= $error['score'] ?>分]</em></span>
					<span class="clearing"></span>
				</div>
				<div class="radioPane">
					<ul>
						<?php foreach($error['ques']['options'] as $m=>$n) { 
							$opid = chr(intval($m)+65);
						?>								
						<li class="radioBox">
							<span class="radioWrapper" style="display:block; float:left">
							<span class="jqTransformRadioWrapper">
								<a rel="question" class="jqTransformRadio" href="javascript:void(0);"></a>
								<input type="radio" value="" name="question" class="jqTransformHidden"></span>
								<label style="cursor:pointer;"><?= $opid ?></label>
							</span>
							<span class="optionContent" style="display:block;float:right; width:925px;"><?= $n ?></span>
							<span class="clearing"></span>
						</li>
						<?php } ?>
					</ul>
				</div>
				<div class="userAnswerBar">
	                <ul style="overflow:auto; zoom:1">
	                <li style="float:left;">我的答案：<span class="userAnsLabel"><?= $error['erranswers']?$error['erranswers']:"没填"; ?></span></li>
	                <li style="float:left;"><span class="markFalse">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></li>
	                </ul>
	            </div>
	            <div class="answerBar">正确答案：<span class="answerLabel"><?= $error['ques']['answers'] ?></span></div>
	           
				<?=getquesdoc($error);?>
				<div class="operateBar"><div class="delabtn delerror" name="<?= $error['eid'] ?>"></div></div>
				<!-- 加上题目关联的知识点 -->
				<?php if(!empty($error['ques']['chapterstxt'])){ ?>
				<div class="chandfo" style="margin:30px 0 0 28px;">
					<div class="chpaterWrap" style="float:">
						所属知识点:<?=$error['ques']['chapterstxt']?>
					</div>
				</div>
				<?php } ?>
			</div>
		<?php } elseif($error['quetype']=="B") { ?>
			<div class="que singleContainer singleContainerFocused " qsval="<?= $k ?>">
				<p class="desc"><span><em>作业名称:</em><strong title="<?= $error['title']?>"><?= shortstr($error['title'],35)?></strong></span><span><em>添加时间:</em><strong><?= date('Y-m-d H:i',$error['dateline'])?></strong></span><span><em>试题类型:</em><strong><?= $qtype[$error['quetype']]?></strong></span></p>
	            <div class="subjectPane">
	                <span class="stIndex" style="float:left;"><?= $k ?>. </span>
	                <span class="inputBox" style="float:left; width:640px;"><?= $error['ques']['subject']?>（<span class="userAnsLabel" style="color:blue;font-weight:bold;padding:0 8px;"></span>）<em class="sorceLabel">[<?=  $error['score'] ?>分]</em></span>
	                <span class="clearing"></span>
	            </div>
	            <div class="radioPane">
	                <ul>
						
						<?php foreach($error['ques']['options'] as $m=>$n) { ?>
						<?php $opid = chr(intval($m)+65); ?>
						<li class="radioBox">
							<span class="radioWrapper" style="display:block; float:left">
							<span class="jqTransformRadioWrapper">
								<a rel="question" class="jqTransformRadio" href="javascript:void(0);"></a>
								<input type="radio" value="" name="question" class="jqTransformHidden"></span>
								<label style="cursor:pointer;"><?= $opid ?></label>
							</span>
							<span class="optionContent" style="display:block; width:954px;"><?= $n ?></span>
							<span class="clearing"></span>
						</li>
						<?php } ?>
	                </ul>
	            </div>
	            <div class="userAnswerBar">
	                <ul style="overflow:auto; zoom:1">
	                <li style="float:left;">我的答案：<span class="userAnsLabel"><?= $error['erranswers']?$error['erranswers']:"没填"; ?></span></li>
	                <li style="float:left;"><span class="markFalse">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></li>
	                </ul>
	            </div>
	            <div class="answerBar">正确答案：<span class="answerLabel"><?= $error['ques']['answers']?></span></div>
	            
				<?=getquesdoc($error);?>
				<div class="operateBar"><div class="delabtn delerror" name="<?= $error['eid']?>"></div></div>
				<!-- 加上题目关联的知识点 -->
				<?php if(!empty($error['ques']['chapterstxt'])){ ?>
				<div class="chandfo" style="margin:30px 0 0 28px;">
					<div class="chpaterWrap" style="float:">
						所属知识点:<?=$error['ques']['chapterstxt']?>
					</div>
				</div>
				<?php } ?>
	        </div>

		<?php } else if($error['quetype']=='C') { ?>
			<div class="que singleContainer singleContainerFocused" qsval="<?= $k ?>">

				<p class="desc"><span><em>作业名称:</em><strong title="<?= $error['title'] ?>"><?= shortstr($error['title'],35)?></strong></span><span><em>添加时间:</em><strong><?= date('Y-m-d H:i',$error['dateline']) ?></strong></span><span><em>试题类型:</em><strong><?= $qtype[$error['quetype']] ?></strong></span></p>
	            <div class="blankSubject subjectPane">
		            <span class="stIndex" style="float:left;"><?= $k ?>.</span>
		            <span class="inputBox" style="float:left; width:650px;">
		            <?= preg_replace('/(\#input\#)|(\#img\#)/', '<input type="text" readonly="readonly" maxlength="2147483647" size="20" value="">',trim($error['ques']['subject']))?> 
		            <span class="pointLabel sorceLabel">[<?= $error['score']?>分]</span></span>
		            <span class="clearing"></span>
	            </div>
	            <div class="userAnswerBar">
	                <ul style="overflow:auto; zoom:1">
	                <li style="">我的答案：
	                	<span class="userAnsLabel">
							<?php 
								$myanswer = '';
								foreach($error['erranswers'] as $m=>$n) {
									$res = preg_match("/(http:\/\/.*?\.png)/is", $n, $matches);
									if($res==1){
										$n = '<img src="'.$matches[1].'">';
									}
									$myanswer .= empty($n)?"没填,":$n.",";
								}
								echo trim($myanswer,',');
							?>
	                	</span>
	               	</li>
	                </ul>
	            </div>
	            <div class="answerBar">正确答案：
	                <span class="answerLabel">
	                	
						<?php 
								$tanswer = '';
								foreach($error['ques']['options'] as $m=>$n) {
									$res = preg_match("/(http:\/\/.*?\.png)/is", $n, $matches);
									if($res==1){
										$n = '<img src="'.$matches[1].'">';
									}
									$tanswer .= $n.",";
								}
								echo trim($tanswer,',');
							?>
	                </span>
	            </div>
	      
			   <?=getquesdoc($error);?>
	            <div class="operateBar"><div class="delabtn delerror" name="<?= $error['eid'] ?>"></div></div>
	            <!-- 加上题目关联的知识点 -->
	            <?php if(!empty($error['ques']['chapterstxt'])){ ?>
				<div class="chandfo" style="margin:30px 0 0 28px;">
					<div class="chpaterWrap" style="float:">
						所属知识点:<?=$error['ques']['chapterstxt']?>
					</div>
				</div>
				<?php } ?>
	        </div>
		<?php } else if($error['quetype']=='D') {?>
			<div class="que singleContainer singleContainerFocused" qsval="<?= $k ?>">
				<p class="desc"><span><em>作业名称:</em><strong title="<?= $error['title'] ?>"><?= shortstr($error['title'],35) ?></strong></span><span><em>添加时间:</em><strong><?= date('Y-m-d H:i',$error['dateline']) ?></strong></span><span><em>试题类型:</em><strong><?= $qtype[$error['quetype']] ?></strong></span></p>
				<div class="questionContainer">
		            <div class="subjectPane">
			            <span class="stIndex" style="float:left;"><?= $k ?>. </span>
			            <span class="inputBox" style="float:left; width:650px;">
			            <?= $error['ques']['subject'] ?>
			            <em class="sorceLabel" >[<?= $error['score'] ?>分]</em></span>
			            <span class="clearing"></span>
		            </div>

		            <div class="userAnswerBar">
			            <div style="float:left;"><span>对错选项：</span></div>
				            <div style="float:left;">
					            <span class="jqTransformRadioWrapper">
					            <a class="jqTransformRadio" href="javascript:void(0);" ></a>
					            <input type="radio" value="true" name="" class="jqTransformHidden"></span>
					            <label for="" style="cursor:pointer;float:left;margin-right:10px;">对</label>

					            <span class="jqTransformRadioWrapper">
					            <a class="jqTransformRadio" href="javascript:void(0);" ></a>
					            <input type="radio" value="false" name="" class="jqTransformHidden"></span>
					            <label for="" style="cursor:pointer;">错</label>
				        	</div>
				            <div class="clearing"></div>
			            </div>
			        </div>


			        <div class="userAnswerBar">
		                <ul style="overflow:auto; zoom:1">
		                <li style="float:left;">我的答案：<span class="userAnsLabel"><?= $error['erranswers']==2?"没填":($error['erranswers']==1?"对":"错") ?></span></li>
		                <li style="float:left;"><span class="markFalse">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></li>
		                </ul>
		            </div>

		            <div class="answerBar">正确答案：<span class="answerLabel"><?= $error['ques']['answers']==1?"对":"错" ?></span></div>

					<?=getquesdoc($error);?>
		        <div class="operateBar"><div class="delabtn delerror" name="<?= $error['eid'] ?>"></div></div>
		        <!-- 加上题目关联的知识点 -->
		        <?php if(!empty($error['ques']['chapterstxt'])){ ?>
				<div class="chandfo" style="margin:30px 0 0 28px;">
					<div class="chpaterWrap" style="float:">
						所属知识点:<?=$error['ques']['chapterstxt']?>
					</div>
				</div>
				<?php } ?>
	        </div>
		<?php } else if($error['quetype']=='E') { ?>
			<div class="que singleContainer singleContainerFocused" qsval="<?= $k ?>">
				<p class="desc"><span><em>作业名称:</em><strong title="<?= $error['title'] ?>"><?= shortstr($error['title'],35)?></strong></span><span><em>添加时间:</em><strong><?= date('Y-m-d H:i',$error['dateline']) ?></strong></span><span><em>试题类型:</em><strong><?= $qtype[$error['quetype']] ?></strong></span></p>
	            <div class="subjectPane">
		            <span class="stIndex" style="float:left;"><?= $k ?>. </span>
		            <span class="inputBox" style="float:left; width:650px;">
		            <?= $error['ques']['subject'] ?>
		            <em class="sorceLabel">[<?= $error['score'] ?>分]</em></span>
		            <span class="clearing"></span>
	            </div>
	            <div class="userAnswerBar">
	                <ul style="overflow:auto; zoom:1">
	                <li style="float:left;">我的答案：<span class="userAnsLabel"><?= $error['erranswers']!=""?$error['erranswers']:"没填"; ?></span></li>
	                <li style="float:left;"><span class="markFalse">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></li>
	                </ul>
	            </div>
	            <div class="answerBar">正确答案：<span class="answerLabel"><?= $error['ques']['answers'] ?></span></div>
				<?php if(!empty($error['ques']['resolve'])) {?>
	            	<div class="title answerBar">答案解析：<div class="resolve inputBox" style="width:885px;float:right;"><?= $error['ques']['resolve'] ?></div><div class="clearing"></div></div>
				<?php } ?>
				
				<?=getquesdoc($error);?>
	            <div class="operateBar"><div class="delabtn delerror" name="<?= $error['eid'] ?>"></div></div>
	            <!-- 加上题目关联的知识点 -->
	            <?php if(!empty($error['ques']['chapterstxt'])){ ?>
				<div class="chandfo" style="margin:30px 0 0 28px;">
					<div class="chpaterWrap" style="float:">
						所属知识点:<?=$error['ques']['chapterstxt']?>
					</div>
				</div>
				<?php } ?>
	        </div>
		<?php } ?>
	<?php } ?>

	<?= $pagestr ?>
<?php } else { ?>
		 
<?php } ?>
<div style="clear:both;" class="nodata"></div>

<script type="text/javascript">
	$(".delerror").click(function(){
		var eid = $(this).attr("name");
		$.confirm("您确认要删除此错题吗？",function(){
			var url = "<?= geturl('smartexam/myerrorbook/del') ?>";
			$.ajax({
				type: "POST",
				url: url,
				data: {'eid':eid},
				dataType : "text",
				success: function(msg){
					if(msg == "success") {
						alert("错题删除成功");
						page_load(1);
					} else {
						alert("错题删除失败");
					}
				}
			});
		});
	});
</script>