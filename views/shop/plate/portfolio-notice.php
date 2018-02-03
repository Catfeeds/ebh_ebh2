<?php
/**
 * 滚动通知模块
 * Created by PhpStorm.
 * User: ycq
 * Date: 2016/10/11
 * Time: 17:31
 */
if (!empty($setting)) { ?>
    <div class="wrap_noticeson">
		<div class="w1200">
			<div class="wrap_noticeleft">通知公告：</div>
			<div class="wrap_noticeright">
				<?php if (!empty($varpool['data'])) {
					foreach ($varpool['data'] as $item) {
						echo htmlspecialchars($item['message']);
					}
				} ?>
			</div>
		</div>
    </div>
    <?php return;
} ?>

<!--通知公告-->
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/kxbdmarquee.js"></script>

<div class="wrap_notice">
    <div class="wrap_noticeson">
		<div class="w1200">
			<div class="wrap_noticeleft">通知公告：</div>
			<div class="wrap_noticeright" id="marquee"><ul>
            <?php if (!empty($varpool['data'])) {
                foreach ($varpool['data'] as $item) { ?>
                    <li><?=htmlspecialchars($item['message'], ENT_NOQUOTES)?></li>
                <?php }
            } ?>
            </ul></div>
		</div>
    </div>
</div>
<script type="text/javascript">
    (function($) {
        $('#marquee').kxbdMarquee({
            isEqual: false
        });
    })(jQuery);
</script>