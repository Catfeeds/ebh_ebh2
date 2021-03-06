<?php
/**
 * 最新报名模块
 * Created by PhpStorm.
 * User: ycq
 * Date: 2016/10/12
 * Time: 10:11
 */
if (!empty($setting)) {
    if(!empty($varpool['viewholder'])) {
        $count = !empty($varpool['data']) ? count($varpool['data']) : 0;
        $pad_len = 6 - $count;
        for ($i = 0; $i < $pad_len; $i++) {
            $varpool['data'][] = array(
                'username' => "***",
                'groupid' => 6,
                'sex' => $i % 2,
                'realname' => '***',
                'oname' => '***'
            );
        }
    }
    ?>
    <div class="latestregistrlist">
        <?php if (!empty($varpool['data'])) {
            $chunk = array_chunk($varpool['data'], 3);
            if (isset($chunk[0])) {
                $max_index = count($chunk[0]) - 1;
                ?>
                <ul class="floatleft">
                    <?php foreach ($chunk[0] as $index => $sign) { ?>
                        <li<?php if ($max_index == $index){ echo " class='last'";}?>>
                            <div class="touxiang fl">
                                <div class="headportrait"><img src="<?=getavater($sign,'50_50')?>" style="width:50px;height:50px;" /></div>
                                <div class="newheadimg"></div>
                            </div>
                            <div class="newsignup fl">
                                <p><?=half_hide_username($sign['username'])?>(<?=half_hide_name($sign['realname'])?>)</p>
                                <div class="openservice">开通<a href="javascript:;">&nbsp;<?=htmlspecialchars(shortstr($sign['oname'], 10), ENT_NOQUOTES)?>&nbsp;</a>服务</div>
                            </div>
                        </li>
                    <?php    } ?>
                </ul>
            <?php }

            if (isset($chunk[1])) {
                $max_index = count($chunk[1]) - 1;
                ?>
                <ul class="floatright">
                    <?php foreach ($chunk[1] as $index => $sign) { ?>
                        <li<?php if ($max_index == $index){ echo " class='last'";}?>>
                            <div class="touxiang fl">
                                <div class="headportrait"><img src="<?=getavater($sign,'50_50')?>" style="width:50px;height:50px;" /></div>
                                <div class="newheadimg"></div>
                            </div>
                            <div class="newsignup fl">
                                <p><?=half_hide_username($sign['username'])?>(<?=half_hide_name($sign['realname'])?>)</p>
                                <div class="openservice">开通<a href="javascript:;">&nbsp;<?=htmlspecialchars(shortstr($sign['oname'], 6), ENT_NOQUOTES)?>&nbsp;</a>服务</div>
                            </div>
                        </li>
                    <?php    } ?>
                </ul>
            <?php }
        } ?>
    </div>
    <?php return;
} ?>


<div class="plate-module latestregistr-2" style="<?php if (empty($varpool['float'])) { ?>position:absolute;top:<?=$varpool['top']?>px;left:<?=$varpool['left']?>px;<?php } else { ?>margin-top:<?=$varpool['margin_top']?>px;<?php } ?>width:<?=$varpool['width']?>px;height:<?=$varpool['height']?>px">
    <div class="latestregistrtitle">
   <?php 
    $systemsetting = Ebh::app()->room->getSystemSetting();
    $appsetting = Ebh::app()->getConfig()->load('othersetting');
    $appsetting['szlz'] = empty($appsetting['szlz'])?0:$appsetting['szlz'];
    if ($appsetting['szlz'] == $systemsetting['crid']) {
        echo '最近观看';
    } else {
        echo htmlspecialchars($varpool['ititle'], ENT_NOQUOTES);
    }
    ?>
    </div>
    <div class="latestregistrlist">
        <?php if (!empty($varpool['data'])) {
            $chunk = array_chunk($varpool['data'], 3);
            if (isset($chunk[0])) {
                $max_index = count($chunk[0]) - 1;
                ?>
                <ul class="floatleft">
                    <?php foreach ($chunk[0] as $index => $sign) { ?>
                        <li<?php if ($max_index == $index){ echo " class='last'";}?>>
                            <div class="touxiang fl">
                                <div class="headportrait"><img src="<?=getavater($sign,'50_50')?>" style="width:50px;height:50px;" /></div>
                                <div class="newheadimg"></div>
                            </div>
                            <div class="newsignup fl">
                                <p><?=half_hide_username($sign['username'])?>(<?=half_hide_name($sign['realname'])?>)</p>
                                <div class="openservice">开通<a href="javascript:;" title="<?=htmlspecialchars($sign['oname'], ENT_COMPAT)?>">&nbsp;<?=htmlspecialchars(shortstr($sign['oname'], 10), ENT_NOQUOTES)?>&nbsp;</a>服务</div>
                            </div>
                        </li>
                    <?php    } ?>
                </ul>
            <?php }

            if (isset($chunk[1])) {
                $max_index = count($chunk[1]) - 1;
                ?>
                <ul class="floatright">
                    <?php foreach ($chunk[1] as $index => $sign) { ?>
                        <li<?php if ($max_index == $index){ echo " class='last'";}?>>
                            <div class="touxiang fl">
                                <div class="headportrait"><img src="<?=getavater($sign,'50_50')?>" style="width:50px;height:50px;" /></div>
                                <div class="newheadimg"></div>
                            </div>
                            <div class="newsignup fl">
                                <p><?=half_hide_username($sign['username'])?>(<?=half_hide_name($sign['realname'])?>)</p>
                                <div class="openservice">开通<a href="javascript:;" title="<?=htmlspecialchars($sign['oname'], ENT_COMPAT)?>">&nbsp;<?=htmlspecialchars(shortstr($sign['oname'], 6), ENT_NOQUOTES)?>&nbsp;</a>服务</div>
                            </div>
                        </li>
                    <?php    } ?>
                </ul>
            <?php }
        } ?>
    </div>
</div>
