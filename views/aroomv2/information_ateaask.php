<?php $this->display('aroomv2/page_header')?>
<script src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css<?=getv()?>"/>

	<div class="ter_tit">
        当前位置 > <a href="/aroomv2/information.html">信息管理</a> >
        答疑管理
    </div>
    <div class="dayis mt10">
    	<div class="dayis_top">
            <div class="clear"></div>
        	<div class="dayis_top_l fl">
            	<div class="fl">
				<?php $has = $this->input->get('has'); ?>
                    <span style="font-size:14px; color:#333;">时间段：</span>
                    <input id="startdate" class="inp" type="text" readonly="readonly" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'});" value="<?=$startdate?>" / >
                    <span style="font-size:14px; color:#333;">到</span>
                    <input id="enddate" class="inp" readonly="readonly" type="text" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'});" value="<?=$enddate?>" />
					<input id="has" type="text" style="display:none" value="<?= $has?>"/ >
                </div>
                <div class="fl ml10" style="margin-top:1px;"><a href="javascript:;" onclick="searchbydate()" class="workBtns workBtns-1">确 定</a></div>
            </div>
            <div class="dayis_top_r fl ml25" style="line-height:32px;">
            	<ul>
                	<li class="fl"><b>问题状态>>&nbsp;&nbsp;</b></li>
                    <li class="fl"><a href="/aroomv2/information/ateaask.html?sdate=<?= $startdate?>&edate=<?=$enddate?>" class="<?= ($has=='')? 'select':''?>">不限</a></li>
                    <li class="fl"><a href="/aroomv2/information/ateaask.html?sdate=<?= $startdate?>&edate=<?=$enddate?>&has=1" class="<?= ($has=='1')? 'select':''?>">已解决</a></li>
                    <li class="fl"><a href="/aroomv2/information/ateaask.html?sdate=<?= $startdate?>&edate=<?=$enddate?>&has=0" class="<?= ($has=='0')? 'select':''?>">未解决</a></li>
                </ul>
            </div>
        </div>
        <div class="clear"></div>
        <div class="queanswcheck">
			<table cellpadding="0" cellspacing="0" class="tables">
    			<tr  class="second">
        			<td width="786" colspan="7">
           				<div>
                            <div class="teacher fl"><b style="font-size:16px;">网校答疑统计:</b></div>
                            <div class="quest fl" style="font-size:15px; width:615px; cursor:context-menu "><p>问题总数：<a href="javascript:;" style="cursor:context-menu;font-size:15px;"><?= $asklistcount?></a>&nbsp;&nbsp;已解决：<a href="javascript:;" style="cursor:context-menu; font-size:15px;"><?= $askanswered?></a>&nbsp;&nbsp;未解决：<a href="javascript:;" style="cursor:context-menu;font-size:15px;"><?= $asklistcount-$askanswered?></a>   </p></div>
                		</div>
                		<div class="clear"></div>
            		</td>
        		</tr>
                <tr   class="first">
                	<td width="194">提问人</td>
                    <td width="150">问题</td>
                    <td width="120">所属课件</td>
                    <td width="75">提问时间</td>
                    <td width="44">回答数</td>
                    <td width="60">问题状态</td>
                    <td width="60">操作</td>
                </tr>
				<?php if(!empty($asklist)){ 
						foreach($asklist as $al){
							if(!empty($al['face']))
								$face = getthumb($al['face'],'50_50');
							else{
								if($al['sex']==1){
									if($al['groupid']==5){
										$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
									}else{
										$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
									}
								}else{
									if($al['groupid']==5){
										$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
									}else{
										$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
									}
								}
								$face = getthumb($defaulturl,'50_50');
							} 
				?>
                <tr >
                    <td width="194"><a href="javascript:;" class="fl" style="cursor:context-menu; "><img src="<?= $face?>" style="height:50px;; width:50px;" /></a><p class="p2s" style="width:138px !important;"><b><?=shortstr($al['username'],8)?>（<?=$al['sex']==1?'女':'男'?>）</b><br /><?= $al['realname']?></p></td>
					<?php if($al['shield']==1){ ?>
						<td width="150"><p style="width:150px;word-wrap: break-word;float:left;color:red;">该问题已被屏蔽</p></td>
					<?php }else{ ?>
						<td width="150"><p style="width:150px;word-wrap: break-word;float:left;"><?= $al['title']?></p></td>
					<?php } ?>
                    <td width="120"><p style="width:115px;word-wrap: break-word;"><?= $al['cwname']?><p></td>
                    <td width="75"><?= Date('Y-m-d H:i:s',$al['dateline'])?></td>
                    <td width="44"><?= $al['answercount']?></td>
                    <td width="60"><?php if($al['hasbest']==0){ ?><p  style="color:#f00;">未解决</p><?php }else{ ?><p>已解决</p><?php } ?></td>
					<?php if($al['shield']==1){ ?>
						<td width="60"><a href="javascript:;" onclick="cancelshield(<?= $al['qid'] ?>)">取消屏蔽</a></td>
					<?php }else{ ?>
						<td width="60"><a href="/aroomv2/information/ateaask/<?= $al['qid'] ?>.html">查看解答</a></td>
					<?php } ?>
                </tr>
				<?php } }else{?>
					<tr><td colspan="5" align="center">暂无记录</td></tr>
				<?php }?>
    	</table>
		</div>
	</div>
	<!--取消屏蔽-->
