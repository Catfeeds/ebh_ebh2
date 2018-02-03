<?php $this->display('admin/header');?>
<body id="main"><table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tbody><tr>
		<td><h1>栏目设置</h1></td>
		<td class="actions">
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tbody><tr>
			<td><a href="/admin/padstypes.html">浏览分类</a></td>
			<td class="active"><a href="/admin/padstypes/add.html" class="add">添加分类</a></td>
			</tr>
			</tbody></table>
		</td>
	</tr>
</tbody></table>
<form  method="post" action="/admin/padstypes/edit.html" onsubmit="return checkAll()">
<input type="hidden" name="tid" value="<?=$typeinfo['tid']?>">
<table cellspacing="0" cellpadding="0" width="100%" class="maintable">
<tbody><tr><th>上级分类</th><td>
  <?=$pselect?>
</td></tr>
<tr>
  <th>名称<span>＊</span></th>
  <td><input type="text" class="w300" id="name" name="name" value="<?php echo $typeinfo['name']?>" onblur="check_name()">
  </td>
</tr>
<tr>
  <th>英文ID<span>＊</span><p>可以包含下划线，英文ID不能重复。</p></th>
  <td>
    <input type="text" class="w300" id="code" name="code" value="<?=$typeinfo['code']?>" onblur="check_code()">
  </td>
</tr>
<tr><th>模板<p></p></th><td><input type="text" class="w300" id="templet" name="templet" value="<?=$typeinfo['templet']?>"></td></tr>
<tr>
  <th>是否系统数据<p>设置为系统数据后，将不能修此状态</p></th>
  <td><input type="radio" name="system" id="system" value="1" <?php if($typeinfo['system']==1)echo 'checked'; ?>>系统数据&nbsp;&nbsp;
      <input type="radio" name="system" id="system2" value="2" <?php if($typeinfo['system']==2)echo 'checked'; ?>>非系统数据
  </td>
</tr>
<tr>
  <th>前台是否可见<p>在前台页面中是否可见</p></th>
  <td><input type="radio" name="visible" value="1" <?php if($typeinfo['visible']==1)echo 'checked'; ?>>可见&nbsp;&nbsp;<input type="radio" name="visible" value="0" <?php if($typeinfo['visible']==0)echo 'checked'; ?>>不可见
  </td>
</tr>
<tr><th>描述<p>该描述将显示在频道页面的 Meta Description 中。</p></th><td><input type="text" class="w300" id="description" name="description" value="<?=$typeinfo['description']?>"></td></tr>
<tr><th>显示顺序</th><td><input type="text" class="w50" id="displayorder" name="displayorder" value="<?=$typeinfo['displayorder']?>" onblur="return check_num()"></td></tr>
</tr>


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
    }else{
      if($code.val()=="<?=$typeinfo['code']?>"){
        return true;
      }

      $.ajax({
        type:'post',
        url:'/admin/padstypes/checkRepeatCode.html',
        data:{code:$code.val()},
        success:function(message){
          if(message==true){
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

  function check_num(e){
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
  function checkAll(){
    check_name();check_code();check_num();
    return(check_name()&&check_code()&&check_num());
  }
</script>
</body>

<?php
  $this->display('admin/footer');
?>