<?php $this->display('troomv2/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xform.js?v=1"></script>
<div class="lefrig">
	<div class="waitite">
		<div class="work_menu" style="position:relative;margin-top:0">
			<ul>
				<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso">收件箱（回复）</span></a></li>
			</ul>
		</div>
	</div>
    <div class="sjxhf" id="hitdiv">
    <form name="forminbox" id="forminbox" action="" method="post">
    	<div class="sjrfa">
        	<p class="sjrs">发件人：<?=$inbox['send_user']?></p>
            <div style="color: #666; font-family: 微软雅黑; font-size: 14px;margin-top:10px;" id="quote"><?=$inbox['message']?></div>
        </div>
		<textarea id="comment" class="hfxxs" x_hit="请输入回复的内容..."></textarea>
        <div class="anniubtn">
        	<a href="<?=geturl($this->input->get('rurl'))?>" class="fhanbtn">返&nbsp;回</a>
            <a href="javascript:;" id="submit" class="fsanbtn">发&nbsp;送</a>
        </div>
        <input type="hidden" name="inid" id="inid" value="<?=$inbox['inid']?>" />
        <input type="hidden" name="mid" id="mid" value="<?=$inbox['mid']?>" />
        <input type="hidden" name="touid" id="touid" value="<?=$inbox['send_uid']?>" />
    </form>
    </div>
</div>
<script>
var _xform = new xForm({
	domid:'hitdiv',
	errorcss:'cuotic',
	okcss:'zhengtic',
	showokmsg:false
});

//发送回复
var submitFlag = true;
$("#submit").click(function(){
	if(!H.get('xtips')){
		H.create(new P({
			id:'xtips',
			easy:true,
			padding:10
		}),'common');
	}

	var comment = $("#comment").val();
	if (comment == '' || comment == '请输入回复的内容...'){
		// alert('请输入回复的内容');
		top.dialog({
			title:"提示信息",
			content:"请输入回复的内容",
			okValue:"确定",
			ok:function () {
				setTimeout(function () {
		        $("#comment").val("");
		        $("#comment").focus();
				},1);
			}
		}).showModal();

		return false;
	}
	
	if (submitFlag) {
		submitFlag = false;
	} else {
		return false;
	}

	var inid = $("#inid").val();
	var mid = $("#mid").val();
	var touid = $("#touid").val();
	var quote= $("#quote").html();
	$.ajax({
		type:'post',
		url:'<?=geturl('troomv2/eth/savereply')?>',
		dataType:'json',
		data:{'inid':inid,'mid':mid,'comment':comment,'quote':quote,'touid':touid},
		success:function(data){
			submitFlag = true;
			if(data!=undefined && data!=null && data==1){
				H.get('xtips').exec('setContent','发送成功').exec('show').exec('close',500);
				rurl = $(".fhanbtn").attr("href");
				setTimeout(function(){
					window.location.href = rurl;
				},500);
			}else{
				H.get('xtips').exec('setContent','发送失败').exec('show').exec('close',500);
			}
		},
		error:function(){
			alert("服务器连接错误，请重试");
		}
	});

});
</script>
</body>
</html>