<?php $this->display('troom/page_header'); ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<div class="ter_tit">
当前位置 > 广告管理</div>
<div class="lefrig" style="border:solid 1px #cdcdcd;background:#fff;float:left;margin-top:15px;width:786px;">
<?php $this->display('aroomv2/datasetting_menu'); ?>
<div class="flopadt">
<a class="jiabgbtn hongbtn" onclick="location.href='/aroom/datasetting/advertisement/add.html'">添加广告</a>
</div><table width="100%" class="datatab" style="border-left:none;border-right:none;">
<thead class="tabhead">
  <tr>
<th><img src="http://static.ebanhui.com/ebh/images/base/image.gif"></th>
<th>广告标题</th>
<th>广告链接</th>
<th>操作</th>
  </tr>
 </thead>
 <tbody>
 
 
<?php foreach($ads as $ad){?>
 <tr>
 <td width="5%" >
 <a class="sn" href="<?=$ad['thumb']?>" title="<?=$ad['subject']?>"><img src="http://static.ebanhui.com/ebh/images/base/image.gif"></a></td>
 <td width="54%"><a href="/aroom/datasetting/advertisement_edit.html?itemid=<?=$ad["itemid"]?>" title="<?=$ad['subject']?>"><?=shortstr($ad['subject'],20)?></a></td>

<td width="25%"><a href="<?=$ad['itemurl']?>" target="_blank"><?=$ad['itemurl']?></a></td>
 <td width="16%">
<a class="workBtn" onclick="location.href='/aroom/datasetting/advertisement_edit.html?itemid=<?=$ad["itemid"]?>'">修改</a>
<input type="button" class="workBtn" onclick="return degroup(<?=$ad['itemid']?>,'<?=$ad['subject']?>')" style="cursor:pointer;vertical-align: middle;font-weight:100;" value="删除" /></div>
 </td>
 </tr>
 <?php }?> 
 </tbody>
  
</table>
<?=$show_page?>
<script type="text/javascript">
$(function(){
$("#gopage").keypress(function(e){
if (e.which == 13){
$(this).next("#page_go").click()
cancelBubble(this,e);
}
})
})</script></div>
</div>
<script type="text/javascript">
<!--
function degroup(itemid,subject) {
$.confirm("您确定要删除【" + subject + "】广告吗？",function(){
      $.ajax({
    url:"/aroom/datasetting/advertisement_del.html",
    type:'post',
    data:{'itemid':itemid,'op':'del','subject':subject},
    dataType:'text',

    success:function(data){
      if(data=='success'){
          $.showmessage({
              img : 'success',
              message:'广告删除成功',
              title:'删除广告',
              callback :function(){
                   document.location.reload();
              }
          });

      }else{
        $.showmessage({
            img : 'success',
            message:'广告删除失败',
            title:'删除广告',
            callback :function(){
                document.location.reload();
            }
        });
      }
    }
  });

});
}
//-->
$(function(){
	$(".sn").lightBox();
});
</script>
</body>
</html>