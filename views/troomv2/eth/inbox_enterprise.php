<?php $this->display('troomv2/page_header'); ?>
<style>
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
<style>
  .waitite2{
    margin-left: 16px;
  }
  .enterprise{

  }
  .enterprise ul li{
    margin: 0;
    font-size: 14px;
  }
  .enterprise .workcurrent a{
    background: none;
  }
  .enterprise a.title-a .jnisrso{ 
    font-size: 14px;
    color: #777;
    background: none;
  }
  .enterprise .showtap a.title-a{
    background:url(http://static.ebanhui.com/ebh/tpl/default/images/workcurrent.jpg) no-repeat right 0px;
  }
  .enterprise .showtap a.title-a .jnisrso{
    background:url(http://static.ebanhui.com/ebh/tpl/default/images/workcurrent.jpg) left 0px no-repeat;
    color: #4c88ff;
  }
</style>
<div class="lefrig">
	<div class="waitite waitite2">
	<div class="work_menu enterprise" style="position:relative;margin-top:0">
		<ul>
			<li class="workcurrent "><a href="/troomv2/eth.html" class="title-a"><span class="jnisrso">发消息</span></a></li>
	        <li class="workcurrent "><a href="/troomv2/eth/history.html" class="title-a"><span class="jnisrso">详情</span></a></li>
	        <li class="workcurrent showtap"><a href="javascript:void(0)" class="title-a"><span class="jnisrso">收件箱</span></a></li>
	        <li class="workcurrent "><a href="/troomv2/eth/bind.html" class="title-a"><span class="jnisrso">绑定情况</span></a></li>
		</ul>
	</div>
	       <!--  <div class="hsidts" style="width:205px">
            <a class="lasrnwe" href="/troomv2/eth.html">发消息</a>
            <a class="lasrnwe" href="/troomv2/eth/history.html">发信历史</a>
            <a class="lasrnwe" href="/troomv2/eth/bind.html">绑定情况</a>
        	</div> -->
	</div>
    <div class="sjxlist">
    <?php if(!empty($inboxList)){
    $maxkey = count($inboxList) - 1;
    foreach($inboxList as $key => $inbox){
    	?>
    	<div class="sjxlist1 sjxlist1s" <?php if($key == $maxkey) echo ' style="border-bottom:none;"';?>>
            <div class="txxm">
                <div style="float:left; margin-right:10px;"><a title="<?=getusername($inbox)?>" href="javascript:;"><img style="width:40px;height:40px; border-radius:20px;" src="<?=getavater($inbox,'50_50')?>"></a></div>
                <div style="width:130px;float:left;">
                    <span class="renming"><?=$inbox['realname']?>
                    <?php if($inbox['sex']==1){?>
                    <img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/women.png">
                    <?php }else{?>
                    <img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/man.png">
                    <?php }?>
                    </span>
                    <div style="clear:both;"></div>
                    <span class="renming1"><?=$inbox['username']?></span>
                </div>
                <div class="sjsj"><?=date("Y-m-d H:i",$inbox['dateline'])?></div>
            </div>
            <p class="sjsj sjsj1s"><?=strip_tags($inbox['message'])?></p>
            <?php if (empty($inbox['isreply'])){?>
            <a href="<?=geturl('troomv2/eth/inbox/reply/'.$inbox['inid']).'?rurl='.$this->uri->path?>" class="waskes waskes1s">回复</a>
            <?php } else {?>
            <a href="<?=geturl('troomv2/eth/inbox/'.$inbox['inid']).'?rurl='.$this->uri->path?>" class="waskes waskes1s">查看</a>
            <?php }?>
            <a href="javascript:;" onclick="delinbox(this)" class="delsc" data-inid="<?=$inbox['inid']?>" >删除</a>
        </div>
        <div class="clear"></div>
    <?php }}else{?>
    <div class="nodata"></div>
    <?php }?>

    </div>
</div>
<?=$pagestr?>

<input type="hidden" name="inid" id="inid" value="0" />
<script type="text/javascript">
function delinbox(obj) {
	//console.log();
	$("#inid").val($(obj).data('inid'));
	/*var button = new xButton();
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

	H.get('dialogdel').exec('show');*/

	top.dialog({
	title:"删除消息",
	content:"确定要删除消息吗",
	cancel:function(){
		this.close().remove();
		return false;
	},
	cancelValue:"取消",
	okValue:"确定",
	ok:function(){
		this.close().remove();
		savedel();
		return false;
	}
	}).showModal();
}
function savedel(){
	var inid = $("#inid").val();
	$.ajax({
		type:'post',
		url:"<?=geturl('troomv2/eth/delinbox')?>",
		dataType:'json',
		data:{'inid':inid},
		success:function(data){
			dialogtip();
			if(data!=undefined && data!=null && data==1){
				// H.get('xtips').exec('setContent','删除成功').exec('show').exec('close',500);
				dialog({
		        skin:"ui-dialog2-tip",
		        width:350,
		        content: "<div class='TPic'></div><p>删除成功</p>",
				onshow:function () {
					var that=this;
					setTimeout(function () {
						that.close().remove();
				        window.location.reload();
					},1000);
				}
				}).show();
			}else{
				// H.get('xtips').exec('setContent','删除失败').exec('show').exec('close',500);
				dialog({
		        skin:"ui-dialog2-tip",
		        width:350,
		        content: "<div class='FPic'></div><p>删除失败</p>",
				onshow:function () {
					var that=this;
					setTimeout(function () {
						that.close().remove();
					},1000);
				}
				}).show();
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
