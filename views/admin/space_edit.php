<?php
$this->display('admin/header');
?>
<form method="post" action="<?php echo geturl('admin/space/edit');?>" id="form">
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
<tr><th>作品标题<em>*</em><p>请输入作品名称。</p></th><td><input type="text" class="w300" maxlength="50" name="title" value="<?php echo $spacedetail['title'];?>"  /></td></tr>
<tr><th>所属教师<em>*</em><p>不能修改。</p></th><td>
<?php echo $spacedetail['username'];?>
</td></tr>
<tr><th>是否公开<em>*</em><p>公开后其他人员也能看到作品图片</p></th><td>
<input type="radio" name="ispublic" value="0" />不公开</input>
<input type="radio" name="ispublic" value="1" />公开</input>
</td></tr>
<tr><th>作品预览<em>*</em><p>查看作品的缩略图</p></th><td>
<?php
$imageurl = $showpath.$spacedetail['image'];
$thumburl = getThumb($imageurl,'126_126');
?>
<a href="<?= $imageurl ?>" class="bigpic">
<img src="<?= $thumburl ?>" style="width: 126px;height: 126px;" /></a>
<a href="<?= $imageurl ?>" class="bigpic">大图</a></td></tr>
<tr>
<th>热门级别</th>
<td>

 <input type="radio" name="hot" value="0"/>非热门</input>
 <input type="radio" name="hot" value="1"/>热门Ⅰ</input>
 <input type="radio" name="hot" value="2"/>热门Ⅱ</input>
 <input type="radio" name="hot" value="3"/>热门Ⅲ</input>
</td></tr>
                                                                                                    
 <tr><th>置顶级别</th><td>
 <input type="radio" name="top" value="0"/>非置顶</input>
 <input type="radio" name="top" value="1"/>置顶Ⅰ</input>
 <input type="radio" name="top" value="2"/>置顶Ⅱ</input>
 <input type="radio" name="top" value="3"/>置顶Ⅲ</input>
 </td></tr> 

  <tr><th>精华级别</th><td>
  <input type="radio" name="best" value="0"/>非精华</input>
  <input type="radio" name="best" value="1"/>精华Ⅰ</input>
  <input type="radio" name="best" value="2"/>精华Ⅱ</input>
  <input type="radio" name="best" value="3"/>精华Ⅲ</input>
 </td></tr> 
 
<tr><th>排序号<em>*</em><p>请输入此课件的排序号，越小越靠前。</p></th><td><input type="text" class="w300" maxlength="50" name="displayorder" value="<?php echo $spacedetail['displayorder'];?>" ></input></td></tr>
<input type="hidden" name="id" value="<?php echo $spacedetail['id'];?>"></input>
</table>
</form>
<a href="javascript:void(0)" class="easyui-linkbutton" onclick="$('#form').submit()" >保存</a>
<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-reload" onclick="$('#form')[0].reset()" >重置</a>
<script>
	$(function(){
		$('input[name=hot]').get(<?php echo $spacedetail['hot'];?>).checked=true;
		$('input[name=best]').get(<?php echo $spacedetail['best'];?>).checked=true;
		$('input[name=top]').get(<?php echo $spacedetail['top'];?>).checked=true;
		$('input[name=ispublic]').get(<?php echo $spacedetail['ispublic'];?>).checked=true;
	})
</script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.min.js"></script>
<script type="text/javascript">
	$('.bigpic').lightBox();

</script>
<?
$this->display('admin/footer');
?>
