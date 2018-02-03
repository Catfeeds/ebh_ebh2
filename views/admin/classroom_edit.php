<?php
$this->display('admin/header');
?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js?version=20150813001"></script>
<body id="main"><table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1 style="width:550px;">网校管理 -  编辑网校</h1></td>
		<td class="actions" >
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tr>
			<td ><a href="/admin/classroom.html">浏览网校信息</a></td>
			<td  class="active"><a href="/admin/classroom/add.html" class="add">添加网校</a></td>
			</tr>
			</table>
		</td>
	</tr>
</table>
<form method="post" action="/admin/classroom/edit.html" onsubmit="return $(this).form('validate')">
<input type="hidden" name="crid" value="<?=$c['crid']?>" />
<input type="hidden" name="token" value="<?=$token?>" />
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<input type="hidden" name="op" value="edit" />
<input type="hidden" name="_crname" value="<?=$c['crname']?>">
<input type="hidden" name="_domain" value="<?=$c['domain']?>">
<style type="text/css">
body{font-family:tahoma,verdana,arial;font-size:11px;line-height:15px;background-color:#FCFDFD;color:#666666;margin-left:20px;}
strong{font-size:12px;}
aink{color:#0066CC;}
a:hover{color:#FF6600;}
aisited{color:#003366;}
a:active{color:#9DCC00;}
.maintable th, .maintable td {color:#333}
</style>
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable"> 
<tr><th>网校名称<em>*</em><p>请输入网校名称，学员可以通过此名称查找到网校。</p></th><td>
<input type="text" class="w300" maxLength="50" name="crname" id="crname" value="<?=$c['crname']?>" onKeyup="checkCrname($(this).val())" />
</td></tr>
<tr><th>网校logo</th><td><?php $Upcontrol->upcontrol('cface',1,array('upfilepath'=>$c['cface']),'customlogo');?></td></tr>
<tr>
<th>所属教师<em>*</em><p>请选择网校所属的教师。</p>
</th>
<td><div>
<input type="text" readonly="readonly" value="<?=$c['username']?>" id="username" name="username">
<input type="button" id="drop" value="选择" />
</div>
<input type="hidden" name="uid" id="mediaid"  value="<?=$c['uid']?>" />
</td>
</tr>
<tr><th>所属分类<em>*</em><p>请输入教室的行业分类ID。</p></th><td>    
<select name="catid" id="catid"   class="w150">
<option value="0" >教室分类</option>
<?php $this->widget('category_widget',array('where'=>array('position'=>'1'),'tag'=>'catid','selected'=>$c['catid']));?>
</select></td></tr>

<tr><th>上级网校<p>请选择上级网校。</p></th><td> 
<?php $this->widget('classroom_widget',array('where'=>array('limit'=>'1000'),'tag'=>'upid','selected'=>$c['upid']));?>
</td></tr>

<tr>
	<th>地址<p>请输入地址，请用逗号分割</p></th>
	<td><input type="text" class="w300" maxlength="50" id="craddress" name="craddress" value="<?=$c['craddress']?>" /></td>
</tr>
<tr>
	<th>联系邮箱/主页<p>如果是学校版本填写主页，否则填写邮箱</p></th>
	<td><input type="text" class="w300" maxlength="50" id="cremail" name="cremail" value="<?=$c['cremail']?>" /></td>
</tr>
<tr>
	<th>联系电话</th>
	<td><input type="text" class="w300" maxlength="50" id="crphone" name="crphone" value="<?=$c['crphone']?>" /></td>
</tr>
<tr>
	<th>QQ</th>
	<td><input type="text" class="w300" maxlength="50" id="crqq" name="crqq" value="<?=$c['crqq']?>" /></td>
</tr>
<tr><th>所属城市</th>
<td>
<?php $this->widget('cities_widget',array('citycode'=>$c['citycode']));?>
</td></tr><tr><th>平台类型<p>电子网校，同步学堂，培训平台,股票，省市区控制平台，每个类型对应模板选择会不同，其中省市区控制平台只用于控制汇总它所属的子网校信息</p></th><td>
<input type="radio" <?php if($c['isschool']=='0'){echo 'checked=checked';}?> id="isschoolone" name="isschool" value="0" /><label for="isschoolone">电子教室</label>
<input type="radio" <?php if($c['isschool']=='1'){echo 'checked=checked';}?> id="isschooltwo" name="isschool" value="1" /><label for="isschooltwo">同步学堂</label>
<input type="radio" <?php if($c['isschool']=='2'){echo 'checked=checked';}?> id="isschoolthree" name="isschool" value="2" /><label for="isschoolthree">云教育网校</label>
<input type="radio" <?php if($c['isschool']=='3'){echo 'checked=checked';}?> id="isschoolfour" name="isschool" value="3"  /><label for="isschoolfour">学校平台(租赁制)</label>
<input type="radio" <?php if($c['isschool']=='4'){echo 'checked=checked';}?> id="isschoolfive" name="isschool" value="4"  /><label for="isschoolfive">股票</label>
<input type="radio" <?php if($c['isschool']=='5'){echo 'checked=checked';}?> id="isschoolsix" name="isschool" value="5"  /><label for="isschoolsix">省市区控制平台</label>
<input type="radio" <?php if($c['isschool']=='6'){echo 'checked=checked';}?> id="isschoolseven" name="isschool" value="6"  /><label for="isschoolseven">收费学校</label>
<input type="radio" <?php if($c['isschool']=='7'){echo 'checked=checked';}?> id="isschooleight" name="isschool" value="7"  /><label for="isschooleight">分成收费</label>
</td></td></tr>
<tr>
	<th>学校类型<p>该学校为小学(1)，初中(7)，中小学(9)，高中(10)，其他(0)类型学校</p></th>
	<td>
	<input type="radio" <?php if($c['grade']=='0'){echo 'checked=checked';}?> id="gradeone" name="grade" value="0" checked /><label for="gradeone">其他</label>
	<input type="radio" <?php if($c['grade']=='1'){echo 'checked=checked';}?> id="gradetwo" name="grade" value="1" /><label for="gradetwo">小学</label>
	<input type="radio" <?php if($c['grade']=='7'){echo 'checked=checked';}?> id="gradethree" name="grade" value="7" /><label for="gradethree">初中</label>
    <input type="radio" <?php if($c['grade']=='9'){echo 'checked=checked';}?> id="gradefour" name="grade" value="9" /><label for="gradefour">中小学</label>
	<input type="radio" <?php if($c['grade']=='10'){echo 'checked=checked';}?> id="gradefive" name="grade" value="10"  /><label for="gradefive">高中</label>
	</td>
</tr>
<tr>
	<th>学校属性<p>默认为0,1表示教学平台,2表示网络学校,3表示企业培训</p></th>
	<td>
	<input type="radio"  name="property" id="property0" value="0" <?=$c['property']==0?'checked=checked':''?> /><label for="property0">默认</label>
	<input type="radio"  name="property" id="property1" value="1" <?=$c['property']==1?'checked=checked':''?> /><label for="property1">教学平台</label>
	<input type="radio"  name="property" id="property2" value="2" <?=$c['property']==2?'checked=checked':''?> /><label for="property2">网络学校</label>
	<input type="radio"  name="property" id="property3" value="3" <?=$c['property']==3?'checked=checked':''?> /><label for="property3">企业培训</label>
	</td>
</tr>
<tr><th>网校域名<em>*</em><p>请输入网校域名。</p></th><td>
<input type="text" class="w300" maxLength="50" name="domain" id="domain" onKeyup="checkDomain($(this).val())" value="<?=$c['domain']?>" />
.ebanhui.com</td></tr>
<tr>
	<th>网校模版<em>*</em><p>请选择网校模版。</p></th>
	<td>     
	<select name="template" id="template" class="w150">
	</select>
	</td>
</tr>
<tr>
	<th>标签</th>
	<td><input type="text" class="w300" maxlength="50" name="crlabel" value="<?=$c['crlabel']?>"></td>
</tr>
<tr>
	<th>网校摘要<em>*</em><p>请输入网校的摘要信息。</p></th>
	<td>
		<textarea  class="p98" name="summary"  rows="5" id="summary" style="width:600px"><?=$c['summary']?></textarea>
	</td>
</tr>
<tr>
	<th>最大人数<em>*</em><p>请选择此网校最大上课人数。</p></th>
	<td>
		<select id="maxnum" name="maxnum" value="">
		<option value="50" <?php if($c['maxnum']==50){echo 'selected=selected';}?> >50</option>
		<option value="100" <?php if($c['maxnum']==100){echo 'selected=selected';}?> >100</option>
		<option value="150" <?php if($c['maxnum']==150){echo 'selected=selected';}?> >150</option>
	</select>
	</td>
</tr>
<tr>
	<th>网校开始时间 </th>
	<td><input type="text" id="begindate" name="begindate" class="w150" value="<?=date('Y-m-d H:i:s',$c['begindate'])?>"  onfocus="$(this).datetimebox({showSeconds:false});" /></td>
</tr>
<tr>
	<th>有效期限<em>*</em><p>请选择此网校的开通有效期限，以年为单位。</p></th>
	<td>
		<?php
			$year = round(($c['enddate']-$c['begindate'])/3600/24/365);
		?>
		<select id="period"  value="">
			<option value="0" <?php if($year==0){echo 'selected=selected';}?> >请选择</option>
			<option value="1" <?php if($year==1){echo 'selected=selected';}?> >1年</option>
			<option value="2" <?php if($year==2){echo 'selected=selected';}?> >2年</option>
			<option value="3" <?php if($year==3){echo 'selected=selected';}?> >3年</option>
			<option value="4" <?php if($year==4){echo 'selected=selected';}?> >4年</option>
			<option value="5" <?php if($year==5){echo 'selected=selected';}?> >5年</option>
		</select>
	</td>
</tr>
<tr>
	<th>网校结束时间</th>
	<td>
		<input type="text" id="enddate" name="enddate" class="w150" value="<?=date('Y-m-d H:i:s',$c['enddate'])?>" onfocus="$(this).datetimebox({showSeconds:false})" />
	</td>
</tr>
<tr>
	<th>开通此电子网校所需金额</th>
	<td><input type="text" class="w150" maxlength="20" name="crprice" id="crprice"  value="<?=$c['crprice']?>" />元<em></em></td>
</tr>
<tr>
	<th>网校老师权限<p>电子网校老师非系统模块权限</p></th>
	<td>
		<?php $modulepower = explode(',',$c['modulepower']);?>
		<?php foreach ($tpowerlist as $tv){?>
			<label><input type="checkbox" <?php if(in_array($tv['catid'],$modulepower)){echo 'checked=checked';}?>  name="modulepower[]" value="<?=$tv['catid']?>" /><?=$tv['name']?></label>
		<?php }?>
	</td>
</tr>
<tr>
	<th>网校学生权限<p>电子网校学生非系统模块权限</p></th>
	<td>
		<?php $stumodulepower = explode(',',$c['stumodulepower']);?>
		<?php foreach ($stpowerlist as $stv){?>
			<label><input type="checkbox"  name="stumodulepower[]" <?php if(in_array($stv['catid'],$stumodulepower)){echo 'checked=checked';}?> value="<?=$stv['catid']?>" /><?=$stv['name']?></label>
		<?php }?>
	</td>
</tr>
<tr>
	<th>共享平台分配<p>需要分配哪些平台权限的，就将该平台打钩</p></th>
	<td>
		<?php 
			$permissionArr = array();
			foreach ($permissionlist as $pv) {
				$permissionArr[] = $pv['moduleid'];
			}
		?>
		<?php foreach ($sharelist as $sv){?>
			<label><input type="checkbox" <?php if(in_array($sv['crid'],$permissionArr)){echo 'checked=checked';}?>  name="roompermission[]" value="<?=$sv['crid']?>" /><?=$sv['crname']?></label>
		<?php }?>
	</td>
</tr>
<tr>
	<?php 
		$pftio = unserialize($c['profitratio']);
		if(empty($pftio)){
			$pftio = array();
		}
	?>
	<th>分层比例</th>
	<td>
		<span id="ceng_company">
		<span style="width:150px;display:-moz-inline-box; display:inline-block;">公司分层</span>
		<input type="text" name="profitratio[company]" value="<?=$pftio['company']?>">
		</span>
		<br style="clear: both;">
		<span id="ceng_agent">
		<span style="width:150px;display:-moz-inline-box; display:inline-block;">第三方内容提供商分层</span>
		<input type="text" name="profitratio[agent]" value="<?=$pftio['agent']?>">
		</span>
		<br style="clear: both;">
		<span id="ceng_teacher">
		<span style="width:150px;display:-moz-inline-box; display:inline-block;">网校分层(教师)</span>
		<input type="text" name="profitratio[teacher]" value="<?=$pftio['teacher']?>">
		</span>
	</td>
</tr>
<tr>
	<th>公开类型</th><td>
	<input type="radio" id="ispublic" name="ispublic" value="0" <?= empty($c['ispublic'])? 'checked=checked':'' ?> />不公开
	<input type="radio" id="ispublic" name="ispublic" value="1" <?= $c['ispublic']==1?'checked=checked':'' ?> />公开
	<input type="radio" id="ispublic" name="ispublic" value="2" <?= $c['ispublic']==2?'checked=checked':'' ?> />免费试听
	</td>
</tr>
<tr>
	<th>是否共享平台<p>如果打钩，那么此平台的课件和作业等资源可对其他平台分享</p></th>
	<td><input type="checkbox" id="isshare" name="isshare" value="1" <?php if($c['isshare']==1){echo 'checked=checked';}?> /></td>
</tr>
<tr>
	<th>是否有TV版本<p>如果打钩，那么此平台存在TV版本</p></th>
	<td><input type="checkbox" id="hastv" name="hastv" value="1" <?php if(!empty($c['hastv'])){echo 'checked=checked';}?> /></td>
</tr>
<tr>
	<th>TV网校LOGO
		<p>此处强烈建议上传341*654px的图片</p>
	</th>
	<td><?php $Upcontrol->upcontrol('tvlogo',1,array('upfilepath'=>$c['tvlogo']),'pic');?></td>
</tr>
<tr>
	<th>是否是大学平台<p>如果打钩，那么此平台是大学平台</p></th>
	<td><input type="checkbox" id="iscollege"  <?php if(!empty($c['iscollege'])){echo 'checked=checked';}?> name="iscollege" value="1" /></td>
</tr>
<tr>
	<th>是否开通网校运营服务<p>如果打钩，那么此平台开通此服务</p></th>
	<td><input type="checkbox" id="isservice" <?php if(!empty($c['isservice'])){echo 'checked=checked';}?> name="isservice" value="1" /></td>
</tr>
<tr>
	<th>头部图片
		<p>此处只能上传960px*60px显示在学生和教师 在网校的头部图片。</p>
	</th>
	<td><?php $Upcontrol->upcontrol('banner',1,array('upfilepath'=>$c['banner']),'pic');?></td>
</tr>
<tr>
	<th>浮动广告
		<p>模板首页浮动广告(告家长书等)</p>
	</th>
	<td><?php $Upcontrol->upcontrol('floatadimg',1,array('upfilepath'=>$c['floatadimg']),'pic');?></td>
</tr>
<tr>
	<th>浮动广告跳转链接
		<p>模板首页浮动广告跳转链接</p>
	</th>
	<td><input name="floatadurl" style="width:300px" value="<?=$c['floatadurl']?>"/></td>
</tr>
<tr>
	<th>显示获取用户名链接(one模板)
		<p>one模板是否显示获取用户名链接</p>
	</th>
	<td><input type="checkbox" name="showusername" value="1" <?php if($c['showusername']==1){echo 'checked=checked';}?>/></td>
</tr>
<tr>
	<th>默认密码
		<p>获取用户名显示的默认密码</p>
	</th>
	<td><input name="defaultpass" style="width:300px" value="<?=$c['defaultpass']?>"/></td>
</tr>
<tr><th>排序</th><td> <input type="text" class="w50" maxlength="50" name="displayorder" id="displayorder" value="<?=$c['displayorder']?>" ></td></tr>
<tr><th>云盘容量</th><td> <input type="text" class="w50" maxlength="50" name="totalpansize" id="totalpansize" value="<?=$c['totalpansize']?>" >G &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 已使用 <?=$c['usepansize']?>G </td> </tr>
    <tr><th>冻结金额时间</th><td><input type="text" name="fund_freeze" id="fund_freeze" value="<?=$c['fund_freeze']?>" maxlength="10"<?php if(empty($c['freeze_editable'])) { ?> readonly="readonly"<?php } ?> />天</td></tr>
<tr><th>转账信息</th><td><?php 
$editor = Ebh::app()->lib('UMEditor');
$editor->xEditor('transferinfo','850px','350px',empty($transferinfo[0])?'':$transferinfo[0]['custommessage'])?></td></tr>
</table>
<div id="dialog"></div>
<div class="buttons">
<input type="submit" name="valuesubmit" value="提交保存" class="submit">
<input type="reset"	 value="重置">
 
</div>
</form>
<script type='text/javascript'>
$(function(){
	// $('#begindate,#enddate').trigger('focus');
});
$('#drop').click(function(){
		$('#dialog').dialog({    
	    title: '选择用户',    
	    width:Math.ceil($(document).width()/2),
		height:450, 
	    closed: false,    
	    cache: false,    
	    href: '/admin/teacher/lite.html',    
	    modal: true   
	});
	$("#ck").trigger('click');    
});
$(function(){
$("#ceng_company input").blur(function(){

if(parseInt(this.value)>100){
this.value = 100;
}
$("#ceng_agent input").blur();
}).keyup(function(){
this.value=this.value.replace(/[^\d]/g,'')
});
$("#ceng_agent input").blur(function(){
	var company = parseInt($("#ceng_company input").val());
	if(isNaN(company)){
		company=0;
		$("#ceng_company input").val(0);
	}
	var agent = parseInt(this.value);
	if(company+agent>100){
	this.value = 100-company;
}
$("#ceng_teacher input").blur();
}).keyup(function(){
this.value=this.value.replace(/[^\d]/g,'')
});
$("#ceng_teacher input").blur(function(){
	var company = parseInt($("#ceng_company input").val());
	var agent = parseInt($("#ceng_agent input").val());
	var teacher = parseInt(this.value);
	if(isNaN(company)){
		$("#ceng_company input").val(0);
		company=0;
	}
	if(isNaN(agent)){
		$("#ceng_agent input").val(0);
		agent=0;
	}
	if(isNaN(teacher)){
		$("#ceng_teacher input").val(0);
		teacher=0;
	}
	this.value = 100-company-agent;
	}).keyup(function(){
	this.value=this.value.replace(/[^\d]/g,'')
	});
});
$(function(){
	$.ajax({
		url:'<?php echo geturl('admin/template/getlist');?>',
		type:'GET',
		success:function(data){
			var datas = eval('('+data+')');
			for(var i=0;i<datas.length;i++){
				if(datas[i]['tplname']=="<?=$c['template']?>"){
					$("#template").append("<option value='"+datas[i]['tplname']+"' selected=selected>"+ datas[i]['tplname']+ "</option>");
				}else{
					$("#template").append("<option value='"+datas[i]['tplname']+"'>"+ datas[i]['tplname']+ "</option>"); 
				}
				
			}
		},
		error:function(){
			alert();
		}
	});
});
$("#period").change(function(){
	var addYear = parseInt($(this).val());
	var begindate = $('.combo-value[name=begindate]').val();
	var d = new Date(begindate);
	d.setFullYear(d.getFullYear()+addYear);
	var _year = d.getFullYear();
	var _month = parseInt(d.getMonth())+1;
	var _day = d.getDate();
	var _hours = d.getHours();
	var _minutes = d.getMinutes();
	$('#enddate').datetimebox('setValue',_year+'-'+_month+'-'+_day+' '+_hours+':'+_minutes);
});
$.extend($.fn.validatebox.defaults.rules, {    
    isprice: {    
        validator: function(value, param){    
              return /^[0-9]{1,}([\.][0-9]{2})?$/.test(value);     
        }     
    },
    isnum: {    
        validator: function(value, param){    
              return /^[0-9]{1,}$/.test(value);     
        }     
    }   
});
$(function(){
    $('#domain').validatebox({    
        required: true,    
        missingMessage:'域名不能为空'
    });  
     $('#summary').validatebox({    
        required: true,    
        validType: 'length[10,1000]',
        missingMessage:'教室摘要不能为空',
        invalidMessage:'教室摘要长度必须为10-1000个字符'
    });
     $('#crprice').validatebox({    
        required: true,
        validType:'isprice',
        missingMessage:'教室金额的格式错误',
        invalidMessage:'教室金额的格式错误,必须为正整数或者两位小数的浮点数'
    }); 
     $('#displayorder').validatebox({    
        required: true,    
        validType: 'isnum',
        missingMessage:'排序不能为空',
        invalidMessage:'排序必须为正整数'
    });
      $('#totalpansize').validatebox({    
        required: true,    
        validType: 'isnum',
        missingMessage:'云盘不能为空',
        invalidMessage:'云盘必须为正整数'
    });
	$('#username').validatebox({
		required:true,
		validType: 'text',
		missingMessage:'请选择教师'
	});
	$('#begindate,#enddate').datebox({
		required:true,
		validType:'text',
		missingMessage:'请选择时间'
	});
	$('#profit_company,#profit_agent,#profit_teacher').validatebox({
		required:true,
		validType:'text',
		missingMessage:'请填写分成比例'
	});
	$(".datebox :text").attr("readonly","readonly");
	$("#fund_freeze").validatebox({
        required: true,
        missingMessage:'冻结金额天数不能为空',
        validType: 'isnum',
        invalidMessage: '冻结金额天数必须为正整数'
    });
});

function checkCrname(crname){
	
	if(crname!="<?=$c['crname']?>"){
		$('#crname').validatebox({    
	        required: true,    
	        validType: 'crname',
	        missingMessage:'教室名称不能为空',
    	});
	}else{
		$("#crname").validatebox({validType:''});
	}
}
function checkDomain(domain){
	$('#domain').validatebox({validType:''});
	if(domain!="<?=$c['domain']?>"){
		$('#domain').validatebox({    
	        required: true,    
	        validType: 'domain',
	        missingMessage:'域名不能为空'
    	});
	}else{
		$("#domain").validatebox({validType:''});
	}
}
</script>
</body>

<?php
$this->display('admin/footer');
?>