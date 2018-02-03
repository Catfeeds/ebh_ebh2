<?php $this->display('troom/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
	<div class="wrap" style="background:#fff;">
		<div class="cmain clearfix" style="background:#fff;">
			<table class="room_info_tab" width="100%">
				<tr>
					<td>
						<input type="text" id="title" style="width:947px; border:none; border-bottom:1px solid #cacaca;height:32px; line-height:32px; margin: 10px 5px
						10px; padding:0 5px;color:#999;font-size:14px" value="请填写模块名称" maxlength="30"/>
					</td>
				</tr>
				
				<tr>
					<td>
						
						<?php
							$editor->xEditor('message','960px','500px');
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
<style>
body{ background:#fff;}
</style>
<script type="text/javascript">

function showresult(status) {
	if(window.parent.closeintroduce != undefined) {
		window.parent.closeintroduce(status);
	}

}

function upmessage(){
	var title = $('#title').val();
	if(title=='' || title=='请填写模块名称'){
		alert(' 请填写模块名称');
	}else{
		// var c = $(top.window.frames["mainFrame"].document.body).find('.leftou');
		var c = $(top.window.frames["mainFrame"].document.body).find('.btns');
		// var mfr = getIframeDocument('mainFrame');
		// mfr.getElementById();
		
		var message = UM.getEditor('message').getContent();
		c.before('<div class="introduceitem"><div class="ksthg"><span class="kstrhf">'+title+'</span><a href="javascript:void(0)" onclick="showcourseedit(event)" class="kstbeys">[编辑]</a><a href="javascript:void(0)" onclick="delm(event)" class="lsitgfd"></a></div><div class="dfyxc">'+message+'</div></div>');
		// c.append(message);
		top.resetmain();
		showresult();
		$('#title').val('');
		ue.setContent('');
		// c.remove();
	}
}

var getIframeDocument = function(iId) {
	
	var ifr = top.document.getElementById(iId);
    return  ifr.contentDocument || ifr.contentWindow.document;
};
$('#title').focus(function(){
	if($('#title').val()=='请填写模块名称'){
		$('#title').val('');
		$('#title').css('color','#333');
	}
});
</script>
</body>
</html>