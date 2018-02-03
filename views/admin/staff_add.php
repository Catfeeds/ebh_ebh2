<?php
$this->display('admin/header');
?>
<body>
<h1>添加用户</h1>
        <form id="form_staff" method="post" novalidate action="<?php echo geturl('admin/staff/add');?>">
            <div class="fitem">
                <label>登录名</label>
                <input name="username" id="username" class="easyui-validatebox" required="true" validType="username['#form_staff input[name=username]']" missingMessage="请输入6-12用户名" />
            </div>
			<div class="fitem">
                <label>密码</label>
                <input name="password" class="easyui-validatebox" required="true" validType="length[6,12]" missingMessage="请输入6-12位密码" invalidMessage="请输入6-12位密码" type="password" />
            </div>
			<div class="fitem">
                <label>确认密码</label>
                <input name="confirm" class="easyui-validatebox" required="true" validType="equalPwd['#form_staff input[name=password]']" missingMessage="请重复密码" invalidMessage="密码不匹配" type="password" />
            </div>
			<div class="fitem">
                <label>所属分组</label>
                <?php $this->display('admin/groupcombo');?>
				</select>
            </div>
		</form>
		
	<div id="dlg-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="savestaff()">保存</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-reload" onclick="$('#form_staff')[0].reset()">重置</a>
    </div>
	<script>
		
		
		function savestaff(){
			if($('#form_staff').form('validate'))
				$('#form_staff').submit();
		}
		
        $(function(){
            $('#form_staff').submit(function(){
                var username = $("#username").val();
                $("#username").val(username.replace(/\s+/g,''));
            });

            $("#username").blur(function(){
                var username = $.trim($("#username").val());
                $("#username").val(username.replace(/\s+/g,''));
            });
        });

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