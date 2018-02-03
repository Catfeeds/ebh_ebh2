<?php $this->display('troom/page_header'); ?>
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/tzds.css" rel="stylesheet" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
	<div class="ter_tit"> 当前位置 > <a href="<?= geturl('troom/notify') ?>">通知管理</a> > > <a href="<?= geturl('troom/notice')?>">通知列表</a> > 修改通知并发送 </div>
	<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:788px;">
		<div class="work_mes">
			<ul>
				<li><a href="<?= geturl('troom/notice') ?>"><span>通知列表</span></a></li>
				<li class="workcurrent"><a href="<?= geturl('troom/notice/send') ?>"><span>发送通知</span></a></li>
			</ul>
		</div>
		<form id="noticeform" method="POST" name="noticeform">
		<input type="hidden" value="<?= $notice['noticeid'] ?>" name="noticeid" />
			<span class="shouaj" style="margin-top:5px;">收件人：</span>
			<div style="float:left;width: 715px;">
				<?php if(!empty($classlist)) { ?>
				<ul>
					
					<?php foreach($classlist as $myclass) { ?>
					<li class="fiorel" title="<?= $myclass['classname'] ?>"><input name="noticeto[]" id="noticeto_<?= $myclass['classid'] ?>" cname="<?= $myclass['classname'] ?>" style="float:left;margin:8px 5px 0 0;*margin-top:4px;" type="checkbox" value="<?= $myclass['classid'] ?>" /><label for="noticeto_<?= $myclass['classid'] ?>"><?= shortstr($myclass['classname'],13) ?></label></li>
	
					<?php } ?>
				</ul>
				<?php } ?>
				
				<script type="text/javascript">
					var str = '<?= $notice["cids"] ?>';
					var arr = str.split(",");
					for (var i = 0; i < arr.length; i++) {
						$("#noticeform input:checkbox[value="+arr[i]+"]").attr("checked","checked");
					};
				</script>
			</div>
			<p style="margin-left:15px;">标题：<span id="msgtitle" style="color:#999;">不能超过30个字</span></p>
			<input style="margin-left:15px;" id="noticetitle" class="wkemtxt" name="noticetitle" type="text" maxLength="30" value="<?= $notice['title'] ?>" />
			<p style="margin-left:15px;">内容：<span id="msgcontent" style="color:#999;">不能超过600个字</span></p>
			<div style="margin-left:15px;">
			<?php
			$editor->xEditor('noticecontent', '746px', '362px',$notice['message']);
			?>
			</div>
			<a href="javascript:void(0)" class="lanbbtn sendnotice" style="margin-top:10px;margin-left:15px;">发 送</a>
		</form>
	</div>
<script type="text/javascript">
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
		$.confirm("确定发送","您确定要发送修改后这个消息通知吗?",function(){
			var url = "<?= geturl('troom/notice/edit') ?>";
			$.ajax({
				type:'POST',
				url:url,
				data:$("#noticeform").serialize(),
				dataType:'json',
				success:function(msg){
					if(msg == 1){
						$.showmessage({
                            img : 'success',
                            message:'修改通知成功',
                            title:'修改通知',
                            callback :function(){
                                 window.location.href="<?= geturl('troom/notice') ?>";
                            }
                        });
						
					}else{
						$.showmessage({
                            img : 'error',
                            message:'修改通知失败，请稍后再试或联系管理员。',
                            title:'修改通知'
                        });
					}
				}
			});
		});
		
	});
	$("#noticetitle").blur(function(){
		if(!($("#noticetitle").val().length<=0 || $("#noticetitle").val().length>30)){
			$("#msgtitle").html('不超过30个字');
		}else{
			$("#msgtitle").html('<font style="color:#f00;">标题不能为空且不能超过30个字</font>');
		}
	});
	$("#noticecontent").blur(function(){
		var noticecontent = UM.getEditor('noticecontent').getContent();
		if(!(HTMLDeCode(noticecontent).replace(/[\s]*<[^>]+>/g,"").length<=0 || HTMLDeCode(noticecontent).replace(/[\s]*<[^>]+>/g,"").length>600)){
			$("#msgcontent").html('不超过600个字');
		}else{
			$("#msgcontent").html('<font style="color:#f00;">内容不能为空且不能超过600个字</font>');
		}
	});
	
</script>

</body>
</html>
