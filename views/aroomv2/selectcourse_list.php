<?php
 $this->display('aroomv2/page_header');
 $room = Ebh::app()->room->getcurroom();
?>

<style>
.terlie li {
    background: none repeat scroll 0 0 #FFFFFF;
    border: 1px solid #B2D9F0;
    display: block;
    float: left;
    font-size: 14px;
    height: 20px;
    line-height: 20px;
    margin-bottom: 7px;
    margin-right: 5px;
    padding-top: 3px;
    width: auto;
}
.terlie li a.labelnode {
    color: #0078B6;
    display: inline;
    float: left;
    height: 18px;
    line-height: 18px;
    padding: 0 7px;
    text-decoration: none;
    vertical-align: 4px;
}

.terlie li a.labeldel {
    float: left;
}
.terlie .mylabel a.labeldel img {
    background: url("http://static.ebanhui.com/ebh/tpl/2012/images/closebg_01.png") no-repeat scroll 0 0 transparent;
    display: inline-block;
    height: 12px;
    margin: 3px 4px 2px 0;
    width: 12px;
}
.terlie .mylabelhover a.labeldel img {
    background: url("http://static.ebanhui.com/ebh/tpl/2012/images/closebg_02.png") no-repeat scroll 0 0 transparent;
    display: inline-block;
    height: 12px;
    margin: 3px 4px 2px 0;
    width: 12px;
}

.terwai {
    background-color: #FFF;
    border: 1px solid #DEDEDE;
    float: right;
    font-size: 14px;
    margin-right: 0px;
    margin-top: 10px;
    min-height: 153px;
    padding: 0 10px 10px;
    width: 590px;
}
.terwai .ternei {
    background: url("http://static.ebanhui.com/ebh/tpl/default/images/aroom/xiangtop0222.jpg") no-repeat scroll center top transparent;
    margin-top: -9px;
    min-height: 13px;
    width: 590px;
	position:static;
}
.terlie {
    border-bottom: 1px dashed #CDCDCD;
    float: left;
    margin-bottom: 15px;
    padding-bottom: 15px;
    padding-top: 10px;
    width: 590px;
}
.xianquan {
    float: left;
    width: 590px;
    max-height:290px;
    _height:290px;
    overflow-y:auto;
}


.xianquan li {
    float: left;
    height: 30px;
    line-height: 30px;
    width: 188px;
	overflow: hidden;
}
/*设置章节*/
#categoryBody {
    background: none repeat scroll 0 0 #FFFFFF;
    color: #444444;
    margin: 0;
    padding: 11px 17px 0;
    width: 460px;
}
#categoryHead {
    background: none repeat scroll 0 0 #FFFFFF;
    margin: 5px auto;
    padding: 5px 0 0;
}
.categoryName {
	border: 1px solid #C2C3BD;
	font-size: 12px;
	margin-right: 7px;
	width: 155px;
	height:21px;
	line-height:21px;
	padding-left:4px;
}
.CJsub cite {
	background-image:url(http://static.ebanhui.com/ebh/tpl/default/images/sn_btnb.gif);
	color: #333399;
	background-repeat: no-repeat;
	font-size: 12px !important;
	height: 23px;
	line-height: 23px;
	min-width: 48px;
	overflow-x: visible;
	text-align: center;
	white-space: nowrap;
	width: 71px;
	display: block;
	cursor:pointer;
	text-decoration: none;
	font-style: normal;
    font-weight: normal;
}
.CJsub:hover{
	text-decoration:none;
}
#errTips {
    color: #CC0000;
    font-weight: bold;
    margin-bottom: 10px;
    padding-left: 6px;
}
#categoryList {
    margin: 10px 0 0;
}
#categoryList li {
    background:url(http://static.ebanhui.com/ebh/tpl/default/images/layertype_2.gif) repeat-x scroll left top transparent;
    clear: both;
    display: block;
    float: left;
    font-family: simsun;
    height: 30px;
    line-height: 30px;
    overflow: hidden;
    width: 100%;
}
#categoryList li.cline {
    background:url(http://static.ebanhui.com/ebh/tpl/default/images/layertype_1.gif) repeat-x scroll left top transparent;
	    clear: both;
    display: block;
    float: left;
    font-family: simsun;
    height: 30px;
    line-height: 30px;
    overflow: hidden;
    width: 100%;
}
#categoryList li span.htit {
    background:url(http://static.ebanhui.com/ebh/tpl/default/images/layertype_3.gif) no-repeat scroll 11px 13px transparent;
    height: 28px;
    overflow: hidden;
    padding-left: 20px;
    width: 270px;
}
#categoryList li span {
    float: left;
}
#categoryList li span.control {
    float: right;
}
#categoryList li span.control .manage {
    float: left;
    width: 170px;
}
.control .manage .CP_a_fuc {
	color: #333399;
	text-decoration: none;
}

