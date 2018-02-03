<?php $this->display('troom/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<style>

.datatab td {
	border-top:none;
}
</style>

<div class="ter_tit">
当前位置 > <a href="<?= geturl('troom/classsubject') ?>" ?>课程管理</a> > 评论管理</div>
<div class="lefrig" style="margin-top:15px;">
<table  width="100%" class="datatab" style="margin-bottom:10px;">
  <tbody class="tabcont">

  <?php if(!empty($reviews)) { 
  if($roominfo['isschool'] == 3 || $roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {
	$coursepath = 'classcourse';
  } else if ($roominfo['isschool'] == 2){
	$coursepath = 'classcourse';
  }else {
	$coursepath = 'course';
  }
  ?>
  <?php foreach ($reviews as $review) { ?>
  <tr>


<td>
<?php 
//var_dump($avalue);
	if(!empty($review['face']))
		$face = getthumb($review['face'],'50_50');
	else{
		if($review['sex']==1){
			if($review['groupid']==5){
				$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
			}else{
				$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
			}
		}else{
			if($review['groupid']==5){
				$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
			}else{
				$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
			}
		}
	
		$face = getthumb($defaulturl,'50_50');
	} 
?>	     
<div style="float:left;margin-right:15px;">
<a href="javascript:;">
<img src="<?=$face?>" title="<?= $review['realname'] ?>" style="width:50px;height:50px;">
</a>
</div>
  <div style="float:left;width:610px;">
							<span style="width:220px;float:left;">评论人：<?= $review['username'] ?>(<?= $review['realname'] ?>)</span>
							 <?php $arr = explode('.',$review['cwurl']);
								$type = $arr[count($arr)-1]; 
								if($type != 'flv' && $review['ism3u8'] == 1)
									$type = 'flv';
								if($type == 'mp3')
									$type = 'flv';
							?>
                            <span style="width:200px;float:left;">评论对象：<a target="<?= (empty($review['cwurl']) || $type == 'flv') ? '_blank' : '' ?>" href="<?= (empty($review['cwurl']) || $type == 'flv') ? geturl('troom/course/'.$review['cwid']) : geturl('troom/'.$coursepath.'/'.$review['cwid']) ?>"><?= $review['title'] ?></a></span>
					    	<span style="width:120px;float:left;"><?= date('Y-m-d H:i:s',$review['dateline']) ?></span>
							</div>



<?php if(!empty($review['replysubject'])) { ?>
		<span style="float:left;" id="tdop_<?= $review['logid'] ?>" align="center" class="noreplyBtn">已回复</span>
	<?php } else { 
            $rasubject=str_replace('"','\"',$review['subject']);
			$rasubject=str_replace("\n",'',$rasubject);
			$rasubject=str_replace("'",'＇',$rasubject);
			$ratitle=str_replace('"','\"',$review['title']);
			$ratitle=str_replace("\n",'',$ratitle);
			$ratitle=str_replace("'",'＇',$ratitle);
            ?>
			<?php if($review['shield']==1){ ?>
			<span style="float:left;" id="tdop_<?= $review['logid'] ?>" align="center"><input class="noreplyBtn"  type="button" value="回复" /></span>
			<?php }else{ ?>
					<?php if($review['authorid'] == $user['uid']) { ?>
						<?php if($review['uid'] == $review['authorid']){ ?><!--是老师的评论不能回复-->
							<span style="float:left;" id="tdop_<?= $review['logid'] ?>" align="center"><input class="noreplyBtn"  type="button" value="回复" /></span>
						<?php }else{ ?>
							<span style="float:left;" id="tdop_<?= $review['logid'] ?>" align="center"><input class="replyBtn" style="cursor:pointer;"  type="button" onclick='reply("<?= $rasubject ?>","<?= $ratitle?>",<?= $review['logid'] ?>,"courseware",<?= $review['cwid'] ?>)' value="回复" /></span>
						<?php } ?>
					<?php } else { ?>
				<span style="float:left;" id="tdop_<?= $review['logid'] ?>" align="center"><input class="noreplyBtn"  type="button" value="回复" /></span>
					<?php } ?>
            <?php } ?>
        <?php } ?>
	
<span style="float:left;" align="center"><input class="<?= ($review['shield']==1)?'noreplyBtn':'replyBtn'?>" style="margin-left:5px;" type="button" value="屏蔽" <?php if($review['shield']==1){?>onclick="javascript:;";<?php }else{ ?>onclick="shield(<?= $review['cwid'] ?>,<?= $review['logid'] ?>)"<?php } ?>/></span>

<p id="subject_<?= $review['logid'] ?>" class="pltit" style="width:655px;margin-top:5px;float:left;">评论：<?php if($review['shield']==1){ ?><span style="color:red;">(该评论已被系统屏蔽)</span><?php }else{ ?><?= $review['subject'] ?><?php } ?></p>
<?php if(!empty($review['replysubject'])) { ?>
<p id="subject_<?= $review['logid'] ?>" class="pltit" style="color:#D0304F;width:650px;margin-top:5px;float:left;margin-left:65px;">回复：<?= $review['replysubject'] ?></p>
  <?php } ?>


</td>
</tr>


  <?php } ?>

  <?php } else { ?>
  <tr><td colspan="5" align="center" class="plitem">暂无记录</td></tr>

  <?php } ?>
  </tbody>
</table>

<?= $pagestr ?>
<div class="clear"></div>
<div class="commentdiv" style="display: none;overflow: hidden;">
	<input type="hidden" id="logid" value="" name="logid" />
	<input type="hidden" id="type" value="" name="type" />
	<input type="hidden" id="toid" value="" name="toid" />
	<table border="0" cellspacing="0" cellpadding="0" width="400">
		<tr><td colspan=2><span style="color: #D0304F">温馨提示：每条评论只能回复一次，请谨慎操作</span></td></tr>
		<tr>
			<td colspan=2>评论对象：<label id="target"></label></td>
		</tr>
		<tr style="margin:8px 0;">
			<td colspan=2>评论内容：<span style="word-wrap:break-word;width:370px;display:inline-block;" id="content"></span></td>
		</tr>
		<tr>
			<td colspan=2>回复内容：<textarea cols="50" rows="5" id="repcontent" name="repcontent"></textarea></td>
		</tr>
		<tr>
			<td width="80"></td><td><em id="msg" style="color: #ff0000"></em></td>
		</tr>
		
	</table>
</div>
</div>
<script type="text/javascript">
$(function(){
	var button = new xButton();
	button.add({
		value:"确定",
		callback:function(){
			submit_refuse();
			//H.get('commentdiv').exec('close');
			return false;
		},
		autofocus:true
	});

	button.add({
		value:"取消",
		callback:function(){
			$("#repcontent").val("");
			$("#msg").html("");
			H.get('commentdiv').exec('close');
			return false;
		}
	});

	H.create(new P({
		title:'回复评论',
		button:button,
		easy:true,
		id:'commentdiv',
		padding:20,
		content:$('.commentdiv')[0]
	},{
		'onclose':function(){
			$("#repcontent").val("");
			return false;
		},
		'onshow':function(){
			$("#msg").html("");
			return false;
		}
	}));
});


function reply(content,target,logid,type,toid)
{

	$("#type").val(type);
	$("#toid").val(toid);
	$("#target").text(target);
	$("#logid").val(logid);
	var reg = /<[^>]+>/gi;  // 正则表达式
	$("#content").text(content.replace(reg,''));
	H.get('commentdiv').exec('show');
}

function submit_refuse(){
	if($("#repcontent").val()==''){
		$("#msg").text('回复内容不能为空！');
		return;
	}else if($("#repcontent").val().length >70){
		$("#msg").text('回复内容应为1-70个字符！');
		return;
	}else{
		$("#msg").text('');
	}
	var _logid = $("#logid").val();
	var _type = $("#type").val();
	var _toid = $("#toid").val();
//	var _repcontent = encodeURI($("#repcontent").val());
        var _repcontent = $("#repcontent").val();
        var url = '<?= geturl('troom/review/reply') ?>';
	$.ajax({
		type:'post',
		url:url,
		dataType:'json',
		data:{'logid':_logid,'type':_type,'toid':_toid,'repcontent':_repcontent},
		success:function(_json){
                        if(_json.status == 1){
                        	H.get('commentdiv').exec('close');
                            var htmlcontent = '<p style="color:#D0304F;width:650px;margin-top:5px;float:left;margin-left:65px;">回复：' + _repcontent + '</p>';
                            $("#subject_" + _logid).after(htmlcontent);
                            $("#tdop_" + _logid).html('已回复');
                        } else {
				$("#msg").text(_json.msg);
			} 
                        
		}
	})
//	$("#revert")[0].submit();
	
}

		//屏蔽
	function shield(cwid,logid){
	
		$.confirm("您确定要屏蔽该评论吗？屏蔽后不可查看该评论!", function() {
			var url = "<?= geturl('troom/review/shield')?>";
			$.ajax({
				type:'post',
				url:url,
				dataType:'json',
				data:{'cwid':cwid,'logid':logid},
				success:function(data){
					if(data != undefined && data.status != undefined && data.status == 1) {
						$.showmessage({
                            img : 'success',
                            message:'屏蔽评论信息成功！',
                            title:'屏蔽评论',
                            callback :function(){
							   document.location.href = document.location.href ;
                            }
                        });
					} else {
						var msg = '屏蔽评论失败，请稍后再试或联系管理员。';
						if(data != undefined && data.msg != undefined)
							msg = data.msg;
						$.showmessage({
                            img : 'error',
                            message:msg,
                            title:'屏蔽评论'
                        });
					}
				}
			});	
		});
	}
</script>
<?php $this->display('troom/page_footer'); ?>