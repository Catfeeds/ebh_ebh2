<?php $this->display('troomv2/room_header');?>
<script type="text/javascript" src="http://static.ebanhui.com/exam/js/template/template-native-debug.js"></script>
<link href="http://exam.ebanhui.com/static/css/done.css" rel="stylesheet" type="text/css" />
<link href="http://exam.ebanhui.com/static/css/public.bak.css" rel="stylesheet" type="text/css" />
<link href="http://exam.ebanhui.com/static/css/jqtransform.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="http://exam.ebanhui.com/static/css/wavplayer.css" rel="stylesheet" />

<style type="text/css">
.delabtn{background:url(http://exam.ebanhui.com/static/images/dela.png) no-repeat;width:79px;height:25px;float:right;cursor:pointer;margin-bottom:5px}
.delahbtn{background:url(http://exam.ebanhui.com/static/images/delah.png) no-repeat;width:79px;height:25px;float:right;cursor:pointer;margin-bottom:5px}

/*#errlist .que{clear:both;padding:5px 0 25px;height:auto;}
#errlist .que p.desc{font-size:12px;height:35px;line-height: 35px;color:#3a3a3a;display: inline-block;border:1px solid #f3f3f3;background: #f3f3f3;width: 998px;}
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

*/
.lefrigs{
	margin:0 auto;
	margin-top:10px;
	width:1000px;
}
#errlist .que {
	clear: both;
	padding: 5px 0 25px;
	height: auto;
	margin: 0;
}
#errlist .que p.desc {
	font-size: 12px;
	height: 35px;
	line-height: 35px;
	color: #3a3a3a;
	display: inline-block;
	border: 1px solid #f3f3f3;
	background: #f3f3f3;
	width: 983px;
	margin: 0 5px;
	padding-left: 5px;
}
#errlist .que p.desc span {
	display: inline-block;
	margin-right: 25px;
}
#errlist .que p.desc em {
	margin-right: 8px;
}
.work_search ul li {
	display: inline-block;
	float: left;
	height: 55px;
	line-height: 55px;
}
#errlist .que .operateBar {
	display: none;
}
#errlist .que .optionContent img {
	vertical-align: middle;
}
#icategory {
	background: #fff;
	border-top: 1px solid #E1E7F5;
	padding: 6px 20px;
	_margin-bottom: -5px;
}
#icategory dt {
	float: left;
	line-height: 22px;
	padding-right: 5px;
	text-align: left;
	font-size: 14px;
	color: #999;
}
#icategory dd {
	float: left;
	width: 885px;
}
.price_cont div a:hover,
.price_cont div a.curr {
	background: none repeat scroll 0 0 #FF5400;
	color: #FFFFFF;
	text-decoration: none;
}
.category_cont1 div a.curr,
.category_cont1 div a:hover {
	color: #5e96f5;
	color: #fff;
}
.category_cont1 div a {
	color: #333;
	text-decoration: none;
	padding: 2px 5px;
	font-size: 14px;
}
.category_cont1 div a.curr,
.category_cont1 div a:hover {
	color: #fff;
	text-decoration: none;
	padding: 2px 5px;
	font-size: 14px;
	background: #5e96f5 none repeat scroll 0 0;
}
.category_cont1 div {
	float: left;
	height: 25px;
	line-height: 22px;
	overflow: hidden;
	padding: 0 10px;
}
.pbtns {
	background: url(http://static.ebanhui.com/ebh/tpl/2012/images/sunt0518.png) repeat scroll 0 0 transparent;
	border: medium none;
	color: #333333;
	height: 20px;
	vertical-align: middle;
	width: 40px;
	cursor: pointer;
}
html {
	background: none;
	color: #000;
}
.waitite {
	border-bottom: none;
	background: #fff;
}

.subjectPane {
	padding-left: 10px;
}
a.chakan {
	color: #5e96f5;
}

.singleContainerFocused {
	border-top: none;
}

.radioPane li {
	width: 100% !important;
}
.answerLabel{
	display: inline-block;
}
.diles{
	top:10px;
}
</style>
<script type="text/javascript">
	
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

<script type="text/javascript">
function ser(){
	var sdate = $("#stardateline").val();
	var mid = $("#uid").val();
	url = '<?= geturl('troomv2/myerrorbook')?>?uid='+mid+'&begintime='+sdate;
	location.href = url;
}
</script>
<!-- <div class="cmain_bottoms cmain_bottoms2 cmain_top_r " style="margin-bottom:5px;padding-bottom:0;">
<div class="esukangs">
<a class="subtop jiancha fl" target="mainFrame" href="/troomv2/tastulog.html" title="学生监察">学生监察</a>
<a class="subtop tongji fl" target="mainFrame" href="#" title="教学统计">教学统计</a>
</div>
</div> -->
<div class="lefrigs"><div class="lefrig">
<?php 
$this->assign('data_index',5);
$this->display('troomv2/data_menu');
?>
		<!-- ===课程筛选开始=== -->
	<!--	<?php if(!empty($folderList)){?>
			<div id="icategory" class="clearfix">
				<dt>所属课程：</dt>
				<dd>
					<div class="category_cont1">
						<div>
							<a <?= empty($folderid)?'class="curr"':'' ?> href="<?= geturl('troomv2/statisticanalysis/errors-1-0-0-'.$classid) ?>">所有课程</a>
						</div>
						<?php if(!empty($folderList)){?>
							<?php foreach($folderList as $folder) { ?>

							<div>
								<a <?= $folderid==$folder['folderid']?'class="curr"':''?> href="<?= geturl('troomv2/statisticanalysis/errors-0-0-0-'.$classid.'-'.$folder['folderid']) ?>"><?= $folder['foldername'] ?></a>
							</div>
							<?php } ?>
						<?php }?>
					</div>
				</dd>
			</div>
		<?php }?>-->
		<!-- ===课程筛选结束=== -->
	
	<?php $qtype=array('A'=>'单选','B'=>'多选','C'=>'填空','D'=>'判断','E'=>'文字','H'=>'主观题'); ?>
	<div class="workol" id="errlist">
		

		
		<?php if(!empty($errors) && $examPower != '1') { ?>
			<?php foreach($errors as $k=>$error) {
				$error['title'] = str_replace("<br>","",$error['etitle']);
				$page = $this->uri->uri_page();
				if(empty($page) || !is_numeric($page))
					$page = 1;
				$k = $k+1+($page-1)*20;
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
							<span class="inputBox" style="float:left; width:960px;"><?= $error['ques']['subject']?>（<span class="userAnsLabel" id="txtanswer" style="color:blue;font-weight:bold;padding:0 8px;"></span>）<em class="sorceLabel">[<?= $error['score'] ?>分]</em></span>
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
									<span class="optionContent" style="display:block; width:960px;"><?= $n ?></span>
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
						<?=getquesdoc($error);?>
					</div>
				<?php } elseif($error['quetype']=="B") { ?>
					<div class="que singleContainer singleContainerFocused " qsval="<?= $k ?>">
						<p class="desc"><span><em>作业名称:</em><strong title="<?= $erro['title']?>"><?= shortstr($error['title'],35)?></strong></span><span><em>添加时间:</em><strong><?= date('Y-m-d H:i',$error['dateline'])?></strong></span><span><em>试题类型:</em><strong><?= $qtype[$error['quetype']]?></strong></span></p>
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
						<?=getquesdoc($error);?>
			        </div>
				<?php } else if($error['quetype']=='C') { ?>
					<div class="que singleContainer singleContainerFocused" qsval="<?= $k ?>">
						<p class="desc"><span><em>作业名称:</em><strong title="<?= $error['title'] ?>"><?= shortstr($error['title'],35)?></strong></span><span><em>添加时间:</em><strong><?= date('Y-m-d H:i',$error['dateline']) ?></strong></span><span><em>试题类型:</em><strong><?= $qtype[$error['quetype']] ?></strong></span></p>
			            <div class="blankSubject subjectPane">
				            <span class="stIndex" style="float:left;"><?= $k ?>.</span>
				            <span class="inputBox" style="float:left; width:960px;">
				            <?= preg_replace('/(\#input\#)|(\#img\#)/',  '<input type="text" readonly="readonly" maxlength="2147483647" size="20" value="">',trim($error['ques']['subject']))?> 
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
	
					  <?=getquesdoc($error);?>
			          
			        </div>
				<?php } else if($error['quetype']=='D') {?>
					<div class="que singleContainer singleContainerFocused" qsval="<?= $k ?>">
						<p class="desc"><span><em>作业名称:</em><strong title="<?= $error['title'] ?>"><?= shortstr($error['title'],35) ?></strong></span><span><em>添加时间:</em><strong><?= date('Y-m-d H:i',$error['dateline']) ?></strong></span><span><em>试题类型:</em><strong><?= $qtype[$error['quetype']] ?></strong></span></p>
						<div class="questionContainer">
				            <div class="subjectPane">
					            <span class="stIndex" style="float:left;"><?= $k ?>. </span>
					            <span class="inputBox" style="float:left; width:960px;">
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
							<?=getquesdoc($error);?>
			        </div>
				<?php } else if($error['quetype']=='E') { ?>
					<div class="que singleContainer singleContainerFocused" qsval="<?= $k ?>">
						<p class="desc"><span><em>作业名称:</em><strong title="<?= $error['title'] ?>"><?= shortstr($error['title'],35)?></strong></span><span><em>添加时间:</em><strong><?= date('Y-m-d H:i',$error['dateline']) ?></strong></span><span><em>试题类型:</em><strong><?= $qtype[$error['quetype']] ?></strong></span></p>
			            <div class="subjectPane">
				            <span class="stIndex" style="float:left;"><?= $k ?>. </span>
				            <span class="inputBox" style="float:left; width:960px;">
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
						<?=getquesdoc($error);?>
			        </div>
				<?php } ?>

			<?php } ?>
			<?= $pagestr ?>

		<?php } else { ?>
<div class="weusaz"><img style="float:left;" src="http://static.ebanhui.com/ebh/tpl/troomv2/images/wureazar.jpg" /><span class="lisretdfe">暂无错题记录...</span></div>
		<?php } ?>
	</div>
	<div id="mpage"></div>
