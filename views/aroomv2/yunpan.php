<?php $this->display('aroomv2/page_header')?>
<script src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen">
<body>
<div >
	<div class="ter_tit">
        当前位置 > <a href="/aroomv2/more.html">更多应用</a> > 云盘管理
    </div>
    <div class="pingluns mt10">
    	<div class="pingluns_top">
            <div class="clear"></div>
        	<div class="pingluns_top_l fl">
            	<div class="fl">
                    <span style="font-size:14px; color:#333;">时间段：</span>
                    <input id="startdate" class="inp" type="text" readonly="readonly" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'});" value="<?=$startdate?>" />
                    <span style="font-size:14px; color:#333;">到</span>
                    <input id="enddate" class="inp" readonly="readonly " type="text" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'});" value="<?=$enddate?>" />
					<input id="status" type="text" style="display:none" value="<?= $status?>"/ >
                </div>
                <div class="fl ml10" ><a href="javascript:;" onclick="searchbydate()" class="workBtns workBtns-1">确 定</a></div>
            </div>
            <div class="pingluns_top_r fl ml25" style="line-height:32px;">
            	<ul>
                	<li class="fl"><b>审核状态>>&nbsp;&nbsp;</b></li>
                    <li class="fl" id="noq"><a href="/aroomv2/yunpan.html?sdate=<?= $startdate?>&edate=<?=$enddate?>&status=0" class="<?= empty($status)? 'select':''?>" >不限</a></li>
                    <li class="fl" id="noq1"><a href="/aroomv2/yunpan.html?sdate=<?= $startdate?>&edate=<?=$enddate?>&status=1" class="<?= ($status=='1')? 'select':''?>" >未审核</a></li>
                    <li class="fl" id="noq2"><a href="/aroomv2/yunpan.html?sdate=<?= $startdate?>&edate=<?=$enddate?>&status=2" class="<?= ($status=='2')? 'select':''?>" >已通过</a></li>
                    <li class="fl" id="noq3"><a href="/aroomv2/yunpan.html?sdate=<?= $startdate?>&edate=<?=$enddate?>&status=3" class="<?= ($status=='3')? 'select':''?>" >未通过</a></li>
                </ul>
            </div>
        </div>
        <div class="clear"></div>
        <div class="kechengguanli_bottom mt5">
            <table cellpadding="0" cellspacing="0" class="tables">
                <tr class="first">
                    <td width="212">文件名称</td>
                    <td width="74">文件大小</td>
                    <td width="110">上传人</td>
                    <td width="100">上传时间</td>
                    <td width="70">审核状态</td>
                    <td width="150">操作</td>
                </tr>
				<?php if(!empty($filelist)){
					foreach($filelist as $file){
				?>
                <tr>
                    <td><p style="width:212px;word-wrap: break-word;float:left;"><b><?=$file['title']?></b></p></td>
                    <td><?=$file['size']?></td>
                    <td><?=$file['realname']?>(<?=$file['username']?>)</td>
                    <td><?=Date('Y-m-d H:i:s',$file['dateline'])?></td>
                    <td><?php if($file['teach_status']==1){echo '已通过';}elseif($file['teach_status']==2){ echo '未通过';}else{echo '未审核';}?></td>
					<td>
					<?php if($file['ispreview']){?>
					<a target="_blank" href="<?='http://uppan.ebh.net/kfpreview.html?id='.$file['fileid'].'&k='.$file['k'];?>" title="文件预览">预览</a>
				    <?php } else {?>
				    <a  target="_blank" href="<?='http://uppan.ebh.net/kfatt.html?id='.$file['fileid'].'&k='.$file['k'];?>" title="文件下载">下载</a>
				    <?php }?>
					<a href="javascript:showdetail(<?=$file['fileid']?>);" title="文件详情">详情</a>
					
					<a href="javascript:checkfile(<?=$file['fileid']?>,<?=$file['teach_status']?>,'<?=$file['teach_remark']?>');">审核</a>
                </tr>
				<?php }} else {?>
				<tr>
					<td colspan="6" align="center" style="border-top:none;">暂无文件</td>
				</tr>
				<?php }?>
            </table>
		</div>
    <?=$pagestr?>
	</div>
</div>


<!--详情-->
<div id="dialogdetail" style="display:none;">
	<div class="mt10 ml50">
		<span>文件名称：</span>
		<label id="file_title"></label>
	 </div>
	<div class="mt10 ml50">
		<span>上传账号：</span>
		<label id="file_username"></label>
	 </div>
	<div class="mt10 ml50">
		<span>上传人：&nbsp;&nbsp;</span>
		<label id="file_realname"></label>
	 </div>
	<div class="mt10 ml50">
		<span>文件大小：</span>
		<label id="file_size"></label>
	 </div>
	<div class="mt10 ml50">
		<span>文件类型：</span>
		<label id="file_suffix"></label>
	 </div>
	<div class="mt10 ml50">
		<span>上传时间：</span>
		<label id="file_dateline"></label>
	 </div>
	<div class="mt10 ml50">
		<span>审核状态：</span>
		<label id="file_teach_status"></label>
	 </div>
	<div class="mt10 ml50">
		<span>审核备注：</span>
		<label id="file_teach_remark"></label>
	 </div>
	<div class="mt10 ml50">
		<span>管理员IP：</span>
		<label id="file_teach_ip"></label>
	 </div>
	<div class="mt10 ml50">
		<span>审核处理时间：</span>
		<label id="file_teach_dateline"></label>
	 </div>
