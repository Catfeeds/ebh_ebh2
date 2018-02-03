<?php $this->display('troomv2/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<div class="ter_tit">
当前位置 > 资讯管理</div>
<div class="lefrig">
<?php $this->display('troomv2/tplsetting_menu'); ?>
<div class="annotate" style="color:#888888; margin-left: 20px;">在此页面中,您可以管理教室平台下面的资讯，您可以进行添加、修改、删除等操作。</div>
<br/> 
<div class="workol" style="margin-top: -22px;">
<div class="work_menu" >
<ul>
<li class="workcurrent"><a href="/troomv2/tplsetting/information.html"><span>资讯列表</span></a></li>
<li><a href="/troomv2/tplsetting/information_add.html"><span>发布资讯</span></a></li>
</ul>
<div class="tiezitool"><ul><li><a class="lvbtn" href="/troomv2/tplsetting/information/add.html">发布新资讯</a></li></ul></div>
</div>
<div class="tiezi_search">
<table>
<tr>
<td><label>资讯标题：</label><input id="subject" name="q" type="text"  value="<?=$q?>" style="width:180px;"/></td>			

<td><a onclick="serc()" class="souhuang" id="ser">搜 索</a></td>
</tr>
</table>
</div>
<div class="workdata">
<table  width="100%" class="datatab">
 	 <thead class="tabhead">
 	 <tr>
  		<th>资讯标题</th>
    	<th>上传时间</th>
    	<th>资讯摘要</th>
<th>操作</th>
  	</tr>
  	</thead>
   	<tbody>
  
 <?php foreach($news as $oneNews){?>
 		<tr>
  		<td width="20%">
  		<?=shortstr($oneNews['subject'])?>	
  		</td>
    	<td width="10%"><?=date('Y-m-d',$oneNews['dateline'])?></td>
    	<td width="54%" title=""><?=shortstr($oneNews['note'],40)?></td>
<td width="16%"><a class="workBtn" onclick="location.href='/troomv2/tplsetting/information_edit.html?itemid=<?=$oneNews["itemid"]?>'">修改</a>
<input class="workBtn" type="submit" value="删除" onclick="return degroup(<?=$oneNews['itemid']?>,'<?=$oneNews["subject"]?>')"></td>
    	</tr>
<?php }?>    
    
  	</tbody>
</table>
</div>
<div><?=$show_page?></div>
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

//关键字符替换
//function strreplace(word){
//	word=word.replace(/\\/gi,"");
//	word=word.replace(/\?/gi,"");
//	word=word.replace(/\//gi,"");
//	return word;
//}
function degroup(itemid,subject) {
$.confirm("您确定要删除【" + subject + "】广告吗？",function(){
    $.ajax({
      url:"/troomv2/tplsetting/information_del.html",
      type:'post',
      data:{'itemid':itemid,'op':'del','subject':subject},
      dataType:'text',
      success:function(data){
        if(data=='success'){
         $.showmessage({
              img : 'success',
              message:'资讯删除成功',
              title:'删除资讯',
              callback :function(){
                   document.location.reload();
              }
          });
        }else{
           $.showmessage({
              img : 'success',
              message:'资讯删除失败,请稍后再试',
              title:'删除资讯',
              callback :function(){
                   document.location.reload();
              }
          });
        }
      }
    });
});
}
</script>
<script type="text/javascript">
<!--
function serc(){
var subject = $("#subject").val();
subject = subject.replace(/_/g,"");
subject = subject.replace(/,/g,"");
subject = subject.replace(/\'/g,"");
subject = subject.replace(/\?/g,"");
subject = subject.replace(/\#/g,"");
subject = subject.replace(/\%/g,"");
var url = '/troomv2/tplsetting/information-0-0-0.html?q='+subject;
window.location.href=url;
}

//-->
</script>
</body>
</html>