<?php $this->display('shop/plate/headernew');?>
<style>
/*跨webview需要手动指定位置*/
img.rebarimg{width:110px;height:110px;border-radius:100%;}

.xairet {line-height:1.7;margin:0 15px;text-indent:25px;overflow:hidden; text-overflow:ellipsis;display:-webkit-box; -webkit-box-orient:vertical;-webkit-line-clamp:3; }
.rigtyle{height:40px;line-height:40px;padding-left:20px;}
.rigtyle.pro{font-size:14px;color:#8f8f94;}
.mui-plus header.mui-bar {
	display: none!important;
}
.mui-plus .mui-bar-nav~.mui-content {
	padding: 0!important;
}
    span.mui-icon {
        font-size: 14px;
        color: #007aff;
        margin-left: -15px;
        padding-right: 10px;
    }
    .mui-popover {
        height: 140px;
    }
    .mui-table-view.mui-grid-view .mui-table-view-cell {
        text-align:left;
    }
    .mui-off-canvas-wrap .mui-bar-nav {
        top: 0;
        -webkit-box-shadow: 0 1px 6px #ccc;
        box-shadow: 0 1px 6px #ccc;
    }
    .mui-control-content {
        background-color: white;
        min-height: 215px;
    }
    .mui-control-content .mui-loading {
        margin-top: 50px;
    }
    .mui-bar-nav~.mui-content .mui-slider.mui-fullscreen {
        top:45px;
    }
    .mui-table-view-cell.mui-collapse .mui-table-view .mui-table-view-cell {
        padding-left: 15px;
    }
    .mui-table-view-cell.mui-collapse .mui-table-view .mui-table-view-cell:after {
        left:0px;
    }
    .mui-table-view:after {height:auto;}
    .mui-table-view-cell.mui-collapse.mui-active .mui-table-view-cell>a:not(.mui-btn).mui-active{margin-left:-31px;padding-left:31px}
    .mui-table-view .mui-media-object {max-width:70px;}
    .mui-scroll {
        z-index:10;
        padding-bottom:40px;
    }
    .mui-bar-nav~.mui-content.mui-scroll-wrapper .mui-scrollbar-vertical {top:84px;}
    .mui-table-view:before {height:0px;}
    .mui-media-body.teacher{padding:35px 0 0 0;}
</style>
<div>
	<div class="mui-table-view">
		<div class="mui-table-view-cell mui-media">
			<img id="master-photo" class="mui-pull-left rebarimg" src="<?=getavater($inner_data['master'], '120_120')?>" />
			<div class="mui-media-body teacher">
				<div id="master-name" class="mui-ellipsis rigtyle"><?=htmlspecialchars($inner_data['master']['realname'], ENT_NOQUOTES)?></div>
				<div id="master-professionaltitle" class="mui-ellipsis rigtyle pro"><?=htmlspecialchars($inner_data['master']['professionaltitle'], ENT_NOQUOTES)?></div>
			</div>
		</div>
	</div>
	<p class="xairet" id="master-profile"><?=htmlspecialchars(shortstr($inner_data['master']['profile'],360), ENT_NOQUOTES)?></p>
	<h4 style="color:#666;line-height:36px;text-indent:15px;">所授课程</h4>
    <?php if (!empty($inner_data['items'])) { ?>
	<ul class="mui-table-view mui-grid-view" id="content-panel">
        <?php foreach ($inner_data['items'] as $itemid => $item) { 
            $cannotpay = !empty($item['cannotpay']);
            $free = $item['iprice'] == 0 || !empty($inner_data['isalumni']) && $item['isschoolfree'] == 1;
            if ($free) {
                $item['iprice'] = 0;
            }
            $url = $this->format_pay_item_url($item, !empty($inner_data['userpermisions']) ? $inner_data['userpermisions'] : false);
            if (empty($item['showbysort']) || !empty($item['allow']) || !empty($item['cannotpay'])) {
                $detail_url = "/courseinfo/{$item['itemid']}.html";
                $deal_by_js = false;
            } else {
                $detail_url = $url;
                $deal_by_js = empty($url);
            }
            if (empty($item['longblockimg']) || empty($item['showaslongblock'])) {
                $showimg = $item['img'];
            } else {
                $showimg = $item['longblockimg'];
            }
            if (empty($showimg)) {
                $showimg = $this->course_viewholder;
            }
            $img = show_plate_course_cover($showimg);
            $img = show_thumb($img);

            $detail_url = !empty($item['showbysort']) ? '/room/portfolio/bundle/'.$item['sid'].'.html' : '/courseinfo/'.$item['itemid'].'.html';

        ?>
	    <li class="mui-table-view-cell mui-media mui-col-xs-6">
			<a href="<?php echo $detail_url;?>">
				<img class="mui-media-object" src="<?php echo $img;?>">
				<div class="mui-media-body" title="<?=htmlspecialchars($item['iname'], ENT_COMPAT)?>"><?=htmlspecialchars(shortstr($item['iname'], 30, ''), ENT_NOQUOTES)?></div>
				<p class="mui-ellipsis"><span class="name"<?php if(!empty($item['speaker'])) { ?> title="<?=htmlspecialchars($item['speaker'], ENT_COMPAT)?>"<?php } ?>><?=!empty($item['speaker']) ? htmlspecialchars(shortstr($item['speaker'], 18, ''), ENT_NOQUOTES) : ''?></span></p>
			</a>
		</li>
        <?php } ?>

        <ul class="item-group" style="display:none;">
                <?php if (!empty($inner_data['bundles'])) { ?>
                    <ul>
                        <?php foreach ($inner_data['bundles'] as $bundle) {
                            $btnClass = array();
                            $free = false;
                            if (empty($inner_data['szlz'])) {
                                $btnClass[] = 'szlz';
                            }
                            if (empty($inner_data['user'])) {
                                $btnClass[] = 'plate-sign-unlogin';
                            } else if($inner_data['user']['groupid'] == 5) {
                                $btnClass[] = 'plate-sign-unallow';
                            }
                            if (!empty($bundle['hasPower'])) {
                                $btnClass[] = 'allow';
                            } else if ($bundle['bprice'] == 0) {
                                $free = true;
                                $btnClass[] = 'free';
                            }
                            if (!empty($bundle['url'])) {
                                $url = $bundle['url'];
                            }
                            $detail_url = '/room/portfolio/tagged/'.$bundle['bid'].'.html';
                            ?>
                            <li class="mui-table-view-cell mui-media mui-col-xs-6" itemid="<?=$bundle['bid']?>">
                                <a href="<?=htmlspecialchars($detail_url, ENT_COMPAT)?>?>">
                                    <img class="mui-media-object" src="<?=htmlspecialchars($bundle['cover'], ENT_COMPAT)?>">
                                    <div class="mui-media-body" title="<?=htmlspecialchars($bundle['name'], ENT_COMPAT)?>"><?=htmlspecialchars(shortstr($bundle['name'], 30, ''), ENT_NOQUOTES)?></div>
                                    <p class="mui-ellipsis"><span class="name"<?php if(!empty($bundle['speaker'])) { ?> title="<?=htmlspecialchars($bundle['speaker'], ENT_COMPAT)?>"<?php } ?>><?=!empty($bundle['speaker']) ? htmlspecialchars(shortstr($bundle['speaker'], 18, ''), ENT_NOQUOTES) : ''?></span></p>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } else { ?>
                    <div class="nodata" style="float:left;"></div>
                <?php } ?>

            </ul>
	</ul>
    <?php } ?>
    <?php if (empty($inner_data['bundles']) && empty($inner_data['items'])) {?>
    <ul>
        <li style="width:100%;text-align:center;padding-top:20%;"><img src="http://wap.ebh.net/static/mui/images/noanswer.png" style="width:256px;height:189px;display:inline-block;"><p style="font-size: 20px;font-weight: 600;color: #2696f0;margin-top:20px;">暂无内容</p></li>
    </ul>
    <?php }?>
</div>
<?php $this->display('shop/plate/footers');?>