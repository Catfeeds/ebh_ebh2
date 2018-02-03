<?php 
  $this->display('admin/header');
?>
<body id="main"><table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tbody><tr>
		<td><h1>帮助管理 - 帮助列表</h1></td>
		<td class="actions">
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tbody><tr>
			<td><a href="/admin/help.html">浏览帮助</a></td>
			<td class="active"><a href="/admin/help/add.html" class="add">添加帮助</a></td>
			</tr>
			</tbody></table>
		</td>
	</tr>
</tbody></table>
<?php $in = 'c.catid in(691,692,693,694,695,789,790,791,792,793,794,795,796,797,798,799,800,801,802,804,805,806,807,808,809,810,861,862,863,864,883,884,931,932,811,812,813,814,815,816,817,818,819,820,821,822,823,824,825,826,827,836,828,837,829,838,830,839)'; ?>
<form method="post" action=<?php echo geturl('admin/items/handle'); ?> onsubmit="return check()">  
<input type="hidden" name="op" value="<?=$op?>" />
<input type="hidden" name="itemid" value="<?=$itemid?>">
<input type='hidden' name='type' value="<?=$type?>" />
<input type='hidden' name='token' value="<?=$token?>" />
<style type="text/css">
body{font-family:tahoma,verdana,arial;font-size:11px;line-height:15px;background-color:#FCFDFD;color:#666666;margin-left:20px;}
strong{font-size:12px;}
aink{color:#0066CC;}
a:hover{color:#FF6600;}
aisited{color:#003366;}
a:active{color:#9DCC00;}
</style>
<table cellspacing="0" cellpadding="0" width="100%" class="maintable">

<tbody>
  <tr>
    <th>帮助分类<span>＊</span></th>
    <td>
        <select name="category" id='category'>      
         <?php $this->widget('category_widget',array('where'=>$in,'tag'=>'category','selected'=>$item['catid'])); ?>
        </select>
      
    </td>
  </tr>
  <tr>
    <th>帮助标题<span>＊</span></th>
    <td><input maxlength="200" class="w300" type="text" name="subject" value="<?php echo $item['subject']?>" onblur="checktext()">
    </td>
  </tr>
<tr>
    <th>摘要<p>描述帮助简介</p></th>
    <td>
      <textarea name="note" rows="2" class="w300" cols="20" id="note"><?php echo $item['subject']?></textarea>
    </td>
  </tr>
<tr>
  <th>详情<p>描述帮助具体内容</p></th>
  <td colspan="2" style="padding: 0;">
       <?php $editor->createEditor('message',"100%",'300px',$item['message']); ?>
  </td>
</tr>
<tr>
  <th>关键词(Tags)
    <p>指定关键词有助于搜索引擎检索,多个关键词请用空格隔开。如果不指定,将自动从内容中提取重复最多的10个关键词</p>
  </th>
  <td>
    <input type="text" name="tag" class="p98" value="<?php echo $item['tag']?>">
  </td>
</tr>

<tr><th>缩略图<p>请上传1张该商品的缩略图。此缩略图可由系统自动生成，如需启用此功能，请到 基本设置 -&gt; 缩略图设置 中设置。</p></th><td>
<br>
<?php
  if(empty($item['thumb'])){
    $Upcontrol->upcontrol('thumb',1,null,'pic');
  }else{
    $Upcontrol->upcontrol('thumb',1,array('upfilepath'=>$item['thumb']),'pic');
  }
?>


</td></tr><tr><th>LOGO缩络图
<p>帮助各种缩略图的尺寸</p>
</th><td valign="bottom">
<table width="100%" cellspacing="0" cellpadding="0" style="border:0">
<tbody><tr>
</tr>

</tbody></table>
</td></tr>
<tr><th>附件(如驱动程序或说明书等)<p>上传此文章中非图片的附件以供前台下载，如.doc .pdf等。删除时，请从后面开始删除。</p></th><td>
   
    <?php 
        if(!empty($item['attachment'])){
          $Upcontrol->upcontrol('attachment',3,array('upfilepath'=>$item['attachment']));
        }else{
          $Upcontrol->upcontrol('attachment',3);
        }
        
    ?>
<input type="radio" name="attachlock" value="1" <?php if($item['attachlock']==1) echo 'checked=checked'; ?>>下载时需要登录
<input type="radio" name="attachlock" value="2" <?php if($item['attachlock']==2||$item['attachlock']==0) echo 'checked=checked'; ?>>直接下载
</td></tr>
<script type='text/javascript'>
  $.fn.datebox.defaults.formatter = function(date){
  var y = date.getFullYear();
  var m = date.getMonth()+1;
  var d = date.getDate();
  return y+'-'+m+'-'+d;
}
</script>
<tr><th>帮助发布日期
<p>您可以自己指定当前帮助的发布日期。注意，不能是当前时间以后的日期</p></th>
<td><input type="text" id="date" name="dateline" class="w150" onfocus="$(this).datetimebox({});" value="<?php $item['dateline']=empty($item['dateline'])?time():$item['dateline']; echo date("Y-m-d H:i:s",$item['dateline']) ?>">

</td></tr>

<tr><th>外部链接URL<p>如果填入外部链接，查看该帮助时，将自动跳转到该链接。</p></th><td>
<input type="text" class="w300" name="itemurl" value="<?php echo $item['itemurl']?>">
</td></tr>

<tr><th id="video">原创作者<p>格式为:张三</p></th><td>
<input type="text" class="w300" id="author" name="author" value="<?php echo $item['author']?>">
</td>
</tr>

<tr><th>信息来源</th><td>
        <input type="text" class="w300" name="source" value="<?php echo substr($item['source'],0,strrpos($item['source'],','));?>">

<select id="sourcekey" name="sourcekey">
<option>选择来源</option>
     <option value="1"  <?php if(strrchr($item['source'],',')==',1'){echo 'selected=selected';}?>>本站原创</option>
        <option value="2" <?php if(strrchr($item['source'],',')==',2'){echo 'selected=selected';}?>>互联网</option>    
</select>
</td></tr>      

<!--  -->
<tr><th>文件夹</th><td>
<input type="radio" name="folder" value="1" <?php if($item['folder']=='1') echo 'checked=checked' ?>>待审箱
<input type="radio" name="folder" value="2" <?php if($item['folder']=='2' or $item['folder']=='0') echo 'checked=checked' ?>>发布箱
</td></tr>
<?php $this->widget('bth_widget',array('hot'=>$item['hot'],'best'=>$item['best'],'top'=>$item['top'])) ?>
</tbody></table>
<div id="dialog"></div>  
<div class="buttons">
<input type="submit" name="nextsubmit" value="保存并继续" class="submit">
<input type="submit" name="valuesubmit" value="提交保存" class="submit">
<input type="reset" name="valuereset" value="重置">
</div>
</form><br><div id="footer"><span>Zhejiang Svnlan Technologies 2011. </span></div>

<script type='text/javascript'>

  function checktext(){
    var e = $("input[name=subject]");
    var area = e.parent('td');
    var len = $(e).val().length;
    if(len<4||len>200){
      $("em.error,em.success",area).remove();
      area.append('<em class="error">标题长度必须为4至200之间!'+'</em>');
      $("html,body").animate({scrollTop:e.offset().top-50},1000);
      return false;
    }else{
      $("em.error,em.success",area).remove();
      area.append('<em class="success">正确!</em>');
    }
    return true;
  }

  function checkcity(){
    var city = $("#address");
    var len = ($("#address_sheng").val()+$("#address_shi").val()+$("#address_qu").val()).length;
    if(len<1){
        $("em.error,em.success",city).remove();
        city.append('<em class="error">请选择城市!</em>');
        $("html,body:not(:animated)").animate({scrollTop:city.offset().top-50},1000);
        return false;
    }else{
        $("em.error,em.success",city).remove();
        city.append('<em class="success">选择正确!</em>');
    }
  }

  function check(){
    $("em.error,em.success").remove();
    return (checktext()&&checkcity());
  }
</script>
<?php 
  $this->display('admin/footer');
?>