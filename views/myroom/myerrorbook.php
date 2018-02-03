<?php $this->display('myroom/page_header'); ?>
<link href="http://exam.ebanhui.com/static/css/done.css" rel="stylesheet" type="text/css" />
<link href="http://exam.ebanhui.com/static/css/public.bak.css" rel="stylesheet" type="text/css" />
<link href="http://exam.ebanhui.com/static/css/jqtransform.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="http://exam.ebanhui.com/static/css/wavplayer.css" rel="stylesheet" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<style type="text/css">
.delabtn{background:url(http://exam.ebanhui.com/static/images/dela.png) no-repeat;width:79px;height:25px;float:right;cursor:pointer;margin-bottom:5px}
.delahbtn{background:url(http://exam.ebanhui.com/static/images/delah.png) no-repeat;width:79px;height:25px;float:right;cursor:pointer;margin-bottom:5px}

#errlist .que{clear:both;padding:5px 0 25px;height:auto;}
#errlist .que p.desc{font-size:12px;height:35px;line-height: 35px;color:#3a3a3a;display: inline-block;border:1px solid #f3f3f3;background: #f3f3f3;width: 782px;}
#errlist .que p.desc span{display: inline-block;margin-right: 25px;}
#errlist .que p.desc em{margin-right: 8px;}
.work_search ul li {display:inline-block;float: left;height:55px;line-height: 55px;}

#errlist .que .optionContent img{vertical-align: middle;}
</style>
<div class="ter_tit">
当前位置 > 我的错题本
	<div class="diles">
	<?php
		$q= empty($q)?'':$q;
		if(!empty($q)){
			$stylestr = 'style="color:#000"';
		}else{
			$stylestr = "";
		}
	?>
	<input name="title" <?=$stylestr?> class="newsou" id="title" value="<?=$q?>" type="text" />
	<input onclick="searchs('title')" type="button" class="soulico" value="">
</div>
</div>

<script type="text/javascript">
	function searchs(strname){

		var sname = $('#'+strname).val();
		if(sname == '请输入搜索关键字'){
			sname="";
		}

		// var sdate = $("#sdate").val();
		// var edate = $("#edate").val();
		// url = '<?= geturl('myroom/myerrorbook')?>?q='+sname+'&sdate='+sdate+'&edate='+edate;
		url = '<?= geturl('myroom/myerrorbook')?>?q='+sname;
		location.href = url;
	}

	var parseimg = function(url){
		return "<img src='"+url+"'/>";
	}
	var parseflash = function(url,param){
		var	objhtml ='<!--begin flash-->'
		objhtml +='<!--url:'+url+'-->'
		objhtml +='<!--width:'+param.width+'-->'
		objhtml +='<!--height:'+param.height+'-->'
		objhtml +='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="'+param.width+'px" height="'+param.height+'px" id="Main">'
		objhtml +='<param name="wmode" value="transparent" />';
		objhtml +='<param name="movie" value="'+url+'" />'
		objhtml +='<param name="quality" value="high" />'
		objhtml +='<param name="bgcolor" value="#869ca7" />'
		objhtml +='<param name="allowScriptAccess" value="sameDomain" />'
		objhtml +='<param name="allowFullScreen" value="true" />'
		objhtml +='<!--[if !IE]>-->'
		objhtml +='<object type="application/x-shockwave-flash" data="'+url+'" width="'+param.width+'px" height="'+param.height+'px">'
		objhtml +='<param name="quality" value="high" />'
		objhtml +='<param name="bgcolor" value="#869ca7" />'
		objhtml +='<param name="allowScriptAccess" value="sameDomain" />'
		objhtml +='<param name="allowFullScreen" value="true" />'
		objhtml +='<!--<![endif]-->'
		objhtml +='<!--[if gte IE 6]>-->'
		objhtml +='<p>' 
		objhtml +='Either scripts and active content are not permitted to run or Adobe Flash Player version'
		objhtml +='10.0.0 or greater is not installed.'
		objhtml +='</p>'
		objhtml +='<!--<![endif]-->'
		objhtml +='<a href="http://www.adobe.com/go/getflashplayer">'
		//objhtml +='<img src="/static/images/get_flash_player.gif" alt="Get Adobe Flash Player" />'
		objhtml +='</a>'
		objhtml +='<!--[if !IE]>-->'
		objhtml +='</object>'
		objhtml +='<!--<![endif]-->'
		objhtml +='</object><!--end flash-->'

		return objhtml;	
	}
	var parseaudio = function(url){
		var	objhtml ='<!--begin audio-->'
		objhtml +='<!--url:'+url+'-->'
		if(window.isMobile){
			var style = (browser=='iPad' || browser=='iPhone'|| browser=='iPod')?'style="height:40px"':'';
			objhtml +='<audio src="'+url+'" controls="controls" preload="preload" '+style+'>您的浏览器不支持,请您尝试升级到最新版本。</audio>';
		}else{
			objhtml += '<object type="application/x-shockwave-flash" data="/static/flash/dewplayer-bubble.swf?mp3='+encodeURIComponent(url)+'" width="250" height="65">';
			objhtml +='<param name="wmode" value="transparent" />';
			objhtml +='<param name="movie" value="/static/flash/dewplayer-bubble.swf?mp3='+encodeURIComponent(url)+'" />';
			objhtml +='</object>';
		}
		objhtml +='<!--end audio-->'
		return objhtml;	
	}
</script>

<!-- 主要内容 -->
<div class="lefrig" style="border:solid 1px #cdcdcd;background:#fff;float:left;margin-top:15px;width:786px;">
	
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
				if(!empty($error['ques'][0])){
					$error['ques'] = is_array($error['ques'][0])?$error['ques'][0]:$error['ques'];
				}
				if(stripos($error['ques']['subject'],"<object")!==false && stripos($error['ques']['subject'],"http://")===false) {
					$pattern = '/\/static\/flash\/dewplayer-bubble.swf/is';
					$error['ques']['subject'] = preg_replace($pattern, 'http://exam.ebanhui.com/static/flash/dewplayer-bubble.swf', $error['ques']['subject']);
				}
				if(stripos($error['ques']['subject'],"<img")!==false && stripos($error['ques']['subject'],"http://")===false) {
					$error['ques']['subject'] = preg_replace('/\/uploads\//', 'http://exam.ebanhui.com/uploads/', $error['ques']['subject']);
				}
				if(preg_match('/[\)\）]$/s',trim(strip_tags($error['ques']['subject'])))!==false) {
					$error['ques']['subject'] = preg_replace('/）/s', ')', $error['ques']['subject']);
					$error['ques']['subject'] = preg_replace('/（/s', '(', $error['ques']['subject']);
					$error['ques']['subject'] = preg_replace('/\([^\)]+\)$/', '', $error['ques']['subject']);
				}
				$error['ques']['subject'] = trim(str_replace("<br>","",$error['ques']['subject']));
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
								<?= $error['erranswers'] ?>
								
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
									<span class="optionContent" style="display:block; width:650px;"><?= $n ?></span>
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
			           
			           	<?php if(!empty($error['ques']['fenxi'])){ ?>	
						<div class="title answerBar">分析:<div class="resolve inputBox" style="float:right;width:600px;"><?=$error['ques']['fenxi']?></div><div class="clearing"></div></div>
						<?php } ?>
						
						<?php if(!empty($error['ques']['resolve'])) { ?>
			            	<div class="title answerBar">解答：<div class="resolve inputBox" style="width:645px;float:right;"><?= $error['ques']['resolve'] ?></div><div class="clearing"></div></div>
						<?php } ?>
			           
			           	<?php if(!empty($error['ques']['dianpin'])){ ?>	
						<div class="title answerBar">点评:<div class="resolve inputBox" style="float:right;width:600px;"><?=$error['ques']['dianpin']?></div><div class="clearing"></div></div>
						<?php } ?>
			           
						<?php if(!empty($error['ques']['cwid'])) { ?>
	                		<div class="title answerBar">课件解析：<div class="resolve inputBox" style="float:right; width:600px;"><a onclick="userplay('http://www.ebanhui.com/',<?= $error['ques']['cwid'] ?>);return false;" href="javascript:void(0);"><img src="http://exam.ebanhui.com/static/images/playcourseware.jpg"></a></div><div class="clearing"></div></div>
						<?php } ?>
						
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
									<span class="optionContent" style="display:block; width:670px;"><?= $n ?></span>
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
						
						<?php if(!empty($error['ques']['fenxi'])){ ?>	
						<div class="title answerBar">分析:<div class="resolve inputBox" style="float:right;width:600px;"><?=$error['ques']['fenxi']?></div><div class="clearing"></div></div>
						<?php } ?>
						
						<?php if(!empty($error['ques']['resolve'])) { ?>
			            	<div class="title answerBar">解答：<div class="resolve inputBox" style="width:645px;float:right;"><?= $error['ques']['resolve'] ?></div><div class="clearing"></div></div>
			            <?php } ?>
						
						<?php if(!empty($error['ques']['dianpin'])){ ?>	
						<div class="title answerBar">点评:<div class="resolve inputBox" style="float:right;width:600px;"><?=$error['ques']['dianpin']?></div><div class="clearing"></div></div>
						<?php } ?>
						
						<?php if(!empty($error['ques']['cwid'])) { ?>
	                		<div class="title answerBar">课件解析：<div class="resolve inputBox" style="float:right; width:600px;"><a onclick="userplay('http://www.ebanhui.com/',<?= $error['ques']['cwid']?>);return false;" href="javascript:void(0);"><img src="http://exam.ebanhui.com/static/images/playcourseware.jpg"></a></div><div class="clearing"></div></div>
						<?php } ?>
						
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
			            
			            <?php if(!empty($error['ques']['fenxi'])){ ?>	
						<div class="title answerBar">分析:<div class="resolve inputBox" style="float:right;width:885px;"><?=$error['ques']['fenxi']?></div><div class="clearing"></div></div>
						<?php } ?>
						
						 <?php if(!empty($error['ques']['resolve'])) { ?>
			            	<div class="title answerBar">解答：<div class="resolve inputBox" style="width:645px;float:right;"><?= $error['ques']['resolve'] ?></div><div class="clearing"></div></div>
						<?php } ?>
			            
			            <?php if(!empty($error['ques']['dianpin'])){ ?>	
						<div class="title answerBar">点评:<div class="resolve inputBox" style="float:right;width:885px;"><?=$error['ques']['dianpin']?></div><div class="clearing"></div></div>
						<?php } ?>
			            
						<?php if(!empty($error['ques']['cwid'])) {?>
	                		<div class="title answerBar">课件解析：<div class="resolve inputBox" style="float:right; width:553px;"><a onclick="userplay('http://www.ebanhui.com/',<?= $error['ques']['cwid'] ?>);return false;" href="javascript:void(0);"><img src="http://exam.ebanhui.com/static/images/playcourseware.jpg"></a></div><div class="clearing"></div></div>
						<?php } ?>
						
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
							
							<?php if(!empty($error['ques']['fenxi'])){ ?>	
							<div class="title answerBar">分析:<div class="resolve inputBox" style="float:right;width:885px;"><?=$error['ques']['fenxi']?></div><div class="clearing"></div></div>
							<?php } ?>
							
							<?php if(!empty($error['ques']['resolve'])) {?>
				            	<div class="title answerBar">解答：<div class="resolve inputBox" style="width:645px;float:right;"><?= $error['ques']['resolve'] ?></div><div class="clearing"></div></div>
							<?php } ?>
							
							<?php if(!empty($error['ques']['dianpin'])){ ?>	
							<div class="title answerBar">点评:<div class="resolve inputBox" style="float:right;width:885px;"><?=$error['ques']['dianpin']?></div><div class="clearing"></div></div>
							<?php } ?>
							
							<?php if(!empty($error['ques']['cwid'])) { ?>
	                		<div class="title answerBar">课件解析：<div class="resolve inputBox" style="float:right; width:553px;"><a onclick="userplay('http://www.ebanhui.com/',<?= $error['ques']['cwid']?>);return false;" href="javascript:void(0);"><img src="http://exam.ebanhui.com/static/images/playcourseware.jpg"></a></div><div class="clearing"></div></div>
							<?php } ?>
							
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
						
						<?php if(!empty($error['ques']['fenxi'])){ ?>	
							<div class="title answerBar">分析:<div class="resolve inputBox" style="float:right;width:600px;"><?=$error['ques']['fenxi']?></div><div class="clearing"></div></div>
						<?php } ?>
						
						<?php if(!empty($error['ques']['resolve'])) {?>
			            	<div class="title answerBar">解答：<div class="resolve inputBox" style="width:645px;float:right;"><?= $error['ques']['resolve'] ?></div><div class="clearing"></div></div>
						<?php } ?>
						
						<?php if(!empty($error['ques']['dianpin'])){ ?>	
							<div class="title answerBar">点评:<div class="resolve inputBox" style="float:right;width:600px;"><?=$error['ques']['dianpin']?></div><div class="clearing"></div></div>
						<?php } ?>
						
						<?php if(!empty($error['ques']['cwid'])) {?>
	                		<div class="title answerBar">课件解析：<div class="resolve inputBox" style="float:right; width:600px;"><a onclick="userplay('http://www.ebanhui.com/',<?= $error['ques']['cwid']?>);return false;" href="javascript:void(0);"><img src="http://exam.ebanhui.com/static/images/playcourseware.jpg"></a></div><div class="clearing"></div></div>
						<?php } ?>
						
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
				 <div style="clear:both;padding-top:10px;text-align:center;"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/wuquanx.jpg">暂无记录</div>
		<?php } ?>
	</div>
</div>
<script type="text/javascript">
	$(".delerror").click(function(){
		var eid = $(this).attr("name");
		$.confirm("您确认要删除此错题吗？",function(){
			var url = "<?= geturl('myroom/myerrorbook/del') ?>";
			$.ajax({
				type: "POST",
				url: url,
				data: {'eid':eid},
				dataType : "text",
				success: function(msg){
					if(msg == "success") {
						alert("错题删除成功");
						document.location.reload();
					} else {
						alert("错题删除失败");
					}
				}
			});
		});
	});

	$(function(){
		var searchtext = "请输入搜索关键字";
		initsearch("title",searchtext);
	});
</script>
<?php 
$this->display('myroom/player');
$this->display('myroom/page_footer'); 
?>