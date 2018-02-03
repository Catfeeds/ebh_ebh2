<?php $this->display('homev2/header'); ?>
<?php $this->display('homev2/top');?>
<style>
.essinfor_top .titless ,.essinfor_tops .titless {
    width: 595px;
    padding: 0 !important;
}
.essinfor_top .titless h3 ,.essinfor_tops .titless h3 {
    color: #333;
    background: url(http://static.ebanhui.com/ebh/tpl/2014/images/pico1.jpg) no-repeat left center;
    padding-left: 30px;
    height: 27px;
    font-size: 14px;
    font-weight: bold;
}

</style>
<div class="divcontent">
	<div class="conentlft">
	<div class="topbaad">
	<div class="user-main clearfix">
	<div class="lefrig" style="background:#fff;margin-top:10px;float:left;width:1000px;">
<?php $this->display('homev2/small_menu');?>
		<div class="card-body" style="min-height:580px;" >
			<div class="essinfor">
				<div class="jizl" style="padding-bottom:20px;">
					<div class="essinfor_top">
						<div class="titless fl"><h3>基本资料</h3></div>
						<div class="bianjis fr"><a href="javascript:;" id="btn_edit" class="hrelh" onclick="editinfo();">[修改]</a></div>
					</div>
					<div class="clear"></div>
					<div class="essinfor_bottom">
						<ul>
							<li class="fl" style="height:33px;"><span class="span1">昵　　称：</span><span id="nickname_span" class="span2"><?= $teacher['nickname'] ?></span><input type="text" style="display:none;" value="<?=$teacher['nickname']?>" id="nickname" maxlength="20"/><input type="hidden" value="<?=$teacher['uid']?>" id="uid" /></li>
							<li class="fl" style="height:33px;">
								<span class="span1">性　　别：</span><span id="sex_span" class="span2"><?= $teacher['sex'] == 1 ? '女' : '男' ?></span>
								<span id="sex" style="display:none;">
									<label>
										<input type="radio" value="0" name="sex" <?php if($teacher['sex'] == 0) echo 'checked="checked";'?> style="width:16px; position:relative;top:7px;*top:2px; border:none;" /><span class="span2">男</span>
									</label>&nbsp;
									<label>
										<input type="radio" value="1" name="sex" <?php if($teacher['sex'] == 1) echo 'checked="checked";'?> style="width:16px; position:relative;top:7px;*top:2px;border:none;" /><span class="span2">女</span>
									</label>
								</span>
							</li>
							<li class="fl" style="height:33px;">
								<span class="span1">姓　　名：</span><span id="realname_span" class="span2"><?= $teacher['realname'] ?></span><input type="text" style="display:none;" value="<?=$teacher['realname']?>" id="realname" maxlength="16"/>
							</li>
							<li class="fl" style="height:33px;">
								<span class="span1">出生日期：</span><span  id="birthdate_span" class="span2"><?=$teacher['birthdate']?Date('Y-m-d',$teacher['birthdate']):''?></span><input id="birthdate" class="Wdate" style="display:none" type="text" value="<?=$teacher['birthdate']?Date('Y-m-d',$teacher['birthdate']):''?>" onClick="WdatePicker()">
							</li>
							<li class="fl" style="height:33px;">
								<span class="span1">单　　位：</span><span id="workunit_span" class="span2"><?= empty($teacher['workunit'])?$roominfo['crname']:$teacher['workunit'] ?></span><input type="text" style="display:none;" value="<?=empty($teacher['workunit'])?$roominfo['crname']:$teacher['workunit']?>" id="workunit" maxlength="50"/>
							</li>
							<li class="fl" style="height:33px;">
								<span class="span1">部　　门：</span><span id="department_span" class="span2"><?= $teacher['department'] ?></span><input type="text" style="display:none;" value="<?=$teacher['department']?>" id="department" maxlength="50"/>
							</li>
							<li class="fl" style="height:33px;">
								<span class="span1">职　　称：</span><span id="professionaltitle_span" class="span2"><?= $teacher['professionaltitle'] ?></span><input type="text" style="display:none;" value="<?=$teacher['professionaltitle']?>" id="professionaltitle" maxlength="50"/>
							</li>
							<li class="fl" style="height:33px;">
								<span class="span1">职　　务：</span><span id="position_span" class="span2"><?= empty($teacher['position'])?'老师':$teacher['position'] ?></span><input type="text" style="display:none;" value="<?=empty($teacher['position'])?'老师':$teacher['position']?>" id="position" maxlength="50"/>
							</li>
							<li class="fl" style="height:33px;">
								<span class="span1">学　　历：<input type="hidden" id="old_degree" value="<?=$teacher['degree']?>" /></span><span id="degree_span" class="span2"><?php if (!empty($teacher['degree']) && array_key_exists($teacher['degree'], $degreearr)) echo $degreearr[$teacher['degree']];?></span><select id="degree" style="display:none;width:100px;border: 1px solid #e1e1e1;height: 24px;line-height: 24px;padding-left: 5px;">
								<option value="0">请选择</option>
								<?php foreach ($degreearr as $key => $value){?>
									<option value="<?=$key?>" <?=($teacher['degree'] == $key) ? "selected='selected'" : '' ?>><?=$value?></option>
								<?php }?>
								</select>
							</li>
							<li class="fl" style="height:33px;">
								<span class="span1">毕业院校：</span><span id="graduateschool_span" class="span2"><?=$teacher['graduateschool']?></span><input type="text" style="display:none;" id="graduateschool" value="<?=$teacher['graduateschool']?>" />
							</li>
							<li class="fl" style="height:33px;">
								<span class="span1">教　　龄：</span><span id="schoolage_span" class="span2"><?= $teacher['schoolage'] ?></span><input type="text" style="display:none;width:80px;" value="<?=$teacher['schoolage']?>" id="schoolage" /><span class="span2"> 年</span>
							</li>
							<li class="fl" style="height:33px;">
								<span class="span1">手机号码：</span><span id="mobile_span" class="span2"><?php if(!empty($teacher['mobile'])){echo $teacher['mobile'];}else{echo $teacher['tmobile'];}?></span><input type="text" readonly="readonly" style="display:none;" id="mobile" value="<?= $teacher['mobile'] ?>" />
							</li>
							<li class="fl" style="height:33px;">
								<span class="span1">电话号码：</span><span id="phone_span" class="span2"><?=$teacher['phone']?></span><input type="text" style="display:none;" id="phone" value="<?= $teacher['phone'] ?>" />
							</li>
							<li class="fl" style="height:33px;">
								<span class="span1">传　　真：</span><span id="fax_span" class="span2"><?=$teacher['fax']?></span><input type="text" style="display:none;" id="fax" value="<?= $teacher['fax'] ?>" />
							</li>
							<li class="fl" style="width:715px;">
								<div  id="QQsqm"></div>
								<span class="span1" style="float:left;">现居住地：<input type="hidden" id="old_citycode" value="<?=$teacher['citycode']?>" /></span>
								<div>
									<span class="span2" id="citycode_span">
									<?php
									if(!empty($teacher['citycode']))
									{
									$this->widget('cities_widget',array('citycode'=>$teacher['citycode'],'getText'=>1,'tag'=>'zzz2'));
									}
									?>
									</span>
									<span class="span2" id="address_span"><?=$teacher['address']?></span>
									<div style="display:none;float:left;" id="citycode">
									<?php
									$this->widget('cities_widget',array('citycode'=>$teacher['citycode'],'tag'=>'zzz1'));
									?>
									</div>
								</div>
							</li>
							<li class="fl mt5" style="display:none;width:726px;" id="address_li">
								<span class="span1" id="address_title" style="float:left;">详细地址：</span>
								<div style="width:656px;float:left;">
									<textarea id="address" style="resize:none;width:634px; height:40px; border:1px solid #e1e1e1;"><?=$teacher['address']?></textarea>
								</div>
							</li>
							<li class="fl mt5" style="width:726px;">
								<span class="span1" style="float:left;">个人简介：</span>
								<div style="width:656px;float:left;">
									<span id="profile_span" class="span2" style="width:656px;"><?=$teacher['profile']?></span>
									<textarea  id="profile" style="resize:none;display:none;width:634px; height:100px;border:1px solid #e1e1e1;"><?=$teacher['profile']?></textarea>
								</div>
							</li>
							<li class="fl mt5" style="width:726px;">
								<span class="span1" style="float:left;">详细介绍：</span>
								<div style="width:656px;float:left;">
									<span  id="vitae_message_span" class="span2" style="width:623px;"><?= $teacher['message'] ?></span>
								    <div id="vitae_message_div" style="display:none;float:left;" ><?php $editor->xEditor('vitae_message', '654px', '200px', $teacher['message']);?>
	                                </div>
                                </div>
							</li>
						</ul>
					</div>
					<div class="fkrer" style="display:none" id="btn_info">
						<a href="javascript:;" class="huibtn" onclick="cancelinfo()" style="background:#eee;color:#000;margin-right:10px;">取 消</a>
						<a href="javascript:;" class="lanbtn" onclick="saveinfo()">保 存</a>
					</div>
				</div>
				<div class="clear"></div>
				<div class="jinglis mt30">
					<div class="essinfor_tops">
						<div class="title fl"><h3 style="background: url(http://static.ebanhui.com/ebh/tpl/2014/images/qq_code.png) no-repeat left center;">QQ授权代码</h3></div>
						<div class="bianjis fr"><a href="javascript:;" id="qqadd_add" class="hrelh">[修改]</a></div>
					</div>
					<!--expadd begin-->
					<div id="qqadd_div" style="display:none;">
						<div class="essinfor_bottoms" style="border-top:1px solid #e1e1e1; padding-top:15px;">
							<div class="dates " >
								<div class="fl" ><a target='_blank' href="/home/profile/step.html" style="color:#4c88ff;">如何获取QQ在线状态?</a></div>
								<div class="clear"></div>
								<div class="neirong mt15">
									<div class="titless">复制QQ授权代码并将其粘贴到此处</div>
									<div class="mt10">
										<!-- <textarea class="neirongs" style="resize:none;" id="qq_href"></textarea> -->
										<input type="text"  id="qq_href" class="neirongs" style="width:100%">
									</div>
								</div>
							</div>
						</div>
						<div class="clear"></div>
						<div class="fkrer">
							<a href="javascript:;" class="huibtn" id="qq_cancel" style="background:#eee;color:#000;margin-right:10px;">取 消</a>
							<a href="javascript:;" class="lanbtn" id="qq_save" >保 存</a>
						</div>
					</div>
					<div class="clear"></div>
					<ul id="qqlist">
						<li class="essinfor_bottoms mt15"><div><p class="olddescription" style="width:100%"><div style="width:100%" id="qq_code"><?php if(!empty($qq_href)) echo $qq_href; else echo '你还没有添加QQ授权码'; ?></div></p></div></li>
					</ul>
				</div>
				<div class="clear"></div>
				<div class="jinglis mt15">
					<div class="essinfor_tops">
						<div class="titless fl"><h3>过往经历</h3></div>
						<div class="bianjis fr"><a href="javascript:;" id="expadd_add" class="hrelh">[添加]</a></div>
					</div>
					<!--expadd begin-->
					<div id="expadd_div" style="display:none;">
						<div class="essinfor_bottoms" style="border-top:1px solid #e1e1e1; padding-top:15px;">
							<div class="dates " >
								<div class="fl" ><span class="span1s">开始时间：</span><input type="text" value="" class="begindate" /></div>
								<div class="fl"><span class="span1s" style="padding-left:15px;">结束时间：</span><input type="text" value="" class="enddate" /></div>
							</div>
							<div class="clear"></div>
							<div class="neirong mt15">
								<div class="titless">描述过往经历（小于200字）：</div>
								<div class="mt10">
									<textarea class="neirongs" style="resize:none;"></textarea>
								</div>

							</div>

						</div>
						<div class="clear"></div>
						<div class="fkrer">
							<a href="javascript:;" class="huibtn" id="expadd_cancel" style="background:#eee;color:#000;margin-right:10px;">取 消</a>
							<a href="javascript:;" class="lanbtn" id="expadd_save" >保 存</a>
						</div>
						<div class="clear"></div>

					</div>
					<!--expadd end-->
					<ul id="explist">
					<?php foreach($explist as $exp){?>
						<li class="essinfor_bottoms mt15" id="exp_<?=$exp['expid']?>">
							<div class="expshow">
								<div class="action fr"><span class="icons edit">编辑</span><span class="icons remove">删除</span></div>
								<div class="date"><span class="oldbegindate"><?=$exp['begindate']?></span> — <span class="oldenddate"><?=$exp['enddate']?></span></div>
								<div><p class="olddescription"><?=$exp['description']?></p></div>
							</div>

						</li>
					<?php } ?>
					</ul>
				</div>

			</div>
		</div>
		
		<div  class="clear"></div>
	</div>
	</div>
	</div>
	</div>
<!--<div class="cotentrgt">
<img src="http://static.ebanhui.com/ebh/tpl/2016/images/rgtimg.jpg" />
</div>-->
</div>

<script type="text/javascript">
var fields = new Array('nickname', 'sex', 'realname', 'birthdate', 'workunit', 'department', 'professionaltitle', 'position', 'degree', 'graduateschool', 'schoolage', 'citycode', 'address', 'mobile', 'phone', 'fax', 'profile', 'vitae_message');

function editinfo() {
	var span;
	var id;
	for(var i = 0; i < fields.length; i++) {
		id = fields[i];
		span = $("#"+id+"_span").html();

		//初始化赋值
		if(id == 'sex') {
			span = span == '女' ? 1 : 0;
			$('input[name="sex"]').eq(span).prop("checked",true);
		}
		else if(id == 'degree') {
			if (span != '') {
				var old_degree = $("#old_degree").val();
				$("#"+id).val(old_degree);
			}
		}
		else if(id == 'citycode') {//设置现居地初始值

			var old_citycode = $("#old_citycode").val();

			if(old_citycode == '')
			{
				$.ajax({
					type:'post',
					url:'/admin/cities/getCities.html',
					data:{'citycode':null,'type':5},
					dateType:"html",
					success:function(_html){
                    $("#address_sheng").html(_html);
                    }
            	});
				$("#address_shi").html('<option value="">请选择</option>');
				$("#address_qu").html('<option value="">请选择</option>');
			}
			else
			{
				$.ajax({
					type:'post',
					url:'/admin/cities/getAddr.html',
					data:{'citycode':old_citycode,'type':5},
					dateType:"html",
					success:function(_html){
						$("#zzz1").html(_html);
					}
				});
			}

		}
		else if(id == 'vitae_message') {
			//$("#vitae_message").html(span);
		}
		else {
			$("#"+id).val(span);
		}

		//显示输入框
		if(id == 'vitae_message') {
			$("#vitae_message_span").hide();
			$("#vitae_message_div").show();
		}
		else if(id == "address")
		{
			$("#address_span").hide();
			$("#address_li").show();
		}
<?php if (empty($is_admin_edit)) {//教师编辑姓名的限制?>
		else if(id == 'realname' && span != '') {
			//do nothing
		}
<?php }?>
		else {
			$("#"+id+"_span").hide();
			$("#"+id).show();
		}
	}
	//显示隐藏按钮，重设窗口高
	$("#btn_info").show();
	$("#btn_edit").hide();
//	window.parent.resetmain();
}

function cancelinfo() {
	var id;
	for(var i = 0; i < fields.length; i++) {
		id = fields[i];
		$("#"+id+"_span").show();
		if(id=='vitae_message')
		{
			$("#"+id+"_div").hide();
		}
		else if(id == "address")
		{
			$("#address_li").hide();
		}
		else
		{
			$("#"+id).hide();
		}
	}
	//显示隐藏按钮，重设窗口高
	$("#btn_edit").show();
	$("#btn_info").hide();
	//window.parent.resetmain();
	
}

function saveinfo() {
	var id;
	var value;
	var data = {};
	data['uid'] = $("#uid").val();
	for(var i = 0; i < fields.length; i++) {
		id = fields[i];
		value = $("#"+id).val();
		if(id!='profile'){
			value = value.replace(/"|'/gm, '');
		}
<?php if (empty($is_admin_edit)) {//教师编辑姓名的限制?>
		if(id=='realname') {
			var oldrealname = $("#realname_span").html();
			if(oldrealname != '') {
				value = '';	
			}
		}
<?php }?>
		if(id=='sex'){
			value = $("input[name='sex']:checked").val() ;
		}
		else if(id=='citycode'){
		
			var sheng = $("#address_sheng").val();
			var shi = $("#address_shi").val();
			var qu = $("#address_qu").val();

			if(qu!=''){
				value=qu;
			}else if(shi!=''){
				value=shi;
			}else if(sheng!=''){
				value=sheng;
			}else{
				value='';
			}
			
		}
		else if(id == 'address'){
			var address = $("#address").val();
			if (address != "") {
				if (address.length>100) {
					var d = dialog({
						title: '提示信息',
						content: '请输入正确的地址！不超过100个字!',
						okValue: '确定',
						cancel: false,
						ok: function () {}
					});
					d.showModal();
					$("#address").focus();
					return false;
				}
			}
		}
		else if(id=='mobile'){
			var mv = $("#mobile").val();
			var reg = /^1\d{10}$/; 
			if(mv!='' && !reg.test(mv)){
				var d = dialog({
					title: '提示信息',
					content: '请输入正确的手机号码！',
					okValue: '确定',
					cancel: false,
					ok: function () {}
				});
				d.showModal();
				$("#mobile").focus();
				return false;
			}	
		}
		else if(id == 'fax'){
			var fax = $("#fax").val();
			var pattern =/^\d{3,4}-\d{7,8}$/; 
			if(fax!='' && !pattern.test(fax)){
				var d = dialog({
					title: '提示信息',
					content: '请输入正确的传真号码！格式为:区号-号码。',
					okValue: '确定',
					cancel: false,
					ok: function () {}
				});
				d.showModal();
				$("#fax").focus();
				return false;
			}
		}
		else if(id == 'phone'){
			var phone = $("#phone").val();
			var pattern =/^\d{3,4}-\d{7,8}$/; 
			if(phone!='' && !pattern.test(phone)){
				var d = dialog({
					title: '提示信息',
					content: '请输入正确的电话号码！格式为:区号-号码。',
					okValue: '确定',
					cancel: false,
					ok: function () {}
				});
				d.showModal();
				$("#phone").focus();
				return false;
			}
		}
		else if(id == 'schoolage') {
			var schoolage = $("#schoolage").val();
			var pattern = /^\d{0,2}$/;
			if (schoolage != '' && !pattern.test(schoolage) || schoolage > 80) {
				var d = dialog({
					title: '提示信息',
					content: '请输入正确的教龄！教龄一般为0-80！',
					okValue: '确定',
					cancel: false,
					ok: function () {}
				});
				d.showModal();
				$("#schoolage").focus();
				return false;
			}
		}
		else if(id == 'profile'){
			var profile = $("#profile").val();
			if (profile != "") {
				if (profile.length>250) {
					var d = dialog({
					title: '提示信息',
					content: '请输入正确的个人简介，不超过250个字！',
					okValue: '确定',
					cancel: false,
					ok: function () {}
				});
				d.showModal();
					$("#profile").focus();
					return false;
				}
			}
		}
		else if(id == 'vitae_message'){
			value = UE.getEditor("vitae_message").getContent();
			//value = UM.getEditor("vitae_message").getContent();
		}
		
		data[id] = filterXSS(value);
	}
	
	//ajax save
	$.ajax({
		url:"<?=geturl('teacher/setting/updateinfo')?>",
		type:'post',
		data:{'data':data},
		dataType:'json',
		success:function(data){
			if(data.code==1){
				for(var i = 0; i < fields.length; i++) {
					id = fields[i];
					$("#"+id+"_span").show();
					if(id=='vitae_message')
					{
						$("#"+id+"_div").hide();
					}
					else if(id=='address')
					{
						$("#"+id+"_li").hide();
					}
					else
					{
						$("#"+id).hide();
					}
					
					if(id=='citycode'){
						var sheng = $('#address_sheng')[0];
						var shi = $('#address_shi')[0];
						var qu = $('#address_qu')[0];
						sheng_text = sheng.options[sheng.selectedIndex].text;
						shi_text = shi.options[shi.selectedIndex].text;
						qu_text = qu.options[qu.selectedIndex].text;
						sheng_text=(sheng_text=="请选择")?'':sheng_text;
						shi_text=(shi_text=="请选择")?'':shi_text;
						qu_text=(qu_text=="请选择")?'':qu_text;
						value = sheng_text+' '+shi_text+' '+qu_text;
						$("#citycode_span").html(value);
						$("#old_citycode").val(data.value['citycode']);
					}
					else if(id=='degree')
					{
						$("#degree_span").html(data.value[id]);
						$("#old_degree").val( $("#degree").val() );
					}
<?php if (empty($is_admin_edit)) {//教师编辑姓名的限制?>
					else if(id == 'realname' && data.value['realname'] == '')
					{
						//do nothing
					}
<?php }?>
					else
					{
						$("#"+id+"_span").html(data.value[id]);
					}
				}
				
				//显示隐藏按钮
				$("#btn_edit").show();
				$("#btn_info").hide();
				//window.parent.resetmain();
				var d = dialog({
					title: '基本信息',
					content:data.message,
					cancel: false
				});
				d.show();
				setTimeout(function () {
					d.close().remove();
				}, 2000);							
			}
			else
			{
				var d = dialog({
					title: '基本信息',
					content:data.message,
					cancel: false
				});
				d.show();
				setTimeout(function () {
					d.close().remove();
				}, 2000);
			}
		}
	});
}

/*过往经历*/
$(function(){
	$("#expadd_add").click(function(){
		$("#expadd_add").hide();
		$("#expadd_div").show();
		//重置输入
		$("#expadd_div .begindate").val("");
		$("#expadd_div .enddate").val("");
		$("#expadd_div textarea").val("");
	//	window.parent.resetmain();
	});
	$("#expadd_cancel").click(function(){
		$("#expadd_div").hide();
		$("#expadd_add").show();
	//	window.parent.resetmain();
	});
	$("#expadd_save").click(function(){
		var begindate = filterXSS($("#expadd_div .begindate").val());
		var enddate = filterXSS($("#expadd_div .enddate").val());
		var description = filterXSS($("#expadd_div textarea").val());
		var uid = $("#uid").val();
		if (begindate != "") {
			if (begindate.length>20) {
				var d = dialog({
					title: '提示信息',
					content: '请正确填写开始时间！',
					okValue: '确定',
					cancel: false,
					ok: function () {}
				});
				d.showModal();
				$("#expadd_div .begindate").focus();
				return false;
			}
		}
		else
		{
			var d = dialog({
					title: '提示信息',
					content: '请填写开始时间！',
					okValue: '确定',
					cancel: false,
					ok: function () {}
				});
				d.showModal();
			$("#expadd_div .begindate").focus();
			return false;
		}
		if (enddate != "") {
			if (enddate.length>20) {
				var d = dialog({
					title: '提示信息',
					content: '请正确填写结束时间！',
					okValue: '确定',
					cancel: false,
					ok: function () {}
				});
				d.showModal();
				$("#expadd_div .enddate").focus();
				return false;
			}
		}
		else
		{
			var d = dialog({
				title: '提示信息',
				content: '请填写结束时间！',
				okValue: '确定',
				cancel: false,
				ok: function () {}
			});
			d.showModal();
			$("#expadd_div .enddate").focus();
			return false;
		}
		if (description != "") {
			if (description.length>200) {
				var d = dialog({
					title: '提示信息',
					content: '请正确描述过往经历，不能超过200个字！',
					okValue: '确定',
					cancel: false,
					ok: function () {}
				});
				d.showModal();
				$("#expadd_div textarea").focus();
				return false;
			}
		}
		else
		{
			var d = dialog({
				title: '提示信息',
				content: '请填写过往经历描述！',
				okValue: '确定',
				cancel: false,
				ok: function () {}
			});
			d.showModal();
			$("#"+exp_li+" textarea").focus();
			return false;
		}

		$.ajax({
			type: "POST",
			url: "<?=geturl('teacher/setting/addexperience')?>",
			data: {begindate:begindate, enddate:enddate, description:description, uid:uid},
			dataType: "json",
			success: function(data){
				if(data.code==1){
					//增加li
					$("#explist").prepend('<li class="essinfor_bottoms mt15" id="exp_'+data.expid+'"><div class="expshow"><div class="action fr"><span class="icons edit">编辑</span><span class="icons remove">删除</span></div><div class="date"><span class="oldbegindate">'+begindate+'</span> — <span class="oldenddate">'+enddate+'</span></div><div><p class="olddescription">'+description+'</p></div></div></li>');
					$("#expadd_div").hide();
					$("#expadd_add").show();
					//window.parent.resetmain();

					var d = dialog({
						title: '过往经历',
						content:data.message,
						cancel: false
						});
						d.show();
						setTimeout(function () {
							d.close().remove();
						}, 2000);
				}
				else
				{
					var d = dialog({
						title: '过往经历',
						content:data.message,
						cancel: false
						});
						d.show();
						setTimeout(function () {
							d.close().remove();
						}, 2000);
				}
			}
		});
	});

	//显示编辑、删除按钮
	$("#explist").delegate("li", 'mouseover', function(){
			$(this).find(".action").show();
	});
	$("#explist").delegate("li", 'mouseout', function(){
			$(this).find(".action").hide();
	});

	//点击编辑
	$("#explist").delegate(".edit", 'click', function(){
		var exp_li = $(this).closest('li').attr("id");
		var oldbegindate = $("#"+exp_li).find(".oldbegindate").html();
		var oldenddate = $("#"+exp_li).find(".oldenddate").html();
		var olddescription = $("#"+exp_li).find(".olddescription").html();
		var editdiv = '';
		editdiv += '<div class="expedit"><div class="dates" >';
		editdiv += '<div class="dates" ><div class="fl" ><span class="span1s">开始时间：</span><input type="text" value="'+oldbegindate+'" class="begindate" style="width:250px;" /></div><div class="fl"><span class="span1s" style="padding-left:15px;">结束时间：</span><input type="text" value="'+oldenddate+'" class="enddate" style="width:250px;" /></div></div>';
		editdiv += '<div class="clear"></div>';
		editdiv += '<div class="neirong mt15"><div class="titless">描述过往经历（小于200字）：</div>';
		editdiv += '<div class="mt10"><textarea class="neirongs" style="width:642px;resize:none;">'+olddescription+'</textarea></div></div>';
		editdiv += '<div class="fkrer"><a style="background:#eee;color:#000;margin-right:10px;" class="huibtn" href="javascript:;">取 消</a><a class="lanbtn" href="javascript:;">保 存</a></div><div class="clear"></div></div>';
		$("#"+exp_li).append(editdiv);
		$("#"+exp_li).children(".expshow").hide();
		//window.parent.resetmain();
	});

	//删除经历
	$("#explist").delegate(".remove", 'click', function(){
		var exp_li = $(this).closest('li').attr("id");
		var expid = exp_li.substr(4);
		var uid = $("#uid").val();
		var d = dialog({
			title: '删除确认',
			content: '您确定要删除该经历吗？',
			okValue: '确定',
			ok: function () {
			$.ajax({
				type: 'POST',
				url: "<?=geturl('teacher/setting/delexperience')?>",
				data: {expid:expid, uid:uid},
				dataType: 'json',
				success: function(data){
					if(data.code==1){
						$("#"+exp_li).remove();
						//window.parent.resetmain();

					var d = dialog({
						title: '过往经历',
						content:data.message,
						cancel: false
						});
						d.show();
						setTimeout(function () {
							d.close().remove();
						}, 2000);
					}
					else
					{
					var d = dialog({
						title: '过往经历',
						content:data.message,
						cancel: false
						});
						d.show();
						setTimeout(function () {
							d.close().remove();
						}, 2000);
					}
				}
			});
		},
		cancelValue: '取消',
        cancel: function () {}
    });
    d.showModal();
	});

	//取消编辑
	$("#explist").delegate(".huibtn", 'click', function(){
		var exp_li = $(this).closest('li').attr("id");
		$("#"+exp_li).children(".expshow").show();
		$("#"+exp_li).children(".expedit").remove();
		$("#"+exp_li).find(".action").hide();
		//window.parent.resetmain();
	});

	//保存编辑
	$("#explist").delegate(".lanbtn", 'click', function(){
		var exp_li = $(this).closest('li').attr("id");
		var begindate = filterXSS($("#"+exp_li).find(".begindate").val());
		var enddate = filterXSS($("#"+exp_li).find(".enddate").val());
		var description = filterXSS($("#"+exp_li).find("textarea").val());
		var expid = exp_li.substr(4);
		var uid = $("#uid").val();

		if (begindate != "") {
			if (begindate.length>20) {
				var d = dialog({
					title: '提示信息',
					content: '请正确填写开始时间！',
					okValue: '确定',
					cancel: false,
					ok: function () {}
				});
				d.showModal();
				$("#"+exp_li+" .begindate").focus();
				return false;
			};
		}
		else
		{
			var d = dialog({
					title: '提示信息',
					content: '请填写开始时间！',
					okValue: '确定',
					cancel: false,
					ok: function () {}
				});
				d.showModal();
			$("#"+exp_li+" .begindate").focus();
			return false;
		}
		if (enddate != "") {
			if (enddate.length>20) {
				var d = dialog({
					title: '提示信息',
					content: '请正确填写结束时间！',
					okValue: '确定',
					cancel: false,
					ok: function () {}
				});
				d.showModal();
				$("#"+exp_li+" .enddate").focus();
				return false;
			};
		}
		else
		{
			var d = dialog({
					title: '提示信息',
					content: '请填写结束时间！',
					okValue: '确定',
					cancel: false,
					ok: function () {}
				});
				d.showModal();
			$("#"+exp_li+" .enddate").focus();
			return false;
		}
		if (description != "") {
			if (description.length>200) {
				var d = dialog({
					title: '提示信息',
					content: '请正确描述过往经历，不能超过200个字！',
					okValue: '确定',
					cancel: false,
					ok: function () {}
				});
				d.showModal();
				$("#"+exp_li+" textarea").focus();
				return false;
			}
		}
		else
		{
			var d = dialog({
					title: '提示信息',
					content: '请填写过往经历描述！',
					okValue: '确定',
					cancel: false,
					ok: function () {}
				});
				d.showModal();
			$("#"+exp_li+" textarea").focus();
			return false;
		}

		$.ajax({
			type: "POST",
			url: "<?=geturl('teacher/setting/editexperience')?>",
			data: {expid:expid, begindate:begindate, enddate:enddate, description:description, uid:uid},
			dataType: "json",
			success: function(data){
				if(data.code==1){
					$("#"+exp_li).find(".oldbegindate").html(begindate);
					$("#"+exp_li).find(".oldenddate").html(enddate);
					$("#"+exp_li).find(".olddescription").html(description);
					$("#"+exp_li).children(".expshow").show();
					$("#"+exp_li).children(".expedit").remove();
					$("#"+exp_li).find(".action").hide();
				//	window.parent.resetmain();
					var d = dialog({
						title: '过往经历',
						content:data.message,
						cancel: false
						});
						d.show();
						setTimeout(function () {
							d.close().remove();
						}, 2000);					
				}
				else
				{
					var d = dialog({
						title: '过往经历',
						content:data.message,
						cancel: false
						});
						d.show();
						setTimeout(function () {
							d.close().remove();
						}, 2000);
				}
			}
		});
	});

});

$(function(){
	$('body').on('click','.edui-icon-emotion',function(){
		$('.edui-dropdown-menu').width(590).height(394);
	});
});
</script>
<script type="text/javascript">
var mainFrame = parent.document.getElementById("mainFrame");
	function htmlspecialchars(str){            
          str = str.replace(/&/g, '&amp;');  
          str = str.replace(/</g, '&lt;');  
          str = str.replace(/>/g, '&gt;');  
          str = str.replace(/"/g, '&quot;');  
          str = str.replace(/'/g, '&#039;');  
          return str;  
	}  
	//添加qq在线状态
		$("#qqadd_add").click(function(){
			if(mainFrame) {
				addHeight(260);
			}
			$("#qqadd_add").hide();
			$("#qqadd_div").show();
			//重置输入
			$("#qqadd_div .begindate").val("");
			$("#qqadd_div .enddate").val("");
			html = $("#qq_code").html();
			$("#qqadd_div textarea").val(html);
			$('#qqlist').hide();
		});
		$("#qq_cancel").click(function(){
			if(mainFrame) {
				resetHeight(260);
			}
			$("#qqadd_div").hide();
			$("#qqadd_add").show();
			$('#qqlist').show();
		});
		$("#qq_save").click(function(){
			var html = $("#qq_href").val();
			html = htmlspecialchars(html);
			$.ajax({
				type: "POST",
				url: "<?=geturl('home/profile/addqqhref')?>",
				data: {href:html},
				dataType: "json",
				success: function(data){
					if(data.status){
						//增加li
						$("#qq_code").html(html);
					
						// $("#qqlist").css('display','block');
						$("#qqadd_div").hide();
						$("#qqadd_add").show();
						$('#qqlist').show();
						if(mainFrame) {
							resetHeight(260);
							addHeight(84);
						}
						var d = dialog({
							title: '信息提示',
							content: '添加成功!',
							cancel: false,
							width:350,
							okValue:'确定',
							ok: function () {

							}
						});
						d.showModal();
					}
					else
					{
						if(mainFrame) {
							resetHeight(260);
							addHeight(84);
						}
						var d = dialog({
							title: '信息提示',
							content: '添加失败!',
							cancel: false,
							width:350,
							okValue:'确定',
							ok: function () {

							}
						});
						d.showModal();
					}
				}
			});
		});
		
</script>
<?php $this->display('homev2/footer');?>
