<?php
/**
 * Created by PhpStorm.
 * User: app
 * Date: 2017/2/24
 * Time: 14:51
 */
$hidden_sub_menu = empty($allways_show_course_menus);
if (!empty($setting)) {
    $hidden_sub_menu = false;
}
if (!empty($setting)) { ?>
    <div id="course-type" class="course-menu-type" style="width:200px;z-index:100;position:relative;float:left;">
        <div class="dl-editBar" style="top:-25px;z-index:10">
            <input type="text" id="pick-color" /><a href="javascript:;" class="dl-remove" id="del-course-menu">移除</a>
        </div>
        <div id="nav">
            <ul id="nav_ul">
                <li class="first_li">
                    <p>全部课程</p>
                    <?php if (!empty($course_menus)) {
                        $l = count($course_menus); ?>
                        <ul id="second_mune_ul">
                            <?php foreach ($course_menus as $course_menu) { ?>
                                <li>
                                    <h3 class="nav-first"><a class="first-link" href="javascript:;"><?=htmlspecialchars(shortstr($course_menu['pname'], 18, ''), ENT_NOQUOTES)?></a></h3>
                                    <?php if (!empty($course_menu['sorts'])) { ?>
                                        <div class="wrap-nav-hot">
                                            <?php foreach ($course_menu['sorts'] as $index => $sort) { ?>
                                                <a class="link-nav-hot" href="javascript:;"><?=htmlspecialchars(shortstr($sort['sname'], 12, ''), ENT_NOQUOTES)?></a>
                                            <?php } ?>
                                        </div>
                                        <div class="first_li_three_mune">
                                            <h2 class="nav-second"><a class="second-link" href="javascript:;"><?=htmlspecialchars(shortstr($course_menu['pname'], 40, ''), ENT_NOQUOTES)?></a></h2>
                                            <?php foreach ($course_menu['sorts'] as $index => $sort) { ?>
                                                <a class="nav-third_line" href="javascript:;"><?=htmlspecialchars(shortstr($sort['sname'], 12, ''), ENT_NOQUOTES)?></a>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </li>
                            <?php }?>
                            <li class="morey">
                                <div class="fosnte"><a href="javascript:;">更多</a></div>
                            </li>
                            <?php if ($l < 5) {
                                for ($i = 0; $i < 5 - $l; $i++) { ?>
                                    <li class="empty"></li>
                                <?php }
                            } ?>
                        </ul>
                    <?php } ?>
                </li>
            </ul>
        </div>
    </div>
<?php
    return;
}

?>
<div id="course-type" style="width:200px;z-index:900;height:50px;position:relative;float:left;">
    <div id="nav" style="position:absolute;top:0;left:0;">
        <ul id="nav_ul" class="<?=!empty($menu_theme) ? $menu_theme: '' ?>">
            <li class="first_li">
                <p>全部课程</p>
                <?php if (!empty($course_menus)) {
                    $l = count($course_menus); ?>
                    <ul id="second_mune_ul"<?php if ($hidden_sub_menu) { ?> style="display:none;"<?php } ?>>
                        <?php foreach ($course_menus as $course_menu) { ?>
                            <li>
                            <h3 class="nav-first"><a class="first-link" href="/platform-1-0-0.html?pid=<?=$course_menu['pid']?>" title="<?=htmlspecialchars($course_menu['pname'], ENT_COMPAT)?>"><?=htmlspecialchars(shortstr($course_menu['pname'], 18, ''), ENT_NOQUOTES)?></a></h3>
                            <?php if (!empty($course_menu['sorts'])) { ?>
                                <div class="wrap-nav-hot">
                                <?php foreach ($course_menu['sorts'] as $index => $sort) { ?>
                                    <a class="link-nav-hot" href="/platform-1-0-0.html?pid=<?=$course_menu['pid']?>&sid=<?=$sort['sid']?>" title="<?=htmlspecialchars($sort['sname'], ENT_COMPAT)?>"><?=htmlspecialchars(shortstr($sort['sname'], 12, ''), ENT_NOQUOTES)?></a>
                                <?php } ?>
                                </div>
                                <div class="first_li_three_mune">
                                    <h2 class="nav-second"><a class="second-link" href="/platform-1-0-0.html?pid=<?=$course_menu['pid']?>" title="<?=htmlspecialchars($course_menu['pname'], ENT_COMPAT)?>"><?=htmlspecialchars(shortstr($course_menu['pname'], 40, ''), ENT_NOQUOTES)?></a></h2>
                                    <?php foreach ($course_menu['sorts'] as $index => $sort) { ?>
                                        <a class="nav-third_line" href="/platform-1-0-0.html?pid=<?=$course_menu['pid']?>&sid=<?=$sort['sid']?>" title="<?=htmlspecialchars($sort['sname'], ENT_COMPAT)?>"><?=htmlspecialchars(shortstr($sort['sname'], 12, ''), ENT_NOQUOTES)?></a>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                            </li>
                        <?php }?>
                        <li class="morey">
                            <div class="fosnte"><a href="/platform.html">更多</a></div>
                        </li>
                        <?php if ($l < 5 && !$hidden_sub_menu) {
                            for ($i = 0; $i < 5 - $l; $i++) { ?>
                                <li class="empty"></li>
                            <?php }
                        } ?>
                    </ul>
                <?php } ?>
            </li>
        </ul>
    </div>
</div>
