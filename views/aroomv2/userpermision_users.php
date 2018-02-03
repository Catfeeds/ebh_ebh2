<?php $this->display('aroomv2/page_header')?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xform.js?v=1"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery.confirm.js"></script>
<link rel="stylesheet" href="http://static.ebanhui.com/ebh/js/xztree/css/zTreeStyle/zTreeStyle.css" type="text/css">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xztree/js/jquery.ztree.core-3.5.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xztree/js/jquery.ztree.excheck-3.5.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xztree/js/jquery.ztree.exedit-3.5.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen">
<style>
.button {float: none;}
.ztree li span.button.add {
  margin-left: 10px;
  background-position: -144px 0;
  vertical-align: top;
}
.ztree li span.button.edit {
	margin-left: 10px;
}
.ztree li span.button.remove {
	margin-left: 10px;
}
.ztree *{
	font-size:14px;
}
.ztree li{
	padding: 2px;
}
.ztree li a{
	padding:5px;
	height: 16px;
	text-decoration: none;
	cursor: pointer;
}
.ztree li a.curSelectedNode,.ztree li a:hover{
	padding:5px;
	background-color: #FFE6B0;
	color: black;
	 height: 16px; 
	border: 0;
	opacity: 0.8;
	text-decoration: none;
	cursor: pointer;
}
.ztree li a input.rename{
	height:20px;
	font-size: 18px;
	padding: 2px;
	width: 500px;
	margin-left: 5px;
	margin-top: -4px;
	margin-right: -8px;
	border: 0;
}
.ztree li span.button.ico_docu {
    background-position: -110px 0;
}
.ztree li span.button.choose {
    background-position: -127px -16px;
    margin-left: 10px;
    vertical-align: top;
}
.ztree li span.button.diy01_ico_docu{margin-right:2px; background-position:-110px -32px; vertical-align:top; *vertical-align:middle}

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
.xznj .pads{ margin-left:45px; padding-left:48px;}

</style>

<body>

<div>
	<div class="ter_tit">
        当前位置 > <a href="<?=geturl('aroomv2/userpermisions')?>">用户权限</a> >
        用户权限
    </div>
    <div class="banjiguanli">
    	<div class="banjiguanli_top fr">
        	<ul>
                <li class="fl ml20"><a href="javascript:adduser
				()">添加用户</a></li>
            </ul>
        </div>
        <div class=" clear"></div>
        <div class="banjiguanli_bottom">
        	<table cellpadding="0" cellspacing="0" class="tables">
            	<tr  class="first">
                	<td width="200">教师信息</td>
                    <td width="483">权限范围</td>
                    <td width="100">操作</td>
                </tr>
				<?php  

				if(!empty($teachercontrollist)) {
				foreach($teachercontrollist as $teacher){?>
                <tr>
                	<td width="200" ><?=$teacher['username'].'['.$teacher['realname'].']'?></td>
                    <td width="483">
						<p style="width:295px;word-wrap: break-word;float:left;">
						<?php
							$powerstr = '';
							if(!empty($teacher['power'])) {
								foreach($teacher['power'] as $tpower) {
									if($powerstr == '') {
										$powerstr = $tpower['catalogname'];
									} else {
										$powerstr = $powerstr.','.$tpower['catalogname'];
									}
								}
							}
						?>
						<?= $powerstr ?>
						</p>
					</td>
                    <td width="100">
                        <a href="javascript:void(0)" onclick="choosepower(<?= $teacher['tid'] ?>);return false;" class="setpower">设置范围</a>
                        <a href="javascript:void(0)" onclick="deluser(<?= $teacher['tid'] ?>,'<?=$teacher['username'].'['.$teacher['realname'].']'?>');return false;" class="delpower">删除</a>
						<input type="hidden" id="tpower_<?= $teacher['tid'] ?>" value="<?= $teacher['folderids'] ?>" />
                    </td>
                </tr>
				<?php }
				} else {
				?>
				<tr><td colspan="3" align="center">暂无记录</td></tr>
				<?php } ?>
         </table>
        </div>
    </div>
	
</div>
</body>

<!--选择教师-->
<div class="chooseteacher" style="display:none">
	<div class="terwai">
	<div class="ternei">
	</div>
	<span id="choosettitle" style="color:#0068b7;"></span>
	<div id="" class="terlie">
			<div id="noteacher">还未选择任何教师</div>
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
<input type="hidden" id="teacherids" values="<?= $teacherids ?>" />
<!--权限树-->
<div class="choosepower curriculumviews_l fl" style="display:none;">
	<div style="width:400px;height:400px;overflow:auto">
		<ul id="cate_tree" class="ztree"></ul>
	</div>
</div>
<br />
<br />
<!--权限树end-->
<!--删除教师-->
<div id="delteacher" class="tanchukuang" style="display:none;height:130px;">
    <div class="tishi"><span class="deltip" style="margin-left:50px;">你确定要删除该用户吗？</span></div>
</div>
<!--删除教师end-->

