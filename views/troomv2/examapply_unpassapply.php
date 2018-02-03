<?php $this->display('troomv2/page_header'); ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2014/css/authement.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<style type="text/css">
.datatab{border:none;}
.datatab td{border:none;}
.dialogcont{
    height: 100px;
    margin: 0 auto;
    text-align: center;
    width: 339px;
}
.dialogcont .tishi{
    background: url("http://static.ebanhui.com/ebh/tpl/aroomv2/images/ico.jpg") no-repeat scroll 40px center;
    height: 36px;
    margin-left: 0;
    text-align: left;
    width: 339px;
    color: #333;
    font-weight: normal;
    padding:0;
}
.dialogcont .tishi p {
    padding-left: 90px; font-size: 16px; line-height: 35px;
}
</style>
<div class="ter_tit">
	当前位置 &gt; <a href="<?=geturl('troomv2/examapply')?>">认证管理</a> &gt; 未通过
        <div class="diles fr">
            <input type="text" value="<?=empty($q)?'请输入学生姓名或登录帐号':$q?>" id="searchkey" class="newsou" name="title" style="color:#999; background:#fff;" onfocus="if($(this).val()=='请输入学生姓名或登录帐号')$(this).val('');$(this).css('color','#333')" onblur="if($.trim($(this).val())==''){$(this).val('请输入学生姓名或登录帐号');$(this).css('color','#999')}">
            <input type="button" value="" onclick="_search()" class="soulico" id="searchbutton">
        </div>
</div>
<div class="lefrig" style="min-height:1000px;">
    <div class="workol">
        <div class="work_mes">
            <ul class="extendul">
                <li><a href="<?=geturl('troomv2/examapply/applylist')?>"><span>待审核</span></a></li>
                <li><a href="<?=geturl('troomv2/examapply/passapply')?>"><span>已通过</span></a></li>
                <li class="workcurrent"><a href="<?=geturl('troomv2/examapply/unpassapply')?>"><span>未通过</span></a></li>
            </ul>
        </div>
        <div class="clear"></div>
		<div style="float:left;margin-top:0px;" class="workdata">
			<table class="datatab" cellpadding="0" cellspacing="0">
            	<tr class="first">
                    <td width="162"><span style="padding-left:20px;">账号</span></td>
                	<td width="168">姓名</td>
                    <td width="149">申请时间</td>
                    <td width="149">审核时间</td>
                    <td width="97">操作</td>
                </tr>
<?php foreach($applylist as $apply){?>
                <tr >
                	<td>
                    	<label>
                            <input type="checkbox" value="<?=$apply['applyid']?>" name="sel" style="position: relative;top: 3px; margin-right:5px;"><?=$apply['username']?>
						</label>
                    </td>
                    <td><?=$apply['realname']?></td>
                    <td><?=date("Y-m-d", $apply['applydate'])?></td>
                    <td><?=date("Y-m-d", $apply['verifydate'])?></td>
                    <td><a href="javascript:;" onclick="applydetail(<?=$apply['applyid']?>)" class="annius">认证通过</a></td>
                </tr>
<?php }?>
			</table>
		</div>
        <div class="clear"></div>
        <div class="bottoms">
            <div class="fl">
            	<label>
					<input type="checkbox" id="selall" style="position: relative;top: 3px; margin-right:5px; margin-left:6px;">全选 
				</label>
			</div>
            <div class="fl ml20"><a id="dopass" href="javascript:;" class="result">批量通过</a></div>
        </div>
        <div class="clear"></div>
<?=$pagestr?>
	</div>
</div>

