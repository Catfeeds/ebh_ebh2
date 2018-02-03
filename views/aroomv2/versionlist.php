<?php $this->display('aroomv2/page_header');?>

<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xform.js?v=1"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen">
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
.as1 {
    position: absolute;
    left: 132px;
    top: 15px;
}
.as {
    position: absolute;
    top: 2px;
	left:132px;
}
</style>
<body>
<div >
    <div class="ter_tit">
        当前位置 &gt; <a href="<?=geturl('aroomv2/course')?>">课程管理</a> &gt; <a href="<?=geturl('aroomv2/course/courses')?>">本校课程</a> &gt; <a href="<?=geturl('aroomv2/chapter')?>">知识点管理</a> &gt; 版本管理
    </div>
    <div class="kechengguanli">

		<div class="jiaoshiguanli_top fr">
        	<ul>
            	<li class="fl "><a onclick="addversion();" href="javascript:;">添加版本</a></li>
            </ul>
        </div>
        <div class=" clear"></div>
        <div class="kechengguanli_bottom">
        	<table cellpadding="0" cellspacing="0" class="tables">
            	<tr class="first">
                	<td width="612">版本名称</td>
                    <td width="150">操作</td>
                </tr>
			<?php if (!empty($versionlist)) {
				foreach($versionlist as $version){
				?>
                <tr>
                	<td class="subject">
                    	<p class="fl" style="width:614px;line-height:23px;"><span class="span2"><?=$version['chaptername']?></span></p>
                    </td>
                    <td style="position: relative;">
                        <a href="javascript:editversion(<?=$version['chapterid']?>,'<?=$version['chaptername']?>');">编辑</a>
                        <a href="javascript:delversion(<?=$version['chapterid']?>);">删除</a>
                        <a class="as" href="javascript:void(0)" title="上移" onclick="movechapter(<?=$version['chapterid']?>,1)"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/cwarr_up.png" /></a>
                        <a class="as1" href="javascript:void(0)" title="下移" onclick="movechapter(<?=$version['chapterid']?>,0)"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/cwarr_down.png" /></a>
                    </td>
                </tr>
            	<?php
            	}
            } else { ?>
				<tr>
			 		<td colspan="2" align="center" style="border-top:none;">暂无版本</td>
			 	</tr>
			<?php } ?>
            </table>
        </div>
    </div>

</div>

<!--添加编辑版本-->
<div id="dialogadd" class="editstudents" style="display:none;">
	<div class="  mt10 height ">
		<span>版本名称：</span>
		<input name="vname" id="vname" class="text input" type="text"  value="" x_hit="请输入版本名称"/>
		<input type="hidden" name="vid" id="vid" value="0" />
		<p id="vname_msg" style="width:inherit;margin-left:75px; font-size:12px;width:280px;"></p>
	 </div>
</div>



<!--删除版本-->
<div id="dialogdel" style="display:none">
	<div style="height:70px;" class="deletecourse">
		<div class="tishi mt40"><p style="padding-left: 90px; font-size: 16px; line-height: 35px;">确定要删除该版本吗?</p></div>
	</div>
