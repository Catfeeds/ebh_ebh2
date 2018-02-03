<?php
$this->display('admin/header');
?>
<style>
.maintable th{
	font-size:14px
}
.wh20{
	width:20px;
	height:20px;
}
.fz14{
	font-size:14px;
}
</style>
<body id="main">
	<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
		<tr>
			<th>请选择菜单类型</th>
			<td>
				<select id="typesel" style="width:300px">
					<option value="1">一级菜单</option>
					<?php if(!empty($menulist)){//有一级菜单才给选二级?>
					<option value="2">二级菜单</option>
					<?php }?>
				</select>
			</td>
		</tr>
	</table>
	<div id="form1">
		<form id="form_menu" method="post" onsubmit="return $(this).form('validate')" action="<?=geturl('admin/menu/add')?>" >
			<input type="hidden" name="crid" value="<?=$crid?>">
		<input type="hidden" name="roomtype" value="<?=$this->input->get('roomtype')?>">
		<table cellspacing="0" cellpadding="0" width="100%"  class="maintable" style="border-top:none">
			<tr>
			<th>跳转地址：<p>点击菜单后跳转地址。</p></th>
			<td>
				<input name="url" class="easyui-validatebox w300" value=""/>
				<input type="button" id="choosebtn" value="选择" />
			</td>
			</tr>
			
			<tr>
			<th>名称：<em>*</em><p>菜单的名称。</p></th>
			<td>
				<input name="mtitle" class="easyui-validatebox w300" maxlength="20" value="" required="true"/>
			</td>
			</tr>
			
			<tr>
			<th>图标地址：<p>菜单前显示的小图标</p></th>
			<td>
				<input name="icon" class="easyui-validatebox w300" value=""/>
			</td>
			</tr>
			
			<tr>
			<th>排序号：<em>*</em><p>数字大的排在上面</p></th>
			<td>
				<input name="mdisplayorder" class="mdisplayorder easyui-validatebox w300" value="" required="true"/>
			</td>
			</tr>
			
			<tr>
			<th>是否显示：<em></em><p></p></th>
			<td>
				<input type="checkbox" name="status" value="1" class="easyui-validatebox w300" style="width:20px;height:20px"/>
			</td>
			</tr>
		</table>
		<div class="buttons">
			<input type="submit" value="提交保存" class="submit">
		</div>
		</form>
	</div>
	
	<div id="form2" style="display:none">
		<form id="form_menu2" method="post" onsubmit="return $(this).form('validate')" action="<?=geturl('admin/menu/add')?>" >
		<input type="hidden" name="crid" value="<?=$crid?>">
		<input type="hidden" name="roomtype" value="<?=$this->input->get('roomtype')?>">
		<table cellspacing="0" cellpadding="0" width="100%"  class="maintable" style="border-top:none">
			<tr>
				<th>选择一级菜单</th>
				<td>
					<select style="width:300px" name="tmid">
						<?php if(!empty($menulist)){
							foreach($menulist as $menu){?>
							<option value="<?=$menu['mid']?>"><?=$menu['mtitle']?></option>
						<?php }
						}?>
					</select>
				</td>
			</tr>
			<tr>
			<th>跳转地址：<em>*</em><p>点击菜单后跳转地址。</p></th>
			<td>
				<input name="url" class="easyui-validatebox w300" value=""/>
				<input type="button" id="choosebtnlevel2" value="选择" />
			</td>
			</tr>
			
			<tr>
			<th>名称：<em>*</em><p>菜单的名称。</p></th>
			<td>
				<input name="mtitle" class="easyui-validatebox w300" maxlength="20" value="" required="true"/>
			</td>
			</tr>
			
			<tr>
			<th>排序号：<em>*</em><p>数字大的排在上面</p></th>
			<td>
				<input name="mdisplayorder" class="mdisplayorder easyui-validatebox w300" value="" required="true"/>
			</td>
			</tr>
			
			<tr>
			<th>是否显示：<em></em><p></p></th>
			<td>
				<input type="checkbox" name="status" value="1" class="easyui-validatebox w300" style="width:20px;height:20px"/>
			</td>
			</tr>
		</table>
		<div class="buttons">
			<input type="submit" value="提交保存" class="submit">
		</div>
		</form>
	</div>
	<div id="dialog"></div> 
	<script>

	$(document).on('keyup','.mdisplayorder',function(){
		$(this).val($(this).val().replace(/[^\d]/g,''));
	});
	$('#typesel').change(function(){
		if($('#typesel').val() == 1){
			$('#form1').show();
			$('#form2').hide();
		} else {
			$('#form1').hide();
			$('#form2').show();
		}
	});
	
	$('#choosebtn').click(function(){
		$('#dialog').dialog({
	    title: '选择',    
	    width:700,
		height:450, 
	    closed: false,    
	    cache: false,    
	    href: '/admin/menu/choose.html',    
	    modal: true   
	});
	$("#ck").trigger('click');    
	});
	$('#choosebtnlevel2').click(function(){
		$('#dialog').dialog({
	    title: '选择',    
	    width:700,
		height:450, 
	    closed: false,    
	    cache: false,    
	    href: '/admin/menu/choose.html',    
	    modal: true   
	});
	$("#ck").trigger('click');    
	});
	</script>
	<style>
		.fitem{
			margin-bottom:5px;
		}
		.fitem label{
			display:inline-block;
			width:80px;
		}
	</style>
</body>
<?php
$this->display('admin/footer');
?>