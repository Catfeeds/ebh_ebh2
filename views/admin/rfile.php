<?php
$this->display('admin/header');
?>
<body>
    
    
    <table id="dg" title="文件列表" class="easyui-datagrid" style="width:1200px;height:630px"
            toolbar="#toolbar"
            rownumbers="true" fitColumns="true" singleSelect="true"
			nowrap="true"
			>
        <thead>
            <tr>
				<th field="rid" width="10">rid</th>
				<th field="title" width="40">文件标题</th>
				<th field="realname" width="20">所属老师</th>
                <th field="name" width="20">所属分类</th>
				<th field="top" width="10">置顶</th>
				<th field="best" width="10">精华</th>
				<th field="hot" width="10">热门</th>
                <th field="dateline" width="20">添加时间</th>
				<th field="downnum" width="10">下载数</th>
				<th field="status" width="10">状态</th>
				<th field="operation" width="40">操作</th>
				
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
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveuser()">保存</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg-pass').dialog('close')">取消</a>
    </div>
	
	
	<div id="dlg-pass" class="easyui-dialog" style="width:400px;height:280px;padding:10px 20px"
            closed="true" buttons="#dlg-buttons">
        <div class="ftitle">用户信息</div>
        <form id="form_pass" method="post" novalidate>
            <div class="fitem">
                <label>登录名：</label>
                <input name="crname" class="easyui-validatebox" readonly><!--
				<input type="hidden" name="crid" id="crid" value=""/>-->
            </div>
            <div class="fitem">
                <label>密码：</label>
                <input name="password" class="easyui-validatebox" required="true" validType="length[6,12]" missingMessage="请输入6-12位密码" invalidMessage="请输入6-12位密码" type="password">
            </div>
            <div class="fitem">
                <label>确认</label>
                <input name="confirm" class="easyui-validatebox" required="true" validType="equalPwd['#form_pass input[name=password]']" missingMessage="请重复密码" invalidMessage="密码不匹配" type="password">
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
				'<a href="/admin/rfile/view.html?rid='+datas[i].rid+'" class="easyui-linkbutton l-btn l-btn-plain" plain="true" onmouseover="$(this).css(\'color\',\'red\')" onmouseout="$(this).css(\'color\',\'#404040\')">[详情]</a>'
				+
				'<a href="/admin/rfile/edit.html?rid='+datas[i].rid+'" class="easyui-linkbutton l-btn l-btn-plain" plain="true" onmouseover="$(this).css(\'color\',\'red\')" onmouseout="$(this).css(\'color\',\'#404040\')">[编辑]</a>'
				+
				'<a href="javascript:deleterfile()" class="easyui-linkbutton l-btn l-btn-plain" plain="true" onmouseover="$(this).css(\'color\',\'red\')" onmouseout="$(this).css(\'color\',\'#404040\')">[删除]</a>';
				;
				if(datas[i].status==1){
					datas[i].operation +=
					'<a href="javascript:changestatus(-2)" class="easyui-linkbutton l-btn l-btn-plain" plain="true" onmouseover="$(this).css(\'color\',\'red\')" onmouseout="$(this).css(\'color\',\'#404040\')">[锁定]</a>';
				}
				else if(datas[i].status==-2){
					datas[i].operation +=
					'<a href="javascript:changestatus(1)" class="easyui-linkbutton l-btn l-btn-plain" plain="true" onmouseover="$(this).css(\'color\',\'red\')" onmouseout="$(this).css(\'color\',\'#404040\')">[解锁]</a>';
				}
				
				
				
			}
			return datas;
		}
		
		$(function(){
			
			var datas = <?php echo $rfilelist;?>;
			formatdata(datas);
            $('#dg').datagrid('loadData',datas);
			
			
        });
		
        function deleterfile(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $.messager.confirm('确认','确定要删除该文件么？',function(r){
                    if (r){
                        $.post('/admin/rfile/del.html',{rid:row.rid},function(result){
                            if (result.success){
								$.messager.show({ 
                                    title: '成功',
                                    msg: '删除成功',
									timeout:2000
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
			$.get('<?php echo geturl('admin/rfile/getlist');?>',{'param[q]':$("#search-input").val()},function(data){getsearchdata(data);}
			);
		}
		function editpasssuccess(msg){
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
		function changestatus(status){
			var row = $('#dg').datagrid('getSelected');
			
            if (row){
                $.post('<?php echo geturl('admin/rfile/editrfile');?>',
					{rid:row.rid,status:status},
					function(result){
                            if (result==1){
							
                               $('.pagination-page-list').trigger('change');
                            } else {
                                $.messager.show({    // show error message
                                    title: 'Error',
                                    msg: result
                                });
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