<?php
$this->display('admin/header');
?>
<body>
    
    
    <table id="dg" title="题库列表" class="easyui-datagrid"
            toolbar="#toolbar"
            rownumbers="true" fitColumns="true" singleSelect="true"
			nowrap="true"
			>
        <thead>
            <tr>
				<th field="aqid" width="20">aqid</th>
				<th field="gradename" width="20">年级</th>
				<th field="subjectname" width="20">科目</th>
				<th field="chaptername" width="40">知识点</th>
				<th field="title" width="150">标题</th>
                
				<th field="dateline" width="40">时间</th>
				<th field="operation" width="30">操作</th>
            </tr>
        </thead>
		
    </table>
	
	
	<?php
		$this->display('admin/pagination');
	?>
	
    <div id="toolbar">
        <a href="http://exam.ebanhui.com/anew.html" target="_blank" class="easyui-linkbutton" iconCls="icon-add" plain="true">添加试题</a>
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
				'<a href="http://exam.ebanhui.com/aedit/'+datas[i].aqid+'.html" target="_blank" class="easyui-linkbutton l-btn l-btn-plain" plain="true" onmouseover="$(this).css(\'color\',\'red\')" onmouseout="$(this).css(\'color\',\'#404040\')">[编辑]</a>'
				+
				'<a href="javascript:deletepubquestion()" class="easyui-linkbutton l-btn l-btn-plain" plain="true" onmouseover="$(this).css(\'color\',\'red\')" onmouseout="$(this).css(\'color\',\'#404040\')">[删除]</a>';
				
			}
		}
		
		$(function(){
			var datas = <?php echo $pubquestionlist;?>;
			formatdata(datas);
            $('#dg').datagrid('loadData',datas);
        });
		
        var url;
		
		function editpass(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
                $('#dlg-pass').dialog('open').dialog('setTitle','修改密码');
				$("#crid").val(row.crid);
				$('#form_pass').form('clear');
                $('#form_pass').form('load',row);
                url = '/admin/pubquestion/editPass.html?crid='+row.crid;
            }
		}
        
		function saveuser(){
			$('#form_pass').form('submit',{
				url:url,
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(result){

                    if (result.errorMsg){
                        $.messager.show({
                            title: 'Error',
                            msg: result.errorMsg
                        });
                    } else {
						editpasssuccess("密码修改成功");
                        $('#dlg-pass').dialog('close');        // close the dialog
                        $('#dg').datagrid('reload');    // reload the user data
                    }
				}
			});
		}
        function deletepubquestion(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $.messager.confirm('确认','确定要删除该题目么？',function(r){
                    if (r){
                        $.post('/admin/pubquestion/del.html',{aqid:row.aqid},function(result){
                            if (result.success){
								$.messager.show({
                                    title: '成功',
                                    msg: '删除成功'
                                });
								$('.pagination-page-list').trigger('change');
                            } else {
                                $.messager.show({
                                    title: 'Error',
                                    msg: result
                                });
                            }
                        },'json');
                    }
                });
            }
        }
		
		function dosearch(){
			$.get('<?php echo geturl('admin/pubquestion/getlist');?>',{'param[q]':$("#search-input").val()},function(data){getsearchdata(data);}
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