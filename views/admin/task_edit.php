<?php
$this->display('admin/header');
?>
<body>
<h1>添加任务</h1>
        <form id="form_task" method="post" novalidate action="<?php geturl('admin/task/edit');?>">
            <div class="fitem">
                <label>任务名称：</label>
                <input name="name" class="easyui-validatebox" value="<?php echo $taskdetail['name'];?>"/>
				<input name="id" type="hidden" value="<?php echo $taskdetail['id']?>"/>
            </div>
			<div class="fitem">
                <label>任务图片</label>
                <input name="image" class="easyui-validatebox" value="<?php echo $taskdetail['image'];?>"/>
            </div>
            <div class="fitem">
                <label>跳转地址</label>
                <input name="url" class="easyui-validatebox" value="<?php echo $taskdetail['url'];?>"/>
			</div>
            <div class="fitem">
                <label>任务描述</label>
                <input name="description" class="easyui-validatebox" value="<?php echo $taskdetail['description'];?>"/>
			</div>
			<div class="fitem">
                <label>任务奖励</label>
                <input name="reward" class="easyui-validatebox" value="<?php echo $taskdetail['reward'];?>"/>
			</div>
			<div class="fitem">
                <label>管理积分规则</label>
                <input name="ruleid" class="easyui-validatebox" value="<?php echo $taskdetail['ruleid'];?>"/>
			</div>
			
			<div class="fitem">
                <label>排序</label>
                <input name="displayorder" class="easyui-validatebox" value="<?php echo $taskdetail['displayorder'];?>"/>
            </div>
			<div>
				<label>任务类型</label>
				<select name="type" id="type">
					<option value="0" >不显示</option>
					<option value="1" >新手任务</option>
					<option value="2" >日常任务</option>
					<option value="3" >学习任务</option>
				</select>
			</div>
        </form>
    </div>
	
	<div id="dlg-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="savetask()">保存</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-reload" onclick="$('#form_task')[0].reset()">重置</a>
    </div>
	
	
	<script>
		$(function(){
			$("#type ").attr("value","<?php echo $taskdetail['type'];?>");
			$("#type ").val("<?php echo $taskdetail['type'];?>");
			// $("#type ").get(0).value = value;
			
		})
		function savetask(){
			if($('#form_task').form('validate')){
			
			
			
				$('#form_task').submit();
			}
		}
		
	</script>
	<style>
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