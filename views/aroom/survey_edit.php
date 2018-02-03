<?php $this->display('aroom/page_header')?>
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/tzds.css" rel="stylesheet" />

<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/dayi.css" rel="stylesheet" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<style>
.wkemtxt {
	height: 24px;
	line-height: 24px;
	padding-left: 4px;
	margin-bottom: 10px;
	margin-top: 8px;
	width:350px;
}
.opbtn{
	margin-left:10px
}
.itemlabel{
	margin-left:20px;
	line-height:16px;
	font-size:12px;
}
.smbtn {
    background: #18a8f7;
    width: 87px;
    height: 32px;
    display: inline;
    float: left;
    line-height: 32px;
    text-align: center;
    margin-top: 10px;
    color: #fff;
    font-size: 14px;
    text-decoration: none;
    margin-left: 20px;
    cursor: pointer;
    border: none;
}
.relatefs{
	border:1px solid #ccc;
	width:414px;
	margin-left:20px;
	float:left;
	display:block;
	padding:15px;
	margin-bottom:10px;
}

.relatecw{
	display:none;
}
.quesdiv{
	width:756px;
	margin:15px;
	float:left
}
.btndiv{
	float:left;
	margin-left:20px;
	width:750px;
	padding-bottom:20px;
	padding-top:10px;
}
.btndiv a.subbtn{
	background: #18a8f7;
  width: 100px;
  height: 22px;
  display: inline;
  float: left;
  line-height: 22px;
  text-align: center;
  color: #fff;
  text-decoration: none;
  margin-left: 20px;
  cursor: pointer;
  border: none;
}
.relatelgd{
	padding:6px;
}
.qitem{
	width:708px;
	border:none;
}
.qitem:hover{
	border:1px solid #ddd;
}
.noidspan{
	float:left;
	width:23px;
}
.qtitle{
	width:480px;
	float:left
}
.itemsdiv{
	margin-top:10px;
	float:left;
	margin-left:22px;
}
</style>
<div class="ter_tit">
		当前位置 > <a href="<?= geturl('aroom/survey') ?>" >调查问卷</a> > 编辑问卷
		</div>
	<div class="lefrig">
	
	<div style="float:left;margin-top:20px;background:#fff; width:788px;">
	<input type="hidden" id="sid" value="<?=$survey['sid']?>"/>
	<span class="itemlabel">
		标　　　　题：
		</span>
		<input class="uipt wkemtxt" id="title" type="text" onblur="" name="title" value="<?=$survey['title']?>" />
	<form id="mainform" action="/aroom/survey/add.html" method="post">
	<fieldset class="relatefs">
		<legend class="relatelgd">关联信息</legend>
		<div>
			<label style="margin-left:20px;">	
				<input type="radio" class="relateradio" name="relate" onclick="relatedisplay(0)" value="0"checked="checked"/>	不关联	
			</label>
			<label style="margin-left:20px;display:none">	
				<input type="radio" class="relateradio" name="relate" onclick="relatedisplay(1)" value="1"/>关联课程
			</label>
			<label style="margin-left:20px">	
				<input type="radio" class="relateradio" name="relate" onclick="relatedisplay(2)" value="2"/>关联课件
			</label>
		</div>
			<div class="relatecw">
				<div class="eeret" id="eeret1">
					<a class="ekiyt" href="javascript:void(0)">当前选择课程：<span id="show_foldername" class="show_foldername"><?=!empty($relateinfo['foldername'])?shortstr($relateinfo['foldername'],44):'无'?></span></a>
					<input type="hidden" name="folderid" id="folderid"  value="<?=!empty($relateinfo['folderid'])?$relateinfo['folderid']:''?>" />
				</div>
				<div class="eeret" id="eeret3" onclick="showcw('选择课件')">
					<a class="ekiyt"  href="javascript:void(0)">当前选择课件：<span id="show_cwname" class=""><?=!empty($relateinfo['title'])?shortstr($relateinfo['title'],44):'无'?></span></a>
					<input type="hidden" name="cwname" id="cwname" value="<?=!empty($relateinfo['title'])?$relateinfo['title']:''?>"/>
					<input type="hidden" name="cwid" id="cwid" value="<?=!empty($relateinfo['cwid'])?$relateinfo['cwid']:''?>" />
				</div>
			</div>
		</fieldset>
	
	<div id="quescontent">
		<?php 
		foreach($survey['content'] as $k=>$content){
			
			?>
			<div class="quesdiv">
				<span class="noidspan"><label class="noid"><?=($k+1)?>.</label></span>
				<input type="text" name="qtitle[]" class="qtitle uipt" value="<?=$content['title']?>"/>
				<input class="opbtn addbefore previewBtn" type="button" value="在前添加"/>
				<input class="opbtn addafter previewBtn" type="button" value="在后添加"/>
				<input class="opbtn delbtn workBtn" type="button" value="删除"/>
				<div class="itemsdiv" >
					<?php $n=0;foreach($content['item'] as $l=>$item){
						
						if(trim($item,' ') != ''){?>
					<span class="itemindex"><?=chr(65+$n)?></span>.<input type="text" class="qitem uipt" value="<?=$item?>"/>
					<?php 
						$n++;}
					}?>
				</div>
			</div>
		<?php }?>
	</div>
	</form>
	<div class="btndiv">
		<a href="javascript:void(0)" onclick="addques()" class="hongbtn jiabgbtn">添加问题</a>
		<a href="javascript:void(0)" class=" subbtn" onclick="submit('edit')" value="">确认编辑</a>
		<a href="javascript:void(0)" class="subbtn" style="display:none" onclick="submit('add')" value="">发布为新问卷</a>
	</div>
	
	
	</div>
	
