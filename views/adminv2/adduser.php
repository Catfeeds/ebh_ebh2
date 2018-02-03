<?php $this->display('adminv2/header')?>
<link rel="stylesheet" href="http://static.ebanhui.com/adminv2/css/layui.css" />
<link rel="stylesheet" href="http://static.ebanhui.com/adminv2/css/layer.css" />
<script type="text/javascript" src="http://static.ebanhui.com/adminv2/js/jquery.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/adminv2/js/layui.js"></script>
<script type="text/javascript">
	layui.config({
		base: 'http://static.ebanhui.com/adminv2/js/'
	}).use(['form'], function() {
		var form = layui.form();
	});
</script>
<div style="margin: 15px;">
	<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
		<legend>添加登录账户黑名单</legend>
	</fieldset>

	<form class="layui-form">
		<div class="layui-form-item">
			<label class="layui-form-label">用户名</label>
			<div class="layui-input-inline">
				<input type="tel" id="username" lay-verify="username" class="layui-input" placeholder="用户名">
			</div>
		</div>

		<div class="layui-form-item">
			<label class="layui-form-label">备注信息</label>
			<div class="layui-input-inline">
				<textarea cols="50" rows="4" id="remark" placeholder="备注信息"></textarea>
			</div>
		</div>

		<div class="layui-form-item">
			<label class="layui-form-label">限制项</label>
			<div class="layui-input-block">
				<input type="radio" name="deny" value="LOGIN" title="登录" checked>
			</div>
		</div>
		
		<div class="layui-form-item">
			<label class="layui-form-label">限制范围</label>
			<div class="layui-input-block">
				<input type="radio" name="school" value="1" title="所属网校" checked>
				<input type="radio" name="school" value="2" title="所有网校">
			</div>
		</div>

		<div class="layui-form-item">
			<div class="layui-input-block">
				<button id="addblack" class="layui-btn">立即提交</button>
			</div>
		</div>
	</form>
</div>
<script type="text/javascript">
//添加黑名单
	$(function(){
		$('#addblack').click(function(evt){
			evt.preventDefault();
			var username = $('#username').val();
			var remark = $('#remark').val();
			var school = $('input[name=school]:checked').val();
			$.ajax({
				url:'/adminv2/black/add.html',
				data:{
					username:username,
					remark:remark,
					school:school,
					operate:'user'
				},
				dataType:'json',
				type:'post',
				success:function(respon){
					if(respon.status == 1){
						alert(respon.msg);
					}else{
						window.location.href = "/adminv2/black.html";
					}
				}
			});
		});
	})
</script>
