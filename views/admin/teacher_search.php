<?php
$this->display('admin/header');
?>
<body>
	<div style="padding:10px 20px;">
        <table id="dg" class="easyui-datagrid" style="width:550px;height:310px;"
            toolbar="#toolbar"
            rownumbers="true" fitColumns="true" singleSelect="true"
			nowrap="true"
			>
        <thead>
            <tr>
				<th field="uid" width="15">uid</th>
                <th field="username" width="30">登录名</th>
                <th field="realname" width="40">真实姓名</th>
                <th field="phone" width="20">手机</th>
                <th field="tag" width="50">标签</th>
            </tr>
        </thead>
		
		</table>
	</div>
	
	<div id="toolbar">
		<input id="search-input" type="text" onkeypress="presstosearch(event);" value="<?php echo $where['q'];?>"/>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" onclick="dosearch()" >搜索</a>
	</div>
		<?php
		$this->display('admin/pagination');
		?>
	<script>
		function formatdata(){
		}
		$(function(){
			
			var datas = <?php echo $teacherlist;?>;
            $('#dg').datagrid('loadData',datas);
			
        });
		$('#dg').datagrid({
			onSelect:function(){
				var row = $('#dg').datagrid('getSelected');
				parent.$('#teacher_input')[0].value=row.username;
				parent.$('#teacher_hidden')[0].value=row.uid;
				parent.$('#teacher_input')[0].focus();
				parent.$('#dlg-teacher').dialog('close');
			}
		});
		function dosearch(){
			$.get('<?php echo geturl('admin/teacher/getlist');?>',{'param[q]':$("#search-input").val()},function(data){getsearchdata(data);}
			);
		}
	</script>
</body>
</html>