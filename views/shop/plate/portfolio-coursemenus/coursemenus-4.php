<?php
/**
 * 课程导航模块
 * Created by PhpStorm.
 * User: ycq
 * Date: 2017/5/26
 * Time: 17:24
 */
if (!empty($setting)) { ?>
    <div class="courselistdoule">
        <?php if (!empty($varpool['data']['packages'])) { ?>
            <div class="courselisttitle nav group">
                <ul class="fl allson">
                    <li><a gid="0" href="javascript:;" class="s-coursemenu courseall<?php if (0 == $varpool['data']['pid']) {
                            echo ' onhover';
                        } ?>">全部<img src="http://static.ebanhui.com/ebh/tpl/newschoolindex/images/selectedico.png" /></a></li>
                    <?php if (!empty($varpool['data']['packages'])) {
                        foreach ($varpool['data']['packages'] as $index => $package) {
                            ?>
                            <li><a gid="<?=$index?>" href="javascript:;" class="s-coursemenu courseall<?php if ($varpool['data']['pid'] == $index) {
                                    echo ' onhover';
                                } ?>"><?= htmlspecialchars($package['pname'], ENT_NOQUOTES) ?><img src="http://static.ebanhui.com/ebh/tpl/newschoolindex/images/selectedico.png" /></a></li>
                            <?php
                        }
                    } ?>
                </ul>
                <?php if (!empty($varpool['data']['sorts'])) { ?>
                    <ul class="fl allsondouble nav" id="course-nav-set">
                    <?php foreach ($varpool['data']['sorts'] as $gid => $gsort) {
                        $f = 0;
                        foreach ($gsort as $sid => $sort) { ?>
                            <li<?php if($varpool['data']['pid'] != $gid) { echo ' style="display:none;"';} ?> pid="<?=$gid?>"><a href="javascript:;" class="courseall<?php if($f++==0){echo ' onhover';}?>"><?=$sort['sname']?></a></li>
                        <?php }
                    } ?>
                    </ul>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
    <?php
    return;
}
?>
<div class="courselistdoule" style="padding-bottom:0;">
    <?php if (!empty($varpool['data']['packages'])) {  ?>
        <div class="courselisttitle group">
            <ul class="fl allson">
                <li><a href="/platform-1-0-0.html" class="courseall<?php if (0 == $varpool['data']['pid']) { echo ' onhover';} ?>">全部</a></li>
                <?php if (!empty($varpool['data']['packages'])) {
                    foreach ($varpool['data']['packages'] as $index => $package) {
                        ?>
                        <li><a href="/platform-1-0-0.html?pid=<?=$index?>" class="courseall<?php if ($varpool['data']['pid'] == $index) { echo ' onhover';} ?>"><?=htmlspecialchars($package['pname'], ENT_NOQUOTES)?></a></li>
                        <?php
                    }
                } ?>
            </ul>
            <?php if (!empty($varpool['data']['sorts'])) {
                $c = count($varpool['data']['sorts']); ?>
                <ul class="fl allsondouble" style="width:100%;">
                    <?php if ($c > 1) { ?><li><a href="/platform-1-0-0.html?pid=<?=$varpool['data']['pid']?>" class="courseall<?php if (empty($varpool['data']['sid'])) { echo ' onhover'; } ?>">全部</a></li><?php } ?>
                    <?php foreach ($varpool['data']['sorts'] as $sid => $sort) { ?>
                        <li><a href="/platform-1-0-0.html?pid=<?=$sort['pid']?>&sid=<?=$sid?>" class="courseall<?php if($c == 1){ echo ' onhover'; } ?>"><?= htmlspecialchars($sort['sname'], ENT_NOQUOTES) ?></a></li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </div>
    <?php  } ?>
</div>