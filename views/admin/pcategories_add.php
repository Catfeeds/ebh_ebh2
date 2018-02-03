<?php $this->display('admin/header');?>
<body id="main"><table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tbody><tr>
		<td><h1>栏目设置</h1></td>
		<td class="actions">
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tbody><tr>
			 <td><a href="/admin/pcategories.html">浏览分类</a></td>
      <td class="active"><a href="/admin/pcategories/add.html" class="add">添加分类</a></td>
			</tr>
			</tbody></table>
		</td>
	</tr>
</tbody></table>
<form  method="post" action="/admin/pcategories/add.html" onsubmit="return checkAll()">
<table cellspacing="0" cellpadding="0" width="100%" class="maintable">
<tbody><tr><th>上级分类</th><td>
  <?=$pselect?>
</td></tr>
<tr>
  <th>名称<span>＊</span></th>
  <td><input type="text" class="w300" id="name" name="name" value="" onblur="check_name()">
  </td>
</tr>
<tr>
  <th>英文ID<span>＊</span><p>不要包含下划线，且英文ID不能重复。</p></th>
  <td>
    <input type="text" class="w300" id="code" name="code" value="" onblur="check_code()">
  </td>
</tr>
<tr>
  <th>是否系统数据<p>设置为系统数据后，将不能修此状态</p></th>
  <td><input type="radio" name="system" id="system" value="1" checked=checked>系统数据&nbsp;&nbsp;
      <input type="radio" name="system" id="system2" value="2" >非系统数据
  </td>
</tr>
<tr>
  <th>前台是否可见<p>在前台页面中是否可见</p></th>
  <td><input type="radio" name="visible" value="1" checked=checked>可见&nbsp;&nbsp;<input type="radio" name="visible" value="2" >不可见
  </td>
</tr>
<tr>
  <th>关键字<p>该关键字将显示在频道页面的 Meta Keywords 中。</p></th>
  <td><input type="text" class="w300" id="keyword" name="keyword" value=""></td>
</tr>
<tr><th>描述<p>该描述将显示在频道页面的 Meta Description 中。</p></th><td><input type="text" class="w300" id="description" name="description" value=""></td></tr>
<tr><th>显示顺序<span>＊</span></th><td><input type="text" class="w50" id="displayorder" name="displayorder" value="" onblur="return check_num(this);"></td></tr>
</tr>

<tr><th>URL跳转地址<p>输入一个URL地址，则浏览该频道时，页面自动跳转到指定的链接地址。</p></th><td><input type="text" class="w300" id="caturl" name="caturl" value=""></td></tr>
<tr><th>打开方式<p>点击该频道时，页面的打开方式。</p></th><td>
  <select id="target" name="target">
    <option value="" >本页打开</option>
    <option value="_blank" >新窗口打开</option>
  </select></td></tr>

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
        url:'/admin/pcategories/checkRepeatCode.html',
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