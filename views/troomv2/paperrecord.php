<?php $this->display('troomv2/page_header'); ?>
<style type="text/css">
.addbtnas {
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/aroom/shua.jpg) no-repeat;
	width:80px;
	height:28px;
	border:none;
	cursor:pointer;
	color:#fff;
	float:right;
	display: block;
	text-decoration: none;
	position: absolute;
	top: 11px;
	right: 15px;
}
.lefrig .annotate a:hover{ color:#fff;}
</style>

<div class="ter_tit">
	当前位置 > <a href="<?= geturl('troomv2/teaexam') ?>">我的题库</a> > 组卷记录
</div>

<div class="lefrig" style="border:solid 1px #cdcdcd;background:#fff;float:left;margin-top:15px;width:786px;">


<div class="annotate" style="position:relative;height:30px;line-height:30px;">
<div class="tiezitoolss"><a class="lanbtn" href="javascript:location.reload();">刷 新</a></div></div>



<div class="workdata" style="float:left;">
	<table width="100%" class="datatab" style="border:none;">
		<thead class="tabhead">
		  <tr>
			<th>试卷名称</th>
			<th>时间</th>
			<th>分数</th>
			<th>操作</th>
		  </tr>
		</thead>
		 <tbody>
		 
                 <?php if(!empty($papers)) { ?>
                 <?php $qtype = array(0=>'单选题',1=>'多选题',2=>'判断题',3=>'填空题',4=>'文字题',5=>'主观题');?>
		
                        <?php foreach($papers as $paper) { ?>
			  <tr>
			  	
                                <?php 
                                    $et = '';
                                    $qtnumarr = unserialize($paper['qtnums']);
                                    if(!empty($qtnumarr)) {
                                        foreach ($qtnumarr as $qk => $qv) {
                                            $qvd = base64_decode($qv);
                                            if(!empty($qvd))
                                                $et .= $qtype[$qk]."&nbsp;".$qvd."题&nbsp;&nbsp;";
                                        }
                                    }
                                ?>
				<td width="30%" name="<?= $paper['pid'] ?>"><span style="width:350px;float:left;word-wrap: break-word;" title="<?= $paper['title'] ?>"><?= shortstr($paper['title'],60) ?>&nbsp;&nbsp;<font style="color:#789ac8;"><?= $et ?></font></span></td>
				<td width="20%"><?= date('Y-m-d H:i:s',$paper['dateline']) ?></td>
				<td width="10%"><?= $paper['totalscore'] ?></td>
				<td width="15%">
					<a class="workBtn" href="http://exam.ebanhui.com/pedit/<?= $crid ?>/<?= $paper['pid'] ?>.html" target="_blank">编辑</a>
					<a class="workBtn" href="javascript:void(0)" onclick="delpaper(<?= $paper['pid'] ?>)">删除</a>
				</td>
			  </tr>
                        <?php } ?>
			 
                 <?php } else { ?>
			<tr>
				<td colspan="8" align="center">暂无记录</td>
			</tr>
                 <?php } ?>
		 
		</tbody>
	</table>
	<div style="margin-top:20px;"><?= $page_str ?></div>
</div>
</div>
</div>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<script type="text/javascript">

function delpaper(pid) {
	$.confirm("你确定删除此试卷吗？",function(){
		$.ajax({
			url:"/troomv2/exampaper/del.html",
			type:'post',
			data:{'pid':pid},
			dataType:'text',
			success:function(data){
				if(data=='success'){
					$.showmessage({
						img		 : 'success',
						message  :  '试卷删除成功',
						title    :      '试卷删除      成功',
						timeoutspeed    :       500,
						callback :    function(){
							location.reload();
						}
					});
				}else{
					$.showmessage({
						img		 : 'error',
						message  :  '试卷删除失败',
						title    :      '试卷删除      失败',
						timeoutspeed    :       500
					});
				}
			}
		});
	});
	
}
</script>
<?php $this->display('troomv2/page_footer'); ?>