<div id="delshield" class="tanchukuang" style="display:none;height:150px;">
    <div class="tishi" style="padding-top:20px;"><span>你确定要取消屏蔽的问题吗？</span></div>
</div>

    <div class="clear"></div>
<?= $pagestr?>
<script>
//取消屏蔽的问题
function cancelshield(qid){
		var button = new xButton();
		button.add({
			value:"确定",
			callback:function(){
				cancel(qid);
				H.get('delshield').exec('close');
				return false;
			},
			autofocus:true
		});

		button.add({
			value:"取消",
			callback:function(){
				// location.reload();
				H.get('delshield').exec('close');
				return false;
			}
		});

		if(!H.get('cancelshield')){
			H.create(new P({
				id : 'delshield',
				title: '屏蔽评论',
				easy:true,
				width:420,
				padding:5,
				button:button,
				content:$('#delshield')[0]
			}),'common').exec('show');
			
		}else{
			H.get('delshield').exec('show');
		}
			
	}
	function cancel(qid){
	
		$.ajax({

			type:'post',
			url:'<?= geturl('aroomv2/information/qshield')?>',
			dataType:'json',
			data:{'qid':qid,'shield':0},
			success:function(data){
				if(data != undefined && data.status != undefined && data.status == 1) {
					document.location.href = "<?= geturl('aroomv2/information/ateaask')?>";
				}else{
					alert("取消屏蔽失败");
				}
			},
			error:function(){
				alert("取消屏蔽失败，请稍后再试或联系管理员。");
			}
		});	
	}

function hlteacher(){
	var username;
	var realname;
	var search = $('#tsearch').val();
	$('.datatab tr').each(function(i){
		username = $(this).children("td:#un");
		realname = $(this).children("td:#rn");
		if(username.text().indexOf(search)>=0 || realname.text().indexOf(search)>=0 || search == ""){
			$(this).show();
		}else if(i!=0){
			$(this).hide();
		}
	});
}
function clearsearch(){
	$('#tsearch').val('');
	hlteacher();
	$('#tsearch').focus();
}
var showtd = false;
function selecttpye(){
	if($('#typediv').css('display') != 'block'){
		$('#typediv').show();
		showtd = true;
	}
}
//function toexcel(stype){
//	var sdate = $('#startdate').val();
//	var edate = $('#enddate').val();
//	var href='/aroom/report/taexcel.html?stype='+stype+'&sdate='+sdate+'&edate='+edate;
//	location.href = href;
//}
function searchbydate(){
	var sdate = $('#startdate').val();
	var edate = $('#enddate').val();
	var has =  $('#has').val();
	if(has=='')
		var href='/aroomv2/information/ateaask.html?sdate='+sdate+'&edate='+edate;
	else
		var href='/aroomv2/information/ateaask.html?sdate='+sdate+'&edate='+edate+'&has='+has;
	location.href = href;
}
$('body').click(function(e){
	obj = e.srcElement ? e.srcElement : e.target;
	if(obj.parentNode == $('#typediv')[0] || obj == $('#typediv')[0])
		;
	else if(showtd == false){
		$('#typediv').hide();
	}
	showtd = false;
});
</script>
<?php $this->display('aroomv2/page_footer')?>

