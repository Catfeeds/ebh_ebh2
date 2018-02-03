<?php
$this->display('admin/header');
?>
<body>
    
    
    <table id="dg" title="年级列表" class="easyui-datagrid" style="width:1200px;height:630px"
            toolbar="#toolbar"
            rownumbers="true" fitColumns="true" singleSelect="true"
			nowrap="true"
			>
        <thead>
            <tr>
				<th field="gradeid" width="25">gradeid</th>
				<th field="gradename" width="80">年级名称</th>
				
                <th field="displayorder" width="20">排序</th>
				
				<th field="operation" width="60">操作</th>
				
            </tr>
        </thead>
		
    </table>
	
	<?php
	$this->display('admin/pagination');
	?>
	
    <div id="toolbar">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" onclick="addgrade()" plain="true">添加年级</a>
		<input id="search-input" type="text" onkeypress="presstosearch(event);"/>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" onclick="dosearch()" >搜索</a>
	</div>
	
	
	
    
    <div id="dlg-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="savegrade()">保存</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="$('#dlg_grade').dialog('close')">取消</a>
    </div>
	
	
	<div id="dlg_grade" class="easyui-dialog" style="width:400px;height:280px;padding:10px 20px"
            closed="true" buttons="#dlg-buttons">
        <div class="ftitle">年级信息</div>
        <form id="form_grade" method="post" novalidate>
            <div class="fitem">
                <label>年级名称：</label>
                <input name="gradename" class="easyui-validatebox" required="true" missingMessage="填写年级名称">
				<input type="hidden" name="gradeid" id="gradeid" value=""/>
            </div>
            <div class="fitem">
                <label>排序</label>
                <input name="displayorder" class="easyui-validatebox" required="true" missingMessage="填写排序号">
            </div>
            
        </form>
    </div>
    <script type="text/javascript">
		function formatdata(datas)
		{
			for(var i=0;i<datas.length;i++)
			{
				datas[i].operation = 
				'<a href="javascript:editgrade()" class="easyui-linkbutton l-btn l-btn-plain" plain="true" onmouseover="$(this).css(\'color\',\'red\')" onmouseout="$(this).css(\'color\',\'#404040\')">[编辑]</a>'
				+
				'<a href="javascript:deletegrade()" class="easyui-linkbutton l-btn l-btn-plain" plain="true" onmouseover="$(this).css(\'color\',\'red\')" onmouseout="$(this).css(\'color\',\'#404040\')">[删除]</a>';
			}
		}
		
		$(function(){
			var datas = <?php echo $gradelist;?>;
			formatdata(datas);
            $('#dg').datagrid('loadData',datas);
        });
		
        var url;
		var message;
		function editgrade(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				
                $('#dlg_grade').dialog('open').dialog('setTitle','修改年级');
				$("#gradeid").val(row.gradeid);
				$('#form_grade').form('clear');
                $('#form_grade').form('load',row);
                url = '/admin/grade/editgrade.html?gradeid='+row.gradeid;
            }
		}
        function addgrade(){
			$('#dlg_grade').dialog('open').dialog('setTitle','添加年级');
			$('#form_grade').form('clear');
			url = '/admin/grade/addgrade.html';
		}
		function savegrade(){
			$('#form_grade').form('submit',{
				url:url,
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(result){
					if (result==1||result==0){
						showsuccess("操作成功");
                        $('#dlg_grade').dialog('close');
						$('.pagination-page-list').trigger('change');
                    }
                    else{
                        $.messager.show({
                            title: 'Error',
                            msg: result
                        });
                    } 
				}
			});
		}
        function deletegrade(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $.messager.confirm('确认','确定要删除该年级么？',function(r){
                    if (r){
                        $.post('/admin/grade/del.html',{gradeid:row.gradeid},function(result){
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
		
		function dosearch(){
			$.get('<?php echo geturl('admin/grade/getlist');?>',{'param[q]':$("#search-input").val()},function(data){getsearchdata(data);}
			);
		}
		function showsuccess(msg){
            $.messager.show({
                title:'成功',
                msg:msg,
				timeout:3000,
                showType:'show',
				style:{
                    left:'',
                    right:0,
                    top:document.body.scrollTop+document.documentElement.scrollTop,
                    bottom:''
                }
            });
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