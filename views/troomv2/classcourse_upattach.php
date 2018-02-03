<?php $this->display('troomv2/page_header'); ?>
<link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/teacher.css" rel="stylesheet" />	
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/upload.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/webuploader/webuploader.css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/webuploader/webuploader.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/webuploader/uploadv2.min.js"></script>
<style>
.uct th {
width: 90px;
text-align: right;
padding: 15px 5px 15px 0;
font-weight: lighter;
font-size: 12px;
}
.uploadbox {
	width:800px;
}
.btncancel{
	cursor:pointer;
}
.toolbar{
	margin-top:7px;
}
.user_config{
	width:100%;
}
</style>
<div class="lefrig" style="padding-bottom:42px;">
<?php 
$dialog = $this->input->get('dialog');
if(empty($dialog)){
	$this->display('troomv2/course_menu');
}?>
	<div class="user_config">
	<form id="upform">
	<input type="hidden" value="<?= $course['cwid'] ?>" name="cwid" />
	<table class="uct" width="100%">
	<tr>
		<th>课件名称：</th>
		<td>
			<p style="font-size:14px; padding-top:0; _padding-top:1px;"><?= $course['title'] ?></p>
			
		</td>
	</tr>
	  
	<tr>

		<th valign="top">附件上传：</th>
		<td>
			<?php Ebh::app()->lib('Webuploader')->renderHtml('up',true); ?>
			<span class="ts2" id="att_msg">可以直接选取多个文件，单次最多选取10个，总文件大小不超过1000M。</span>
		</td>
	</tr>
	
	</table>
	<div id="tables" style="margin-left:30px;"></div>
	</form>
	</div>
	<div id="buttonbar" style="margin-left:20px;">
		<input class="fstiewes _huangbtn" name="" type="button" value="提 交" />
		<input type="button" value="返 回" onclick="parent.window.dialog.get('coleck').remove();"  class="wrkrshui">
	</div>
</div>
<script type="text/javascript">
	$(function(){
		$("._huangbtn").click(function(){
			if(check_attachment()) {
				$("._huangbtn").val('上传中');
				$("._huangbtn").attr('disabled',true);
				$("._huangbtn").css('cursor','default');
				$("._huangbtn").css('background','#cdcdcd');
				submitform();
			}
		});
	});
		function submitform() {
			var url="<?= geturl('troomv2/classcourse/upattach') ?>";
			$.ajax({
				url:url,
				type:"post",
				dataType:"json",
				async:false,
				data:$("#upform").serialize(),
				success:function(data){
					if(data != undefined && data.status == 1) {
						dialog({
							skin:"ui-dialog2-tip",
							content:"<div class='TPic'></div><p>附件上传成功！</p>",
							width:350,
							onshow:function () {
								var that=this;
								setTimeout(function () {
									<?php $selfrefresh = $this->input->get('selfrefresh');
									if(empty($selfrefresh)){?>
									var mframe = $('#mainFrame',window.parent.document)
									mframe[0].contentDocument.location.reload();
									window.open("<?=geturl('troomv2/course/'.$course['cwid']) ?>#upduce","_blank");
									parent.window.dialog.get('coleck').remove();
									<?php }else {?>
									window.parent.location.reload();
									<?php }?>
								}, 1000);
							}
						}).show();
					} else {
						dialog({
							skin:"ui-dialog2-tip",
							content:"<div class='FPic'></div><p>附件上传失败！</p>",
							width:350,
							onshow:function () {
								var that=this;
								setTimeout(function () {
									that.close().remove();
								}, 1000);
							}
						}).show();
						$("._huangbtn").val('提 交');
						$("._huangbtn").removeAttr('disabled');
						$("._huangbtn").css('background','');
					}
				}
			});
		}
		function check_attachment() {
			var uploadfile = $(".up_sid");
			if (uploadfile == null || uploadfile.length == 0 || uploadfile.val() == "") {
					var d = top.dialog({
					title: '提示',
					content: '您还没有上传附件文件。',
					cancel: false,
					okValue: '确定',
					ok: function () {}
				});
				d.showModal();
				return false;
			}
			return true;
		}
</script>
