<?php
	$this->display('admin/header');
?>
<body id="main">
	<table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr>
			<td><h1>专题管理 - 专题列表</h1></td>
			<td class="actions">
				<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
				<tr>
				<td ><a href="/admin/special.html">浏览专题</a></td>
				<td  class="active"><a href="/admin/special/add.html" class="add">添加专题</a></td>
				</tr>
				</table>
			</td>
		</tr>
	</table>
<form method="post" id="submitform" action="/admin/special/op.html" >
<input type="hidden" name="op" value="<?=$op?>" />
<input type="hidden" name="sid" value="<?=$s['sid']?>" />
<input type="hidden" name="token" value="<?=$token?>" />
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
	<tr>
		<th>专题分类 <em>*</em></th>
		<td>
			<select id="category" name="catid" class="w150">
			<option value="0" >专题分类</option>
			<?php $this->widget('category_widget',array('where'=>array('type'=>'special'),'tag'=>'category','selected'=>$s['catid'])); ?>
 			</select>
		</td>
	</tr>
	<tr>
		<th>专题标题 <em>*</em></th>
		<td><input type="text"  class="w300"  name="title" value="<?=$s['title']?>"/></td>
	</tr>
	<tr>
		<th>横幅图片</th>
		<td>
			<?php
			  if(empty($s['banner'])){
			    $Upcontrol->upcontrol('banner',1,array(),'pic');
			  }else{
			  	echo '<img alt="" width="90px" height="90px" border="1" src="'.$s['banner'].'">';
			    $Upcontrol->upcontrol('banner',1,array('upfilepath'=>$s['banner']),'pic');
			}
			?>
		</td>
	</tr>
<tr>
	<th>缩略图</th>
	<td>
		<?php
		  	if(empty($s['thumb'])){
		    	$Upcontrol->upcontrol('thumb',1,array(),'pic');
		  	}else{
		  		echo '<img alt="" width="90px" height="90px" border="1" src="'.$s['thumb'].'">';
		    	$Upcontrol->upcontrol('thumb',1,array('upfilepath'=>$s['thumb']),'pic');
			}
		?>
	</td>
</tr>
<tr><th>专题URL <em>*</em></th><td><input type="text" class="w300" name="urlrule" value="<?=$s['urlrule']?>"></td></tr>
<tr><th>专题导语概要</th><td><textarea name="description" id="description" cols="55" rows="3" class=""><?=$s['description']?></textarea></td></tr>
<tr><th>SEO关键字</th><td><input type="text" class="w300" name="seokeywords" value="<?=$s['seokeywords']?>" /><label> 格式如：ebh，PHP，高考专题</label></td></tr>
<tr><th>添加专题自定义导航</th>
	<td>

	<?php 
		$nav = unserialize($s['navigation']);$count=count($nav['subject']);$i=0;
		do{
			echo '<div style="margin-top:5px;" id="versiondiv">';
			echo '标题：<input type="text" name="subject[]" class="w150" id="subject" value="'.$nav['subject'][$i].'" />';
			echo '地址：<input type="text" class="w150" name="address[]" id="address" value="'.$nav['address'][$i].'" />';
			echo '排序: <input type="text" name="order[]" id="order" value="'.$nav['order'][$i].'" />
			<input type="button" value="删除此项" onclick="$(this).parent().remove();">';
			echo '</div><br />';
		}while((++$i)<$count);

	?>

<input type="button" name="" value="再加一个" style=" margin-top:5px;" id="addnewversion" />
<script type="text/javascript">
$(function(){
$("#addnewversion").click(function(){
$("#addnewversion").before('<div style="margin-top:5px;" id="versiondiv">标题：<input type="text" name="subject[]" class="w150" id="subject" />&nbsp;地址：<input type="text" class="w150" name="address[]" id="address" />&nbsp;排序:<input type="text" name="order[]" id="order" />&nbsp;<input type="button" value="删除此项" onclick="$(this).parent().remove();"></div>');
})
});
</script>
</td></tr>
<tr><th>专题内容模板</th><td><input type="text" name="tplmain" class="w300" value="<?=$s['tplmain']?>" />.html.php</td></tr>
<tr><th>专题头部模板</th><td><input type="text" name="tplhead" class="w300" value="<?=$s['tplhead']?>" />.html.php</td></tr>
<tr><th>专题脚部模板</th><td><input type="text" name="tplfoot" class="w300" value="<?=$s['tplfoot']?>" />.html.php</td></tr>
</table><div class="buttons">
<input type="submit" name="nextsubmit" value="保存并继续" class="submit">
<input type="submit" name="valuesubmit" value="提交保存" class="submit " >
<input type="reset"	 name="valuereset" value="重置" class="reset">
 
</div>
</form>
<br>
<script type='text/javascript'>
 
	$("input[name=urlrule]").validatebox({    
    	required: true,
    	missingMessage:'专题URL不能为空!'   
	});

	$("input[name=title]").validatebox({    
    	required: true,    
    	validType: 'length[2,50]',
    	missingMessage:'专题标题不能为空!',
    	invalidMessage:'标题长度必须处于2-50之间!'   
	});
	$(function(){
		$("#submitform").submit(function(){
			$("#category").triggerHandler('change');
			if($("#category").val()==0){
				var tag = false;
			}
			return ($(this).form('validate'))&&(tag);
		});
	});

	$(function(){
		$("#category").change(function(){
		e=$(this);
		var area = e.parent("td");
			if(e.val()==0){
				$("em[class=error]",area).remove();
				area.append('<em class="error">请选择专题!'+'</em>');
				$("html,body").animate({scrollTop:e.offset().top-20},1000);
				return false;
			}else{
				$("em[class=error]",area).remove();
			}
		});
	});

</script>
<div id="footer"><span>Zhejiang Svnlan Technologies 2011. </span></div>

<?php
	$this->display('admin/footer');
?>