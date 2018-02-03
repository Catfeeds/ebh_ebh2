<?php $this->display('aroomv2/page_header')?>
<body>
<div class="ter_tit">
		当前位置 > <a href="<?=geturl('aroomv2/course')?>">课程管理</a> > 课件审核
	</div>
<div class="coursewareview">

	<div>
        <div class="fl">
            	<div class="fl">
                    <span style="font-size:14px; color:#333;">审核状态：</span>
                    <select name="checkstatus" id="checkstatus" class="inp" style="height:32px;">
                    	<option value="0" <?=empty($checkstatus)?'selected="selected"':''?>>不限</option>
                    	<option value="1" <?=$checkstatus==1?'selected="selected"':''?>>未审核</option>
                    	<option value="2" <?=$checkstatus==2?'selected="selected"':''?>>审核已通过</option>
                    	<option value="3" <?=$checkstatus==3?'selected="selected"':''?>>审核未通过</option>
                    </select>
                    <span style="font-size:14px; color:#333;">所属课程：</span>
                    <select name="folderid" id="folderid" class="inp" style="height:32px;width:200px;">
                    	<option value="0" <?=empty($folderid)?'selected="selected"':''?>>不限</option>
                    <?php foreach($folderlist as $folder){?>
                    	<option value="<?=$folder['folderid']?>" <?=$folderid==$folder['folderid']?'selected="selected"':''?>><?=$folder['foldername']?></option>
                    <?php }?>
                    </select>
                </div>
                <div style="margin-top:1px;" class=" fl ml10"><a class="workBtns" onclick="_search()" href="javascript:void(0)">确 定</a></div>
				<div style="margin-top:1px;" class=" fl ml10"><a class="workBtns" onclick="clearsearch()" href="javascript:void(0)">清 空</a></div>
            </div>
    </div>
    <div style="clear: both;height:10px;line-height:10px;visibility:hidden;"></div>
    <table cellpadding="0" cellspacing="0" class="tables" >
        <tr   class="first">
            <td width="282" >课件名称</td>
            <td width="149">所属课程</td>
            <td width="124">发布时间</td>
            <td width="77">状态</td>
            <td width="94">操作</td>
        </tr>
	<?php
	if(!empty($coursewarelist)){
		foreach($coursewarelist as $cw){
			$face = getthumb($cw['face'],'50_50');
			if(empty($face))
				$face = 'http://static.ebanhui.com/ebh/tpl/default/images/'.(empty($cw['sex'])?'t_man_50_50.jpg':'t_woman_50_50.jpg');
			$arr = explode('.',$cw['cwurl']);
			$type = $arr[count($arr)-1];
			$target = '';
			$coursetype = 'classcourse';
			if(empty($cw['cwurl']) || in_array($type,array('flv','mp4','avi','mp3','mpeg','mpg','rmvb','rm','mov'))){
				$target = '_blank';
				$coursetype = 'course';
			}
			?>
        <tr>
			<td width="282">
				<div>
					<img src="<?=$face?>" style="height:50px; width:50px; float:left;display:inline;">
					<div>
						<p style="float:left;display:inline;padding-left:5px; width:225px;word-wrap: break-word;font-size:14px;height:35px; overflow:hidden;"><a style="text-decoration:none;" target="_blank" href="<?=geturl('aroomv2/courseware/view-1-0-0-'.$cw['cwid'])?>"><b><?=$cw['title']?></b></a></p>
						<p style="float:left;display:inline;padding-left:5px; width:225px;word-wrap: break-word;font-size:14px;height:23px; overflow:hidden; font-size:12px; color:#808080;"><?=$cw['realname']?>(<?=$cw['username']?>)</p>
					</div>
				</div>
			</td>
			<td width="149"><a href="<?=geturl('aroomv2/courseware')?>?folderid=<?=$cw['folderid']?>"><?=$cw['foldername']?></a></td>
			<td width="124"><?=Date('Y-m-d H:i:s',$cw['dateline'])?></td>
			<td width="77">
			<?php if ($cw['teach_status'] == 2)
				echo '<span style="color:red;cursor:pointer;" class="opremark" ckstatus="未通过" ckdate="' . date("Y-m-d H:i:s",$cw['teach_dateline']) . '" ckremark="' . $cw['teach_remark'] . '">审核未通过</span>';
			elseif ($cw['teach_status'] == 1)
				echo '<span style="cursor:pointer;" class="opremark" ckstatus="已通过" ckdate="' . date("Y-m-d H:i:s",$cw['teach_dateline']) . '" ckremark="' . $cw['teach_remark'] . '">审核已通过</span>';
			else
				echo '<span style="color:blue">未审核</span>';
			?>
			</td>
			<td width="94">
				<a target="_blank" href="<?=geturl('aroomv2/courseware/view-1-0-0-'.$cw['cwid'])?>">查看</a>&nbsp;&nbsp;
			<?php if (empty($cw['teach_status'])){?>
				<a href="javascript:;" class="opcwcheck" toid="<?=$cw['cwid']?>">审核</a>
			<?php } ?>
			</td>
		</tr>
        <?php }
	}else{
		?>
		<tr><td colspan="5" style='text-align:center'>暂无课件</td></tr>
    <?php }?>
    </table>
    <?=$pagestr?>
