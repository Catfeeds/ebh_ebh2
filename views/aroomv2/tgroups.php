<?php
$this->display('aroomv2/page_header');
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
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css<?=getv()?>"/>

<div class="ter_tit">当前位置 > 教师管理 ><a href="#">教研组</a></div>
		<!--<div class="tiezitool"><a class="hongbtn jiabgbtn" onclick="location.href='<?=geturl('aroomv2/tgroups/addGroup')?>'">添加分组</a></div>-->
<div class="jiaoyanzu">
    	<div class="jiaoyanzu_top fr">
        	<ul>
            	<li class="fl "><a href="javascript:showaddgroup();">添加教研组</a></li>
            </ul>
        </div>
        <div class=" clear"></div>
        <div class="jiaoyanzu_bottom">

			<table cellpadding="0" cellspacing="0">
				<tr height="36" bgcolor="#f1f1f1" class="first">
                	<td width="134">教研组</td>
                    <td width="473">教研组成员</td>
                    <td width="177">操作</td>
                </tr>
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
				<tr height="101" class="trcolor">
					<td width="134" title="<?=$group['groupname']?>">
						<?=shortstr($group['groupname'],30,'')?>
					</td>
					<td width="473" id="teachername_<?=$group['groupid']?>" title="<?=!empty($group['teachers'])?$group['teachers']:''?>">
						<?=!empty($group['teachers'])?shortstr($group['teachers'],30,'...'):''?>
					</td>
					<td width="177">
                    	<a href="javascript:chooseteacher(<?=$group['groupid']?>)" class="backstage">选择成员</a>
						<input type="hidden" id="teacherids_<?=$group['groupid']?>" value="<?=!empty($group['teacherids'])?$group['teacherids']:''?>" />
                        <a href="javascript:showeditgroup(<?=$group['groupid']?>)">编辑</a>
						<!--<input type="hidden" id="edit_<?=$group['groupid']?>" value="<?=!empty($group['teacherids'])?$group['teacherids']:''?>" />-->
                        <a href="javascript:showdelgroup(<?=$group['groupid']?>);">删除</a>
						<!--<input type="hidden" id="del_<?=$group['groupid']?>" value="<?=!empty($group['teacherids'])?$group['teacherids']:''?>" />-->
                    </td>
				</tr>
				<?php }}else{?>
				<tr><td colspan="3" align="center">暂无记录</td></tr>
				<?php }?>
			</table>
		</div>
	</div>
<?=$pagestr?>

