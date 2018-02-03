<?php $this->display('troom/page_header'); ?>
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
	当前位置 &gt; <a href="<?=geturl('troom/examapply')?>">认证管理</a> &gt; <a href="<?=geturl('troom/examapply')?>">成绩统计</a> &gt; 已通过未发证
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
                <li class="workcurrent"><a href="/troom/examapply/result/<?=$eid?>.html"><span>已通过未发证</span></a></li>
                <li><a href="/troom/examapply/resultfail/<?=$eid?>.html"><span>未通过</span></a></li>
                <li><a href="/troom/examapply/resultaward/<?=$eid?>.html"><span>已发证</span></a></li>
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
                                <input type="checkbox" value="<?=$answer['aid']?>" name="sel" style="position: relative;top: 3px; margin-right:5px;"><?=$answer['username']?>
                            </label>
                        </td>
                        <td><?=$answer['realname']?></td>
                        <td><?=date("y-m-d H:i:s", $answer['dateline'])?></td>
                        <td><?=round($answer['totalscore'],2)?></td>
                        <td><a href="http://exam.ebanhui.com/etmark/<?=$answer['aid']?>.html" class="caoz" target="_blank">查看试卷</a>&nbsp;&nbsp;<a href="<?=$answer['photo']?>" class="caoz" target="_blank">照片下载</a></td>
                    </tr>
<?php }
} else { ?>
				<tr><td colspan="5" align="center"><p align="center">暂无记录</p></td></tr>
<?php } ?>
                </table>
            </div>
            <div class="clear"></div>
            <div class="bottoms">
                <div class="fl">
                    <label>
                        <input type="checkbox" id="selall" style="position: relative;top: 3px; margin-right:5px; margin-left:6px;">全选
                    </label>
                </div>
                <div class="fl ml20"><a id="doaward" href="javascript:;" class="result">批量发证</a></div>
            </div>
            <div class="clear"></div>
        </div>
<?=$pagestr?>
	</div>
</div>



<div id="dialogdoaward" style="display:none">
	<div class="dialogcont">
		<div class="tishi mt40"><p>确定全部发证?</p></div>
	</div>
</div>

<script>
function _search(){
	var searchkey = $('#searchkey').val();
	if(searchkey == '请输入学生姓名或登录帐号')
		searchkey = '';
	location.href = '<?=geturl('troom/examapply/result/'.$eid)?>?q='+searchkey;
}
function _examexcel(){
	var startdate = $('#startdate').val();
	var enddate = $('#enddate').val();
	location.href = '/troom/examapply/examexcel/<?=$eid?>.html?type=1&startdate='+startdate+'&enddate='+enddate;
}
$(function(){
	//批量选择
	$("#selall").click(function(){
		$("input[name='sel']").attr("checked", this.checked);
	});
	//批量发证
	$("#doaward").click(function(){
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
					alert("请选择要发证的学生");
					return false;
				}
				$.post('/troom/examapply/batchaward.html',{ids:idarr.join(",")},function(data){
					if(data != undefined && data != null && data.code ==1){
						$.showmessage({
							img : 'success',
							message:data.msg,
							title:'消息通知',
							callback:function(){
								H.get('dialogdoaward').exec('close');
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
				H.get('dialogdoaward').exec('close');
				return false;
			}
		});
		if(!H.get('dialogdoaward')){
			H.create(new P({
				id : 'dialogdoaward',
				title: '批量发证',
				easy:true,
				width:455,
				padding:5,
				content:$('#dialogdoaward')[0],
				button:button
			}),'common');
		}
		H.get('dialogdoaward').exec('show');
	});

});
</script>


<?php $this->display('troom/page_footer'); ?>