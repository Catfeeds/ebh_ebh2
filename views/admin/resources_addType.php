<?php
	$this->display('admin/header');
?>
<body id="main"><table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1 style="width:550px;">资源站管理 - 添加资源分类</h1></td>
		<td class="actions" >
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tr>
			<td ><a href="#" >资源分类管理</a></td>
			<td class="active"><a href="#" class="add">添加资源分类</a></td>
			</tr>
			</table>
		</td>
	</tr>
</table>
<form method="post" action="/admin/category/op.html" onsubmit="return checkAll()">
<input type="hidden" name="op" value="<?=$op?>">
<input type="hidden" name="catid" value="<?=$catid?>">
<input type="hidden" name="type" value="<?=$type?>">
<input type="hidden" name="token" value="<?=$token?>">
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
<tr><th>上级分类</th><td>
<select name="upid" id="upid">
	<option  value="0" >根目录</option>
	<?php $this->widget('category_widget',array('where'=>array('type'=>'resources'),'tag'=>'upid','selected'=>$catinfo['upid'])); ?>
</select>
</td></tr>
<tr>
	<th>名称<span>＊</span></th>
	<td>
		<input type="text" class="w300" id="name" name="name" value="<?=$catinfo['name']?>"   onblur="check_name()"  >
	</td>
</tr>
<tr>
	<th>英文ID<span>＊</span><p>不要包含下划线，且英文ID不能重复。</p></th>
	<td><input type="text" class="w300" id="code" name="code" value="<?=$catinfo['code']?>"   onblur="check_code()"   /></td>
</tr>
<tr>
	<th>关键字<p>该关键字将显示在频道页面的 Meta Keywords 中。</p></th>
	<td><input type="text" class="w300" id="keyword" name="keyword" value="<?=$catinfo['keyword']?>"></input></td>
</tr>
<tr>
	<th>描述<p>该描述将显示在频道页面的 Meta Description 中。</p></th>
	<td><input type="text" class="w300" id="description" name="description" value="<?=$catinfo['description']?>"></input></td>
</tr>
<tr>
	<th>显示顺序</th>
	<td><input type="text" class="w50" id="displayorder" name="displayorder" value="<?=$catinfo['displayorder']?>"   onblur=""/>
	</td>
</tr>
</table><div class="buttons">
<input type="submit" name="valuesubmit" value="提交保存" class="submit"/>
<input type="reset"	 name="valuereset" value="重置"/>
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