</div>

<div id="coursedialogdiv" style="display:none">
	<div class="titket" style="width:550px;background:white;height:250px;overflow-y:auto">
	<div class="leftke" style="width:500px;">课程列表：</div>
		<div class="riglei" style="width:520px;">
		<ul>
		<?php if($courselist){
			foreach($courselist as $course){?>
		<li class="etkly" style="white-space:nowrap;"><a class="atfwt auttds" fid=<?=$course['folderid']?>><?=$course['foldername']?></a></li>
		<?php }
		}?>
		</ul>
		</div>
	</div>
</div>

<script>
var quesdiv = '<div class="quesdiv">';
quesdiv+= '<span class="noidspan"><label class="noid"></label></span>';
quesdiv+= '<input type="text" name="qtitle[]" class="qtitle uipt"/>';
quesdiv+= '<input class="opbtn addbefore previewBtn" type="button" value="在前添加"/>';
quesdiv+= '<input class="opbtn addafter previewBtn" type="button" value="在后添加"/>';
quesdiv+= '<input class="opbtn delbtn workBtn" type="button" value="删除"/>';
quesdiv+= '<div class="itemsdiv">';
quesdiv+= '<span class="itemindex">A</span>.<input type="text" class="qitem uipt"/>';

quesdiv+= '</div>';
quesdiv+= '</div>';

$(function(){
	$('.relateradio')[<?=$survey['type']?>].click();
})

