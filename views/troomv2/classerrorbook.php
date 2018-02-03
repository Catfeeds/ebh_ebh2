
<?php $this->display('troomv2/page_header')?>

<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />

<link href="http://exam.ebanhui.com/static/css/base.css" rel="stylesheet" type="text/css" />
<link href="http://exam.ebanhui.com/static/css/done.css" rel="stylesheet" type="text/css" />
<link href="http://exam.ebanhui.com/static/css/public.bak.css" rel="stylesheet" type="text/css" />
<link href="http://exam.ebanhui.com/static/css/jqtransform.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="http://exam.ebanhui.com/static/css/wavplayer.css" rel="stylesheet" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen">
<style type="text/css">

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
.key_word {
	padding: 6px 20px;
	border-bottom-width: 1px;
	border-bottom-style: solid;
	border-bottom-color: #cdcdcd;
}
.key_word dt {
    float: left;
    line-height: 22px;
    padding-right: 5px;
    text-align: left;
}
.pbtns {
    background: url(/static/tpl/2012/images/sunt0518.png) repeat scroll 0 0 transparent;
    border: medium none;
    color: #333333;
    height: 20px;
    vertical-align: middle;
    width: 40px;
	cursor:pointer;
}

.delabtn{background:url(http://exam.ebanhui.com/static/images/dela.png) no-repeat;width:79px;height:25px;float:right;cursor:pointer;margin-bottom:5px}
.delahbtn{background:url(http://exam.ebanhui.com/static/images/delah.png) no-repeat;width:79px;height:25px;float:right;cursor:pointer;margin-bottom:5px}
#errlist .que {
    clear: both;
    color: #333;
    font-family: 宋体;
    height: auto;
    line-height: 23px;
    padding: 5px 0 25px;
}
#errlist .que p.desc{font-size:12px;height:35px;line-height: 35px;color:#3a3a3a;display: inline-block;border:1px solid #f3f3f3;background: #f3f3f3;width: 983px; margin:0 5px;padding-left:5px;}
 p.desc span{display: inline-block;margin-right: 25px;}
#errlist .que p.desc em{margin-right: 8px;}
.work_search ul li {display:inline-block;float: left;height:55px;line-height: 55px;}
#errlist .que .operateBar{display: none;}
#errlist .que .userAnswerBar{display: none;}
.showQ{
	background: url(http://static.ebanhui.com/ebh/tpl/default/images/tensuoding0605.jpg) no-repeat scroll 0 0 transparent;
	color: #8e8d8d;
	width: 43px;
	height: 22px;
	line-height: 22px;
	border: none;
	text-align: center;
	margin-right: 5px;
}
html {
    background: none;
}
p.zymc{
	font-size:22px;
	font-family:微软雅黑;
	text-align:center;
	color:#666;
	padding:10px 0;
}
.subjectPane {
    padding-left: 10px;
	padding-top:10px;
}
.lefrig{
	background:none;
}
a.chakan{
	color:#5e96f5;
}
.singleContainerFocused{
	border-top:none;
}
.radioPane li{
	width:950px;
}
/*#errlist .que .radioBox{width: 170px;border: 1px solid #ccc;overflow: hidden;height: 24px;line-height: 24px;}
.jqTransformRadioWrapper{margin-top:4px;}*/
</style>

<div class="lefrig" >
<div class="workol" id="errlist">
			<?php if(!empty($errorlist)){
				$qtype=array('A'=>'单选','B'=>'多选','C'=>'填空','D'=>'判断','E'=>'文字','H'=>'主观题');
                ?>
                <p class="zymc"><span><strong title="<?=$errorlist[0]['title']?>"><?=shortstr($errorlist[0]['title'],35)?></strong></span></p>
                <?php
				foreach($errorlist as $k=>$value){
					$page = $this->uri->uri_page();
					if(empty($page) || !is_numeric($page))
						$page = 1;
					$k = $k+1+($page-1)*$pagesize;
					if (isset($value['erranswers'])) {
						$value['erranswers'] = base64str(unserialize($value['erranswers']));
					} else {
						$value['erranswers'] = '';
					}
					
					$value['ques'] = isset($value['ques'][0])?$value['ques'][0]:$value['ques'];
					subjectfix($value);
					if($value['quetype']=='A'){
						if(!empty($value['ques'][0]))
							$value['ques'] = $value['ques'][0];
				?>
						
						<div class="que singleContainer singleContainerFocused" qsval="<?=$k?>" id="que">
							<p class="desc"><span><em>试题类型:</em><strong><?=$qtype[$value['quetype']]?></strong></span><span><em>错误数:</em><strong style="color:#f00;"><?=$value['falsenum']?></strong></span><a href="javascript:;" class=" chakan" onclick="showQDetqil(<?=$value['qid']?>);">查看</a></p>
							<div class="subjectPane">
								<span class="stIndex" style="float:left;"><?=$k?>. </span>
								<span class="inputBox" style="float:left; width:965px;"><?=$value['ques']['subject']?>（<span class="userAnsLabel" id="txtanswer" style="color:blue;font-weight:bold;padding:0 8px;"></span>）<em class="sorceLabel">[<?=$value['score']?>分]</em></span>
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
										<span class="optionContent" style="display:block; width:965px;"><?=$n?></span>
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
							<?=getquesdoc($value);?>


							<div class="operateBar"><div class="delabtn delerror" name="<?=$value['eid']?>"></div></div>
						</div>
					<?php }elseif($value['quetype']=='B'){
							if(!empty($value['ques'][0]))
								$value['ques'] = $value['ques'][0];?>
						<div class="que singleContainer singleContainerFocused " qsval="<?=$k?>">
							<p class="desc"><span><em>试题类型:</em><strong><?=$qtype[$value['quetype']]?></strong></span><span><em>错误数:</em><strong style="color:#f00;"><?=$value['falsenum']?></strong></span><a href="javascript:;" class=" chakan" onclick="showQDetqil(<?=$value['qid']?>);">查看</a></p>
				            <div class="subjectPane">
				                <span class="stIndex" style="float:left;"><?=$k?>. </span>
				                <span class="inputBox" style="float:left; width:965px;"><?=$value['ques']['subject']?>（<span class="userAnsLabel" style="color:blue;font-weight:bold;padding:0 8px;"></span>）<em class="sorceLabel">[<?=$value['score']?>分]</em></span>
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
										<span class="optionContent" style="display:block; width:965px;"><?=$n?></span>
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

				           <?=getquesdoc($value);?>


							<div class="operateBar"><div class="delabtn delerror" name="<?=$value['eid']?>"></div></div>
				        </div>
					<?php }elseif($value['quetype']=='C'){
							if(!empty($value['ques'][0]))
								$value['ques'] = $value['ques'][0];?>
						<div class="que singleContainer singleContainerFocused" qsval="<?=$k?>">
							<p class="desc"><span><em>试题类型:</em><strong><?=$qtype[$value['quetype']]?></strong></span><span><em>错误数:</em><strong style="color:#f00;"><?=$value['falsenum']?></strong></span><a href="javascript:;" class="chakan" onclick="showQDetqil(<?=$value['qid']?>);">查看</a></p>
				            <div class="blankSubject subjectPane">
					            <span class="stIndex" style="float:left;"><?=$k?>.</span>
					            <span class="inputBox" style="float:left; width:965px;">
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
						 	<?=getquesdoc($value);?>

				            <div class="operateBar"><div class="delabtn delerror" name="<?=$value['eid']?>"></div></div>
				        </div>
					<?php }elseif($value['quetype']=='D'){
						if(!empty($value['ques'][0]))
							$value['ques'] = $value['ques'][0];?>
						<div class="que singleContainer singleContainerFocused" qsval="<?=$k?>">
							<p class="desc"><span><em>试题类型:</em><strong><?=$qtype[$value['quetype']]?></strong></span><span><em>错误数:</em><strong style="color:#f00;"><?=$value['falsenum']?></strong></span><a href="javascript:;" class="chakan" onclick="showQDetqil(<?=$value['qid']?>);">查看</a></p>
							<div class="questionContainer">
					            <div class="subjectPane">
						            <span class="stIndex" style="float:left;"><?=$k?>. </span>
						            <span class="inputBox" style="float:left; width:965px;">
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
								<?=getquesdoc($value);?>
					        <div class="operateBar"><div class="delabtn delerror" name="<?=$value['eid']?>"></div></div>
				        </div>
					<?php }elseif($value['quetype']=='E'){
						if(!empty($value['ques'][0]))
							$value['ques'] = $value['ques'][0];?>
						<div class="que singleContainer singleContainerFocused" qsval="<?=$k?>">
							<p class="desc"><em>试题类型:</em><strong><?=$qtype[$value['quetype']]?></strong></span><span><em>错误数:</em><strong style="color:#f00;"><?=$value['falsenum']?></strong></span><a href="javascript:;" class=" chakan" onclick="showQDetqil(<?=$value['qid']?>);">查看</a></p>
				            <div class="subjectPane">
					            <span class="stIndex" style="float:left;"><?=$k?>. </span>
					            <span class="inputBox" style="float:left; width:965px;">
					            <?=$value['ques']['subject']?>
					            <em class="sorceLabel">[<?=$value['score']?>分]</em></span>
					            <span class="clearing"></span>
				            </div>
				            <div class="userAnswerBar">
				                <ul style="overflow:auto; zoom:1">
				                <li style="float:left;">我的答案：<span class="userAnsLabel"><?=isset($value['erranswers'])?$value['erranswers']:"没填"?></span></li>
				                <li style="float:left;"><span class="markFalse">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></li>
				                </ul>
				            </div>
				            <div class="answerBar">正确答案：<span class="answerLabel"><?=$value['ques']['answers']?></span></div>

							<?=getquesdoc($value);?>

				            <div class="operateBar"><div class="delabtn delerror" name="<?=$value['eid']?>"></div></div>
				        </div>
				<?php }

                }
				echo $pagestr;
				
				}else{?>
                <p class="zymc"><span><strong title="<?=$title?>"><?=shortstr($title,35)?></strong></span></p>

<!--                <div style="width:1000px;clear:both;border-top:0px solid #ccc;padding-top:10px;text-align:center;font-size: large">暂无记录</div>-->
                <div class="nodata"></div>
				<?php }?>
				
		</div>
	</div>
<script type="text/javascript">
var tip = '请输入试题标题关键字';
$(function(){
	initsearch('search',tip);
	$('#searchbuttons').click(function(){
		<?php $classid = empty($classid)?'0':$classid?>
		var href = '<?=geturl('troomv2/statisticanalysis/classerrorbook-0-0-0-'.$classid)?>';

		if($("#search").val()=='请输入试题标题关键字'){
			var searchvalue = '';
		}else{
			var searchvalue = $("#search").val();
		}
		if(searchvalue=='请输入试题标题关键字'){
			searchvalue='';
		}
		location.href = href+"?q="+searchvalue;
	});

});
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
<!-- ================================== -->
<script>
	var crid = <?php echo $room['crid'];?>;
	function showQDetqil(quesid){
		$.ajax({
			type: "POST",
            url: "<?=geturl('troomv2/statisticanalysis/getTotalErrors')?>",
            data: {quesid:quesid,<?php if(isset($gradeid)){?>gradeid:<?=$gradeid?><?php }else{?>classid:<?php echo $classid?><?php }?>},
            dataType: "json",
            success: function(res){
            	if(res.status ==1){
            		window.QTmp = new errorDialog(res.data);
            	}else{
            		$.showmessage({message:res.msg});
            	}
            }
		});
	}
	var errorDialog = function(str){
		this.init(str);
		this.showDialog();
	}
	errorDialog.prototype = {
		constructior:errorDialog,
		init:function(str){
			this.datas = $.parseJSON(str);
			this.datasLen = $(this.datas).length;
		},
		showDialog:function(){
			parent.window.H.create(new P({
				title:'错题查看',
				content: this.parseHtml(),
				easy:true
			}),'common').exec('show');
		},
		parseHtml:function(){
			var htmlStr = new Array();
			htmlStr.push("<div id='QDialog' style='text-align:center;border-bottom: 1px solid #E4E4E4;'>");
			htmlStr.push('<div class="header" style="padding-bottom: 0px; padding-top: 0px;height:60px;line-height:60px;border: 1px solid #E4E4E4;border-bottom: 0;"><div class="leftcol" style="width:100px;display:block;float:left;border-right: 1px solid #E4E4E4;" >学生姓名</div><div class="middlecol" style="width:698px;display:block;float:left;border-right: 1px solid #E4E4E4;" >学生答案</div><div class="rightcol" style="width:100px;display:block;float:left;">操作</div></div>');
			for(var i=0 ; i<this.datasLen ;i++){
                if(this.datas[i]['type']=='D'){
                    if(this.datas[i]['erranswers']==0){
                        this.datas[i]['erranswers']='X';
                    }else if(this.datas[i]['erranswers']==1){
                        this.datas[i]['erranswers']='√';
                    }
                }
				htmlStr.push('<div class="content" style="width:900px;min-height:60px;overflow:hidden;border: 1px solid #E4E4E4;border-bottom: 0;">');
				htmlStr.push('<div class="leftcol" style="width:100px;line-height:60px;display:block;float:left;">'+(this.datas[i].realname || this.datas[i].username)+'</div>');
				htmlStr.push('<div class="middlecol" style="font: 14px Arial,sans-serif;color: #282;font-weight: bold;width:698px;line-height:60px;float:left;overflow: hidden;border-right: 1px solid #E4E4E4;border-left: 1px solid #E4E4E4;">'+this.parseAnswers(this.datas[i]['erranswers'],this.datas[i]['type'])+'&nbsp;</div>');
				htmlStr.push('<div class="rightcol" style="font: 14px Arial,sans-serif;color: #282;font-weight: bold;width:100px;line-height:60px;float:left;overflow: hidden;"><a style="padding: 5px 10px;color: #FFFFEE;background: #18a8f7; text-decoration: none; cursor: pointer;border: none;" class="workBtn" href="http://exam.ebanhui.com/etmark/'+this.datas[i]['aid']+'.html?crid='+crid+'" target="_blank"><span>'+(this.datas[i]['tid']>0?'查看':'批阅')+'</span></a></div>');
				htmlStr.push('</div>');
			}
			htmlStr.push("</div>");
			this.html = htmlStr.join("");
			return this.html;
		},
		parseAnswers:function(answers,type){
			var answerslen = answers.length;
			var res = new Array();
			if(type=='C'){
				for(var i = 0; i<answerslen ;i++){
					if($.trim(answers[i])==""){
						answers[i] = '<span style="color:#FF024F">未填</span>';
					}else{
						if(/ebh_1_data-latexebh_2_/.test(answers[i])){//解析公式图片
							if(/commonimg/.test(answers[i])){
								answers[i] = answers[i].replace(/ebh_1_/g,' ').replace(/ebh_2_/g,'=');
							}else{
								answers[i] = unescape(answers[i].replace(/ebh_1_/g,' ').replace(/ebh_2_/g,'='));
							}
							answers[i] = '<img onclick="parent.window.showimage2(this)" style="max-height:50px;vertical-align:middle;cursor:pointer;"'+answers[i]+' />';
						}
					}   
					
					res.push(answers[i]);
				}
			}else{
				if(!answers){
						answers = '<span style="color:#FF024F">未填</span>';
					}
				res.push(answers);
			}
			return res.join(' , ');
		}
	}
</script>
<!-- =========================== -->
<?php
$this->display('common/player');
$this->display('aroom/page_footer');
?>