</div>
<script>
function addversion() {
		$("#vname").val("");
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
				add_version();
				return false;
			},
			autofocus:true
		});

		button.add({
			value:"取消",
			callback:function(){
				H.get('dialogadd').exec('close');
				return true;
			}
		});

		if(!H.get('dialogadd')){
			H.create(new P({
				id : 'dialogadd',
				title: '添加版本',
				easy:true,
				width:420,
				padding:5,
				button:button,
				content:$('#dialogadd')[0]
			},{
				onclose:function(){
					location.reload();
				}
			}),'common').exec('show');

		}else{
			H.get('dialogadd').exec('show');
		}

}
function editversion(vid, vname) {
	$("#vname").val(vname);
	$("#vid").val(vid);
	var button = new xButton();
	button.add({
		value:"确定",
		callback:function(){
			edit_version();
			return false;
		},
		autofocus:true
	});

	button.add({
		value:"取消",
		callback:function(){
			H.get('dialogadd').exec('close');
			return false;
		}
	});



	if(!H.get('dialogadd')){
		H.create(new P({
			id : 'dialogadd',
			title: '编辑版本',
			easy:true,
			width:420,
			padding:5,
			button:button,
			content:$('#dialogadd')[0]
		},{
			onclose:function(){
				location.reload();
			}
		}),'common').exec('show');

	}else{
		H.get('dialogadd').exec('show');
	}
}
function delversion(vid) {
	$("#vid").val(vid);
	var button = new xButton();
	button.add({
		value:"确定",
		callback:function(){
			savedel(vid);
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
			title: '删除版本',
			easy:true,
			width:400,
			padding:5,
			content:$('#dialogdel')[0],
			button:button
		}),'common');
	}
		
	H.get('dialogdel').exec('show');
}

function movechapter(chapterid,flag){
	if(!H.get('xtips')){
		H.create(new P({
			id:'xtips',
			easy:true,
			padding:10
		}),'common');
	}
	$.ajax({
		url:"/aroomv2/chapter/move.html",
		type:'post',
		data:{'chapterid':chapterid,'flag':flag},
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
function savedel(){
	var vid = $("#vid").val();
	$.ajax({
		type:'post',
		url:'<?=geturl('aroomv2/chapter/delchapter')?>',
		dataType:'json',
		data:{'chapterid':vid},
		success:function(data){
			if(data.status == 1){
				$.showmessage({
					img : 'success',
					message:'删除版本成功',
					title:'删除版本',
					callback :function(){
				  		document.location.reload();
					}
				});
			}else{
				$.showmessage({
					img : 'error',
					message:data.msg,
					title:'删除版本'
				});
			}
		},
		error:function(){
			alert("服务器连接错误，请重试");
		}
	});
}

function add_version(){
	var vname = $("#vname").val();
	if (vname == '请输入版本名称' || vname == '') {
		$.showmessage({
			img : 'error',
			message:'请输入版本名称',
			title:'添加版本'
		});
		return false;
	}
	$.ajax({
		type:'post',
		url:'<?=geturl('aroomv2/chapter/addversion')?>',
		dataType:'json',
		data:{'chaptername':vname},
		success:function(data){
			if(data.code == 1) {
			  $.showmessage({
				img : 'success',
				message:'添加版本成功',
				title:'添加版本',
				callback :function(){
				  document.location.reload();
				}
			  });
			} else if(data['code'] == -2){
				$.showmessage({
					img : 'error',
					message:'添加版本失败，版本名称已存在，请重新输入',
					title:'添加版本'
				});
			} else {
			  $.showmessage({
				img : 'error',
				message:'添加版本失败，请稍后再试',
				title:'添加版本'
			  });
			}
		}
	});
}

function edit_version(){
	var chapterid = $("#vid").val();
	var chaptername = $("#vname").val();
	if (chaptername == '') {
		$.showmessage({
			img : 'error',
			message:'请输入版本名称',
			title:'编辑版本'
		});
		return false;
	}
	$.ajax({
		type:'post',
		url:'<?=geturl('aroomv2/chapter/editversion')?>',
		dataType:'json',
		data:{chapterid:chapterid,chaptername:chaptername},
		success:function(data) {
			if(data['code'] == 1) {
				$.showmessage({
					img : 'success',
					message:'编辑版本成功',
					title:'编辑版本',
					callback :function(){
				  		document.location.reload();
					}
				});
			} else if(data['code'] == -2){
				$.showmessage({
					img : 'error',
					message:'编辑版本失败，版本名称已存在，请重新输入',
					title:'编辑版本'
				});
			} else {
				$.showmessage({
					img : 'error',
					message:'编辑版本失败，请稍后再试或联系管理员',
					title:'编辑版本'
				});
			}
		}
	});


}
</script>
</body>
</html>
