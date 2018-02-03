<?php
$this->display('admin/header');
?>
<body id="main"><table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1 style="width:550px;">课件管理 -  修改课件信息</h1></td>
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
<form method="post" action="<?php echo geturl('admin/courseware/edit');?>" onsubmit="return $(this).form('validate')">
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
<input type="hidden" name="formhash" value="<?=$formhash?>">
<input type="hidden" name="cwid" value="<?=$c['cwid']?>">
<input type="hidden" name="crid" value="<?=$c['crid']?>">
<input type="hidden" name="op" value="edit">
<tr>
	<th>课件标题<em>*</em><p>请输入名称名称，学员可以通过此名称查找到课件。</p></th>
	<td><input type="text" class="w300" maxlength="50" name="title" id='title' value="<?=$c['title']?>"  /></td>
</tr>
<tr>
	<th>课件副标题<p>请输入课件副标题，用于一些置顶的或者标题比较短的地方显示。</p></th>
	<td><input type="text" class="w300" maxlength="50" name="sub_title" value="<?=$c['sub_title']?>" /></td>
</tr>
<tr><th>所属教师<em>*</em><p>请选择教室所属的教师。</p></th><td>       
<input type="text" readonly="readonly" value="<?=$c['username']?>" id="username" name="username">
<input type="button" id="drop" value="选择" />
<input type="hidden" name="uid" id="mediaid"  value="<?=$c['uid']?>" />
</td></tr>
<tr>
	<th>所属分类<em>*</em><p>请输入课件的行业分类ID。</p></th>
	<td>
		<select name="catid" id="catid" class="w150">
		<?php $this->widget('category_widget',array('where'=>array('position'=>'1'),'tag'=>'catid','selected'=>$c['catid']));?>
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
	<td><input type="text" class="w300" maxlength="50" name="tag" id='tag' value="<?=$c['tag']?>" /></td>
</tr>
<tr>
	<th>课件摘要<em>*</em><p>请输入课件的摘要信息。</p></th>
	<td><textarea  class="p98" name="summary"   rows="5" style="width:600px;" id='summary' ><?=$c['summary']?></textarea></td>
</tr>
<tr>
	<th>课件详情<em>*</em><p>请输入课件的详细介绍资料。</p></th>

	<td><?php $editor->createEditor('message',"100%","300px",$c['message']);?></td>
</tr>
<?php 
$cwParam = array(
	'upfilepath'=>$c['cwsource'].','.$c['cwurl'],
	'upfilename'=>$c['cwname'],
	'upfilesize'=>$c['cwsize']
	)
?>
<tr><th>课件上传<em>*</em><p>请将制作好的课件文件上传。</p></th><td><?php $Upcontrol->upcontrol('cwurl',3,$cwParam);?></td></tr>
<tr><th>课件封面<em>*</em><p>请将课件封面图片上传。</p></th><td><?php $Upcontrol->upcontrol('logo',1,array('upfilepath'=>$c['logo']),'pic');?></td></tr>
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
<td align="center"><div><span id="update90_90_spanuploadbutton"><?php $Upcontrol->upcontrol('update9090',1,array('upfilepath'=>$c['images']['image9090']),'pic');?></span></div></td>
</tr>
</table>
</td>
<td valign="bottom" align="center" style="border:0">
<table>

<td align="center">尺寸194x194</td>
</tr>
<tr>
<td align="center"><div><span id="update194_194_spanuploadbutton"><?php $Upcontrol->upcontrol('update194194',1,array('upfilepath'=>$c['images']['image194194']),'pic');?></span></div></td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
<?php $this->widget('bth_widget',array('hot'=>$c['hot'],'top'=>$c['top'],'best'=>$c['best']));?> 
<tr>
	<th>课件提交价<p>教师提交的课件价格,此价格需要审核,最终价格以核准价为准,0表示免费。</p></th>
	<td><input type="text" class="w300" maxlength="50" readonly="readonly" name="verifyprice" value="<?=$c['verifyprice']?>" /></td>
</tr>
<tr>
	<th>课件审核价<em>*</em><p>请输入学生学习此课件的售价,0表示免费。(必须为整数)</p></th>
	<td><input type="text" class="w300" maxlength="50" name="price" id='price' value="<?=$c['price']?>" />
	</td>
</tr>
<tr>
	<th>排序号<em>*</em><p>请输入此课件的排序号，越小越靠前。</p></th>
	<td><input type="text" class="w300" maxlength="50" name="displayorder" id='displayorder' value="<?=$c['displayorder']?>" /></td>
</tr>
<tr style=''>
<th>状态</th>
<td>
<input type="radio" name="status"  value="-1" <?php if($c['status']==-1){echo 'checked=checked';}?>/>审核不通过&nbsp;&nbsp;
<input type="radio" name="status"  value="0"  <?php if($c['status']==0){echo 'checked=checked';}?> />未审核&nbsp;&nbsp;
<input type="radio" name="status"  value="1"  <?php if($c['status']==1){echo 'checked=checked';}?> />已审核&nbsp;&nbsp;
<input type="radio" name="status"  value="-2" <?php if($c['status']==-2){echo 'checked=checked';}?> />已禁用&nbsp;&nbsp;
<input type="radio" name="status"  value="-3" <?php if($c['status']==-3){echo 'checked=checked';}?> />已删除&nbsp;&nbsp;
<input type="hidden" value='0' id='coursecheck'  name='coursecheck'>
</td>
<tr id="trcheckinfo" style="display: none;"><th>不通过原因<em>*</em><p>请输入此课件审核不通过原因。</p></th><td><textarea id="checkinfo" name="checkinfo" rows="3" cols="100"></textarea></td></tr>

</table>
<div id="dialog"></div> 
<div class="buttons">
<input type="submit" name="valuesubmit" value="提交保存" class="submit">
<input type="reset"	 name="valuereset" value="重置">
 
</div>
</form><br><div id="footer"><span>Zhejiang Svnlan Technologies 2011. </span></div>
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

	$.post('/admin/coursewareattr/getGradeSelect.html',{catid:"<?=$c['catid']?>",selected:"<?=$c['grade']?>"},function(message){
			$("#grade").html(message);
		});
	$.post('/admin/coursewareattr/getEditionSelect.html',{catid:"<?=$c['catid']?>",selected:"<?=$c['edition']?>"},function(message){
		$("#edition").html(message);
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