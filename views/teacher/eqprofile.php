<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/teacher.js"></script>
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/teacher.css" rel="stylesheet" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/editdata.css" rel="stylesheet" />



</head>
<style type="text/css">
.datatabsim td {
    border: 1px solid #E6E6E6;
    color: #666666;
	height:28px;
	line-height: 26px;
    _height: auto;
	_line-height:28px;
    padding: 2px;
}
.spfl{float:left;line-height: 2.2;}
 </style>

<script type="text/javascript">
$(function(){
	  
	    $("#menudiv ul").hover(function(){
			$(this).addClass("hover");
		},function(){
			$(this).removeClass("hover");
		})
	})
</script>
<body>
<div class="tmiddle" style="width:auto;">

	<div class="lefrig" style="margin:0;">
			<table width="740" class="datatabsim">
                        <thead class="tabheadsim">
                            <tr>
                                <th colspan="4" class="zitis">基本资料</th>
                            </tr>
                            <tr>
                                <td width="105" align="center">昵&nbsp;&nbsp;&nbsp;&nbsp;称</td>
                                <td width="238"><span class="width175" id="nickname_span" ><?= $teacher['nickname'] ?></span><input type="text" class="uipt w170 spfl" style="display:none" value="<?= $teacher['nickname'] ?>" id="nickname" maxlength="16"/> <span class="spfl" style="width:73px;"><a href="javascript:;" onclick="upinfo('nickname', '', '<?= $teacher['nickname'] ?>');" style="color:#2da8cb;" id="nickname_but" name="nickname_but">[修改]</a><a href="javascript:;" onclick="upinfo('nickname', 'cancel', '')" style="color:#2da8cb;display:none;" id="nickname_cancel">[取消]</a></span></td>
                                <td width="105" align="center">性&nbsp;&nbsp;&nbsp;&nbsp;别</td>
               
                                <td><span class="width175" id="sex_span"><?= $teacher['sex'] == 1 ? '女' : '男' ?></span><select id="sex" style="display:none;float:left;"><option value="0"  <?= $teacher['sex'] != 1 ? "selected='selected'" : '' ?>>男</option><option value="1" <?= $teacher['sex'] == 1 ? "selected='selected'" : '' ?>>女</option></select><span class="spfl" style="width:73px;" style="float:right;width:73px;"><a href="javascript:;" onclick="upinfo('sex', '',<?= $teacher['sex'] ?>)" id="sex_but" name="sex_but" style="color:#2da8cb;">[修改]</a><a href="javascript:;" onclick="upinfo('sex', 'cancel', '')" style="color:#2da8cb;display:none;" id="sex_cancel">[取消]</a></span></td>
                            </tr>
                            <tr>
                                <td width="105" align="center">姓&nbsp;&nbsp;&nbsp;&nbsp;名</td>
                                <td width="238"><span class="width175" id="realname_span"><?= $teacher['realname'] ?></span><input type="text"  class="uipt w170 spfl" style="display:none" value="<?= $teacher['realname'] ?>" id="realname" maxlength="16"/><span class="spfl" style="width:73px;"><a href="javascript:;" style="color:#2da8cb;" onclick="upinfo('realname', '', '<?= $teacher['realname'] ?>')" id="realname_but" name="realname_but">[修改]</a><a href="javascript:;" onclick="upinfo('realname', 'cancel', '')" style="color:#2da8cb;display:none;" id="realname_cancel">[取消]</a></span></td>
                                <td width="105" align="center">教&nbsp;&nbsp;&nbsp;&nbsp;龄</td>
                                <td><span class="width175" id="schoolage_span"><?= $teacher['schoolage'] ?></span><input type="text"  class="uipt w170 spfl" style="display:none" value="<?= $teacher['schoolage'] ?>" id="schoolage" /><span class="spfl" style="float:right;width:73px;"><a href="javascript:;" onclick="upinfo('schoolage', '', '<?= $teacher['schoolage'] ?>')" id="schoolage_but" style="color:#2da8cb;">[修改]</a><a href="javascript:;" onclick="upinfo('schoolage', 'cancel', '')" style="color:#2da8cb;display:none;" id="schoolage_cancel">[取消]</a></span></td>
                            </tr>
                            <tr>
                                <td width="105" align="center">现居地</td>
                                <td colspan="3">
                                    <span style="width:480px;" class="width564">
											
										<table style="float:left;display:none;" id="citycode_div">
											<tr>
												<td id="citycode" style="border:none;float:left;padding:0px;height:auto;">
													<?php
													$this->widget('cities_widget',array('citycode'=>$teacher['citycode']));
													?>
												</td>
											</tr>
										</table>
										<span style="float:left;height:26px;line-height:26px;" id="citycode_span"><?php
											$this->widget('cities_widget',array('citycode'=>$teacher['citycode'],'getText'=>1,'tag'=>'zzzz'));
										?></span>

                                    </span>

                                    <span style="float:right;width:73px;" class="spfl" style="width:73px;" ><a href="javascript:;" onclick="upinfo('citycode', '', '<?= $teacher['citycode'] ?>')" style="color:#2da8cb;" id="citycode_but">[修改]</a><a href="javascript:;" onclick="upinfo('citycode', 'cancel')" style="color:#2da8cb;display:none;" id="citycode_cancel">[取消]</a></span>

                                </td>

                            </tr>

                            <tr>
                                <td height="25" colspan="4"></td>
                            </tr>
                            <tr>
                                <th colspan="4" class="zitis">联系资料<span class="tishi">联系资料为您保密，仅供客服使用。</span></th>
                            </tr>
                            <tr>
                                <td align="center">手机号码</td>
                                <td><span class="width175" id="mobile_span"><?= $teacher['mobile'] ?></span><input type="text" class="uipt w170 spfl" style="display:none;" id="mobile" value="<?= $teacher['mobile'] ?>" /><span class="spfl" style="width:73px;"><a href="javascript:;" onclick="upinfo('mobile', '', '<?= $teacher['mobile'] ?>')" style="color:#2da8cb;" id="mobile_but">[修改]</a><a href="javascript:;" onclick="upinfo('mobile', 'cancel', '')" style="color:#2da8cb;display:none;" id="mobile_cancel">[取消]</a></span></td>
                                <td align="center">电话号码</td>
                                <td><span class="width175" id="phone_span"><?= $teacher['phone'] ?></span><input type="text" class="uipt w170 spfl" style="display:none;" id="phone" value="<?= $teacher['phone'] ?>" /><span class="spfl" style="float:right;width:73px;"><a href="javascript:;" onclick="upinfo('phone', '', '<?= $teacher['phone'] ?>')" style="color:#2da8cb;" id="phone_but">[修改]</a><a href="javascript:;" onclick="upinfo('phone', 'cancel', '')" style="color:#2da8cb;display:none;" id="phone_cancel">[取消]</a></span></td>
                            </tr>
                            <tr>
                                <td align="center">传真</td>
                                <td colspan="3"><span class="width175" id="fax_span"><?= $teacher['fax'] ?></span><input type="text" class="uipt w170 spfl" style="display:none;" id="fax" value="<?= $teacher['fax'] ?>" /><span class="spfl" style="width:73px;"><a href="javascript:;" onclick="upinfo('fax', '', '<?= $teacher['fax'] ?>')" style="color:#2da8cb;" id="fax_but">[修改]</a><a href="javascript:;" onclick="upinfo('fax', 'cancel', '')" style="color:#2da8cb;display:none;" id="fax_cancel">[取消]</a></span></td>
                            </tr>

                            <tr height="140">
                                <td align="center">个人简介</td>
                                <td colspan="3">
                                    <span class="width564" id="profile_span" style="word-wrap: break-word;"><?= $teacher['profile'] ?></span>
                                    <textarea rows="3" cols="50" id="profile" maxlength="200"  class="tarea w380" style="resize:none;display:none;width:500px;padding:5px;margin-top:0px;float:left;margin-right:12px;"><?= $teacher['profile'] ?></textarea>
                                    <span style="width:73px;"><a href="javascript:;" onclick="upinfo('profile', '', '')" style="color:#2da8cb;" id="profile_but">[修改]</a><a href="javascript:;" onclick="upinfo('profile', 'cancel', '')" style="color:#2da8cb;display:none;" id="profile_cancel">[取消]</a></span>
                                </td>
                            </tr>
                        </thead>
                    </table>
			<div class="fotku">
				<table width="100%">
                            <tr height="300">
                                <td width="109" align="center"><span style="color:#666;">详细介绍</span></td>
                                <td style="border:none;border-left:1px solid #E6E6E6;">
                                    <span class="width564" id='vitae_message_span' style="width:523px;padding-left:10px;height:auto;line-height:26px;padding:10px;padding-right:0px;color: #666666;word-wrap: break-word;">
                                        <?= $teacher['message'] ?>
                                    </span>
                                    <div id="vitae_message_div" style="display:none;float:left;padding-left:5px;" >
                                        <?php
                                        $editor->simpleEditor('vitae_message', '529px', '200px', $teacher['message']);
                                        ?>
                                    </div>
                                    <span style="float:left; margin-left: 8px;margin-top:14px;"><a href="javascript:;" onclick="upinfo('vitae_message', '', '')" style="color:#2da8cb;" id="vitae_message_but">[修改]</a><a href="javascript:;" onclick="upinfo('vitae_message', 'cancel', '')" style="color:#2da8cb;display:none;" id="vitae_message_cancel">[取消]</a></span>
                                </td>
                            </tr>
                        </table>
			</div>
