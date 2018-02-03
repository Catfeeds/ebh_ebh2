<?php $this->display('admin/header');?>
<body id="main">
<table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1 style="width:550px;">代理商管理 -  <?=$op=='edit'?'编辑':'添加'?>代理商</h1></td>
		<td class="actions" >
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tr>
			<td ><a href="/admin/agent.html">浏览代理商</a></td>
            <td ><a href="/admin/agent/add.html" class="add">添加代理商</a></td>
            <td ><a href="/admin/agent/batchadd.html" class="add">批量生成代理商</a></td>
			</tr>
			</table>
		</td>
	</tr>
</table>
<form method="post" action="/admin/agent/handle.html" onsubmit="return $(this).form('validate')">
<input type="hidden" name="op" value="<?=$op?>" />
<input type="hidden" name="agentid" value="<?=$a['agentid']?>" />
<input type="hidden" name="token" value="<?=$token?>" />
<input type="hidden" name="formhash" value="<?=$formhash?>">
<style type="text/css">
body{font-family:tahoma,verdana,arial;font-size:11px;line-height:15px;background-color:#FCFDFD;color:#666666;margin-left:20px;}
strong{font-size:12px;}
aink{color:#0066CC;}
a:hover{color:#FF6600;}
aisited{color:#003366;}
a:active{color:#9DCC00;}
</style>
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
<tr>
	<th>上级代理<p>请选择上级代理，如果是一级代理，可不选</p></th>
	<td>
		<div>
			<input disabled="disabled" value="<?=$upname?>" id="username">
			<input type="button" id="drop" value="选择" />
		</div>
		<input type="hidden" name="upid" id="mediaid"  value="<?=$a['upid']?>" />
	</td>
</tr>
<tr>
	<th>登录名<em>*</em><p>代理商登录时的账号。</p></th>
	
	<?php if($op=='add'){?>
		<td><input type="text" class="w300" maxlength="50" name="username" id='uname' value=""></td>
</tr>
<tr>
	<th>密码<em>*</em><p>请输入代理商登录时的密码。</p></th>
	<td><input type="password" class="w300" maxlength="20" name="password" id="password"  value="" onblur=""></td>
</tr>
<tr>
	<th>重复密码<em>*</em><p>请再次输入代理商登录时的密码。</p></th>
	<td><input type="password" class="w300" maxlength="20" name="forpassword" id="forpassword"  value="" onblur=""></td>
</tr>
	<?php }else{?>
		<td><?=$a['username']?></td>
</tr>
	<?php }?>
<tr>
	<th>合同编号<p>代理商所在的单位名称。</p></th>
	<td><input type="text" class="w300" name="contractno"  maxlength="50" value="<?=$a['contractno']?>" ></input></td>
</tr>
<tr><th>开始代理时间<p>代理商开始代理时间。</p></th>
	<td>
		<input type="text" class="w300" id="agentdate" name="agentdate"  maxlength="50" value="<?php if(!empty($a['agentdate'])){echo date('Y-m-d',$a['agentdate']);}?>"  onfocus="$(this).datebox({showSeconds:false});" />
	</td>
</tr>
 
<tr>
	<th>真实姓名<p>代商真实姓名。</p></th>
	<td><input type="text" class="w300" maxlength="50" name=realname value="<?=$a['realname']?>"   /></td>
</tr>
<tr>
	<th>信息描述<p>代理商信息描述。</p></th>
	<td><textarea name="profile" class="p98" rows="5"><?=$a['profile']?></textarea></td>
</tr>
<tr>
	<th>联系电话<p>请输入您的联系电话。</p></th>
	<td><input type="text" class="w300" name="phone" maxlength="25" value="<?=$a['phone']?>"   onblur="#"  />
	</td>
</tr>
<tr>
	<th>传真</th>
	<td>
		<input type="text" class="w300" name="fax"  maxlength="25" value="<?=$a['fax']?>"   onblur="#"  />
	</td>
</tr>
<tr>
	<th>手机号码<p>请填写您的手机号码，方便我们联系。</p></th>
	<td><input type="text" class="w300" name="mobile" maxlength="25" value="<?=$a['mobile']?>"   onblur="" />
	</td>
</tr>
<tr>
	<th>地址<p>请选择代理商的详细地址。</p></th>
	<td>
		<?php $this->widget('cities_widget',array('citycode'=>$a['citycode'])); ?>
	</td>
</tr>
<tr>
	<th>银行帐号<p>银行帐号请认真填写,账号和银行不能只存在一项</p></th>
	<td>
		<?php $bankinfo = unserialize($a['bankcard']);?>
		<input type="text" class="w300" name="bankcard" id="bankcard"  maxlength="25" value="<?=$bankinfo['card']?>" />
		<select id="bankselect" name="bankname"> 
		<option selected="selected" value="0" >选择归属银行</option>
			
			<?php $this->widget('bank_widget',array('bankname'=>$bankinfo['bankname']));?>
		</select>
	</td>
</tr>
</table>
<div class="buttons">
<input type="submit" name="valuesubmit" value="提交保存" class="submit">
<input type="reset"	 name="valuereset" value="重置">
</div>
</form>
<div id="dd"></div>
<br>
<script type="text/javascript">
$.extend($.fn.validatebox.defaults.rules, {    
    equals: {    
        validator: function(value,param){    
            return value == $('#forpassword').val();    
        },    
        message: '密码不匹配!'   
    },
    _date:{
    	validator:function(value){
    		return /^(([0-9]{3}[1-9]|[0-9]{2}[1-9][0-9]{1}|[0-9]{1}[1-9][0-9]{2}|[1-9][0-9]{3})-(((0[13578]|1[02])-(0[1-9]|[12][0-9]|3[01]))|((0[469]|11)-(0[1-9]|[12][0-9]|30))|(02-(0[1-9]|[1][0-9]|2[0-8]))))|((([0-9]{2})(0[48]|[2468][048]|[13579][26])|((0[48]|[2468][048]|[3579][26])00))-02-29)$/.test(value);
    	}
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
	$('#password').validatebox({    
	    required: true,    
	    validType: 'equals',
	    missingMessage:'密码不能为空'  
	});  
});
$(function(){
	$('#uname').validatebox({    
	    required: true,
	    missingMessage:'用户名不能为空'  
	});  
});
</script>
</body>

<?php $this->display('admin/footer');?>