function addques(qid){
	
	$('#quescontent').append(quesdiv);
	validate();
	
	top.resetmain();
}
function validate(){
	$.each($('.quesdiv'),function(k,v){
		$('.quesdiv .noid:eq('+k+')').html(k+1+'.');
		// console.log($('.quesdiv:eq('+k+') .qitem'));
		$.each($('.quesdiv:eq('+k+') .qitem'),function(ik,iv){
			$('.quesdiv:eq('+k+') .qitem:eq('+ik+')').attr('name','qitem'+k+'[]');
		});
	});
}
function submit(submittype){
	var url = '/aroom/survey/'+submittype+'.html';
	var relatetype = $('input[name=relate]:checked').val();
	if(relatetype == 1){
		if(!$('#folderid').val()){
			alert('已勾选关联课程，请选择关联课程');
			return;
		}
	}else if(relatetype == 2){
		if(!$('#cwid').val()){
			alert('已勾选关联课件，请选择关联课件');
			return;
		}
		$.confirm("编辑问卷将会删除学生已答的数据,确定吗?",function(r){
			suretosubmit(relatetype);
		});
	}else{
		suretosubmit(relatetype);
	}
	
	
	
}
function suretosubmit(relatetype){
	var content = getContent();
	
			if(content.length == 0){
				alert('请填写问题.');
				return ;
			}
			$.ajax({
				type:'post',
				url:'/aroom/survey/edit.html',
				data:{'title':$('#title').val(),'content':content,'relatetype':relatetype,'folderid':$('#folderid').val(),'cwid':$('#cwid').val(),'sid':$('#sid').val()},
				success:function(data){
					if(data==1){
						$.showmessage({
							message:'提交成功！',
							timeoutspeed:1000,
							callback:function(){
								location.href='/aroom/survey.html';
							}
						});
					}
					else
						alert(data);
				}
			});
	
}
function getContent(){
	var obj = new Array();
	$.each($('.quesdiv'),function(k,v){
		var q = new Object();
		q.title = $(this).children('.qtitle').val();
		q.item = Array();
		$.each($('.quesdiv:eq('+k+') .qitem'),function(ik,iv){
			q.item.push($(this).val());
		});
		obj.push(q);
	});
	return obj;
}
$('.delbtn').live('click',function(d){
	$(this).parent().remove();
	validate();
	top.resetmain();
});
$('.addbefore').live('click',function(){
	$(this).parent().before(quesdiv);
	validate();
	top.resetmain();
});
$('.addafter').live('click',function(){
	$(this).parent().after(quesdiv);
	validate();
	top.resetmain();
});

$("#eeret1").click(function(){
	html = $('#coursedialogdiv')[0];
	H.create(new P({
		id : 'artdialogcourse',
		title: '选择课程',
		content:html,
		easy:true
	}),'common').exec('show');
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
			$(".show_terchername").html(tname);
			$("input[name=tid]").attr("value",tid);
			H.get('artdialogcourse').exec('close');
			$('#cwblock').show();
			innerTextConvert($('#show_cwname')[0],'无');
			$('#cwid').val('');
			$('#cwname').val();
			
		}
});

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

function showcw(title){
	height = 540;
	width = 650;
	var folderid = $('#folderid').val();
	url = '/aroom/survey/box_cw/'+folderid+'.html';
	var html = '<iframe scrolling="" marginheight="0" marginwidth="0" frameborder="0" width="'+width+'" height="'+height+'" src="'+url+'"></iframe>';
	H.create(new P({
		id : 'artdialogcw',
		title : title,
		width : width,
		height : height,
		content : html,
		easy:true
	},{
		'onclose':function(){
			H.remove('artdialogcw');
		}
	}),'common').exec('show');
}
function selectcw(cwid,title){
	H.get('artdialogcw').exec('close');
	innerTextConvert($('#show_cwname')[0],shortstr(title));
	// $('#show_cwname')[0].innerText = shortstr(title);
	$('#cwid').val(cwid);
	// var cwname = '《'+foldername+'》'+title;
	var cwname = title;
	$('#cwname').val(cwname);
}
function shortstr(str){
	var result = str.substr(0,22);
	if(result.length<str.length)
		result+= '...';
	return result;
}
function relatedisplay(type){
	if(type==0){
		$('.relatecw').hide();
	}else if(type==1){
		$('.relatecw').show();
		$('#eeret3').hide();
	}else{
		$('.relatecw').show();
		$('#eeret3').show();
	}
	
}
$('.qitem').live('keydown',function(e){
	if(e.keyCode==13){
		var index = parseInt($(this).attr('index'));
		if($(this).parent().children('.itemindex').length<26){
			$(this).after('<span class="itemindex"></span>.<input type="text" class="qitem uipt" index="'+(index+1)+'"/>');
			$(this).next().next().focus();
			top.resetmain();
			inquesvalidate($(this).parent());
		}
	}
});
function inquesvalidate(ques){
	$.each(ques.children('.itemindex'),function(k,v){
		$(this).html(String.fromCharCode(65+k));
	});
}
</script>
<?php $this->display('aroom/page_footer')?>
