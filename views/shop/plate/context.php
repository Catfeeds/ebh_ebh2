<?php
if(!empty($varpool['roomdetail']['floatadimg'])) {
    $syimg = $varpool['roomdetail']['floatadimg'];
}
if (!empty($varpool['roomdetail']['floatadurl'])) {
    $syurl = $varpool['roomdetail']['floatadurl'];
}
$roominfo = Ebh::app()->room->getcurroom();
if (!empty($syimg) && $roominfo['domain'] == 'nbrazx') { ?>
<div id="edrghgh" style="position:absolute;z-index:1001;width:448px;height:149px;background:url(<?= $syimg ?>) no-repeat;background-color:#fff">
    <a class="fenstbtn" href="http://static.ebanhui.com/ebh/file/nbrazx.htm" style="display:block;width:224px;height:149px;float:left" target="_blank">
    </a>
    <a class="fenstbtn" href="http://static.ebanhui.com/ebh/file/nbrazx2.htm" style="display:block;width:224px;height:149px;float:left" target="_blank">
    </a>
    </div>
<?php } else if(!empty($syimg) && $roominfo['domain'] == 'dczz') { ?>
    <div id="edrghgh" style="position:absolute;z-index:1001;width:448px;height:149px;background:url(<?= $syimg ?>) no-repeat;background-color:#fff">
        <a class="fenstbtn" href="http://static.ebanhui.com/ebh/file/dczz.htm" style="display:block;width:224px;height:149px;float:left" target="_blank">
        </a>
        <a class="fenstbtn" href="http://static.ebanhui.com/ebh/file/dczzer.htm" style="display:block;width:224px;height:149px;float:left" target="_blank">
        </a>
    </div>
<?php } else if(!empty($syimg) && $roominfo['domain'] == 'hlsy') { ?>
    <div id="edrghgh" style="position:absolute;z-index:1001;width:448px;height:149px;background:url(<?= $syimg ?>) no-repeat;background-color:#fff">
        <a class="fenstbtn" href="http://static.ebanhui.com/ebh/file/hlsy.htm" style="display:block;width:224px;height:149px;float:left" target="_blank">
        </a>
        <a class="fenstbtn" href="http://static.ebanhui.com/ebh/file/hlsyer.htm" style="display:block;width:224px;height:149px;float:left" target="_blank">
        </a>
    </div>
<?php } else if(!empty($syimg) && $roominfo['domain'] == 'sxzx') { ?>
    <div id="edrghgh" style="position:absolute;z-index:1001;width:448px;height:149px;background:url(<?= $syimg ?>) no-repeat;background-color:#fff">
        <a class="fenstbtn" href="http://static.ebanhui.com/ebh/file/sxzx.htm" style="display:block;width:224px;height:149px;float:left" target="_blank">
        </a>
        <a class="fenstbtn" href="http://static.ebanhui.com/ebh/file/sxzxer.htm" style="display:block;width:224px;height:149px;float:left" target="_blank">
        </a>
    </div>
<?php } else if(!empty($syimg) && $roominfo['domain'] == 'nxwx') { ?>
    <div id="edrghgh" style="position:absolute;z-index:1001;width:448px;height:149px;background:url(<?= $syimg ?>) no-repeat;background-color:#fff">
        <a class="fenstbtn" href="http://static.ebanhui.com/ebh/file/nxwx.htm" style="display:block;width:224px;height:149px;float:left" target="_blank">
        </a>
        <a class="fenstbtn" href="http://static.ebanhui.com/ebh/file/nxwxer.htm" style="display:block;width:224px;height:149px;float:left" target="_blank">
        </a>
    </div>
<?php } else if(!empty($syimg) && $roominfo['domain'] == 'hlsywx') { ?>
    <div id="edrghgh" style="position:absolute;z-index:1001;width:448px;height:149px;background:url(<?= $syimg ?>) no-repeat;background-color:#fff">
        <a class="fenstbtn" href="http://static.ebanhui.com/ebh/file/hlsywx.htm" style="display:block;width:224px;height:149px;float:left" target="_blank">
        </a>
        <a class="fenstbtn" href="http://static.ebanhui.com/ebh/file/hlsywxer.htm" style="display:block;width:224px;height:149px;float:left" target="_blank">
        </a>
    </div>
<?php } else if (!empty($syurl) && !empty($syimg)) { ?>
    <div id="edrghgh" style="position:absolute;z-index:1001;width:448px;height:149px;background:url(<?= $syimg ?>) no-repeat;background-color:#fff">
        <!--链接地址-->
        <a href="<?=htmlspecialchars($syurl, ENT_COMPAT)?>" target="_blank" style="display:block;width:448px;height:149px;"></a>
    </div>
<?php } ?>
<script>
    (function($) {
        /*$(window).bind('load', function() {
            console.log($('body').height()+":"+$('body').width());
        });*/

        $.floatingAd('#edrghgh', { startX: 0, startY: 0 });
    })(jQuery);

    /*var x = 398,y = 124
    var xin = true, yin = true
    var step = 1
    var delay = 10
    var obj=document.getElementById("edrghgh")
    function floatwww_qpsh_com() {
        var L=T=0
        var R= $("body").width()-$("#edrghgh").width();
//var B = $("body").height()-$("#edrghgh").height();
        var B = 768;
//obj.style.left = x + document.body.scrollLeft
//obj.style.top = y + document.body.scrollTop
        $("#edrghgh").css("left",x+$("body").scrollLeft());
        $("#edrghgh").css("top",y+$("body").scrollTop());
        x = x + step*(xin?1:-1)
        if (x < L) { xin = true; x = L}
        if (x > R){ xin = false; x = R}
        y = y + step*(yin?1:-1)
        if (y < T) { yin = true; y = T }
        if (y > B) { yin = false; y = B }
    }
    var itl= setInterval("floatwww_qpsh_com()", delay)
    obj.onmouseover=function(){clearInterval(itl)}
    obj.onmouseout=function(){itl=setInterval("floatwww_qpsh_com()", delay)}*/
