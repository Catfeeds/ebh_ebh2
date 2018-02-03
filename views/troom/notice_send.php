<?php $this->display('troom/page_header'); ?>
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/tzds.css" rel="stylesheet" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xform.js?v=1"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<style>
.wkemtxt{ border:1px solid #ccc; box-shadow: 0 0 6px #e0e0e0;}
</style>
	<div class="ter_tit"> 当前位置 > <a href="<?= geturl('troom/notify') ?>">通知管理</a> > 发送通知</div>
	<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:788px;">
		<div class="work_mes">
			<ul>

				<li><a href="<?= geturl('troom/notice') ?>"><span>通知列表</span></a></li>
				<li class="workcurrent"><a href="<?= geturl('troom/notice/send') ?>"><span>发送通知</span></a></li>
			</ul>
		</div>
		<form id="noticeform" method="POST" name="noticeform">
			<span class="shouaj" style="margin-top:5px;">收件人：</span>
			<div style="float:left;width:720px; line-height:27px;">
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
			<p style="margin-left:15px;">标题：<span id="msgtitle" style="color:#999;"></span></p>
			<div id="biaoti">
			<input id="noticetitle" style="margin-left:15px;" class="wkemtxt" name="noticetitle" type="text" maxLength="30" value="" x_hit="请输入标题,不能超过30个字"/>
			</div>
			<p style="margin-left:15px;">内容：<span id="msgcontent" style="color:#999;">不能超过600个字</span></p>
			<div style="margin-left:15px;">
			<?php
			$editor->xEditor('noticecontent', '746px', '362px');
			?></div>
			<a href="javascript:;" class="lanbbtn sendnotice" style="margin-top:10px;margin-left:15px;">发 送</a>
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
	$(".sendnotice").click(function(){
		var str = new Array();
		$(".fiorel input:checkbox:checked").each(function(i){
			str[i] = $(this).val();
		});
		if (str.length==0) {alert("请选择接收人！");return;};

		if($("#noticetitle").val().length<=0 || $("#noticetitle").val().length>30){
			$("#msgtitle").html('<font style="color:#f00;">标题不能为空且不能超过30个字</font>');
			return;
		}
		var noticecontent = UM.getEditor('noticecontent').getContent();
		if(HTMLDeCode(noticecontent).replace(/[\s]*<[^>]+>/g,"").length<=0 || HTMLDeCode(noticecontent).replace(/[\s]*<[^>]+>/g,"").length>600){
			$("#msgcontent").html('<font style="color:#f00;">内容不能为空且不能超过600个字</font>');
			return;
		}
		$.confirm("发送确认","您确定要发送这个通知消息吗?",function(){
			var url = "<?= geturl('troom/notice/send') ?>";
			$.ajax({
				type:'POST',
				url:url,
				data:$("#noticeform").serialize(),
				dataType:'json',
				success:function(msg){
					if(msg == 1){
						$.showmessage({
                            img : 'success',
                            message:'发送通知成功',
                            title:'发送通知',
                            callback :function(){
                                 window.location.href="<?= geturl('troom/notice') ?>";
                            }
                        });
						
					}else{
						$.showmessage({
                            img : 'error',
                            message:'发送通知失败，请稍后再试或联系管理员。',
                            title:'发送通知'
                        });
					}
				}
			});
		});
		
	});
	$("#noticetitle").blur(function(){
		if(!($("#noticetitle").val().length<=0 || $("#noticetitle").val().length>30 || $("#noticetitle").val()=='请输入标题,不能超过30个字')){
			$("#msgtitle").html('');
		}else{
			$("#msgtitle").html('<font style="color:#f00;">标题不能为空且不能超过30个字</font>');
		}
	});
	$("#noticecontent").blur(function(){
		var noticecontent = UM.getEditor('noticecontent').getContent();
		if((HTMLDeCode(noticecontent).replace(/[\s]*<[^>]+>/g,"").length<=0 || HTMLDeCode(noticecontent).replace(/[\s]*<[^>]+>/g,"").length>600)){
			$("#msgcontent").html('<font style="color:#f00;">内容不能为空且不能超过600个字</font>');
		}else{
			$("#msgcontent").html('不超过600个字');
		}
	});
	
</script>
</body>
</html>