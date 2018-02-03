<?php $this->display('aroomv2/page_header')?>
<body>
<div>
<div class="ter_tit">
<?php 
$rurl = $this->input->get('rurl');
?>
	<?php
	if($rurl == 'aroomv2/teacher/teacherlist'){?>
		当前位置 > <a href="<?=geturl('aroomv2/report')?>">统计分析</a> > <a href="<?=geturl('aroomv2/teacher/viewnav')?>"> 教师查看 </a> > <a href="<?=geturl('aroomv2/teacher/teacherlist')?>"> 教师列表 </a> > 评论查看
	<?php }else{?>
		当前位置 > <a href="<?=geturl('aroomv2/report')?>">统计分析</a> > <a href="<?=geturl('aroomv2/report/teacher')?>"> 教师统计 </a> > 评论查看
	<?php }?>
	</div>

<div class="reviewview">
	<table cellpadding="0" cellspacing="0" class="tables">
		<tr  class="second">
        	<td  colspan="5">
            	<div>
                	<div class="teacher fl"><b style="font-size:16px;">教师:</b></div>					
                    <div class="xingming_p fl" style="font-size:16px;"><?=$tuser[0]['realname']?>　(<?=empty($tuser[0]['sex'])?'男':'女'?>)　<?=$tuser[0]['username']?></div>
                </div>
            </td>
        </tr>
        <tr class="first">
            <td width="179">评论人</td>
            <td width="174">评论对象</td>
            <td width="192">评论内容</td>
            <td width="125">评论时间</td>
            <td width="56">操作</td>
        </tr>
		<?php 
		foreach($reviewlist as $review){
			$face = getthumb($review['face'],'50_50');
			if(empty($face))
				$face = 'http://static.ebanhui.com/ebh/tpl/default/images/'.(empty($review['sex'])?'m_man_50_50.jpg':'m_woman_50_50.jpg');
			?>
        <tr>
            <td width="179"><div class="fl"><img src="<?=$face?>" style="height:50px; width:50px;"/></div><p class="p2s"><b><?=$review['realname']?>(<?=empty($review['sex'])?'男':'女'?>)</b><br /><?=$review['username']?></p></td>
            <td width="174"><p style="width:160px;word-wrap: break-word;float:left;"><?=$review['title']?></p></td>
            <td width="192"><p style="width:190px;word-wrap: break-word;float:left;"><?=empty($review['shield'])?$review['subject']:'<span>(该评论已被系统屏蔽)</span>'?></p></td>
            <td width="125"><?=Date('Y-m-d H:i:s',$review['dateline'])?></td>
            <td width="56">
			<?php if(empty($review['shield'])){?>
			<a href="javascript:void(0)" onclick="shielddiv(<?= $review['cwid']?>,<?= $review['logid']?>)">屏蔽</a>
			<?php }else{?>
			<a href="javascript:void(0)" onclick="canceldiv(<?= $review['cwid']?>,<?= $review['logid']?>)">取消</a>
			<?php }?></td>
        </tr>
		<?php }?>
    </table>
    <div class="button2 fr"><a href="/<?=$rurl?>.html">返 回</a></div>
    <?=$pagestr?>
</div>
<!--屏蔽评论-->
<div id="delreview" class="tanchukuang" style="display:none;height:135px;" >
    <div class="tishi"><span>你确定要屏蔽该评论吗？</span></div>
</div>
<!--取消评论-->
<div id="cancelshielddiv" class="tanchukuang" style="display:none;height:135px;">
    <div class="tishi"><span>你确定要取消该屏蔽的评论吗？</span></div>
</div>
</body>
<script>
//屏蔽评论
function shielddiv(cwid,logid){
		var button = new xButton();
		button.add({
			value:"确定",
			callback:function(){
				shield(cwid,logid);
				H.get('delreview').exec('close');
				return false;
			},
			autofocus:true
		});

		button.add({
			value:"取消",
			callback:function(){
				// location.reload();
				H.get('delreview').exec('close');
				return false;
			}
		});

		if(!H.get('delreview')){
			H.create(new P({
				id : 'delreview',
				title: '屏蔽评论',
				easy:true,
				width:420,
				padding:5,
				button:button,
				content:$('#delreview')[0]
			}),'common').exec('show');
			
		}else{
			H.get('delreview').exec('show');
		}
			
	}
	function shield(cwid,logid){
	
		$.ajax({

			type:'post',
			url:'<?= geturl('aroomv2/information/shield')?>',
			dataType:'json',
			data:{'cwid':cwid,'logid':logid},
			success:function(data){
				if(data != undefined && data.status != undefined && data.status == 1) {
					alert("屏蔽评论成功");
					location.reload(true);
				}else{
					alert("屏蔽评论失败");
				}
			},
			error:function(){
				alert("屏蔽评论失败，请稍后再试或联系管理员。");
			}
		});	
	}
//取消屏蔽评论
function canceldiv(cwid,logid){
		var button = new xButton();
		button.add({
			value:"确定",
			callback:function(){
				cancel(cwid,logid);
				H.get('cancelshielddiv').exec('close');
				return false;
			},
			autofocus:true
		});

		button.add({
			value:"取消",
			callback:function(){
				// location.reload();
				H.get('cancelshielddiv').exec('close');
				return false;
			}
		});

		if(!H.get('cancelshield')){
			H.create(new P({
				id : 'cancelshielddiv',
				title: '屏蔽评论',
				easy:true,
				width:420,
				padding:5,
				button:button,
				content:$('#cancelshielddiv')[0]
			}),'common').exec('show');
			
		}else{
			H.get('cancelshielddiv').exec('show');
		}
			
	}
	function cancel(cwid,logid){
	
		$.ajax({

			type:'post',
			url:'<?= geturl('aroomv2/information/cancleshield')?>',
			dataType:'json',
			data:{'cwid':cwid,'logid':logid},
			success:function(data){
				if(data != undefined && data.status != undefined && data.status == 1) {
					alert("取消屏蔽成功");
					location.reload(true);
				}else{
					alert("取消屏蔽失败");
				}
			},
			error:function(){
				alert("取消屏蔽失败，请稍后再试或联系管理员。");
			}
		});	
	}
</script>
</html>
