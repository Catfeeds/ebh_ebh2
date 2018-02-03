<?php
$this->display('admin/header');
?>
<style type="text/css">
	.mr10 {
	margin-right: 10px;
	width: 100px;
    line-height: 30px;
    background: #fff;
    text-align: center;
    font-weight: 400;
    font-family: 'Lato', sans-serif;
    cursor: pointer;
    display: inline-block;
    border-radius: 4px;
    box-shadow: 0 -1px 0 #e0e0e0 inset, 0 1px 2px rgba(0, 0, 0, 0.23) inset;
}
</style>
<body id="main">
<form method="post" action="/admin/spitem/add.html" onsubmit="return $(this).form('validate')" id="itemform">
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
<tr>
	<th>一级分类</th>
	<td><?php if(!empty($bsid)){?>
		<select id="bsid" onchange="getNextSort(this.value,'msid')">
		<option selected = "selected" value="0">请选择</option>
		<?php foreach($bsid as $key=>$value){?>
			<option value="<?php echo $value['sid']?>"><?php echo $value['sname']?></option>
		<?php }?>
		</select>
		<?php } else {?>
			<select id="bsid" onchange="getNextSort(this.value,'msid')">
			<option selected = "selected" value="0">请选择</option>
		<?php }?>
	</td>
	<td >&nbsp;&nbsp;<a onclick="showAdd('#showbsid')" style="cursor: pointer;">新建一级分类&nbsp;&nbsp;</a><span id="showbsid" style="display:none;"><input type="text" id="bsidtext" name="bsidtext" /><input type="button" value="添加" onclick="addsort('bsid')"/></span></td>	
</tr>
<tr>
	<th>二级分类</th>
	<td>
		<select id="msid" onchange="alert('请添加三级类');showAdd('#showssid');">
		</select>
	</td>	
	<td>&nbsp;&nbsp;<a onclick="showAdd('#showmsid')" style="cursor: pointer;">新建二级分类&nbsp;&nbsp;</a><span id="showmsid" style="display:none;"><input type="text" id="msidtext" name="msidtext"/><input type="button" value="添加" onclick="addsort('msid')"/></span></td>
</tr>
<tr>
	<th>三级分类</th>
	<td>
		<select id="ssid" onchange="getLabel()">
		</select>
	</td>	
	<td>&nbsp;&nbsp;<a onclick="showAdd('#showssid')" style="cursor: pointer;">新建三级分类&nbsp;&nbsp;</a><span id="showssid" style="display:none;"><input type="text" id="ssidtext" name="ssidtext"/><input type="button" value="添加" onclick="addsort('ssid');labelHide()"/></span></td>
</tr>
<tr>
	<th>标签</th>
	<td>
		<label id="label">
			<span></span>
		</label>
		
	</td>
	<td>&nbsp;&nbsp;新建标签&nbsp;&nbsp;<input type="text" name="label" id="labell" /><input type="button" value="添加标签" onclick="addlabel()"/></td>	
</tr>
</table>
<div class="buttons">
<input type="reset"  name="valuereset" value="重置" onclick="hide()" />

</div>
<div id="dialog"></div>
</form>  
</body>
<script type="text/javascript">

	function getNextSort(sid,sorttype){
		if(sid == 0){
			return false;
		}else{
			var sort = '#'+sorttype;
			$.ajax({
			type:'post',
			url:'/admin/jingpin/getsortAjax.html',
			data:{sid:sid,sorttype:sorttype},
			success:function(data){	
				var data = eval('('+data+')');
				$(sort+' option').remove('');
				$(sort).append('<option selected = "selected" value="0">请选择</option>');
				$.each(data,function(i,item){
					$(sort).append('<option value="'+item.sid+'">'+item.sname+'</option>');
				})
			}
		});
		}		
	}

	function getLabel(){
		sid = $('#ssid').val();
		if(sid ==0){
			return false;
		}else{
			$.ajax({
				type:'post',
				url:'/admin/jingpin/getLabelAjax.html',
				data:{sid:sid},
				success:function(data){
					var data = eval('('+data+')');
					$('#label span').remove('');
					$.each(data,function(i,label){
						$('#label').append('<span>'+label.label+'&nbsp;</span>');
					})
				}
			});
		}
	}

	function addlabel() {
		sid = $('#ssid').val();
		label = $('#labell').val();
		if(!sid) {
			alert('请填写分类');return false;
		}
		if(!label) {
			alert('请填写标签名');return false;
		}
		$.ajax({
				type:'post',
				url:'/admin/jingpin/addlabelAjax.html',
				data:{sid:sid,label:label},
				success:function(data){
					if(data){
						var data = eval('('+data+')');
						if(data == 0) {
							alert("该分类下标签名已存在");
							return false;
						}
						var label = $('#labell').val();
						$('#label').append('<span class="mr10">'+label+'</span>');
						alert('添加成功');
						$('#labell').focus();
					}else{
						alert('添加失败，请重试..');
					}
				}
			});

	}


	function addsort(sorttype){
		if(sorttype =='bsid'){
			bsid = $('#bsid').val();
			psid = 0;
			path = '';
		}else if(sorttype =='msid'){
			psid = $('#bsid').val();
			if(psid == null || psid == 0) {
				alert('请先选择一级分类');
				showAdd('#showbsid');
				$('#bsidtext').focus();
				return false;
			}
			path = '/'+psid;
		}else{
			psid = $('#msid').val();
			bsid = $('#bsid').val();
			if(psid == null || psid == 0) {
				alert('请先添加二级分类');
				showAdd('#showmsid');
				$('#msidtext').focus();
				return false;
			}
			path = '/'+bsid+'/'+psid;
		}
		snametype = '#'+sorttype+'text';
		sname = $(snametype).val();
		if(!sname) {
			alert("请添加分类名");
			return false;
		}
		$.ajax({
				type:'post',
				url:'/admin/jingpin/addsortAjax.html',
				data:{psid:psid,path:path,sname:sname},
				success:function(data){
					if(data){
						var data = eval('('+data+')');
						if(data == 0) {
							alert("分类名已存在");return false;
						}
						$('#'+sorttype).append('<option selected = "selected" value="'+data.sid+'">'+data.sname+'</option>');
						alert("分类添加成功");
					}else{
						alert('添加失败，请重试..');
					}
				}
			});
	}

	function checksort(sname){
		$.ajax({
				type:'post',
				url:'/admin/jingpin/checksortAjax.html',
				data:{sname:sname},
				success:function(data){
					if(data){
						return true;
					}else{
						alert('该分类名已存在！');
						return false;
					}
				}
			});
	}

	function showAdd(obj){
		$(obj).show();
	}

	function labelHide() {
		$('#label').html('');
	}

	function hide() {
		$('#label').html('');
		$('#showbsid').hide();
		$('#showmsid').hide();
		$('#showssid').hide();
		window.location.reload();

	}
</script>
<?php
$this->display('admin/footer');
?>