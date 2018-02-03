<?php $this->display('troom/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<div class="ter_tit">
当前位置 > <a href="/troom/setting/tplsetting/contact.html">联系方式</a> > 关于我们</div>
<div class="lefrig">
<?php $this->display('troom/tplsetting_menu'); ?>
<div class="annotate" style="color:#888888; margin-left: 20px;">在此页面中,您可以管理教室平台下面的关于我们、加盟合作、版权说明，您可以进行添加、修改、删除等操作。</div>
<br/> 
<div class="workol" style="margin-top: -22px;"><div class="work_menu" >
<ul>
<li class="<?=$tag=='about'?'workcurrent':''?>">
<a href="/troom/tplsetting/contact-0-0-0-about.html"><span>关于我们</span></a></li>
<li class="<?=$tag=='join'?'workcurrent':''?>">
<a  href="/troom/tplsetting/contact-0-0-0-join.html"><span>加盟合作</span></a>
</li>
<li class="<?=$tag=='copy'?'workcurrent':''?>">
<a href="/troom/tplsetting/contact-0-0-0-copy.html"><span>版权说明</span></a>
</li>
<li class="<?=$tag=='payment'?'workcurrent':''?>">
<a href="/troom/tplsetting/contact-0-0-0-payment.html"><span>付款方式</span></a>
</li>
</ul>
</div>
<div class="room_info_bot" style="padding: 10px 10px;">
     <table class="room_info_tab" width="100%">
<tr>
   		<td id="messagediv">
         <?php $editor->createEditor('message',"100%",'300px',$info['message']);?>
		<span id='summary_msg' style="float:left;height:30px;line-height:30px;"></span>
		</td>
</tr>
  
  <tr>
  				<td colspan="6" align="right" id="tdaction">
    		<input class="borlanbtn" style="float:right;" onclick="upmessage();" value="保存修改" type="button" />
    </td>
</tr>
</table>
</div>

<script type="text/javascript">
//兼容多个浏览器Enter提交
document.onkeydown=function(event) 
{ 
e = event ? event :(window.event ? window.event : null); 
if(e.keyCode==13){ 
$("#ser").click();
e.returnValue = false;
} 
}
function upmessage(){
var message = ue.getContent();
$.ajax({
url:"/troom/tplsetting/contactHandle.html",
type:'post',
data:{tag:"<?=$tag?>",'message':message,'itemid':"<?=empty($info['itemid'])?0:$info['itemid']?>",'op':"<?=$op?>"},
dataType:'json',
success:function(data){
if(data.type=='success'){
$.showmessage({
img		 :  'success',
message  :  data.msg,
title    :  data.title,
callback :  function(){
}
});

}else{
$.showmessage({
img		 :  'error',
message  :  data.msg,
title    :  data.title,
callback :  function(){
}
});
}
}
});
}

</script>
</body>
</html>