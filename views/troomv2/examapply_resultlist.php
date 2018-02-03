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
	当前位置 &gt; <a href="<?=geturl('troomv2/examapply')?>">认证管理</a> &gt; 成绩统计
        <div class="diles fr">
            <input type="text" value="<?=empty($q)?'请输入认证名称':$q?>" id="searchkey" class="newsou" name="title" style="color:#999; background:#fff;" onfocus="if($(this).val()=='请输入认证名称')$(this).val('');$(this).css('color','#333')" onblur="if($.trim($(this).val())==''){$(this).val('请输入认证名称');$(this).css('color','#999')}">
            <input type="button" value="" onclick="_search()" class="soulico" id="searchbutton">
        </div>
</div>
<div class="lefrig">
    <div class="workol">
       <div>
            <div style="float:left;margin-top:0px;" class="workdata">
                <table class="datatab" cellpadding="0" cellspacing="0">
                    <tr class="first">
                        <td width="187"><span style="padding-left:20px;">认证名称</span></td>
                        <td width="143">出卷时间</td>
                        <td width="149">满分</td>
                        <td width="149">答题人数</td>
                        <td width="97">操作</td>
                    </tr>
<?php if(!empty($exams)) {
	foreach($exams as $exam) {?>
                    <tr >
                        <td>
                            <label>
                                <?= shortstr($exam['title'],44) ?>
                            </label>
                        </td>
                        <td><?= date("Y-m-d H:i",$exam['dateline']) ?></td>
                        <td><?= $exam['score'] ?></td>
                        <td><?= $exam['answercount'] ?></td>
                        <td><a href="/troomv2/examapply/result/<?=$exam['eid']?>.html" class="annius">查看详情</a></td>
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
	if(searchkey == '请输入认证名称')
		searchkey = '';
	location.href = '<?=geturl('troomv2/examapply/resultlist')?>?q='+searchkey;
}
</script>


<?php $this->display('troomv2/page_footer'); ?>