</script>
<?php
/**
 * Created by PhpStorm.
 * User: app
 * Date: 2016/11/4
 * Time: 17:11
 */
//print_r(get_defined_vars());exit;
if (empty($varpool['adjust'])) {
    ?>
    <div class="wrapmodule" style="height:<?=$varpool['content_height']?>px">
        <?php
        $room_cache = Ebh::app()->lib('Roomcache');
        if (!empty($varpool['modules'])) {
            foreach($varpool['modules'] as $module) {
                if ($module['mid'] == 20) {
                    //富文本 ?>
                    <div style="position:absolute;background-color:#fff;top:<?=$module['top']?>px;left:<?=$module['left']?>px;width:<?=$module['width']?>px;height:<?=$module['height']?>px;overflow:hidden;"><div class="richtext" style="font-size:12px;line-height:2;"><?=!empty($module['custom_data']['richtext']) ? $module['custom_data']['richtext'] : ''?></div></div>

                    <?php     continue;
                }
                $view_name = $module['show_type'] == 2 ?
                    sprintf('shop/plate/portfolio-%s/%s-%d-%d', $module['code'], $module['code'], $module['rows'], $module['columns']) :
                    sprintf('shop/plate/portfolio-%s/%s-%d', $module['code'], $module['code'], $module['columns']);
                if (!empty($module['cache'])) {
                    $htmlfragment = $room_cache->getCache($varpool['roomdetail']['crid'], $module['code'], 'view');
                    if (!empty($htmlfragment)) {
                        echo $htmlfragment;
                        continue;
                    }
                    $htmlfragment = $this->partial($view_name, false, $module);
                    $expire = !empty($module['expire']) ? intval($module['expire']) : 0;
                    $room_cache->setCache($varpool['roomdetail']['crid'], $module['code'], 'view', $htmlfragment, $expire, true);
                    echo $htmlfragment;
                    continue;
                }
                $this->partial($view_name, true, $module);
            }
        }
        ?>

    </div>
<?php }
else { ?>
    <div style="width:1200px;margin:0 auto;" class="group">
        <?php
        foreach ($varpool['modules'] as $group) {
            if (!empty($group['mid'])) {
                //单行模块
                if ($group['mid'] == 20) {
                    //富文本 ?>
                    <div class="plate-module" style="background-color:#fff;width:1200px;margin-top:10px;overflow:hidden;"><div class="richtext" style="font-size:12px;line-height:2;"><?=!empty($group['custom_data']['richtext']) ? $group['custom_data']['richtext'] : ''?></div></div>

                    <?php     continue;
                }
                $group['float'] = true;
                $group['margin_top'] = 10;
                $view_name = $group['show_type'] == 2 ?
                    sprintf('shop/plate/portfolio-%s/%s-%d-%d', $group['code'], $group['code'], $group['rows'], $group['columns']) :
                    sprintf('shop/plate/portfolio-%s/%s-%d', $group['code'], $group['code'], $group['columns']);
                $this->partial($view_name, true, $group);
                continue;
            }
            if (!empty($group['group'])) { ?>
                <div style="width:<?=$group['width']?>px;margin-top:10px;<?php if($group['width'] == 1200) { ?>margin-right:auto;margin-left:auto;<?php } ?>" class="group">




                    <?php
                    unset($group['group'], $group['width']);
                    foreach ($group as $gindex => $module) { ?>
                        <div style="float:left;width:<?=$module['width']?>px;position:relative;<?php if($gindex > 0){ ?>margin-left:20px;<?php } ?>">





                            <?php
                            if (!empty($module['group'])) {
                                $ss_width = $module['width'];
                                unset($module['width'], $module['group']);
                                foreach ($module as $ssk => $ss_module) {
                                    $sss_width = !empty($ss_module['width']) ? $ss_module['width'] : $ss_width;
                                    $height = !empty($ss_module['mid']) ? 0 : $ss_module['height'];
                                    ?>
                                    <div <?php if (!empty($ss_module['mid']) && $ss_module['mid'] == 11) { ?>class="plate-module"<?php } ?> style="position:relative;float:left;width:<?=$ss_width?>px;<?php if($ssk > 0) { ?>margin-top:10px;<?php } ?><?php if ($height > 0) { ?>height:<?=$height?>px;<?php } ?>">
                                        <?php
                                            if (!empty($ss_module['mid'])) {
                                                if ($ss_module['mid'] == 20) {
                                                    //富文本 ?>
                                                    <div class="plate-module" style="background-color:#fff;width:<?=$module['width']?>px;overflow:hidden;<?php if ($module['width'] == 285) { ?>margin-top:10px;<?php } ?>"><div class="richtext" style="font-size:12px;line-height:2;"><?=!empty($module['custom_data']['richtext']) ? $module['custom_data']['richtext'] : ''?></div></div>

                                                    <?php     continue;
                                                }
                                                $ss_module['float'] = true;
                                                $view_name = $ss_module['show_type'] == 2 ?
                                                    sprintf('shop/plate/portfolio-%s/%s-%d-%d', $ss_module['code'], $ss_module['code'], $ss_module['rows'], $ss_module['columns']) :
                                                    sprintf('shop/plate/portfolio-%s/%s-%d', $ss_module['code'], $ss_module['code'], $ss_module['columns']);
                                                $this->partial($view_name, true, $ss_module);
                                            } else {
                                                foreach ($ss_module as $ssss_module) {
                                                    if (!is_array($ssss_module)) {
                                                        continue;
                                                    }
                                                    if ($ssss_module['mid'] == 20) {
                                                        //富文本 ?>
                                                        <div class="plate-module" style="position:absolute;background-color:#fff;top:<?=$ssss_module['top']?>px;left:<?=$ssss_module['left']?>px;width:<?=$ssss_module['width']?>px;height:<?=$ssss_module['height']?>px;overflow:hidden;"><div class="richtext" style="line-height:2;font-size:12px;"><?=!empty($ssss_module['custom_data']['richtext']) ? $ssss_module['custom_data']['richtext'] : ''?></div></div>

                                                        <?php     continue;
                                                    }

                                                    $view_name = $ssss_module['show_type'] == 2 ?
                                                        sprintf('shop/plate/portfolio-%s/%s-%d-%d', $ssss_module['code'], $ssss_module['code'], $ssss_module['rows'], $ssss_module['columns']) :
                                                        sprintf('shop/plate/portfolio-%s/%s-%d', $ssss_module['code'], $ssss_module['code'], $ssss_module['columns']);
                                                    $this->partial($view_name, true, $ssss_module);
                                                }
                                            }
                                        ?>
                                    </div>
                                <?php }
                            } else {
                                if (!empty($module['mid'])) {
                                    $module['float'] = true;
                                    $view_name = $module['show_type'] == 2 ?
                                        sprintf('shop/plate/portfolio-%s/%s-%d-%d', $module['code'], $module['code'], $module['rows'], $module['columns']) :
                                        sprintf('shop/plate/portfolio-%s/%s-%d', $module['code'], $module['code'], $module['columns']);
                                    $this->partial($view_name, true, $module);
                                } else {
                                    $width = $module['width'];
                                    unset($module['width'], $module['height']);
                                    $fi = true;
                                    foreach ($module as $sk => $sub_module) {
                                        $margin_top = !$fi && $width == 285 ? 10 : 0;
                                        if ($sub_module['mid'] == 20) {
                                            //富文本 ?>
                                            <div class="plate-module" style="background-color:#fff;width:<?=$sub_module['width']?>px;overflow:hidden;<?php if($width == 285) { ?><?php } else { ?>position:absolute;top:<?=$sub_module['top']?>px;left:<?=$sub_module['left']?>px;height:<?=$sub_module['height']?>px;<?php } ?>margin-top:<?=$margin_top?>px;"><div class="richtext" style="font-size:12px;line-height:2;"><?=!empty($sub_module['custom_data']['richtext']) ? $sub_module['custom_data']['richtext'] : ''?></div></div>

                                            <?php
                                        } else {
                                            $sub_module['margin_top'] = $margin_top;
                                            if ($width == 285) {
                                                $sub_module['float'] = true;
                                            }

                                            $view_name = $sub_module['show_type'] == 2 ?
                                                sprintf('shop/plate/portfolio-%s/%s-%d-%d', $sub_module['code'], $sub_module['code'], $sub_module['rows'], $sub_module['columns']) :
                                                sprintf('shop/plate/portfolio-%s/%s-%d', $sub_module['code'], $sub_module['code'], $sub_module['columns']);
                                            $this->partial($view_name, true, $sub_module);
                                        }
                                        $fi = false;
                                    }
                                }
                            }
                            ?>







                        </div>
                    <?php }
                    ?>
















                </div>
            <?php    continue;
            }
            $height = $group['height'];
            unset($group['height']);
            ?>
            <div style="width:1200px;margin-top:10px;margin-left:auto;margin-right:auto;position:relative;height:<?=$height?>px">
                <?php foreach ($group as $module) {
                    if ($module['mid'] == 20) {
                        //富文本 ?>
                        <div class="plate-module" style="position:absolute;background-color:#fff;top:<?=$module['top']?>px;left:<?=$module['left']?>px;width:<?=$module['width']?>px;height:<?=$module['height']?>px;overflow:hidden;"><div class="richtext" style="font-size:12px;line-height:2;"><?=!empty($module['custom_data']['richtext']) ? $module['custom_data']['richtext'] : ''?></div></div>

                        <?php     continue;
                    }

                    $view_name = $module['show_type'] == 2 ?
                        sprintf('shop/plate/portfolio-%s/%s-%d-%d', $module['code'], $module['code'], $module['rows'], $module['columns']) :
                        sprintf('shop/plate/portfolio-%s/%s-%d', $module['code'], $module['code'], $module['columns']);
                    $this->partial($view_name, true, $module);
                } ?>
            </div>
        <?php }
        ?>
    </div>
<?php } ?>
