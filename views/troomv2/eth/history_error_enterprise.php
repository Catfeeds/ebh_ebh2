<?php $this->display('troomv2/page_header'); ?>
<style>
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
        .huerdfr{
            height:280px;           
            overflow-y: auto;
        }
        .nodata{
            min-height: 258px;
            overflow-y:auto;
        }
</style>
<div class="lefrig">
    <div class="waitite">
        <div class="work_menu" style="position:relative;margin-top:0">
			<ul>
				<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso">发送状态</span></a></li>
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
            <li class="workcurrent">
                <a href="<?=geturl("troomv2/eth/history/error/".$mid)?>">
                <span>发送状态</span>
                </a>
            </li>
            <li>
                <a href="<?=geturl("troomv2/eth/history/tong/".$mid)?>">
                <span>统计分析</span>
                </a>
            </li>
            <li>
                <a href="<?=geturl("troomv2/eth/history/reply/".$mid)?>">
                <span>查看回复（<?=$replycount?>）</span>
                </a>
            </li>
        </ul>
    </div>
    <div id="icategory" class="clearfix" style="border-top:none;margin:10px;float:left;">
        <dl style="float:left;display:inline;width:595px; *width:500px;">
            <dd>
                <div class="category_cont1">
                    <div>
                    <a class="<?=empty($type)?"curr":""?>" href="<?=geturl("troomv2/eth/history/error/view-0-0-0-".$mid."-0")?>">全部</a>
                    </div>
                    <div>
                    <a class="<?=($type=='1')?"curr":""?>" href="<?=geturl("troomv2/eth/history/error/view-0-0-0-".$mid."-1")?>">发送成功</a>
                    </div>
                    <div>
                    <a class="<?=($type=='2')?"curr":""?>" href="<?=geturl("troomv2/eth/history/error/view-0-0-0-".$mid."-2")?>">发送失败</a>
                    </div>
                </div>
            </dd>
        </dl>
    </div>
    <style>
        .tableBox{
            height: 375px;
            width: 100%;
            overflow-y:auto;
            border-top: 1px solid #f3ebeb;
            border-bottom: 1px solid #f3ebeb;         
        }
    </style>
    <div class="tableBox">
        <table class="datatab" width="100%" style="border:none;">
            <tbody>
            <?php if (!empty($inboxList)){
            $maxkey = count($inboxList) - 1;
            foreach ($inboxList as $key => $inbox){?>
                <tr class="">
                    <td width="25%" <?php if($key == $maxkey) echo ' style="border-bottom:none;"';?>>
                        <a title="<?=getusername($inbox)?>" href="javascript:;" style="float:left;">
                        <img class="imgyuan" src="<?=getavater($inbox,'50_50')?>">
                        </a>
                        <p class="ghjuts">
                        <?=$inbox['realname']?>
                        <?php if($inbox['sex']==1){?>
                        <img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/women.png">
                        <?php }else{?>
                        <img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/man.png">
                        <?php }?>
                        </p>
                        <p class="ghjuerts"><?=$inbox['username']?></p>
                        <p class="ghjus"><?=date("Y-m-d H:i",$inbox['dateline'])?></p>
                    </td>
                    <td width="65%" <?php if($key == $maxkey) echo ' style="border-bottom:none;"';?>><?=strip_tags($inbox['message'])?></td>
                    <td width="10%" style="text-align:center;<?php if($key == $maxkey) echo 'border-bottom:none;';?>">
                        <?=empty($inbox['status'])?'<span style="color:#f85c72">发送失败</span>':'<span style="color:#5e96f5">发送成功</span>'?>
                    </td>
                </tr>
            <?php } } else {?>
                <tr class="" style="background-color: #fff;">
                    <td colspan="3" style="border-bottom:none;text-align:center;">
                    <div class="nodata"></div>
                    </td>
                </tr>
            <?php }?>
            </tbody>
        </table>
    </div>
    <?=$pagestr?>
</div>

<input type="hidden" name="inid" id="inid" value="0" />
<!--删除对话框-->
<div id="dialogdel" style="display:none">
	<div class="dialogcont">
		<div class="tishi mt40"><p>确定要删除该消息吗?</p></div>
	</div>
</div>
<script type="text/javascript">
function delinbox(obj) {
	//console.log();
	$("#inid").val($(obj).data('inid'));
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
			title: '删除消息',
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
	var inid = $("#inid").val();
	$.ajax({
		type:'post',
		url:'<?=geturl('troomv2/eth/delinbox')?>',
		dataType:'json',
		data:{'inid':inid},
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