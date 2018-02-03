<?php
/**
 * 获取用户名模块
 * Created by PhpStorm.
 * User: ycq
 * Date: 2016/10/12
 * Time: 10:16
 */
if (!empty($setting)) { ?>
    <a class="yuasntr" href="javascript:;" id="getusername"><span class="dsirts">点击获取用户名</span></a>
    <p class="grysre">可输入自己的姓名查询是否获得网校用户名</p>
    <?php return;
} ?>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/citytpl/stores/css/wxind.css" />
<div class="plate-module md-obtain" style="<?php if (empty($varpool['float'])) { ?>position:absolute;top:<?=$varpool['top']?>px;left:<?=$varpool['left']?>px;<?php } else { ?>margin-top:<?=$varpool['margin_top']?>px;<?php } ?>width:<?=$varpool['width']?>px;height:<?=$varpool['height']?>px">
    <h2 class="titsign"><?=htmlspecialchars($varpool['ititle'], ENT_NOQUOTES)?></h2>
    <a class="yuasntr" href="javascript:;" id="getusername"><span class="dsirts">点击获取用户名</span></a>
    <p class="grysre">可输入自己的姓名查询是否获得网校用户名</p>
</div>


<div id="dialogdetail" style="display:none;">
    <div style="width:665px;text-align:left">
        <div class="yhcxxtf">
            <div class="yhcxxt">
                <div>
                    <div class="tishi"><span style="color:#ff0000;">*</span>如果你已经取得账号并且修改过密码，那么用你的账号及你的密码<a id="login_btn" href="javascript:;" style="color:#ff0000;">登录</a>或者<a href="/forget.html" style="color:#ff0000;">取回密码</a></div>
                    <div class="chaxun">
                        <div class="szschool mt20">
                            <span class="elxian fl">所在学校：</span>
                            <select id="crname" class="fl ertyu"></select>
                        </div>
                        <div class="clear"></div>
                        <div class="names mt20">
                            <span class="elxian fl">姓名：</span>
                            <input class="ertyu ertyus" id="search_name" type="text" onchange="hided()" />
                        </div>
                        <a href="javascript:;" id="dosearch" class="chabtn">查&nbsp;询</a>
                    </div>
                </div>

                <div style="height:133px;">
                    <input id="default_password" type="hidden" />
                    <!--查询成功-->
                    <div class="cxright" style="display:none;">
                        <p class="chenggbtn">查询成功！<span id="result_realname" style="color:#ff0000;"></span>&nbsp;同学您好，</p>
                        <p class="chenggbtns"><span class="chenggbtn1">您的账号：</span><span id="result_username" style="padding:0 8px;color:#18a8f7; font-size:30px; font-family:微软雅黑;"></span>(牢记此账号用于登录学习）</p>
                        <p class="chenggbtns p1s"><span id="result_password_span" class="chenggbtn1 fl">默认密码：</span><span id="result_password" class="span1s fl" style="padding:0 8px;"></span><a id="logbtn" href="javascript:;" class="chabtns fl">立即登录</a>&nbsp;(登录后请及时修改密码）</p>
                    </div>
                    <!--查询失败-->
                    <div class="cxfalse" style="display:none;">
                        <p class="p1">查询错误！</p>
                        <p>没有您的账号信息，请核对学校及姓名，如有</p>
                        <p>问题请及时联系客服。</p>
                    </div>
                </div>

                <div class="relation">
                    <div class="relation_son">
                        <?php if($varpool['room']['domain'] == 'anhui') { ?>
                            <div class="yxdh">
                                <div class="phone fl">0556-5358377 / 5275114</div>
                                <div class="email fr">邮箱：543349578@qq.com</div>
                            </div>
                            <div class="clear"></div>
                            <div class="qq">
                                <span class="fl" style="color:#626262; display:block;">咨询:&nbsp;</span>
                                <a href="http://wpa.qq.com/msgrd?v=3&uin=543349578&site=qq&menu=yes" target="_blank" class="qqlx fl">客服01</a>
                            </div>
                        <?php } else { ?>
                            <div class="yxdh">
                                <div class="phone fl">0571-88252183 / 88252153</div>
                                <div class="email fr">ebanhui@qq.com</div>
                            </div>
                            <div class="clear"></div>
                            <div class="qq" style="width:220px">
                                <span class="fl" style="color:#626262; display:block;">咨询:&nbsp;</span>
                                <a href="http://wpa.qq.com/msgrd?v=3&uin=6488479&site=qq&menu=yes" target="_blank" class="qqlx fl">客服01</a>
                                <a href="http://wpa.qq.com/msgrd?v=3&uin=15335667&site=qq&menu=yes" target="_blank" class="qqlx fr">客服02</a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript">
    var infoUrl = "<?=geturl('getusername/getinfo')?>";
    (function($) {
        $("#getusername").bind('click', function() {
            //初始化学校列表
            $.getJSON(infoUrl, function(data) {
                if (data != undefined && data.crlist != undefined && data.defaultpass != undefined) {
                    var htmlFrag = [];
                    $.each(data.crlist, function(i, n){
                        htmlFrag.push('<option value="' + n + '">' + n + '</option>');
                    });
                    $("#crname").html(htmlFrag.join(''));
                }
            }, 'json');
            $("#crname").bind('change', function() {
                $('.cxright').css('display','none');
                $('.cxfalse').css('display','none');
            });
            //查找用户名
            $("#dosearch").bind('click', function() {
                var crname = $('#crname').val();
                var search_name = $('#search_name').val();
                var defaultpass = $("#default_password").val();
                $.ajax({
                    url:'/getusername.html',
                    type:'post',
                    data:{'crname':crname,'realname':search_name},
                    success:function(data){
                        if(data != undefined && data == 0){
                            $('.cxright').css('display','none');
                            $('.cxfalse').css('display','block');
                        }else{
                            res = eval('('+(data)+')');
                            $('.cxfalse').css('display','none');
                            $('.cxright').css('display','block');
                            $('#result_username').html(res.username);
                            $('#result_realname').html(res.realname);
                            if(res.password){
                                $('#result_password_span').html('您的密码：');
                                $('#result_password').html(res.password);
                            }
                            else{
                                $('#result_password_span').html('默认密码：');
                                $('#result_password').html(defaultpass);
                            }
                        }
                    }
                });
            });
            //打开查找用户名对话框
            var d = new dialog({
                id:'search-student',
                title:"用户名查询系统",
                content: $("#dialogdetail"),
                fixed:true,
                onshow:function(){
                    /*var i=$('<span style="font-size:12px;color:#999;">（请务必正确选择，否则将影响后续正常学习）</span>');
                    $(this.node).find(".ui-dialog2-title").append(i);
                    $(this.node).find('.ui-dialog2-content').bind('click', function(e) {
                        var target = $(e.target);
                        if (!target.hasClass('directsbj')) {
                            return;
                        }
                        $(this).find('a.onhover').removeClass('onhover');
                        target.addClass('onhover');
                    });*/
                },
                padding:0
            });
            d.showModal();
            //立即登录
            $("#login_btn").bind('click', function() {
                d.close();
                var loginWindow = new dialog({
                    id:'login-small-window',
                    title:'用户登录',
                    fixed:true,
                    content:$("#window-login")
                });
                loginWindow.showModal();
            });

            $("#logbtn").bind('click', function() {
                d.close();
                var loginWindow = new dialog({
                    id:'login-small-window',
                    title:'用户登录',
                    fixed:true,
                    onshow:function() {
                      $("#uname").val($("#result_username").html());
                    },
                    content:$("#window-login")
                });
                loginWindow.showModal();

                return;
                var username = $("#result_username").html();
                var pwd = $("#result_password").html();
                var crname = $("#crname").val();
                $.ajax({
                    'url': '/login.html',
                    'type': 'post',
                    'data': {'loginsubmit':1,'username':username,'password':pwd},
                    'dataType': 'json',
                    'success': function(d) {
                        if (d.code == '1') {
                            //document.location.href = d.returnurl;
                            return;;
                        }
                        alert(d.message);
                    }
                });
            });
        });
    })(jQuery);
</script>