</div>
<div class="clear"></div>
</div>
<script type="text/javascript">
                function upinfo(id, type, tvalue) {
                    var _type = $("#" + id + "_but").html();
                    if (type == 'cancel') {
                        $("#" + id + "_span").show();
                        $("#" + id + "_but").html('[修改]');
                        if (id == 'citycode' || id == 'vitae_message') {
                            $("#" + id + "_div").css('display', "none");
                        } else {
                            $("#" + id).css('display', "none");
                        }
                        $("#" + id + "_cancel").css('display', "none");
                    } else {
                        if (_type == '[修改]') {
                            var span = $("#" + id + "_span").html();
                            if (span != '') {
                                if (id == 'sex') {
                                    $("#" + id).val = span == '男' ? 0 : 1;
                                } else {
                                    $("#" + id).val = span;
                                }
                            }
                            $("#" + id + "_but").html('[保存]');
                            $("#" + id + "_span").hide();

                            if (id == 'citycode' || id == 'vitae_message') {
                                $("#"+id+"_div").css('display','');
								$("#"+id).css('display','');
                            } else {
                                $("#" + id).css('display', "");
                            }
                            $("#" + id + "_cancel").css('display', "");
                        } else {  //保存
                            $("#" + id + "_but").html('[修改]');
                            $("#" + id + "_span").show();
                            if (id == 'citycode' || id == 'vitae_message') {
                                $("#" + id + "_div").css('display', "none");
                            } else {
                                $("#" + id).css('display', "none");
                            }
                            $("#" + id + "_cancel").css('display', "none");
                            var value = $("#" + id).val();
                            if (id == 'vitae_message')
                                value = UM.getEditor('vitae_message').getContent();
                            if (id == 'citycode') {
                                var city = '';
                                var sheng = $("#address_sheng").val();
                                var shi = $("#address_shi").val();
                                var qu = $("#address_qu").val();

                                if (qu != '') {
                                    value = qu;
                                } else if (shi != '') {
                                    value = shi;
                                } else if (sheng != '') {
                                    value = sheng;
                                }
                            }
                            if (id == 'vitae_message') {
                                $.ajax({
                                    url: "<?= geturl('teacher/setting/updateinfo') ?>",
                                    type: 'post',
                                    data: {'name': id, 'rich_message': value},
                                    dataType: 'json',
                                    success: function(data) {
                                        if (data.code == 1) {
                                            //top.frames['mainFrame'].location.reload();
                                            $("#" + id + "_span").html(value);
                                        }
                                    }
                                });
                            } else {
                                if (id != 'profile') {
                                    value = replaceAll(value, '"', ' ');
                                    value = replaceAll(value, "'", ' ');
                                }
                                if (id == 'mobile') {
                                    var mv = $("#mobile").val();
                                    var reg = /^1[3-8]+\d{9}$/;
                                    if (mv != '' && !reg.test(mv)) {
                                        alert("手机号码输入不正确！");
                                        return false;
                                    }
                                }
                                if (id == 'fax') {
                                    var fax = $("#fax").val();
                                    var pattern = /^(([0\+]\d{2,3}-)?(0\d{2,3})-)(\d{7,8})(-(\d{3,}))?$/;
                                    if (fax != '' && !pattern.test(fax)) {
                                        alert("请输入正确的传真号码！");
                                        return false;
                                    }
                                }
                                if (id == 'phone') {
                                    var phone = $("#phone").val();
                                    var pattern = /^(([0\+]\d{2,3}-)?(0\d{2,3})-)(\d{7,8})(-(\d{3,}))?$/;
                                    if (phone != '' && !pattern.test(phone)) {
                                        alert("请输入正确的电话号码！");
                                        return false;
                                    }
                                }
                                if (id == 'schoolage') {
                                    var schoolage = $("#schoolage").val();
                                    var pattern = /^\d{0,2}$/;
                                    if (schoolage != '' && !pattern.test(schoolage) || schoolage > 80) {
                                        alert("请输入正确的教龄！教龄一般为0-80！");
                                        return false;
                                    }
                                }
                                if (id == 'profile') {
                                    var profile = $("#profile").val();
                                    if (profile != '' && profile.length > 200) {
                                        alert("字符限制在0-200之间!");
                                        return false;
                                    }
                                }
                                $.ajax({
                                    url: "<?= geturl('teacher/setting/updateinfo') ?>",
                                    type: 'post',
                                    data: {'name': id, 'value': value},
                                    dataType: 'json',
                                    success: function(data) {
                                        if (data.code == 1) {
                                            if(id == 'sex') {
                                                var htmlvalue = value == 1 ? '女' : '男';
                                                $("#" + id + "_span").html(htmlvalue);
                                            } else if(id == 'citycode' ) {
                                                var htmlvalue = "";
                                                var sheng = $("#address_sheng").find("option:selected").text();
                                                var shi = $("#address_shi").find("option:selected").text();
                                                var qu = $("#address_qu").find("option:selected").text();
                                                if(sheng != "" && sheng != "请选择")
                                                    htmlvalue = sheng;
                                                if(shi != "" && shi != "请选择")
                                                    htmlvalue += " " + shi;
                                                if(qu != "" && qu != "请选择")
                                                    htmlvalue += " " + qu;
                                                $("#" + id + "_span").html(htmlvalue);
                                            }else {
                                                $("#" + id + "_span").html(value);
                                            }
                                        }
                                    }
                                });
                            }

                        }
                    }

                }

                function replaceAll(str, find, rp) {
                    while (true) {
                        if (str.indexOf(find) == -1) {
                            break;
                        }
                        str = str.replace(find, rp);
                    }
                    return str;
                }

                function controlprofile() {
                    if ($("#more").text() == "收起") {
                        $("#messages").hide();
                        $("#message").hide();
                        $("#jiaimg").show();
                        $("#jianimg").hide();
                        $("#more").text("更多");
                    }
                    else
                    {
                        $("#messages").show();
                        $("#message").show();
                        $("#jiaimg").hide();
                        $("#jianimg").show();
                        $("#more").text("收起");
                    }
                }
                $(function() {
                    $.ajax({
                        url: "<?= geturl('admin/cities/getAddrText') ?>",
                        type: 'post',
                        data: {'citycode': "<?= $teacher['citycode'] ?>"},
                        dataType: 'text',
                        success: function(data) {
                            $("#address_span").html(data);
                        }
                    });
                })
            </script>
	</body>
	</html>