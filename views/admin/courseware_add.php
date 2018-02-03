<?php
$this->display('admin/header');
?>
<body id="main"><table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1 style="width:550px;">课件管理 -  添加课件信息</h1></td>
		<td class="actions" >
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tr>
			<td ><a href="/admin/courseware.html">浏览课件信息</a></td>
			<td ><a href="/admin/courseware/add.html" class="add">添加课件</a></td>
			</tr>
			</table>
		</td>
	</tr>
</table>
<form method="post" action="<?php echo geturl('admin/courseware/add');?>" onsubmit="return $(this).form('validate')">
<style type="text/css">
body{font-family:tahoma,verdana,arial;font-size:11px;line-height:15px;background-color:#FCFDFD;color:#666666;margin-left:20px;}
strong{font-size:12px;}
aink{color:#0066CC;}
a:hover{color:#FF6600;}
aisited{color:#003366;}
a:active{color:#9DCC00;}
</style>

<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
	<input type="hidden" name="token" value="<?=$token?>">
	<input type="hidden" name="op" value="add">
	<input type="hidden" name="formhash" value="<?=$formhash?>">
<tr>
	<th>课件标题<em>*</em><p>请输入名称名称，学员可以通过此名称查找到课件。</p></th>
	<td><input type="text" class="w300" maxlength="50" name="title" id="title" value=""  /></td>
</tr>
<tr>
	<th>课件副标题<p>请输入课件副标题，用于一些置顶的或者标题比较短的地方显示。</p></th>
	<td><input type="text" class="w300" maxlength="50" name="sub_title" value="" /></td>
</tr>
<tr><th>所属教师<em>*</em><p>请选择教室所属的教师。</p></th><td>       
<input type="text" readonly="readonly" value="" id="username" name="username">
<input type="button" id="drop" value="选择" />
<input type="hidden" name="uid" id="mediaid"  value="" />
</td></tr>
<tr>
	<th>所属分类<em>*</em><p>请输入课件的行业分类ID。</p></th>
	<td>
		<select name="catid" id="catid" class="w150">
		<?php $this->widget('category_widget',array('where'=>array('position'=>'1'),'tag'=>'catid'));?>
		</select>
	</td>
</tr>

<tr><th>所属年级</th><td>
<select name="grade" id="grade" class="w150">
<option value="" >选择年级</option>
</select>
</td></tr>
<tr><th>课件版本</th><td>
<select name="edition" id="edition" class="w150">
<option value="">选择版本</option>
</select></td></tr>

<tr>
	<th>所属标签<em>*</em><p>请输入课件标签，多个标签以逗号隔开。</p></th>
	<td><input type="text" class="w300" maxlength="50" name="tag" id="tag" value="" /></td>
</tr>
<tr>
	<th>课件摘要<em>*</em><p>请输入课件的摘要信息。</p></th>
	<td><textarea  class="p98" name="summary" style="width:600px" id="summary"  rows="5"  ></textarea></td>
</tr>
<tr>
	<th>课件详情<em>*</em><p>请输入课件的详细介绍资料。</p></th>
	<td><?php $editor->createEditor('message',"100%","300px",'');?></td>
</tr>
<tr><th>课件上传<em>*</em><p>请将制作好的课件文件上传。</p></th><td><?php $Upcontrol->upcontrol('cwurl',3);?></td></tr>
<tr><th>课件封面<em>*</em><p>请将课件封面图片上传。</p></th><td><?php $Upcontrol->upcontrol('logo',1,array(),'pic');?></td></tr>
<tr>
<th>课件封面LOGO<p>如果生成的缩略图不符合要求，可单独上传</p></th>
<td>

<table>
<tr>
<td valign="bottom" align="center" style="border:0">
<table>
<tr>
<td align="center">尺寸90x90</td>
</tr>
<tr>
<td align="center">
	<div>
		<span id="update90_90_spanuploadbutton"><?php $Upcontrol->upcontrol('update9090',1,array(),'pic');?></span>
	</div>
</td>
</tr>
</table>
</td>
<td valign="bottom" align="center" style="border:0">
<table>
<tr>
<td align="center">尺寸194x194</td>
</tr>
<tr>
<td align="center"><div><span id="update194_194_spanuploadbutton"><?php $Upcontrol->upcontrol('update194194',1,array(),'pic');?></span></div></td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>

<tr>
<th>热门级别</th>
<td> <input type="radio" name="hot" value="0" checked />非热门</input>
 <input type="radio" name="hot" value="1"  />热门Ⅰ</input>
 <input type="radio" name="hot" value="2"  />热门Ⅱ</input>
 <input type="radio" name="hot" value="3" />热门Ⅲ</input>
</td></tr>                                                                                                          
 <tr><th>置顶级别</th><td>
 <input type="radio" name="top" value="0" checked />非置顶</input>
 <input type="radio" name="top" value="1"  />置顶Ⅰ</input>
 <input type="radio" name="top" value="2"  />置顶Ⅱ</input>
 <input type="radio" name="top" value="3" />置顶Ⅲ</input>
 </td></tr> 
    <tr><th>精华级别</th><td>
  <input type="radio" name="best" value="0"  checked />非精华</input>
  <input type="radio" name="best" value="1"   />精华Ⅰ</input>
 <input type="radio" name="best" value="2"    />精华Ⅱ</input>
 <input type="radio" name="best" value="3"    />精华Ⅲ</input>
 </td></tr> 
 
 
<tr>
	<th>课件提交价<p>教师提交的课件价格,此价格需要审核,最终价格以核准价为准,0表示免费。</p></th>
	<td><input type="text" class="w300" maxlength="50" readonly="readonly" name="verifyprice" value="0.00" /></td>
</tr>
<tr>
	<th>课件审核价<em>*</em><p>请输入学生学习此课件的售价,0表示免费。(必须为整数)</p></th>
	<td><input type="text" class="w300" maxlength="50" id='price' name="price" value="0" /></td>
</tr>
<tr>
	<th>排序号<em>*</em><p>请输入此课件的排序号，越小越靠前。</p></th>
	<td><input type="text" class="w300" maxlength="50" id='displayorder' name="displayorder" value="500" />
	</td>
</tr>
<tr style=''>
<th>状态</th>
<td>
<input type="radio" name="status"  value="-1" />审核不通过&nbsp;&nbsp;
<input type="radio" name="status"   value="0" />未审核&nbsp;&nbsp;
<input type="radio" checked='checked' name="status" value="1" />已审核&nbsp;&nbsp;
<input type="radio" name="status"  value="-2" />已禁用&nbsp;&nbsp;
<input type="radio" name="status"  value="-3" />已删除&nbsp;&nbsp;
</td>
<tr id="trcheckinfo" style="display: none;"><th>不通过原因<em>*</em><p>请输入此课件审核不通过原因。</p></th><td><textarea id="checkinfo" name="checkinfo" rows="3" cols="100"></textarea></td></tr>
<input type="hidden" name="cwid" value="9878"></input>
</table>
<div id="dialog"></div> 
<div class="buttons">
<input type="submit" name="valuesubmit" value="提交保存" class="submit">
<input type="reset"	 name="valuereset" value="重置">
 
</div>
</form>
</body>
<script type="text/javascript">

$(function(){

	$('#catid').change(function(){
		var catid = $(this).val();
		$.post('/admin/coursewareattr/getGradeSelect.html',{catid:catid},function(message){
			$("#grade").html(message);
		});
	});

	$('#catid').change(function(){
		var catid = $(this).val();
		$.post('/admin/coursewareattr/getEditionSelect.html',{catid:catid},function(message){
			$("#edition").html(message);
		});
	});
});
$('#drop').click(function(){
		$('#dialog').dialog({    
	    title: '选择用户',    
	    width:Math.ceil($(document).width()/2),
		height:450, 
	    closed: false,    
	    cache: false,    
	    href: '/admin/teacher/lite.html',    
	    modal: true   
	});
	$("#ck").trigger('click');    
});
$.extend($.fn.validatebox.defaults.rules, {    
    isprice: {    
        validator: function(value, param){    
              return /^[0-9]{1,}([\.][0-9]{2})?$/.test(value);     
        }     
    },
    isnum: {    
        validator: function(value, param){    
              return /^[0-9]{1,}$/.test(value);     
        }     
    }   
}); 
$(function(){
    $('#title').validatebox({    
        required: true,    
        validType: 'length[4,50]',
        missingMessage:'标题不能为空',
        invalidMessage:'课件标题长度必须为4-50个字符'
    });
     $('#tag').validatebox({    
        required: true,    
        validType: 'length[2,120]',
        missingMessage:'标签不能为空',
        invalidMessage:'课件标签长度必须为2-120个字符'
    });  
     $('#summary').validatebox({    
        required: true,    
        validType: 'length[10,1000]',
        missingMessage:'课件摘要不能为空',
        invalidMessage:'课件摘要长度必须为10-1000个字符'
    });
     $('#price').validatebox({    
        required: true,
        validType:'isprice',
        missingMessage:'审核价不能为空',
        invalidMessage:'课件审核价格式不正确,必须为正整数或者两位小数的浮点数'
    }); 
     $('#displayorder').validatebox({    
        required: true,    
        validType: 'isnum',
        missingMessage:'排序不能为空',
        invalidMessage:'排序必须为正整数'
    }); 
});
</script>
<?php
$this->display('admin/footer');
?>