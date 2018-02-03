<?php $this->display('troom/page_header');?>
<link href="http://exam.ebanhui.com/static/css/base.css" rel="stylesheet" type="text/css" />
<link href="http://exam.ebanhui.com/static/css/done.css" rel="stylesheet" type="text/css" />
<link href="http://exam.ebanhui.com/static/css/public.bak.css" rel="stylesheet" type="text/css" />
<link href="http://exam.ebanhui.com/static/css/jqtransform.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="http://exam.ebanhui.com/static/css/wavplayer.css" rel="stylesheet" />

<style type="text/css">
.delabtn{background:url(http://exam.ebanhui.com/static/images/dela.png) no-repeat;width:79px;height:25px;float:right;cursor:pointer;margin-bottom:5px}
.delahbtn{background:url(http://exam.ebanhui.com/static/images/delah.png) no-repeat;width:79px;height:25px;float:right;cursor:pointer;margin-bottom:5px}

#errlist .que{clear:both;padding:5px 0 25px;height:auto;}
#errlist .que p.desc{font-size:12px;height:35px;line-height: 35px;color:#3a3a3a;display: inline-block;border:1px solid #f3f3f3;background: #f3f3f3;width: 782px;}
#errlist .que p.desc span{display: inline-block;margin-right: 25px;}
#errlist .que p.desc em{margin-right: 8px;}
.work_search ul li {display:inline-block;float: left;height:55px;line-height: 55px;}
#errlist .que .operateBar{display: none;}
#errlist .que .optionContent img{vertical-align: middle;}

#icategory {
    background: none repeat scroll 0 0 #F7FAFF;
    border-top: 1px solid #E1E7F5;
    padding: 6px 20px;
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
    width: 645px;
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
}
.category_cont1 div {
    float: left;
    height: 25px;
    line-height: 22px;
    overflow: hidden;
	padding:0 10px;
}
.pbtns {
    background: url(http://static.ebanhui.com/ebh/tpl/2012/images/sunt0518.png) repeat scroll 0 0 transparent;
    border: medium none;
    color: #333333;
    height: 20px;
    vertical-align: middle;
    width: 40px;
	cursor:pointer;
}
html {
    background: none;
    color: #000;
}
</style>

<div class="ter_tit">
当前位置 > <a href="<?=geturl('troom/statisticanalysis')?>">统计分析</a> > 错题集汇总
		<div class="diles">
			<input name="search" class="newsou" <?php if($q!='请输入错题名称'){echo 'style="color:#000"';}?> id="search" value="<?= $q ?>" type="text" />
			<input type="button" class="soulico" name="searchbutton" id="searchbuttons" value="">
		</div>
</div>

<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:788px;">
	<div id="icategory" class="clearfix" style="border:none;">
			<dt>所属班级：</dt>
			<dd>
				<div class="category_cont1">
					<div>
						<a <?= empty($classid)?'class="curr"':'' ?> href="<?= geturl('troom/statisticanalysis/errors-0-0-0-0-'.$folderid) ?>">所有班级</a>
					</div>
					
					<?php foreach($classlist as $myclass) { ?>
					<div>
						<a <?= $classid==$myclass['classid']?'class="curr"':''?> href="<?= geturl('troom/statisticanalysis/errors-0-0-0-'.$myclass['classid'].'-'.$folderid) ?>"><?= $myclass['classname'] ?></a>
					</div>
					<?php } ?>
				</div>
			</dd>
		</div>
		<!-- ===课程筛选开始=== -->
		<?php if(!empty($folderList)){?>
			<div id="icategory" class="clearfix">
				<dt>所属课程：</dt>
				<dd>
					<div class="category_cont1">
						<div>
							<a <?= empty($folderid)?'class="curr"':'' ?> href="<?= geturl('troom/statisticanalysis/errors-1-0-0-'.$classid) ?>">所有课程</a>
						</div>
						<?php if(!empty($folderList)){?>
							<?php foreach($folderList as $folder) { ?>

							<div>
								<a <?= $folderid==$folder['folderid']?'class="curr"':''?> href="<?= geturl('troom/statisticanalysis/errors-0-0-0-'.$classid.'-'.$folder['folderid']) ?>"><?= $folder['foldername'] ?></a>
							</div>
							<?php } ?>
						<?php }?>
					</div>
				</dd>
			</div>
		<?php }?>
		<!-- ===课程筛选结束=== -->
	
	<?php $qtype=array('A'=>'单选','B'=>'多选','C'=>'填空','D'=>'判断','E'=>'文字','H'=>'主观题'); ?>
	<div class="workol" id="errlist">
		<?php if(!empty($errors)) { ?>
			<?php foreach($errors as $k=>$error) {
				$error['title'] = str_replace("<br>","",$error['etitle']);
				$page = $this->uri->uri_page();
				if(empty($page) || !is_numeric($page))
					$page = 1;
				$k = $k+1+($page-1)*$pagesize;
				$error['erranswers'] = base64str(unserialize($error['erranswers']));
				$error['ques'] = isset($error['ques'][0])?$error['ques'][0]:$error['ques'];
				subjectfix($error);
			?>
				<?php if($error['quetype']=='A') { ?>
					<div class="que singleContainer singleContainerFocused" qsval="<?= $k ?>" id="que">
						<p class="desc"><span><em>作业名称:</em><strong title="<?= $error['title'] ?>"><?= shortstr($error['title'],35)?></strong></span><span><em>添加时间:</em><strong><?= date('Y-m-d H:i',$error['dateline'])?></strong></span><span><em>试题类型:</em><strong><?= $qtype[$error['quetype']]?></strong></span><span><em>答题者:</em><strong><?= empty($error['realname'])?$error['username']:$error['realname']?></strong></span></p>
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
									<p class="radioWrapper" style="display:block; float:left;width:35px;">
									<span class="jqTransformRadioWrapper">
										<a rel="question" class="jqTransformRadio" href="javascript:void(0);"></a>
										<input type="radio" value="" name="question" class="jqTransformHidden"></span>
										<label style="cursor:pointer;"><?= $opid ?></label>
									</p>
									<span class="optionContent" style="display:block; width:650px;"><?= $n ?></span>
									<span class="clearing"></span>
								</li>
								<?php } ?>
								
							</ul>
						</div>
						<div class="userAnswerBar">
			                <ul style="overflow:auto; zoom:1">
			                <li style="float:left;">学生答案：<span class="userAnsLabel"><?= $error['erranswers']?$error['erranswers']:"没填"; ?></span></li>
			                <li style="float:left;"><span class="markFalse">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></li>
			                </ul>
			            </div>
			            <div class="answerBar">正确答案：<span class="answerLabel"><?= $error['ques']['answers'] ?></span></div>
			          	<?=getquesdoc($error)?>

						<div class="operateBar"><div class="delabtn delerror" name="<?= $error['eid'] ?>"></div></div>
					</div>
				<?php } elseif($error['quetype']=="B") { ?>
					<div class="que singleContainer singleContainerFocused " qsval="<?= $k ?>">
						<p class="desc"><span><em>作业名称:</em><strong title="<?= $erro['title']?>"><?= shortstr($error['title'],35)?></strong></span><span><em>添加时间:</em><strong><?= date('Y-m-d H:i',$error['dateline'])?></strong></span><span><em>试题类型:</em><strong><?= $qtype[$error['quetype']]?></strong></span><span><em>答题者:</em><strong><?= empty($error['realname'])?$error['username']:$error['realname']?></strong></span></p>
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
									<span class="optionContent" style="display:block; width:670px;"><?= $n ?></span>
									<span class="clearing"></span>
								</li>
								<?php } ?>
			                </ul>
			            </div>
			            <div class="userAnswerBar">
			                <ul style="overflow:auto; zoom:1">
			                <li style="float:left;">学生答案：<span class="userAnsLabel"><?= $error['erranswers']?$error['erranswers']:"没填"; ?></span></li>
			                <li style="float:left;"><span class="markFalse">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></li>
			                </ul>
			            </div>
			            <div class="answerBar">正确答案：<span class="answerLabel"><?= $error['ques']['answers']?></span></div>
						<?=getquesdoc($error)?>

						<div class="operateBar"><div class="delabtn delerror" name="<?= $error['eid']?>"></div></div>
			        </div>
				
				<?php } else if($error['quetype']=='C') { ?>
					<div class="que singleContainer singleContainerFocused" qsval="<?= $k ?>">
						<p class="desc"><span><em>作业名称:</em><strong title="<?= $error['title'] ?>"><?= shortstr($error['title'],35)?></strong></span><span><em>添加时间:</em><strong><?= date('Y-m-d H:i',$error['dateline']) ?></strong></span><span><em>试题类型:</em><strong><?= $qtype[$error['quetype']] ?></strong></span><span><em>答题者:</em><strong><?= empty($error['realname'])?$error['username']:$error['realname']?></strong></span></p>
			            <div class="blankSubject subjectPane">
				            <span class="stIndex" style="float:left;"><?= $k ?>.</span>
				            <span class="inputBox" style="float:left; width:650px;">
				            <?= preg_replace('/(\#input\#)|(\#img\#)/', '<input type="text" readonly="readonly" maxlength="2147483647" size="20" value="">',trim($error['ques']['subject']))?> 
				            <span class="pointLabel sorceLabel">[<?= $error['score']?>分]</span></span>
				            <span class="clearing"></span>
			            </div>
			            <div class="userAnswerBar">
			                <ul style="overflow:auto; zoom:1">
			                <li style="">学生答案：
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
			          
					   <?=getquesdoc($error)?>
			            <div class="operateBar"><div class="delabtn delerror" name="<?= $error['eid'] ?>"></div></div>
			        </div>
		
				<?php } else if($error['quetype']=='D') {?>
					<div class="que singleContainer singleContainerFocused" qsval="<?= $k ?>">
						<p class="desc"><span><em>作业名称:</em><strong title="<?= $error['title'] ?>"><?= shortstr($error['title'],35) ?></strong></span><span><em>添加时间:</em><strong><?= date('Y-m-d H:i',$error['dateline']) ?></strong></span><span><em>试题类型:</em><strong><?= $qtype[$error['quetype']] ?></strong></span><span><em>答题者:</em><strong><?= empty($error['realname'])?$error['username']:$error['realname']?></strong></span></p>
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
				                <li style="float:left;">学生答案：<span class="userAnsLabel"><?= $error['erranswers']==2?"没填":($error['erranswers']==1?"对":"错") ?></span></li>
				                <li style="float:left;"><span class="markFalse">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></li>
				                </ul>
				            </div>

				            <div class="answerBar">正确答案：<span class="answerLabel"><?= $error['ques']['answers']==1?"对":"错" ?></span></div>
				         
							<?=getquesdoc($error)?>

				        <div class="operateBar"><div class="delabtn delerror" name="<?= $error['eid'] ?>"></div></div>
			        </div>
		
				<?php } else if($error['quetype']=='E') { ?>
					<div class="que singleContainer singleContainerFocused" qsval="<?= $k ?>">
						<p class="desc"><span><em>作业名称:</em><strong title="<?= $error['title'] ?>"><?= shortstr($error['title'],35)?></strong></span><span><em>添加时间:</em><strong><?= date('Y-m-d H:i',$error['dateline']) ?></strong></span><span><em>试题类型:</em><strong><?= $qtype[$error['quetype']] ?></strong></span><span><em>答题者:</em><strong><?= empty($error['realname'])?$error['username']:$error['realname']?></strong></span></p>
			            <div class="subjectPane">
				            <span class="stIndex" style="float:left;"><?= $k ?>. </span>
				            <span class="inputBox" style="float:left; width:650px;">
				            <?= $error['ques']['subject'] ?>
				            <em class="sorceLabel">[<?= $error['score'] ?>分]</em></span>
				            <span class="clearing"></span>
			            </div>
			            <div class="userAnswerBar">
			                <ul style="overflow:auto; zoom:1">
			                <li style="float:left;">学生答案：<span class="userAnsLabel"><?= $error['erranswers']!=""?$error['erranswers']:"没填"; ?></span></li>
			                <li style="float:left;"><span class="markFalse">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></li>
			                </ul>
			            </div>
			            <div class="answerBar">正确答案：<span class="answerLabel"><?= $error['ques']['answers'] ?></span></div>

						<?=getquesdoc($error)?>
			            <div class="operateBar"><div class="delabtn delerror" name="<?= $error['eid'] ?>"></div></div>
			        </div>
				<?php } ?>
	
			<?php } ?>

			<?= $pagestr ?>
		<?php } else { ?>
				 <div style="clear:both;border-top:1px solid #ccc;padding-top:10px;text-align: center;">暂无记录</div>
		<?php } ?>
	</div>
</div>
<script type="text/javascript">
var tip="请输入错题名称";
$(function(){
	initsearch('search',tip);
	$('#searchbuttons').click(function(){
		var href = '<?= geturl('troom/statisticanalysis/errors-0-0-0-'.$classid.'-'.$folderid) ?>';
		if($("#search").val()=='请输入错题名称'){
			var searchvalue = '';
		}else{
			var searchvalue = $("#search").val();
		}
		if(searchvalue=='请输入错题名称'){
			searchvalue='';
		}
		location.href = href+"?q="+searchvalue;
	});

});

</script>
<?php 
$this->display('common/player');
$this->display('troom/page_footer');
?>