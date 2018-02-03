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
	<form id="form_module" method="post" onsubmit="return $(this).form('validate')" action="<?php geturl('admin/appmodule/add');?>" >
		<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
			<tr>
			<th>模块名称：<em>*</em><p>模块的名称。</p></th>
			<td>
                <input name="modulename" class="easyui-validatebox w300" value="" required="true"/>
			</td>
			</tr>
			
			<tr>
			<th>模块编码：<em>*</em><p>英文代码,如college</p></th>
			<td>
                <input name="modulecode" class="easyui-validatebox w300" value="" required="true"/>
            </td>
			</tr>
			
			<tr>
			<th>跳转地址：<em>*</em><p>点击模块后跳转地址。</p></th>
			<td>
                <input name="url" class="easyui-validatebox w300" value="" required="true"/>
			</td>
			</tr>
			
			<tr>
			<th>系统模块：<em></em><p>是否系统模块</p></th>
			<td>
                <input type="checkbox" name="system" value="1" class="easyui-validatebox w300" style="width:20px;height:20px"/>
			</td>
			</tr>
			
			<tr>
			<th>classname：<em></em><p>样式的名称</p></th>
			<td>
                <input name="classname" class="easyui-validatebox w300" value=""/>
			</td>
			</tr>
			
			<tr>
			<th>页面打开方式：<em></em><p>不填默认为框架子页面</p></th>
			<td>
				<input name="target" class="easyui-validatebox w300 target" value=""/>
				<input type="button" class="targettype targettype1" value="新页面" targetstr="_blank"/>
				<input type="button" class="targettype targettype2" value="本页面" targetstr="_self"/>
				<input type="button" class="targettype targettype2" value="顶层页面" targetstr="_top"/>
			</td>
			</tr>
			
			<tr>
			<th>不自动补充url：<em></em><p>sns空间上,链接前不会添加http://域名.ebh.net/myroom.html?url=</p></th>
			<td>
                <input type="checkbox" name="isstrict" value="1" class="easyui-validatebox w300" style="width:20px;height:20px"/>
			</td>
			</tr>
			
			<tr>
			<th>应用于学生/老师：<em></em><p>学生模块还是老师模块</p></th>
			<td>
				<label>
                <input type="radio" name="tors" value="0" class="wh20" checked="checked"/>
				<span class="fz14">学生</span>
				</label>
				<label>
                <input type="radio" name="tors" value="1" class="wh20"/>
				<span class="fz14">老师</span>
				</label>
				<label>
                <input type="radio" name="tors" value="2" class="wh20"/>
				<span class="fz14">学生和老师</span>
				</label>
			</td>
			</tr>
			
			<tr>
			<th>显示方式：<em></em><p>模块在什么地方显示</p></th>
			<td>
				<label>
                <input type="radio" name="showmode" value="0" class="wh20" checked="checked"/>
				<span class="fz14">作为显式模块在导航中</span>
				</label>
				<label>
                <input type="radio" name="showmode" value="1" class="wh20"/>
				<span class="fz14">某些特定页面中</span>
				</label>
			</td>
			</tr>
			
			<tr>
			<th>默认更多：<em></em><p>是否默认显示在更多模块里</p></th>
			<td>
                <input type="checkbox" name="ismore" value="1" class="easyui-validatebox w300" style="width:20px;height:20px"/>
			</td>
			</tr>
            <tr>
                <th>学生模块说明：</th>
                <td><textarea name="remark" cols="100" rows="5"></textarea></td>
            </tr>
            <tr>
                <th>教师模块说明：</th>
                <td><textarea name="remark_t" cols="100" rows="5"></textarea></td>
            </tr>
    </div>
	</table>
	<div class="buttons">
		<input type="submit" value="提交保存" class="submit">
    </div>
</form>
	
	<script>
		$(function(){
		
		})
		function savemodule(){
			if($('#form_module').form('validate')){
			
			
			
				$('#form_module').submit();
			}
		}
		
		
	$('.targettype').click(function(){
		$('.target').val($(this).attr('targetstr'));
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