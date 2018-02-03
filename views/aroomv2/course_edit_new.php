<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php $v=getv();?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css<?=$v?>" />
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css<?=$v?>" />
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/aroomv2-style.css<?=$v?>" />
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/2016/css/covers.css<?=$v?>" />

<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js<?=$v?>"></script>
<title>课程编辑</title>
</head>

<body>

<!-- 代码 开始 -->
<div class="">
 	<div class="ter_tit">
		当前位置 &gt; <a href="<?=geturl('aroomv2/course')?>">课程管理</a> &gt; <a href="<?=geturl('aroomv2/course/courses')?>">本校课程</a> &gt; 课程编辑
	</div>
 	<div class="lefrig" style="border-bottom:none;background:#fff;float:left;margin-top:15px;width:788px;">
	<form id="courseaddform" autocomplete="off">
		<input type="hidden" value="<?=$coursedetail['folderid']?>" name="folderid"/>
		<h2 class="sckezi2">基本信息</h2>
		<div class="cernter">
			<input id="img" type="hidden" name="img" value="<?=$coursedetail['img']?>" />
			<?php if($roominfo['template'] == 'plate'){
				$img = show_plate_course_cover($coursedetail['img']);
				?>
			<div class="sedres">
				<img id="folderimg" src="<?=empty($coursedetail['img'])?'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_247_147.jpg':show_thumb($img, '247_147')?>" style="width:247px;height:147px;" border="0">
			</div>
			<?php }else{?>
			<div class="sedresr">
				<img id="folderimg" src="<?=empty($coursedetail['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$coursedetail['img']?>" style="width:114px;height:159px;" border="0">
			</div>
			<?php }?>
			<input id="cqbc" class="lasrbtn" value="修改课程封面" name="Submit" type="button">
		</div>
		<div class="ewartre">
		<span class="puspan redxing">课程名称：</span>
			<input class="shuter" name="foldername" type="text" id="foldername" value="<?=$coursedetail['iname']?>" placeholder="如：高一语文（上册）" irequired="true"/>
		</div>
		<div class="ewartre">
		<span class="puspan redxing">课程介绍：</span>
			<textarea class="duosxsr" name="summary" maxlength="200" id="summary" cols="45" rows="5" placeholder="请输入课程简介" irequired="true"><?=$coursedetail['isummary']?></textarea>
		</div>
		<div class="ewartre">
		<span class="puspan">主讲教师：</span>
			<input class="shuter" name="speaker" type="text" id="" value="<?=empty($coursedetail['speaker'])?'主讲老师':$coursedetail['speaker']?>" placeholder="如：吴老师（省特级数学老师）" />
		</div>
		<div class="ewartre">
		<span class="puspan redxing">课程分类：</span>
			<select class="xuwatde" name="pid" id="list_sp" irequired="true"></select>
			<select class="xuwatde" name="sid" id="list_sort" style="display:none;margin-left: 20px;"></select>
			<p class="huitsser">请为课程选择所属分类。<a style="color:#4c8eff;text-decoration:none" href="/aroomv2/coursesort.html" target="_blank">新建分类</a></p>
		</div>
		<div class="ewartre">
			<span class="puspan redxing">课程价格：</span>
			<?php $iprice = intval($coursedetail['iprice']);
				$isfree = empty($iprice)?1:0;
				$price = $isfree?'':$iprice;
				
			?>
			<label class="lenwsie"><input class="isfree" style="vertical-align:middle;margin-right:5px;" type="radio" name="isfree" value="0" checked="checked"/>收费</label><i class="wenrtsd aboutthis" tipid="freetip"></i>
			<label class="lenwsie"><input class="isfree" style="vertical-align:middle;margin-right:5px;" type="radio" name="isfree" value="1"/>免费</label><i class="wenrtsd aboutthis" tipid="paytip"></i>
		</div>
		<div class="ewartre" id="priceblock" style="">
			<div class="botmer">
				<div class="topmer"></div>
				<p class="huisrt"><span class="huisprt">课程价格：</span><input class="husrrt intinput" name="fprice" type="text" id="priceinput" value="<?=$price?>" maxlength="9" irequired="true"/>元</p>
				<p class="huisrt">注：请填写正整数。</p>
			</div>
		</div>
		<div class="ewartre">
		<span class="puspan redxing" style="width:115px;">课程有效期：</span>
			<div class="huierte">
			<label class="lenwsie"><input style="vertical-align: middle;margin-right:5px;" class="bywhich" type="radio" name="bywhich" value="0" checked="checked"/>按月：</label>
				<input class="anyuedt intinput" name="imonth" type="text" id="bym_input" value="<?=empty($coursedetail['imonth'])?'':$coursedetail['imonth']?>" maxlength="3" irequired="true"/><span class="jisrtwe">个月</span>
			</div>
			<div class="huierte">
			<label class="lenwsie"><input style="vertical-align: middle;margin-right:5px;" class="bywhich" type="radio" name="bywhich" value="1" />按日：</label>
				<input class="anyuedt intinput" style="background:#CCC" readonly="readonly" name="iday" type="text" id="byd_input" value="<?=empty($coursedetail['iday'])?'':$coursedetail['iday']?>" maxlength="3"/><span class="jisrtwe">日</span>
			</div>
		</div>
		<div class="ewartre">
		<span class="puspan">详细介绍：</span>
			<div style="float:left">
			<?php $editor->xEditor('detail','650px','300px',$coursedetail['detail']);?>
			</div>
		</div>
		<h2 class="sckezi2">其他设置<span class="huifeis"> (非必选)</span><a class="shoutra osettoggle expand" href="javascript:void(0)">展开</a></h2>
		<div class="othersettings" style="display:none">
			<div class="flefle">
			<h3 class="tistsee">显示设置：</h3>
			<?php if($roominfo['template'] == 'plate'){?>
			<p class="huretwes">
				<i class="wenicos aboutthis" tipid="coursetip"></i>
					<span class="fuhuiert">首页课程排列：</span>
					<label class="husirtrt aboutthis" tipid="gridtip"><input style="vertical-align: middle;margin-right:5px;" type="radio" name="view_mode" class="view_mode" id="" value="0" checked="checked"/>网格模式</label>
					<label class="husirtrt aboutthis" tipid="listtip"><input style="vertical-align: middle;margin-right:5px;" type="radio" name="view_mode" class="view_mode" id="" value="1" />列表形式（1/2模块宽度）</label>
					<label class="husirtrt aboutthis" tipid="alllisttip"><input style="vertical-align: middle;margin-right:5px;" type="radio" name="view_mode" class="view_mode" id="" value="2"/>列表形式（全模块宽度）</label>
				</p>
			<?php }?>
			<p class="huretwes">
				<i class="wenicos aboutthis" tipid="cwtip"></i>
					<span class="fuhuiert">后台课件排列：</span>
					<label class="husirtrt aboutthis" tipid="alllisttip"><input style="vertical-align: middle;margin-right:5px;" type="radio" name="showmode" class="showmode" id="" value="2" checked="checked"/>列表模式</label>
					<label class="husirtrt aboutthis" tipid="gridtip"><input style="vertical-align: middle;margin-right:5px;" type="radio" name="showmode" class="showmode" id="" value="1"/>网格模式</label>
					<label class="husirtrt aboutthis" tipid="detailtip"><input style="vertical-align: middle;margin-right:5px;" type="radio" name="showmode" class="showmode" id="" value="3" />详情模式</label>
				</p>
			<p class="huretwes">
				<i class="wenicos aboutthis" tipid="pertip"></i>
					<span class="fuhuiert">课程权限：</span>
					<label class="husirtrt"><input style="vertical-align: middle;margin-right:5px;" type="radio" name="power" class="power" id="" value="0" checked="checked"/>老师学生都有权限</label>
					<label class="husirtrt"><input style="vertical-align: middle;margin-right:5px;" type="radio" name="power" class="power" id="" value="1" />只有老师有权限</label>
					<label class="husirtrt"><input style="vertical-align: middle;margin-right:5px;" type="radio" name="power" class="power" id="" value="2" />没有权限</label>
				</p>
			</div>
			<div class="flefle">
				<h3 class="tistsee">学分设置：</h3>
				<div class="huretwes">
				<span class="hnuistle">课程学分：</span>
					<input class="anyuedt intinput" name="credit" type="text" id="credit" value="<?= empty($coursedetail['credit'])?10:$coursedetail['credit']?>" maxlength="5"/><span class="jduetser">分</span>
				</div>
				<div class="huretwes">
				<span class="hnuistle">获取方式：</span>
					<label class="lenwsie" style="margin-right:30px;"><input style="vertical-align: middle;margin-right:5px;" type="radio" name="creditmode" class="creditmode" value="0" checked="checked"/>按学习进度</label>
					<label class="lenwsie"><input style="vertical-align: middle;margin-right:5px;" type="radio" name="creditmode" class="creditmode" value="1" />按累计学习时长</label>
				</div>
				<?php $creditrule = $coursedetail['creditrule'];$rulearr = explode(':',$creditrule);$coursecredit = empty($rulearr) ? 0 : $rulearr[0];$examcredit = count($rulearr)>1 ? $rulearr[1] : 0; ?>
				<div class="huretwes">
					<div class="botmer modeprogress" style="height:70px;margin-top:0px;">
						<div class="topmer"></div>
						<p class="huisrt"><span class="huisprt">课件占比：</span><input class="husrrt intinput" name="coursecredit" id="coursecredit" value="<?= $coursecredit ?>" type="text" maxlength="3">%</p>
						<p class="huisrt"><span class="huisprt">作业占比：</span><input class="husrrt intinput" name="examcredit" id="examcredit" value="<?= $examcredit ?>" type="text" maxlength="3">%</p>
					</div>
					<div class="botmer modetime" style="height:40px;margin-top:0px;margin-left:220px;width:180px;display:none">
						<div class="topmer"></div>
						<p class="huisrt"><span class="huisprt">累计时长：</span><input class="husrrt intinput" name="credittime" id="" value="<?=$coursedetail['credittime']/60?>" type="text">分钟</p>
					</div>
				</div>
			</div>
			<div class="flefle">
				<h3 class="tistsee">学习设置：</h3>
				<div class="huretwes">
				<span class="hnuistle" style="width:148px">学习顺序限制：</span>
					<a href="javascript:void(0)" class="lrbtn playmode"></a>
					<input type="hidden" name="playmode" value="0"/>
					<span class="tisheyi">学员必须按课时顺序学习，否则无法打开下一课时</span>
				</div>
				<div class="huretwes">
				<span class="hnuistle" style="width:148px">学习提醒：</span>
					<a href="javascript:void(0)" class="lrbtn isremind"></a>
					<input type="hidden" name="isremind" value="0"/>
				</div>
				<div class="huretwes remindblock" style="display:none">
					<div class="botmer reminds" style="padding-bottom:5px;height:auto;margin-top:0px;margin-left:110px;width:545px">
						<div class="topmer"></div>
						<?php if(!empty($coursedetail['remindtime'])) {
							$remindtime = $coursedetail['remindtime'];
							$rtarr = explode(',',$remindtime);
							$remindmsg = $coursedetail['remindmsg'];
							$rmarr = explode('#',$remindmsg);
							if(!empty($rtarr)) {
								for($i = 0; $i < count($rtarr); $i ++) {
						?>
						<div>
							<p class="huisrt">
							<span class="huisprt">提醒时间：第</span><input class="husrrt intinput" name="remindtime[]" id="" value="<?= $rtarr[$i]/60 ?>"  type="text" maxlength="3"><span class="huisprt">分钟</span>
								<span class="huisprt" style="margin-left:20px;">提醒内容：</span><input style="width:260px;" class="husrrt" name="remindmsg[]" id="" value="<?= empty($rmarr[$i])?'':$rmarr[$i] ?>"  type="text">
							</p>
							<a href="javascript:void(0)" class="xutianbtn" onclick="addremind()">继续添加</a>
							<?php if($i != 0){?>
							<a href="javascript:void(0)" class="xutianbtn" onclick="delremind(this)">删除</a>
							<?php }?>
						</div>
								<?php }
							}
						}else{?>
						<div>
							<p class="huisrt">
							<span class="huisprt">提醒时间：第</span><input class="husrrt intinput" name="remindtime[]" id="" value=""  type="text" maxlength="3"><span class="huisprt">分钟</span>
								<span class="huisprt" style="margin-left:20px;">提醒内容：</span><input style="width:260px;" class="husrrt" name="remindmsg[]" id="" value=""  type="text">
							</p>
							<a href="javascript:void(0)" class="xutianbtn" onclick="addremind()">继续添加</a>
						</div>
						<?php }?>
					</div>
				</div>
			</div>
		</div>
		<div class="weibtse">
		<a href="javascript:void(0)" class="fasetbtn">发 布</a>
		</div>
		<input name="isajax" value="true" type="hidden"/>
		</form>
	</div>
	
