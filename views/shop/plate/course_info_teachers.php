<div class="teacherlist">
<?php if (!empty($teachers)) {
    foreach ($teachers as $teacher) { ?>
        <div class="teacherlist_son">
            <div class="mt35">
                <div class="ttouxiang fl">
                    <img src="<?=getavater($teacher,'120_120')?>" width="120" height="120" /><span class="dengji">等级：<?=$teacher['level']?></span>
                </div>
                <div class="jieshao fl">
                    <div>
                        <div class="fl"><span class="span1s"><?=!empty($teacher['realname']) ? htmlspecialchars($teacher['realname'], ENT_NOQUOTES) : $teacher['username']?></span><span class="span2s">&nbsp;老师</span></div>
                        <div class="fl ml55 xingji">
                            <ul>
                                <li class="fl"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/pijias.png" width="18" height="18" /></li>
                                <li class="fl"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/pijias.png" width="18" height="18" /></li>
                                <li class="fl"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/pijias.png" width="18" height="18" /></li>
                                <li class="fl"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/pijias.png" width="18" height="18" /></li>
                                <li class="fl"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/pijias.png" width="18" height="18" /></li>
                            </ul>
                        </div>
                        <div class="fl ml15 xingjis"><span class="span3s">5.0</span><span class="span4s">&nbsp;分</span></div>
                    </div>
                    <div class="clear"></div>
                    <div class="qiangming" title="nb41234"><p><span>个性签名：<?=!empty($teacher['mysign']) ? htmlspecialchars($teacher['mysign'], ENT_NOQUOTES) : '暂无签名'?></span></p></div>
                    <div class="mt5">
                        <table cellpadding="0" cellspacing="0" class="tables">
                            <tr>
                                <td>讲课</td>
                                <td>总课时</td>
                                <td>布置作业</td>
                                <td>解答</td>
                                <td>评论</td>
                            </tr>
                            <tr>
                                <td><span><?=!empty($teacher['courseware_count']) ? $teacher['courseware_count'] : '0'?></span>节</td>
                                <td><span><?=!empty($teacher['courseware_length']) ? $teacher['courseware_length'] : '0'?></span>分钟</td>
                                <td><span><?=!empty($teacher['exam_count']) ? $teacher['exam_count'] : '0'?></span>份</td>
                                <td><span><?=!empty($teacher['answer_count']) ? $teacher['answer_count'] : '0'?></span>次</td>
                                <td><span><?=!empty($teacher['review_count']) ? $teacher['review_count'] : '0'?></span>次</td>
                            </tr>
                        </table>
                    </div>
                </div>

            </div>
            <div class="clear"></div>
            <div><p class="jianjies">简介：<?=$teacher['profile']?></p></div>
        </div>
    <?php } ?>
    <?=$pagestr?>
    <?php return;
} ?>
</div>
<div class="nodata"></div>
