<?php $this->display('troom/page_header'); ?>

<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<script type="text/javascript">
<!--

$(function(){
	$("img[Jimg='a']").click(function(){
		$("#thatimg").attr("src",this.src);
		$("#logo").val(this.src);
	});
	$("#btnlogo").click(function(){
		uploadslogo();
	})
});

function uploadslogo(){
	$("#btnlogo").unbind( "click" );
	var logo=$("#logo").val();
	
	$.ajax({
		type:'POST',
		data:{'logo':logo},
		dataType:'text',
		success:function(data){
			if(data=='1'){
				alert('头像修改成功');
				location.reload();
				
			}else{
				alert('头像修改失败');
				location.reload();
			}
		}
	});
}
//-->
</script>
<?php
if(empty($myroom['cface']))
	$cface = 'http://static.ebanhui.com/ebh/tpl/default/images/face/4.jpg';
else{
	$cface = $myroom['cface'];
}
?>
<div class="ter_tit">
当前位置 > <a href="<?=geturl('troom/setting/avatarold')?>">教室头像</a> > 系统头像
</div>
<div class="lefrig">
<div class="workol">
<div class="work_menuss">
	<ul>
		<li><a href="<?=geturl('troom/setting/avatarold')?>"><span>自定义头像</span></a></li>
		<li class="workcurrent"><a href="<?=geturl('troom/setting/roomlogo')?>"><span>系统头像</span></a></li>
	</ul>
		</div>
	<div class="tab_box">
		<div class="ecenter">
				<div class="mrtx">
					<p>当前头像：</p>
					<div class="mrtxpic"><img id="thatimg" src="<?=$cface?>" style="width:100px;height:100px;"/></div>
				</div>
				<div class="xttxtit">系统推荐头像(共18个)</div>
				<div class="xttxlist">
					<ul>
						<?php for($i=1;$i<=18;$i++){
							echo '<li><a href="#"><img Jimg="a" src="http://static.ebanhui.com/ebh/tpl/2012/images/face/'.$i.'.jpg" /></a></li>';
						}
						?>
						
				</div>
				<input type="hidden" id="logo"  />
					<div class="xgtxBtn"><a class="lanbtn" href="#" id="btnlogo" >确认</a></div>
		</div>
	</div>
</div>
</div>
<?php $this->display('troom/page_header'); ?>