<div style="display:none" id="tips">
	<div id="paytip" style="width:126px;height:63px">
		<p>所有拥有平台账号的人员都可以进入您的网校学习这门课程。</p>
	</div>
	<div id="freetip" style="width:160px;height:63px">
		<p class="phone_text">具体结算流程及细则详询:</p><p class="phone_text">靳老师：13757168928</p><p class="phone_text">陈老师：13957170417</p>
	</div>
	<div id="cwtip" style="width:170px;height:63px">
		<p>此处的设置将影响学生进入网校后台，查看某课程时，课件的排列方式。</p>
	</div>
	<div id="coursetip" style="width:160px;height:83px">
		<p>此处的设置将影响您网校首页的课程展示方式。（仅在X3课程列表中有效）</p>
	</div>
	<div id="pertip" style="width:200px;height:205px">
		<p>老师学生都有权限：</p>
		<p>表示该课程正常销售。</p>
		<br>
		<p>只有老师有权限：</p>
		<p>表示该课程不进行销售，仅内部教师可查看。</p>
		<br>
		<p>没有权限：</p>
		<p>表示该课程不开放，仅自己能查看。</p>
	</div>
	<div id="gridtip" nobg="true" style="width:190;height:120px">
		<img src="http://static.ebanhui.com/ebh/tpl/2016/images/list_grid.png"/>
	</div>
	<div id="listtip" nobg="true" style="width:190;height:120px">
		<img src="http://static.ebanhui.com/ebh/tpl/2016/images/list_halfwidth.png"/>
	</div>
	<div id="alllisttip" nobg="true" style="width:190;height:120px">
		<img src="http://static.ebanhui.com/ebh/tpl/2016/images/list_allwidth.png"/>
	</div>
	<div id="detailtip" nobg="true" style="width:190;height:120px">
		<img src="http://static.ebanhui.com/ebh/tpl/2016/images/list_details.png"/>
	</div>
