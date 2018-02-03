<?php
$this->display('admin/header');
?>
<body>
    
    
    <table id="dg" title="日志列表" class="easyui-datagrid" style="width:1200px;height:630px"
            toolbar="#toolbar"
            rownumbers="true" fitColumns="true" singleSelect="true"
			nowrap="true"
			>
        <thead>
            <tr>
				<th field="logid" width="10">logid</th>
                <th field="username" width="40">操作人</th>
				<th field="too" width="40">操作对象</th>
                <th field="opname" width="15">操作类型</th>
				<th field="message" width="50">操作内容</th>
				<th field="fromip" width="20">ip地址</th>
				<th field="dateline" width="20">时间</th>
				<th field="operation" width="10">操作</th>
				
            </tr>
        </thead>
		
    </table>
	
	
	<?php
	$this->display('admin/pagination');
	?>
	
    <div id="toolbar">
        <select id="type" >
			<option value="ad" >广告</option>
			<option value="agent" >代理商</option>
			<option value="card" >充值卡</option>
			<option value="cardbatch" >卡片批次</option>
			<option value="classroom" >教室</option>
			<option value="courseware" >课件</option>
			<option value="folder" >课程</option>
			<option value="class" >班级</option>
			<option value="group" >组成员</option>
			<option value="machine" >媒体中心机器</option>
			<option value="mediacenter" >媒体中心</option>
			<option value="member" >会员</option>
			<option value="room" >教室公告</option>
			<option value="roomcourse" >教室课件</option>
			<option value="roomuser" >教室内会员</option>
			<option value="serial" >软件版本</option>
			<option value="teacher" >教师</option>
			<option value="users" >用户</option>
			<option value="apply" >申请进入教室</option>
		</select>
		<input id="search-input" type="text" onkeypress="presstosearch(event);"/>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" onclick="dosearch()" >搜索</a>
	</div>
	
	
    <script type="text/javascript">
		function formatdata(datas)
		{
			for(var i=0;i<datas.length;i++)
			{
				datas[i].dateline = getformatdate(datas[i].dateline);
				datas[i].operation = 
				'<a href="javascript:deletelog()" class="easyui-linkbutton l-btn l-btn-plain" plain="true" onmouseover="$(this).css(\'color\',\'red\')" onmouseout="$(this).css(\'color\',\'#404040\')">[删除]</a>';
				
			}
		}
		
		$(function(){
			
			var datas = <?php echo $loglist;?>;
			formatdata(datas);
            $('#dg').datagrid('loadData',datas);
			
        });
		
        var url;
		
        function deletelog(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $.messager.confirm('确认','确定要删除该会员么？',function(r){
                    if (r){
                        $.post('/admin/log/del.html',{logid:row.logid},function(result){
                            if (result){
								$.messager.show({
									timeout:2000,
                                    title: '成功',
                                    msg: '删除成功'
                                });
                                dosearch();
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
			$.get('<?php echo geturl('admin/log/getlist');?>',{'param[q]':$("#search-input").val(),'param[type]':$("#type").val()},function(data){
				getsearchdata(data);
			}
			);
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