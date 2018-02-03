<?php
$this->display('admin/header');
?>
<body>
    
    
    <table id="dg" title="答疑列表" class="easyui-datagrid"
            toolbar="#toolbar"
            rownumbers="true" fitColumns="true" singleSelect="true"
			nowrap="false"
			>
        <thead>
            <tr>
				<th field="qid" width="15">qid</th>
                <th field="title" width="30">标题</th>
                <th field="message" width="80">内容</th>
                <th field="username" width="20">提问者</th>
				<th field="dateline" width="20">时间</th>
				<th field="operation" width="10">操作</th>
				
            </tr>
        </thead>
		
    </table>
	
	
	<?php
	$this->display('admin/pagination');
	?>
	
    <div id="toolbar">
		<select name="crid" id="crid" style="width:150px" >
			<option value="">选择所属网校</option>   
		</select>
        
		<input id="search-input" type="text" onkeypress="presstosearch(event);" />
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" onclick="dosearch()" >搜索</a>

	</div>
	<script>
		$(window).resize(function(){
			$('#dg').datagrid('resize', {
			});
		});
		function formatdata(datas)
		{
			for(var i=0;i<datas.length;i++)
			{
				datas[i].dateline = getformatdate(datas[i].dateline);
				datas[i].operation = 
				
				'<a href="javascript:del()" class="easyui-linkbutton l-btn l-btn-plain" plain="true" onmouseover="$(this).css(\'color\',\'red\')" onmouseout="$(this).css(\'color\',\'#404040\')">[删除]</a>'
				;
				
			}
			return datas;
		}
		$(function(){
			
			var datas = <?php echo $askquestionlist;?>;
			formatdata(datas);
            $('#dg').datagrid('loadData',datas);
			
			$.ajax({
				url:'<?php echo geturl('admin/classroom/getsimplelist');?>',
				type:'GET',
				success:function(data){
					var datas = eval('('+data+')'); 
					for(var i=0;i<datas.length;i++){
						$("#crid").append("<option value='"+datas[i]['crid']+"'>"+ datas[i]['crname']+ "</option>"); 
					}
				},
				error:function(){
					alert();
				}
			});
        });
		function del(){
			var row = $('#dg').datagrid('getSelected');
            if (row){
                $.messager.confirm('确认','确定要删除该答疑么？',function(r){
                    if (r){
                        $.post('<?php echo geturl('admin/askquestion/del');?>',{qid:row.qid},function(result){
                            if (result.success){
								$.messager.show({
                                    timeout:2000,
									title: '成功',
                                    msg: '删除成功'
                                });
								$('.pagination-page-list').trigger('change');
                            } else {
                                $.messager.show({    // show error message
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
			$.get('<?php echo geturl('admin/askquestion/getlist');?>',{'param[q]':$("#search-input").val(),'param[crid]':$("#crid").val()},function(data){
				getsearchdata(data);
			}
			);
			
		}
		
	</script>
</body>
<?php
$this->display('admin/footer');
?>