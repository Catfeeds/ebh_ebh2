<?php $this->display('troomv2/page_header');?>
    <link href="http://exam.ebanhui.com/static/css/base.css" rel="stylesheet" type="text/css"/>
    <link href="http://exam.ebanhui.com/static/css/done.css" rel="stylesheet" type="text/css"/>
    <link href="http://exam.ebanhui.com/static/css/public.bak.css" rel="stylesheet" type="text/css"/>
    <link href="http://exam.ebanhui.com/static/css/jqtransform.css" rel="stylesheet" type="text/css"/>
    <link type="text/css" href="http://exam.ebanhui.com/static/css/wavplayer.css" rel="stylesheet"/>

<style type="text/css">
.delabtn{background:url(http://exam.ebanhui.com/static/images/dela.png) no-repeat;width:79px;height:25px;float:right;cursor:pointer;margin-bottom:5px}
.delahbtn{background:url(http://exam.ebanhui.com/static/images/delah.png) no-repeat;width:79px;height:25px;float:right;cursor:pointer;margin-bottom:5px}

#errlist .que{clear:both;padding:5px 0 25px;height:auto;}
#errlist .que p.desc{font-size:12px;height:35px;line-height: 35px;color:#3a3a3a;display: inline-block;border:1px solid #f3f3f3;background: #f3f3f3;width: 983px; margin:0 5px;padding-left:5px;}
#errlist .que p.desc span{display: inline-block;margin-right: 25px;}
#errlist .que p.desc em{margin-right: 8px;}
.work_search ul li {display:inline-block;float: left;height:55px;line-height: 55px;}
#errlist .que .operateBar{display: none;}
#errlist .que .optionContent img{vertical-align: middle;}

#icategory {
    background:#fff;
    border-top: 1px solid #E1E7F5;
    padding: 6px 20px;
	_margin-bottom:-5px;
}
#icategory dt {
    float: left;
    line-height: 22px;
    padding-right: 5px;
    text-align: left;
	font-size:14px;
	color:#999;
}
#icategory dd {
    float: left;
    width: 885px;
}
.price_cont div a:hover, .price_cont div a.curr {
	background: none repeat scroll 0 0 #FF5400;
	color: #FFFFFF;
	text-decoration: none;
}
.category_cont1 div a.curr,.category_cont1 div a:hover{
	color:#5e96f5;
	color:#fff;
}
.category_cont1 div a {
    color: #333;
    text-decoration: none;
    padding: 2px 5px;
	font-size:14px;
}
.category_cont1 div a.curr , .category_cont1 div a:hover{
    color: #fff;
    text-decoration: none;
    padding: 2px 5px;
	font-size:14px;
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
.waitite{
	border-bottom:none;
	background:#fff;
}
.subjectPane {
    padding-left: 10px;
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
	width:100% !important;
}
</style>


<div class="lefrig" >
	<div class="waitite">
		<div class="work_menu" style="position:relative;margin-top:0">
			<ul>
				<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso">错题集</span></a></li>
			</ul>
		</div>
		<div class="diles">
			<input name="search" class="newsou" <?php if($q!='请输入错题名称'){echo 'style="color:#000"';}?> id="search" value="<?= $q ?>" type="text" />
			<input type="button" class="soulico" name="searchbutton" id="searchbuttons" value="">
		</div>
	</div>
		<!-- ===课程筛选开始=== -->
		<?php if(!empty($folderList)){?>
			<div id="icategory" class="clearfix">
				<dt>所属课程：</dt>
				<dd>
					<div class="category_cont1">
						<div>
							<a <?= empty($folderid)?'class="curr"':'' ?> href="<?= geturl('troomv2/statisticanalysis/errors-1-0-0-'.$classid) ?>">全部课程</a>
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
		<?php }?>
		<!-- ===课程筛选结束=== -->
		<div id="icategory" class="clearfix" style="border:none;">
				<dt>所属班级：</dt>
				<dd>
					<div class="category_cont1">
						<div>
							<a <?= empty($classid)?'class="curr"':'' ?> href="<?= geturl('troomv2/statisticanalysis/errors-0-0-0-0-'.$folderid) ?>">全部班级</a>
						</div>
						
						<?php foreach($classlist as $myclass) { ?>
						<div>
							<a <?= $classid==$myclass['classid']?'class="curr"':''?> href="<?= geturl('troomv2/statisticanalysis/errors-0-0-0-'.$myclass['classid'].'-'.$folderid) ?>"><?= $myclass['classname'] ?></a>
						</div>
						<?php } ?>
					</div>
				</dd>
			</div>
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
						<p class="desc"><span><em>作业名称:</em><strong title="<?= $error['title'] ?>"><?= shortstr($error['title'],35)?></strong></span><span><em>添加时间:</em><strong><?= date('Y-m-d H:i',$error['dateline'])?></strong></span><span><em>试题类型:</em><strong><?= $qtype[$error['quetype']]?></strong></span><span><em>错误数:</em><strong style="color:#f85c72;"><?php echo $error['falsenum']?$error['falsenum']:0?></strong></span><a href="javascript:;" class="chakan" onclick="showQDetqil(<?=$error['quesid']?>);">查看</a></p>
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
						<p class="desc"><span><em>作业名称:</em><strong title="<?= $error['title']?>"><?= shortstr($error['title'],35)?></strong></span><span><em>添加时间:</em><strong><?= date('Y-m-d H:i',$error['dateline'])?></strong></span><span><em>试题类型:</em><strong><?= $qtype[$error['quetype']]?></strong></span><span><em>错误数:</em><strong style="color:#f85c72;"><?php echo $error['falsenum']?$error['falsenum']:0?></strong></span><a href="javascript:;" class="chakan" onclick="showQDetqil(<?=$error['quesid']?>);">查看</a></p>
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
						<p class="desc"><span><em>作业名称:</em><strong title="<?= $error['title'] ?>"><?= shortstr($error['title'],35)?></strong></span><span><em>添加时间:</em><strong><?= date('Y-m-d H:i',$error['dateline']) ?></strong></span><span><em>试题类型:</em><strong><?= $qtype[$error['quetype']] ?></strong></span><span><em>错误数:</em><strong style="color:#f85c72;"><?php echo $error['falsenum']?$error['falsenum']:0?></strong></span><a href="javascript:;" class="chakan" onclick="showQDetqil(<?=$error['quesid']?>);">查看</a></p>
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
						<p class="desc"><span><em>作业名称:</em><strong title="<?= $error['title'] ?>"><?= shortstr($error['title'],35) ?></strong></span><span><em>添加时间:</em><strong><?= date('Y-m-d H:i',$error['dateline']) ?></strong></span><span><em>试题类型:</em><strong><?= $qtype[$error['quetype']] ?></strong></span><span><em>错误数:</em><strong style="color:#f85c72;"><?php echo $error['falsenum']?$error['falsenum']:0?></strong></span><a href="javascript:;" class="chakan" onclick="showQDetqil(<?=$error['quesid']?>);">查看</a></p>
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
						<p class="desc"><span><em>作业名称:</em><strong title="<?= $error['title'] ?>"><?= shortstr($error['title'],35)?></strong></span><span><em>添加时间:</em><strong><?= date('Y-m-d H:i',$error['dateline']) ?></strong></span><span><em>试题类型:</em><strong><?= $qtype[$error['quetype']] ?></strong></span><span><em>错误数:</em><strong style="color:#f85c72;"><?php echo $error['falsenum']?$error['falsenum']:0?></strong></span><a href="javascript:;" class="chakan" onclick="showQDetqil(<?=$error['quesid']?>);">查看</a></p>
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
				 <div class="nodata"></div>
		<?php } ?>
	</div>
</div>
<script type="text/javascript">
var tip="请输入错题名称";
$(function(){
	initsearch('search',tip);
	$('#searchbuttons').click(function(){
		var href = '<?= geturl('troomv2/statisticanalysis/errors-0-0-0-'.$classid.'-'.$folderid) ?>';
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


function showQDetqil(quesid){
    $.ajax({
        type: "POST",
        url: "<?=geturl('troomv2/statisticanalysis/getTotalErrors')?>",
        data: {quesid:quesid,classid:<?=empty($classid)?0:$classid?>},
        dataType: "json",
        success: function(res){
        	console.log(res)
//            var res = eval('('+res+')');
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
var crid = <?php echo $roominfo['crid'];?>;
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
        }else if(type == 'D'){
            if(answers == 0){
                answers = '×';
            }else if(answers == 1){
                answers = '√';
            }else{
                answers = '<span style="color:#FF024F">未填</span>';
            }
            res.push(answers);
        } else {
            var answer = answers.replace(/&nbsp;/ig, '');
            if (answer == "") {
                answers = '<span style="color:#FF024F">未填</span>';
            }
            res.push(answers);
        }
        return res.join(' , ');
    }
}

</script>
<?php 
$this->display('common/player');
$this->display('troomv2/page_footer');
?>