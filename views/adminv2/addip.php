<?php $this->display('adminv2/header')?>
<link rel="stylesheet" href="http://static.ebanhui.com/adminv2/css/layui.css" />
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
		<legend>添加登录IP黑名单</legend>
	</fieldset>

	<form class="layui-form">
		<div class="layui-form-item">
			<label class="layui-form-label">IP地址</label>
			<div class="layui-input-inline">
				<input type="tel" id="ip" lay-verify="mobile" class="layui-input" placeholder="IP地址">
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
				<input type="radio" name="school" value="2" title="所有网校" checked>
			</div>
		</div>

		<div class="layui-form-item">
			<div class="layui-input-block">
				<button id="addblack" class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
			</div>
		</div>
	</form>
</div>
<script type="text/javascript">
//添加黑名单
	$(function(){
		$('#addblack').click(function(evt){
			evt.preventDefault();
			var ip = $('#ip').val();
			var remark = $('#remark').val();
			$.ajax({
				url:'/adminv2/black/add.html',
				data:{
					ip:ip,
					remark:remark,
					operate:'ip'
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
