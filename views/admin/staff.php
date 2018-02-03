<?php
$this->display('admin/header');
?>
<body>
	<table id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
		<td><h1>内部用户管理 - 用户列表</h1></td>
	</tr>
	</table>
    <table cellspacing="0" cellpadding="0" class="toptable">
		<tr>
		<td><label>关键字: </label><input type="text" name="q" id="search-input" value="" size="20" />
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" onclick="_search()" >搜索</a></td>
		</tr>
	</table>
    
	<table id="dg" cellspacing="0" cellpadding="0" width="100%"  class="listtable">
		<thead class="reviewtbody">
			<tr>
			<th>序号</th>
			<th>选择</th>
			<th field="username" width="30%">登录名</th>
			<th field="lastlogintime" width="20%">最后登录时间</th>
			<th field="logincount" width="10%">登录次数</th>
			<th field="status" width="10%">用户状态</th>
			<th field="operation" width="20%">操作</th>
			</tr>
		</thead>
		<tbody class="moduletbody">
			<tr class="tr_review" />
			<th class="sn">1</th>
			<td class="sn"><input type="checkbox" name="item[]" value="0" /></td>
			<td class="username">xs00047</td>
			<td class="lastlogintime"></td>
			<td class="logincount">33333</td>
			<td class="status">正常</td>
			<td class="op">[<a href="#">编辑</a>] [<a href="#" >删除</a>]</td>
			</tr>
		</tbody>
	</table>
	<div id="pp"></div>
	
    <div id="dlg-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveuser()">保存</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg-user').dialog('close')">取消</a>
    </div>
	
	
	<div id="dlg-user" class="easyui-dialog" style="width:400px;height:280px;padding:10px 20px"
            closed="true" buttons="#dlg-buttons">
        <div class="ftitle">用户信息</div>
        <form id="form_user" method="post" novalidate>
            <div class="fitem">
                <label>登录名：</label>
                <input name="username" class="easyui-validatebox" readonly>
				<input type="hidden" name="uid"/>
            </div>
            <div class="fitem">
                <label>密码:</label>
                <input name="password" id="password" class="easyui-validatebox" onchange="changerequire()" validType="length[6,12]" missingMessage="请输入6-12位密码" invalidMessage="请输入6-12位密码" type="password"> （留空则不修改密码）
            </div>
            <div class="fitem">
                <label>确认密码</label>
                <input name="confirm" id="confirm" class="easyui-validatebox" validType="equalPwd['#form_user input[name=password]']" missingMessage="请重复密码" invalidMessage="密码不匹配" type="password">
            </div>
			<div class="fitem">
				<label>所属分组</label>
				<?php $this->display('admin/groupcombo');?>
			</div>
        </form>
    </div>
    <script type="text/javascript">
		$(function(){
			$(".pagination-page-list").trigger('change');
		});
		function _search(){
			$('#pp').pagination({pageNumber:1});
			$(".pagination-page-list").trigger('change');
			return false;
		}
		
		function _render(_data){
			$(".moduletbody").html('');
			$.each($(_data),function(k,v){
				$(_renderRow(k,v)).appendTo(".moduletbody");
			});
		}
		function _renderRow(k,v){
			var row = ['<tr class="tr_review" />'];
			row.push('<th class="sn">'+(k+1)+'</th>');
			row.push('<td class="sn"><input type="checkbox" name="item[]" value="'+v.logid+'" /></td>');
			row.push('<td class="username">'+v.username+'</td>');
			row.push('<td class="lastlogintime">'+getformatdate(v.lastlogintime)+'</td>');
			row.push('<td class="logincount">'+v.logincount+'</td>');
			row.push('<td class="status">'+(parseInt(v.status)?'正常':'锁定')+'</td>');
			row.push('<td class="op">[<a href="javascript:edituser('+v.uid+',\''+v.username+'\','+v.groupid+')">编辑</a>] ');
			
			row.push(parseInt(v.status)?'[<a href="javascript:changestatus('+v.uid+',0)">锁定</a>]':'[<a href="javascript:changestatus('+v.uid+',1)">解锁</a>]');
			row.push('</td>');
			row.push('</tr>');
			return row.join('');
		}
		$('#pp').pagination({
			pageSize:20,
			onSelectPage:function(pageNumber, pageSize){
				var query = $("#search-input").val()
				$.post("/admin/staff/getListAjax.html",
					{query:query,pageNumber:pageNumber,pageSize:pageSize},
					function(message){
						message = JSON.parse(message);
						$('#pp').pagination('refresh',message.shift());
						// $('#dd').datagrid({'data':message});
						_render(message);
					}
					);
				return false;
			}
		}); 
		
		$.extend($.fn.validatebox.defaults.rules, {
	        equalPwd: {
		        validator: function(value, param){
		        	return value == $(param[0]).val();
		        },
				message:"密码不匹配"
	        } 
	    });	
        var url;
		
		function edituser(uid,username,groupid){
		// alert(row);
			// var row = $('#dg').datagrid('getSelected');
			// if (row){
                $('#dlg-user').dialog('open').dialog('setTitle','修改');
				$('#form_user').form('clear');
                $('#form_user').form('load',{username:username,uid:uid,groupid:groupid});
                url = '<?php echo geturl('admin/staff/editstaff');?>';
            // }
		}
        
		function saveuser(){
			$('#form_user').form('submit',{
				url:url,
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(result){
                    if (result==1||result==0){
						showsuccess("修改成功");
                        $('#dlg-user').dialog('close'); 
                        $('.pagination-page-list').trigger('change');
                    } else {
						$.messager.show({
                            title: 'Error',
                            msg: result
                        });
                    }
				}
			});
		}
        
		// function dosearch(){
			// $.get('<?php echo geturl('admin/staff/getlist');?>',{'param[q]':$("#search-input").val()},function(data){getsearchdata(data);}
			// );
		// }
		function showsuccess(msg){
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
		function changestatus(uid,status){
			// var row = $('#dg').datagrid('getSelected');
			//alert(row.uid);
            // if (row){
                $.post('<?php echo geturl('admin/staff/editstaff');?>',
					{uid:uid,status:status},
					function(result){
                            if (result=="1"){
                               $(".pagination-page-list").trigger('change');
                            } else {
                                $.messager.show({   
                                    title: 'Error',
                                    msg: result
                                });
                            }
                    });
            // }
		}
		function changerequire(){
			var password = $('#password').val();
			if(password!=''){
				$('#confirm').validatebox({    
					required: true,    
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