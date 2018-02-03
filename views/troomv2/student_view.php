<?php $this->display('troomv2/page_header'); ?>
<style>
    .datatab td{
        padding: 3px 7px;
    } 
</style>


<?php
if ($member['sex'] == 1) {
    $default = 'http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
} else {
    $default = 'http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
}
$face = empty($member['face']) ? $default : $member['face'];
$face = getthumb($face, '120_120');
?>
<div class="ter_tit">
    当前位置 > <a href="<?= geturl('troomv2/student') ?>">学员管理</a> > 学员基本信息
</div>
<div class="lefrig">
    <div class="user_left">
        <div class="usertx"><img width="120px" height="120px" src="<?= $face ?>" /></div>
    </div>
    <div class="user_right">
        <div class="user_info_tit">基本信息</div>
        <dl>
            <dt>登录账号：</dt>
            <dd><?= $member['username'] ?></dd>
            <dt>昵　　称：</dt>
            <dd><?= $member['realname'] ?></dd>
            <dt>真实姓名：</dt>
            <dd><?= $member['realname'] ?></dd>
            <dt>性　　别：</dt>
            <dd><?= $member['sex'] == 1 ? '女' : '男' ?></dd>
            <dt>出生日期：</dt>
            <dd><?= empty($member['birthdate'])?'':date('Y-m-d', $member['birthdate']) ?></dd>
        </dl>
        <div class="clear"></div>
        <div class="user_info_tit">联系方式</div>
        <dl>
            <dt>Q　　　Q：</dt>
            <dd><?= $member['qq'] ?></dd>
            <dt>M　 S　N：</dt>
            <dd><?= $member['msn'] ?></dd>
            <dt>所在地区：</dt>
            <dd><span id="address_span"></span></dd>
            <dt>电话号码：</dt>
            <dd><?= $member['phone'] ?></dd>
            <dt>手机号码：</dt>
            <dd><?= $member['mobile'] ?></dd>
            <dt>常用邮箱：</dt>
            <dd><?= $member['email'] ?></dd>
        </dl>
        <div class="clear"></div>
        <div class="user_info_tit"><span style="float:right; padding-right:10px;"></span>相关介绍</div>

        <dl>
            <dt>个人简介：</dt>
            <dd><?= $member['profile'] ?></dd>
        </dl>
    </div>
</div>
<div class="clear"></div>
<?php
if(!empty($member['citycode'])) { ?>
<script type="text/javascript">
    $(function() {
        var citycode = '<?= $member['citycode'] ?>';
        $.ajax({
            url: "/admin/cities/getAddrText.html",
            type: 'post',
            data: {'citycode': citycode},
            dataType: 'text',
            success: function(data) {
                $("#address_span").html(data);
            }
        });
    })

</script>
<?php } ?>
<?php $this->display('troomv2/page_footer'); ?>