</div>

<!--课件审核-->
<div id="dialogcheck" style="display:none;height:160px;">
	<div style="height:160px;width:350px;padding-left:50px;">
	    <div class="mt15">
	    	<span>审核状态：</span>
				<label><input type="radio" checked="checked" value="1" name="teach_status"> 通 过</label>
				<label style="margin-left:20px"><input type="radio" value="2" name="teach_status"> 未通过</label>
				<input id="toid" name="toid" type="hidden"  value="" />
	    </div>
	    <div class="mt15">
	    	<span style="vertical-align:top;">备注信息：</span>
	        <textarea style="height:100px;width:220px;resize:none;" class="text input" id="remark" name="remark"></textarea>
	    </div>
	</div>
</div>
<!--备注信息-->
<div id="dialogremark" style="display:none;height:160px;">
	<div style="height:160px;width:350px;padding-left:50px;">
	    <div class="mt15">
	    	<span>审核结果：</span>
	    	<span id="teach_status"></span>
	    </div>
	    <div class="mt15">
	    	<span style="vertical-align:top;">审核时间：</span>
	        <span id="teach_dateline"></span>
	    </div>
	    <div class="mt15">
	    	<span style="vertical-align:top;">备注信息：</span>
	        <span id="teach_remark"></span>
	    </div>
	</div>
</div>
<script type="text/javascript">
$(function(){
	$(".opcwcheck").click(function(){
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
				id : 'dialogcheck',
				title: '课件审核',
				easy:true,
				width:400,
				padding:5,
				content:$('#dialogcheck')[0],
				button:button
			}),'common');
		}

		$("#toid").val($(this).attr('toid'));
		$("input:radio[name=teach_status]")[0].checked = true;
		$("#remark").val('');

		H.get('dialogcheck').exec('show');
	});


	$(".opremark").click(function(){
		var button = new xButton();
		button.add({
			value:"关闭",
			callback:function(){
				H.get('dialogremark').exec('close');
				return false;
			},
			autofocus:true
		});
		if(!H.get('dialogremark')){
			H.create(new P({
				id : 'dialogremark',
				title: '审核详情',
				easy:true,
				width:400,
				padding:5,
				content:$('#dialogremark')[0],
				button:button
			}),'common');
		}

		$("#teach_status").html($(this).attr("ckstatus"));
		$("#teach_dateline").html($(this).attr("ckdate"));
		$("#teach_remark").html($(this).attr("ckremark"));
		H.get('dialogremark').exec('show');
	});
});

function savecheck() {
	if(!H.get('xtips')){
		H.create(new P({
			id:'xtips',
			easy:true,
			padding:10
		}),'common');
	}
	var toid = $("#toid").val();
	var teach_status = $("input[name='teach_status']:checked").val();
	var remark = $("#remark").val();

	$.post("<?=geturl('aroomv2/courseware/checkprocess')?>",{toid:toid,teach_status:teach_status,teach_remark:remark,type:1},function(data){
		if(data != null && data != undefined && data.code == 1){
			H.get('xtips').exec('setContent','审核成功').exec('show').exec('close',500);
			setTimeout(function(){
				window.location.reload();
			},500);
		}
		else
		{
			H.get('xtips').exec('setContent','审核失败').exec('show').exec('close',800);
		}
	},'json');

}

function _search(){
	var checkstatus = $('#checkstatus').val();
	var folderid = $('#folderid').val();
	window.location.href = '<?=geturl('aroomv2/courseware')?>?checkstatus='+checkstatus+'&folderid='+folderid;
}

function clearsearch(){
	window.location.href = '<?=geturl('aroomv2/courseware')?>';
}
</script>
</body>
</html>
