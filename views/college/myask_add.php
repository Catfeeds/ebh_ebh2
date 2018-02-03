<?php $this->display('college/page_header'); ?>
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/dayi.css?v=20160325" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" />	
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/upload.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js?v=20150731"></script>
<link type="text/css" href="http://static.ebanhui.com/js/soundManager2/css/voicePlayer.css" rel="stylesheet" />
<style>
<?php if(!empty($imgsrc)){ ?>
body{
	margin-left: 15px;
}
<?php } ?>
.lefkty em{
	line-height:28px;
}
.wenzid{
	font-weight:bold;
	color:#777;
}
html{
	background:<?=$this->uri->uri_domain()!='zjdlr'?'#f2f2f2':'none'?>;
}
.leftke{
	width:88px;
	text-align:left;
}
.trekt{
	border:0;
}
.biaowaim .titwenti{ width:965px;}
.etklys{
	width:68px;
}
a.remove-img {
    border: 0 none;
    display: none;
    height: 17px;
    position: absolute;
    right: 5px;
    text-decoration: none;
    top: 5px;
    width: 17px;
}
a.remove-img:link {
    border: 0 none;
    display: none;
    height: 17px;
    text-decoration: none;
    width: 17px;
}
a.remove-img:visited {
    border: 0 none;
    display: none;
    height: 17px;
    text-decoration: none;
    width: 17px;
}
a.remove-img:hover {
    border: 0 none;
    display: none;
    height: 17px;
    text-decoration: none;
    width: 17px;
}
a.remove-img:active {
    border: 0 none;
    display: none;
    height: 17px;
    text-decoration: none;
    width: 17px;
}
.languan{
	background:url(http://static.ebanhui.com/ebh/tpl/troomv2/images/hrsire.png) no-repeat;
}
.sckcfm li {
    height: 110px;
    margin-bottom: 10px;
    margin-right: 10px;
}
.glitus{
	display: block;
    height: 108px;
    left: 1px;
    opacity: 0;
	filter: progid:DXImageTransform.Microsoft.Alpha(opacity=0);
    position: absolute;
    top: 1px;
    width: 178px;
}
</style>
<div style="height:1500px;width:788px;float:left;<?php if(!empty($imgsrc)) echo 'height:900px' ?>">

<div class="lefrig" style="width:998px;">
<div class="workol" style="margin-top:0px">

	<div class="tit_search" style="margin-top:0px">
<form id="askform">
<div class="biaowaim" style="width:1000px;border:none;">
  <input class="titwenti" name="title" id="title" type="text" value="" maxlength="50"/>
  <div class="txtxdaru" style="float:left;width:983px;display: inline;">

  <?php $editor->xEditor('message','99%','500px'); ?>

  </div>
  <div style="clear:both;"></div>
  
 <div class="fontfen" style="width:730px;margin-left:15px;margin-bottom:10px;margin-top:10px;height:50px;">
  <span class="wenzid" style="width:70px;">所属课程：</span>
	<div class="eeret" id="eeret1">
		<a class="ekiyt" href="javascript:void(0)">当前选择课程：<span id="show_foldername" class="show_foldername"><?= isset($folder['foldername'])?$folder['foldername']:'无';?></span></a>
		<input type="hidden" name="folderid" id="folderid"  value="<?=$folder['folderid']?>" />
	</div>
	<?php if($showTeacherSelect == true && !$iszjdlr){?>
	<span class="wenzid" style="width:70px;">指定老师：</span>
	<div class="eeret" id="eeret2" style="background:url(http://static.ebanhui.com/ebh/images/xuanter.jpg) no-repeat;width:140px;">
		<a class="ekiyt" href="javascript:void(0)" ><span class="show_terchername"><?=shortstr(empty($teacher['realname'])?'无':$teacher['realname'],16)?></span></a>
		<input type="hidden" name="tid" value="<?=empty($teacher['uid'])?'':$teacher['uid']?>" />
	</div>
	<?php } ?>

	<?php if($iszjdlr) { ?>
		<span class="wenzid" style="width:70px;">提问对象：</span>
		<div class="eeret" id="ask-for-students" style="background:url(http://static.ebanhui.com/ebh/images/xuanter.jpg) no-repeat;width:140px;">
			<a class="ekiyt" href="javascript:void(0)"><span class="show_studentname"><?=empty($student['realname'])?'无':$student['realname']?></span></a>
			<input type="hidden" name="tid" value="<?=empty($student['uid'])?'':$student['uid']?>" />
		</div>
	<?php } ?>
  </div>
  
  <div class="fontfen" style="width:700px;margin-left:15px;margin-bottom:10px;height:50px;<?=empty($cw)?'display:none':''?>" id="cwblock">
  <span class="wenzid" style="width:70px;">相关课件：</span>
	<div class="eeret" id="eeret3" onclick="showcw('选择课件')">
		<a class="ekiyt"  href="javascript:void(0)">当前选择课件：<span id="show_cwname" class=""><?= isset($cw['title'])?shortstr($cw['title'],44):'无';?></span></a>
		<input type="hidden" name="cwname" id="cwname" value="<?=empty($cw['title'])?'':$cw['title']?>"/>
		<input type="hidden" name="cwid" id="cwid" value="<?=empty($cw['cwid'])?'':$cw['cwid']?>" />
	</div>
  </div>
<?php if($showTeacherSelect == true){?>
<div class="trekt" id="teacherdiv" style="display:none">
	<?php foreach($groupInfo as $key => $onegroup){?>
	
		<div class="titkets">
			<div class="leftkes"><?=$onegroup[0]['groupname']?>：</div>
			<div class="rigleis">
				<ul>
		<?php foreach($onegroup as $group){
		if(!empty($group['face'])){
			$face = getthumb($group['face'],'50_50');
		}else{
			if(!empty($group['sex'])){
				$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
			}else{
				$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
			}
			$face = getthumb($defaulturl,'50_50');
		}
		if(!empty($group['uid'])){
			$tname = empty($group['realname'])?$group['username']:$group['realname'];
		?>
			<li class="etklys">
				<a class="auttdss" tid="<?=$group['uid']?>" tname="<?=$tname?>"><img src="<?=$face?>" style="height:50px;" title="<?=$tname?>"></a><a class="atfwt auttdss" style="padding-top:0px" tid="<?=$group['uid']?>" tname="<?=$tname?>" title="<?=$tname?>"><?=shortstr($tname,6,'')?></a>
			</li>
		<?php }
		}?>
				</ul>
			</div>
		</div>
	<?php }?>
</div>
<?php }?> 
<?php if($iszjdlr) { ?>
	<div class="trekt" id="studentdiv" style="display:none">
		<div class="designatedstudent" style="padding:0 0 15px 15px;">
			<div class="designatedstudent-left">
				<?php if (!empty($classes)) { foreach ($classes as $index => $classitem) { ?>
					<a href="javascript:;" class="class-1<?php if($index == 0) { ?> on<?php } ?>"<?php if(strlen($classitem['classname']) > 14){ ?> title="<?=htmlspecialchars($classitem['classname'], ENT_COMPAT)?>"<?php } ?> cid="<?=$classitem['classid']?>"><?=htmlspecialchars(shortstr($classitem['classname'], 14), ENT_NOQUOTES)?></a>
				<?php }} ?>
			</div>
			<div class="designatedstudent-right">
				<div class="diles-1">
					<input class="newsou-1" placeholder="请输入学生姓名" style="color:#999;" type="text">
					<input class="soulico-1" value="" type="button">
				</div>
				<div class="clear"></div>
				<ul>
					<?php if (!empty($students)){ foreach ($students as $student) {
						$show_name = !empty($student['realname']) ? $student['realname'] : $student['username']; ?>
						<li uid="<?=$student['uid']?>" username="<?=htmlspecialchars($show_name, ENT_COMPAT)?>">
							<div><img class="designatedstudenthead" src="<?=getavater($student,'50_50')?>"></div>
							<p class="designatedstudentname"<?php if(strlen($show_name) > 6) { ?> title="<?=htmlspecialchars(shortstr($show_name, 8), ENT_COMPAT)?>"<?php } ?>><?=shortstr($show_name, 6)?></p>
						</li>
					<?php }} ?>
				</ul>
				<div class="clear"></div>
				<div class="loading-1" style="display:none">
					<div class="loadingson-1">
						<img src="http://static.ebanhui.com/ebh/tpl/2016/images/loading_i.gif">
						<span>正在加载</span>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
<div style="clear:both;"></div>
  <div style="float:left;margin-left:19px;width:70px;_margin-top:20px;margin-top:5px;font-weight:bold;color:#777;">相关图片：</div>
  <div style="width:850px;_margin-top:20px; float:left;">
		<ul class="sckcfm" id="logo-box">
			<?php if($imgsrc){?>
				<li class="fl noimg2" style="position:relative;">
					<!-- <a href="javascript:;" class="glitus" id="Button2" disable></a> -->
					<input name="images[]" type="hidden" value="<?php echo $imgsrc ?>"><input name="imagesname[]" type="hidden" value="<?php echo $imgsrc ?>">
					<img r="0" src="<?php echo $imgsrc ?>" style="cursor:pointer;width:180px;height:110px;" id="uploadimg" >
				</li>
			<?php }?>
			<li class="fl noimg" style="position:relative;">
				<a href="javascript:;" class="glitus" id="Button1"></a>
				<img r="0" src="http://static.ebanhui.com/ebh/tpl/selcur/images/kcfmadd.jpg" style="cursor:pointer;width:180px;height:110px;" id="uploadimg" >
			</li>
		</ul>
  	</div>
	<div id="audio"></div>
	<div style="clear:both;"></div>
	<?php if(!$iszjdlr){?>
	<div style="float:left;margin-left:19px;width:72px;font-weight:bold;color:#777;margin-top:16px">积分悬赏：
	</div>
	<div style="float:left;width:610px;margin-top:14px">
	<select style="font-size:14px" name="reward">
	<?php $askreward = EBH::app()->getConfig()->load('askreward');
		foreach($askreward as $k=>$reward){
			if($user['credit']>=$reward){
	?>
		<option value="<?=$k?>"><?=$reward?>积分</option>
	<?php }}?>
		
	</select>
	</div>
	<?php }?>
	<div style="clear:both;"></div>
	<div class="fontfen" id="doheight">
	<input class="tijibtn" style="margin-left:404px;width:190px;margin-right:20px;float:left;" type="button" value="提交问题" />
	</div>
</div>
</form>
</div>
</div>
<div id="coursedialogdiv" style="display:none">
	<div class="titket" style="width:720px;overflow-x:hidden;background:white;height:250px;overflow-y:auto">
	<div class="leftke" style="width:720px;overflow-x:hidden;">我的课程：</div>
		<div class="riglei" style="width:720px;overflow-x:hidden;">
		<ul>
		<?php if($myfolders){foreach($myfolders as $myfolder){?>
		<li class="etkly" style="white-space:nowrap;"><a class="atfwt auttds" tname="<?= $myfolder['tid_realname']?>" tid="<?=empty($myfolder['tid'])?0:$myfolder['tid']?>" fid=<?=$myfolder['folderid']?>><?=$myfolder['foldername']?></a></li>
		<?php }}?>
		</ul>
		</div>
	</div>
	<?php if($otherfolders){ ?>
	<div class="ewtlt" style="width:720px;overflow-x:hidden;background:white;height:250px;overflow-y:auto;height:480px;">
		<div class="leftke">其他课程：</div>
			<div class="riglei" style="width:720px;overflow-x:hidden;">
			<ul>
				<?php foreach($otherfolders as $key=>$otherfolder){ ?>
						<li class="etkly" style="cursor:pointer;white-space:nowrap;"><a class="atfwt auttds"  tname="<?= $otherfolder['realname']?>" tid="<?=$otherfolder['tid']?>" fid=<?=$key?>><?=$otherfolder['foldername']?></a></li>
				<?php }?>
			</ul>
			</div>
	</div>
	<?php } ?>
</div>
<?php if(!$iszjdlr){?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/recorder.js<?=getv()?>"></script>
<script src="http://static.ebanhui.com/js/soundManager2/js/voicePlayer.js<?=getv()?>"></script>
<?php }?>
<script type="text/javascript">
	
	var timelag;
	$.ajax({
		type: "GET",
		url: '/register/getbindstatus.html',
		dataType: 'json',
		async: false,
		success:function(json){
			timelag = json.data.post_interval;
		},
		error: function(){
			console.log("接口错误！");
		}
	});
	if(timelag == undefined){
		timelag = 0;
	}
	
<?php if(!$iszjdlr){?>
loadaudio('audio');
<?php }?>
var swf = null;
HTools.rFlash({
	id:'Button1',
	uri:'http://static.ebanhui.com/ebh/flash/MultiImageUploadaddqu.swf',
	vars:{'xmlurl':'http://static.ebanhui.com/ebh/flash/xml/webDataStudent.xml'},
	width:178,
	height:108,
});
HTools.rFlash({
	id:'Button2',
	uri:'http://static.ebanhui.com/ebh/flash/MultiImageUploadaddqu.swf',
	vars:{'xmlurl':'http://static.ebanhui.com/ebh/flash/xml/webDataStudent.xml'},
	width:178,
	height:108,
});
//flash调用js提示
function calltips(type){
	var msg = '上传失败';
	switch (type){
	 	case 0 : msg = '文件过大,单张图片不能超过2m';
	 	break;
	 	case 1 : msg = '图片数量不能超过9张';
	 	break;
	 	case 2:msg = '图片上传失败,请刷新后重试';
	 	break;
	}
	//'图片数量不能超过9张'
	top.dialog({
			title: '提示信息',
			content: msg,
			width:370,
			cancel: false,
			okValue: '确定',
			ok: function () {
			}
		}).showModal();
}
//图片上传以后的处理
function callImageUpload(data){	
	if(data.success == true){
		var html = '';
		$(data.data).each(function(){
			//console.log(this.showurl);
			var showurl = this.showurl;
			var thumpc = this.thumpc;
			html += '<li class="fl hasimg"  style="position:relative;"><img r="0" src="'+thumpc+'" style="cursor:pointer;width:180px;height:110px;" ><input name="images[]" type="hidden" value="'+showurl+'"><input name="imagesname[]" type="hidden" value="'+showurl+'"><a onclick="removeimg(this);" href="javascript:void(0);" class="remove-img languan" style="display:block;"></a></li>';
		});
		$('.noimg').before(html);
		<?php if(!isset($imgsrc)){ ?>
			if($(".hasimg").length >= 9){
				$('.noimg').hide();
				$(".hasimg").each(function(k,v){
					if(k >= 9){
						$(this).remove();
					}
				});
			}
		<?php }else{ ?>
			if($(".hasimg").length >= 8){
				$('.noimg').hide();
				$(".hasimg").each(function(k,v){
					if(k >= 8){
						$(this).remove();
					}
				});
			}
		<?php } ?>
	}else{
		top.dialog({
			title: '提示信息',
			content: data.message,
			width:370,
			cancel: false,
			okValue: '确定',
			ok: function () {
			}
		}).showModal();
	}
}
$(function(){
	$("#eeret1").click(function(){
		if(!H.get('artdialogcourse')){
			H.create(new P({
				id : 'artdialogcourse',
				title: '选择课程',
				easy:true,
			    width:720,
			    padding:5,
				content:$('#coursedialogdiv')[0]
			}),'common');
		}
		var folderid = $("input[name=folderid]").val();
		if(folderid){
			$("li.rtytle .atfwt,li.etkly .atfwt").each(function(){
				$(this).css('background','');
				var fid = $(this).attr('fid');
				if(fid==folderid){
					$(this).css('background','#b1d6e9');
				}
			});
		}
		H.get('artdialogcourse').exec('show');

	});
	$("li.rtytle .atfwt,li.etkly .atfwt").click(function(){
		var foldername = $(this).html();
		var folderid = $(this).attr('fid');
		var tid = $(this).attr('tid');
		$(".show_foldername").html(foldername);
		$("input[name=folderid]").attr("value",folderid);
		if(true){
			if(!$(this).attr('tname')){
				var tname = '无';
				var tid = '';
			}else{
				var tname = $(this).attr('tname');
				var tid = $(this).attr('tid');
			}
			<?php if(!$iszjdlr){?>
			$(".show_terchername").html(tname);
			$("input[name=tid]").attr("value",tid);
			<?php }else{?>
			$("input[name=tid]").attr("value",'');
			$(".show_studentname").html('无');
			<?php }?>
			H.get('artdialogcourse').exec('close');
			$('#cwblock').show();
			innerTextConvert($('#show_cwname')[0],'无');
			$('#cwid').val('');
			$('#cwname').val();
			
		}
	});
	<?php if(!empty($folder['folderid'])){?>
	$('#cwblock').show();
	<?php }?>
})

$(function(){
	thtml = $('#teacherdiv')[0];
	$("#eeret2").click(function(){
		if(!H.get('artdialogteacher')){
			H.create(new P({
				id : 'artdialogteacher',
			    title: '指定老师',
			    easy:true,
			    padding:5,
			    content:$('#teacherdiv')[0]
			}),'common');
		}
		var tercherid = $("input[name=tid]").val();
		if(tercherid){
		$("li.etklys .auttdss").each(function(){
			$(this).css('color','#888');
			var tid = $(this).attr('tid');
			if(tid==tercherid){
				$(this).css('color','#18A8FE');
				}
			});
		}
		H.get('artdialogteacher').exec('show');
	});
	$("li.etklys .auttdss").click(function(){
		var terchername = $(this).attr('tname');
		var tid = $(this).attr('tid');
		$(".show_terchername").html(terchername);
		$("input[name=tid]").attr("value",tid);
		H.get('artdialogteacher').exec('close');
	});
})
var titletips = "请在这里输入问题标题";
var flag = true;
$(function(){
	settips("title",titletips);
        $(".tijibtn").click(function(){
            if(checkquestion() && flag) {
            	flag = false;
                addquestion();
            }
        });
});
function settips(id,tips) {
	if($.trim($("#"+id).val()) == "") {
		$("#"+id).val(tips);
		$("#"+id).addClass("titwentigray");
	}
	$("#"+id).click(function(){
		if($.trim($(this).val()) == tips) {
			$(this).val("");
			$(this).removeClass("titwentigray");
		}
	});
	$("#"+id).blur(function(){
		if($.trim($(this).val()) == "") {
			$(this).val(tips);
			$(this).addClass("titwentigray");
		}
	});
}
function checkquestion() {
	if($.trim($("#title").val()) == "" || $.trim($("#title").val()) == titletips) {
		top.dialog({
			title: '提示信息',
			content: '问题的标题不能为空！',
			width:370,
			cancel: false,
			okValue: '确定',
			ok: function () {
			}
		}).showModal();	
		return false;
	}
        var message = UE.getEditor('message').getContent();
        if(message == "") {
		top.dialog({
			title: '提示信息',
			content: '问题内容不能为空！',
			width:370,
			cancel: false,
			okValue: '确定',
			ok: function () {
			}
		}).showModal();	
		return false;
	}
	return true;
}



//设置cookie
function setCookie(name, value, expiredays, path) {  
    var Days = 30;  
    var exp = new Date();  
    exp.setTime(exp.getTime() + expiredays*1000); 
    var path = (path == null) ? ";path=/" : ";path="+path;
    document.cookie = name + "=" + escape(value) + ";expires=" + exp.toGMTString() + path;  
}

function addquestion() {
	$.ajax({
				url:"<?= geturl('college/myask/addquestion') ?>",
				type: "POST",
				data:$("#askform").serialize(),
				dataType:"json",
				success: function(data){
                    if(data != null && data != undefined && data.status == 1) {
                    	
                    		var timestamp = Date.parse(new Date())/1000;
                    		timelag = parseInt(timelag);
                    		var timeend = timestamp + timelag;
                    		setCookie('username',timeend,timelag,"");
                    		
							<?php 
								if(empty($folder['folderid'])){?>
									<?php if(!empty($imgsrc)){ ?>
										window.open("<?= '/myroom.html?url=college/myask/all.html' ?>"); //截图提问的用新窗口展示问题列表
										top.H.get('askQuestionDialog').exec('destroy');
										var flashObj = top.document.getElementById('flvcontrol');
										flashObj._play();
									<?php }else{ ?>
										document.location.href = "<?= geturl('college/myask/all') ?>";
									<?php } ?>
								<?php }else{
									$itemid = $this->input->get('itemid');?>
									<?php if(!empty($imgsrc)){ ?>
										window.open("<?= '/myroom.html?url=college/myask/all.html' ?>"); //截图提问的用新窗口展示问题列表
										parent.H.get('askQuestionDialog').exec('hide');
										var flashObj = parent.parent.document.getElementById('flvcontrol');
										flashObj._play();
									<?php }else{ ?>
										document.location.href = "<?= geturl('college/myask/all').'?folderid='.$folder['folderid'] ?>&itemid=<?=!empty($itemid)?$itemid:''?>";
									<?php } ?>
								// document.location.href = "<?= geturl('college/myask/all').'?folderid='.$folder['folderid'] ?>&itemid=<?=!empty($itemid)?$itemid:''?>";
								<?php }?>
					} else if(data != null && data != undefined && data.status == -1){
						var str = '';
                    	$.each(data.Sensitive,function(name,value){
                    		str+=value+'&nbsp;';
                    	});
                    	var d = dialog({
							title: '提示',
							content: '问题包含敏感词汇'+str+'！请修改后重试...',
							cancel: false,
							okValue: '确定',
							ok: function () {        
							}
						});
						d.showModal();
						flag = true;
						return false;
					}else{
						var message = '提交问题失败，请稍后再试或联系管理员。';
						if(data != undefined && data.message != undefined)
							message = data.message;
						flag = true;
						var d = dialog({
							title: '提交问题',
							content:message,
							cancel: false,
							okValue: '确定',
							ok: function () {        
							}
						}).showModal();
						return false;
					}
				}
			});
}
function showcw(title){
	height = 540;
	width = 650;
	var folderid = $('#folderid').val();
	url = '/college/myask/box_cw/'+folderid+'.html';
	var html = '<iframe scrolling="" marginheight="0" marginwidth="0" frameborder="0" width="'+width+'" height="'+height+'" src="'+url+'"></iframe>';
	H.create(new P({
		id : 'artdialogcw',
		title : title,
		width : width,
		height : height,
		content : html,
		easy:true,
		padding:5
	},{'onclose':function(){H.get('artdialogcw').exec('destroy');}}),'common').exec('show');
}
function selectcw(cwid,title){
	H.get('artdialogcw').exec('close');
	innerTextConvert($('#show_cwname')[0],shortstr(title));
	$('#cwid').val(cwid);
	var foldername = getInnerText($('#show_foldername')[0]);
	var cwname = title;
	$('#cwname').val(cwname);
	<?php if($iszjdlr){?>
		$.ajax({
			url: '/college/myask/getcwStudent.html',
			data: {cwid:cwid},
			dataType: 'json',
			type: 'post',
			cache: false,
			success: function(ret) {
				if(ret.status == 1){
					$('.show_studentname').html(ret.data['realname'].substring(0,8));
					$("input[name=tid]").attr("value",ret.data['uid']);
				}
			}
		});
	<?php }?>
}
function shortstr(str){
	var result = str.substr(0,22);
	if(result.length<str.length)
		result+= '...';
	return result;
}
function innerTextConvert(ele,text){
	if(window.navigator.userAgent.toLowerCase().indexOf("firefox")!=-1)
	{
		ele.textContent=text;
	}
	else
	{
		ele.innerText=text;
	}
}
function getInnerText(ele){
	if(window.navigator.userAgent.toLowerCase().indexOf("firefox")!=-1)
	{
		return ele.textContent;
	}
	else
	{
		return ele.innerText;
	}
}
//删除图片
function removeimg(obj){
	$(obj).parent().remove();
	$('.noimg').show();
}
//向学生提问，选学生
(function($) {
	var page = 1;
	var finished = false;
	var loading = false;
	function ajaxStudents(args, box) {
		if (args.page > 1) {
			loading = true;
		}
		$.ajax({
			url: '/college/myask/ajax_students.html',
			data: args,
			dataType: 'json',
			type: 'get',
			cache: false,
			success: function(ret) {
				var ul = box.find('div.designatedstudent-right ul');
				if (ret) {
					var l = ret.length;
					var html = [];
					for(var i = 0; i < l; i++) {
						html[i] = '<li uid="' + ret[i].uid + '" username="' + ret[i].showname + '">'
							+ '	<div><img class="designatedstudenthead" src="' + ret[i].photo + '"></div>'
							+ '	<p class="designatedstudentname"'+ (ret[i].showname ? ' title="'+ ret[i].showname + '"' : '') + '>' + ret[i].shortname + '</p>'
							+ '</li>';
					}

					if (l < 35) {
						finished = true;
					}
					box.find('div.loading-1').hide();
					if (page == 1) {
						ul.html(html.join(''));
						return;
					}
					if (loading == false) {
						return;
					}
					loading = false;
					ul.append(html.join(''));
					return;
				}
				if (args.page == 1) {
					ul.empty();
				}
				box.find('div.loading-1').hide();
				ul.html('没有该学生！');
				finished = true;
			}
		});
	}
	$("#ask-for-students").bind('click', function() {
		finished = loading = false;
		page = 1;
		var studentDialog = top.dialog({
			id: 'student-dialog',
			title: '指定学生',
			content: $("#studentdiv").html(),
			fixed: true,
			padding: 0,
			onshow: function() {
				//绑定事件
				var that = this;
				var dia = $(this.node);
				finished = dia.find('div.designatedstudent-right ul li').size() < 35;
				dia.find("div.designatedstudent-right").scrollTop(0);
				dia.find("div.designatedstudent-left").scrollTop(0);
				dia.bind('click', function(e) {
					var t = $(e.target);
					//选择班级
					if (t.hasClass('class-1')) {
						dia.find("div.designatedstudent-right").animate({scrollTop:0}, 0);
						page = 1;
						dia.find('.designatedstudent-left a.on').removeClass('on');
						t.addClass('on');
						finished = false;
						loading = false;
						dia.find('div.loading-1').hide();
						ajaxStudents({ 'cid': t.attr('cid'), 'page': page }, dia);
						return true;
					}
					//选择学生
					if (t.hasClass('designatedstudenthead') || t.hasClass('designatedstudentname')) {
						var li = t.parents('li');
						$("#ask-for-students span.show_studentname").html(li.attr('username').substring(0,8));
						$("#ask-for-students input[name='tid']").val(li.attr('uid'));
						that.close().remove();
						return true;
					}
					//点击搜索
					if (t.hasClass('soulico-1')) {
						//搜索学生
						dia.find("div.designatedstudent-right").animate({scrollTop:0}, 0);
						page = 1;
						finished = false;
						loading = false;
						dia.find('div.loading-1').hide();
						dia.find('.designatedstudent-left a.on').removeClass('on');
						ajaxStudents({ 'q': $.trim(dia.find('input.newsou-1').val()), 'page': page }, dia);
						return true;
					}
					return false;
				});
				//回车搜索
				dia.find('input.newsou-1').bind('keypress', function(e) {
					if (e.keyCode == 13) {
						dia.find("div.designatedstudent-right").animate({scrollTop:0}, 0);
						page = 1;
						finished = false;
						loading = false;
						dia.find('div.loading-1').hide();
						dia.find('.designatedstudent-left a.on').removeClass('on');
						ajaxStudents({ 'q': $.trim(dia.find('input.newsou-1').val()), 'page': page }, dia);
					};
				});
				//加载更多
				dia.find("div.designatedstudent-right").scroll(function(){
					if (finished || loading) {
						return;
					}
					dia.find('div.loading-1').show();
					var nScrollHight = $(this)[0].scrollHeight;
					var nScrollTop = $(this)[0].scrollTop;
					if(nScrollTop + $(this).height() >= nScrollHight)   {
						page++;
						var cid = dia.find('.designatedstudent-left a.on').attr('cid');
						ajaxStudents({ 'q': $.trim(dia.find('input.newsou-1').val()), 'cid': cid, 'page': page }, dia);
					}
				});
			}
		});
		studentDialog.showModal();
	});
})(jQuery);
</script>
<?php $this->display('myroom/page_footer'); ?>