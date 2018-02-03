<?php
$this->display('admin/header');
?>
<body>
    
    
    <table id="dg" title="分组列表" class="easyui-datagrid" style="width:1200px;height:630px"
            toolbar="#toolbar"
            rownumbers="true" fitColumns="true" singleSelect="true"
			nowrap="true"
			>
        <thead>
            <tr>
				<th field="groupid" width="25">groupid</th>
				<th field="groupname" width="80">名称</th>
				
                <th field="type" width="20">类型</th>
				
				<th field="operation" width="60">操作</th>
				
            </tr>
        </thead>
		
    </table>
	<?php
	$this->display('admin/pagination');
	?>
	<div id="toolbar">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" onclick="addgroup()" plain="true">添加分组</a>
		<input id="search-input" type="text" onkeypress="presstosearch(event);"/>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" onclick="dosearch()" >搜索</a>
	</div>
    
    <div id="dlg-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="savegroup()">保存</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="$('#dlg_group').dialog('close')">取消</a>
    </div>
	
	
	<div id="dlg_group" class="easyui-dialog" style="width:400px;height:250px;padding:10px 20px"
            closed="true" buttons="#dlg-buttons">
        <div class="ftitle">分组信息</div>
        <form id="form_group" method="post" novalidate>
			<div class="fitem">
				<label>所属用户组</label>
				<select name="upid" id="groupid" disabled="true">
				</select>
			</div>	
            <div class="fitem">
                <label>用户组名称：</label>
                <input name="groupname" id="groupname" class="easyui-validatebox" required="true" missingMessage="填写组名称">
				<input type="hidden" name="groupid" value=""/>
				<input type="hidden" name="type" value=""/>
            </div>
            
            
        </form>
    </div>
    <script type="text/javascript">
		function formatdata(datas)
		{
			for(var i=0;i<datas.length;i++)
			{
				datas[i].operation = 
				'<a href="/admin/permission/edit.html?groupid='+datas[i].groupid+'" class="easyui-linkbutton l-btn l-btn-plain" plain="true" onmouseover="$(this).css(\'color\',\'red\')" onmouseout="$(this).css(\'color\',\'#404040\')">[编辑组权限]</a>'
				+
				'<a href="javascript:addgroup()" class="easyui-linkbutton l-btn l-btn-plain" plain="true" onmouseover="$(this).css(\'color\',\'red\')" onmouseout="$(this).css(\'color\',\'#404040\')">[添加子用户组]</a>'
				+
				'<a href="javascript:editgroup()" class="easyui-linkbutton l-btn l-btn-plain" plain="true" onmouseover="$(this).css(\'color\',\'red\')" onmouseout="$(this).css(\'color\',\'#404040\')">[编辑]</a>'
				+
				'<a href="javascript:deletegroup()" class="easyui-linkbutton l-btn l-btn-plain" plain="true" onmouseover="$(this).css(\'color\',\'red\')" onmouseout="$(this).css(\'color\',\'#404040\')">[删除]</a>';
			}
		}
		
		$(function(){
			var datas = <?php echo $grouplist;?>;
			formatdata(datas);
            $('#dg').datagrid('loadData',datas);
			for(var i=0;i<datas.length;i++){
				$("#groupid").append("<option value='"+datas[i]['groupid']+"'>"+ datas[i]['groupname']+ "</option>");  
			}
        });
		
        var url;
		var message;
		function editgroup(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				
                $('#dlg_group').dialog('open').dialog('setTitle','编辑分组');
				$('#groupid').attr('name','upid');
				//$('#groupid').attr('disabled',true);
				if(row.upid==0)
					row.upid=row.groupid;
				$('#form_group').form('clear');
                $('#form_group').form('load',row);
                url = '/admin/permission/editgroup.html?groupid='+row.groupid;
            }
		}
        function addgroup(){
			var row = $('#dg').datagrid('getSelected');
			$('#dlg_group').dialog('open').dialog('setTitle','添加子用户组');
			$('#groupid').attr('name','groupid');
			//$('#groupid').attr('disabled',false);
			$('#form_group').form('clear');
			$('#form_group').form('load',row);
			$('#groupname').val('');
			url = '/admin/permission/addgroup.html';
		}
		function savegroup(){
			$('#form_group').form('submit',{
				url:url,
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(result){
					if (result=="1"||result=="0"){
						showsuccess("操作成功");
                        $('#dlg_group').dialog('close');
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
        function deletegroup(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $.messager.confirm('确认','确定要删除该分组么？',function(r){
                    if (r){
                        $.post('/admin/permission/deletegroup.html',{groupid:row.groupid},function(result){
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
			$.get('<?php echo geturl('admin/permission/getlist');?>',{'param[q]':$("#search-input").val()},function(data){getsearchdata(data);}
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