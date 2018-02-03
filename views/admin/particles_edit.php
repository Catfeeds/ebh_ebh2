<?php 
  $this->display('admin/header');
?>
<body id="main"><table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tbody><tr>
		<td><h1>资讯管理 - 资讯列表</h1></td>
		<td class="actions">
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tbody><tr>
			<td><a href="/admin/news.html">浏览资讯</a></td>
			<td class="active"><a href="/admin/news/add.html" class="add">添加资讯</a></td>
			</tr>
			</tbody></table>
		</td>
	</tr>
</tbody></table>

<form method="post" action=<?php echo geturl('admin/particles/edit'); ?> onsubmit="return check()">
  <input type="hidden" name="itemid" value="<?=$item['itemid']?>">
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
    <th>文章分类<span>＊</span></th>
    <td>
      <?=$pselect?>
    </td>
  </tr>
  <tr>
    <th>资讯标题<span>＊</span></th>
    <td><input maxlength="200" class="w300" style="width:500px;" type="text" name="subject" value="<?=$item['subject']?>" onblur="return checktext()">
    </td>
  </tr>
<tr>
    <th>摘要<p>描述资讯简介0-200字</p></th>
    <td>
      <textarea name="note" rows="2" style="width:80%;height:120px;" cols="20" id="note"><?=$item['note']?></textarea>
    </td>
  </tr>
<tr>
  <th>详情<p>描述资讯具体内容</p></th>
  <td colspan="2" style="padding: 0;">
       <?php $editor->createEditor('message',"1000px",'500px',$item['message']); ?>
  </td>
</tr>
<tr>
  <th>关键词(Tags)
    <p>指定关键词有助于搜索引擎检索,多个关键词请用空格隔开。如果不指定,将自动从内容中提取重复最多的10个关键词</p>
  </th>
  <td>
    <input type="text" name="tag" class="p98" value="<?=$item['tag']?>">
  </td>
</tr>

<tr><th>缩略图<p>缩略图用于封面显示,不要过大,建议尺寸143*98</p></th><td>
<br>
<?php
  if(empty($item['thumb'])){
    $Upcontrol->upcontrol('thumb',1,null,'pic');
  }else{
    $Upcontrol->upcontrol('thumb',1,array('upfilepath'=>$item['thumb']),'pic');
  }
?>
</td></tr>

<script type='text/javascript'>
  $.fn.datebox.defaults.formatter = function(date){
  var y = date.getFullYear();
  var m = date.getMonth()+1;
  var d = date.getDate();
  return y+'-'+m+'-'+d;
}
</script>
<tr><th>资讯发布日期
<p>您可以自己指定当前资讯的发布日期。注意，不能是当前时间以后的日期</p></th>
<td><input type="text" id="date" name="dateline" class="w150" onfocus="$(this).datetimebox({});" value="<?=date('Y-m-d H:i:s',$item['dateline'])?>">

</td></tr>

<tr><th>外部链接URL<p>如果填入外部链接，查看该资讯时，将自动跳转到该链接。</p></th><td>
<input type="text" class="w300" name="itemurl" value="<?=$item['itemurl']?>">
</td></tr>

<tr><th id="video">作者<p>格式为:张三</p></th><td>
<input type="text" class="w300" id="author" name="author" value="<?=$item['author']?>">
</td>
</tr>

<tr><th>信息来源</th><td>
        <input type="text" class="w300" name="source" value="<?=$item['source']?>">

<!-- <select id="sourcekey" name="sourcekey">
<option>选择来源</option>
     <option value="1" >本站原创</option>
      <option value="2">互联网</option>    
</select> -->
</td></tr>      

<!--  -->
<tr><th>状态</th><td>
<input type="radio" name="status" value="1" <?php if($item['status']==1){echo 'checked=checked';}?> />正常状态
<input type="radio" name="status" value="2" <?php if($item['status']==2){echo 'checked=checked';}?> />锁定状态
</td></tr>
<tr><th>排序</th><td>
<input type="text" name="displayorder" id="displayorder" value="<?=$item['displayorder']?>" onblur="return check_num()" />
</td></tr>
<?php $this->widget('bth_widget',array('hot'=>$item['hot'],'best'=>$item['best'],'top'=>$item['top'])) ?>
</tbody></table>
<div class="buttons">
<input type="submit" name="valuesubmit" value="提交保存" class="submit">
<input type="reset" name="valuereset" value="重置">
</div>
</form><br>

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
 function check(){
    $("em.error,em.success").remove();
     return (checktext()&&check_num());
  }
  function check_num(){
      var $name = $("#displayorder");
      var $area = $name.parent('td');
      $("em",$area).remove();
      $name.val($.trim($name.val()));
      if(!(/^(([1-9][0-9]*)|([0]{1}))$/.test($name.val()))){
        $area.append('<em class="error">显示顺序为空或者格式不对</em>');
        $("html,body:not(:animated)").animate({scrollTop:$name.offset().top-50},1000);
        return false;
      }
      return true;
  }
  $("#date").trigger('focus');
  $(".datebox :text").attr("readonly","readonly");
</script>
<?php 
  $this->display('admin/footer');
?>