</div>

<div id="dialogimg" style="display:none">
	<div class="tab_menu" style="float:left;*margin-top:-14px;">
		<ul>
			<li id="uploadli"  class="selected" onclick="changepanel('upload')">自定义图片</li>
			<li id="systemli" onclick="changepanel('system')">从图片库里选择</li>
		</ul>
	</div>
	
	<div class="tab_box" style="main-height:620px;float:left;border:none;border-top:solid 1px #cdcdcd;">
		<div class="ecenter" id="upload" style="padding:0;" >
			<iframe id="imgFrame" name="imgFrame" scrolling="no" width="760" height="460" frameborder="0" src=""></iframe>
		</div>
		
		<div class="ecenter" id="system" style="display:none">
			<?php if ($roominfo['template'] == 'plate') { ?>
				<!--plate模板封面图库-->
				<div class="xttxlist3 cover_page" >
					<ul id="page1">

						<?php $count=0;
						foreach($imgarr as $img){
						$count++;
						if($count>20 && $count%20==1){
						?>
					</ul>
					<ul id="page<?=intval($count/20)+1?>" style="display:none;">
						<?php }?>
						<li class="xtpage" style="margin:8px"><a href="#"><img d="<?=show_thumb($img, '247_147')?>" Jimg="a" width="129" height="77" src="<?=show_thumb($img, '129_77')?>" /></a></li>
						<?php }?>
					</ul>
				<?php if($count>20){?>
					<div class="pages" style="width:360px; margin-top: 20px;clear:both;">
						<div class="listPage" style="float:right;">
							<a id="prev" href="javascript:topage(1)" style="width: 60px;">&lt;&lt;上一页</a>
							<?php for($i=0;$i<=intval($count/20);$i++){?>
							<a id="pagelink<?=$i+1?>" href="javascript:topage(<?=$i+1?>)"><?=$i+1?></a>
							<?php }?>
							<a id="next" href="javascript:topage(2)">下一页&gt;&gt;</a>
						</div>
					</div>
				<?php }?>
			</div>
			<?php } else { ?>
				<div class="xttxlist2 cover_page" style="width:727px;float:left;">
					<ul id="page1">

						<?php $count=0;
						foreach($imgarr as $img){
						$count++;
						if($count>20 && $count%20==1){
						?>
					</ul>
					<ul id="page<?=intval($count/20)+1?>" style="display:none;">
						<?php }?>
						<li><a href="#"><img Jimg="a" width="114" height="159" src="<?=$img?>" /></a></li>
						<?php }?>
					</ul>

				<?php if($count>20){?>
				<div class="pages" style="width:360px; margin-top: 20px;clear:both;">
					<div class="listPage" style="float:right;">
						<a id="prev" href="javascript:topage(1)" style="width: 60px;">&lt;&lt;上一页</a>
						<?php for($i=0;$i<=intval($count/20);$i++){?>
						<a id="pagelink<?=$i+1?>" href="javascript:topage(<?=$i+1?>)"><?=$i+1?></a>
						<?php }?>
						<a id="next" href="javascript:topage(2)">下一页&gt;&gt;</a>
					</div>
				</div>
				<?php }?>
					</div>
			<?php } ?>
		</div>
	</div>
