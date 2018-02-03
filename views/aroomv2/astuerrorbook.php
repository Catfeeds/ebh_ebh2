<?php $this->display('aroomv2/page_header')?>

<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />

<link href="http://exam.ebanhui.com/static/css/base.css" rel="stylesheet" type="text/css" />
<link href="http://exam.ebanhui.com/static/css/done.css" rel="stylesheet" type="text/css" />
<link href="http://exam.ebanhui.com/static/css/public.bak.css" rel="stylesheet" type="text/css" />
<link href="http://exam.ebanhui.com/static/css/jqtransform.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="http://exam.ebanhui.com/static/css/wavplayer.css" rel="stylesheet" />
<style type="text/css">
.delabtn{background:url(http://exam.ebanhui.com/static/images/dela.png) no-repeat;width:79px;height:25px;float:right;cursor:pointer;margin-bottom:5px}
.delahbtn{background:url(http://exam.ebanhui.com/static/images/delah.png) no-repeat;width:79px;height:25px;float:right;cursor:pointer;margin-bottom:5px}

#errlist .que{clear:both;padding:5px 0 25px;height:auto;}
#errlist .que p.desc{font-size:12px;height:35px;line-height: 35px;color:#3a3a3a;display: inline-block;border:1px solid #f3f3f3;background: #f3f3f3;width: 783px;}
 p.desc span{display: inline-block;margin-right: 25px;}
#errlist .que p.desc em{margin-right: 8px;}
.work_search ul li {display:inline-block;float: left;height:55px;line-height: 55px;}
#errlist .que .operateBar{display: none;}
#errlist .que .userAnswerBar{display: none;}
/*#errlist .que .radioBox{width: 170px;border: 1px solid #ccc;overflow: hidden;height: 24px;line-height: 24px;}
.jqTransformRadioWrapper{margin-top:4px;}*/
</style>

	<div class="ter_tit">
		当前位置 > 学校错题排行
		<div class="diles">
			<input name="title" class="newsou" id="search" style="<?php if(!empty($search)){?>color:#000<?php }?>" type="text" <?php if(!empty($search)){?>value="<?=str_replace("''","'",$search)?>" <?php }else{?>value="输入关键字搜索"<?php }?>  onblur="if($('#search').val()==''){$('#search').val('输入关键字搜索').css('color','#CBCBCB');}" onfocus="if($('#search').val()=='输入关键字搜索'){$('#search').val('').css('color','#000');}">
			<input type="button" class="soulico" value="" id="searchbuttons" style="background: url(http://static.ebanhui.com/ebh/tpl/2014/images/newsolico.jpg) no-repeat;width: 26px;margin-right:0;">
		</div>
	</div>
	<div class="lefrig">
		<div class="annuato" style="line-height:28px;padding-left:20px;position: relative;border:solid 1px #cdcdcd;background:#fff;">
			本网校共有班级&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['classnum']?></span>&nbsp;个，共有教师&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['teanum']?></span>&nbsp;个，学生&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['stunum']?></span>&nbsp;名，课件&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['coursenum']?></span>&nbsp;个，课程&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['foldernum']?></span>&nbsp;个
		</div>

		<div id="icategory" class="clearfix" style="border:solid 1px #cdcdcd;background:#fff;">
			<dt>所属班级：</dt>
			<dd>
				<div class="category_cont1">
					<div>
						<a <?php if(empty($classid)){?>class="curr"<?php }?> href="<?=geturl('aroomv2/astuerrorbook-0-0-0-0')?>">所有学生</a>
					</div>
					<?php foreach($classlist as $cl){?>
					<div>
						<a <?php if($classid==$cl['classid']){?>class="curr"<?php }?>href="<?=geturl('aroomv2/astuerrorbook-0-0-0-'.$cl['classid'])?>"><?=$cl['classname']?></a>
					</div>
					<?php }?>
				</div>
			</dd>
		</div>

		
		<div class="workol" id="errlist" style="border:solid 1px #cdcdcd;border-top:none;">
			<?php if(!empty($errorlist)){
				$qtype=array('A'=>'单选','B'=>'多选','C'=>'填空','D'=>'判断','E'=>'文字','H'=>'主观题');
				foreach($errorlist as $k=>$value){
					if($page==0)
						$page=1;
					$k = $k+1+($page-1)*$pagesize;
					if($value['quetype']=='A'){
						if(!empty($value['ques'][0]))
							$value['ques'] = $value['ques'][0];
				?>
					
						<div class="que singleContainer singleContainerFocused" qsval="<?=$k?>" id="que">
							<p class="desc"><span><em>作业名称:</em><strong title="<?=$value['title']?>"><?=shortstr($value['title'],35)?></strong></span><span><em>添加时间:</em><strong><?=Date('Y-m-d H:i',$value['dateline'])?></strong></span><span><em>试题类型:</em><strong><?=$qtype[$value['quetype']]?></strong></span><span><em>错误数:</em><strong style="color:#f00;"><?=$value['falsenum']?></strong></span></p>
							<div class="subjectPane">
								<span class="stIndex" style="float:left;"><?=$k?>. </span>
								<span class="inputBox" style="float:left; width:650px;"><?=$value['ques']['subject']?>（<span class="userAnsLabel" id="txtanswer" style="color:blue;font-weight:bold;padding:0 8px;"></span>）<em class="sorceLabel">[<?=$value['score']?>分]</em></span>
								<span class="clearing"></span>
							</div>
							<div class="radioPane">
								<ul>
									
									<?php foreach($value['ques']['options'] as $m=>$n){
										$opid = chr(intval($m)+65);
									?>
									<li class="radioBox">
										<span class="radioWrapper" style="display:block; float:left">
										<span class="jqTransformRadioWrapper">
											<a rel="question" class="jqTransformRadio" href="javascript:void(0);"></a>
											<input type="radio" value="" name="question" class="jqTransformHidden"></span>
											<label style="cursor:pointer;"><?=$opid?></label>
										</span>
										<span class="optionContent" style="display:block; width:650px;"><?=$n?></span>
										<span class="clearing"></span>
									</li>
									<?php }?>
									
								</ul>
							</div>
							<div class="userAnswerBar">
				                <ul style="overflow:auto; zoom:1">
				                <li style="float:left;">我的答案：<span class="userAnsLabel"><?=$value['erranswers']?$value['erranswers']:"没填";?></span></li>
				                <li style="float:left;"><span class="markFalse">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></li>
				                </ul>
				            </div>
				            <div class="answerBar">正确答案：<span class="answerLabel"><?=$value['ques']['answers']?></span></div>
							<?php if(!empty($value['ques']['resolve'])){?>
				            	<div class="title answerBar">答案解析：<div class="resolve inputBox" style="width:645px;float:right;"><?=$value['ques']['resolve']?></div><div class="clearing"></div></div>
							<?php }?>
							
							<?php if(!empty($value['ques']['cwid'])){?>
		                		<div class="title answerBar">课件解析：<div class="resolve inputBox" style="float:right; width:553px;"><a onclick="userplay('http://www.ebanhui.com/',<?=$value['ques']['cwid']?>);return false;" href="javascript:void(0);"><img src="http://exam.ebanhui.com/static/images/playcourseware.jpg"></a></div><div class="clearing"></div></div>
							<?php }?>


							<div class="operateBar"><div class="delabtn delerror" name="<?=$value['eid']?>"></div></div>
						</div>
					<?php }elseif($value['quetype']=='B'){
							if(!empty($value['ques'][0]))
								$value['ques'] = $value['ques'][0];?>
						<div class="que singleContainer singleContainerFocused " qsval="<?=$k?>">
							<p class="desc"><span><em>作业名称:</em><strong title="<?=$value['title']?>"><?=shortstr($value['title'],35)?></strong></span><span><em>添加时间:</em><strong><?=Date('Y-m-d H:i',$value['dateline'])?></strong></span><span><em>试题类型:</em><strong><?=$qtype[$value['quetype']]?></strong></span><span><em>错误数:</em><strong style="color:#f00;"><?=$value['falsenum']?></strong></span></p>
				            <div class="subjectPane">
				                <span class="stIndex" style="float:left;"><?=$k?>. </span>
				                <span class="inputBox" style="float:left; width:640px;"><?=$value['ques']['subject']?>（<span class="userAnsLabel" style="color:blue;font-weight:bold;padding:0 8px;"></span>）<em class="sorceLabel">[<?=$value['score']?>分]</em></span>
				                <span class="clearing"></span>
				            </div>
				            <div class="radioPane">
				                <ul>
									<?php foreach($value['ques']['options'] as $m=>$n){
										$opid = chr(intval($m)+65);
									?>
									<li class="radioBox">
										<span class="radioWrapper" style="display:block; float:left">
										<span class="jqTransformRadioWrapper">
											<a rel="question" class="jqTransformRadio" href="javascript:void(0);"></a>
											<input type="radio" value="" name="question" class="jqTransformHidden"></span>
											<label style="cursor:pointer;"><?=$opid?>.</label>
										</span>
										<span class="optionContent" style="display:block; width:670px;"><?=$n?></span>
										<span class="clearing"></span>
									</li>
									<?php }?>
				                </ul>
				            </div>
				            <div class="userAnswerBar">
				                <ul style="overflow:auto; zoom:1">
				                <li style="float:left;">我的答案：<span class="userAnsLabel"><?=isset($value['erranswers'])?$value['erranswers']:"没填"?></span></li>
				                <li style="float:left;"><span class="markFalse">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></li>
				                </ul>
				            </div>
				            <div class="answerBar">正确答案：<span class="answerLabel"><?=$value['ques']['answers']?></span></div>

				            <?php if(!empty($value['ques']['resolve'])){?>
				            	<div class="title answerBar">答案解析：<div class="resolve inputBox" style="width:645px;float:right;"><?=$value['ques']['resolve']?></div><div class="clearing"></div></div>
							<?php }?>
							<?php if(!empty($value['ques']['cwid'])){?>
		                		<div class="title answerBar">课件解析：<div class="resolve inputBox" style="float:right; width:553px;"><a onclick="userplay('http://www.ebanhui.com/',<?=$value['ques']['cwid']?>);return false;" href="javascript:void(0);"><img src="http://exam.ebanhui.com/static/images/playcourseware.jpg"></a></div><div class="clearing"></div></div>
							<?php }?>


							<div class="operateBar"><div class="delabtn delerror" name="<?=$value['eid']?>"></div></div>
				        </div>
					<?php }elseif($value['quetype']=='C'){
							if(!empty($value['ques'][0]))
								$value['ques'] = $value['ques'][0];?>
						<div class="que singleContainer singleContainerFocused" qsval="<?=$k?>">
							<p class="desc"><span><em>作业名称:</em><strong title="<?=$value['title']?>"><?=shortstr($value['title'],35)?></strong></span><span><em>添加时间:</em><strong><?=Date('Y-m-d H:i',$value['dateline'])?></strong></span><span><em>试题类型:</em><strong><?=$qtype[$value['quetype']]?></strong></span><span><em>错误数:</em><strong style="color:#f00;"><?=$value['falsenum']?></strong></span></p>
				            <div class="blankSubject subjectPane">
					            <span class="stIndex" style="float:left;"><?=$k?>.</span>
					            <span class="inputBox" style="float:left; width:650px;">
								<?php
								echo preg_replace('/(\#input\#)|(\#img\#)/','<input type="text" readonly="readonly" maxlength="2147483647" size="20" value="">',trim($value['ques']['subject']));?>
					            <span class="pointLabel sorceLabel">[<?=$value['score']?>分]</span></span>
					            <span class="clearing"></span>
				            </div>
				            <div class="userAnswerBar">
				                <ul style="overflow:auto; zoom:1">
				                <li style="">我的答案：
				                	<span class="userAnsLabel">
				          
				                	</span>
				               	</li>
				                </ul>
				            </div>
				            <div class="answerBar">正确答案：
				                <span class="answerLabel">
									<?php 
										$tanswer = '';
										foreach($value['ques']['options'] as $n){
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
						   <?php if(!empty($value['ques']['resolve'])){?>
				            	<div class="title answerBar">答案解析：<div class="resolve inputBox" style="width:645px;float:right;"><?=$value['ques']['resolve']?></div><div class="clearing"></div></div>
							<?php }?>
							<?php if(!empty($value['ques']['cwid'])){?>
		                		<div class="title answerBar">课件解析：<div class="resolve inputBox" style="float:right; width:553px;"><a onclick="userplay('http://www.ebanhui.com/',<?=$value['ques']['cwid']?>);return false;" href="javascript:void(0);"><img src="http://exam.ebanhui.com/static/images/playcourseware.jpg"></a></div><div class="clearing"></div></div>
							<?php }?>

				            <div class="operateBar"><div class="delabtn delerror" name="<?=$value['eid']?>"></div></div>
				        </div>
					<?php }elseif($value['quetype']=='D'){
						if(!empty($value['ques'][0]))
							$value['ques'] = $value['ques'][0];?>
						<div class="que singleContainer singleContainerFocused" qsval="<?=$k?>">
							<p class="desc"><span><em>作业名称:</em><strong title="<?=$value['title']?>"><?=shortstr($value['title'],35)?></strong></span><span><em>添加时间:</em><strong><?=Date('Y-m-d H:i',$value['dateline'])?></strong></span><span><em>试题类型:</em><strong><?=$qtype[$value['quetype']]?></strong></span><span><em>错误数:</em><strong style="color:#f00;"><?=$value['falsenum']?></strong></span></p>
							<div class="questionContainer">
					            <div class="subjectPane">
						            <span class="stIndex" style="float:left;"><?=$k?>. </span>
						            <span class="inputBox" style="float:left; width:650px;">
						            <?=$value['ques']['subject']?>
						            <em class="sorceLabel" >[<?=$value['score']?>分]</em></span>
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
					                <li style="float:left;">学生答案：<span class="userAnsLabel"><?=$value['erranswers']==2?"没填":($value['erranswers']==1?"对":"错")?></span></li>
					                <li style="float:left;"><span class="markFalse">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></li>
					                </ul>
					            </div>

					            <div class="answerBar">正确答案：<span class="answerLabel"><?=$value['ques']['answers']==1?"对":"错";?></span></div>
								<?php if(!empty($value['ques']['resolve'])){?>
					            	<div class="title answerBar">答案解析：<div class="resolve inputBox" style="width:645px;float:right;"><?=$value['ques']['resolve']?></div><div class="clearing"></div></div>
								<?php }?>
								<?php if(!empty($value['ques']['cwid'])){?>
		                		<div class="title answerBar">课件解析：<div class="resolve inputBox" style="float:right; width:553px;"><a onclick="userplay('http://www.ebanhui.com/',<?=$value['ques']['cwid']?>);return false;" href="javascript:void(0);"><img src="http://exam.ebanhui.com/static/images/playcourseware.jpg"></a></div><div class="clearing"></div></div>
								<?php }?>
					        <div class="operateBar"><div class="delabtn delerror" name="<?=$value['eid']?>"></div></div>
				        </div>
					<?php }elseif($value['quetype']=='E'){
						if(!empty($value['ques'][0]))
							$value['ques'] = $value['ques'][0];?>
						<div class="que singleContainer singleContainerFocused" qsval="<?=$k?>">
							<p class="desc"><span><em>作业名称:</em><strong title="<?=$value['title']?>"><?=shortstr($value['title'],35)?></strong></span><span><em>添加时间:</em><strong><?=Date('Y-m-d H:i',$value['dateline'])?></strong></span><span><em>试题类型:</em><strong><?=$qtype[$value['quetype']]?></strong></span><span><em>错误数:</em><strong style="color:#f00;"><?=$value['falsenum']?></strong></span></p>
				            <div class="subjectPane">
					            <span class="stIndex" style="float:left;"><?=$k?>. </span>
					            <span class="inputBox" style="float:left; width:650px;">
					            <?=$value['ques']['subject']?>
					            <em class="sorceLabel">[<?=$value['score']?>分]</em></span>
					            <span class="clearing"></span>
				            </div>
				            <div class="userAnswerBar">
				                <ul style="overflow:auto; zoom:1">
				                <li style="float:left;">我的答案：<span class="userAnsLabel"><?=$value['erranswers']?$value['erranswers']:"没填"?></span></li>
				                <li style="float:left;"><span class="markFalse">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></li>
				                </ul>
				            </div>
				            <div class="answerBar">正确答案：<span class="answerLabel"><?=$value['ques']['answers']?></span></div>

							<?php if (!empty($value['ques']['resolve'])){?>
				            	<div class="title answerBar">答案解析：<div class="resolve inputBox" style="width:645px;float:right;"><?=$value['ques']['resolve']?></div><div class="clearing"></div></div>
							<?php }?>
							<?php if (!empty($value['ques']['cwid'])){?>
		                		<div class="title answerBar">课件解析：<div class="resolve inputBox" style="float:right; width:553px;"><a onclick="userplay('http://www.ebanhui.com/',<?=$value['ques']['cwid']?>);return false;" href="javascript:void(0);"><img src="http://exam.ebanhui.com/static/images/playcourseware.jpg"></a></div><div class="clearing"></div></div>
							<?php }?>
				            <div class="operateBar"><div class="delabtn delerror" name="<?=$value['eid']?>"></div></div>
				        </div>
					
					
				<?php }}echo show_page($errorcount);}else{?>
				
					 <div style="clear:both;border-top:1px solid #ccc;padding-top:10px;padding-left:20px;">暂无记录</div>
				<?php }?>
				
		</div>
	</div>
<script type="text/javascript">
$(function(){
	$('#searchbuttons').click(function(){
		<?php $classid = empty($classid)?'0':$classid?>
		var href = '<?=geturl('aroomv2/astuerrorbook-0-0-0-'.$classid)?>';

		if($("#search").val()=='请输入试题标题关键字'){
			var searchvalue = '';
		}else{
			var searchvalue = $("#search").val();
		}
		if(searchvalue=='请输入试题标题关键字'){
			searchvalue='';
		}
		searchvalue = searchvalue.replace(/,/g,"");
		searchvalue = searchvalue.replace(/\'/g,"");
		searchvalue = searchvalue.replace(/\"/g,"");
		searchvalue = searchvalue.replace(/\//g,"");
		searchvalue = searchvalue.replace(/%/g,"");
		searchvalue = searchvalue.replace(/_/g,"");
		searchvalue = searchvalue.replace(/#/g,"");
		searchvalue = searchvalue.replace(/\?/g,"");
		searchvalue = searchvalue.replace(/\\/g,"");
		// href=href.replace('searchvalue',encodeURIComponent(searchvalue));
		href=href+'?q='+searchvalue;
		location.href = href;
	});

});

function replaceAll(str,find,rp){
	while(true){
		if(str.indexOf(find) == -1){
			break;
		}
		str = str.replace(find,rp);
	}
	return str;
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
<?php 
$this->display('common/player');
$this->display('aroomv2/page_footer');
?>
