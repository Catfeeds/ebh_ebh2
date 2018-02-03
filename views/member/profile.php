
<?php
$this->display('common/header');
?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/easyui/themes/default/easyui.css">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/easyui/locale/easyui-lang-zh_CN.js"></script>

<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" type="text/css" />
<style>
.lefrig .datatabsim td {
	border:none;
	border-top: 1px solid #e6e6e6;
}
.lefrig .tabheadsim th {
	border-top:none;
}
</style>
<div class="topbaad">
<div class="user-main clearfix">
	<?php
	$this->assign('menuid',0);
	$this->display('member/left');
	?>
	<div class="cright_cher">
	<div class="ter_tit">
	当前位置 > <a href="<?php echo geturl('member')?>">个人信息</a> > 基本信息
	</div>
	<div class="lefrig" style="background:#fff;border:solid 1px #cdcdcd;margin-top:15px;width:786px;float:left;">
	


<?php
$this->assign('type','setting');
$this->display('member/simplate_menu');
?>
<div style="float:left;width:786px;">
<table width="100%" class="datatabsim" style="font-size:12px;border:none;">
	<thead class="tabheadsim">
		<tr>
			<th colspan="4" class="zitis">基本资料</th>
		</tr>

		<tr>
			<td width="105" align="center">姓&nbsp;&nbsp;&nbsp;&nbsp;名</td>
			<td width="238"><span class="width175" id="cnname_span" maxlength="18"><?=$memberdetail['realname']?></span><input type="text"  class="uipt w165 spfl" style="display:none" value="<?=$memberdetail['realname']?>" id="cnname" maxlength="16"/>
			<?php if(empty($memberdetail['realname'])){ ?>
			<span class="spfl"><a href="javascript:;" style="color:#2da8cb;" onclick="upinfo('cnname','','<?=$memberdetail['realname']?>')" id="cnname_but" name="cnname_but">[修改]</a><a href="javascript:;" onclick="upinfo('cnname','cancel','')" style="color:#2da8cb;display:none;" id="cnname_cancel">[取消]</a></span>
			<?php } ?>
			</td>
			<td width="105" align="center">性&nbsp;&nbsp;&nbsp;&nbsp;别</td>
			<?php $selectsex[$memberdetail['sex']]='selected="selected"';?>
			
			<td width="244"><span class="width175"  id="sex_span"><?=$memberdetail['sex']==0?'男':'女'?></span><select id="sex" style="display:none;width:160px;"  class="uipt spfl"><option value="0" <?=!empty($selectsex[0])?$selectsex[0]:''?>>男</option><option value="1" <?=!empty($selectsex[1])?$selectsex[1]:''?>>女</option></select><span class="spfl"><a href="javascript:;" onclick="upinfo('sex','','<?=$memberdetail['sex']?>')" id="sex_but" name="sex_but" style="color:#2da8cb;">[修改]</a><a href="javascript:;" onclick="upinfo('sex','cancel','')" style="color:#2da8cb;display:none;" id="sex_cancel">[取消]</a></span></td>
		</tr>

		<tr>
			<td width="105" align="center">昵&nbsp;&nbsp;&nbsp;&nbsp;称</td>
			<td width="238"><span class="width175" id="nickname_span" maxlength="20"><?=$memberdetail['nickname']?></span><input type="text"  class="uipt w165 spfl" style="display:none" id="nickname" maxlength="20"/><span class="spfl"><a href="javascript:;" style="color:#2da8cb;" onclick="upinfo('nickname','','<?=$memberdetail['nickname']?>')" id="nickname_but" name="nickname_but">[修改]</a><a href="javascript:;" onclick="upinfo('nickname','cancel','')" style="color:#2da8cb;display:none;" id="nickname_cancel">[取消]</a></span></td>
			<td width="105" align="center">出生日期</td>
			<td width="238"><span class="width175" id="birthdate_span"><?=$memberdetail['birthdate']?Date('Y-m-d',$memberdetail['birthdate']):''?></span><div id="birthdate" style="display:none;float:left"><input id="datebox" name="birthdate" class="easyui-datebox" value="<?=$memberdetail['birthdate']?Date('Y-m-d',$memberdetail['birthdate']):'1991-01-01'?>"></div><span class="spfl"><a href="javascript:;" style="color:#2da8cb;" onclick="upinfo('birthdate','','<?=Date('Y-m-d',$memberdetail['birthdate'])?>')" id="birthdate_but" name="birthdate_but">[修改]</a><a href="javascript:;" onclick="upinfo('birthdate','cancel','')" style="color:#2da8cb;display:none;" id="birthdate_cancel">[取消]</a></span></td>
		</tr>

		<tr>
			<td height="25" colspan="4" style="border-bottom:1px solid #bbdcee;"></td>
		</tr>

		<tr>
			<th colspan="4" class="zitis">联系资料<span class="tishi">联系资料为您保密，仅供客服使用。</span></th>
		</tr>

		<tr>
			<td align="center">手机号码</td>
			<td><span class="width175" id="mobile_span" maxlength="11"><?=$memberdetail['mobile']?></span><input type="text" class="uipt w165 spfl" style="display:none;" id="mobile" value="<?=$memberdetail['mobile']?>" maxlength="11"/><span class="spfl"><a href="javascript:;" onclick="upinfo('mobile','','<?=$memberdetail['mobile']?>')" style="color:#2da8cb;" id="mobile_but">[修改]</a><a href="javascript:;" onclick="upinfo('mobile','cancel','')" style="color:#2da8cb;display:none;" id="mobile_cancel">[取消]</a></span></td>
			<td align="center">电话号码</td>
			<td><span class="width175" id="phone_span"><?=$memberdetail['phone']?></span><input type="text" class="uipt w165 spfl" style="display:none;" id="phone" value="<?=$memberdetail['phone']?>" /><span class="spfl"><a href="javascript:;" onclick="upinfo('phone','','<?=$memberdetail['phone']?>')" style="color:#2da8cb;" id="phone_but">[修改]</a><a href="javascript:;" onclick="upinfo('phone','cancel','')" style="color:#2da8cb;display:none;" id="phone_cancel">[取消]</a></span></td>
		</tr>

		<tr>
			<td align="center">qq</td>
			<td><span class="width175" id="qq_span"><?=$memberdetail['qq']?></span><input type="text" class="uipt w165 spfl" style="display:none;" id="qq" value="<?=$memberdetail['qq']?>" /> <span class="spfl"><a href="javascript:;" onclick="upinfo('qq','','<?=$memberdetail['qq']?>')" style="color:#2da8cb;" id="qq_but">[修改]</a><a href="javascript:;" onclick="upinfo('qq','cancel','')" style="color:#2da8cb;display:none;" id="qq_cancel">[取消]</a></span></td>
			<td align="center">MSN</td>
			<td><span class="width175" id="msn_span"><?=$memberdetail['msn']?></span><input type="text" class="uipt w165 spfl" style="display:none;" id="msn" value="<?=$memberdetail['msn']?>" /> <span class="spfl"><a href="javascript:;" onclick="upinfo('msn','','<?=$memberdetail['msn']?>')" style="color:#2da8cb;" id="msn_but">[修改]</a><a href="javascript:;" onclick="upinfo('msn','cancel','')" style="color:#2da8cb;display:none;" id="msn_cancel">[取消]</a></span></td>
		</tr>

		<tr>
			<td width="105" align="center">邮箱</td>
			<td colspan="3"><span class="width564" id="email_span"><?=$memberdetail['email']?></span><input class="uipt w165 spfl" type="text" style="display:none;" id="email" value="<?=$memberdetail['email']?>" /> <span class="spfl" style="float:right;width:80px;"><a href="javascript:;" onclick="upinfo('email','','<?=$memberdetail['email']?>')" style="color:#2da8cb;" id="email_but">[修改]</a><a href="javascript:;" onclick="upinfo('email','cancel','')" style="color:#2da8cb;display:none;" id="email_cancel">[取消]</a></span></td>
		</tr>

		<tr>
			<td width="105" align="center">现居地</td>
			<td colspan="3">
				<span class="width564">
				<table style="float:left;display:none;" id="citycode_div">
					<tr>
						<td id="citycode" style="border:none;float:left;padding:0px;height:auto;">
							<?php
							$this->widget('cities_widget',array('citycode'=>$memberdetail['citycode'],'tag'=>'zzz1'));
							?>
						</td>
					</tr>
				</table>
				<span style="float:left;height:26px;line-height:26px;" id="citycode_span"><?php
							$this->widget('cities_widget',array('citycode'=>$memberdetail['citycode'],'getText'=>1,'tag'=>'zzz2'));
							?></span>
				</span>
				<span class="spfl"><a href="javascript:;" onclick="upinfo('citycode','','<?=$memberdetail['citycode']?>')" style="color:#2da8cb;" id="citycode_but">[修改]</a><a href="javascript:;" onclick="upinfo('citycode','cancel')" style="color:#2da8cb;display:none;" id="citycode_cancel">[取消]</a></span>
			</td>
		</tr>

		<tr>
			<td width="105" align="center">详细地址</td>
			<td colspan="3"><span class="width564" id="address_span" style="word-wrap: break-word;"><?=$memberdetail['address']?></span><input class="uipt w541 spfl" type="text" maxlength="50" style="display:none;_width:528px;margin-right:6px;_margin-right:3px;word-wrap: break-word;" id="address" value="<?=$memberdetail['address']?>" /> <span class="spfl"><a href="javascript:;" onclick="upinfo('address','','<?=$memberdetail['address']?>')" style="color:#2da8cb;" id="address_but">[修改]</a><a href="javascript:;" onclick="upinfo('address','cancel','')" style="color:#2da8cb;display:none;" id="address_cancel">[取消]</a></span></td>
		</tr>

		<tr>
			<td align="center">个人简介</td>
			<td colspan="3">
			<span class="width564" id="profile_span" style="word-wrap: break-word;overflow: hidden;"><?=$memberdetail['profile']?></span>
			<textarea rows="5" cols="50" id="profile"  class="tarea w380" style="display:none;width:528px;word-wrap: break-word;resize:none;"><?=$memberdetail['profile']?></textarea>
			<a href="javascript:;" onclick="upinfo('profile','','')" style="color:#2da8cb;" id="profile_but">[修改]</a><a href="javascript:;" onclick="upinfo('profile','cancel','')" style="color:#2da8cb;display:none;" id="profile_cancel">[取消]</a>
			</td>
		</tr>

		<tr>
			<td height="25" colspan="4" style="border-bottom:1px solid #bbdcee;"></td>
		</tr>
		<tr>
			<th colspan="4" class="zitis">家长资料<span class="tishi">填写您最亲密的家人资料，资料为您保密，仅供客服使用。</span></th>
		</tr>

		<tr>
			<td align="center">家长姓名</td>
			<td>
				<span class="width175" id="familyname_span" maxlength="15"><?=$memberdetail['familyname']?></span>
				<input type="text" class="uipt w165 spfl" style="display:none;" id="familyname" value="<?=$memberdetail['familyname']?>" maxlength="11"/>
				<span class="spfl">
					<a href="javascript:;" onclick="upinfo('familyname','','<?=$memberdetail['familyname']?>')" style="color:#2da8cb;" id="familyname_but">[修改]</a><a href="javascript:;" onclick="upinfo('familyname','cancel','')" style="color:#2da8cb;display:none;" id="familyname_cancel">[取消]</a>
				</span>
			</td>

			<td align="center">家长电话</td>
			<td><span class="width175" id="familyphone_span" maxlength="20"><?=$memberdetail['familyphone']?></span><input type="text" class="uipt w165 spfl" style="display:none;" id="familyphone" value="<?=$memberdetail['familyphone']?>" /><span class="spfl"><a href="javascript:;" onclick="upinfo('familyphone','','<?=$memberdetail['familyphone']?>')" style="color:#2da8cb;" id="familyphone_but">[修改]</a><a href="javascript:;" onclick="upinfo('familyphone','cancel','')" style="color:#2da8cb;display:none;" id="familyphone_cancel">[取消]</a></span></td>
		</tr>
		<tr>
			<td align="center">家长职业</td>
			<td><span class="width175" id="familyjob_span" maxlength="15"><?=$memberdetail['familyjob']?></span><input type="text" class="uipt w165 spfl" style="display:none;" id="familyjob" value="$memberdetail['familyjob']" maxlength="11"/><span class="spfl"><a href="javascript:;" onclick="upinfo('familyjob','','<?=$memberdetail['familyjob']?>')" style="color:#2da8cb;" id="familyjob_but">[修改]</a><a href="javascript:;" onclick="upinfo('familyjob','cancel','')" style="color:#2da8cb;display:none;" id="familyjob_cancel">[取消]</a></span></td>
			<td align="center">家长邮箱</td>

			<td><span class="width175" id="familyemail_span" maxlength="50"><?=$memberdetail['familyemail']?></span><input type="text" class="uipt w165 spfl" style="display:none;" id="familyemail" value="<?=$memberdetail['familyemail']?>" /><span class="spfl"><a href="javascript:;" onclick="upinfo('familyemail','','<?=$memberdetail['familyemail']?>')" style="color:#2da8cb;" id="familyemail_but">[修改]</a><a href="javascript:;" onclick="upinfo('familyemail','cancel','')" style="color:#2da8cb;display:none;" id="familyemail_cancel">[取消]</a></span></td>
		</tr>
		<tr>
			<td height="25" colspan="4" style="border-bottom:1px solid #bbdcee;"></td>
		</tr>

		<tr>
			<th colspan="4" class="zitis">兴趣爱好</th>
		</tr>
		<tr>
			<td width="105" align="center">兴趣爱好</td>
			<td colspan="3"><span class="width564" id="hobbies_span" style="word-wrap: break-word;"><?=$memberdetail['hobbies']?></span><input class="uipt w541 spfl" type="text" maxlength="50" style="display:none;_width:528px;margin-right:6px;_margin-right:3px;word-wrap: break-word;" id="hobbies" value="<?=$memberdetail['hobbies']?>" /> <span class="spfl"><a href="javascript:;" onclick="upinfo('hobbies','','<?=$memberdetail['hobbies']?>')" style="color:#2da8cb;" id="hobbies_but">[修改]</a><a href="javascript:;" onclick="upinfo('hobbies','cancel','')" style="color:#2da8cb;display:none;" id="hobbies_cancel">[取消]</a></span></td>
		</tr>
		<tr>
			<td width="105" align="center">喜欢音乐</td>
			<td colspan="3"><span class="width564" id="lovemusic_span" style="word-wrap: break-word;"><?=$memberdetail['lovemusic']?></span><input class="uipt w541 spfl" type="text" maxlength="50" style="display:none;_width:528px;margin-right:6px;_margin-right:3px;word-wrap: break-word;" id="lovemusic" value="<?=$memberdetail['lovemusic']?>" /> <span class="spfl"><a href="javascript:;" onclick="upinfo('lovemusic','','<?=$memberdetail['lovemusic']?>')" style="color:#2da8cb;" id="lovemusic_but">[修改]</a><a href="javascript:;" onclick="upinfo('lovemusic','cancel','')" style="color:#2da8cb;display:none;" id="lovemusic_cancel">[取消]</a></span></td>
		</tr>
		<tr>
			<td width="105" align="center">喜欢电影</td>
			<td colspan="3"><span class="width564" id="lovemovies_span" style="word-wrap: break-word;"><?=$memberdetail['lovemovies']?></span><input class="uipt w541 spfl" type="text" maxlength="50" style="display:none;_width:528px;margin-right:6px;_margin-right:3px;word-wrap: break-word;" id="lovemovies" value="<?=$memberdetail['lovemovies']?>" /> <span class="spfl"><a href="javascript:;" onclick="upinfo('lovemovies','','<?=$memberdetail['lovemovies']?>')" style="color:#2da8cb;" id="lovemovies_but">[修改]</a><a href="javascript:;" onclick="upinfo('lovemovies','cancel','')" style="color:#2da8cb;display:none;" id="lovemovies_cancel">[取消]</a></span></td>
		</tr>
		<tr>
			<td width="105" align="center">玩的游戏</td>
			<td colspan="3"><span class="width564" id="lovegames_span" style="word-wrap: break-word;"><?=$memberdetail['lovegames']?></span><input class="uipt w541 spfl" type="text" maxlength="50" style="display:none;_width:528px;margin-right:6px;_margin-right:3px;word-wrap: break-word;" id="lovegames" value="<?=$memberdetail['lovegames']?>" /> <span class="spfl"><a href="javascript:;" onclick="upinfo('lovegames','','<?=$memberdetail['lovegames']?>')" style="color:#2da8cb;" id="lovegames_but">[修改]</a><a href="javascript:;" onclick="upinfo('lovegames','cancel','')" style="color:#2da8cb;display:none;" id="lovegames_cancel">[取消]</a></span></td>
		</tr>
		<tr>
			<td width="105" align="center">喜欢动漫</td>
			<td colspan="3"><span class="width564" id="lovecomics_span" style="word-wrap: break-word;"><?=$memberdetail['lovecomics']?></span><input class="uipt w541 spfl" type="text" maxlength="50" style="display:none;_width:528px;margin-right:6px;_margin-right:3px;word-wrap: break-word;" id="lovecomics" value="<?=$memberdetail['lovecomics']?>" /> <span class="spfl"><a href="javascript:;" onclick="upinfo('lovecomics','','<?=$memberdetail['lovecomics']?>')" style="color:#2da8cb;" id="lovecomics_but">[修改]</a><a href="javascript:;" onclick="upinfo('lovecomics','cancel','')" style="color:#2da8cb;display:none;" id="lovecomics_cancel">[取消]</a></span></td>
		</tr>
		<tr>
			<td width="105" align="center">玩的运动</td>
			<td colspan="3"><span class="width564" id="lovesports_span" style="word-wrap: break-word;"><?=$memberdetail['lovesports']?></span><input class="uipt w541 spfl" type="text" maxlength="50" style="display:none;_width:528px;margin-right:6px;_margin-right:3px;word-wrap: break-word;" id="lovesports" value="<?=$memberdetail['lovesports']?>" /> <span class="spfl"><a href="javascript:;" onclick="upinfo('lovesports','','<?=$memberdetail['lovesports']?>')" style="color:#2da8cb;" id="lovesports_but">[修改]</a><a href="javascript:;" onclick="upinfo('lovesports','cancel','')" style="color:#2da8cb;display:none;" id="lovesports_cancel">[取消]</a></span></td>
		</tr>
		<tr>
			<td width="105" align="center">喜欢书籍</td>
			<td colspan="3"><span class="width564" id="lovebooks_span" style="word-wrap: break-word;"><?=$memberdetail['lovebooks']?></span><input class="uipt w541 spfl" type="text" maxlength="50" style="display:none;_width:528px;margin-right:6px;_margin-right:3px;word-wrap: break-word;" id="lovebooks" value="<?=$memberdetail['lovebooks']?>" /> <span class="spfl"><a href="javascript:;" onclick="upinfo('lovebooks','','<?=$memberdetail['lovebooks']?>')" style="color:#2da8cb;" id="lovebooks_but">[修改]</a><a href="javascript:;" onclick="upinfo('lovebooks','cancel','')" style="color:#2da8cb;display:none;" id="lovebooks_cancel">[取消]</a></span></td>
		</tr>	
	</thead>
