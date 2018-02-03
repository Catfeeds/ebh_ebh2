<?php $this->display('admin/header');?>
<body id="main">
  <table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1 style="width:550px;">资源站管理 - 添加资源</h1></td>
		<td class="actions" >
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tr>
			<td class="active"><a href="<?php echo geturl('admin/resources/add')?>" class="add">添加资源</a></td>
			<td ><a href="<?php echo geturl('admin/resources/showlist')?>" >资源管理</a></td>
			</tr>
			</table>
		</td>
	</tr>
</table>
<script>
 VerifyDate=function(thisform)
 {
    
    with(thisform)
    {  
        var strValue = $("#category option:selected").val();
        if(strValue == "0")
        {
             alert('请选择广告分类');
             return false; 
        }
        if(document.getElementById('subject').value.length==0)
        {
            alert('标题不能为空！');
            document.getElementById('subject').focus();
            return false;
        }
       
    }
    
 }
 </script>
<form method="post" action="/admin/items/handle.html" onsubmit="return VerifyDate(this)">
<input type="hidden" name="op" value="<?=$op?>" />
<input type="hidden" name="token" value="<?=$token?>" />
<input type="hidden" name="itemid" value="<?=$itemid?>">
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
<style type="text/css">
body{font-family:tahoma,verdana,arial;font-size:11px;line-height:15px;background-color:#FCFDFD;color:#666666;margin-left:20px;}
strong{font-size:12px;}
aink{color:#0066CC;}
a:hover{color:#FF6600;}
aisited{color:#003366;}
a:active{color:#9DCC00;}
</style>
<br />
<br />
<tr>
  <th>资源标题<span>＊</span></th>
  <td>
    <input maxlength="200" class="w300" type="text" name="subject" id="subject"  value="<?=$item['subject']?>"   onblur=""  ></input>
  </td>
</tr>
<tr><th>资源分类<span>＊</span></th><td>
<select name="category" id="category"  onblur=""  >
	<option value="0" >资源分类</option>
	<?php $this->widget('category_widget',array('where'=>array('type'=>'resources'),'tag'=>'category','selected'=>$item['catid'])); ?>
</select>
</td></tr>
<tr>
  <th>资源图片<p></p></th>
  <td>
  <?php
    if(empty($item['thumb'])){
      $Upcontrol->upcontrol('thumb',1,null,'pic');
    }else{
      $Upcontrol->upcontrol('thumb',1,array('upfilepath'=>$item['thumb']),'pic');
  }
  ?>
</td></tr>            

 <tr>
<td colspan="2" style="padding:0;">
	<?php $editor->createEditor('message',"100%",'300px',$item['message']); ?>
</td>
</tr>
</table>

<div class="buttons">

<input type="submit" name="nextsubmit" value="保存并继续" class="submit">
<input type="submit" name="valuesubmit" value="提交保存" class="submit">
<input type="reset"	 name="valuereset" value="重置">
</div>
</form>
<br>
<div id="footer"><span>Zhejiang Svnlan Technologies 2011. </span></div>
</body>
</html>

