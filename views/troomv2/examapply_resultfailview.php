<?php $this->display('troomv2/page_header'); ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2014/css/authement.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<script src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
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
	当前位置 &gt; <a href="<?=geturl('troomv2/examapply')?>">认证管理</a> &gt; <a href="<?=geturl('troomv2/examapply')?>">成绩统计</a> &gt; 未通过
        <div class="diles fr">
            <input type="text" value="<?=empty($q)?'请输入学生姓名或登录帐号':$q?>" id="searchkey" class="newsou" name="title" style="color:#999; background:#fff;" onfocus="if($(this).val()=='请输入学生姓名或登录帐号')$(this).val('');$(this).css('color','#333')" onblur="if($.trim($(this).val())==''){$(this).val('请输入学生姓名或登录帐号');$(this).css('color','#999')}">
            <input type="button" value="" onclick="_search()" class="soulico" id="searchbutton">
        </div>
</div>
<div class="lefrig" style="padding-bottom:0;">
	<table width="100%" class="datatab">
		<thead class="tabhead">
		  <tr class="">
		<th>认证名称</th>
		<th>出卷时间</th>
		<th>满分</th>
		<th>题数</th>
		<th>答题人数</th>
		  </tr>
		</thead>
		 <tbody>
			  <tr>
				<td width="35%"><?= shortstr($exam['title'],60) ?></td>
				<td width="20%"><?= date('Y-m-d H:i:s',$exam['dateline']) ?></td>
				<td width="15%"><?= $exam['score'] ?></td>
				<td width="15%"><?= $exam['quescount'] ?></td>
				<td width="15%"><?= $exam['answercount'] ?></td>
			  </tr>
			<tr>
		</tbody>
	</table>
</div>
<div class="lefrig">
    <div class="workol">
        <div class="work_mes">
			<div class="fr" style="margin:4px 10px 0 0;">
				<div class="fl">
			        <span>时间段：</span>
			        <input id="startdate" class="readonly inp" readonly="readonly" type="text" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',maxDate:'#F{$dp.$D(\'enddate\',{d:-1})||\'<?=Date('Y-m-d',SYSTIME-86400)?>\'}'});" value="<?=empty($startdate)?'':$startdate?>"/>
			        <span>到</span>
					<input id="enddate" class="readonly inp" readonly="readonly" type="text"  onclick="WdatePicker({dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'startdate\',{d:1})}',maxDate:'<?=Date('Y-m-d',SYSTIME)?>'});" value="<?=empty($enddate)?'':$enddate?>"/>
			    </div>
			    <div class=" fl ml10"><a class="workBtns" onclick="_examexcel()" href="javascript:void(0)">导 出</a></div>
			</div>
            <ul class="extendul">
                <li><a href="/troomv2/examapply/result/<?=$eid?>.html"><span>已通过未发证</span></a></li>
                <li class="workcurrent"><a href="/troomv2/examapply/resultfail/<?=$eid?>.html"><span>未通过</span></a></li>
                <li><a href="/troomv2/examapply/resultaward/<?=$eid?>.html"><span>已发证</span></a></li>
            </ul>
        </div>
        <div class="clear"></div>
        <div>
            <div style="float:left;margin-top:0px;" class="workdata">
                <table class="datatab" cellpadding="0" cellspacing="0">
                    <tr class="first">
                        <td width="183"><span style="padding-left:20px;">账号</span></td>
                        <td width="170">姓名</td>
                        <td width="159">答题时间</td>
                        <td width="68">得分</td>
                        <td width="144">操作</td>
                    </tr>
<?php if(!empty($answers)) {
	foreach($answers as $answer) {?>
                    <tr >
                        <td>
                            <label>
                                <?=$answer['username']?>
                            </label>
                        </td>
                        <td><?=$answer['realname']?></td>
                        <td><?=date("y-m-d H:i:s", $answer['dateline'])?></td>
                        <td><?=round($answer['totalscore'],2)?></td>
                        <td><a href="http://exam.ebanhui.com/etmark/<?=$answer['aid']?>.html" class="caoz" target="_blank">查看试卷</a>&nbsp;&nbsp;<a href="javascript:;" onclick="return deleteanswer('<?=$answer['aid']?>','<?=$answer['eid']?>','<?=$answer['uid']?>')" class="caoz">重考</a></td>
                    </tr>
<?php }
} else { ?>
				<tr><td colspan="5" align="center"><p align="center">暂无记录</p></td></tr>
<?php } ?>
                </table>
            </div>
            <div class="clear"></div>
        </div>
<?=$pagestr?>
	</div>
</div>


<script>
function _search(){
	var searchkey = $('#searchkey').val();
	if(searchkey == '请输入学生姓名或登录帐号')
		searchkey = '';
	location.href = '<?=geturl('troomv2/examapply/resultfail/'.$eid)?>?q='+searchkey;
}
function _examexcel(){
	var startdate = $('#startdate').val();
	var enddate = $('#enddate').val();
	location.href = '/troomv2/examapply/examexcel/<?=$eid?>.html?type=2&startdate='+startdate+'&enddate='+enddate;
}
function deleteanswer(aid,eid,uid) {
	$.confirm("重考确认","确定要该学生重考吗？",function(){
		var url = '<?= geturl('troomv2/classpaper/deleteanswer') ?>';
		$.post(url,{'aid':aid,'eid':eid,'uid':uid},function(data){
				if(data==1){
					$.showmessage({
						img		 : 'success',
						message  :  '操作成功',
						title    :      '重考',
						timeoutspeed    :       500,
						callback :    function(){
							location.reload();
						}
					});
				}else{
					$.showmessage({
						img		 : 'error',
						message  :  '操作失败',
						title    :      '重考',
						timeoutspeed    :       500
					});
				}
			});

	});
	return false;
	
}
</script>


<?php $this->display('troomv2/page_footer'); ?>