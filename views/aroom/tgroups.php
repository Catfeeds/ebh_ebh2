<?php
$this->display('aroom/page_header');
?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen">
<STYLE TYPE="text/css">
.cqshangc {
	padding-bottom:10px;	
	width: 748px;
	border: 1px solid #cdcdcd;
	float:left;
}
.cqshangc .sckezi {
	font-size: 14px;
	font-weight: bold;
	color: #6683c7;
	height: 35px;
	width: 718px;
	border-bottom-width: 1px;
	border-bottom-style: solid;
	border-bottom-color: #cdcdcd;
	margin-left: 10px;
	padding-left: 10px;
	line-height: 35px;
}
.cqshangc .cqleftsc {
	float: left;
	width: 478px;
	font-size: 14px;
	margin-top: 15px;
	padding-left: 20px
}
.inpxuanx {
	height: 32px;
	border:none;
	padding-left: 5px;
	overflow: hidden;
	font-size: 14px;
	line-height: 32px;
	display: block;
	color: #666666;
}

.cqshangc .cqrightsc {
	float: left;
	left: 480px;
	width: 250px;
	margin-top: 15px;
	font-size: 14px;
	position: absolute;
	_top:140px;
}
.cqshangc .cqleftsc .pxxuanx {
	height: 32px;
	display: block;
	float: left;
	line-height: 32px;

}
.sds {
	height: 184px;
	width: 145px;
	border: 1px solid #cdcdcd;
	background-image:url(http://static.ebanhui.com/ebh/tpl/2012/images/dise.jpg);
	background-repeat: no-repeat;
	background-position: center center;
	margin-bottom: 8px;
	margin-right: auto;
	margin-left: auto;
}
.cqshangc .cqrightsc .cqbc {
	background: url(http://static.ebanhui.com/ebh/tpl/2012/images/xgtxbtn.png) no-repeat;
	height: 33px;
	line-height:33px;
	width: 120px;
	border:none;
	font-size: 14px;
	cursor:pointer;
	float: left;
	margin-left:70px;
	_margin-left:35px;
	display: block;
	color:#fff;
}
.cqshangc .cqrightsc .cqxg {
	background:url(http://static.ebanhui.com/ebh/tpl/2012/images/xiugai_inp01.png) no-repeat;
	height:35px;
	cursor:pointer;
	width: 70px;
	float: left;
	margin-left: 60px;
	margin-right: 10px;
	border:none;
}


.sds img {
	margin-top: 6px;
	margin-left: 8px;
}


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
    background-color: #fff;
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

</STYLE>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />

<div class="ter_tit">
	当前位置 > <a href="<?=geturl('aroom/tgroups')?>">分组管理</a> > 所有分组
	</div>
	<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:788px;">
	<div class="annuato" style="line-height:28px;padding-left:20px;position: relative;">
		<div class="tiezitool"><a class="hongbtn jiabgbtn" onclick="location.href='<?=geturl('aroom/tgroups/addGroup')?>'">添加分组</a></div>
	</div>
<table class="datatab" width="100%" style="border:none;">
<thead class="tabhead">
<tr>
<th>分组名称</th>
<th>任课老师</th>
<th>选择</th>
<th>操作</th>
</tr>
</thead>
<tbody>
	<?php if(!empty($groupsList)){
		foreach($groupsList as $group){
			$key1 = 'groupid_tid_'.$group['groupid'];
			$key2 = 'groupid_tname_'.$group['groupid'];
			if(array_key_exists($key1, $teachergroups)){
				$group['teacherids'] = implode(',', $teachergroups[$key1]);
			}
			if(array_key_exists($key2, $teachergroups)){
				$group['teachers'] = implode(',', $teachergroups[$key2]);
			}

	?>			
		<tr>
		<td width="25%" title="<?=$group['groupname']?>"><?=shortstr($group['groupname'],30,'')?></td>
		<td width="35%" id="teachername_<?=$group['groupid']?>" title="<?=!empty($group['teachers'])?$group['teachers']:''?>"><?=!empty($group['teachers'])?shortstr($group['teachers'],30,'...'):''?></td>
		<td width="12%"><a class="workBtn" href="javascript:chooseteacher(<?=$group['groupid']?>)">选择</a><input type="hidden" id="teacherids_<?=$group['groupid']?>" value="<?=!empty($group['teacherids'])?$group['teacherids']:''?>" /></td>
		<td width="20%">
		<a class="workBtn" href="<?=geturl('aroom/tgroups/editGroup/'.$group['groupid'])?>">编辑</a>
		<a class="workBtn" href="javascript:delgroup(<?=$group['groupid']?>);">删除</a>
		
		</td>
		</tr>
	<?php }}else{?>
	<tr><td colspan="6" align="center">暂无记录</td></tr>
	<?php }?>
</tbody>
</table>
<?=$pagestr?>
<script type="text/javascript">
function delgroup(groupid) {
	$.confirm("您确定要删除分组吗?",function(){
		$.ajax({
			type:'post',
			url:'<?=geturl('aroom/tgroups/delGroupAjax')?>',
			dataType:'json',
			data:{'groupid':groupid},
			success:function(res){
				if(res.status=="1"){
					$.showmessage({
						message:res.msg,
						callback :function(){
                           window.location.reload();
                       }});
				}else{
					$.showmessage({message:res.msg});
				}
			},
			error:function(){
				alert("服务器连接错误，请重试");
			}
		});
	});

}
function chooseteacher(groupid) {
	var teacherdis = $("#teacherids_"+groupid).val();
	$("#choosetsimp").empty();
	if(teacherdis == "") {
		$("#noteacher").html("还未设置任何任课教师");
	}
	$("#choosetall li input").removeAttr("checked");
	
	var button = new xButton();
	button.add({
		value:"保存",
		callback:function(){
			saveteacher(groupid);
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
	}),'common');
	H.get('chooseteacher').exec('show');
}

var allteacher = function(uname){
		//url = '';
		var uid = $('.dilan :checked').val();
		if(uname == "请输入老师姓名或账号")
			uname = "";
		//if(uname){
		//	url='&uname='+encodeURIComponent(uname);
		//}
		$.ajax({
		   type: "GET",
		   //url: "#getsitecpurl()#?action=aroomteacher&op=getcourseteacher&crid=$crid"+url+"&t="+(new Date()).getTime(),
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
	function saveteacher(groupid) {
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
			url: "<?=geturl('aroom/tgroups/addTeacherAjax')?>",
			data:{'groupid':groupid,'teacherids':teacherids},
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
	var allteachers = <?=json_encode($roomteacherlist)?>;
</script>

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
<?php $this->display('aroom/page_footer')?>