<div id="dialogdetail" style="display:none;">
    <div class="grxx">
        <h3>个人信息</h3>
        <div class="nrdetail">
        	<input type="hidden" id="current_applyid" value="0" />
            <div><span class="span1s" style="position:relative;top:-45px;">证件照：&nbsp;&nbsp;&nbsp;&nbsp;</span><img id="photo" src=""  width="92" /></div>
            <div><span class="span1s">姓&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名：</span><span id="realname" class="span2s"></span></div>
            <div><span class="span1s">姓名全拼：</span><span id="namespell" class="span2s"></span></div>
            <div><span class="span1s">性&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;别：</span><span id="sex" class="span2s"></span></div>
            <div><span class="span1s">出生年月：</span><span id="birthdate" class="span2s"></span></div>
            <div><span class="span1s">身份证号：</span><span id="idcard" class="span2s"></span></div>
            <div><span class="span1s">手机号：&nbsp;&nbsp;&nbsp;&nbsp;</span><span id="mobile" class="span2s"></span></div>
            <div><span class="span1s">电子邮箱：</span><span id="email" class="span2s"></span></div>
            <div><span class="span1s">收件地址：</span><span id="address" class="span2s"></span></div>
            <div><span class="span1s">邮政编码：</span><span id="zipcode" class="span2s"></span></div>
            <div><span class="span1s">学校名称：</span><span id="schoolname" class="span2s"></span></div>
            <div><span class="span1s">所属专业：</span><span id="major" class="span2s"></span></div>
            <div><span class="span1s">学生证号：</span><span id="stuid" class="span2s"></span></div>
            <div><span class="span1s">审&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;核：</span><span id="stuid" class="span2s"><label><input type="radio" checked="checked" value="1" name="status"> 通 过</label><label style="margin-left:20px"><input type="radio" value="2" name="status"> 未通过</label></span></div>
            <div><span class="span1s">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span id="stuid" class="span2s"><textarea class="resultson" id="verifymessage"  style="line-height:27px; color:#626262; font-size:14px; padding:0 5px;" name="verifymessage"></textarea></span></div>
        </div>
    </div>
</div>

<div id="dialogdopass" style="display:none">
	<div class="dialogcont">
		<div class="tishi mt40"><p>确定全部审核通过?</p></div>
	</div>
</div>

<div id="dialogdonopass" style="display:none">
	<div class="dialogcont">
		<div class="tishi mt40"><p>确定全部审核不通过?</p></div>
	</div>
</div>

<script>
function _search(){
	var searchkey = $('#searchkey').val();
	if(searchkey == '请输入学生姓名或登录帐号')
		searchkey = '';
	location.href = '<?=geturl('troomv2/examapply/unpassapply')?>?q='+searchkey;
}
function applydetail(applyid){
	$("#current_applyid").val(applyid);
	$("#photo").attr("src",'');
	$("#realname").html('');
	$("#namespell").html('');
	$("#sex").html('');
	$("#birthdate").html('');
	$("#idcard").html('');
	$("#mobile").html('');
	$("#email").html('');
	$("#address").html('');
	$("#zipcode").html('');
	$("#schoolname").html('');
	$("#major").html('');
	$("#stuid").html('');
	$.ajax({
		type: 'post',
		url: '<?=geturl('troomv2/examapply/applydetail')?>',
		dataType: 'json',
		data: {applyid:applyid},
		success: function(data){
			if(data!=undefined && data!=null && data.code==1){
				var sex = data.apply['namespell'] == 1 ? '女' : '男';
				var schoolname = data.apply['schoolname'] == '' ? '无' : data.apply['schoolname'];
				var major = data.apply['major'] == '' ? '无' : data.apply['major'];
				var stuid = data.apply['stuid'] == '' ? '无' : data.apply['stuid'];
				$("#photo").attr("src", data.apply['photo']);
				$("#realname").html(data.apply['realname']);
				$("#namespell").html(data.apply['namespell']);
				$("#sex").html(sex);
				$("#birthdate").html(data.apply['birthyear']+'-'+data.apply['birthmonth']);
				$("#idcard").html(data.apply['idcard']);
				$("#mobile").html(data.apply['mobile']);
				$("#email").html(data.apply['email']);
				$("#address").html(data.apply['provincename']+' '+data.apply['cityname']+' '+data.apply['address']);
				$("#zipcode").html(data.apply['zipcode']);
				$("#schoolname").html(schoolname);
				$("#major").html(major);
				$("#stuid").html(stuid);
				if (data.apply['status'] == 2){
					$("input[name='status']").eq(1).attr("checked",true);
					$("#verifymessage").show();
				} else {
					$("input[name='status']").eq(0).attr("checked",true);
					$("#verifymessage").hide();
				}
				$("#verifymessage").val(data.apply['verifymessage']);
			}
		},
		error:function(){
			alert("服务器连接错误，请重试");
		}
	});

	var button = new xButton();
	button.add({
		value:"确定并下一个",
		callback:function(){
			savecheck();
			return false;
		},
		autofocus:true
	});

	button.add({
		value:"取消",
		callback:function(){
			H.get('dialogdetail').exec('close');
			return false;
		}
	});
	if(!H.get('dialogdetail')){
		H.create(new P({
			id : 'dialogdetail',
			title: '查看详情',
			easy:true,
			width:455,
			padding:5,
			content:$('#dialogdetail')[0],
			button:button
		},{
			onclose:function(){
				location.reload(true);
			}
		}),'common');
	}

	H.get('dialogdetail').exec('show');
}

