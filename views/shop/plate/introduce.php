<?php if(true||!empty($varpool['roomdetail']['isdesign'])) { ?>
    <style type="text/css">
        .denser{margin:0 !important;}
    </style>
<?php }?>
<div class="subpage" style="margin:10px auto;">
    <div class="nseeate" style="width:1140px;min-height:800px;_height:800px">
        <div>
            <h2 class="hsrtrt"><?=$varpool['roomdetail']['crname'];?></h2>
            <p style="line-height: 2;color: #666;font-size: 16px;">
                <?= htmlspecialchars_decode($varpool['roomdetail']['summary'])?>
            </p>
            <h2 class="hsrtrt">详情介绍</h2>
            <?php if(!empty($varpool['roomdetail']['message'])){
                /* echo "<pre>";
                var_dump($varpool);die; */
                echo htmlspecialchars_decode($varpool['roomdetail']['message']);
                /* $str = str_replace('&lt;str&gt;', '', str_replace('\\"','"',$varpool['roomdetail']['message']));
                echo htmlspecialchars_decode($str); */
            }else{?>
                <div class="zwnr"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/hmyxgnr.jpg"/></div>
            <?php }?>
        </div>
        </div>
    </div>
</div>
<?php if(is_mobile()) {?>
    <script src="http://static.ebanhui.com/design/wapdesign/js/mobile.js?v=1236"></script>
    <script src="http://static.ebanhui.com/design/wapdesign/js/module.js?v=1236"></script>
     <link rel="stylesheet" href="http://static.ebanhui.com/design/wapdesign/css/common.css?version=20160614001">
    <link rel="stylesheet" href="http://static.ebanhui.com/design/wapdesign/css/module.css?version=20160614001">
<?php }?>
<script src="http://static.ebanhui.com/design/js/getroominfo.js"></script>
<script src="http://static.ebanhui.com/design/js/player.js"></script>