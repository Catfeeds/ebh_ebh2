<?php $this->display('home/page_header'); ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />

<style type="text/css">
.card-body {width:726px;padding: 20px 30px 50px;; margin:0 auto;}
.essinfor_top{ height:27px; line-height:27px; border-bottom:1px solid #e1e1e1; padding-bottom:10px;}
.essinfor_top .title{ width:595px; padding:0 !important;}
.essinfor_top .title h3{ color:#333; background:url("http://static.ebanhui.com/ebh/tpl/2014/images/pico1.jpg") no-repeat left center; padding-left:30px; height:27px; font-size:14px; font-weight:bold;}
.essinfor_top a.hrelh {background:url("http://static.ebanhui.com/ebh/tpl/2014/images/xiudty.jpg") no-repeat left center;color: #2796f0;display: block;float: right;height: 24px;line-height: 24px;padding-left: 20px;text-align: center;text-decoration: none;width: 45px;}
.essinfor_bottom{ line-height:32px; font-size:14px; min-height:210px;}
.essinfor_bottom ul li{ width:360px; }
.essinfor_bottom .span1{ color:#333;font-family:"微软雅黑";}
.essinfor_bottom .span2{ color:#666;}
ul li.essinfor_bottoms{ width:684px; border:1px solid #e6e6e6; padding:10px 20px;}
.essinfor_tops{ height:27px; line-height:27px; padding-bottom:10px;}
.essinfor_tops .title{ width:595px; padding:0 !important;}
.essinfor_tops .title h3{ font-size:14px; font-weight:bold;color:#333; background:url("http://static.ebanhui.com/ebh/tpl/2014/images/pico2.jpg") no-repeat left center; padding-left:30px; height:27px;}
.essinfor_tops a.hrelh {background:url("http://static.ebanhui.com/ebh/tpl/2014/images/xiudty.jpg") no-repeat left center;color: #2796f0;display: block;float: right;height: 24px;line-height: 24px;padding-left: 20px;text-align: center;text-decoration: none;width: 45px;}
.essinfor_bottoms .date{ font-weight:bold; font-size:14px; color:#333; display:block; padding-bottom:7px;}
.essinfor_bottoms .olddescription{ font-size:13px; color:#606060; word-wrap: break-word; width:696px;}
.essinfor_bottoms .action {display: none;}
.essinfor_bottoms .action .icons {background-color: #abc0e9;border-radius: 2px;color: #fff;cursor: pointer;font-size: 12px;line-height: 18px;margin-left: 10px;padding: 3px 7px;}
.essinfor_bottom .span1s{ position:relative; top:-50px;}
.essinfor_bottom textarea{ font-size:14px;  padding:10px; line-height:23px;letter-spacing: 2px;}
.card-body .essinfor input{ width:260px; border:1px solid #e1e1e1; height:24px; line-height:24px; padding-left:5px;}
.fkrer { display: inline;float: right; height: 50px;padding: 10px 0 0;}
.fkrer a.huibtn {border: none;color: #fff;cursor: pointer;display: block;float: left;font-size: 14px;height: 32px;line-height: 32px;text-align: center;text-decoration: none; width: 87px;}
.fkrer a.lanbtn {background: #18a8f7 ;border: medium none;color: #fff;cursor: pointer;display: block;float: left;font-size: 14px;font-weight: bold;height: 32px;line-height: 32px;text-align: center;text-decoration: none; width: 87px;}
.essinfor_bottoms{ font-size:14px; font-family:"微软雅黑";}
.neirongs{ border:1px solid #e1e1e1; width:684px; height:100px; padding:10px 20px; color:#666;}
 .span2s{ position:relative; top:-25px;}
 .xqah .essinfor_bottom ul li{ height:64px;}
.expedit{font-size: 13px;}
.expedit input{ width:240px; border:1px solid #e1e1e1; height:24px; line-height:24px; padding-left:5px;}
.xqahs .essinfor_bottom ul li{*margin-top:10px;}
.xqahs .essinfor_bottom ul li{ line-height:18px;}
</style>

<div class="topbaad">
<div class="user-main clearfix">
	<?php
	$this->assign('menuid',0);
	?>
	<div class="ter_tit">
	当前位置 > 个人信息 > 基本信息
	</div>
	<div class="lefrig" style="background:#fff;<?=(empty($room['iscollege'])||$user['groupid']!=6)?'border:solid 1px #cdcdcd;':''?>margin-top:15px;">
	
	<?php
	$this->assign('type','setting');
	$this->display('home/simplate_menu');
	?>
		<div class="clear"></div>
		<div class="card-body">
			<div class="essinfor">
		        <div class="jizl">
		            <div class="essinfor_top">
		                <div class="title fl"><h3>基本资料</h3></div>
		                <div class="bianjis fr"><a href="javascript:;" id="btn_edit" class="hrelh" onclick="editinfo()">[修改]</a></div>
		            </div>
		            <div class="clear"></div>
		            <div class="essinfor_bottom">
		                <ul>
							<li class="fl">
								<span class="span1">姓　　名：</span><span id="cnname_span" class="span2"><?=$memberdetail['realname'] ?></span><input type="text" style="display:none;" value="<?=$memberdetail['realname']?>" id="cnname" maxlength="18"/>
							</li>
							<li class="fl">
								<span class="span1">性　　别：</span><span id="sex_span" class="span2"><?= $memberdetail['sex'] == 1 ? '女' : '男' ?></span>
								<span id="sex" style="display:none;">
									<label>
										<input type="radio" value="0" name="sex" <?php if($memberdetail['sex'] == 0) echo 'checked="checked";'?> style="width:16px; position:relative;top:7px;*top:2px; border:none;" /><span class="span2">男</span>
									</label>&nbsp;
									<label>
										<input type="radio" value="1" name="sex" <?php if($memberdetail['sex'] == 1) echo 'checked="checked";'?> style="width:16px; position:relative;top:7px;*top:2px; border:none;" /><span class="span2">女</span>
									</label>
								</span>
							</li>
							<li class="fl"><span class="span1">昵　　称：</span><span id="nickname_span" class="span2"><?=$memberdetail['nickname'] ?></span><input type="text" style="display:none;" value="<?=$memberdetail['nickname']?>" id="nickname" maxlength="20"/></li>
		                    <li class="fl"><span class="span1">出生日期：</span><span  id="birthdate_span" class="span2"><?=$memberdetail['birthdate']?Date('Y-m-d',$memberdetail['birthdate']):''?></span><input id="birthdate" class="Wdate" style="display:none" type="text" value="<?=$memberdetail['birthdate']?Date('Y-m-d',$memberdetail['birthdate']):'1991-01-01'?>" onClick="WdatePicker()"></li>
							<li class="fl">
								<span class="span1">手机号码：</span><span id="mobile_span" class="span2"><?=$memberdetail['mobile']?></span><input type="text" style="display:none;" id="mobile" value="<?= $memberdetail['mobile'] ?>" />
							</li>
							<li class="fl">
								<span class="span1">电话号码：</span><span id="phone_span" class="span2"><?=$memberdetail['phone']?></span><input type="text" style="display:none;" id="phone" value="<?= $memberdetail['phone'] ?>" />
							</li>
							<li class="fl"><span class="span1">Q　　 Q：</span><span id="qq_span" class="span2"><?=$memberdetail['qq']?></span><input type="text" style="display:none;" id="qq" value="<?= $memberdetail['qq'] ?>" /></li>
							<li class="fl"><span class="span1">微信账号：</span><span id="msn_span" class="span2"><?=$memberdetail['msn']?></span><input type="text" style="display:none;" id="msn" value="<?= $memberdetail['msn'] ?>" /></li>
							<li class="fl"><span class="span1">联系邮箱：</span><span id="email_span" class="span2"><?=$memberdetail['email']?></span><input type="text" style="display:none;" id="email" value="<?= $memberdetail['email'] ?>" /></li>
							<li class="fl" style="width:715px;">
								<span class="span1" style="float:left;">现居住地：<input type="hidden" id="old_citycode" value="<?=$memberdetail['citycode']?>" /></span>
								<div>
									<span class="span2" id="citycode_span">
									<?php
									if(!empty($memberdetail['citycode']))
									{
									$this->widget('cities_widget',array('citycode'=>$memberdetail['citycode'],'getText'=>1,'tag'=>'zzz2'));
									}
									?>
									</span>
									<span class="span2" id="address_span"><?=$memberdetail['address']?></span>
									<div style="display:none;float:left;" id="citycode">
									<?php
									$this->widget('cities_widget',array('citycode'=>$memberdetail['citycode'],'tag'=>'zzz1'));
									?>
									</div>
								</div>
							</li>
							<li class="fl mt5" style="display:none;width:726px;" id="address_li">
								<span class="span1" id="address_title" style="float:left;">详细地址：</span>
								<div style="width:656px;float:left;">
									<textarea id="address" style="resize:none;width:605px; height:40px; border:1px solid #e1e1e1;"><?=$memberdetail['address']?></textarea>
								</div>
							</li>
							<li class="fl mt5" style="width:726px;">
								<span class="span1" style="float:left;">个人简介：</span>
								<div style="width:627px;float:left;">
									<span id="profile_span" class="span2" style="width:627px;"><?=$memberdetail['profile']?></span>
									<textarea id="profile" style="resize:none;display:none;width:605px; height:100px;border:1px solid #e1e1e1;"><?=$memberdetail['profile']?></textarea>
								</div>
							</li>
		                    <li class="fl mt10"><span class="span1">家长姓名：</span><span id="familyname_span" class="span2"><?=$memberdetail['familyname']?></span><input type="text" style="display:none;" id="familyname" value="<?= $memberdetail['familyname'] ?>" /></li>
		                    <li class="fl mt10"><span class="span1">家长电话：</span><span id="familyphone_span" class="span2"><?=$memberdetail['familyphone']?></span><input type="text" style="display:none;" id="familyphone" value="<?= $memberdetail['familyphone'] ?>" /></li>
		                    <li class="fl"><span class="span1">家长职业：</span><span id="familyjob_span" class="span2"><?=$memberdetail['familyjob']?></span><input type="text" style="display:none;" id="familyjob" value="<?= $memberdetail['familyjob'] ?>" /></li>
		                    <li class="fl"><span class="span1">家长邮箱：</span><span id="familyemail_span" class="span2"><?=$memberdetail['familyemail']?></span><input type="text" style="display:none;" id="familyemail" value="<?= $memberdetail['familyemail'] ?>" /></li>
		                </ul>
		            </div>
					<div class="fkrer" style="display:none" id="btn_info">
						<a href="javascript:;" class="huibtn" onclick="cancelinfo()" style="background:#eee;color:#000;margin-right:10px;">取 消</a>
						<a href="javascript:;" class="lanbtn" onclick="saveinfo()">保 存</a>
					</div>
		        </div>
		        <div class="clear"></div>
		        <div class="xqahs mt40">
		            <div class="essinfor_top">
		                <div class="title fl"><h3>兴趣爱好</h3></div>
		                <div class="bianjis fr"><a href="javascript:;" id="interest_edit" class="hrelh">[修改]</a></div>
		            </div>
		            <div class="clear"></div>
		            <div class="essinfor_bottom mt10">
		                <ul>
							<li class="fl mt10" style="width:715px; ">
								<span class="span1" style="float:left">兴趣爱好：</span>
								<div style="width:645px;float:left;">
									<span id="hobbies_span" class="span2" style="width:645px;"><?=shortstr($memberdetail['hobbies'],20)?></span>
									<textarea id="hobbies" maxlength="200" style="resize:none;display:none;width:623px;height:30px;border:1px solid #e1e1e1;"><?=$memberdetail['hobbies']?></textarea>
								</div>
							</li>
							<li class="fl mt10" style="width:715px; ">
								<span class="span1" style="float:left">喜欢音乐：</span>
								<div style="width:645px;float:left;">
									<span id="lovemusic_span" class="span2" style="width:645px;"><?=$memberdetail['lovemusic']?></span>
									<textarea id="lovemusic" maxlength="200" style="resize:none;display:none;width:623px;height:30px;border:1px solid #e1e1e1;"><?=$memberdetail['lovemusic']?></textarea>
								</div>
							</li>
							<li class="fl mt10" style="width:715px;">
								<span class="span1" style="float:left">喜欢电影：</span>
								<div style="width:645px;float:left;">
									<span id="lovemovies_span" class="span2" style="width:645px;"><?=$memberdetail['lovemovies']?></span>
									<textarea id="lovemovies" maxlength="200" style="resize:none;display:none;width:623px;height:30px;border:1px solid #e1e1e1;"><?=$memberdetail['lovemovies']?></textarea>
								</div>
							</li>
							<li class="fl mt10" style="width:715px; ">
								<span class="span1" style="float:left">玩的游戏：</span>
								<div style="width:645px;float:left;">
									<span id="lovegames_span" class="span2" style="width:645px;"><?=$memberdetail['lovegames']?></span>
									<textarea id="lovegames" maxlength="200" style="resize:none;display:none;width:623px;height:30px;border:1px solid #e1e1e1;"><?=$memberdetail['lovegames']?></textarea>
								</div>
							</li>
							<li class="fl mt10" style="width:715px;">
								<span class="span1" style="float:left">喜欢动漫：</span>
								<div style="width:645px;float:left;">
									<span id="lovecomics_span" class="span2" style="width:645px;"><?=$memberdetail['lovecomics']?></span>
									<textarea id="lovecomics" maxlength="200" style="resize:none;display:none;width:623px;height:30px;border:1px solid #e1e1e1;"><?=$memberdetail['lovecomics']?></textarea>
								</div>
							</li>
							<li class="fl mt10" style="width:715px; ">
								<span class="span1" style="float:left">玩的运动：</span>
								<div style="width:645px;float:left;">
									<span id="lovesports_span" class="span2" style="width:645px;"><?=$memberdetail['lovesports']?></span>
									<textarea id="lovesports" maxlength="200" style="resize:none;display:none;width:623px;height:30px;border:1px solid #e1e1e1;"><?=$memberdetail['lovesports']?></textarea>
								</div>
							</li>
							<li class="fl mt10" style="width:715px; ">
								<span class="span1" style="float:left">喜欢书籍：</span>
								<div style="width:645px;float:left;">
									<span id="lovebooks_span" class="span2" style="width:645px;"><?=$memberdetail['lovebooks']?></span>
									<textarea id="lovebooks" maxlength="200" style="resize:none;display:none;width:623px;height:30px;border:1px solid #e1e1e1;"><?=$memberdetail['lovebooks']?></textarea>
								</div>
							</li>
		                </ul>
		            </div>
					<div class="fkrer" style="display:none" id="interest_info">
						<a href="javascript:;" class="huibtn" id="interest_cancel" style="background:#eee;color:#000;margin-right:10px;">取 消</a>
						<a href="javascript:;" class="lanbtn" id="interest_save">保 存</a>
					</div>
		        </div>
		        <div class="clear"></div>
		        <div class="jinglis mt30">
		            <div class="essinfor_tops">
		                <div class="title fl"><h3>过往经历</h3></div>
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
<script type="text/javascript">	
var fields = new Array('cnname', 'sex', 'nickname', 'birthdate', 'mobile', 'phone', 'qq', 'msn', 'email', 'citycode', 'address', 'profile', 'familyname', 'familyphone', 'familyjob', 'familyemail');
var fields2 = new Array('hobbies', 'lovemusic', 'lovemovies', 'lovegames', 'lovecomics', 'lovesports', 'lovebooks');
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
		else {
			$("#"+id).val(span);
		}

		//显示输入框
		if(id == "address")
		{
			$("#address_span").hide();
			$("#address_li").show();
		}
		else if(id != 'cnname' || span == '') {//except this (id==cnname && span!='')
			$("#"+id+"_span").hide();
			$("#"+id).show();
		}
	}
	//显示隐藏按钮，重设窗口高
	
	$("#btn_info").show();
	$("#btn_edit").hide();
	window.parent.resetmain();
}

function cancelinfo() {
	var id;
	for(var i = 0; i < fields.length; i++) {
		id = fields[i];
		$("#"+id+"_span").show();
		if(id == "address")
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
	window.parent.resetmain();
	
}

function saveinfo() {
	var id;
	var value;
	var data = {};
	for(var i = 0; i < fields.length; i++) {
		id = fields[i];
		value = $("#"+id).val();
		if(id=='cnname') {
			var oldcnname = $("#cnname_span").html();
			if(oldcnname != '') {
				value = '';	
			}
		}
		else if(id=='sex'){
			value = $("input[name='sex']:checked").val() ;
		}
		if(id=='citycode'){
		
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
					alert("请输入正确的地址！不超过100个字!");
					$("#address").focus();
					return false;
				}
			}
		}
		if(id!='profile'){
			value = value.replace(/"|'/gm, '');
		}

		if(id=='mobile'){
			var mv = $("#mobile").val();
			var reg = /^1\d{10}$/; 
			if(mv!='' && !reg.test(mv)){
				alert("请输入正确的手机号码！");
				$("#mobile").focus();
				return false;
			}	
		}
		if(id == 'phone'){
			var phone = $("#phone").val();
			var pattern =/^\d{3,4}-\d{7,8}$/; 
			if(phone!='' && !pattern.test(phone)){
				alert("请输入正确的电话号码！格式为:区号-号码。");
				$("#phone").focus();
				return false;
			}
		}
		if(id == 'qq'){
			var qq = $("#qq").val();
			var pattern = /^[1-9]*[1-9][0-9]*$/;
			if(qq!='' && !pattern.test(qq)){
				alert("请输入正确的QQ号码！");
				$("#qq").focus();
				return false;
			}
		}
		if(id == 'email'||id=='familyemail'){
			var email = $("#"+id).val();
			var pattern =/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/;
			if(email!='' && !pattern.test(email)){
				alert("请输入正确的邮箱！");
				$("#"+id).focus();
				return false;
			}
		}
		if(id == 'msn'){
			var msn = $("#msn").val();
			var pattern =/^\w{5,}$/; 
			if(msn!='' && !pattern.test(msn)){
				alert("请输入正确的微信号！");
				$("#msn").focus();
				return false;
			}
		}
		if(id == 'profile'){
			var profile = $("#profile").val();
			if (profile != "") {
				if (profile.length>250) {
					alert("请输入0-250个字符!");
					$("#profile").focus();
					return false;
				}
			}
		}
		if(id=='familyphone'){
			var mv = $("#familyphone").val();
			var reg = /^[\s\-\d]{0,20}$/; 
			if(mv!='' && !reg.test(mv)){
				alert("请输入正确的电话号码！");
				$("#familyphone").focus();
				return false;
			}	
		}
		
		data[id] = value;
	}
	
	//ajax save
	$.ajax({
		url:"<?=geturl('home/profile/editmember')?>",
		type:'post',
		data:{'data':data},
		dataType:'json',
		success:function(data){
			if(data.code==1){
				for(var i = 0; i < fields.length; i++) {
					id = fields[i];
					$("#"+id+"_span").show();
					if(id=='address')
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
					else if(id != 'cnname' || data.value['cnname'] != '')
					{
						$("#"+id+"_span").html(data.value[id]);
					}
				}
				
				//显示隐藏按钮
				$("#btn_edit").show();
				$("#btn_info").hide();
				window.parent.resetmain();
				
				$.showmessage({
					img : 'success',
					message:data.message,
					title:'基本资料'
				});
							
			}
			else
			{
				$.showmessage({
					img : 'error',
					message:data.message,
					title:'基本资料'
				});
			}
		}
	});
}

</script>

<script type="text/javascript">
$(function(){
	//编辑兴趣爱好
	$("#interest_edit").click(function(){
		var span;
		var id;
		for(var i = 0; i < fields2.length; i++) {
			id = fields2[i];
			span = $("#"+id+"_span").html();
			if(id != 'cnname' || span == '') {//except this (id==cnname && span!='')
				$("#"+id).val(span);
				$("#"+id+"_span").hide();
				$("#"+id).show();
			}
		}
		//显示隐藏按钮，重设窗口高
		$("#interest_info").show();
		$("#interest_edit").hide();
		window.parent.resetmain();
	});

	//取消编辑兴趣爱好
	$("#interest_cancel").click(function(){
		var id;
		for(var i = 0; i < fields2.length; i++) {
			id = fields2[i];
			$("#"+id+"_span").show();
			$("#"+id).hide();
		}
		//显示隐藏按钮，重设窗口高
		$("#interest_edit").show();
		$("#interest_info").hide();
		window.parent.resetmain();
	});

	//保存兴趣爱好
	$("#interest_save").click(function(){
		var id;
		var value;
		var data = {};
		for(var i = 0; i < fields2.length; i++) {
			id = fields2[i];
			value = $("#"+id).val();
			value = value.replace(/"|'/gm, '');

			if (value.length>200) {
				alert("请输入0-200个字符!");
				$("#"+id).focus();
				return false;
			}
			data[id] = value;
		}

		//ajax save
		$.ajax({
			url:"<?=geturl('home/profile/editmember')?>",
			type:'post',
			data:{'data':data},
			dataType:'json',
			success:function(data){
				if(data.code==1){
					for(var i = 0; i < fields2.length; i++) {
						id = fields2[i];
						$("#"+id+"_span").show();
						$("#"+id).hide();
						$("#"+id+"_span").html(data.value[id]);
					}

					//显示隐藏按钮
					$("#interest_edit").show();
					$("#interest_info").hide();
					window.parent.resetmain();

					$.showmessage({
						img : 'success',
						message:data.message,
						title:'兴趣爱爱好'
					});

				}
				else
				{
					$.showmessage({
						img : 'error',
						message:data.message,
						title:'兴趣爱好'
					});
				}
			}
		});
	});

	//添加过往经历
	$("#expadd_add").click(function(){
		$("#expadd_add").hide();
		$("#expadd_div").show();
		//重置输入
		$("#expadd_div .begindate").val("");
		$("#expadd_div .enddate").val("");
		$("#expadd_div textarea").val("");
		window.parent.resetmain();
	});
	$("#expadd_cancel").click(function(){
		$("#expadd_div").hide();
		$("#expadd_add").show();
		window.parent.resetmain();
	});
	$("#expadd_save").click(function(){
		var begindate = $("#expadd_div .begindate").val();
		var enddate = $("#expadd_div .enddate").val();
		var description = $("#expadd_div textarea").val();
		if (begindate != "") {
			if (begindate.length>20) {
				alert("请正确填写开始时间!");
				$("#expadd_div .begindate").focus();
				return false;
			}
		}
		else
		{
			alert("请填写开始时间!");
			$("#expadd_div .begindate").focus();
			return false;
		}
		if (enddate != "") {
			if (enddate.length>20) {
				alert("请正确填写结束时间!");
				$("#expadd_div .enddate").focus();
				return false;
			}
		}
		else
		{
			alert("请填写结束时间!");
			$("#expadd_div .enddate").focus();
			return false;
		}
		if (description != "") {
			if (description.length>200) {
				alert("请正确描述过往经历，不能超过200个字!");
				$("#expadd_div textarea").focus();
				return false;
			}
		}
		else
		{
			alert("请填写过往经历描述!");
			$("#"+exp_li+" textarea").focus();
			return false;
		}

		$.ajax({
			type: "POST",
			url: "<?=geturl('home/profile/addexperience')?>",
			data: {begindate:begindate, enddate:enddate, description:description},
			dataType: "json",
			success: function(data){
				if(data.code==1){
					//增加li
					$("#explist").prepend('<li class="essinfor_bottoms mt15" id="exp_'+data.expid+'"><div class="expshow"><div class="action fr"><span class="icons edit">编辑</span><span class="icons remove">删除</span></div><div class="date"><span class="oldbegindate">'+begindate+'</span> — <span class="oldenddate">'+enddate+'</span></div><div><p class="olddescription">'+description+'</p></div></div></li>');
					$("#expadd_div").hide();
					$("#expadd_add").show();
					window.parent.resetmain();

					$.showmessage({
						img : 'success',
						message:data.message,
						title:'过往经历'
					});
				}
				else
				{
					$.showmessage({
						img : 'error',
						message:data.message,
						title:'过往经历'
					});
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
		window.parent.resetmain();
	});

	//删除经历
	$("#explist").delegate(".remove", 'click', function(){
		var exp_li = $(this).closest('li').attr("id");
		var expid = exp_li.substr(4);

		$.confirm("您确定要删除该经历吗？", function() {
			$.ajax({
				type: 'POST',
				url: "<?=geturl('home/profile/delexperience')?>",
				data: {expid:expid},
				dataType: 'json',
				success: function(data){
					if(data.code==1){
						$("#"+exp_li).remove();
						window.parent.resetmain();

						$.showmessage({
							img : 'success',
							message:data.message,
							title:'过往经历'
						});
					}
					else
					{
						$.showmessage({
							img : 'error',
							message:data.message,
							title:'过往经历'
						});
					}
				}
			});
		});

	});

	//取消编辑
	$("#explist").delegate(".huibtn", 'click', function(){
		var exp_li = $(this).closest('li').attr("id");
		$("#"+exp_li).children(".expshow").show();
		$("#"+exp_li).children(".expedit").remove();
		$("#"+exp_li).find(".action").hide();
		window.parent.resetmain();
	});

	//保存编辑
	$("#explist").delegate(".lanbtn", 'click', function(){
		var exp_li = $(this).closest('li').attr("id");
		var begindate = $("#"+exp_li).find(".begindate").val();
		var enddate = $("#"+exp_li).find(".enddate").val();
		var description = $("#"+exp_li).find("textarea").val();
		var expid = exp_li.substr(4);

		if (begindate != "") {
			if (begindate.length>20) {
				alert("请正确填写开始时间!");
				$("#"+exp_li+" .begindate").focus();
				return false;
			};
		}
		else
		{
			alert("请填写开始时间!");
			$("#"+exp_li+" .begindate").focus();
			return false;
		}
		if (enddate != "") {
			if (enddate.length>20) {
				alert("请正确填写结束时间!");
				$("#"+exp_li+" .enddate").focus();
				return false;
			};
		}
		else
		{
			alert("请填写结束时间!");
			$("#"+exp_li+" .enddate").focus();
			return false;
		}
		if (description != "") {
			if (description.length>200) {
				alert("请正确描述过往经历，不能超过200个字!");
				$("#"+exp_li+" textarea").focus();
				return false;
			}
		}
		else
		{
			alert("请填写过往经历描述!");
			$("#"+exp_li+" textarea").focus();
			return false;
		}

		$.ajax({
			type: "POST",
			url: "<?=geturl('home/profile/editexperience')?>",
			data: {expid:expid, begindate:begindate, enddate:enddate, description:description},
			dataType: "json",
			success: function(data){
				if(data.code==1){
					$("#"+exp_li).find(".oldbegindate").html(begindate);
					$("#"+exp_li).find(".oldenddate").html(enddate);
					$("#"+exp_li).find(".olddescription").html(description);
					$("#"+exp_li).children(".expshow").show();
					$("#"+exp_li).children(".expedit").remove();
					$("#"+exp_li).find(".action").hide();
					window.parent.resetmain();

					$.showmessage({
						img : 'success',
						message:data.message,
						title:'过往经历'
					});
				}
				else
				{
					$.showmessage({
						img : 'error',
						message:data.message,
						title:'过往经历'
					});
				}
			}
		});
	});

});
</script>
</body>
</html>