function savecheck(){
	var applyid = $("#current_applyid").val();
	var status = $("input[name='status']:checked").val();
	var verifymessage = $("#verifymessage").val();
	var nexttype = 2;//下一个待审核
	$.ajax({
		type: 'post',
		url: '<?=geturl('troomv2/examapply/check')?>',
		dataType: 'json',
		data: {applyid:applyid,status:status,verifymessage:verifymessage,nexttype:nexttype},
		success: function(data){
			if(data!=undefined && data!=null && data.code==1){
				$.showmessage({
					img : 'success',
					message:'审核成功',
					title:'消息通知',
					callback:function(){
						if(data.nextapply != undefined & data.nextapply != false){
							var sex = data.nextapply['namespell'] == 1 ? '女' : '男';
							var schoolname = data.nextapply['schoolname'] == '' ? '无' : data.nextapply['schoolname'];
							var major = data.nextapply['major'] == '' ? '无' : data.nextapply['major'];
							var stuid = data.nextapply['stuid'] == '' ? '无' : data.nextapply['stuid'];
							$("#current_applyid").val(data.nextapply['applyid']);
							$("#photo").attr("src", data.nextapply['photo']);
							$("#realname").html(data.nextapply['realname']);
							$("#namespell").html(data.nextapply['namespell']);
							$("#sex").html(sex);
							$("#birthdate").html(data.nextapply['birthyear']+'-'+data.nextapply['birthmonth']);
							$("#idcard").html(data.nextapply['idcard']);
							$("#mobile").html(data.nextapply['mobile']);
							$("#email").html(data.nextapply['email']);
							$("#address").html(data.nextapply['provincename']+' '+data.nextapply['cityname']+' '+data.nextapply['address']);
							$("#zipcode").html(data.nextapply['zipcode']);
							$("#schoolname").html(schoolname);
							$("#major").html(major);
							$("#stuid").html(stuid);
							if (data.nextapply['status'] == 2){
								$("input[name='status']").eq(1).attr("checked",true);
								$("#verifymessage").show();
							} else {
								$("input[name='status']").eq(0).attr("checked",true);
								$("#verifymessage").hide();
							}
							$("#verifymessage").val(data.nextapply['verifymessage']);
						} else {
							alert('已经是最后一个申请了。');
							window.location.reload();
						}
					}
				});
			} else {
				$.showmessage({
					img : 'error',
					message:'审核失败',
					title:'消息通知'
				});
			}
		},
		error:function(){
			alert("服务器连接错误，请重试");
		}
	});
}



$(function(){
	//批量选择
	$("#selall").click(function(){
		$("input[name='sel']").attr("checked", this.checked);
	});
	//批量审核通过
	$("#dopass").click(function(){
		var button = new xButton();
		button.add({
			value:"确定",
			callback:function(){
				var idarr = new Array();
				$("input[name='sel']").each(function(){
					if($(this).prop("checked")==true){
						idarr.push($(this).val());
					}
				});
				if(idarr.length==0){
					alert("请选择要审核的申请");
					return false;
				}
				$.post('/troomv2/examapply/batchcheck.html',{ids:idarr.join(","),status:1},function(data){
					if(data != undefined && data != null && data.code ==1){//审核成功
						$.showmessage({
							img : 'success',
							message:data.msg,
							title:'消息通知',
							callback:function(){
								H.get('dialogdopass').exec('close');
								window.location.reload();
							}
						});
					} else {
						$.showmessage({
							img : 'error',
							message:data.msg,
							title:'消息通知'
						});
					}
				},'json');
				return false;
			},
			autofocus:true
		});

		button.add({
			value:"取消",
			callback:function(){
				H.get('dialogdopass').exec('close');
				return false;
			}
		});
		if(!H.get('dialogdopass')){
			H.create(new P({
				id : 'dialogdopass',
				title: '审核通过',
				easy:true,
				width:455,
				padding:5,
				content:$('#dialogdopass')[0],
				button:button
			}),'common');
		}
		H.get('dialogdopass').exec('show');
	});

	$("input[name='status']").click(function(){
		if ($(this).val()== 2){
			$("#verifymessage").show();
		} else {
			$("#verifymessage").hide();
		}
	});

});
</script>


<?php $this->display('troomv2/page_footer'); ?>