<?php
$this->display('admin/header');
?>
<body id="main">
<form method="post" enctype="multipart/form-data" action="/admin/templates/addtemplates.html" onsubmit="return checkAll()" id="itemform">
<input type="hidden" id="ishide" name="ishide" value="0">
<input type="hidden" id="clienttype" name="clienttype" value="<?=$clienttype?>">
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable" >
<tr>
	<th>选择主类</th>
	<td>
	<select id="selectp" name="paid" onChange="selectgallery(this.value)" class="w300">
		<option name="0" value="0" >请选择</option>
	</select>
	</td>
</tr>
<tr>
	<th>选择子类</th>
	<td>
	<select id="sidsecond" name="aid" class="w300">
	 <option  value="0" >请选择</option>
	</select>
	</td>
</tr>
<tr>
    <th>模板名称</th>
    <td><input name="photoname" id="photoname" value="" class="easyui-validatebox w300" required missingMessage="请输入图片名称" onblur="check_name()"/></td>
</tr>
<tr>
	<th>上传效果图</th><td>
	<input type="file" name="uploadfile" id="uploadfile" style="display:none" onchange="check_pic()" accept="image/gif,image/png,image/jpg,image/jpeg"/>
	<button type="button" id="upbtn" onclick="document.getElementById('uploadfile').click();" />上传</button>
	<span  id="filemessage">图片大小不超过5M</span></td>
</tr>
<tr>
	<th>是否显示:<p>默认显示</p></th>
	<td><input type="checkbox" id="isshow"  value="" checked onchange="change()"/>
	</td>
</tr>
</table>
<div class="buttons">
<input type="submit" name="valuesubmit" value="提交保存" class="submit">

</div>
<div id="dialog"></div>  
</body>
<script type="text/javascript">
	var clienttype = <?=$clienttype?>;
   	$.post("/admin/templates/gettemplatesclass.html",
   	{paid:0,clienttype:clienttype},
    function(data){
    	data = JSON.parse(data);
    	var palname = $("#selectp");
		var gallerylist = data.data;
			$.each(gallerylist,function(i,item){
				palname.append('<option value="'+item.aid+'">'+item.alname+'</option>');
				
			})
    	}
   );
	function selectgallery(paid){
		var palname = $("#sidsecond");
		$(' option',palname).remove('');
		palname.append('<option value="0">请选择</option>');
		$.ajax({
			type:"post",
			url:"/admin/templates/gettemplatesclass.html",
			async:true,
			data:{paid:paid,clienttype:clienttype},
			dataType:'json',
			success:function(data){
				var gallerys = data.data;
				if(gallerys && (paid != 0)){
					$.each(gallerys,function(i,item){
						palname.append('<option value="'+item.aid+'">'+item.alname+'</option>');
						
					})
				}
			}
		});	
	}
	function check_aid(){
	    var $name = $("#sidsecond");
	    var $area = $name.parent('td');
	    $("em",$area).remove();
	    var aid = $.trim($name.val());
	    if((aid=='0')){
	      $area.append('<em class="error">分类不能为空</em>');
	      $("html,body:not(:animated)").animate({scrollTop:$name.offset().top-50},1000);
	      return false;
	    } else {
	      return true;
	    }
	}
	/** 
	 * 校验图片尺寸 
	 */  
	function check_pic() {
		var files= $("#uploadfile").prop('files');
		if(files.length==0){
	      	$.messager.show({   
                           title: 'Error',
                           msg: '没有图片上传'
                       });
	      	return false;
	   	}
		var size = (files[0].size / 1024 )/ 1024;
		var type = files[0].type;
		var pictype = ['image/gif','image/png','image/jpg','image/jpeg'];       
		if(size>5){
	      	$.messager.show({   
                           title: 'Error',
                           msg: '图片大小不超过5M'
                       });
	      	return false;
	    } 
	    if($.inArray(type,pictype)==-1){
	    	$.messager.show({   
                           title: 'Error',
                           msg: '只能上传gif,png,jpg,jpeg类型的图片'
                       });
            return false;
	    }
	    $("#upbtn").html("已上传");
	    return true; 
	};
	function check_name(){
	    var $name = $("#photoname");
	    var $area = $name.parent('td');
	    $("em",$area).remove();
	    $name.val($.trim($name.val()));
	    if($name.val().length>50){
	      $area.append('<em class="error">名称大小不能超过50字</em>');
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
    	if(check_aid() && check_name() && check_pic()){
    		$(this).form('validate');
    		return true;
    	}else{
    		return false;
    	}
  	}
</script>