</div>

<!--审核-->
<div id="dialogcheck" style="display:none;">
	<div class="mt15 ml50">
		<span>审核结果：</span>
		<label><input type="radio" checked="checked" value="1" name="teach_status"> 通 过</label><label style="margin-left:20px"><input type="radio" value="2" name="teach_status"> 未通过</label>
		<input type="hidden" id="curfileid" value="0" />
	 </div>
	 <div class="mt15 ml50" >
		<span class="span3">审核备注：</span>
		<textarea class="text1" name="remark" id="remark" ></textarea>
	 </div>
</div>

<script type="text/javascript">
function searchbydate(){
	var sdate = $('#startdate').val();
	var edate = $('#enddate').val();
	var status = $('#status').val();
	if(status=='')
		var href='/aroomv2/yunpan.html?sdate='+sdate+'&edate='+edate;
	else
		var href='/aroomv2/yunpan.html?sdate='+sdate+'&edate='+edate+'&status='+status;
	location.href = href;
}

function showdetail(fileid) {
	$("#file_title").html('');
	$("#file_username").html('');
	$("#file_realname").html('');
	$("#file_size").html('');
	$("#file_suffix").html('');
	$("#file_dateline").html('');
	$("#file_teach_status").html('');
	$("#file_teach_remark").html('');
	$("#file_teach_ip").html('');
	$("#file_teach_dateline").html('');
	$.ajax({
		type: 'POST',
		url: "<?=geturl('aroomv2/yunpan/getfile')?>",
		dataType:'json',
		data:{fileid:fileid},
		success:function(data){
			if(data != undefined && data.code == 1){
				$("#file_title").html(data.file['title']);
				$("#file_username").html(data.file['username']);
				$("#file_realname").html(data.file['realname']);
				$("#file_size").html(data.file['size']);
				$("#file_suffix").html(data.file['suffix']);
				$("#file_dateline").html(data.file['dateline']);
				$("#file_teach_status").html(data.file['teach_status']);
				$("#file_teach_remark").html(data.file['teach_remark']);
				$("#file_teach_ip").html(data.file['teach_ip']);
				$("#file_teach_dateline").html(data.file['teach_dateline']);
			}
		},
		error:function(){
			alert("服务器连接错误，请重试");
		}
	});

	var button = new xButton();
	button.add({
		value:"关闭",
		callback:function(){
			H.get('dialogdetail').exec('close');
			return false;
		},
		autofocus:true
	});

	if(!H.get('dialogdetail')){
		H.create(new P({
			id: 'dialogdetail',
			title: '审核详情',
			easy:true,
			width:400,
			padding:5,
			content:$("#dialogdetail")[0],
			button:button
		}),'common');
	}
	H.get('dialogdetail').exec('show');
}

function checkfile(fileid,teach_status,remark) {
	$("#curfileid").val(fileid);
	if (teach_status != undefined && teach_status !=null && teach_status == 2)
		$("input[name='teach_status']").eq(1).attr('checked', true);
	else
		$("input[name='teach_status']").eq(0).attr('checked', true);
	if (remark == undefined || remark == null)
		remark = '';
	$("#remark").val(remark);

	var button = new xButton();
	button.add({
		value:"确定",
		callback:function(){
			savecheck();
			return false;
		},
		autofocus:true
	});

	button.add({
		value:"取消",
		callback:function(){
			H.get('dialogcheck').exec('close');
			return false;
		}
	});

	if(!H.get('dialogcheck')){
		H.create(new P({
			id: 'dialogcheck',
			title: '审核文件',
			easy:true,
			width:400,
			padding:5,
			content:$("#dialogcheck")[0],
			button:button
		}),'common');
	}
	H.get('dialogcheck').exec('show');
}

function savecheck(){
	var toid = $("#curfileid").val();
	var teach_status = $("input[name='teach_status']:checked").val();
	var remark = $("#remark").val();

	$.ajax({
		type:'post',
		url:'<?=geturl('aroomv2/yunpan/checkprocess')?>',
		dataType:'json',
		data:{toid:toid,teach_status:teach_status,teach_remark:remark},
		success:function(data){
			if(data!=undefined && data.code == 1){
	            $.showmessage({
	                img : 'success',
	                message:'审核成功',
	                title:'云盘审核',
	                callback: function(){
	                	window.location.reload();
	                }
	            });
			}else{
	            $.showmessage({
	                img : 'error',
	                message:'审核失败',
	                title:'云盘审核'
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

