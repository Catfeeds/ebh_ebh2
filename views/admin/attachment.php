<?php
$this->display('admin/header');
?>
<body>
    
    
    <table id="dg" title="附件列表" class="easyui-datagrid" style="width:1200px;height:630px"
            toolbar="#toolbar"
            rownumbers="true" fitColumns="true" singleSelect="true"
			nowrap="true"
			>
        <thead>
            <tr>
				<th field="attid" width="25">attid</th>
				<th field="title" width="80">附件标题</th>
                <th field="suffix" width="20">附件格式</th>
				<th field="size" width="40">附件大小</th>
				<th field="status" width="40">附件状态</th>
				<th field="dateline" width="60">时间</th>
				<th field="operation" width="60">操作</th>
            </tr>
        </thead>
		
    </table>
	<?php
	$this->display('admin/pagination');
	?>
    <div id="toolbar">
		<input id="search-input" type="text" onkeypress="presstosearch(event);"/>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" onclick="dosearch()" >搜索</a>
	</div>
	
    <div id="dlg-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveattachment()">保存</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg-attachment').dialog('close')">取消</a>
    </div>
	
	
	<div id="dlg-attachment" class="easyui-dialog" style="width:400px;height:280px;padding:10px 20px"
            closed="true" buttons="#dlg-buttons">
        <div class="ftitle">附件信息</div>
        <form id="form_attachment" method="post" novalidate>
            <div class="fitem">
                <label>附件标题</label>
                <input name="title" class="easyui-validatebox" required="true" style="width:200px" missingMessage="请填写标题">
				<input type="hidden" name="attid" id="crid"/>
            </div>
            <div class="fitem">
                <label>附件介绍</label>
                <textarea name="message" class="easyui-validatebox" required="true" style="width:200px;height:80px;" missingMessage="请填写介绍">
				</textarea>
            </div>
            
        </form>
    </div>
    <script type="text/javascript">
		function formatdata(datas)
		{
			for(var i=0;i<datas.length;i++)
			{
				datas[i].dateline = getformatdate(datas[i].dateline);
				datas[i].operation = 
				'<a href="javascript:void(0)" class="easyui-linkbutton l-btn l-btn-plain" plain="true" onmouseover="$(this).css(\'color\',\'red\')" onmouseout="$(this).css(\'color\',\'#404040\')">[详情]</a>'
				+
				'<a href="javascript:editattachment(0)" class="easyui-linkbutton l-btn l-btn-plain" plain="true" onmouseover="$(this).css(\'color\',\'red\')" onmouseout="$(this).css(\'color\',\'#404040\')">[编辑]</a>'
				;
				if(datas[i].status==1){
					datas[i].operation +=
					'<a href="javascript:changestatus(0)" class="easyui-linkbutton l-btn l-btn-plain" plain="true" onmouseover="$(this).css(\'color\',\'red\')" onmouseout="$(this).css(\'color\',\'#404040\')">[锁定]</a>';
				}
				else{
					datas[i].operation +=
					'<a href="javascript:changestatus(1)" class="easyui-linkbutton l-btn l-btn-plain" plain="true" onmouseover="$(this).css(\'color\',\'red\')" onmouseout="$(this).css(\'color\',\'#404040\')">[解锁]</a>';
				}
				datas[i].operation +=
				'<a href="javascript:deleteattachment()" class="easyui-linkbutton l-btn l-btn-plain" plain="true" onmouseover="$(this).css(\'color\',\'red\')" onmouseout="$(this).css(\'color\',\'#404040\')">[删除]</a>';
				
			}
		}
		
		$(function(){
			var datas = <?php echo $attachmentlist;?>;
			formatdata(datas);
            $('#dg').datagrid('loadData',datas);
        });
		
        function deleteattachment(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $.messager.confirm('确认','确定要删除该附件么？',function(r){
                    if (r){
                        $.post('<?php echo geturl('admin/attachment/del');?>',{attid:row.attid},function(result){
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
			$.get('<?php echo geturl('admin/attachment/getlist');?>',{'param[q]':$("#search-input").val()},function(data){getsearchdata(data);}
			);
		}
		var url;
		function editattachment(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
                $('#dlg-attachment').dialog('open').dialog('setTitle','修改附件');
				$('#form_attachment').form('clear');
                $('#form_attachment').form('load',row);
                url = '<?php echo geturl('admin/attachment/editattachment');?>';
            }
		}
		
		function saveattachment(){
			$('#form_attachment').form('submit',{
				url:url,
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(result){
                    if (result==1||result==0){
						showsuccess("修改成功");
                        $('#dlg-attachment').dialog('close'); 
                        $('.pagination-page-list').trigger('change');
                    } else {
						$.messager.show({
                            title: 'Error',
                            msg: result
                        });
                    }
				}
			});
		}
		function changestatus(status){
			var row = $('#dg').datagrid('getSelected');
            if (row){
                $.post('<?php echo geturl('admin/attachment/editattachment');?>',
					{attid:row.attid,status:status},
					function(result){
							if (result==1){
							
                               $('.pagination-page-list').trigger('change');
                            } else {
                                $.messager.show({
                                    title: 'Error',
                                    msg: result
                                });
                            }
                    });
            }
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