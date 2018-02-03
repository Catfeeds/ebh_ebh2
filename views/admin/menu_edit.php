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
	
	<?php if(empty($menudetail['tmid'])){//一级菜单?>
	<div id="form1">
		<form id="form_menu" method="post" onsubmit="return $(this).form('validate')" action="<?=geturl('admin/menu/edit')?>" >
		<input type="hidden" name="crid" value="<?=$crid?>">
		<input type="hidden" name="mid" value="<?=$menudetail['mid']?>">
		<input type="hidden" name="roomtype" value="<?=$this->input->get('roomtype')?>">
		<table cellspacing="0" cellpadding="0" width="100%"  class="maintable" style="border-top:none">
			<tr>
			<th>名称：<em>*</em><p>菜单的名称。</p></th>
			<td>
				<input name="mtitle" class="easyui-validatebox w300" maxlength="20" value="<?=$menudetail['mtitle']?>" required="true"/>
				<input name="oldmtitle" type="hidden" value="<?=$menudetail['mtitle']?>"/>
			</td>
			</tr>
			
			<tr>
			<th>图标地址：<p>菜单前显示的小图标</p></th>
			<td>
				<input name="icon" class="easyui-validatebox w300" value="<?=$menudetail['icon']?>"/>
			</td>
			</tr>
			
			<tr>
			<th>排序号：<em>*</em><p>数字大的排在上面</p></th>
			<td>
				<input name="mdisplayorder" class="mdisplayorder easyui-validatebox w300" value="<?=$menudetail['mdisplayorder']?>" required="true"/>
			</td>
			</tr>
			
			<tr>
			<th>是否显示：<em></em><p></p></th>
			<td>
				<input type="checkbox" name="status" value="1" class="easyui-validatebox w300" style="width:20px;height:20px" <?=$menudetail['status']?'checked="checked"':''?>/>
			</td>
			</tr>
		</table>
		<div class="buttons">
			<input type="submit" value="提交保存" class="submit">
		</div>
		</form>
	</div>
	<?php }else{?>
	<div id="form2">
		<form id="form_menu2" method="post" onsubmit="return $(this).form('validate')" action="<?=geturl('admin/menu/edit')?>" >
		<input type="hidden" name="crid" value="<?=$crid?>">
		<input type="hidden" name="mid" value="<?=$menudetail['mid']?>">
		<input type="hidden" name="roomtype" value="<?=$this->input->get('roomtype')?>">
		<table cellspacing="0" cellpadding="0" width="100%"  class="maintable" style="border-top:none">
			<tr>
				<th>选择一级菜单</th>
				<td>
					<select style="width:300px" name="tmid">
						<?php if(!empty($menulist)){
							foreach($menulist as $menu){?>
							<option value="<?=$menu['mid']?>" <?=$menu['mid']==$menudetail['tmid']?'selected="selected"':''?>><?=$menu['mtitle']?></option>
						<?php }
						}?>
					</select>
				</td>
			</tr>
			<tr>
			<th>名称：<em>*</em><p>菜单的名称。</p></th>
			<td>
				<input name="mtitle" class="easyui-validatebox w300" maxlength="20" value="<?=$menudetail['mtitle']?>" required="true"/>
				<input name="oldmtitle" type="hidden" value="<?=$menudetail['mtitle']?>"/>
			</td>
			</tr>
			<?php if(empty($crid) || !empty($menudetail['crid'])){?>
			<tr>
			<th>跳转地址：<p>点击菜单后跳转地址。</p></th>
			<td>
				<input name="url" class="easyui-validatebox w300" value="<?=$menudetail['url']?>"/>
			</td>
			</tr>
			<?php }?>
			
			<tr>
			<th>排序号：<em>*</em><p>数字大的排在上面</p></th>
			<td>
				<input name="mdisplayorder" class="mdisplayorder easyui-validatebox w300" value="<?=$menudetail['mdisplayorder']?>" required="true"/>
			</td>
			</tr>
			
			<tr>
			<th>是否显示：<em></em><p></p></th>
			<td>
				<input type="checkbox" name="status" value="1" class="easyui-validatebox w300" style="width:20px;height:20px" <?=$menudetail['status']?'checked="checked"':''?>/>
			</td>
			</tr>
		</table>
		<div class="buttons">
			<input type="submit" value="提交保存" class="submit">
		</div>
		</form>
	</div>
	<?php }?>
	<script>
		
	$(document).on('keyup','.mdisplayorder',function(){
		$(this).val($(this).val().replace(/[^\d]/g,''));
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