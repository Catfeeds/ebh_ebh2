<?php $this->display('aroomv2/page_header')?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xform.js?v=1"></script>
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
    padding-left: 6px;
    width: auto;
}
.terlie li a.labelnode {
    color: #0078B6;
    display: inline;
    float: left;
    height: 18px;
    line-height: 18px;
    padding: 0 7px 0 1px;
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
.terlie .labelstar{
	display: block;
	float: left;
	margin-top: 2px;
	width: 14px;
	height: 12px;
	background: url(http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif) no-repeat scroll 0 0 transparent;
}
.terlie .star_on{
	background: url(http://static.ebanhui.com/ebh/tpl/default/images/icon_star_2.gif) no-repeat scroll 0 0 transparent;
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
    max-height:300px;
    _height:300px;
    overflow-y:auto;
}


.xianquan li {
    float: left;
    height: 30px;
    line-height: 30px;
    width: 188px;
	overflow: hidden;
	text-align:left;
}
.xznj .pads{ margin-left:45px; padding-left:48px;}
#dialogadd .addclass{
 font-size:14px;
}
</style>

<body>

<div>
	<div class="ter_tit">
        当前位置 > <a href="<?=geturl('aroomv2/classes/student')?>">班级学生</a> >
        班级管理
    </div>
    <div class="banjiguanli banjiguanli1s">
    	<div class="banjiguanli_top fr">
    		<?php $domain = $this->uri->uri_domain();?>
        	<ul>
                <li class="fl ml20"><a href="javascript:addclass()">添加班级</a></li>
                <?php if($domain == 'lcyhg'){ ?>
                <li class="fl ml20"><a href="/aroomv2/classes/input.html">导入班级教师</a></li>
                <li class="fl ml20"><a href="/aroomv2/lcyhstu/input.html">导入学生</a></li>
                <?php }else{ ?>
                <li class="fl ml20"><a href="/aroomv2/classes/input.html">导入班级</a></li>
                <?php } ?>
            </ul>
        </div>
        <div class=" clear"></div>
        <div class="banjiguanli_bottom">
        	<table cellpadding="0" cellspacing="0" class="tables">
            	<tr  class="first">
                	<td width="115">班级名称</td>
                    <td width="380">任课教师</td>
                    <td width="73">学生人数</td>
                    <td width="172">操作</td>
                </tr>
				<?php
				$domain = $this->uri->uri_domain();
				$rurl = $this->uri->path;
				foreach($classlist as $class){?>
                <tr>
                	<?php if($domain == 'lcyhg'){ ?>
                	<td width="115"><?=$class['classname']?></td>
                    <td width="380"><p class="renjiaols" title=""><?=!empty($class['teachers'])?$class['teachers']:''?></p></td>
                    <?php }else{ ?>
                    <td width="115"><?=$class['classname']?></td>
                    <td width="380"><p class="renjiaols"><?=!empty($class['teachers'])?$class['teachers']:''?></p></td>
                    <?php } ?>
                    <td width="73"><?=$class['stunum']?></td>
                    <!--<td width="80"><a href="<?=geturl('aroomv2/student/list_view').'?classid='.$class['classid'].'&rurl='.$rurl?>">学生管理</a></td>-->
                    <td width="172" style="">
						<div style="position:relative; vertical-align:middle;">
							<a href="javascript:chooseteacher(<?=$class['classid']?>)">选择教师</a>
							<input type="hidden" id="teacherids_<?=$class['classid']?>" value="<?=!empty($class['teachers'])?$class['teacherids']:''?>" />
							<input type="hidden" id="headteacherid_<?=$class['classid']?>" value="<?=!empty($class['headteacherid'])?$class['headteacherid']:0?>" />
							<a href="<?=geturl('aroomv2/student/list_view').'?classid='.$class['classid'].'&rurl='.$rurl?>" class="ml10">学生管理</a>
							<a href="javascript:;" class="zhankai sMemu"><img src="http://static.ebanhui.com/ebh/tpl/aroomv2/images/zhankai.png" />
								<div class="moreoperate" style="display:none;">
									<span  class="aedit moreoperatea">编辑</span>
									<span  class="<?=empty($class['stunum'])?'adel':'adelunable'?> moreoperatea">删除</span>
									<span  class="ainit moreoperatea">初始化</span>
									<input type="hidden" class="classinfo" classid="<?=$class['classid']?>" classname="<?=$class['classname']?>" grade="<?=$class['grade']?>"/>
									<span  class="moreoperatea changeclass" data-id="<?=$class['classid']?>">升班级</span>
								</div>
							</a>
						</div>
                    </td>
                </tr>
				<?php }?>
         </table>
         <?=$pagestr?>
        </div>
    </div>

</div>
</body>

<!--选择教师-->
<div class="chooseteacher" style="display:none">
	<div class="terwai">
	<input type="hidden" id="current_classid" value="0" />
	<div class="ternei">
	</div>
	<span id="choosettitle" style="color:#0068b7;"></span>
	<div id="" class="terlie">
			<div id="noteacher">还未设置任何任课教师</div>
			<ul id="choosetsimp" style="display:none">
			</ul>
		</div>
		<div style="" class="xiansuoyout">
		<span style="float:left;margin-right:60px;line-height:22px;display: inherit;height:22px;"> 教师列表</span>
		<div style="height:26px;float:left;">
		<input type="text" onclick="this.value=''" id="teachername" class="soutxt" value="请输入老师姓名或账号" name="search" style="width:180px;">
		<input type="button" onclick="allteacher($('#teachername').val())" class="souhuang" value="搜 索" name="searchbutton" >
		</div>
		</div>
		<div class="xianquan">
		<ul style="" id="choosetall">
		<?php foreach($roomteacherlist as $teacher){?>
		<li id="all<?=$teacher['uid']?>"><input type="checkbox" id="allteacheri<?=$teacher['uid']?>" onclick="choose('<?=$teacher['uid']?>','<?=$teacher['realname']?>(<?=$teacher['username']?>)',this)" value="<?=$teacher['uid']?>" style="top:2px;" <?= $teacher['folderid'] == 0 ?'checked="checked"':''?> ><label title="<?=$teacher['realname']?>(<?=$teacher['username']?>)" id="teachername_<?=$teacher['uid']?>" for="allteacheri<?=$teacher['uid']?>" style="margin-left:4px;_margin-left:2px;"><?=$teacher['realname']?>(<?=$teacher['username']?>)</label></li>
		<?php }?>
		</ul>
		</div>
	</div>
</div>

<!--编辑班级-->
<div id="dialogedit" style="display:none;height:90px">
<div class="editclass">
<!--
	<div class="title2"><p>编辑班级</p></div>
	-->
    <div class="mingcheng mt30" style="text-align:left">
		<span style="margin-left:15px;">班级名称：</span>
		<input id="class_edit_classname" class="text input" type="text" value=""/>
		<input id="class_edit_classid" type="hidden" value=""/>
		<p class="p3" id="editclassmsg" style="margin-left:45px; padding-left:45px !important;">请输入班级名称</p>
    </div>
	<?php if(!in_array($roominfo['isschool'],array(1,2)) && !empty($roominfo['grade'])){?>
	<div class="xznj mt20" id="class_edit_grade">
		<span style="display: inline;vertical-align: middle;float: left;padding-left: 16px;">年　　级：</span>
		<div style="width:70px; float:left;"><label style=" "><input style="width:26px;" type="radio" value="0" name="grade_edit" checked=""/>不选</label></div>
		<?php if($roominfo['grade']==1){
				$gradearr = array('一年级','二年级','三年级','四年级','五年级','六年级');
				for($i=1;$i<7;$i++){
					if($i!=4)
						echo '<div style="width:70px; float:left;"><label style=" "><input style="width:26px;" type="radio" value="'.$i.'" name="grade_edit" />'.$gradearr[$i-1].'</label></div>';
					else
						echo '<div style="width:70px; float:left;" class="pads"><label style=" "><input style="width:26px;" type="radio" value="'.$i.'" name="grade_edit" />'.$gradearr[$i-1].'</label></div>';
				}
			}elseif($roominfo['grade']==7){
				$gradearr = array('初一','初二','初三');
				for($i=7;$i<10;$i++){
					echo '<div style="width:70px; float:left;"><label style=" "><input style="width:26px;" type="radio" value="'.$i.'" name="grade_edit" />'.$gradearr[$i-7].'</label></div>';
				}
			}elseif($roominfo['grade']==10){
				$gradearr = array('高一','高二','高三');
				for($i=10;$i<13;$i++){
					echo '<div style="width:70px; float:left;"><label style=" "><input style="width:26px;" type="radio" value="'.$i.'" name="grade_edit" />'.$gradearr[$i-10].'</label></div>';
				}
			}
		?>

	</div>
	<?php }?>
</div>
</div>

<!--添加班级-->
<div id="dialogadd" style="display:none;height:90px">
<div class="addclass">
<!--
	<div class="title2"><p>添加班级</p></div>
	-->
    <div class="mingcheng mt15" style="text-align:left;">
    	<span style="margin-left:15px;">班级名称：</span>
        <input id="class_add_classname" class="text input mt20" style="margin-top:0;" type="text" value="" x_hit="请输入班级名称"/>
        <p class="p3" id="addclassmsg" style="margin-left:45px; padding-left:45px !important;"></p>
    </div>
	<?php if(!in_array($roominfo['isschool'],array(1,2)) && !empty($roominfo['grade'])){?>
	<div class="xznj mt15" id="class_add_grade">
		<span style="display: inline;vertical-align: middle;float: left;padding-left: 16px;">年　　级：</span>
		<div style="width:70px; float:left;"><label style=" "><input style="width:26px;" type="radio" value="0" name="grade_add" checked=""/>不选</label></div>
		<?php if($roominfo['grade']==1){
				$gradearr = array('一年级','二年级','三年级','四年级','五年级','六年级');
				for($i=1;$i<7;$i++){
					if($i!=4)
						echo '<div style="width:70px; float:left;"><label style=" "><input style="width:26px;" type="radio" value="'.$i.'" name="grade_add" />'.$gradearr[$i-1].'</label></div>';
					else
						echo '<div style="width:70px; float:left;" class="pads"><label style=" "><input style="width:26px;" type="radio" value="'.$i.'" name="grade_add" />'.$gradearr[$i-1].'</label></div>';
				}
			}elseif($roominfo['grade']==7){
				$gradearr = array('初一','初二','初三');
				for($i=7;$i<10;$i++){
					echo '<div style="width:70px; float:left;"><label style=""><input style="width:26px;" type="radio" value="'.$i.'" name="grade_add" />'.$gradearr[$i-7].'</label></div>';
				}
			}elseif($roominfo['grade']==10){
				$gradearr = array('高一','高二','高三');
				for($i=10;$i<13;$i++){
					echo '<div style="width:70px; float:left;"><label style=" "><input style="width:26px;" type="radio" value="'.$i.'" name="grade_add" />'.$gradearr[$i-10].'</label></div>';
				}
			}
		?>

	</div>
	<?php }?>
</div>
</div>


<!--删除班级-->
<div id="dialogdel" style="display:none">
<div class="deleteclass">
<!--
	<div class="title2"><p>删除班级</p></div>
	-->
    <div class="tishi">
		<input id="class_del_classid" type="hidden"/>
		<p style="padding-left:55px; font-size:14px; line-height:36px;">您确定要删除此班级吗？</p>
    </div>
    <div class="clear"></div>
</div>
</div>

<!--删除班级有学生-->
<div id="dialogdelunable" style="display:none">
<div class="deleteclass">
<!--
	<div class="title2"><p>删除班级</p></div>
	-->
    <div class="tishi">
		<input id="class_del_classid" type="hidden"/>
		<p style="padding-left:55px; font-size:14px; line-height:18px;">该班级下还有学生，不能删除此班级！</p>
    </div>
    <div class="clear"></div>
</div>
</div>


<!--班级初始化-->
<div id="dialoginit" style="display:none">
<div class="classinitialization">
<!--
	<div class="title2"><p>班级初始化</p></div>
	-->
    <div class="tishi">
		<input id="class_init_classid" type="hidden"/>
        <p style="padding-left:55px; font-size:14px; text-align:left;">该操作会清除该班级所有学生，并将其移出网校！是否继续初始化？</p>
    </div>
    <div class="clear"></div>
</div>
</div>
<script type="text/javascript">
$(function () {
	$(".sMemu").on({
		mouseenter:function () {
			$(this).find(".moreoperate").css("display","block");
		},
		mouseleave:function () {
			$(this).find(".moreoperate").css("display","none");
		}
	});
	$(".changeclass").bind('click', function() {
		document.location.href='/aroomv2/changeclass.html?classid='+$(this).data('id');
	})
});
function closedialog(id){
	H.get('dialog'+id).exec('close');
}

	var showteachertoolbar = function(classid){
		$('#teachertoolbar'+classid).show();
		$('#class'+classid+' .showtip').attr('src','http://static.ebanhui.com/ebh/tpl/default/images/aroom/db_arrow_up.gif');
		$('#class'+classid+' .showtiplink').attr('href','javascript:hideteachertoolbar('+classid+')');
		top.resetmain();
	}
	var hideteachertoolbar = function(classid){
		$('#teachertoolbar'+classid).hide();
		$('#class'+classid+' .showtip').attr('src','http://static.ebanhui.com/ebh/tpl/default/images/aroom/db_arrow_down.gif');
		$('#class'+classid+' .showtiplink').attr('href','javascript:showteachertoolbar('+classid+')');
		top.resetmain();
	}
	function showstudent(url) {
		if(window.parent != undefined && typeof(window.parent.refresh) == "function") {
			window.parent.refresh("student");
			document.location.href = url;
		}
	}


	function chooseteacher(courseid) {
	$("#current_classid").val(courseid);
	var teacherdis = $("#teacherids_"+courseid).val();
	var headteacherid = $("#headteacherid_"+courseid).val();
	$("#choosetsimp").empty();
	if(teacherdis == "") {
		$("#noteacher").html("还未设置任何任课教师");
	}
	$("#choosetall li input").removeAttr("checked");

	var button = new xButton();
	button.add({
		value:"确定",
		callback:function(){
			saveteacher();
			return false;
		},
		autofocus:true
	});

	button.add({
		value:"取消",
		callback:function(){
			H.get('chooseteacher').exec('close');
			return false;
		}
	});
	if(teacherdis != "") {
		teacherids = teacherdis + ',';
		for(var j = 0; j < allteachers.length; j ++) {
			var t = allteachers[j];
			if(teacherdis.indexOf(t.uid) != -1) {
				$("#noteacher").css("display","none");
				$("#choosetsimp").css("display","block");
				var teachername = t.realname+"("+t.username+")";
				var listr = '<li  id="simp'+t.uid+'" onmouseout="this.className=\'mylabel\'" onmouseover="this.className=\'mylabel mylabelhover\'" class="mylabel" >';
				if (t.uid == headteacherid)
					listr += '<a class="labelstar star_on" title="取消班主任" href="javascript:;"></a>';
				else
					listr += '<a class="labelstar" title="设为班主任" href="javascript:;"></a>';
				listr += '<a class="labelnode" title="'+teachername+'" href="#">'+teachername+'</a>';
				listr += '<a class="labeldel" title="删除标签" onclick="removelabel(\''+t.uid+'\')" href="javascript:void(0)">';
				listr += '<img src="http://static.ebanhui.com/ebh/tpl/2012/images/transparent.gif">';
				listr += '</a>';
				listr += '<input type="hidden" value="'+t.uid+'" name="simteacher[]" />';
				listr += '</li>';
				$("#choosetsimp").append(listr);


			}
		}
		$("#choosetall li input").each(function(){
			if(teacherids.indexOf($(this).val()+",") != -1) {
				var tid = $(this).val();

				$("#allteacheri"+tid).prop("checked","checked");
			}

		});
	}
	H.create(new P({
		id:'chooseteacher',
		content:$('.chooseteacher')[0],
		title:'选择任课老师（选中星号为班主任）',
		easy:true,
		button:button
	},{
		'onshow':function(){
			$(this).focus();
			return false;
		}
	}),'common').exec('show');
}

var allteacher = function(uname){
		var uid = $('.dilan :checked').val();
		if(uname == "请输入老师姓名或账号")
			uname = "";

		$.ajax({
		   type: "GET",
		   url:"<?=geturl('aroomv2/classes/getroomteachers')?>",
		   data:{'q':uname},
		   dataType:'json',
		   success: function(json){
			   $('.terwai').show();
			   $('#choosetall').empty();
			   $(json).each(function(index,item){
				   var tid = item['uid'];
				   var uname = item['realname'] == ""?item['username']:(item['realname']+"("+item['username']+")");
				   var checkstatus = '';
					if($("#simp"+tid).length > 0)
						checkstatus = 'checked="checked"';
				   var itemstr = '<li ><input type="checkbox" style="top:2px;" value="'
				   +item['teacherid']+'" ' + checkstatus + ' onclick="choose(\''+item['teacherid']+'\',\''+uname+'\',this)" id="allteacheri'
				   +item['teacherid']+'" '+checkstatus
					   +'/><label style="margin-left:4px;_margin-left:2px;" id="teachername_"'+item['teacherid']+' for="allteacheri'+item['teacherid']
					   +'" title="'+item['realname']+'('+item['username']+')">'+item['realname']
					   +'('+item['username']+')</li>';

					$('#choosetall').append(itemstr);

			   });
		   }
		});
	}
	function mysubstr(inputString,len){
		var tmpstring = inputString.replace(/\*/g,'_').replace(/[\u0391-\uFFE5]/g,'**');
		if(tmpstring.length<=len){
			return inputString;
		}
		tmpstring = tmpstring.substr(0,len);
		chcount = Math.ceil((tmpstring.length-tmpstring.replace(/\*/g,'').length)/2);

		return inputString.substr(0,len-chcount);
	}
	var choose = function(teacherid,teachername,dom){
		if($(dom).prop("checked")){
			$("#noteacher").css("display","none");
			$("#choosetsimp").css("display","block");
			var listr = '<li  id="simp'+teacherid+'" onmouseout="this.className=\'mylabel\'" onmouseover="this.className=\'mylabel mylabelhover\'" class="mylabel">';
			listr += '<a class="labelstar" title="设为班主任" href="javascript:;"></a>';
			listr += '<a class="labelnode" title="'+teachername+'" href="#">'+teachername+'</a>';
			listr += '<a class="labeldel" title="删除标签" onclick="removelabel(\''+teacherid+'\')" href="javascript:void(0)">';
			listr += '<img src="http://static.ebanhui.com/ebh/tpl/2012/images/transparent.gif">';
			listr += '</a>';
			listr += '<input type="hidden" value="'+teacherid+'" name="simteacher[]" />';
			listr += '</li>';
			$("#choosetsimp").append(listr);
		}else{
			$("#simp"+teacherid).remove();
			if($("#choosetsimp li").length == 0) {
				$("#choosetsimp").css("display","none");
				$("#noteacher").css("display","block");
			}
		}
	}
	function removelabel(tid){
		$("#simp"+tid).remove();
		$("#allteacheri"+tid).removeAttr("checked");
		if($("#choosetsimp li").length == 0) {
			$("#choosetsimp").css("display","none");
			$("#noteacher").css("display","block");
		}
	}
	function saveteacher() {
		var classid = $("#current_classid").val();
		var teacherids = "";
		var headteacherid = 0;
		var simp = $("#choosetsimp").children();
		for(var i = 0; i <simp.length; i++) {
			var teacherid = $(simp[i]).attr("id");
			teacherid = teacherid.substring("simp".length);
			if(i == 0)
				teacherids = teacherid;
			else
				teacherids += ","+teacherid;
			if ($(simp[i]).children(".star_on").length > 0){
				headteacherid = teacherid;
			}
		}
		$.ajax({
			type: "POST",
			url: "<?=geturl('aroomv2/classes/chooseteacher')?>",
			data:{'classid':classid,'teacherids':teacherids,'headteacherid':headteacherid},
			dataType:'json',
			async:false,
			success: function(json){
				dialogtip();
				H.get('xtips').exec('setContent','修改成功').exec('show').exec('close',500);
		   }
		});
	}
	var allteachers = <?=json_encode($roomteacherlist)?>;

function initclass(classname,classid){
	$.confirm('初始化班级','此操作会<font color="red">清空</font>该班级的学生,并将班级下的学生移出学校',function(){
		$.confirm('初始化班级','如果要初始化班级,请输入 <font color="red">'+classname+'</font> 进行确认',function(dotdelcrm){
			var inputclassname = $.trim(dotdelcrm.find('#inputclassname').val());
			if(classname == inputclassname){
				$.ajax({
					url : '/aroom/classes/initclass.html',
					type : 'post',
					data : {'classid':classid,'classname':classname},
					success : function(data){
						if(data == 1){
							alert('初始化成功');
							location.reload(true);
						}
						else
							alert('初始化失败,操作取消');
					}
				});

			}else{
				alert('确认失败,操作取消.');
			}
		},'inputclassname');
	});
}
var _tclassname;
$('.aedit').click(function(){
	var button = new xButton();
	button.add({
		value:"确定",
		callback:function(){
			saveedit();
			return false;
		},
		autofocus:true
	});

	button.add({
		value:"取消",
		callback:function(){
			closedialog('edit');
			return false;
		}
	});
	if(!H.get('dialogedit')){
		H.create(new P({
			id : 'dialogedit',
			title: '编辑',
			easy:true,
			width:400,
			padding:5,
			content:$('#dialogedit')[0],
			button:button
		}),'common');
	}
	var classinfo = $(this).parent().find('.classinfo');
	$('#class_edit_classid').val(classinfo.attr('classid'));
	$('#class_edit_classname').val(classinfo.attr('classname'));
	_tclassname = classinfo.attr('classname');
	$('#editclassmsg').html(' ');
	$('#class_edit_classname').next('em').remove();
	$('#class_edit_grade input[type=radio][value='+classinfo.attr('grade')+']').click();
	H.get('dialogedit').exec('show');
});

function saveedit(){
	var classname = $('#class_edit_classname').val();
	var classid = $('#class_edit_classid').val();
	var grade = $('#class_edit_grade input[type=radio]:checked').val();
	if(!checkclassname('edit')){
		return;
	}
	$.ajax({
		type:'post',
		url:'<?=geturl('aroomv2/classes/edit')?>',
		dataType:'text',
		data:{'classname':classname,'classid':classid,'grade':grade},
		success:function(data){
			dialogtip();
			if(data==1){
				H.get('xtips').exec('setContent','修改成功').exec('show').exec('close',500);
			}else{
				H.get('xtips').exec('setContent','修改失败').exec('show').exec('close',500);
			}

		}
	});
}
function saveadd(){
	var classname = $('#class_add_classname').val();
	if(classname == '请输入班级名称'){
		$('#class_add_classname').focus();
		return;
	}
	var grade= $('#class_add_grade input[type=radio]:checked').val();

	if(!checkclassname('add')){
		return;
	}
	$.ajax({
		type:'post',
		url:'<?=geturl('aroomv2/classes/add')?>',
		dataType:'text',
		data:{'classname':classname,'grade':grade},
		success:function(data){
			dialogtip();
			if(data==1){
				H.get('xtips').exec('setContent','添加成功').exec('show').exec('close',500);
			}else{
				H.get('xtips').exec('setContent','添加失败').exec('show').exec('close',500);
			}

		}
	});
}
function dialogtip(){
	if(!H.get('xtips')){
		H.create(new P({
			id:'xtips',
			easy:true,
			padding:10
		},{
			onclose:function(){
				location.reload(true);
			}
		}),'common');
	}
}
function addclass(){
	var _xform = new xForm({
			domid:'dialogadd',
			errorcss:'cuotic',
			okcss:'zhengtic',
			showokmsg:false
		});
	var button = new xButton();
	button.add({
		value:"确定",
		callback:function(){
			saveadd();
			return false;
		},
		autofocus:true
	});

	button.add({
		value:"取消",
		callback:function(){
			closedialog('add');
			return false;
		}
	});
	if(!H.get('dialogadd')){
		H.create(new P({
			id : 'dialogadd',
			title: '添加班级',
			easy:true,
			width:400,
			padding:5,
			content:$('#dialogadd')[0],
			button:button
		}),'common');
	}
	$('#class_add_classname').next('em').remove();
	H.get('dialogadd').exec('show');
}
function checkclassname(type){
	classerr = 0;
	var tclassname = $.trim($('#class_'+type+'_classname').val());

	$('#class_'+type+'_classname').next('em').remove();
	if(tclassname==''){
		$('#'+type+'classmsg').attr('class','emacuo p3');
		$('#'+type+'classmsg').html('<font color="red">班级名称不能为空</font>');
		// $('#class_'+type+'_classname').after('<em class="emacuo"><font color="red">班级名称不能为空</font></em>');
		classerr = 1;
		return false;
	}else{
		if (tclassname.length>15) {
			$('#'+type+'classmsg').attr('class','emacuo p3');
			$('#'+type+'classmsg').html('<font color="red">班级名称太长，应该为15个字符以内!</font>');
			// $('#class_'+type+'_classname').after('<em class="emacuo"><font color="red">班级名称太长，应该为15个字符以内!</font></em>');
			classerr = 1;
			return false;
		}
		else{
			$('#'+type+'classmsg').html(' ');
		}
	}
	if(!(type=='edit' && _tclassname==tclassname)){
	$.ajax({
		type:"POST",
		dataType:"JSON",
		url: "<?=geturl('aroomv2/classes/classnameexists')?>",
		data:{'classname':tclassname},
		async:false,
		success: function(data){
			if(data == 1) {
				$('#'+type+'classmsg').attr('class','emacuo p3');
				$('#'+type+'classmsg').html('<font color="red">班级已存在!</font>');
				classerr = 1;
			} else {
				classerr = 0;
				$('#'+type+'classmsg').html(' ');
			}
		}
	});
	}
	if(classerr)
		return false;
	return true;
}

$('.adel').click(function(){
	var button = new xButton();
	button.add({
		value:"确定",
		callback:function(){
			savedel();
			return false;
		},
		autofocus:true
	});

	button.add({
		value:"取消",
		callback:function(){
			closedialog('del');
			return false;
		}
	});
	if(!H.get('dialogdel')){
		H.create(new P({
			id : 'dialogdel',
			title: '删除班级',
			easy:true,
			width:400,
			padding:5,
			content:$('#dialogdel')[0],
			button:button
		}),'common');
	}
	var classinfo = $(this).parent().find('.classinfo');
	$('#class_del_classid').val(classinfo.attr('classid'));
	H.get('dialogdel').exec('show');
});

function savedel(){
	var classid = $('#class_del_classid').val();
	$.ajax({
		type:'post',
		url:'<?=geturl('aroomv2/classes/deleteclass')?>',
		dataType:'JSON',
		data:{'classid':classid},
		success:function(data){
			dialogtip();
			H.get('xtips').exec('setContent',data.message).exec('show').exec('close',500);


		}
	});
}
$('.adelunable').click(function(){
	var button = new xButton();

	button.add({
		value:"确定",
		callback:function(){
			closedialog('delunable');
			return false;
		}
	});
	if(!H.get('dialogdelunable')){
		H.create(new P({
			id : 'dialogdelunable',
			title: '删除班级',
			easy:true,
			width:400,
			padding:5,
			content:$('#dialogdelunable')[0],
			button:button
		}),'common');
	}
	H.get('dialogdelunable').exec('show');
});
$('.ainit').click(function(){
	var button = new xButton();
	button.add({
		value:"确定",
		callback:function(){
			saveinit();
			return false;
		},
		autofocus:true
	});

	button.add({
		value:"取消",
		callback:function(){
			closedialog('init');
			return false;
		}
	});
	if(!H.get('dialoginit')){
		H.create(new P({
			id : 'dialoginit',
			title: '初始化班级',
			easy:true,
			width:400,
			padding:5,
			content:$('#dialoginit')[0],
			button:button
		}),'common');
	}
	var classinfo = $(this).parent().find('.classinfo');
	$('#class_init_classid').val(classinfo.attr('classid'));
	H.get('dialoginit').exec('show');
});

function saveinit(){
	var classid = $('#class_init_classid').val();
	$.ajax({
		type:'post',
		url:'<?=geturl('aroomv2/classes/initclass')?>',
		data:{'classid':classid},
		success:function(data){
			dialogtip();
			if(data==1){
				H.get('xtips').exec('setContent','初始化成功').exec('show').exec('close',500);
			}else{
				H.get('xtips').exec('setContent','初始化失败').exec('show').exec('close',500);
			}

		}
	});
}

$(function(){
	$("#choosetsimp").delegate('.labelstar', 'click', function(){
		if ($(this).hasClass("star_on")){
			$(this).attr("title","设为班主任");
			$(this).removeClass("star_on");
		} else {
			$(".star_on").attr("title","设为班主任");
			$(".star_on").removeClass("star_on");
			$(this).addClass("star_on");
			$(this).attr("title","取消班主任");
		}
	});
});
/*更多操作*/

</script>

<?php $this->display('aroomv2/page_footer')?>