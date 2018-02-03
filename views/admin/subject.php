<?php
$this->display('admin/header');
?>
<body>
    
    
    <table id="dg" title="科目列表" class="easyui-datagrid" style="width:1200px;height:630px"
            toolbar="#toolbar"
            rownumbers="true" fitColumns="true" singleSelect="true"
			nowrap="true"
			>
        <thead>
            <tr>
				<th field="subjectid" width="25">subjectid</th>
				<th field="subjectname" width="80">章节名称</th>
                <th field="displayorder" width="20">排序</th>
				<th field="operation" width="60">操作</th>
				
            </tr>
        </thead>
		
    </table>
	
	<?php
	$this->display('admin/pagination');
	?>
	
    <div id="toolbar">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" onclick="addsubject()" plain="true">添加科目</a>
		<input id="search-input" type="text" onkeypress="presstosearch(event);"/>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" onclick="dosearch()" >搜索</a>
	</div>
	
	
	
    
    <div id="dlg-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="savesubject()">保存</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="$('#dlg_subject').dialog('close')">取消</a>
    </div>
	
	
	<div id="dlg_subject" class="easyui-dialog" style="width:400px;height:280px;padding:10px 20px"
            closed="true" buttons="#dlg-buttons">
        <div class="ftitle">科目信息</div>
        <form id="form_subject" method="post" novalidate>
            <div class="fitem">
                <label>科目名称：</label>
                <input name="subjectname" class="easyui-validatebox" required="true" missingMessage="填写科目名称">
				<input type="hidden" name="subjectid" id="subjectid" value=""/>
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
				'<a href="javascript:editsubject()" class="easyui-linkbutton l-btn l-btn-plain" plain="true" onmouseover="$(this).css(\'color\',\'red\')" onmouseout="$(this).css(\'color\',\'#404040\')">[编辑]</a>'
				+
				'<a href="javascript:deletesubject()" class="easyui-linkbutton l-btn l-btn-plain" plain="true" onmouseover="$(this).css(\'color\',\'red\')" onmouseout="$(this).css(\'color\',\'#404040\')">[删除]</a>';
			}
		}
		
		$(function(){
			
			var datas = <?php echo $subjectlist;?>;
			formatdata(datas);
            $('#dg').datagrid('loadData',datas);
			
        });
		
        var url;
		
		function editsubject(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				
                $('#dlg_subject').dialog('open').dialog('setTitle','修改科目');
				$("#subjectid").val(row.subjectid);
				$('#form_subject').form('clear');
                $('#form_subject').form('load',row);
                url = '/admin/subject/editsubject.html?subjectid='+row.subjectid;
				
            }
		}
        function addsubject(){
			$('#dlg_subject').dialog('open').dialog('setTitle','添加科目');
			$('#form_subject').form('clear');
			url = '/admin/subject/addsubject.html';
		}
		function savesubject(){
			$('#form_subject').form('submit',{
				url:url,
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(result){
					if (result==1||result==0){
						showsuccess("操作成功");
                        $('#dlg_subject').dialog('close');
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
        function deletesubject(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $.messager.confirm('确认','确定要删除该任务么？',function(r){
                    if (r){
                        $.post('/admin/subject/del.html',{subjectid:row.subjectid},function(result){
                            if (result.success){
								$.messager.show({    
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
			$.get('<?php echo geturl('admin/subject/getlist');?>',{'param[q]':$("#search-input").val()},function(data){getsearchdata(data);}
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