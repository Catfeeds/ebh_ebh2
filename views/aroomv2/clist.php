<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>课程管理（子）</title>
</head>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css<?=getv()?>"/>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js?v=20150731"></script>
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
}

</style>
<body>
<div >
    <div class="ter_tit">
        当前位置 > <a href="<?=geturl('aroomv2/course')?>">课程管理</a> > 课程列表
    </div>
    <div class="kechengguanli">
    	<div class="kechengguanli_top fr">
        	<ul>
            	<li class="fl "><a href="<?=geturl('aroomv2/course/add')?>">开设课程</a></li>
            </ul>
        </div>
        <div class=" clear"></div>
        <div class="kechengguanli_bottom">
        	<table cellpadding="0" cellspacing="0" class="tables">
            	<tr class="first">
                	<td width="258">课程</td>
                    <td width="300">授课教师</td>
                    <td width="196">操作</td>
                </tr>
				<?php foreach($courselist as $course){?>
                <tr>
                	<td width="258" class="subject">
                    	<a href="javascript:void(0)" class="fl"><img style="width:57px;height:80px;" src="<?=empty($course['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$course['img']?>" /></a>
                    	<p class="fl"><span class="span2"><?=$course['foldername']?></span><br/>
                        <span><?=$course['dateline']?></span><br/>
                        <span>课件：<?=$course['coursewarenum']?>&nbsp;&nbsp;人气：<?=$course['viewnum']?></span></p>
                    </td>
                    <td width="300"><p style="width:270px;word-wrap: break-word;float:left;"><?=$course['teachers']?></p></td>
                    <td width="196">
                    	<a href="javascript:chooseteacher(<?=$course['folderid']?>)" class="backstage">选择教师</a>
						<input type="hidden" id="teacherids_<?=$course['folderid']?>" value="<?=!empty($course['teachers'])?$course['teacherids']:''?>" />						
                        <a href="<?=geturl('aroomv2/course/edit/'.$course['folderid'])?>">编辑</a>
                        <a href="javascript:delcourse(<?=$course['folderid']?>,<?=$course['coursewarenum']?>);">删除</a>
                        <a href="#"><img src="http://static.ebanhui.com/ebh/tpl/aroomv2/images/jiantou1.jpg" /></a>
                        <a href="#"><img src="http://static.ebanhui.com/ebh/tpl/aroomv2/images/jiantou2.jpg" /></a>
                    </td>
                </tr>
                <?php }?>
            </table>
        </div>
    </div>
	
	<?=$pagestr?>
    
</div>

<!--删除课程-->
<div id="dialogdel" style="display:none">
<div class="deletecourse">
	<div class="title"><p>删除课程</p></div>
    <div class="tishi mt40"><p style="padding-left:90px; font-size:14px;">该课程下还有课件，如要删除，请先删除课件！</p></div>
     <div class="button">
     	<div class="fl button2"><a href="#">删除课件</a></div>
        <div class="fr button3"><a href="#">取 消</a></div>
     </div>
</div>
</div>
<!--选择教师-->
<div id="dialogct" style="display:none">
<div class="chooseteacher" style="display:none">
	<div class="terwai">
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
		<input type="button" onclick="allteacher($('#teachername').val())" class="souhuang" value="搜 索" name="searchbutton">
		</div>
		</div>
		<div class="xianquan">
		<ul style="" id="choosetall">
		<?php foreach($roomteacherlist as $teacher){?>
		<li id="all<?=$teacher['uid']?>"><input type="checkbox" id="allteacheri<?=$teacher['uid']?>" onclick="choose('<?=$teacher['uid']?>','<?=$teacher['realname']?>(<?=$teacher['username']?>)',this)" value="<?=$teacher['uid']?>" style="top:2px;" ><label title="<?=$teacher['realname']?>(<?=$teacher['username']?>)" id="teachername_<?=$teacher['uid']?>" for="allteacheri<?=$teacher['uid']?>" style="margin-left:4px;_margin-left:2px;"><?=$teacher['realname']?>(<?=$teacher['username']?>)</label></li>
		<?php }?>
		</ul>
		</div>
	</div>
</div>
</div>
<script>

function delcourse(courseid,coursewarenum) {
	if(coursewarenum>0){
		alert('该课程下还有课件，如要删除，请先删除课件!');
		return ;
	}
	
	if(!H.get('dialogdel')){
		H.create(new P({
			id : 'dialogdel',
			title: '删除课程',
			easy:true,
			width:400,
			padding:5,
			content:$('#dialogdel')[0],
			okValue: '提交',
			cancelValue:'取消'
		}),'common');
	}
		
	H.get('dialogdel').exec('show');
}

var allteachers = <?=json_encode($roomteacherlist)?>;

function chooseteacher(courseid) {
	var teacherdis = $("#teacherids_"+courseid).val();
	$("#choosetsimp").empty();
	if(teacherdis == "") {
		$("#noteacher").html("还未设置任何任课教师");
	}
	$("#choosetall li input").removeAttr("checked");
	
	var button = new xButton();
	button.add({
		value:"保存",
		callback:function(){
			saveteacher(courseid);
			H.get('chooseteacher').exec('close');
			return false;
		},
		autofocus:true
	});

	button.add({
		value:"取消",
		callback:function(){
			// location.reload();
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
				var listr = '<li  id="simp'+t.uid+'" onmouseout="this.className=\'mylabel\'" onmouseover="this.className=\'mylabel mylabelhover\'" class="mylabel">';
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
		title:'选择任课老师',
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
		url:'<?=geturl('aroom/classes/getroomteachers')?>',
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
				var itemstr = '<li><input type="checkbox" style="top:2px;" value="'
				+item['teacherid']+'" ' + checkstatus + ' onclick="choose(\''+item['teacherid']+'\',\''+uname+'\',this)" id="allteacheri'
				+item['teacherid']+'" '+checkstatus
				+'/><label style="margin-left:4px;_margin-left:2px;" id="teachername_"'+item['teacherid']+' for="allteacheri'+item['teacherid']
				+'" title="'+item['realname']+'('+item['username']+')">'+item['realname']+'('+item['username']+')</label></li>';

				$('#choosetall').append(itemstr);

			});
		}
	}); 
}
var choose = function(teacherid,teachername,dom){
		if($(dom).prop("checked")){
			$("#noteacher").css("display","none");
			$("#choosetsimp").css("display","block");
			var listr = '<li  id="simp'+teacherid+'" onmouseout="this.className=\'mylabel\'" onmouseover="this.className=\'mylabel mylabelhover\'" class="mylabel">';
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
function saveteacher(courseid) {
		var teacherids = "";
		var simp = $("#choosetsimp").children();
		for(var i = 0; i <simp.length; i++) {
			var teacherid = $(simp[i]).attr("id");
			teacherid = teacherid.substring("simp".length);
			if(i == 0)
				teacherids = teacherid;
			else
				teacherids += ","+teacherid;
		}
		$.ajax({
			type: "POST",
			url: "<?=geturl('aroom/course/chooseteacher')?>",
			data:{'courseid':courseid,'teacherids':teacherids},
			dataType:'json',
			success: function(json){
				H.remove('chooseteacher');
		   		H.create(new P({
		   			content:'操作成功',
		   			padding:10,
		   			easy:true
		   		},{
		   			onclose:function(){
		   				location.reload();
		   			}
		   		}),'common').exec('show').exec('close',500);
		   }
		}); 
	}
</script>
</body>
</html>
