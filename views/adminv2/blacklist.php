<?php $this->display('adminv2/header')?>
<link rel="stylesheet" href="http://static.ebanhui.com/adminv2/css/table.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/adminv2/css/zxf_page.css"/>
<script type="text/javascript" src="http://static.ebanhui.com/adminv2/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/adminv2/js/zxf_page.js"></script>
<script type="text/javascript">
	//点击全选按钮 切换全选或全不选
    function allCheck(){
    	var checkbox = $('input[name=black]');
    	if($('#allcheck')[0].checked == true){
    		checkbox.each(function(i,e){
    			$(this)[0].checked = true;
    		})
    	}else{
    		checkbox.each(function(i,e){
    			$(this)[0].checked = false;
    		})
    	}
    }
</script>
<script type="text/javascript">
	//删除数据后重新加载当前页数据列表
	function getlist(pageNum){
		var url = '/adminv2/black/blackList.html';
		var data = {pagenum:pageNum};
		$.get(url,data,function(respon){
			var html = '';
			respon = eval("(" + respon + ")");
			$.each(respon,function(i,e){
				html += '<tr>';
				html += '<td><input style="width:20px;height:20px;" type="checkbox" name="black" value="'+$(this)[0].bid+'" lay-skin="primary"></td>';
				html += '<td>'+$(this)[0].username+'</td><td>'+$(this)[0].mobile+'</td>';
				html += '<td>'+$(this)[0].ip+'</td>';
				html += '<td>'+$(this)[0].addr+'</td>';

				if($(this)[0].deny == 'ALL'){
					html += '<td>所有</td>';
				}else if($(this)[0].deny == 'LOGIN'){
					html += '<td>登录</td>';
				}else if($(this)[0].deny == 'REGISTER'){
					html += '<td>注册用户</td>';
				}else{
					html += '<td>创建网校</td>';
				}

				if($(this)[0].crid == 0){
					html += '<td>所有网校</td>';
				}else{
					html += '<td title="'+$(this)[0].crname+'">'+$(this)[0].shortname+'</td>';
				}
				
				html += '<td>'+$(this)[0].dateline+'</td>';
				html += '</tr>';
			});
			$('#content').html(html);
		});
	}
	//删除黑名单
	function multiDel(){
		var checkbox = $('input[name=black]:checked');
		if(checkbox.length == 0){
			alert('请勾选黑名单后再删除');return false;
		}
		var txt = "确认删除吗？";
		if(confirm(txt) == false)return false;
		var blackids = [];
		checkbox.each(function(i,e){
			//收集所有被选中的黑名单的bid
			blackids.push($(this)[0].value);
		});
		//提交数据删除
		$.ajax({
			url:'/adminv2/black/del.html',
			data:{blackids:blackids},
			dataType:'json',
			type:'post',
			success:function(respon){
				if(respon.status == 1){
					alert(respon.msg);
				}else{
					if(typeof(currentpage) == 'undefined'){
						getlist(1);
					}else{
						getlist(currentpage);
					}
					$('#allcheck')[0].checked = false;
				}
			}
		});
	}
</script>
<div class="admin-main">
	<blockquote class="layui-elem-quote">
		<a href="/adminv2/black/add.html?operate=user" class="layui-btn layui-btn-small">添加登录账号黑名单</a>
		<a href="/adminv2/black/add.html?operate=ip" class="layui-btn layui-btn-small">添加登录IP黑名单</a>
		<a href="/adminv2/black/add.html?operate=register" class="layui-btn layui-btn-small">添加注册黑名单</a>
		<a href="javascript:;" class="layui-btn layui-btn-small" onclick="multiDel();">删除黑名单</a>
	</blockquote>
	<fieldset class="layui-elem-field">
		<legend>黑名单列表</legend>
		<div class="layui-field-box">
			<table class="layui-table admin-table" style="text-align:center;">
				<thead>
					<tr>
						<th style="width:30px;text-align:center;">
							<input id="allcheck" style="width:20px;height:20px;" onclick="allCheck();" type="checkbox" lay-filter="allselector" lay-skin="primary" title="全选">
						</th>
						<th style="text-align:center;">用户名</th>
						<th style="text-align:center;">手机</th>
						<th style="text-align:center;">IP地址</th>
						<th style="text-align:center;">IP所在地</th>
						<th style="text-align:center;">限制内容</th>
						<th style="text-align:center;">限制范围</th>
						<th style="text-align:center;">添加日期</th>
					</tr>
				</thead>
				<tbody id="content">
					<?php foreach($blacklist as $black):?>
					<tr>
						<td>
							<input style="width:20px;height:20px;" type="checkbox" name="black" value="<?=$black['bid']?>" lay-skin="primary">
						</td>
						<td><?=$black['username']?></td>
						<td><?=$black['mobile']?></td>
						<td><?php if($black['ip'] != 0){echo long2ip($black['ip']);}?></td>
						<td><?=$black['addr']?></td>
						<?php if($black['deny'] == 'ALL'){?>
							<td>所有</td>
						<?php }else if($black['deny'] == 'LOGIN'){?>
							<td>登录</td>
						<?php }else if($black['deny'] == 'REGISTER'){?>
							<td>注册用户</td>
						<?php }else{?>
							<td>创建网校</td>
						<?php }?>
						<?php if($black['crid'] == 0){?>
							<td>所有网校</td>
						<?php }else{?>
							<td title="<?=$black['crname']?>"><?php echo shortstr($black['crname'],20);?></td>
						<?php }?>
						<td><?php echo date('Y-m-d H:i:s',$black['dateline']);?></td>
					</tr>
					<?php endforeach;?>
				</tbody>
			</table>
		</div>
	</fieldset>
	<div class="zxf_pagediv"></div>
</div>
<script type="text/javascript">
	
	//获取分页导航条
	$.get('/adminv2/black/blackCount.html',function(respon){
		$(".zxf_pagediv").createPage({
			pageNum : respon,//总页数
			current: 1,//首次加载时默认选中的页码
			backfun: function(e) {
				currentpage = e.current;//当前页码
				getlist(currentpage);
			}
		});
	});
</script>


