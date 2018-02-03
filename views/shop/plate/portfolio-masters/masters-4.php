<?php
/**
 * 名师团队
 * Created by PhpStorm.
 * User: ycq
 * Date: 2017/5/10
 * Time: 14:54
 */
if (!empty($setting)) { ?>
    <div class="team" id="master-edit">
        <div class="team_botm" id="team_botm">
            <?php if (!empty($varpool['data']['masters'])) {
                foreach ($varpool['data']['masters'] as $master) { ?>
                    <div class="team_bk item team_bk_t" tid="<?=$master['uid']?>" style="width:245px;height: 226px;border:1px solid #ccc;">
                        <a href="javascript:;">
                            <div class="team_hbj">
                                <img src="<?=getavater($master, '120_120')?>" />
                                <h3 class="team_h3"><?=htmlspecialchars(!empty($master['realname']) ? $master['realname'] : $master['username'], ENT_NOQUOTES)?></h3>
                                <p class="team_p1"><?=htmlspecialchars(shortstr($master['professionaltitle'], 28), ENT_NOQUOTES)?></p>
                            </div>
                            <p class="team_p2"><?=htmlspecialchars(shortstr($master['profile'], 52), ENT_NOQUOTES)?></p>
                        </a>
                        <a href="javascript:void(0)" class="tremove delmovet" ></a>
                    </div>
                <?php }
            }?>
            <div class="team_bk master-add-btn" id="add_team_bk" style="background: url(http://static.ebanhui.com/ebh/tpl/newschoolindex/images/addtea.jpg) center;">
            	<a href="javascript:"></a>
        </div>
    </div>
    </div>

<!--弹窗选教师!-->
<div id="masters" style="display:none">
    <div class="terles">
        <div class="terles_top">
            <ul id="master-choose">
                <?php if (!empty($varpool['data']['teachers'])) {
                    foreach ($varpool['data']['teachers'] as $teacher) {
                        if (!empty($teacher['isMaster'])) { ?>
                            <li tid="<?=$teacher['uid']?>">
                                <a class="terles_lnode" title="<?= !empty($teacher['realname']) ? $teacher['realname'] . '(' . $teacher['username'] . ')' : $teacher['username'] ?>" href="javascript:;"><?= !empty($teacher['realname']) ? shortstr($teacher['realname'], 30, '') . '(' . $teacher['username'] . ')' : shortstr($teacher['username'], 30, '') ?></a>
                                <a class="terles_labe" title="删除标签" href="javascript:;">
                                    <img src="http://static.ebanhui.com/ebh/tpl/newschoolindex/images/tstebico.png">
                                </a>
                            </li>
                        <?php }
                    }
                } ?>
            </ul>
        </div>
        <div class="terles_bot">
            <span class="setitr">教师列表</span>
            <div class="shoufe">
                <input id="teachername" class="soutxt" placeholder="请输入老师姓名或账号" name="search" type="text">
                <input class="souhuang" id="souhuang-masters" value="搜 索" name="searchbutton" type="button">
            </div>
            <div class="xianquan" id="master-all">
                <?php if (!empty($varpool['data']['teachers'])) {
                    foreach ($varpool['data']['teachers'] as $teacher) {
                        if (empty($teacher['isMaster'])) { ?>
                            <a href="javascript:;" class="lisnres " tid="<?=$teacher['uid']?>" urealname="<?=htmlspecialchars($teacher['realname'], ENT_COMPAT)?>" uname="<?=htmlspecialchars($teacher['username'], ENT_COMPAT)?>" uface="<?=getavater($teacher, '120_120')?>" uprofile="<?=htmlspecialchars(shortstr($teacher['profile'], 52), ENT_COMPAT)?>" uprofessionaltitle="<?=htmlspecialchars(shortstr($teacher['professionaltitle'],28,''), ENT_COMPAT)?>" val="<?=!empty($teacher['realname']) ? shortstr($teacher['realname'], 30, '') . '(' . $teacher['username'] . ')' : shortstr($teacher['username'], 30, '') ?>"><span
                                    class="selectico"><?=!empty($teacher['realname']) ? shortstr($teacher['realname'], 28, '') . '(' . $teacher['username'] . ')' : shortstr($teacher['username'], 30, '') ?>
                            </a>
                        <?php } else { ?>
                            <a href="javascript:;" class="lisnres onlock" tid="<?=$teacher['uid']?>" urealname="<?=htmlspecialchars($teacher['realname'], ENT_COMPAT)?>" uname="<?=htmlspecialchars($teacher['username'], ENT_COMPAT)?>" uface="<?=getavater($teacher, '120_120')?>" uprofile="<?=htmlspecialchars(shortstr($teacher['profile'], 52), ENT_COMPAT)?>" uprofessionaltitle="<?=htmlspecialchars(shortstr($teacher['professionaltitle'],28,''), ENT_COMPAT)?>" val="<?=!empty($teacher['realname']) ? shortstr($teacher['realname'], 30, '') . '(' . $teacher['username'] . ')' : shortstr($teacher['username'], 30, '') ?>"><?=!empty($teacher['realname']) ? shortstr($teacher['realname'], 30, '') . '(' . $teacher['username'] . ')' : shortstr($teacher['username'], 30, '') ?><span class="selectico"></span></a>
                        <?php }
                    }
                } ?>
            </div>
        </div>
    </div>
</div>
<?php return; } ?>
<div class="group plate-module courselist-2" style="margin-top:10px;">
    <div class="freeauditiontitle">名师团队</div>
    <div class="team">
        <div class="team_botm group">
    <?php if(!empty($varpool['data'])) {
        foreach ($varpool['data'] as $tid => $master) { ?>
            <div class="team_bk">
				<a class="defut" href="/master/<?=$tid?>.html" target="_blank"><?=htmlspecialchars(shortstr($master['profile'], 140), ENT_NOQUOTES)?></a>
                <a href="/master/<?=$tid?>.html" target="_blank">
                    <div class="team_hbj">
                        <img src="<?=getavater($master, '120_120')?>" />
                        <h3 class="team_h3"><?=htmlspecialchars(!empty($master['realname']) ? $master['realname'] : $master['username'], ENT_NOQUOTES)?></h3>
						<p class="team_p1"><?=empty($master['professionaltitle'])? '暂无职称': htmlspecialchars(shortstr($master['professionaltitle'], 30), ENT_NOQUOTES)?></p>
                    </div>
                    <p class="team_p2"><?=htmlspecialchars(shortstr($master['profile'], 56), ENT_NOQUOTES)?></p>
                </a>
            </div>
        <?php }
    } ?>
    </div>
    </div>
</div>

