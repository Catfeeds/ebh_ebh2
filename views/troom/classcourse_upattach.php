<?php $this->display('troom/page_header'); ?>
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
</style>
<div class="ter_tit">
当前位置 > <a href="<?= geturl('troom/classsubject') ?>" ?>课程管理</a> > <a href="<?= geturl('troom/classsubject') ?>" >班级课程</a> > <a href="<?= geturl('troom/classsubject/'.$course['folderid'])?>"><?= $course['foldername'] ?></a> > 上传附件
</div>
<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:788px;">
	<div class="user_config" style="width:755px;">
	<form id="upform">
	<input type="hidden" value="<?= $course['cwid'] ?>" name="cwid" />
	<table class="uct" width="100%">
	<tr>
		<th>课件名称：</th>
		<td>
			<p style="font-size:14px; padding-top:4px; _padding-top:1px;"><?= $course['title'] ?></p>
			
		</td>
	</tr>
	  
	<tr>

		<th valign="top">附件上传：</th>
		<td>
			<?php Ebh::app()->lib('Webuploader')->renderHtml('up',true); ?>
			<span class="ts2" id="att_msg">可以直接选取多个文件,单次最多选取10个，且单个文件大小不超过500M。</span>
		</td>
	</tr>
	
	</table>
	<div id="tables" style="margin-left:30px;"></div>
	</form>
	</div>
	<div id="buttonbar" style="margin-left:100px;">
	<input class="huangbtn" name="" type="button" value="提 交" />
			<input type="button" value="返 回" onclick="window.location='javascript:history.go(-1)'"  class="lanbtn marlef">
	</div>
</div>

<script type="text/javascript">
	$(function(){
		$(".huangbtn").click(function(){
			if(check_attachment()) {
				$(".huangbtn").val('上传中');
				$(".huangbtn").attr('disabled',true);
				$(".huangbtn").css('cursor','default');
				$(".huangbtn").css('background','#cdcdcd');
				submitform();
			}
		});
	});
		function submitform() {
			var url="<?= geturl('troom/classcourse/upattach') ?>";
			$.ajax({
				url:url,
				type:"post",
				dataType:"json",
				data:$("#upform").serialize(),
				success:function(data){
					if(data != undefined && data.status == 1) {
						$.showmessage({
							img		 : 'success',
							message  :  '附件上传成功',
							title    :      '附件上传',
							callback :    function(){
								var backurl = "<?= geturl('troom/classsubject/'.$course['folderid'])?>";
								document.location.href = backurl;
							}
						});
					} else {
						var message = "附件上传失败";
						$.showmessage({
							img		:'error',
							message :message,
							title   :'附件上传'
						});

						$(".huangbtn").val('提 交');
						$(".huangbtn").removeAttr('disabled');
						$(".huangbtn").css('background','');
					}
				}
			});
		}
		function check_attachment() {
			var uploadfile = $(".up_sid");
			if (uploadfile == null || uploadfile.length == 0 || uploadfile.val() == "") {
				alert("您还没有上传附件文件。");
				return false;
			}
			return true;
		}
</script>
<?php $this->display('troom/page_footer'); ?>