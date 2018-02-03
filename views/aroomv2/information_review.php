<?php $this->display('aroomv2/page_header')?>
<script src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css<?=getv()?>"/>
<body>
<div >
	<div class="ter_tit">
        当前位置 > <a href="/aroomv2/information.html">信息管理</a> > 评论管理
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
					<input id="q" type="text" style="display:none" value="<?= $q?>"/ >
                </div>
                <div class="fl ml10" ><a href="javascript:;" onclick="searchbydate()" class="workBtns workBtns-1">确 定</a></div>
            </div>
            <div class="pingluns_top_r fl ml25" style="line-height:32px;">
            	<ul><?php $q = $this->input->get('q'); ?>
                	<li class="fl"><b>评论状态>>&nbsp;&nbsp;</b></li>
                    <li class="fl" id="noq"><a href="/aroomv2/information/review.html?sdate=<?= $startdate?>&edate=<?=$enddate?>" class="<?= ($q=='')? 'select':''?>" >不限</a></li>
                    <li class="fl" id="noq1"><a href="/aroomv2/information/review.html?sdate=<?= $startdate?>&edate=<?=$enddate?>&q=1" class="<?= ($q=='1')? 'select':''?>" >已屏蔽</a></li>
                    <li class="fl" id="noq2"><a href="/aroomv2/information/review.html?sdate=<?= $startdate?>&edate=<?=$enddate?>&q=0" class="<?= ($q=='0')? 'select':''?>" >未屏蔽</a></li>
                </ul>
            </div>
        </div>
        <div class="clear"></div>
        <div class="reviewview">
            <table cellpadding="0" cellspacing="0" class="tables">
                <tr class="first">
                    <td width="150">评论人</td>
                    <td width="174">评论对象</td>
                    <td width="192">评论内容及状态</td>
                    <td width="114">评论时间</td>
                    <td width="96">操作</td>
                </tr>
				<?php if(!empty($reviews)){
					foreach($reviews as $rl){
				?>
                <tr>
				<?php $arr = explode('.',$rl['cwurl']);
					$type = $arr[count($arr)-1]; 
					if($type != 'flv' && $rl['ism3u8'] == 1)
						$type = 'flv';
					if($type == 'mp3')
						$type = 'flv';
					if(!empty($rl['face']))
						$face = getthumb($rl['face'],'50_50');
					else{
						if($rl['sex']==1){
							if($rl['groupid']==5){
								$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
							}else{
								$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
							}
						}else{
							if($rl['groupid']==5){
								$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
							}else{
								$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
							}
						}
					
						$face = getthumb($defaulturl,'50_50');
					} 
				?>
                    <td width="150"><a href="javascript:;" class="fl" style="cursor:context-menu"><img src="<?= $face?>" /></a><p class="p2s" style="width:95px !important;"><b><?=!empty($rl['realname'])?$rl['realname']:$rl['username']?>（<?= $rl['sex']==1?'女':'男'?>）</b><br /><?= $rl['trealname']?></p></td>
                    <td width="174"><p style="width:160px;word-wrap: break-word;float:left;"><?=$rl['title']?></p></td>
                    <td width="192"><p style="width:185px;word-wrap: break-word;float:left;"><?php if($rl['shield']==1){ ?><span style="color:red;">(该评论已被屏蔽)</span><?php }else{ ?><?=preg_replace('/<([^i][^m][^g])/','&lt;\1',$rl['subject']);?><?php } ?><p></td>
                    <td width="114"><?=Date('Y-m-d H:i:s',$rl['dateline'])?></td>
					<?php if($rl['shield']==1){ ?>
						<td width="96"><a href="javascript:;">屏蔽</a>&nbsp;&nbsp;<a href="javascript:cancel(<?= $rl['cwid']?>,<?= $rl['logid']?>)">取消</a></td>
					<?php }else{ ?>
						<td width="96"><a href="javascript:shield(<?= $rl['cwid']?>,<?= $rl['logid']?>)">屏蔽</a>&nbsp;&nbsp;<a href="javascript:;">取消</a></td>
					<?php } ?>
                </tr>
				<?php }} ?>
            </table>
		</div>
    <?=show_page($reviewcount)?>
	</div>
</div>

<script type="text/javascript">
<!--
	function searchbydate(){
	var sdate = $('#startdate').val();
	var edate = $('#enddate').val();
	var q = $('#q').val();
	if(q=='')
		var href='/aroomv2/information/review.html?sdate='+sdate+'&edate='+edate;
	else
		var href='/aroomv2/information/review.html?sdate='+sdate+'&edate='+edate+'&q='+q;
	location.href = href;
}

//屏蔽评论
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
				alert("屏蔽评论失败，请稍后再试。");
			}
		});	
	}
//取消屏蔽评论
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
				alert("取消屏蔽失败，请稍后再试。");
			}
		});	
	}
//-->
</script>
<?php $this->display('aroomv2/page_footer')?>

