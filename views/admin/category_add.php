<?php $this->display('admin/header');?>
<body id="main"><table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tbody><tr>
		<td><h1>栏目设置</h1></td>
		<td class="actions">
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tbody><tr>
			<td><a href="/admin/category/<?=$type?>.html">浏览分类</a></td>
			<td class="active"><a href="/admin/category/edit.html?type=<?=$type?>&op=<?=$op?>" class="add">添加分类</a></td>
			</tr>
			</tbody></table>
		</td>
	</tr>
</tbody></table>
<form  method="post" action="/admin/category/op.html" onsubmit="return checkAll()">
<input type="hidden" name="op" value="<?=$op?>">
<input type="hidden" name="catid" value="<?=$catid?>">
<input type="hidden" name="type" value="<?=$type?>">
<input type="hidden" name="token" value="<?=$token?>">
<input type="hidden" name="position" value="<?=$position?>">
<table cellspacing="0" cellpadding="0" width="100%" class="maintable">
<tbody><tr><th>上级分类</th><td>
  <select name="upid" id="upid">
    <option value="0">根目录</option>
     <?php $this->widget('category_widget',array('where'=>array('type'=>$type,'position'=>$position),'tag'=>'upid','selected'=>$catinfo['upid'])); ?>
  </select>
</td></tr>
<tr>
  <th>名称<span>＊</span></th>
  <td><input type="text" class="w300" id="name" name="name" value="<?php echo $catinfo['name']?>" onblur="check_name()">
  </td>
</tr>
<tr>
  <th>英文ID<span>＊</span><p>不要包含下划线，且英文ID不能重复。</p></th>
  <td>
    <input type="text" class="w300" id="code" name="code" value="<?=$catinfo['code']?>" onblur="check_code()">
  </td>
</tr>
<tr>
  <th>是否系统数据<p>设置为系统数据后，将不能修此状态</p></th>
  <td><input type="radio" name="system" id="system" value="1" <?php if($catinfo['system']==1)echo 'checked'; ?>>系统数据&nbsp;&nbsp;
      <input type="radio" name="system" id="system2" value="0" <?php if($catinfo['system']==0)echo 'checked'; ?>>非系统数据
  </td>
</tr>
<tr>
  <th>前台是否可见<p>在前台页面中是否可见</p></th>
  <td><input type="radio" name="visible" value="1" <?php if($catinfo['visible']==1)echo 'checked'; ?>>可见&nbsp;&nbsp;<input type="radio" name="visible" value="0" <?php if($catinfo['visible']==0)echo 'checked'; ?>>不可见
  </td>
</tr>
<tr>
  <th>关键字<p>该关键字将显示在频道页面的 Meta Keywords 中。</p></th>
  <td><input type="text" class="w300" id="keyword" name="keyword" value="<?=$catinfo['keyword']?>"></td>
</tr>
<tr><th>描述<p>该描述将显示在频道页面的 Meta Description 中。</p></th><td><input type="text" class="w300" id="description" name="description" value="<?=$catinfo['description']?>"></td></tr>
<tr><th>显示顺序</th><td><input type="text" class="w50" id="displayorder" name="displayorder" value="<?=$catinfo['displayorder']?>" onblur="check_text('int',-1,100000,this,null,null)"></td></tr>
<tr><th>模版文件<p>您可以为该分类首页指定一个模板文件。模板文件必须放置在指定的目录下面，且后缀为 .html.php 。当指定的模板文件不存在的时候，则使用默认模板。</p></th><td><input type="text" class="w300" id="tpl" name="tpl" value="<?=$catinfo['tpl']?>"></td></tr>
<tr><th>分类查看页面模版<p>您可以为该分类的内容指定一个模板文件。模板文件必须放置在指定的目录下面，且后缀为 .html.php 。当指定的模板文件不存在的时候，则使用默认模板。</p></th><td><input type="text" class="w300" id="viewtpl" name="viewtpl" value="<?=$catinfo['viewtpl']?>"></td></tr>
<tr><th>分类封面<p>您可以为该频道设置一个介绍性的封面图片。</p></th>
<td>
<?php
  if(empty($catinfo['thumb'])){
    $Upcontrol->upcontrol('thumb',1,null,'pic');
  }else{
    $Upcontrol->upcontrol('thumb',1,array('upfilepath'=>$catinfo['thumb']),'pic');
  }
