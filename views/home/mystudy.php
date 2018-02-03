<?php $this->display('home/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<div class="">
<!--第一个div是测试看页面的，引用头部后会自带的，要去掉的-->
<div class="ter_tit">
当前位置 > <a href="<?= geturl('home/largedb') ?>">历史数据</a> > 学习记录
<div class="diles">
	<input name="sdate" class="newsou" id="sdate" value="<?= $d ?>" onclick="WdatePicker()"/>
	<input id="searchbutton" type="button" class="soulico" value="">
</div>
</div>
<div class="lefrig" style="border:solid 1px #cdcdcd;background:#fff;float:left;margin-top:15px;width:786px;">
<div class="weaktil">
<span class="datek">学习记录</span>
</div>
<!--学习数据开始-->
<div class="workol">
<div class="workdata" style="float:left">
<table width="100%" style="border:none;" class="datatab">
	<tbody>
    	<?php if(!empty($playlogs)) { ?>
		<?php
		$tdcount = 0;
		?>
		<?php foreach($playlogs as $log) { 
			  $arr = explode('.',$log['cwurl']);
			  $type = $arr[count($arr)-1];
			  $tdcount++;
		?>
		<tr>
        	<?php if($tdcount == 1){ ?>
        	<td style="border-top:none">
            <?php } else { ?>
            <td>
            <?php } ?>
				<div style="float:left;width:772px;font-family:Microsoft YaHei;">
                    <p style="width:500px;word-wrap: break-word;margin-bottom:10px;font-size:14px;;float:left;line-height:2;">
                        <a href="<?=$log['subjecturl']?>" target="_blank" style="color:#000;font-weight:bold;"><?=$log['foldername'] ?>(<?=$log['coursewarenum'] ?>)</a>
                    </p>
                    <span style="float:right;"><a href="<?=$log['murl']?>" target="_blank"><?= shortstr($log['crname'],40)?></a></span>
                    <div style="float:left; width: 772px;">
                        <span style="width:170px;float:left;">课件名称：<a target="_blank" href="<?=$log['cousewareurl']?>" target="_blank"><?= $log['title'] ?></a></span>
                        <span style="width:115px;float:left;">课件时长：<?= $this->getltimestr($log['ctime'])?></span>
                        <span style="width:115px;float:left;">持续时间：<?= $this->getltimestr($log['ltime'])?></span>
                        <span style="width:185px;float:left;">首次时间：<?= date('Y-m-d H:i:s',$log['startdate'])?></span>
                        <span style="width:185px;float:left;">末次时间：<?= date('Y-m-d H:i:s',$log['lastdate'])?></span>
                    </div>		
				</div>
            </td>
        </tr>
        <?php } ?>
	<?php } else { ?>
		<tr><td colspan="5" align="center">暂无记录</td></tr>
	<?php } ?>	
</tbody>				
</table>
<?= $pagestr ?>
</div>
<!--学习数据结束-->
</div>
</div>
<script type="text/javascript">

var tip = '请输入课件名称';
$(function(){
	initsearch('txtname',tip);
	$('#searchbutton').click(function(){
		if($("#txtname").val()==tip){
			var searchvalue = '';
		}else{
			var searchvalue = $("#txtname").val();
		}
		if(searchvalue==tip){
			searchvalue='';
		}
		var d = $("#sdate").val();
		location.href = '<?= geturl('home/largedb/study')?>?d='+d;
	});
});

function replaceAll(str,find,rp){
	while(true){
		if(str.indexOf(find) == -1){
			break;
		}
		str = str.replace(find,rp);
	}
	return str;
}
</script>
<?php $this->display('home/page_footer'); ?>