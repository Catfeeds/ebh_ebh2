<?php $this->display('troomv2/page_header'); ?>
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/tzds.css" rel="stylesheet" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xform.js?v=1"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/troomv2/css/wussyu.css"/>
<style>
</style>
	<div class="lefrig">
		<div class="work_mes">
			<ul>
				<li class="workcurrent"><a href="<?= geturl('troomv2/notice/send') ?>">发通知</a></li>
				<li><a href="<?= geturl('troomv2/notice') ?>">我接收的</a></li>
				<li><a href="<?= geturl('troomv2/notice/sent') ?>">我发送的</a></li>
			</ul>
		</div>
		<div style="clear:both;"></div>
		<form id="noticeform" method="POST" name="noticeform">
			<span class="shouaj">收件人：</span>
			<div class="kuisrtrt">
				<?php if(!empty($classlist)) { ?>
				<ul>
					<?php foreach($classlist as $myclass) { ?>
					<li class="fiorel" title="<?= $myclass['classname'] ?>"><input id="noticeto_<?= $myclass['classid'] ?>" name="noticeto[]" cname="<?= $myclass['classname'] ?>" style="float:left;margin:8px 5px 0 0;*margin-top:4px;" type="checkbox" value="<?= $myclass['classid'] ?>" /><label for="noticeto_<?= $myclass['classid'] ?>"><?= shortstr($myclass['classname'],13) ?></label></li>
					<?php } ?>
	
				</ul>
				<?php } else { ?>
				您还未分配任何班级，请联系管理员给您的教师账号分配班级信息。
				<?php } ?>

			</div>
			<div style="clear:both;"></div>
			<span class="shouaj">主题：</span>
			<div id="biaoti">
			<input id="noticetitle" class="wkemtxt" name="noticetitle" type="text" maxLength="30" value="" x_hit="请输入1-30概括性文字"/>
			</div>
<!--            <p id="msgtitle" class="hirleres">标题不能为空且不能超过30个字</p>-->
			<span  class="shouaj">内容：</span>
			<div class="uhuwet">
			<?php
			$editor->xEditor('noticecontent', '830px', '362px');
			?></div>
			<p id="msgcontent" class="hirleres">不能超过600个字</p>
			<a href="javascript:;" class="lustbart sendnotice" >发 送</a>
		</form>
	</div>
</div>

<script type="text/javascript">
	var _xform = new xForm({
		domid:'biaoti',
		errorcss:'cuotic',
		okcss:'zhengtic',
		showokmsg:false
	});
	var confirm_send = false;
	$(".sendnotice").click(function(){
		var str = new Array();
		$(".fiorel input:checkbox:checked").each(function(i){
			str[i] = $(this).val();
		});
		if (str.length==0) {
			top.dialog({
		    title: '提示',
		    content: '请选择接收人！',
		    cancel: false,
		    okValue: '确定',
		    ok: function () {        
		    }
		}).showModal();

			return;};

		if($("#noticetitle").val().length<=0 || $("#noticetitle").val().length>30 || $("#noticetitle").val()=="请输入1-30概括性文字"){
			$("#msgtitle").html('<font style="color:#f00;">标题不能为空且不能超过30个字</font>');
			return;
		}
		var noticecontent = UE.getEditor('noticecontent').getContent();
		if((HTMLDeCode(noticecontent).replace(/[\s]*<[^>]+>/g,"").length<=0 || HTMLDeCode(noticecontent).replace(/[\s]*<[^>]+>/g,"").length>600)&&noticecontent.indexOf("img")==-1){
			console.log(noticecontent.indexOf("img"));
			$("#msgcontent").html('<font style="color:#f00;">内容不能为空且不能超过600个字</font>');
			return;
		}
		top.dialog({
			title: '发送确认',
			content: '您确定要发送这个通知消息吗?',
			okValue: '确定',
			ok: function () {
				if (confirm_send === true) {
					return;
				}
				confirm_send = true;
				var url = "<?= geturl('troomv2/notice/send') ?>";
				$.ajax({
					type:'POST',
					url:url,
					data:$("#noticeform").serialize(),
					dataType:'json',
					success:function(msg){
						if(msg == 1){
							window.location.href="<?= geturl('troomv2/notice/sent') ?>";
						}else{
							confirm_send = false;
			                top.dialog({
						        skin:"ui-dialog2-tip",
						        width:350,
						        content: "<div class='FPic'></div><p>发送通知失败，请稍后再试或联系管理员。</p>",
								onshow:function () {
									var that=this;
									setTimeout(function () {
										that.close().remove();
									}, 2000);
								}
							}).show();
						}
					}
				});
	        },
		    cancelValue: '取消',
			cancel: function () {}
		}).showModal();
	});
	$("#noticetitle").blur(function(){
		if(!($("#noticetitle").val().length<=0 || $("#noticetitle").val().length>30 || $("#noticetitle").val()=='请输入1-30概括性文字')){
			$("#msgtitle").html('');
		}else{
			$("#msgtitle").html('<font style="color:#f00;">标题不能为空且不能超过30个字</font>');
		}
	});
	$("#noticecontent").blur(function(){
		var noticecontent = UE.getEditor('noticecontent').getContent();
		if((HTMLDeCode(noticecontent).replace(/[\s]*<[^>]+>/g,"").length<=0 || HTMLDeCode(noticecontent).replace(/[\s]*<[^>]+>/g,"").length>600)&&noticecontent.indexOf("img")==-1){
			$("#msgcontent").html('<font style="color:#f00;">内容不能为空且不能超过600个字</font>');
		}else{
			$("#msgcontent").html('不超过600个字');
		}
	});
	
</script>
</body>
</html>