</div>
</div>
<script id="t:que" type="text/html">
	<%if(queType == 'A'){%>
		<div class="que singleContainer singleContainerFocused" qsval="<%=i + 1%>" id="que">
		<p class="desc"><span><em>作业名称:</em><strong title="<%=esubject%>"><%=sesubject%></strong></span><span><em>添加时间:</em><strong><%=dateline%></strong></span><span><em>试题类型:</em><strong>单选</strong></span><span><em>错误数:</em><strong style="color:#f85c72;"><%=errorCount%></strong></span></p>
		<div class="subjectPane">
			<span class="stIndex" style=""><%=i + 1+(page *20)%>. </span>
			<span class="inputBox" style=" width:95%;"><%=#qsubject%><em class="sorceLabel">[<%=quescore%>分]</em></span>
			<span class="clearing"></span>
		</div>
		<div class="radioPane">
			<ul style="overflow: hidden;">
				<%for(var i=0;i<blanks.length;i++){%>
				<li class="radioBox" >
					<p class="radioWrapper" style="display:block; float:left;width:40px;">
					<span class="jqTransformRadioWrapper">
						<a rel="question" class="jqTransformRadio" href="javascript:void(0);"></a>
						<input type="radio" value="" name="question" class="jqTransformHidden"></span>
						<label style="cursor:pointer;" bid='<%=keycode+i%>'></label>
					</p>
					<span class="optionContent" style="display: block;width: 85%; margin-left: 36px; word-break: break-all;"><%=#blanks[i].bsubject%></span>
					<span class="clearing"></span>
				</li>
				<%}%>							
			</ul>
		</div>
		<div class="userAnswerBar">
	                <ul style="overflow:auto;  overflow-y:hidden;zoom:1">
	                <li style="float:left;">学生答案：<span class="userAnsLabel"><%=#mychoicestr%></span></li>
	                <li style="float:left;"><span class="markFalse">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></li>
	                </ul>
	            </div>
        <div class="answerBar">正确答案：<span class="answerLabel"><%=#choicestr%></span></div>
        <%if(extdata == ''){%>
        <%}else{%>
        	<%if(extdata.fenxi == ''){%>
        		
        	<%}else{%>
        		<div class="title answerBar"><span style="float:left;">分析：</span><div class="resolve inputBox" style="width:85%;float:left;"><p><%=#extdata.fenxi%><br></p></div><div class="clearing"></div></div>
        	<%}%>
        	<%if(extdata.jx == ''){%>
        		
        	<%}else{%>
        		<div class="title answerBar"><span style="float:left;">解答：</span><div class="resolve inputBox" style="width:85%;float:left;"><p><%=#extdata.jx%><br></p></div><div class="clearing"></div></div>
        	<%}%>
        	<%if(extdata.dp == ''){%>
        		
        	<%}else{%>
        		<div class="title answerBar"><span style="float:left;">点评：</span><div class="resolve inputBox" style="width:85%;float:left;"><p><%=#extdata.dp%><br></p></div><div class="clearing"></div></div>
        	<%}%>
        <%}%>
		<div class="operateBar"><div class="delabtn delerror" name="84269"></div></div>
	</div>
	<%}else if(queType == 'B'){%>
	<div class="que singleContainer singleContainerFocused " qsval="<%=i + 1%>">
		<p class="desc"><span><em>作业名称:</em><strong title="<%=esubject%>"><%=sesubject%></strong></span><span><em>添加时间:</em><strong><%=dateline%></strong></span><span><em>试题类型:</em><strong>多选</strong></span><span><em>错误数:</em><strong style="color:#f85c72;"><%=errorCount%></strong></span></p>
        <div class="subjectPane">
            <span class="stIndex" style=""><%=i + 1+(page *20)%>. </span>
            <span class="inputBox" style=" width:95%;"><%=#qsubject%>（<span class="userAnsLabel" style="color:blue;font-weight:bold;padding:0 8px;"></span>）<em class="sorceLabel">[<%=quescore%>分]</em></span>
            <span class="clearing"></span>
        </div>
        <div class="radioPane">
            <ul style="overflow: hidden;">
            	<%for(var i=0;i<blanks.length;i++){%>
				<li class="radioBox" style="width: 340px;">
					<span class="radioWrapper" style="display:block; float:left;width: 40px;">
					<span class="jqTransformRadioWrapper">
						<a rel="question" class="jqTransformRadio" href="javascript:void(0);"></a>
						<input type="radio" value="" name="question" class="jqTransformHidden"></span>
						<label style="cursor:pointer;" bid='<%=keycode+i%>'></label>
					</span>
					<span class="optionContent" style="display: block;width: 85%; margin-left: 36px; word-break: break-all;"><%=#blanks[i].bsubject%><br></span>
					<span class="clearing"></span>
				</li>
				<%}%>
			 </ul>
        </div>
		<div class="userAnswerBar">
	                <ul style="overflow:auto;overflow-y:hidden; zoom:1">
	                <li style="float:left;">学生答案：<span class="userAnsLabel"><%=#mychoicestr%></span></li>
	                <li style="float:left;"><span class="markFalse">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></li>
	                </ul>
	            </div>
        <div class="answerBar">正确答案：<span class="answerLabel"><%=#choicestr%></span></div>
        <%if(extdata == ''){%>
        <%}else{%>
        	<%if(extdata.fenxi == ''){%>
        		
        	<%}else{%>
        		<div class="title answerBar"><span style="float:left;">分析：</span><div class="resolve inputBox" style="width:85%;float:left;"><p><%=#extdata.fenxi%><br></p></div><div class="clearing"></div></div>
        	<%}%>
        	<%if(extdata.jx == ''){%>
        		
        	<%}else{%>
        		<div class="title answerBar"><span style="float:left;">解答：</span><div class="resolve inputBox" style="width:85%;float:left;"><p><%=#extdata.jx%><br></p></div><div class="clearing"></div></div>
        	<%}%>
        	<%if(extdata.dp == ''){%>
        		
        	<%}else{%>
        		<div class="title answerBar"><span style="float:left;">点评：</span><div class="resolve inputBox" style="width:85%;float:left;"><p><%=#extdata.dp%><br></p></div><div class="clearing"></div></div>
        	<%}%>
        <%}%>
		<div class="operateBar"><div class="delabtn delerror" name="84270"></div></div>
    </div>	
	<%}else if(queType == 'C'){%>
	<div class="que singleContainer singleContainerFocused" qsval="<%=i + 1%>">
		<p class="desc"><span><em>作业名称:</em><strong title="<%=esubject%>"><%=sesubject%></strong></span><span><em>添加时间:</em><strong><%=dateline%></strong></span><span><em>试题类型:</em><strong>填空</strong></span><span><em>错误数:</em><strong style="color:#f85c72;"><%=errorCount%></strong></span></p>
        <div class="blankSubject subjectPane">
            <span class="stIndex" style=""><%=i + 1+(page *20)%>.</span>
            <span class="inputBox" style=" width:95%;"><%=#qsubject%>
            <span class="pointLabel sorceLabel">[<%=quescore%>分]</span></span>
            <span class="clearing"></span>
        </div>
		<div class="userAnswerBar">
	                <ul style="overflow:auto;overflow-y:hidden; zoom:1">
	                <li style="float:left;">学生答案：<span class="userAnsLabel"><%=#mychoicestr%></span></li>
	                <li style="float:left;"><span class="markFalse">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></li>
	                </ul>
	            </div>
        <div class="answerBar">正确答案：
            <span class="answerLabel"><%=#choicestr%></span>
        </div>
        <%if(extdata == ''){%>
        <%}else{%>
        	<%if(extdata.fenxi == ''){%>
        		
        	<%}else{%>
        		<div class="title answerBar"><span style="float:left;">分析：</span><div class="resolve inputBox" style="width:85%;float:left;"><p><%=#extdata.fenxi%><br></p></div><div class="clearing"></div></div>
        	<%}%>
        	<%if(extdata.jx == ''){%>
        		
        	<%}else{%>
        		<div class="title answerBar"><span style="float:left;">解答：</span><div class="resolve inputBox" style="width:85%;float:left;"><p><%=#extdata.jx%><br></p></div><div class="clearing"></div></div>
        	<%}%>
        	<%if(extdata.dp == ''){%>
        		
        	<%}else{%>
        		<div class="title answerBar"><span style="float:left;">点评：</span><div class="resolve inputBox" style="width:85%;float:left;"><p><%=#extdata.dp%><br></p></div><div class="clearing"></div></div>
        	<%}%>
        <%}%>
	   	<div class="operateBar"><div class="delabtn delerror" name="84271"></div></div>
    </div>
	<%}else if(queType == 'D'){%>
	<div class="que singleContainer singleContainerFocused" qsval="<%=i + 1+(page *20)%>">
		<p class="desc"><span><em>作业名称:</em><strong title="<%=esubject%>"><%=sesubject%></strong></span><span><em>添加时间:</em><strong><%=dateline%></strong></span><span><em>试题类型:</em><strong>判断</strong></span><span><em>错误数:</em><strong style="color:#f85c72;"><%=errorCount%></strong></span></p>
		<div class="questionContainer">
            <div class="subjectPane">
	            <span class="stIndex" style=""><%=i + 1+(page *20)%>. </span>
	            <span class="inputBox" style=" width:95%;">
	            <%=#qsubject%>
	            <em class="sorceLabel">[<%=quescore%>分]</em></span>
	            <span class="clearing"></span>
            </div>

            <div class="userAnswerBar">
	            <div style="float:left;"><span>对错选项：</span></div>
		            <div style="float:left;">
			            <span class="jqTransformRadioWrapper">
			            <a class="jqTransformRadio" href="javascript:void(0);"></a>
			            <input type="radio" value="true" name="" class="jqTransformHidden"></span>
			            <label for="" style="cursor:pointer;float:left;margin-right:10px;">对</label>

			            <span class="jqTransformRadioWrapper">
			            <a class="jqTransformRadio" href="javascript:void(0);"></a>
			            <input type="radio" value="false" name="" class="jqTransformHidden"></span>
			            <label for="" style="cursor:pointer;">错</label>
		        	</div>
		            <div class="clearing"></div>
	            </div>
	        </div>
            <div class="answerBar">正确答案：<span class="answerLabel"><%=choicestr=='10'?'对':'错'%></span></div>
            <%if(extdata == ''){%>
        <%}else{%>
        	<%if(extdata.fenxi == ''){%>
        		
        	<%}else{%>
        		<div class="title answerBar"><span style="float:left;">分析：</span><div class="resolve inputBox" style="width:85%;float:left;"><p><%=#extdata.fenxi%><br></p></div><div class="clearing"></div></div>
        	<%}%>
        	<%if(extdata.jx == ''){%>
        		
        	<%}else{%>
        		<div class="title answerBar"><span style="float:left;">解答：</span><div class="resolve inputBox" style="width:85%;float:left;"><p><%=#extdata.jx%><br></p></div><div class="clearing"></div></div>
        	<%}%>
        	<%if(extdata.dp == ''){%>
        		
        	<%}else{%>
        		<div class="title answerBar"><span style="float:left;">点评：</span><div class="resolve inputBox" style="width:85%;float:left;"><p><%=#extdata.dp%><br></p></div><div class="clearing"></div></div>
        	<%}%>
        <%}%>
        <div class="operateBar"><div class="delabtn delerror" name="84273"></div></div>
	</div>	
	<%}else if(queType == 'E'){%>
	<div class="que singleContainer singleContainerFocused" qsval="<%=i + 1%>"> 
		<p class="desc"><span><em>作业名称:</em><strong title="<%=esubject%>"><%=sesubject%></strong></span><span><em>添加时间:</em><strong><%=dateline%></strong></span><span><em>试题类型:</em><strong>文字</strong></span><span><em>错误数:</em><strong style="color:#f85c72;"><%=errorCount%></strong></span></p>
        <div class="subjectPane">
            <span class="stIndex" style=""><%=i + 1+(page *20)%>. </span>
            <span class="inputBox" style=" width:95%;">
            <%=#qsubject%>	            <em class="sorceLabel">[<%=quescore%>分]</em></span>
            <span class="clearing"></span>
        </div>
        <div class="answerBar" style="width: 805px;display: block;">正确答案：<span class="answerLabel" ><%=#choicestr%></span></div>
		<%if(extdata == ''){%>
        <%}else{%>
        	<%if(extdata.fenxi == ''){%>
        		
        	<%}else{%>
        		<div class="title answerBar"><span style="float:left;">分析：</span><div class="resolve inputBox" style="width:85%;float:left;"><p><%=#extdata.fenxi%><br></p></div><div class="clearing"></div></div>
        	<%}%>
        	<%if(extdata.jx == ''){%>
        		
        	<%}else{%>
        		<div class="title answerBar"><span style="float:left;">解答：</span><div class="resolve inputBox" style="width:85%;float:left;"><p><%=#extdata.jx%><br></p></div><div class="clearing"></div></div>
        	<%}%>
        	<%if(extdata.dp == ''){%>
        		
        	<%}else{%>
        		<div class="title answerBar"><span style="float:left;">点评：</span><div class="resolve inputBox" style="width:85%;float:left;"><p><%=#extdata.dp%><br></p></div><div class="clearing"></div></div>
        	<%}%>
        <%}%>
	</div>	
	<%}%>