<script type="text/javascript">
	function adduser() {
		chooseteacher();
	}

	function chooseteacher() {
		var teacherdis = $("#teacherids").val();
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
			title:'选择教师用户',
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
	function saveteacher(classid) {
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
			url: "<?=geturl('aroomv2/userpermision/chooseteacher')?>",
			data:{'teacherids':teacherids},
			dataType:'json',
			async:false,
			success: function(json){
				dialogtip();
				H.get('xtips').exec('setContent','修改成功').exec('show').exec('close',500);
		   }
		}); 
	}
	var allteachers = <?=json_encode($roomteacherlist)?>;


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


	
	//tree
	var setting = {
		data: {
			simpleData: {
				enable: true
			}
		},
		callback: {
			beforeClick: beforeClick
		},
		check: {
			enable: true
		}
	};
	var zNodes = new Array();
	var idstr;
	function beforeClick(treeId, treeNode, clickFlag) {
		return (treeNode.click != false);
	}
	function savepower(tid) {
		var checknodes = new Array();
		var nochecknodes = new Object();
		var treeObj = $.fn.zTree.getZTreeObj("cate_tree");
		var nodes = treeObj.getCheckedNodes(true);
		nodes = nodes.sort(sortlevel);
		for(var i = nodes.length - 1; i >= 0; i --) {
			var curnode = nodes[i];
			var pnode = curnode.getParentNode();
			if(nochecknodes[curnode.tId] != undefined) {
				if(pnode != null) {
					nochecknodes[pnode.tId] = 1;
				}
				continue;
			}
			if(pnode == null) {
				checknodes[checknodes.length] = curnode;
			} else {
				var cnodes = pnode.children;
				for(var ci = 0; ci < cnodes.length; ci ++) {
					if(!cnodes[ci].checked || nochecknodes[cnodes[ci].tId] != undefined) {	//如果兄弟结点中有未选中的，则不选中父节点，否则 子节点不选中，直接选中父节点即可
						checknodes[checknodes.length] = curnode;
						nochecknodes[pnode.tId] = 1;
						break;
					}
				}
			}
		}
		var checkstr = "";
		var checkidstr = "";
		for(var j = 0; j < checknodes.length; j ++) {
			if(checkstr == "") {
				checkstr = checknodes[j].name;
			} else {
				checkstr = checkstr + "," + checknodes[j].name;
			}
			if(checkidstr == "") {
				checkidstr = checknodes[j].id;
			} else {
				checkidstr = checkidstr + "," + checknodes[j].id;
			}
		}
		saveteacherpower(tid,checkidstr);
	}
	function saveteacherpower(tid,powerids) {
		$.ajax({
			type:'post',
			url:'<?=geturl('aroomv2/userpermision/savepower')?>',
			dataType:'JSON',
			data:{'tid':tid,'powerids':powerids},
			success:function(data){
				if(data != undefined && data.success != undefined && data.success == 1) {
					var aaa = 1;aaa=aaa+1;
				}
				dialogtip();
				H.get('xtips').exec('setContent',data.message).exec('show').exec('close',500);
			}
		});
	}
	//对树节点按照level进行排序 flag=1 表示从下到上 其他则表示从上到下
	function sortlevel(nodea,nodeb) {
		return nodea.level - nodeb.level;
	}
	$(function(){
		$.post("<?=geturl('aroomv2/userpermision/powernodes')?>", function(data){
			if(data != undefined)
			{
				//初始化课程目录节点
				$.each(data.cataloglist, function(i,n){
					zNodes.push({
						id:n.catalogid,
						pId:n.pid,
						name:n.catalogname,
						click:false
					});
				});

				$.fn.zTree.init($("#cate_tree"), setting, zNodes);
			}
		}, "json");
	});
	function choosepower(tid) {
		var treeObj = $.fn.zTree.getZTreeObj("cate_tree");
		treeObj.checkAllNodes(false);
		var powers = $("#tpower_"+tid).val();
		if(powers != "") {
			var pidarr = powers.split(',');
			for(var i = 0; i < pidarr.length; i++) {	
				var pid = pidarr[i];
				var treeNode = treeObj.getNodeByParam("id", pid, null);
				treeObj.checkNode(treeNode, true, true);
			}

		}
		var button = new xButton();
		button.add({
			value:"确定",
			callback:function(){
				savepower(tid);
				return false;
			},
			autofocus:true
		});

		button.add({
			value:"取消",
			callback:function(){
				H.get('choosepower').exec('close');
				return false;
			}
		});
		
		H.create(new P({
			id:'choosepower',
			content:$('.choosepower')[0],
			title:'选择用户权限范围',
			easy:true,
			button:button
		},{
			'onshow':function(){
				$(this).focus();
				return false;
			}
		}),'common').exec('show');
	}
//tree end
//del
//删除
	function deluser(tid,tinfo){
		$('.deltip').html("你确定要删除 " + tinfo + " 的权限吗？");
		var button = new xButton();
		button.add({
			value:"确定",
			callback:function(){
				deluserpower(tid);
				H.get('delteacher').exec('close');
				return false;
			},
			autofocus:true
		});

		button.add({
			value:"取消",
			callback:function(){
				// location.reload();
				H.get('delteacher').exec('close');
				return false;
			}
		});

		if(!H.get('delteacher')){
			H.create(new P({
				id : 'delteacher',
				title: '删除用户',
				easy:true,
				width:420,
				padding:5,
				button:button,
				content:$('#delteacher')[0]
			}),'common').exec('show');
			
		}else{
			H.get('delteacher').exec('show');
		}
	}
	function deluserpower(tid) {
		$.ajax({
			type:'post',
			url:'/aroomv2/userpermision/delpower.html',
			dataType:'text',
			data:{'tid':tid},
			success:function(res){
				if(res != undefined && res == 1){
					 $.showmessage({
							img : 'success',
							message:'用户删除成功',
							title:'删除用户',
							callback :function(){
								 document.location.reload();
							}
						});
				}else{
					$.showmessage({
							img : 'error',
							message:'删除失败，请稍后再试或联系客服。',
							title:'删除用户'
						});
				}
			},
			error:function(){
				alert("服务器连接错误，请重试");
			}
		});
	}

</script>
<?php $this->display('aroomv2/page_footer')?>