a.CP_a_fuc cite {
	cursor: pointer !important;
	font-family: Verdana;
	text-decoration:none;
	color: #333399;
	font-style: normal;
    font-weight: normal;
}
a.CP_a_fuc:hover cite {
	text-decoration:underline;
	color:#FF0000;
}
#categoryBody #categoryList .clearfix .control .manage .CP_a_fuc:hover {
	color: #FF0000;
	text-decoration: none;
}
.CP_w a:link, .CP_w a:visited {
    color: #2E3092;
}
#categoryBottom {
	height: 60px;
	padding-top: 20px;
	text-align: center;
	background-image: url(http://static.ebanhui.com/ebh/tpl/default/images/layertype_2.gif);
	background-repeat: repeat-x;
}
.bcun {
	background: url(http://static.ebanhui.com/ebh/tpl/default/images/sn_btnb.gif) no-repeat;
	height: 23px;
	width: 71px;
	color: #333399;
	border:none;
	cursor:pointer;
}
#categoryBody #categoryList .clearfix .vbuo input {
	margin-top: 4px;
}

</style>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<script src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<div >
    <div class="ter_tit">
        当前位置 > <a href="<?=geturl('aroomv2/more')?>">更多应用</a> > 选课管理
    </div>
    <div class="kechengguanli">


<div class="teacherstatistics_top">
    	<div class="kechengguanli_top">
        	<ul class="fl ">
            	<li class="fl "><a href="<?=geturl('aroomv2/selectcourse/add')?>" class="cjmt13">开设选课课程</a></li>
            	<li class="fl ml20"><a href="javascript:;" id="setRegTime" class="cjmt13">设置报名时间</a></li>
            	<li class="fl ml20"><a href="javascript:;" id="resetReg" class="cjmt13">重置报名</a></li>
            </ul>
        </div>

        <div class="diles diles-1 fr">
            <input type="text" value="<?=empty($q)?'请输入课程名称':$q?>" id="searchkey" class="newsous" name="title" style="color:#999; background:#fff;" onfocus="if($(this).val()=='请输入课程名称')$(this).val('');$(this).css('color','#333')" onblur="if($.trim($(this).val())==''){$(this).val('请输入课程名称');$(this).css('color','#999')}">
            <input type="button" value="" onclick="_search()" class="soulico" id="searchbutton">
        </div>
        <div class=" clear"></div>
        <div class="kechengguanli_bottom">
        	<table cellpadding="0" cellspacing="0" class="tables">
            	<tr class="first">
				<?php if ($room['template'] == 'plate') { ?>
					<td width="410">课程</td>
                    <td width="61">计划数</td>
                    <td width="61">报名数</td>
                    <td width="81">历年报名数</td>
                    <td width="116">操作</td>
				<?php } else { ?>
                	<td width="354">课程</td>
                    <td width="81">计划数</td>
                    <td width="81">报名数</td>
                    <td width="97">历年报名数</td>
                    <td width="116">操作</td>
				<?php } ?>
                </tr>
			<?php if (!empty($courselist)) {
				$gradearr = array(1=>'一年级',2=>'二年级',3=>'三年级',4=>'四年级',5=>'五年级',6=>'六年级');
				foreach($courselist as $course){
				?>
                <tr>
                	<td class="subject">
                    	<div class="fl">
						<?php if ($room['template'] == 'plate') {
                            $img = show_plate_course_cover($course['img']); ?>
							<img style="width:147px;height:86px; padding-right:5px;" src="<?=empty($img)?'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_147_86.jpg':show_thumb($img, '147_86')?>" />
						<?php } else { ?>
							<img style="width:63px;height:86px; padding-right:5px;" src="<?=empty($course['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$course['img']?>" />
						<?php } ?>
						</div>
						<p class="fl titlecourse titlecourse-1"><?=$course['foldername']?><?php if($course['isforbidden']==1) echo '<span style="color:red;">（禁止报名）</span>';?></p>
						<p class="datadd-1 fl">
							<span class="address-2"><?=shortstr($course['location'],28)?></span><br/>
							<span class="datapeople-2"><?=$course['speaker']?></span>
							<span class="nianji-2"><?php if (empty($course['allowgrade'])) { echo '不限制';} else {
								$gradestr = trim($course['allowgrade'], ',');
								$grades = explode(',', $gradestr);
								foreach ($grades as $key => $value) {
									$grades[$key] = array_key_exists($value, $gradearr) ? $gradearr[$value] : '';
								}
								echo shortstr(implode('、', $grades), 14); } ?>
							</span>
						</p>
                    </td>
                    <td><?=$course['admitnum']?></td>
                    <td><?=$course['regnum']?></td>
                    <td><a href="<?=geturl('aroomv2/selectcourse/student/'.$course['folderid']).'?rurl='.$this->uri->path?>" title="查看历年报名学生"><?=$course['totalnum']?></a></td>
                    <td style="position: relative;">
						<div class="managementfa">
							<div href="javascript:void(0)" class="management-1">管理
								<img src="http://static.ebanhui.com/ebh/tpl/2016/images/jt-1.png" width="11" height="5" />
								<div class="moreoperate-1" style="display: none; right:27px;">																	
									<a href="<?=geturl('aroomv2/selectcourse/edit/'.$course['folderid'])?>" class="moreoperatea">编辑</a>
									<a href="javascript:delcourse(<?=$course['folderid']?>,<?=$course['coursewarenum']?>);" class="moreoperatea">删除</a>
									<a href="<?=geturl('aroomv2/selectcourse/student/'.$course['folderid']).'?isnew=1&rurl='.$this->uri->path?>" class="moreoperatea">查看报名学生</a>
								</div>
							</div>							
							<div class="move-1" style="display:none;">							
								<a class="imges moveup" href="javascript:void(0)" title="上移" onclick="movefolder(<?=$course['folderid']?>,1)"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/cwarr_up.png" /></a>
								<a class="imgas movedown" href="javascript:void(0)" title="下移" onclick="movefolder(<?=$course['folderid']?>,0)"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/cwarr_down.png" /></a>
							</div>
						</div>
                    </td>
                </tr>
            	<?php
            	}
            } else { ?>
				<tr>
			 		<td colspan="5" align="center" style="border-top:none;">暂无课程</td>
			 	</tr>
			<?php } ?>
            </table>
        </div>
    </div>
	
	<?=$pagestr?>
    
