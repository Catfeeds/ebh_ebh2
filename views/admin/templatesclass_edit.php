<?php
	$this->display('admin/header');
?>
<body id="main">
<form method="post" action="/admin/templates/edittemplatesclass.html" onsubmit="return checkAll();">
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
<input type="hidden" id="systype" name="systype" value="">
<input type="hidden" id="ishide" name="ishide" value="0">
<input type="hidden" id="aid" name="aid" value="<?=$gallerydetail['aid']?>">
<input type="hidden" id="clienttype" name="clienttype" value="<?=$clienttype?>">
<tr><th>请选择类型</th><td>
<select name="typesel" id="typesel" class="w300"  onchange="check_type()">
	<option name="0" value="1" <?php if($gallerydetail['paid']==0){echo "selected";}else{echo "disabled";}?>  >一级分类</option>
	<option name="0" value="2" <?php if($gallerydetail['paid']==0){echo "disabled";}else{echo "selected";}?>  >二级分类</option>
</select>
</td></tr>
	
<tr id="typese2" <?php if($gallerydetail['paid']==0){echo 'style="display:none"';}?>;">
	<th>请选择一级分类</th>
	<td>
	<select id="sidsecond" name="paid" class="w300">
	 <option  value="0" >请选择</option>
	<?php if(!empty($gallerys) && is_array($gallerys)){foreach($gallerys as $gallery){?>
	<option name="<?=$gallery['systype']?>" value="<?=$gallery['aid']?>" <?=($gallery['aid']==$gallerydetail['paid'])?'selected':''?>><?=$gallery['alname']?></option>
	<?php }}?>
	</select>
	</td>
</tr>	
<tr>
	<th>名称<span>＊</span><br><p>分类的名称</p></th>
	<td>
		<input type="text" id="alname" name="alname" value="<?=$gallerydetail['alname']?>" class="easyui-validatebox w300" required missingMessage="请输入分类名称">
	</td>
</tr>
<tr>
	<th>排序号<span>＊</span><p>数字小的排在上面</p></th>
	<td><input type="text" id="displayorder" name="displayorder" value="<?=$gallerydetail['displayorder']?>"   onblur="check_order()" class="easyui-validatebox w300" required missingMessage="请输入排序号"/></td>
</tr>
<tr>
	<th>是否显示:<p>默认显示</p></th>
	<td><input type="checkbox" id="isshow"  value="" <?php if(!empty($gallerydetail['ishide'])&&($gallerydetail['ishide']==1)){echo '';}else{echo 'checked';}?> onchange="change()"/>
	</td>
</tr>
</table><div class="buttons">
<input type="submit" name="valuesubmit" value="提交保存" class="submit"/>
</div>
</form><br>
<script type="text/javascript">
	$('#typesel').change(function(){
		if($('#typesel').val() == 1){
			$('#typese2').hide();
		} else {
			$('#typese2').show();
		}
	});
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
	    var $name = $("#paid");
	    var $area = $name.parent('td');
	    var $systype = $("#systype")
	    $("em",$area).remove();
	    aid = $.trim($name.val());
	    var systype = $("#paid option:selected").attr("name");
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