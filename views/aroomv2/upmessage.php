<?php 
$this->assign('jquery11',TRUE);
$this->display('aroomv2/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />

				<div class="wrap">
					<div class="cmain clearfix">
		
		                    	<table class="room_info_tab" width="100%">
		                    		<tr>
		                    		    <td>

                                                                                        <?php
                                                                                        $editor->simpleEditor('message','960px','480px',$myroom['message']);
                                                                                        ?>
										</td>
		                    		</tr>
		                    		<tr>
		                    			  	<td align="right">
										    	<input class="crupBtn lightbtn" style="cursor:pointer;margin-top:10px;" onclick="showresult(0)" value="取消" type="button" />
										    	<input class="crupBtn lightbtn" style="cursor:pointer;margin-top:10px;" value="保存修改" type="button" onclick="upmessage()"/>
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
		url:"<?= geturl('aroomv2/asetting/upinfo') ?>",
		type:'post',
		data:{'message':message},
		dataType:'text',
		success:function(data){
			if(data=='success'){
				$.showmessage({
					img		 : 'success',
					message  :  '平台详细介绍修改成功',
					title    :      '平台详细介绍修改',
					callback :    function(){
						showresult(1);
					}
				});
				
			}else{
				$.showmessage({
					img		 : 'error',
					message  :  '平台详细介绍修改失败',
					title    :      '平台详细介绍修改成功',
					callback :    function(){
					}
				});
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