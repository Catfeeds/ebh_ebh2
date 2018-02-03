<?php 

$this->display('aroomv2/page_header'); ?>
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<style>
.lefrig {
	font-family:微软雅黑;
	font-family:Microsoft YaHei;
	min-height:600px;
	padding-bottom:40px;
}
.scbtn{
	height:29px;
	line-height:25px;
	background:#6489ac;
	color:#fff;
	border:1px solid #6489ac;
	width:92px;
	letter-spacing: 3px;
	margin:7px 10px 10px 10px;
	cursor:pointer;
	float:right;
}
.binput{
	border:1px solid #cdcdcd;
	width:608px;
	height:25%;
	padding:5px;
	margin-top:10px;
}
.sjitds a.fewytg{ display:block; width:85px;}
.crupBtn{background:#6489ac;}
.crupBtn:hover{background:#7398bb;}
.kstgds.qqkf{
	letter-spacing:5px;
}
.kstgd1s{
	font-size:14px;
	color:#555;
    font-weight: bold   ;
	float:none;
	padding-left:15px;
}
.jwefir1s{
	width:150px;
	float:left;
}
.jwefir2s{
	width:95px;
}
.binput{
	width:590px;
}
.binput1s{
	width:284px;
	color:#999;
	font-size:12px;
}
.setup{
	padding:0;
	height:auto;
}
.binput2s{
    width:284px;
    color:#000;
    font-size:12px;
}
.pingzhu{
	font-size:12px;
	color:#999;
	font-family:微软雅黑;
	padding-left: 72px;
    padding-top: 10px;
	float:left;
	display:inline;
}
.pingzhu a{
	color:#3c79e3;
	font-size:12px;
	text-decoration: underline;
	padding:0 1px;
}
.zjkf{
	background:url("http://static.ebanhui.com/ebh/tpl/aroomv2/images/tjkfico.png") no-repeat left center;
    color: #3c79e3;
    display: inline;
    float: right;
    font-family: 微软雅黑;
    font-size: 14px;
    height: 25px;
    line-height: 25px;
    padding-left: 18px;
    width: 88px;
	margin-top:3px;
	cursor:pointer;
}
#content\:basicinfo{
    display: inherit;
}
<?php 
if(empty($myroom['cface']))
	$cface = 'http://static.ebanhui.com/ebh/tpl/default/images/face/4.jpg';
else
	$cface = $myroom['cface'];
	$curdomain = $this->uri->uri_domain();
?>
<?php 
if ($this->uri->curdomain != $myroom['domain'].'ebh.net') {
	$isfulldomain = 1;
	?>
.ui-close {
    position: relative;
    _position: absolute;
    float: right;
    top: 408px;
    z-index: 1000;
    right: 31px;
    _height: 26px;
    padding: 0 4px;
    font-size: 21px;
    font-weight: bold;
    line-height: 1;
    color: #000;
    text-shadow: 0 1px 0 #FFF;
    opacity: .0;
    filter: alpha(opacity=00);
    cursor: pointer;
    background: transparent;
    _background: #FFF;
    border: 0;
    -webkit-appearance: none;
}
.setup .mylabel a.labeldel img{
	background: url(http://static.ebanhui.com/ebh/tpl/aroomv2/images/close.png) no-repeat;
	margin:10px 0 4px 6px;
}
<?php }?>
</style>

<div class="ter_tit"> 当前位置 > 网校概况 </div>
<!--改版start-->
<div class="lefrig leftou">
	<div class="schoolname-1">
		<?php $domain = 'http://'.$curdomain.'.'.$this->uri->curdomain;?>
		<?=$myroom['crname']?>
		<?php if(!empty($myroom['fulldomain'])){?>
			<a href="http://<?=$myroom['fulldomain']?>" target="_blank">&nbsp;<?=$myroom['fulldomain']?></a>
		<?php }else{?>
			<a href="<?=$domain?>" target="_blank">&nbsp;<?=$domain?></a>
		<?php }?>
	</div>
	<div class="kstiylist-1">
    	<ul>
        	<li>
            	<div class="studentotal"><?= $myroom['stunum'] ?><span class="studentotalspan">名</span></div>
                <div class="studentotalspan"><?=$curdomain == 'bndx' ? '学员' : '学生'?></div>
            </li>
            <li>
            	<div class="studentotal"><?= $myroom['teanum'] ?><span class="studentotalspan">位</span></div>
                <div class="studentotalspan"><?=$curdomain == 'bndx' ? '教员' : '老师'?></div>
            </li>
            <li>
            	<div class="studentotal"><?= $classesnum?><span class="studentotalspan">个</span></div>
                <div class="studentotalspan"><?=$curdomain == 'bndx' ? '班次' : '班级'?></div>
            </li>
            <li>
            	<div class="studentotal"><?= $foldernum?><span class="studentotalspan">门</span></div>
                <div class="studentotalspan">课程</div>
            </li>
            <li>
            	<div class="studentotal"><?= $myroom['coursenum']?><span class="studentotalspan">份</span></div>
                <div class="studentotalspan">课件</div>
            </li>
            <li>
            	<div class="studentotal"><?= $myroom['examcount']?><span class="studentotalspan">份</span></div>
                <div class="studentotalspan">作业</div>
            </li>
            <li>
            	<div class="studentotal"><?= $myroom['asknum']?><span class="studentotalspan">条</span></div>
                <div class="studentotalspan"><?=$curdomain == 'bndx' ? '互动' : '答疑'?></div>
            </li>
            <li>
            	<div class="studentotal"><?= $reviewnum?><span class="studentotalspan">条</span></div>
                <div class="studentotalspan">评论</div>
            </li>
        </ul>
    </div>
	<div class="clear"></div>
	<!--网校简介-->
	<div class="schoolprofile">
    	<h2 class="prtitles">网校简介</h2>
		<a href="javascript:void(0)" class="editdetail" onclick="showdetail()">详情编辑</a>
        <a href="javascript:void(0)" onclick="editsummary()" class="edit-1">编辑</a>
        <div class="clear"></div>
		<!-- 中共巴南网校过滤 -->
		<?php if($curdomain != 'bndx'){ ?>		
        <a href="<?= geturl('aroomv2/setting/avatarold') ?>" class="modifybadge-1">修改校徽</a>
        <img class="badge-1" src="<?=$cface?>" />
		<?php } ?>
        <div class="schoolprofileson" id="summary"><?= $myroom['summary'] ?></div>
    </div>
    <div class="clear"></div>
	<!--基本信息-->
	<div class="basicinformation">
    	<h2 class="prtitles">基本信息</h2>
        <a href="javascript:void(0)" onclick="editbasic()" class="edit-1">编辑</a>
        <div class="clear"></div>
        <p class="servicetel"><span class="servicecall">服务电话</span><span class="telephone-1" id="crphone"><?= shortstr($myroom['crphone'],50) ?></span></p>
        <p class="servicetel servicetel-1"><span class="servicecall">QQ客服 </span></p>
		<p class="servicetel servicetel-1">
			<?php if(!empty($kefu['kefu'])){
				foreach($kefu['kefu'] as $k=>$v){?>
				<span class="telephone-1"><?php echo !empty($v)?$v:'--'?> <?php if(!empty($kefu['kefuqq'][$k])) echo $kefu['kefuqq'][$k]?></span><br>
			<?php } }?>
		</p>
		<div class="clear"></div>
		<p class="servicetel">
			<span class="servicecall">联系地址</span>
			<span class="telephone-1" id="craddress" title="<?=$myroom['craddress']?>"><?= shortstr($myroom['craddress'],50) ?></span>
			<input type="hidden" value="<?=$myroom['crphone']?>" id="fullphone"/>
			<input type="hidden" value="<?=$myroom['craddress']?>" id="fulladdress"/>
			<input type="hidden" id="lng" value="<?= $myroom['lng'] ?>" />
			<input type="hidden" id="lat" value="<?= $myroom['lat'] ?>" />
			<?php if(!empty($myroom['lng']) && !empty($myroom['lat'])) { ?>
				<a class="located" id="maptip" href="javascript:void(0)" onclick="setmap()">已定位</a>
			<?php }else{?>
				<a class="located" id="maptip" href="javascript:void(0)" onclick="setmap()">未定位</a>
			<?php }?>
		</p>
    </div>	
	<!-- 中共巴南网校过滤 -->
	<?php if($curdomain != 'bndx'){ ?>
	
	<div class="netlabel">
		<h2 class="prtitles">网校标签</h2>
		<a href="javascript:void(0)" onclick="showaddlabel()" class="edit-1">编辑</a>
		<div class="setup">
			<?php if(!empty($myroom['crlabel'])) { 
				$labelarr = explode(',',$myroom['crlabel']);
			?>
			<ul class="labelul">
			<?php foreach($labelarr as $label) { ?>
				<li class="mylabel" onmouseout="this.className='mylabel'" onmouseover="this.className='mylabel mylabelhover onhover'">
					<span class="labeleft"></span>
					<div class="bqnr-1">
						<a class="labelnode" href="javascript:void(0)" title="<?= $label ?>" ><?= $label ?></a>
						<a class="labeldel" title="删除标签" onclick="removelabel(this)" href="javascript:void(0)">
						<img src="http://static.ebanhui.com/ebh/tpl/default/images/transparent.gif">
						</a>
					</div>
					<span class="labelright"></span>
				</li>
			<?php } ?>
			<?php } else { ?>
			您还没有添加任何标签！
			<?php } ?>
			</ul>
		</div>
	</div>
	<?php } ?>
	<!--改版end-->	
</div>
<div class="ptbiaoq" id="addlabeldiv" style="display:none">
	<input id="crlabel" style="float:left; width:94%;margin:15px" class="txtlan" type="text" value="多个标签词之间请用空格分开" />
</div>
<div id="basicinfodiv" style="display:none;padding:10px;">
	<span>服务电话：</span><input value="请输入服务电话,多个电话用英文逗号隔开" id="crphoneinput" class="binput" style='color: #999;font-size: 12px;' maxlength="50" onblur="showpa(this,1)"/><br/>
	<!--增加客服系统sta-->
	<span style="float:left;letter-spacing:1px;line-height:47px; padding-left:13px;">QQ客服：</span>
	<div style="float:left;" id = 'addkfcontent'>
		<?php if(!empty($kefu['kefu'])){foreach($kefu['kefu'] as $key=>$value){?>
			<p>
				<input autocomplete="off" value="<?php echo !empty($value)?$value:'请输入客服名称，如：徐老师'?>" onblur="showkefu(this)" class="binput <?php echo empty($value)?'binput1s':'binput2s'?>" style="margin-right:7px;" maxlength="20" />
				<input autocomplete="off" value="<?php echo !empty($kefu['kefuqq'][$key])?$kefu['kefuqq'][$key]:'请输入QQ号码'?>" onkeyup='this.value=this.value.replace(/\D/gi,"")' onblur="showqq(this)" class="binput <?php echo empty($kefu['kefuqq'][$key])?'binput1s':'binput2s'?>" maxlength="15"/>
				<a href="javascript:;" onclick="delkf(this)"><img src="http://static.ebanhui.com/ebh/tpl/aroomv2/images/sckfico.png" style="margin-left: 5px;margin-top: 15px;position: absolute;" /></a><br/>
			</p>
		<?php }}else{?>
		<p>
			<input value="请输入客服名称，如：徐老师" onblur="showkefu(this)" class="binput binput1s" style="margin-right:7px;" maxlength="20" />
			<input value="请输入QQ号码" onkeyup='this.value=this.value.replace(/\D/gi,"")' onblur="showqq(this)" class="binput binput1s" style='' maxlength="15"/>
			<a href="javascript:;" onclick="delkf(this)"><img src="http://static.ebanhui.com/ebh/tpl/aroomv2/images/sckfico.png" style="margin-left: 5px;margin-top: 15px;position: absolute;" /></a><br/>
		</p>
		<?php }?>
	</div>
	<div style="clear:both;"></div>
	<div>
		<div class="pingzhu">注：请<a href="/aroomv2/asetting/qqsetting.html" target="_blank">设置</a>QQ号为允许接受临时会话</div>
		<div class="zjkf" onclick="addkf()">新增客服</div>
	</div>
	<div style="clear:both;"></div>
	<!--增加客服系统end-->

	<span>联系地址：</span><input value="请输入联系地址" id="craddressinput" class="binput" style='color: #999;font-size: 12px;' onblur="showpa(this,2)"/><br/><br/>
	<input class="scbtn" style="" type="button" value="取消" onclick="closedialog('basicinfo')"/>
	<input class="scbtn" style="" type="button" value="确定" onclick="savebasic('basicinfo')"/>
</div>

<div id="crsummarydiv" style="display:none">
	<textarea id="summaryta" style="padding:5px;width:98%;height:350px; border:1px solid #cdcdcd; line-height:23px; letter-spacing: 2px;">
	</textarea>
	<input class="scbtn" style="" type="button" onclick="closedialog('summary')" value="取消" />
	<input class="scbtn" style="" type="button" onclick="upsummary('summary')" value="确定" />
</div>


<?php if (!empty($isfulldomain)) {?>
<div id="divMapLayer" style="width:500px;height:350px;display:none;">
	<iframe id="map" scrolling="no" frameborder=0 style="width:500px;height:410px;"></iframe>
	<div>
		<div class="main_bot"></div>
	</div>
</div>
<?php } else {?>
<div id="divMapLayer" style="width:500px;height:350px;display:none;">
	<div style="margin-bottom:5px;">
		地址：<input type="text" value="" id="txtMapSearchKey" name="txtMapSearchKey" class="binput" style="width:360px;height:12px;margin-top:0px;font-size:12px" />&nbsp;&nbsp;<input type="button" value="" style="cursor:pointer;background:url(http://static.ebanhui.com/ebh/tpl/2012/images/dingwei1206.png) no-repeat;width:68px;height:22px;border:none;margin-top:5px;" onclick="search()" />
		
	</div>
	<div id="map" style="width:500px;height:325px"></div>
	<div>
		 <div class="main_bot"></div>
	</div>
	<input class="scbtn" style="" type="button" onclick="closedialog('divMapLayer')" value="取消" />
	<input class="scbtn" style="" type="button" onclick="savemap('divMapLayer')" value="确定" />
</div>
<?php }?>
<script>
color();
$(function(){
	$("#crlabel").focus(function(){
		if($.trim($("#crlabel").val()) == "多个标签词之间请用空格分开") {
			$("#crlabel").css("color","#000");
			$("#crlabel").val("");
		}
	});
	$("#crlabel").blur(function(){
		if( $.trim($("#crlabel").val()) == "") {
				$("#crlabel").css("color","#CCC");
				$("#crlabel").val("多个标签词之间请用空格分开");
			}
	});
});

function removelabel(labelobj) {
	if (labelobj != undefined && $(labelobj).parent() != "")
	{
		$(labelobj).parent().parent().remove();
		savelabels();
	}
}
function addlabel(id) {
	var maxwords = 50;	//标签最大字数
	var labels = $.trim($("#crlabel").val());
	if (labels != "" && labels != "多个标签词之间请用空格分开")
	{
		var haschange = 0;
		if ($.trim($(".setup").text()) == "您还没有添加任何标签！")
		{
			$(".setup").html("");
			$(".setup").append("<ul class='labelul'></ul>");
		}
		var labelarr = labels.split(" ");
		for(var i = 0; i < labelarr.length; i ++) {
			var labelvalue = $.trim(labelarr[i]);
			if (labelvalue == "")
			{
				continue;
			}
			if(isexists(labelvalue))
				continue;
			var tmplabels = getlabels();
			if ((tmplabels + "," + labelvalue).length > maxwords)
			{
				alert("对不起，所有标签的字数之和不能超过50个字，超出部分标签将无法保存到系统！");
				$("#crlabel").val("");
				return false;
			}
			var listr = '<li class="mylabel" onmouseover="this.className=\'mylabel onhover mylabelhover\'" onmouseout="this.className=\'mylabel\'">';
			listr += '<span class="labeleft"></span><div class="bqnr-1"><a href="javascript:void(0)" title="' + labelvalue + '" class="labelnode">' + labelvalue + '</a>';
			listr += '<a href="javascript:void(0)" onclick="removelabel(this)" title="删除标签" class="labeldel"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/transparent.gif" /></a><span class="labelright"></span><div>';
			listr += '</li>';

			$(".labelul").append(listr);
			haschange = 1;
		}
		if(haschange) {
			savelabels();
			$("#crlabel").css("color","#CCC");
			$("#crlabel").val("多个标签词之间请用空格分开");
		}
	}else{
		alert("你还没有输入任何标签");
		return false;
	}

	dialog.get(id).close();
}
function isexists(labelvalue) {
	var elabels = $(".labelnode");
	for(var i = 0; i < elabels.length; i ++) {
		if($(elabels[i]).html() == labelvalue)
			return 1;
	}
	return 0;
}
function getlabels() {
	var mylabels = "";
	var elabels = $(".labelnode");
	for(var i = 0; i < elabels.length; i ++) {
		if (i == 0)
			mylabels = $(elabels[i]).text();
		else
			mylabels = mylabels + "," + $(elabels[i]).text();
	}
	return mylabels;
}
//基本信息编辑文章颜色
function color(){
}
//删除客服框
function delkf(that){
    if(!confirm('是否删除该客服')){
        return false;
    }
    $(that).parent('p').remove();
    var input = $('#addkfcontent p').find('input');
    if(input.length==0){
        addkf();
    }

}
//添加客服框
function addkf(){
    var content = '<p><input value="请输入客服名称，如：徐老师" onblur="showkefu(this)" class="binput binput1s kefu" style="margin-right:11px;" maxlength="20" />'
                    +'<input value="请输入QQ号码" onblur="showqq(this)" class="binput binput1s qq" style="" maxlength="15"'
                    +" onkeyup='this.value=this.value.replace(/\\D/gi,\"\")'/>"
                    +'<a href="javascript:;" onclick="delkf(this)"><img src="http://static.ebanhui.com/ebh/tpl/aroomv2/images/sckfico.png" style="margin-left: 5px;margin-top: 15px;position: absolute;" /></a><br/></p>'
    $('#addkfcontent').append(content);
}


//客服文字提示
$('.binput1s,.binput2s').live('click',function(){
    var data = $(this).val();
    if(data=="请输入客服名称，如：徐老师"||data=="请输入QQ号码"){
        $(this).val('');
    }
    $(this).css('color','#000');
})
$('#crphoneinput').live('click',function(){
    var data = $(this).val();
    if(data=='请输入服务电话,多个电话用英文逗号隔开'){
        $(this).val('');
    }
    $(this).css('color','#000');
})
$('#craddressinput').live('click',function(){
    var data = $(this).val();
    if(data=='请输入联系地址'){
        $(this).val('');
    }
    $(this).css('color','#000');
})
function showpa(that,i){
    var data = $(that).attr('value')
    if(data==''){
        if(i==1){
            $(that).val('请输入服务电话,多个电话用英文逗号隔开');
            $(that).css('color','#999');
        }else if(i==2){
            $(that).val('请输入联系地址');
            $(that).css('color','#999');
        }
    }
}
function showkefu(that){
    var data = $(that).attr('value')
    if(data==''){
        $(that).val('请输入客服名称，如：徐老师');
        $(that).css('color','#999');
    }
}
function showqq(that){
    var data = $(that).val();
    if(data==''){
        $(that).val('请输入QQ号码')
        $(that).css('color','#999');
    }
}


function savelabels() {
	var mylabels = getlabels();
	$.ajax({
		url:"<?= geturl('aroomv2/asetting/upinfo') ?>",
		type:'post',
		data:{'crlabel':mylabels},
		dataType:'text',
		success:function(data){
			if(data!='success'){
				alert("对不起，标签保存失败，请联系e板会客服！");
			}
		}
	});
}
// function 
function showaddlabel(){
	if(!H.get('addlabel')){
		/*H.create(new P({
			id : 'addlabel',
			title: '添加标签',
			easy:true,
			width:720,
			padding:5,
			content:$('#addlabeldiv')[0]
		}),'common').exec('show');*/
		dialog({
			id : 'addlabel',
			title: '添加标签',
			easy:true,
			width:720,
			padding:5,
			content:$('#addlabeldiv')[0],
			okValue:"确定",
			ok:function(){
				addlabel('addlabel');
				return false;
			},
			cancelValue:"取消",
			cancel:function(){
				this.close();
				return false;
			}
		}).showModal();
	}else{
		H.get('addlabel').exec('show');
	}
}

function editbasic(){
    if($('#fullphone').val()!=''){
        $('#crphoneinput').val($('#fullphone').val());
        $('#crphoneinput').css('color','#000');
    }
	if($('#fulladdress').val()!=''){
        $('#craddressinput').val($('#fulladdress').val());
        $('#craddressinput').css('color','#000');
    }
	if(!H.get('basicinfo')){
		H.create(new P({
			id : 'basicinfo',
			title: '基本信息',
			easy:true,
			width:720,
			padding:5,
			content:$('#basicinfodiv')[0]
		}),'common').exec('show');
	}else{
		H.get('basicinfo').exec('show');
	}
//    $('.ui-dialog-content').css('display','inherit')
}
function editsummary(){
	$('#summaryta').html($('#summary').html());
	if(!H.get('summary')){
		H.create(new P({
			id : 'summary',
			title: '网校简介',
			easy:true,
			width:720,
			padding:5,
			content:$('#crsummarydiv')[0]
		}),'common').exec('show');
		
	}else{
		H.get('summary').exec('show');
	}
}
function showdetail(){
	if (window.parent.showdetail != undefined)
	{
		window.parent.showdetail();
	}
}

function upsummary(id){
	var summary=$("#summaryta").val();
	$.ajax({
		url:"<?= geturl('aroomv2/asetting/upinfo') ?>",
		type:'post',
		data:{'summary':summary},
		dataType:'text',
		success:function(data){
			if(data=='success'){
				$.showmessage({
					img		 : 'success',
					message  :  '平台介绍修改成功',
					title    :      '平台介绍修改',
					callback :    function(){
						closedialog(id);
                        $("#summary").html("<p>" +summary+ "</>");
						top.resetmain();
					}
				});
				
			}else{
				$.showmessage({
					img		 : 'error',
					message  :  '平台介绍修改失败',
					title    :      '平台介绍修改',
					callback :    function(){
						
					}
				});
			}
		}
	});
}
function savebasic(id){
    if($('#crphoneinput').val()=='请输入服务电话,多个电话用英文逗号隔开'){
        var crphone = '';
    }else{
        var crphone = $('#crphoneinput').val();
    }
    if($('#craddressinput').val()=='请输入联系地址'){
        var craddress = '';
    }else{
        var craddress = $('#craddressinput').val();
    }
    var input = $('#addkfcontent p').find('input');
    var kfcontent = [];
    for(var i=0;i<input.length;i++){
        kfcontent.push(input.eq(i).val());
    }
//    var crkefu = $('#addkfcontent p input').eq(1).val();
	if(oldaddress != craddress)
		addresschanged = true;
	oldaddress = craddress;
	$.ajax({
		url:"<?= geturl('aroomv2/asetting/upinfo') ?>",
		type:'post',
		data:{'crphone':crphone,'craddress':craddress,'kfcontent':kfcontent},
		dataType:'text',
		success:function(data){
			if(data=='success'){
//				$('#fullphone').val(crphone);
//				$('#crphone').html(shortstr(crphone));
//				$('#fulladdress').val(craddress);
//				$('#craddress').html(shortstr(craddress));
                location.reload();
			}else{
			}
		}
	});
	closedialog(id);
}
function closedialog(id){
	H.get(id).exec('close');
}

/*****************百度地图2.0 eker**********************************/
var ismapinit = 0;	//是否已加载地图
var defaultZoom = 16;	//默认缩放比例
var mp;	//地图变量
var marker;
var oldaddress = '<?=$myroom['craddress']?>';
var addresschanged = false;

//异步加载 百度地图js
<?php if (!empty($isfulldomain)) {?>
function loadBdMap(){
  $('#map').attr('src','http://<?=$myroom['domain']?>.ebh.net/map/setmap.html');
}
<?php } else {?>
function loadBdMap(){
  var script = document.createElement("script");
  script.src = "http://api.map.baidu.com/api?v=2.0&ak=H8Y9OO2Gt8C584uRpzC4LED4&callback=initialize";
  document.body.appendChild(script);
}
<?php }?>	
function setmap(){
	var address = $('#craddress').text();
	if(address==''){
		dialog({
			skin:"ui-dialog2-tip",
			content:"<div class='PPic'></div><p>请先编辑联系地址</p>",
			width:350,
			onshow:function () {
				var that=this;
				setTimeout(function() {
					that.close().remove();
				}, 1000);
			}
		}).show();
		return false;
	}
	if(!H.get('divMapLayer')){
		H.create(new P({
			id : 'divMapLayer',
			title: '标注地图',
			easy:true,
			height:400,
			width:505,
			padding:15,
			content:$('#divMapLayer')[0]
		}),'common').exec('show');
		<?php if (!empty($isfulldomain)) {?>
		var b = '<button class="ui-close" onclick="closedialog(\'divMapLayer\')">232342</button>';
		$(".ui-dialog-header").append(b);
		<?php }?>	
	}else{
		H.get('divMapLayer').exec('show');
	}
	
	if (ismapinit == 0){		
		loadBdMap();
	}
	if(addresschanged){
		$("#txtMapSearchKey").val($("#fulladdress").val());
		addresschanged = false;
	}
	
}

//异步加载 初始化回调
function initialize() {
	mp = new BMap.Map('map');
	if ($("#lat").val() == "" || $("#lng").val() == "")
	{
		if ($("#fulladdress").val() != "")
		{
			$("#txtMapSearchKey").val($("#fulladdress").val());
			mp.centerAndZoom("杭州市",defaultZoom);
			//search();
		}
	} else {
		mp.centerAndZoom(new BMap.Point($("#lng").val(), $("#lat").val()),defaultZoom);
		marker = new BMap.Marker(new BMap.Point($("#lng").val(), $("#lat").val()),{enableDragging:true});
		mp.addOverlay(marker);
		$("#txtMapSearchKey").val($("#fulladdress").val());
	}


	//添加带有定位的导航控件
	// 添加定位控件
	var geolocationControl = new BMap.GeolocationControl();
	geolocationControl.addEventListener("locationSuccess", function(e){
	  // 定位成功事件
	  var address = '';
	  address += e.addressComponent.province;
	  address += e.addressComponent.city;
	  address += e.addressComponent.district;
	  address += e.addressComponent.street;
	  address += e.addressComponent.streetNumber;
	  console.log("当前定位地址为：" + address);
	});
	geolocationControl.addEventListener("locationError",function(e){
	  // 定位失败事件
	  alert(e.message);
	});
	mp.addControl(geolocationControl);
	
	mp.enableScrollWheelZoom();
	mp.setDefaultCursor("pointer");
	mp.addEventListener("click", setmarker);
	ismapinit = 1;
}
//点击事件
function setmarker(e) {
	$("hdnSetLng").val(e.point.lng);
	$("hdnSetLat").val(e.point.lat);
	if (marker != null)
	{
		mp.removeOverlay(marker);
	}
	marker = new BMap.Marker(new BMap.Point(e.point.lng, e.point.lat),{enableDragging:true});
	mp.addOverlay(marker);
}

function savemap(id){
	if (marker != null)
	{
		var curpoint = marker.getPosition();
		var lng = curpoint.lng;
		var lat = curpoint.lat;
		$("#lng").val(curpoint.lng);
		$("#lat").val(curpoint.lat);
		
		$.ajax({
			url:"<?= geturl('aroomv2/asetting/upinfo') ?>",
			type:'post',
			data:{'lng':lng,'lat':lat},
			dataType:'text',
			success:function(data){
				if(data=='success'){
					$("#maptip").html("已标注");
					closedialog(id);
				}else{
				}
			}
		});
	}else{
		$.showmessage({
			img		 : 'error',
			message  :  '请先点击快速定位',
			title    :  '提示消息',
			callback :   function(){
				
			}
		});
	}
}
//搜索定位
function search() {
	var searchTxt = $("#txtMapSearchKey").val();
	if ( searchTxt== ""){
		alert("请输入要搜索的地址！");
		$("#txtMapSearchKey").focus();
	} else {
		// 创建地址解析器实例
    	var myGeo = new BMap.Geocoder();
    	// 将地址解析结果显示在地图上，并调整地图视野
    	myGeo.getPoint(searchTxt, function (point) {
    		if (point) {
    			mp.centerAndZoom(point, defaultZoom);
    			mp.removeOverlay(marker);
				marker = new BMap.Marker(new BMap.Point(point.lng, point.lat),{enableDragging:true});
				mp.addOverlay(marker);
    		}else{
    			alert("搜索不到结果");
    			}
    		}, "全国");
	}
}
function shortstr(str){
	var result = str.substr(0,25);
	if(result.length<str.length)
		result+= '...';
	return result;
}
</script>
<?php $this->display('aroomv2/page_footer');?>
