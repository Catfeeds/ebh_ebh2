<?php $this->display('troomv2/page_header'); ?>
<style>
    em{
        font-style: italic;
    }
    .huide strong em{
        font-weight: bold;
    }
    .huide em strong{
        font-style: italic;
    }
    strong{
        font-weight: bold;
    }
</style>
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/tzds.css" rel="stylesheet" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/troomv2/css/wussyu.css"/>
	<div class="lefrig">
		<div class="work_mes">
			<ul>
				<li class="workcurrent"><a href="<?= geturl('troomv2/notice/send') ?>">发通知</a></li>
				<li><a href="<?= geturl('troomv2/notice') ?>">我接收的</a></li>
				<li><a href="<?= geturl('troomv2/notice/sent') ?>">我发送的</a></li>
			</ul>
		</div>
		<div style="clear:both;"></div>
		<form id="noticeform" method="POST" name="noticeform" style="height:720px;">
		<input type="hidden" value="<?= $notice['noticeid'] ?>" name="noticeid" />
			<span class="shouaj">收件人：</span>
			<div class="kuisrtrt">
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
			<span class="shouaj">主题：</span>
			<input id="noticetitle" class="wkemtxt" name="noticetitle" type="text" maxLength="30" value="<?= $notice['title'] ?>" onfocus="if(value=='请输入标题,不能超过30个字'){value=''}" />
<!--            <p id="msgcontent" class="hirleres">不能超过600个字</p>-->
			<span  class="shouaj">内容：</span>
			<div class="uhuwet"><textarea id="noticecontent" name="noticecontent" style="width:800px;height:362px;"></textarea>
			<?php
			$editor->xEditor('noticecontent', '800px', '362px',$notice['message']);
			?>
			</div>
			<p id="msgcontent" class="hirleres">不能超过600个字</p>
			<a href="javascript:void(0)" class="lustbart sendnotice">发 送</a>
		</form>
	</div>
<script type="text/javascript">
	$(".sendnotice").click(function(){
		var str = new Array();
		$(".fiorel input:checkbox:checked").each(function(i){
			str[i] = $(this).val();
		});
		if (str.length==0) {
			var d = top.dialog({
			title: '信息提示',
			content: '收件人不能为空',
			cancel: false,
			okValue:"确定",
			ok: function () {
				this.close().remove();
			}
		});
		d.showModal();
		return;};

		if($("#noticetitle").val().length<=0 || $("#noticetitle").val().length>30 || $("#noticetitle").val()=="请输入标题,不能超过30个字"){
			$("#msgtitle").html('<font style="color:#f00;">标题不能为空且不能超过30个字</font>');
			return;
		}
		var noticecontent = UE.getEditor('noticecontent').getContent();
		if(HTMLDeCode(noticecontent).replace(/[\s]*<[^>]+>/g,"").length<=0 || HTMLDeCode(noticecontent).replace(/[\s]*<[^>]+>/g,"").length>600){
			$("#msgcontent").html('<font style="color:#f00;">内容不能为空且不能超过600个字</font>');
			return;
		}
		var d = dialog({
        title: '确定发送',
        content: '您确定要修改并发送该消息通知吗？',
        okValue: '确定',
        ok: function () {
			var url = "<?= geturl('troomv2/notice/edit') ?>";
			$.ajax({
				type:'POST',
				url:url,
				data:$("#noticeform").serialize(),
				dataType:'json',
				success:function(msg){
					if(msg == 1){
						dialog({
							skin:"ui-dialog2-tip",
							content:"<div class='TPic'></div><p>修改通知成功</p>",
							width:350,
							onshow:function () {
								var that=this;
								setTimeout(function () {
									window.location.href="<?= geturl('troomv2/notice/sent') ?>";
									that.close().remove();
								}, 1000);
							}
						}).show();
					}else{
						dialog({
							skin:"ui-dialog2-tip",
							content:"<div class='FPic'></div><p>修改通知失败，请稍后再试或联系管理员。</p>",
							width:350,
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
    });
    d.showModal();
	});
	$("#noticetitle").blur(function(){
//		if(!($("#noticetitle").val().length<=0 || $("#noticetitle").val().length>30)){
//			$("#msgtitle").html('不超过30个字');
//		}else{
//			$("#msgtitle").html('<font style="color:#f00;">标题不能为空且不能超过30个字</font>');
//		}
        if($("#noticetitle").val()==""){
            $("#noticetitle").val('请输入标题,不能超过30个字')
        }

	});
//    $("#noticetitle").click(function(){
//        if(("#noticetitle").val()=="请输入标题,不能超过30个字"){
//            $("#noticetitle").value="";
//        }
//    })
	$("#noticecontent").blur(function(){
		var noticecontent = UM.getEditor('noticecontent').getContent();
		if(!(HTMLDeCode(noticecontent).replace(/[\s]*<[^>]+>/g,"").length<=0 || HTMLDeCode(noticecontent).replace(/[\s]*<[^>]+>/g,"").length>600||noticecontent.indexOf("img")==-1)){
			$("#msgcontent").html('不超过600个字');
		}else{
			$("#msgcontent").html('<font style="color:#f00;">内容不能为空且不能超过600个字</font>');
		}
	});

</script>

</body>
</html>