</div>

<!--删除课程-->
<div id="dialogdel" style="display:none;height:100px;">
	<div style="height:70px;" class="deletecourse">
		<div class="tishi mt40"><p style="padding-left: 90px; font-size: 16px; line-height: 35px;">确定要删除该课程吗?</p></div>
	</div>
</div>
<!--设置选课时间-->
<div id="dialogregtime" style="display:none;height:120px;margin: 0 auto;text-align: center;">
	<div class="mt30">
		<span>开始时间：</span>
		<input id="begintime" class="text" type="text" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="" />
		<p id="begintime_msg" style="margin-left:129px;height:20px;text-align:left;"></p>
	</div>
	<div class="mt5">
		<span>结束时间：</span>
		<input id="endtime" class="text" type="text" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="" />
		<p id="endtime_msg" style="margin-left:129px;height:20px;text-align:left;"></p>
	</div>
</div>
<!--重置-->
<div id="dialogreset" style="display:none;height:120px;">
	<div style="height:70px;" class="deletecourse">
		<div class="tishi mt40" style="width:auto;"><p style="padding-left: 90px; font-size: 16px; line-height: 35px;">重置报名会清除报名时间和报名记录，确定要重置报名吗?</p></div>
	</div>
</div>
<script>
/*展开操作选项*/
$(function () {
	$(".management-1").mouseenter(function(){
		$(this).find(".moreoperate-1").css("display","block");
	});
	$(".management-1").mouseleave(function(){
		$(this).find(".moreoperate-1").css("display","none");
	});
});
$(function () {
	$(".tables tr").mouseenter(function(){
		$(this).find(".move-1").css("display","block");
	});
	$(".tables tr").mouseleave(function(){
		$(this).find(".move-1").css("display","none");
	});
});

function delcourse(courseid,coursewarenum) {
	if(coursewarenum>0){
		alert('该课程下还有课件，如要删除，请先删除课件!');
		return ;
	}
	var button = new xButton();
	button.add({
		value:"确定",
		callback:function(){
			savedel(courseid);
			return false;
		},
		autofocus:true
	});

	button.add({
		value:"取消",
		callback:function(){
			H.get('dialogdel').exec('close');
			return false;
		}
	});
	if(!H.get('dialogdel')){
		H.create(new P({
			id : 'dialogdel',
			title: '删除课程',
			easy:true,
			width:400,
			padding:5,
			content:$('#dialogdel')[0],
			button:button
		}),'common');
	}
		
	H.get('dialogdel').exec('show');
}