</div>
<script>
var editorwidth = 770;
	$(function(){
		showsp();
		checkedinit();
		
	});
	function checkedinit(){
		var isfree = <?=$isfree?>;
		$('.isfree[value='+isfree+']').trigger('click');
		
		var pid = <?=$coursedetail['pid']?>;
		var sid = <?=$coursedetail['sid']?>;
		$('#list_sp').val(pid);
		renderlist(sortarr[pid],'list_sort','s');
		$('#list_sort').val(sid);
		
		var imonth = <?=empty($coursedetail['imonth'])?1:0?>;
		$('.bywhich[value='+imonth+']').trigger('click');
		
		var showmode = <?=$coursedetail['showmode']?>;
		$('.showmode[value='+showmode+']').trigger('click');
		var view_mode = <?=$coursedetail['view_mode']?>;
		$('.view_mode[value='+view_mode+']').trigger('click');
		var power = <?=$coursedetail['power']?>;
		$('.power[value='+power+']').trigger('click');
		var creditmode = <?=$coursedetail['creditmode']?>;
		$('.creditmode[value='+creditmode+']').trigger('click');
		var playmode = <?=$coursedetail['playmode']?>;
		if(playmode)
			$('.playmode').trigger('click');
		var isremind = <?=$coursedetail['isremind']?>;
		if(isremind)
			$('.isremind').trigger('click');
	}
	var changepanel = function(panel){
		$(".tab_menu li").removeClass("selected");
		$("#"+panel+"li").addClass("selected");
		$(".ecenter").hide();
		$("#"+panel).show();
		top.resetmain();
	}
	$(".cover_page img").click(function(){
		if ($(this).attr('d')) {
			$("#folderimg").attr('src',$(this).attr('d'));
			$("#img").val($(this).attr('d'));
		} else {
			$("#folderimg").attr('src',$(this).attr('src'));
			$("#img").val($(this).attr('src'));
		}
		H.get('dialogimg').exec('close');
	});
	<?php if ($roominfo['template'] == 'plate') { ?>
	var changeimg = function(url, showurl){
		$("#folderimg").attr('src',showurl);
		$("#img").val(showurl);
		H.get('dialogimg').exec('close');
	}

	<?php } else { ?>
	var changeimg = function(url){
		$("#folderimg").attr('src',url);
		$("#img").val(url);
		H.get('dialogimg').exec('close');
	}
	<?php } ?>
	var sortarr;
	function showsp(){
		sortarr = new Array();
		$('#list_sort').hide();
		$.ajax({
			url:'/aroomv2/coursesort/getSplist.html',
			dataType:'json',
			type:'post',
			data:{'showbysort':0},
			async:false,
			success:function(data){
				$.each(data.sortlist,function(k,v){
					if(sortarr[v.pid])
						sortarr[v.pid].push(v);
					else{
						sortarr[v.pid] = new Array(v);
					}
				});
				
				renderlist(data.splist,'list_sp','p');
			}
		});
		
	}
	function renderlist(listdata,target,mark){
		var optionstr = '';
		$('#'+target).empty();
		if(listdata){
			optionstr += '<option value="0">请选择</option>'
			$.each(listdata,function(k,v){
				var name = mark+'name';
				var id = mark+'id';
				optionstr+= '<option value="'+v[id]+'">'+v[name]+'</option>';
				
			});
			$('#'+target).append(optionstr).show();
		}else{
			$('#'+target).hide();
		}
	}
	$('#list_sp').change(function(){
		var pid = $(this).val();
		renderlist(sortarr[pid],'list_sort','s');
	});
	$('#list_sp,#list_sort').change(function(){
		$(this).attr('title',$(this).find("option:selected").text());
	});
	
	$('.isfree').click(function(){
		if($(this).val()==0){
			$('#priceblock').show();
			$('#priceinput').attr('irequired',true);
		}else{
			$('#priceblock').hide();
			$('#priceinput').attr('irequired',false);
		}
	});
	$(".aboutthis").hover(function(){
		var theleft = $(this).offset().left;
		var thetop = $(this).offset().top;
		var tipid = $(this).attr('tipid');
		
		var tipdiv = $('#'+tipid);
		var nobg = false;
		if(tipdiv.attr('nobg'))
			nobg = true;
		thewidth = tipdiv.width();
		theheight = tipdiv.height();
		top.showbubble(theleft,thetop,tipdiv.html(),thewidth,theheight,nobg);
		
	},function(){
		top.hidebubble();
	});
	
	$('.fasetbtn').click(function(){
		if(!checkform())
			return false;
		if($(this).attr('disabled') == true || $(this).attr('disabled') == 'disabled')
			return false;
		$(this).addClass('cannotsubmit');
		$(this).text('发布中...');
		$(this).attr('disabled',true);
		var sbtn = $(this);
		$.ajax({
			url:'/aroomv2/course/edit.html',
			type:'post',
			data:$('#courseaddform').serialize(),
			dataType:'json',
			success:function(data){
				if(data.status == false){
					sbtn.removeClass('cannotsubmit');
					sbtn.text('发布');
					sbtn.attr('disabled',false);
					var targetlist = $('#list_'+data.idtype);
					
					name = targetlist.find("option:selected").text();
					alert(data.msg.replace('[name]',name));
					showsp();
				}else{
					sbtn.removeClass('cannotsubmit');
					sbtn.text('发布成功');
					location.href="/aroomv2/course/courselist.html"
				}
			}
		});
	});
	$(document).on('keyup','.intinput',function(){
		$(this).val($(this).val().replace(/[^\d]/g,'').replace(/0*(\d+)/g,"$1"));
		
	}).on('keyup','#priceinput,#bym_input,#byd_input',function(){
		if($(this).val()==0)
			$(this).val('');
	}).on('keyup','#bym_input',function(){
		if($(this).val()>36)
			$(this).val(36);
	}).on('keyup','#summary',function(){
		if($(this).val().length > 200){
			$(this).val($(this).val().substring(0,200));
		}
	})
	
	$('.osettoggle').click(function(){
		$('.othersettings').toggle();
		$(this).toggleClass('expand');
		if($(this).hasClass('expand'))
			$(this).text('展开');
		else
			$(this).text('收起');
		
		top.resetmain();
	});
	$('.creditmode').click(function(){
		if($(this).val()==0){
			$('.modeprogress').show();
			$('.modetime').hide();
		}else{
			$('.modeprogress').hide();
			$('.modetime').show();
		}
	})
	$('.lrbtn').click(function(){
		$(this).toggleClass('lravailable');
		hideinput = $(this).next('input[type=hidden]');
		hideinput.val(1-hideinput.val());
		
		if(hideinput.attr('name') == 'isremind'){
			$('.remindblock').toggle();
			
		}
	});
	$('.bywhich').click(function(){
		if($(this).val() == 0){
			$('#byd_input').attr('readonly','readonly').attr('irequired',false).css('background','#CCC');
			$('#bym_input').attr('irequired',true).removeAttr('readonly').css('background','#fff');
		}else{
			$('#bym_input').attr('readonly','readonly').attr('irequired',false).css('background','#CCC');
			$('#byd_input').attr('irequired',true).removeAttr('readonly').css('background','#fff');
		}
	});
	function checkform(){
		return checkirequired();
	}
	function checkirequired(){
		var elements = $('input[irequired=true],select[irequired=true],textarea[irequired=true]');
		var notfill;
		$.each(elements,function(k,v){
			if($.trim($(this).val())=='' || (v.tagName=='SELECT' && $(this).val() == 0)){
				
				notfill = $(this);
				return false;
			}
		});
		// c(notfill);
		if(notfill){
			notfill.focus();
			playnotice(notfill);
			return false;
		}
		return true;
	}
	$('input[irequired=true],textarea[irequired=true]').keyup(function(){
		if($.trim($(this).val()) != '')
			$(this).removeClass('borderred');
	})
	function playnotice(target){
		$('.borderred').removeClass('borderred');
		var times = 0;
		var itv = setInterval(function(){
			if(times<5){
				target.toggleClass('borderred');
				times++;
			}else{
				clearInterval(itv);
			}
		},200);
	}
	function c(t){
		console.log(t);
	}
	function addremind(){
		var htmlstr = '<div><p class="huisrt">'
						+'<span class="huisprt">提醒时间：第</span><input class="husrrt intinput" name="remindtime[]" id="" value=""  type="text" maxlength="3"><span class="huisprt">分钟</span>'
						+'<span class="huisprt" style="margin-left:20px;">提醒内容：</span><input style="width:260px;" class="husrrt" name="remindmsg[]" id="" value=""  type="text">'
						+'</p>'
						+'<a href="javascript:void(0)" class="xutianbtn" onclick="addremind()">继续添加</a>'
						+'<a href="javascript:void(0)" class="xutianbtn" onclick="delremind(this)">删除</a>'
						+'</div>'
		$('.reminds').append(htmlstr);
		top.resetmain();
	}
	function delremind(obj) {
		$(obj).parent().remove();
		top.resetmain();
	}
	$('#cqbc').click(function(){
		
		if(!H.get('dialogimg')){
			H.create(new P({
				id : 'dialogimg',
				title: '设置封面',
				easy:true,
				width:760,
				padding:5,
				content:$('#dialogimg')[0]
			}),'common');
		}
		H.get('dialogimg').exec('show');
		<?php
			$img = empty($coursedetail['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$coursedetail['img'];
		?>
		$("#imgFrame").attr("src",'<?=geturl('uploadimage/img')?>?initurl=<?=urlencode($img)?>');
	
	})
	var topage = function(page){
		$(".cover_page ul").hide();
		$("#page"+page).show();
		$("#prev").attr('href','javascript:topage('+(page==1?1:page-1)+')');
		$("#next").attr('href','javascript:topage('+(page==$(".listPage a").length-2?$(".listPage a").length-2:page+1)+')');
		$(".listPage a").removeClass('none');
		$("#pagelink"+page).addClass('none');
	}
	var pairarr = {'coursecredit':'examcredit','examcredit':'coursecredit'};
	$('#coursecredit,#examcredit').blur(function(){
		var targetid = $(this).attr('id');
		var theother = $('#'+pairarr[targetid]);
		
		var theval = $(this).val();
		if(theval<=100)
			theother.val(100-theval);
		else{
			$(this).val(100);
			theother.val(0);
		}
	});
	$.includePath = 'http://static.ebanhui.com/js/dialog/';
	$.include(['dialog-plus.js']);
	$.include(['css/dialog.css']);
</script>
<!-- 代码 结束 -->
</body>
</html>