</script>
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
var tip="请输入错题关键字";
var uid =  "<?=$uid?>";
var exampower = "<?=$examPower?>";
$(function(){
	initsearch('search',tip);
	$('#searchbutton').click(function(){
		
		if($("#search").val()=='请输入错题关键字'){
			var searchvalue = '';
		}else{
			var searchvalue = $("#search").val();
		}
		if(searchvalue=='请输入错题关键字'){
			searchvalue='';
		}
		if(exampower != '1'){
			var href = '<?= geturl('troomv2/statisticanalysis/errorlogs/'.$uid) ?>';
			location.href = href+"?q="+searchvalue;
		}else{
			getStuErrlistAjax();
		}
		
	});
		
		function getStuErrlistAjax(url){
			if(typeof url == "undefined") {
				url = '/troomv2/examv2/getStuErrlistAjax.html';
			}
			var title = $("#search").val();			
			if(title == tip){
				title = "";
				
			}
			$.ajax({
				url:url,
				method:'post',
				dataType:'json',
				data : {
					uid : uid,
					q : title || ''
				}
			}).done(function(res){
				
				$("#errlist,#mpage").empty();
				var errList = res.datas.errList;
				// console.log(errList);
				if(errList.length <=0){
					var cmain_bottom = '<div class="weusaz"><img style="float:left;" src="http://static.ebanhui.com/ebh/tpl/troomv2/images/wureazar.jpg" /><span class="lisretdfe">暂无错题记录...</span></div>';
					$('#mpage').empty().append(cmain_bottom);
				}else{
					for(var i=0;i<errList.length;i++){
						var queType = errList[i].question.queType;
						if(errList[i].question.queType == 'C'){
							var qsubject =	errList[i].question.qsubject.replace(/#input#/g,'<input type="text" readonly="readonly" maxlength="2147483647" size="20" value="">');
							qsubject =	qsubject.replace(/#img#/g,'<input type="text" readonly="readonly" maxlength="2147483647" size="20" value="">');
						}else{
							var qsubject = errList[i].question.qsubject;
						}
						if(queType == 'C'){
							var choicestr = [];
							var bidarr = [];
							var answerblankarr = [];
							for(var j=0;j<errList[i].question.blanks.length;j++){
								if(/ebh_1_data-latexebh_2_/.test(errList[i].question.blanks[j].bsubject)){
								  var bsubjecthtml = unescape(errList[i].question.blanks[j].bsubject.replace(/ebh_1_/g,' ').replace(/ebh_2_/g,'='));
								  bsubjecthtml = '<img '+ bsubjecthtml +' />';
								   choicestr.push(bsubjecthtml);
								}else{
									choicestr.push(errList[i].question.blanks[j].bsubject);
								}
								bidarr.push(errList[i].question.blanks[j].bid);
							}
							for(var k=0;k<errList[i].answerQueDetail.answerBlankDetails.length;k++){
								var bid = errList[i].answerQueDetail.answerBlankDetails[k].bid;
								answerblankarr[bid] = errList[i].answerQueDetail.answerBlankDetails[k]
							}
							var  choicestr = choicestr.join(';&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;')
							var extdata =$.parseJSON(errList[i].question.extdata)
							var mychoicestr = '';
							for(key in bidarr){
								if(/ebh_1_data-latexebh_2_/.test(answerblankarr[bidarr[key]].content)){
									var  bsubjecthtml = answerblankarr[bidarr[key]].content.replace(/ebh_1_/g,' ').replace(/ebh_2_/g,'=');
									bsubjecthtml = '<img '+ bsubjecthtml +' />';
									mychoicestr += bsubjecthtml?bsubjecthtml:'<font color="red">未作答</font>';
								}else{
									mychoicestr += answerblankarr[bidarr[key]].content?answerblankarr[bidarr[key]].content:'<font color="red">未作答</font>';
								}
								
								if(key < bidarr.length-1)
									mychoicestr += ';&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
							}
							// var mychoicestr = errList[i].answerQueDetail.data; 
						}else if(queType == 'E'){
							var  choicestr = errList[i].question.blanks[0].bsubject;
						}else if(queType == 'A' || queType == 'B'){
							// alert();
							var trueanswer = '';
							var myanswer = '';
							var aindex = -2;
							var maindex = -2;
							while(aindex != -1){
								if(aindex == -2)
									aindex = errList[i].question.choicestr.indexOf(1)
								else
									aindex = errList[i].question.choicestr.indexOf(1,aindex+1);
								
								if(aindex>=0)
									trueanswer += String.fromCharCode(parseInt(aindex)+65);
							}
							while(maindex != -1){
								if(maindex == -2){
									maindex = errList[i].answerQueDetail.choicestr.indexOf(1)
								}else{
									maindex = errList[i].answerQueDetail.choicestr.indexOf(1,maindex+1);
								};
								if(maindex>=0){
									myanswer += String.fromCharCode(parseInt(maindex)+65);
								}
									
							}
							var choicestr = trueanswer;
							var mychoicestr = myanswer;
						}else{
							var choicestr = errList[i].question.choicestr;
						}
						if(errList[i].question.extdata == ''){
							var extdata = '';
						}else{
							var extdata = $.parseJSON(errList[i].question.extdata);
						}
						mychoicestr = mychoicestr?mychoicestr:'<font color="red">未作答</font>';
					
						var page = parseInt(res.datas.page)
						if(errList[i].exam.esubject.length>40){
						    var  sesubject = errList[i].exam.esubject.substring(0,40)+"...";
						}else{
							var  sesubject = errList[i].exam.esubject;
						}
						var data = {
							page : page -1,
							i : i,
							keycode : 65,
							queType : errList[i].question.queType,
							sesubject : sesubject,
							esubject : errList[i].exam.esubject,
							dateline : new Date(parseInt(errList[i].question.dateline)* 1000).format("yyyy-MM-dd hh:mm:ss"),
							blanks : errList[i].question.blanks,
							quescore : errList[i].question.quescore,
							qsubject : qsubject,
							choicestr : choicestr,
							errorCount : errList[i].errorCount,
							extdata :extdata,
							qid :  errList[i].question.qid,
							mychoicestr : mychoicestr
						};
						var $dom = $(template('t:que',data));
						$("#errlist").append($dom);
						$('#errlist br').remove();
					}
					$('#mpage').empty().append(res.datas.pagestr);
					$('.radioBox label ').each(function(){
						$(this).text(String.fromCharCode($(this).attr('bid')));
					})
				}
				
				}).fail(function(){
				console.log('req err');
			});
			
		}
	if(exampower == '1'){
		getStuErrlistAjax();
		$('#mpage ').on('click','.pages .listPage a',function(){
			var url = $(this).attr('data');
			if(!!url) {
				getStuErrlistAjax(url);
			}
		});
	};
	
	
	
	Date.prototype.format = function(format) 
	{ 
		var o = 
		{ 
		"M+" : this.getMonth()+1, //month 
		"d+" : this.getDate(), //day 
		"h+" : this.getHours(), //hour 
		"m+" : this.getMinutes(), //minute 
		"s+" : this.getSeconds(), //second 
		"q+" : Math.floor((this.getMonth()+3)/3), //quarter 
		"S" : this.getMilliseconds() //millisecond 
		}
		
		if(/(y+)/.test(format)){ 
			format = format.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length)); 
		}
		
		for(var k in o){ 
			if(new RegExp("("+ k +")").test(format)){ 
				format = format.replace(RegExp.$1, RegExp.$1.length==1 ? o[k] : ("00"+ o[k]).substr((""+ o[k]).length)); 
			} 
		} 
		return format; 
	} 
});

</script>
<?php 
$this->display('common/player'); 
$this->display('troomv2/page_footer'); 
?>