function movefolder(folderid,flag){
	if(!H.get('xtips')){
		H.create(new P({
			id:'xtips',
			easy:true,
			padding:10
		}),'common');
	}
	$.ajax({
		url:"/aroomv2/selectcourse/move.html",
		type:'post',
		data:{'folderid':folderid,'flag':flag},
		dataType:'json',
		success:function(data){
			if(data==1){
				H.get('xtips').exec('setContent','移动成功').exec('show');
				setTimeout(function(){
					window.location.reload();
				},500);
			}else{
				if(flag == 1)
					alert('已在顶部');
				else
					alert('已在底部');
			}
		}
	});

}
function savedel(courseid){
	$.ajax({
		type:'post',
		url:'<?=geturl('aroomv2/selectcourse/del')?>',
		dataType:'json',
		data:{'folderid':courseid},
		success:function(_json){
			if(_json.code == 1){
				alert(_json.message);
				window.location.reload();
			}else{
				alert(_json.message);
			}
		},
		error:function(){
			alert("服务器连接错误，请重试");
		}
	});
}

function _search(){
	var searchkey = $('#searchkey').val();
	if(searchkey == '请输入课程名称')
		searchkey = '';
	location.href = '<?=geturl('aroomv2/selectcourse/courselist')?>?q='+searchkey;
}

function setregtime(){
	var begintime = $("#begintime").val();
	var endtime = $("#endtime").val();
	var flag = true;
	if (begintime == '') {
		flag = false;
		$("#begintime_msg").html('<font color="red">请填写开始时间</font>');
	} else {
		$("#begintime_msg").html('');
	}
	if (endtime == '') {
		flag = false;
		$("#endtime_msg").html('<font color="red">请填写结束时间</font>');
	} else {
		$("#endtime_msg").html('');
	}

	if (flag) {
		$.ajax({
			type: "POST",
			url: "<?=geturl('aroomv2/selectcourse/setregtime')?>",
			dateType: "json",
			data: {begintime:begintime, endtime:endtime},
			success: function(data){
				if(data != undefined && data != null){
					if (data == 1){
						$.showmessage({
							img : 'success',
							message:'设置成功',
							title:'设置报名时间',
							callback :function(){
								H.get('dialogregtime').exec('close');
							}
						});
					} else if (data == -1) {
						$.showmessage({
							img : 'error',
							message:'开始时间和结束时间不能为空',
							title:'设置报名时间'
						});
					} else {
						$.showmessage({
							img : 'error',
							message:'设置失败',
							title:'设置报名时间'
						});
					}
				}
			},
			error: function(){
				alert("服务器连接错误，请重试");
			}
		});
	}

}

function savereset(){
	$.ajax({
		type:'post',
		url:'<?=geturl('aroomv2/selectcourse/reset')?>',
		dataType:'json',
		success:function(_json){
			if(_json.code == 1){
				$.showmessage({
					img : 'success',
					message:_json.message,
					title:'重置报名',
					callback :function(){
						window.location.reload();
					}
				});
			}else{
				$.showmessage({
					img : 'error',
					message:_json.message,
					title:'重置报名'
				});
			}
		},
		error:function(){
			alert("服务器连接错误，请重试");
		}
	});
}

$(function(){
	$("#setRegTime").click(function(){
		$("#begintime").val('');
		$("#endtime").val('');
		$.ajax({
			type: "POST",
			url: "<?=geturl('aroomv2/selectcourse/getregtime')?>",
			dataType: "json",
			success: function(data){
				if(data != undefined && data != null) {
					$("#begintime").val(data.begintime);
					$("#endtime").val(data.endtime);
				}
			},
			error: function(){
				alert("服务器连接错误，请重试");
			}
		});

		var button = new xButton();
		button.add({
			value:"确定",
			callback:function(){
				setregtime();
				return false;
			},
			autofocus:true
		});
		button.add({
			value:"取消",
			callback:function(){
				H.get('dialogregtime').exec('close');
				return false;
			}
		});
		if (!H.get('dialogregtime')){
			H.create(new P({
				id : 'dialogregtime',
				title: '设置报名时间',
				easy:true,
				width:400,
				padding:5,
				content:$('#dialogregtime')[0],
				button:button
			}),'common');
		}
		H.get('dialogregtime').exec('show');
	});

	$("#resetReg").click(function(){
		var button = new xButton();
		button.add({
			value:"确定",
			callback:function(){
				savereset();
				return false;
			},
			autofocus:true
		});
		button.add({
			value:"取消",
			callback:function(){
				H.get('dialogreset').exec('close');
				return false;
			}
		});
		if(!H.get('dialogreset')){
			H.create(new P({
				id : 'dialogreset',
				title: '重置报名',
				easy:true,
				width:400,
				padding:5,
				content:$('#dialogreset')[0],
				button:button
			}),'common');
		}
		H.get('dialogreset').exec('show');
	});

});
</script>
</body>
</html>
