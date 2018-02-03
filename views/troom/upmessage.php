<?php $this->display('troom/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
	<div class="wrap">
		<div class="cmain clearfix">
        	<table class="room_info_tab" width="100%">
        		<tr>
        		    <td>
                        <?php
                        $editor->xEditor('message','960px','640px',$myroom['message']);
                        ?>
					</td>
        		</tr>
        		<tr>
    			  	<td align="right">
				    	<input class="crupBtn lightbtn" style="cursor:pointer;margin-top:10px;" onclick="showresult(0)" value="取消" type="button" />
				    	<input class="crupBtn lightbtn" style="cursor:pointer;margin-top:10px;" value="确定" type="button" onclick="upmessage()"/>
				    </td>
        		</tr>
    		</table>
		</div>
	</div>
<script type="text/javascript">
function upmessage()
{
	var message = UM.getEditor('message').getContent();
	$.ajax({
		url:"<?= geturl('troom/setting/upinfo') ?>",
		type:'post',
		data:{'message':message},
		dataType:'text',
		success:function(data){
			if(data=='success'){
				dialog({
					skin:"ui-dialog2-tip",
					content:"<div class='TPic'></div><p>平台详细介绍修改成功</p>",
					width:350,
					onshow:function () {
						var that=this;
						setTimeout(function() {
							showresult(1);
							that.close().remove();
						}, 1000);
					}
				}).show();
			}else{
				dialog({
					skin:"ui-dialog2-tip",
					content:"<div class='FPic'></div><p>平台详细介绍修改失败</p>",
					width:350,
					onshow:function () {
						var that=this;
						setTimeout(function() {
							that.close().remove();
						}, 2000);
					}
				}).show();
			}
		}
	});
}
function showresult(status) {
	if(window.parent.closedetail != undefined) {
		window.parent.closedetail(status);
	}

}
</script>
</body>
</html>