?>
</td></tr>
<tr><th>显示图</th>
<td>
   
<?php
  if(empty($catinfo['image'])){
    $Upcontrol->upcontrol('image',1,null,'pic');
  }else{
    $Upcontrol->upcontrol('image',1,array('upfilepath'=>$catinfo['image']),'pic');
  }
?>
</td>
</tr>
<tr><th>URL跳转地址<p>输入一个URL地址，则浏览该频道时，页面自动跳转到指定的链接地址。</p></th><td><input type="text" class="w300" id="caturl" name="caturl" value="<?=$catinfo['caturl']?>"></td></tr>
<tr><th>打开方式<p>点击该频道时，页面的打开方式。</p></th><td>
  <select id="target" name="target">
    <option value="" <?php if($catinfo['target']=='')echo 'selected';?>>本页打开</option>
    <option value="_blank" <?php if($catinfo['target']=='__blank')echo 'selected';?>>新窗口打开</option>
  </select></td></tr>
<tr><th>位置<p>分类在页面中显示的位置</p></th><td>
  <select id="position" name="position">
    <option value="0" <?php if($catinfo['position']==0)echo 'selected';?>>未指定</option>
    <option value="1" <?php if($catinfo['position']==1)echo 'selected';?>>页头栏目</option>
    <option value="2" <?php if($catinfo['position']==2)echo 'selected';?>>页脚栏目</option>
    <option value="3" <?php if($catinfo['position']==3)echo 'selected';?>>顶部栏目</option>
  </select></td></tr>
<tr><th>适用操作</th><td>
<?php $this->widget('operation_widget',array('opvalue'=>$catinfo['opvalue'],'position'=>'1,3'))?>
</td></tr>
</tbody></table>

<div class="buttons">
<input type="submit" name="valuesubmit" value="提交保存" class="submit">
<input type="reset" name="valuereset" value="重置">
</div>
</form><br>
<script type="text/javascript">
  function check_name(){
    var $name = $("#name");
    var $area = $name.parent('td');
    $("em",$area).remove();
    $name.val($.trim($name.val()));
    if($name.val().length<1){
      $area.append('<em class="error">名称不能为空</em>');
      $("html,body:not(:animated)").animate({scrollTop:$name.offset().top-50},1000);
      return false;
    }
    return true;
  }

  function check_code(){
    var $code = $("#code");
    $code.prop('tag',true);
    $code.val($.trim($code.val()));
    var $area = $code.parent('td');
    $("em",$area).remove();
    if($code.val().length<1){
      $area.append('<em class="error">ID不能为空</em>');
      $("html,body:not(:animated)").animate({scrollTop:$code.offset().top-50},1000);
      return false;
    }else if(/_/.test($code.val())){
       $area.append('<em class="error">ID不能含有下划线</em>');
      $("html,body:not(:animated)").animate({scrollTop:$code.offset().top-50},1000);
       return false;
    }else{
      $.ajax({
        type:'post',
        url:'/admin/category/checkRepeatID.html',
        data:{code:$code.val(),op:"<?=$op?>"},
        success:function(message){
          if(message==0){
            $area.append('<em class="error">ID重复</em>');
            $("html,body:not(:animated)").animate({scrollTop:$code.offset().top-50},1000);
            $code.prop('tag',false);
          }
        },
        async:false
      });
      
    }
    return $code.prop('tag')&&true;
  }
  function checkAll(){
    return(check_name()&&check_code());
  }
</script>
<div id="footer"><span>Zhejiang Svnlan Technologies 2011. </span></div>
</body>

<?php
  $this->display('admin/footer');
?>