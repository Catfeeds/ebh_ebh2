<?php
$this->display('admin/header');
?>
<body id="main"><table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
        <td><h1 style="width:550px;">教师管理 -  添加教师</h1></td>
        <td class="actions" >
            <table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
            <tr>
            <td ><a href="admin.php?token=1be80ab57e1a2eca&action=teacher">浏览教师</a></td>
            <td  class="active"><a href="admin.php?token=1be80ab57e1a2eca&action=teacher&op=add" class="add">添加教师</a></td>
            </tr>
            </table>
        </td>
    </tr>
</table>
<form method="post" id="form_member" action="/admin/teacher/add.html" onsubmit="return $(this).form('validate')">
<style type="text/css">
body{font-family:tahoma,verdana,arial;font-size:11px;line-height:15px;background-color:#FCFDFD;color:#666666;margin-left:20px;}
strong{font-size:12px;}
aink{color:#0066CC;}
a:hover{color:#FF6600;}
aisited{color:#003366;}
a:active{color:#9DCC00;}
</style>
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
<tr><th>所属代理商<em>*</em><p>请选择所属代理商，如果是总部代理，可不选</p></th><td>
<?=$agentSelect?>
</td></tr>
<tr><th>登录名<em>*</em><p>教师登录时的账号。</p></th>
    <td><input type="text" class="w300" maxlength="50" name="username" id="username" value="" />
    </td>
</tr>

<tr>
    <th>密码<em>*</em><p>请输入教师登录时的密码。</p></th>
    <td><input type="password" id="password" class="w300" maxlength="20" name="password" value="" /></td>
</tr>
<tr>
    <th>重复密码<em>*</em><p>请再次输入教师登录时的密码。</p></th>
    <td><input type="password" id="forpassword" class="w300"  maxlength="20"  name="forpassword" value="" /></td>
</tr>
<tr>
    <th>姓名</th>
    <td><input type="text" class="w300" name="realname"   maxlength="25" value="" /></td>
</tr>

<tr>
    <th>昵称</th>
    <td><input type="text" class="w300" name="nickname"   maxlength="25" value="" /></td>
</tr>
<tr>
    <th>组织机构</th>
    <td><input type="text" class="w300" name="agency"   maxlength="25" value="" /></td>
</tr>
<tr>
    <th>手机号码</th>
    <td><input type="text" class="w300" name="mobile"   maxlength="25" value="" /></td>
</tr>
<tr>
    <th>座机</th>
    <td><input type="text" class="w300" name="phone"   maxlength="25" value="" /></td>
</tr>
<tr>
    <th>传真</th>
    <td><input type="text" class="w300" name="fax"   maxlength="25" value="" /></td>
</tr>
<tr><th>地址</th>
<td>
    <?php $this->widget('cities_widget'); ?>
</td></tr>
<tr>
    <th>个人简介</th>
    <td><textarea  class="p98" name="profile"  rows="5"  ></textarea><font style="color: green;">&nbsp;&nbsp;&nbsp;&nbsp;</font></td>
</tr>
<tr>
    <th>年龄</th>
    <td><input class="w300" type="text" id="vage" name="vitae[age]" value="" /><font style="color: green;">&nbsp;&nbsp;&nbsp;&nbsp;</font></td>
</tr>
<tr><th>头像</th><td>
<?php
    $Upcontrol->upcontrol('face',1,array(),'pic');

?>
</td></tr>
<tr><th>详细介绍</th>
<td>
<?php $editor->createEditor('message',"100%","300px",''); ?>
</td></tr>
<tr><th>银行帐号<p>银行帐号请认真填写。</p></th><td><input type="text" class="w300" name="bankcard"   maxlength="25" value=""></input>
<select id="bankselect" name="bankname">
<option selected="selected" value="0" >选择归属银行</option>
<?php $this->widget('bank_widget');?>
</select>
<em id="emmsg" class=""></em></td></tr>
<tr>
    <th>标签<em>*</em><p>请填写教师的标签。</p></th>
    <td><input type="text" class="w300" name="tag" id="tag" maxlength="250" value="" /></td>
</tr>
<tr><th>教龄<em>*</em><p>请填写教师的教龄。</p></th>
<td><input type="text" class="w300" name="schoolage" id="schoolage" maxlength="250" value="" />
</td></tr>
</table>
<div class="buttons">
<input type="submit" name="valuesubmit" value="提交保存" class="submit">
<input type="reset"  name="valuereset" value="重置">
 
</div>
</form>
</body>
<script type="text/javascript">
$.extend($.fn.validatebox.defaults.rules, {    
    equals: {    
        validator: function(value,param){    
            return value == $('#password').val();    
        },    
        message: '两次密码不匹配!'   
    },
    bank:{
        validator:function(){
            if($('#bankselect').val()!=0){
                if(!$('#bankcard').val()){
                    return false;
                }
            }else{
                return true;
            }
        }
    },
    isNum:{
        validator:function(value){
            return /^\d+$/.test(value);
        },
        message:'必须位数字'
    },
	
	password:{
		validator:function(value){
			if(value.length>=6 && value.length<=16){
				var un = $('#username').val();
				if(un==value){
					$.fn.validatebox.defaults.rules.password.message = '密码不能和用户名相同';
					return false;
				}else{
					var patt1=new RegExp(/^123456\d{0,3}$/);
					if(patt1.test(value)){
						$.fn.validatebox.defaults.rules.password.message = '密码不能使用123456等过于简单的';
						return false;
					}
				}
			}
			else{
				$.fn.validatebox.defaults.rules.password.message = '密码长度必须在6-16';
				return false;
			}
			return true;
			
		}
	}
    
}); 
$(function(){
    $("#agentdate").trigger('focus');
    $('.maintable').height($(document).height());
    $("input").blur(function(){
        $(this).val($.trim($(this).val()));
    });
});
$(function(){
    $("#drop").click(function(){
        $('#dd').dialog({    
            title: '选择用户',
            width:Math.ceil($(document).width()/2),
            height:Math.ceil($(document).height()/2)+50,    
            closed: false,    
            cache: false,    
            href: '/admin/agent/lite.html',
            modal: true,
            shadow:true   
        }); 
    });
});
$(function(){
    $('#forpassword').validatebox({    
        required: true,    
        validType: 'equals',
        missingMessage:'密码不能为空'  
    });  
});
$(function(){
    $('#password').validatebox({    
        required: true,    
        validType: 'password',
        missingMessage:'密码不能为空'
    });  
});
$(function(){
    $('#schoolage').validatebox({    
        required: true,
        validType:['isNum','length[1,2]'],
        missingMessage:'教龄不能为空'  
    });  
});
$(function(){
    $('#vage').validatebox({    
        required: true,
        validType:['isNum','length[1,2]'],
        missingMessage:'年龄不能为空'  
    });  
});
$(function(){
    $('#tag').validatebox({    
        required: true,
        missingMessage:'标签不能为空'  
    });  
});
$(function(){
    $('#username').validatebox({    
        required: true,
        missingMessage:'登录名不能为空' ,
        validType: 'username'
    });  
});


</script>
<?php
$this->display('admin/footer');
?>