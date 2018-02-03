<?php
	$this->display('admin/header');
?>
<body id="main">
<form method="post" action="/admin/gallery/addgallerys.html" onsubmit="return checkAll()">
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
<input type="hidden" id="systype" name="systype" value="">
<input type="hidden" id="ishide" name="ishide" value="0">
<tr><th>请选择类型</th><td>
<select name="aid" id="aid" class="w300"  onchange="check_type()">
	<option name="0" value="0" >请选择</option>
	<?php if(!empty($gallerys) && is_array($gallerys)){foreach($gallerys as $gallery){?>
	<option name="<?=$gallery['systype']?>" value="<?=$gallery['aid']?>"><?=$gallery['alname']?></option>
	<?php }}?>
</select>
</td></tr>
	
<tr>
	<th>名称<span>＊</span><br><p>分类的名称</p></th>
	<td>
		<input type="text" id="alname" name="alname" value=""   onblur="check_name()" class="easyui-validatebox w300" required missingMessage="请输入分类名称">
	</td>
</tr>
<tr>
	<th>排序号<span>＊</span><p>数字小的排在上面</p></th>
	<td><input type="text" id="displayorder" name="displayorder" value="" class="easyui-validatebox w300" required missingMessage="请输入排序号"/></td>
</tr>
<tr>
	<th>是否显示:<p>默认显示</p></th>
	<td><input type="checkbox" id="isshow"  value="" checked onchange="change()"/>
	</td>
</tr>
</table><div class="buttons">
<input type="submit" name="valuesubmit" value="提交保存" class="submit" />
</div>
</form><br>
<script type="text/javascript">
  function check_name(){
    var $name = $("#alname");
    var $area = $name.parent('td');
    $("em",$area).remove();
    $name.val($.trim($name.val()));
    if($name.val().length<1){
      $area.append('<em class="error">名称不能为空</em>');
      $("html,body:not(:animated)").animate({scrollTop:$name.offset().top-50},1000);
      return false;
    } else {
      return true;
    }
    
  }

  function check_order(){
    var $name = $("#displayorder");
    var $area = $name.parent('td');
    $("em",$area).remove();
    $name.val($.trim($name.val()));
    if($name.val().length<1){
      $area.append('<em class="error">排序号不能为空</em>');
      $("html,body:not(:animated)").animate({scrollTop:$name.offset().top-50},1000);
      return false;
    }
    var patrn=/^([1-9]\d*|0)$/;
	if (!patrn.exec($name.val())){
      $area.append('<em class="error">排序号为0或正整数</em>');
      $("html,body:not(:animated)").animate({scrollTop:$name.offset().top-50},1000);
      return false;
    } else {
	  return true;
	}
  }
    function check_type(){
	    var $name = $("#aid");
	    var $area = $name.parent('td');
	    var $systype = $("#systype")
	    $("em",$area).remove();
	    aid = $.trim($name.val());
	    var systype = $("#aid option:selected").attr("name");
	    $systype.val(systype);
	    $name.val(aid);
	    if((aid=='0') || (systype=='0')){
	      $area.append('<em class="error">类型不能为空</em>');
	      $("html,body:not(:animated)").animate({scrollTop:$name.offset().top-50},1000);
	      return false;
	    } else {
	      return true;
	    }
	}
	function change(){
	    var $name = $("#isshow");
	    var $area = $name.parent('td');
	    var ishide = $("#ishide")
	    $("em",$area).remove();
	    isshow = $.trim($name.val());
	    if($name.is(':checked')){
	    	ishide.val(0);
	      $area.append('<em id="checknotice" class="error">已设置为显示此分类</em>');
	      $("html,body:not(:animated)").animate({scrollTop:$name.offset().top-50},1000);
	      return true;
	    }else{
	      ishide.val(1);
	      $area.append('<em id="checknotice" class="error">已设置为不显示此分类</em>');
	      $("html,body:not(:animated)").animate({scrollTop:$name.offset().top-50},1000);
	      return true;
	    }
	}
  	function checkAll(){
    	if(check_type() && check_name() && check_order()){
    		return true;
    	}else{
    		return false;
    	}
  	}
</script>
</body>