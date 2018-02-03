<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/editdata.css" rel="stylesheet" />
<style type="text/css">
    .spfl{float:left;line-height: 2.2;}
.tabheadsim a.hrelh {
	display: block;
    margin-right: 56px;
    background:url(http://static.ebanhui.com/ebh/tpl/2014/images/xiudty.jpg) no-repeat left center;
    color: #2796f0;
    cursor: pointer;
    float: right;
    height: 24px;
    line-height: 24px;
    text-align: center;
    text-decoration: none;
    width: 45px;
	padding-left:20px;
}
.datatabsim td {
	border:none;
}
.tabheadsim th {
	border-top:none;
}
</style>
</style>
<div class="work_mes" style=" margin-bottom:10px;">
    <?php
    $menus = array(
        array('codepath'=>'teacher/setting/rprofile','name'=>'基本信息'),
        array('codepath'=>'teacher/setting/avatar','name'=>'修改头像'),
        array('codepath'=>'teacher/setting/pass','name'=>'修改密码')
        );
    ?>
    <ul >
        <?php foreach($menus as $menu) { ?>
        <li <?= $this->uri->codepath == $menu['codepath'] ? 'class="workcurrent"':''?>><a href="<?= geturl($menu['codepath']) ?>" ><span><?= $menu['name'] ?></span></a></li>
        <?php } ?>
    </ul>
</div>



