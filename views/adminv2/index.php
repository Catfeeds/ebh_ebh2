<?php $this->display('adminv2/aheader');?>
<?php $this->display('adminv2/left');?>
<div class="layui-body" style="bottom: 0;border-left: solid 2px #1AA094;" id="admin-body">
	<div class="layui-tab admin-nav-card layui-tab-brief" lay-filter="admin-tab">
		<ul class="layui-tab-title">
			<li class="layui-this">
				<i class="fa fa-dashboard" aria-hidden="true"></i>
				<cite>欢迎页</cite>
			</li>
		</ul>
		<div class="layui-tab-content" style="min-height: 150px; padding: 5px 0 0 0;">
			<div class="layui-tab-item layui-show">
				<iframe src="/adminv2/default/main.html"></iframe>
			</div>
		</div>
	</div>
</div>
<?php $this->display('adminv2/footer');?>