</div>
<script type="text/javascript">
//$(function(){
//		$(".ui-dialog-autofocus").click(function(){
//		
//		});
//	});
//	
//添加
function showaddgroup(){
	$('#crphoneinput').val($('#crphone').html());
	$('#craddressinput').val($('#fulladdress').val());
	var button = new xButton();
	button.add({
		value:"保存",
		callback:function(){
			saveteacher(groupid);
			H.get('addtgroups').exec('close');
			return false;
		},
		autofocus:true
	});

	button.add({
		value:"取消",
		callback:function(){
			// location.reload();
			H.get('addtgroups').exec('close');
			return false;
		}
	});

	if(!H.get('addtgroups')){
		H.create(new P({
			id : 'addtgroups',
			title: '添加教研组',
			easy:true,
			width:420,
			padding:5,
			button:button,
			content:$('#addtgroups')[0]
		}),'common').exec('show');
		
	}else{
		H.get('addtgroups').exec('show');
	}
		
		
	if(checkgroupname() && checksummary()){
		alert('xxxxx');
			$.ajax({
			   type: "POST",
			   dataType: "json",
			   url: "<?=geturl('aroomv2/tgroups/editGroupAjax')?>",
			   data: $("#groupvalue").serialize(),
			   success: function(res){
				if(res.status=="1"){
					$.showmessage({
						message:res.msg,
						callback :function(){
						  document.location=document.referrer;
						}});
					}else{
						$.showmessage({message:res.msg});
					}	
			   }
			});
			return false;
		}

	var checkgroupname = function(){
		if($("#groupname").val().replace(/\s/g,"")==""){
			$("#groupnamespan").css("color","red").html("请输入分组名称");
			return false;
		}
		$("#groupnamespan").css("color","#999").html("请输入分组名称如：语文组");
		return true;
	}
	var checksummary =function(){
		if ($("#summary").val().length>256) {
			$("#summary_msg").css("color","red").html("分组详细介绍应在256字以内！");
			return false;
		};
		$("#summary_msg").css("color","#999").html("分组详细介绍(256字以内)");
		return true;
	}
}
//编辑
function showeditgroup(){
	var button = new xButton();
	button.add({
		value:"保存",
		callback:function(){
			saveteacher(groupid);
			H.get('editgroup').exec('close');
			return false;
		},
		autofocus:true
	});

	button.add({
		value:"取消",
		callback:function(){
			// location.reload();
			H.get('editgroup').exec('close');
			return false;
		}
	});

	if(!H.get('editgroup')){
		H.create(new P({
			id : 'editgroup',
			title: '编辑教研组',
			easy:true,
			width:420,
			padding:5,
			button:button,
			content:$('#editgroups')[0]
		}),'common').exec('show');
		
	}else{
		H.get('editgroup').exec('show');
	}

}
//删除
function showdelgroup(){
	var button = new xButton();
	button.add({
		value:"保存",
		callback:function(){
			saveteacher(groupid);
			H.get('editgroup').exec('close');
			return false;
		},
		autofocus:true
	});

	button.add({
		value:"取消",
		callback:function(){
			// location.reload();
			H.get('delgroups').exec('close');
			return false;
		}
	});

	if(!H.get('delgroups')){
		H.create(new P({
			id : 'delgroups',
			title: '删除教研组',
			easy:true,
			width:420,
			padding:5,
			button:button,
			content:$('#delgroups')[0]
		}),'common').exec('show');
		
	}else{
		H.get('delgroups').exec('show');
	}

}
//function delgroup(groupid) {
//	$.confirm("您确定要删除分组吗?",function(){
//		$.ajax({
//			type:'post',
//			url:'<?=geturl('aroomv2/tgroups/delGroupAjax')?>',
//			dataType:'json',
//			data:{'groupid':groupid},
//			success:function(res){
//				if(res.status=="1"){
//					$.showmessage({
//						message:res.msg,
//						callback :function(){
//                           window.location.reload();
//                       }});
//				}else{
//					$.showmessage({message:res.msg});
//				}
//			},
//			error:function(){
//				alert("服务器连接错误，请重试");
//			}
//		});
//	});
//
//}
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
		   url:'<?=geturl('aroomv2/classes/getroomteachers')?>',
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
			url: "<?=geturl('aroomv2/tgroups/addTeacherAjax')?>",
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

<!--新建教研组-->
<div id="addtgroups" class="tanchukuang" style="display:none">
	<div class="title"><p>新建教研组</p></div>
    <div class="mingcheng mt15">
    	<span>教研组名称：</span>
        <input id="groupname" class="text" type="text" />
     </div>
     <div class="jieshao">
    	<span class="span3">教研组介绍：</span>
        <textarea class="text1" id="summary"></textarea>
     </div>
</div>

<!--编辑教研组-->
<div id="editgroups" class="tanchukuang" style="display:none">
	<div class="title"><p>编辑教研组</p></div>
	<div class="mingcheng mt15">
		<span>教研组名称：</span>
		<input id="groupname" class="text" type="text" value="<?=$group['groupname']?>"/>
	</div>
	<div class="jieshao">
		<span class="span3">教研组介绍：</span>
		<textarea class="text1"><?=$group['summary']?></textarea>
	</div>
</div>

<!--删除教研组-->
<div id="delgroups" class="tanchukuang" style="display:none">
	<div class="title"><p>删除教研组</p></div>
    <div class="tishi"><span>你确定要删除该教研组吗？</span></div>
</div>

</div>
<?php $this->display('aroomv2/page_footer')?>