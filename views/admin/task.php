<?php
$this->display('admin/header');
?>
<body>
    
    
    <table id="dg" title="任务列表" class="easyui-datagrid" style="width:1200px;height:630px"
            toolbar="#toolbar"
            rownumbers="true" fitColumns="true" singleSelect="true"
			nowrap="true"
			>
        <thead>
            <tr>
				
				<th field="name" width="25">任务名称</th>
				<th field="image" width="25">任务图片</th>
                <th field="url" width="50">跳转地址</th>
				<th field="description" width="40">任务描述</th>
				<th field="reward" width="15">任务奖励</th>
                <th field="rulename" width="20">积分规则</th>
				<th field="displayorder" width="10">排序</th>
				<th field="type" width="20">任务类型</th>
				<th field="operation" width="50">操作</th>
				
            </tr>
        </thead>
		
    </table>
	
	<?php
	$this->display('admin/pagination');
	?>
    
	
	<div id="toolbar">
        <a href="<?php echo geturl('admin/task/add');?>" class="easyui-linkbutton" iconCls="icon-add" plain="true">添加新任务</a>
        
    </div>
    
    <script type="text/javascript">
		var typearr = new Array();
		typearr[1] = '新手任务';
		typearr[2] = '日常任务';
		typearr[3] = '学习任务';
		function formatdata(datas)
		{
			for(var i=0;i<datas.length;i++)
			{
				datas[i].type = typearr[datas[i].type];
				datas[i].image = '<img src="http://static.ebanhui.com/ebh'+datas[i].image+'" width="100"/>';
				datas[i].operation = 
				'<a href="/admin/task/edit.html?id='+datas[i].id+'" class="easyui-linkbutton l-btn l-btn-plain" plain="true" onmouseover="$(this).css(\'color\',\'red\')" onmouseout="$(this).css(\'color\',\'#404040\')">[编辑]</a>'
				+
				'<a href="javascript:deletetask()" class="easyui-linkbutton l-btn l-btn-plain" plain="true" onmouseover="$(this).css(\'color\',\'red\')" onmouseout="$(this).css(\'color\',\'#404040\')">[删除]</a>';
				
			}
			return datas;
		}
		
		$(function(){
			var datas = <?php echo $tasklist;?>;
			formatdata(datas);
            $('#dg').datagrid('loadData',datas);
        });
		
        function deletetask(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $.messager.confirm('确认','确定要删除该任务么？',function(r){
                    if (r){
                        $.post('<?php echo geturl('admin/task/del')?>',{id:row.id},function(result){
                            if (result.success){
								$.messager.show({
									timeout:2000,
                                    title: '成功',
                                    msg: '删除成功'
                                });
								$('.pagination-page-list').trigger('change');
                            } else {
                                $.messager.show({
                                    title: 'Error',
                                    msg: result.errorMsg
                                });
                            }
                        },'json');
                    }
                });
            }
        }
		
    </script>
    <style type="text/css">
        #fm{
            margin:0;
            padding:10px 30px;
        }
        .ftitle{
            font-size:14px;
            font-weight:bold;
            padding:5px 0;
            margin-bottom:10px;
            border-bottom:1px solid #ccc;
        }
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