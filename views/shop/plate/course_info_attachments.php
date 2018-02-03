<div class="datadoad">
    <?php
    if (!empty($attachments)) { ?>
        <div class="datadoad" style="margin-top:25px;" >
            <?php foreach ($attachments as $attachment) { ?>
                <div class="datadoadson ">
                    <h2><?=htmlspecialchars($attachment['courseware'], ENT_NOQUOTES)?></h2>
                    <ul>
                        <?php foreach ($attachment['items'] as $item) { ?>
                            <li>
                                <p class="fl" style="font-size:14px;font-family: 微软雅黑">
                                    <i class="icont ico-<?=$item['suffix']?>"></i>
                                    <span style="float:left;width:300px;"><a href="javascript:;" class="opbtn"><?=$item['filename']?></a></span>
                                    <span style="float:left;width:200px;">　　大小：<?=$item['size_description']?>　　</span><span style="color:#999;"><?=date('Y-m-d', $item['dateline'])?></span></p>
                                <div class="clear"></div>
                            </li>
                        <?php }?>
                    </ul>
                </div>
            <?php } ?>
        </div>
        <?=$pagestr?>
        <?php return; } ?>
    <div class="nodata"></div>