</table>
</div>
<div  class="clear"></div>
<style type="text/css">
.datatabsim .tabheadsim .width175 {
    float: left;
    padding-left: 5px;
    width: 155px;
}

.datatabsim .tabheadsim .width564 {
    float: left;
    padding-left: 5px;
    width: 529px;
}
.user-cont {
    float: left;
    padding-left: 10px;
    padding-top: 10px;
    width: 750px;
}
</style>
<script type="text/javascript">	

$(function(){
	$(".datebox :text").attr("readonly","readonly");
});


function upinfo(id,type,tvalue){

	var _type =$("#"+id+"_but").html();

	if(type=='cancel'){
		$("#"+id+"_span").show();
		$("#"+id+"_but").html('[修改]');
		if(id=='citycode'){
			$("#"+id+"_div").css('display',"none");
		}else if(id=='username'){
			$("#usernametip").html("6-16位以字母开头且不包含特殊字符！");
			$("#"+id).css('display',"none");
		}else{
			$("#"+id).css('display',"none");
		}
		$("#"+id).val('');
		$("#"+id+"_cancel").css('display',"none");
	}else{
		if(_type=='[修改]'){
			var span	= $("#"+id+"_span").html();
			$("#"+id).val(span);
			if(span !=''){
				if(id=='sex'){
					$("#"+id).value=span=='男'?0:1;	
				}else{
					$("#"+id).value=span;	
				}
		    }
			$("#"+id+"_but").html('[保存]');
			$("#"+id+"_span").hide();
			if(id=='citycode'){
				$("#"+id+"_div").css('display','');
				$("#"+id).css('display','');
			}else{
				$("#"+id).css('display','');
			}
			$("#"+id+"_cancel").css('display','');
			if(id=='birthdate'){
				//WdatePicker({dateFmt:'yyyy-MM-dd',maxDate:'%y-%M-%d',startDate:'1991-01-01',el:'birthdate'});
			}
		}else{
			$("#"+id+"_but").html('[修改]');
			$("#"+id+"_span").show();
			$("#"+id).css('display',"none");
			$("#"+id+"_cancel").css('display',"none");
			var value = $("#"+id).val();

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
			if(id!='profile'){
				value = replaceAll(value,'"',' ');
				value = replaceAll(value,"'",' ');
			}

			if(id=='mobile'){
				var mv = $("#mobile").val();
				var reg = /^1[3-8]{1}\d{9}$/; 
				if(mv!='' && !reg.test(mv)){
					alert("请输入正确的手机号码！");
					return false;
				}	
			}
			if(id == 'fax'){
				var fax = $("#fax").val();
				var pattern =/^(([0\+]\d{2,3}-)?(0\d{2,3})-)(\d{7,8})(-(\d{3,}))?$/; 
				if(fax!='' && !pattern.test(fax)){
					alert("请输入正确的传真号码！");
					return false;
				}
			}
			if(id == 'phone'){
				var phone = $("#phone").val();
				var pattern =/^(([0\+]\d{2,3}-)?(0\d{2,3})-)(\d{7,8})(-(\d{3,}))?$/; 
				if(phone!='' && !pattern.test(phone)){
					alert("请输入正确的电话号码！");
					return false;
				}
			}
			if(id == 'qq'){
				var qq = $("#qq").val();
				var pattern = /^[1-9]\d{4,8}$/; 
				if(qq!='' && !pattern.test(qq)){
					alert("请输入正确的QQ号码！");
					return false;
				}
			}
			if(id == 'email'||id=='familyemail'){
				var email = $("#"+id).val();
				var pattern =/^[a-zA-Z0-9_\-]{1,}@[a-zA-Z0-9_\-]{1,}\.[a-zA-Z0-9_\-.]{1,}$/; 
				if(email!='' && !pattern.test(email)){
					alert("请输入正确的邮箱！");
					return false;
				}
			}
			if(id == 'msn'){
				var msn = $("#msn").val();
				var pattern =/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/; 
				if(msn!='' && !pattern.test(msn)){
					alert("请输入正确的MSN！");
					return false;
				}
			}
			if(id == 'profile'){
				var profile = $("#profile").val();
				if (profile != "") {
					if (profile.length>250) {
						alert("请输入0-250个字符!");
						return false;
					};
				};
			}
			if(id=='familyphone'){
				var mv = $("#familyphone").val();
				var reg = /^[\s-\d]{0,20}$/; 
				if(mv!='' && !reg.test(mv)){
					alert("请输入正确的电话号码！");
					return false;
				}	
			}
			if(id=='birthdate'){
				var v = $('#datebox').datebox('getValue'); 
				var arr = v.split("-");
				var now = new Date(Date.UTC(arr[0],arr[1]-1,arr[2]));
				value = parseInt(now.getTime()/1000);
			}
			$.ajax({
				url:"<?=geturl('member/setting/editmember')?>",
				type:'post',
				data:{'name':id,'value':value},
				dataType:'json',
				success:function(data){
					if(data.code==1){
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
							$("#"+id+"_span").html(value);
						}
						else
						$("#"+id+"_span").html(data.value);
						
					}
				}
			});
		}
	}

//	alert($("#nickname_but").innerText);
}

function replaceAll(str,find,rp){
	while(true){
		if(str.indexOf(find) == -1){
			break;
		}
		str = str.replace(find,rp);
	}
	return str;
}



</script>

</div>

</div>
</div>
</div>
<?php
$this->display('common/footer');
?>