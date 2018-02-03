<?php $this->display('troomv2/page_header'); ?>
<style>
    body{
        background: #fff;
    }
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
    .category_cont1 div a {
        padding:3px 10px;
        font-size:14px;
    }

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
    .work_menu ul li.viewclose{
            float: right;
            margin:10px;
            padding: 0 4px;
            font-size: 24px;
            font-weight: bold;
            line-height: 1;
            color: #000;
            text-shadow: 0 1px 0 #FFF;
            cursor: pointer;
            background: transparent;         
            border: 0;
            -webkit-appearance: none;
            top: 8px;
            font-family: sans-serif;
            opacity: .5;
            filter: alpha(opacity=50);
    }
    a.title-a{
        background: none;           
    }
    a.title-a .jnisrso{
        background: none;
        color: #000;
        font-size: 22px;
        font-weight: 600;
    }
    .work_mes{          
        padding-left: 20px;           
        box-sizing: border-box;
        -moz-box-sizing:border-box; /* Firefox */
        -webkit-box-sizing:border-box; /* Safari */
    }
    .nodata{
        min-height: 304px;
        overflow-y:auto;
    }
    .huerdfr{
            height:280px;           
            overflow-y: auto;
        }
</style>
<div class="lefrig">
    <div class="waitite">
        <div class="work_menu" style="position:relative;margin-top:0">
			<ul>
				<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso">发信历史（查看）</span></a></li>
                <li class="viewclose" onclick="parent.window.H.get('dialogNotice').exec('close')">×</li>
			</ul>
		</div>
    </div>
    <div class="work_mes">
        <ul class="extendul">
            <li >
                <a href="<?=geturl("troomv2/eth/history/".$mid)?>">
                <span>发信历史</span>
                </a>
            </li>
            <li>
                <a href="<?=geturl("troomv2/eth/history/error/".$mid)?>">
                <span>发送状态</span>
                </a>
            </li>
            <li>
                <a href="<?=geturl("troomv2/eth/history/tong/".$mid)?>">
                <span>统计分析</span>
                </a>
            </li>
            <li class="workcurrent">
                <a href="<?=geturl("troomv2/eth/history/reply/".$mid)?>">
                <span>查看回复（<?=$replycount?>）</span>
                </a>
            </li>
        </ul>
    </div>
     <table class="datatab" width="100%" style="border:none;">
        <tbody>
        <?php if (!empty($replylist)){
        $maxkey = count($replylist) - 1;
        foreach ($replylist as $key => $reply){?>
            <tr class="">
                <td width="25%" <?php if($key == $maxkey) echo ' style="border-bottom:none;"';?>>
                    <a title="<?=getusername($reply)?>" href="javascript:;" style="float:left;">
                    <img class="imgyuan" src="<?=getavater($reply,'50_50')?>">
                    </a>
                    <p class="ghjuts">
                    <?=$reply['realname']?>
                    <?php if($inbox['sex']==1){?>
                    <img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/women.png">
                    <?php }else{?>
                    <img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/man.png">
                    <?php }?>
                    </p>
                    <p class="ghjuerts"><?=$reply['username']?></p>
                    <p class="ghjus"><?=date("Y-m-d H:i",$reply['dateline'])?></p>
                </td>
                <td width="75%" <?php if($key == $maxkey) echo ' style="border-bottom:none;"';?>><?=strip_tags($reply['comment'])?></td>
            </tr>
        <?php } } else {?>
            <tr class="" style="background-color: #fff;">
                <td colspan="2" style="border-bottom:none;text-align:center;">
                <div class="nodata"></div>
                </td>
            </tr>
        <?php }?>
        </tbody>
    </table>
</div>
<?=$pagestr?>

<input type="hidden" name="rid" id="rid" value="0" />
<!--删除问卷对话框-->
<div id="dialogdel" style="display:none">
	<div class="dialogcont">
		<div class="tishi mt40"><p>确定要删除该回复吗?</p></div>
	</div>
</div>
<script type="text/javascript">
function delreply(obj) {
	//console.log();
	$("#rid").val($(obj).data('rid'));
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
			title: '删除回复',
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
	var rid = $("#rid").val();
	$.ajax({
		type:'post',
		url:'<?=geturl('troomv2/eth/delreply')?>',
		dataType:'json',
		data:{'rid':rid},
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
		}),'common');
	}
}
</script>
</body>
</html>