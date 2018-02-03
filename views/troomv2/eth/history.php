<?php $this->display('troomv2/page_header'); ?>
<style type="text/css">
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
    padding: 0;
    font-weight: normal;
    color:#333;
}
.dialogcont .tishi p {
    padding-left: 90px; font-size: 16px; line-height: 35px;
}
.datatab a,.datatab a:visited {
    color: #666;
}
</style>
<div class="lefrig">
    <div class="waitite">
        <div class="work_menu" style="position:relative;margin-top:0">
			<ul>
				<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso">发信历史</span></a></li>
			</ul>
		</div>
        <div class="hsidts" style="width:205px">
            <a class="lasrnwe" href="/troomv2/eth.html">发消息</a>
            <a class="lasrnwe" href="/troomv2/eth/inbox.html">收件箱</a>
            <a class="lasrnwe" href="/troomv2/eth/bind.html">绑定情况</a>
        </div>
        
        <!-- <div class="hjiware">
			<input class="jisewse" name="textarea" type="text" id="textarea" value="起始时间" size="45" />
            <span class="jietds">一</span>
			<input class="jisewse" name="textarea" type="text" id="textarea" value="截止时间" size="45" />
            <a href="#" class="hisret">查询</a>
        </div>-->
  </div> 
    <table class="datatab" width="100%" style="border:none;">
        <thead class="tabhead">
            <tr class="">
            <th style="padding-left:30px;text-align: left;">时间</th>
            <th style="text-align: left;" >主题</th>
            <th>发送人数</th>
            <th>操作</th>
            </tr>
        </thead>
        <tbody>
        <?php if(!empty($sendList)){
        	$maxkey = count($sendList) - 1;
        	foreach($sendList as $key => $send){?>
        	 <tr class="">
                <td width="18%" <?php if($key == $maxkey) echo ' style="border-bottom:none;"';?>>
                <span class="husrryd"><?=date("Y-m-d H:i",$send['dateline'])?></span>
                </td>
                <td width="57%" <?php if($key == $maxkey) echo ' style="border-bottom:none;"';?>><span style="width:535px;float:left;word-wrap: break-word;"><?=$send['subject']?></span></td>
                <td width="10%" style="text-align:center;<?php if($key == $maxkey) echo 'border-bottom:none;';?>"><?=$send['send_total_num']?></td>
                <td width="15%" style="text-align:center;<?php if($key == $maxkey) echo 'border-bottom:none;';?>">
                <a class="" href="<?=geturl("troomv2/eth/history/".$send['mid'])?>" style="text-decoration: none;text-align:center;color:#5e98fb;">查看</a>
                </td>
            </tr>
        	<?php }?>
        <?php }else{?>
        <tr class="" style="background-color: #fff;"><td colspan="4" style="text-align:center;border-bottom:none;"><div class="nodata"></div></td></tr>
        <?php }?>
        <tbody>
    </table>
    <?=$pageStr?>
</div>
<input type="hidden" name="mid" id="mid" value="0" />
<!--删除问卷对话框-->
<div id="dialogdel" style="display:none">
	<div class="dialogcont">
		<div class="tishi mt40"><p>确定要删除该邮件吗?</p></div>
	</div>
</div>
<script type="text/javascript">
function deloutbox(obj) {
	//console.log();
	$("#mid").val($(obj).data('mid'));
	var button = new xButton();
	button.add({
		value:"确定",
		callback:function(){
			savedel();
			return false;
		},
		autofocus:true
	});

	button.add({
		value:"取消",
		callback:function(){
			H.get('dialogdel').exec('close');
			return false;
		}
	});
	if(!H.get('dialogdel')){
		H.create(new P({
			id : 'dialogdel',
			title: '删除发件',
			easy:true,
			width:400,
			padding:5,
			content:$('#dialogdel')[0],
			button:button
		}),'common');
	}

	H.get('dialogdel').exec('show');
}
function savedel(){
	var mid = $("#mid").val();
	$.ajax({
		type:'post',
		url:'<?=geturl('troomv2/eth/deloutbox')?>',
		dataType:'json',
		data:{'mid':mid},
		success:function(data){
			dialogtip();
			if(data!=undefined && data!=null && data==1){
				H.get('xtips').exec('setContent','删除成功').exec('show').exec('close',500);
				window.location.reload();
			}else{
				H.get('xtips').exec('setContent','删除失败').exec('show').exec('close',500);
			}
		},
		error:function(){
			alert("服务器连接错误，请重试");
		}
	});
}
function dialogtip(){
	if(!H.get('xtips')){
		H.create(new P({
			id:'xtips',
			easy:true,
			padding:10
		},{
			onclose:function(){
			//	location.reload(true);
			}
		}),'common');
	}
}
</script>
<?php ?>
</body>
</html>