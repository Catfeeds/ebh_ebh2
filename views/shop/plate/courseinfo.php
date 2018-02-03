<?php
/**
 * 课件详情
 * Created by PhpStorm.
 * User: app
 * Date: 2016/11/4
 * Time: 16:34
 */
$viewnumlib = Ebh::app()->lib('Viewnum');
?>
<style type="text/css">
    .kehtfs.plate-sign-disabled{background-color:#e7e7e7;color:#999}
    .traitimg {width:30px;height:30px;border-radius:100%;}
    .latestregistrlist .touxiang {
        height:40px;
        width:30px;
        margin-top:8px;
    }

    .ranking2s-1 .latestregistrlist ul li {
        height: 46px;
    }
    .headportrait {
        height:30px;
        width:30px;
    }
    .ranking2s-1 .latestregistrlist ul li {height:48px;}
	.plshi {
		color:#999;
		font-size:14px;
		border-radius:4px;
		border:solid 1px #999;
		vertical-align: middle;
		padding:2px 4px;
		margin-right:5px;
	}

	/*分享弹窗样式*/
	#share_course{
		/*width: 751px;*/
		width: 500;
		margin: 10px 0 0 26px;
	}
	.marginbott24{
		margin-bottom: 24px;
	}
	
	.sharetitle{
		text-align: left;
		font-size: 18px;
		margin-bottom: 16px;
	}
	.sharetitle_send{
		font-size: 20px;
		color: #333333;
		font-weight: 900;
		height: 72px;
		line-height: 72px;
		width: 180px;
		text-align: center;
		/*增加float*/
		float: left;
		margin-bottom: 20px;
	}
	.seeqrbox{
		width: 220px;
		height: 142px;
		float: left;
	}
	.seeqrbox div{
		width: 142px;
		height: 140px;
		border: 1px solid #666666;
		border-radius: 5px;
		padding: 1px
	}
	.showqr{
		width: 140px;
		height: 140px;
	}
	.qrcode img{
		width: 100px;
		height: 100px;
	}
	.qrbox{
		height: 20px;
		margin-bottom: 22px;
	}
	.qrload{
		margin-right: 15px;
		float: left;
		width: 80px;
		text-align: left;
		line-height: 20px;
		font-size: 15px !important;
		color: #3d3d3d;
	}
	.qrload:hover{
		color: #3095C6;
	}
	.qrloadsvg{
		margin-right: 15px;
		float: left;
		width: 80px;
		text-align: left;
		line-height: 20px;
		font-size: 15px !important;
		color: #3d3d3d;
	}
	.qrloadsvg:hover{
		color: #3095C6;
	}
	.qrtips{
		float: left;
		width: 125px;
		text-align: left;
		line-height: 20px;
		font-size: 15px !important;
		color: #3d3d3d;
	}
	
	.sharecourse .icon-wechat,.sharecourse .icon-weibo,.sharecourse .icon-qq,.sharecourse .icon-qzone{
		float: left;
		width: 72px;
		height: 72px;
		margin-right: 53px;
	}
	.sharecourse .icon-wechat{
		background: url(http://static.ebanhui.com/ebh/tpl/troomv2/images/wechaticon72.png);
	}
	.sharecourse .icon-wechat .wechat-qrcode{
		left: -65px;
	}
	.sharecourse .icon-wechat .help{
		border: 0 none;
		width: 100%;
		text-align: center;
	}
	.sharecourse .icon-weibo{
		background: url(http://static.ebanhui.com/ebh/tpl/troomv2/images/sinaicon72.png);
	}
	.sharecourse .icon-qq{
		background: url(http://static.ebanhui.com/ebh/tpl/troomv2/images/qqicon72.png);
	}
	.sharecourse .icon-qzone{
		margin-right: 0;
		background: url(http://static.ebanhui.com/ebh/tpl/troomv2/images/qzoneicon72.png);
	}
	.help p{
		color: #666;
    	font-size: 12px;
	}
	.kshare{
		background: url(http://static.ebanhui.com/ebh/tpl/courses/images/kshare.png) no-repeat left center;
	    color: #1296DB;
	    font-size: 16px;
	    height: 16px;
	    line-height: 16px;
	    padding-left: 20px;
	    margin-left: 20px;
	    cursor: pointer;
	}
    <?php if (!empty($varpool['roominfo']['isdesign'])) { ?>
    .denser{margin:0 !important;}
    <?php } ?>
</style>
<div class="coursecenter group">
    <div class="coursedetailson group">
        <div class="ter_tits"> <a href="/">首页</a> &gt; <a href="/platform.html?pid=<?=(empty($varpool['pay_item']['pid'])?0:$varpool['pay_item']['pid'])?>"><?=htmlspecialchars(empty($varpool['pay_item']['pname'])?'':$varpool['pay_item']['pname'], ENT_NOQUOTES)?></a><?php if (!empty($varpool['pay_item']['sid'])) { ?> &gt;  <a href="/platform.html?pid=<?=$varpool['pay_item']['pid']?>&sid=<?=$varpool['pay_item']['sid']?>"><?=htmlspecialchars($varpool['pay_item']['sname'], ENT_NOQUOTES)?></a><?php } ?></div>
        <div class="coursedetailson-1">
            <?php
            //课程封面调用原图
            if (strpos($varpool['pay_item']['showimg'], 'tpl/default/images/folderimgs/course_cover_default_') !== false) {
                $cover = 'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/course_cover_default.png';
            } else {
                $cover = str_replace('_th', '', $varpool['pay_item']['showimg']);
                $cover = preg_replace('/_\d+_\d+/', '', $cover);
            }
            ?>
            <img class="kluisr" width="560" height="336" src="<?=htmlspecialchars($cover, ENT_COMPAT)?>">
            <div class="ietjsd" style="margin-bottom: 25px;">
                <h2 class="kuwres"><?=htmlspecialchars(!empty($varpool['pay_item']['iname'])?$varpool['pay_item']['iname']:'', ENT_NOQUOTES)?></h2>
                <?php
                $viewnum = $viewnumlib->getViewnum('folder',empty( $varpool['pay_item']['folderid'])?0: $varpool['pay_item']['folderid']);
                if (empty($viewnum)) {
                    $viewnum = $varpool['pay_item']['viewnum'];
                }
                ?>
                <span class="ketebn">人气：<?=intval($viewnum)?></span>
                <span class="kheter">总课时：<?=(empty($varpool['pay_item']['coursewarenum'])?0:$varpool['pay_item']['coursewarenum'])?>课时</span>
                <span class="kshare <?=($varpool['userid'] <= 0) ? "plate-sign-unlogin" : ""?>" id="kshare">分享</span>
                <div class="lectureteachfa">
                    <?php if (!empty($varpool['pay_item']['summary'])) { ?>
                        <div class="lectureteach">
                            <p title="<?=htmlspecialchars($varpool['pay_item']['summary'], ENT_COMPAT)?>"><?=htmlspecialchars(shortstr($varpool['pay_item']['summary'], 260), ENT_NOQUOTES)?></p>
                            <span>课程介绍</span>
                        </div>
                    <?php }?>
                </div>

                <?php
                $roominfoSetting = Ebh::app()->room->getSystemSetting();
                $appsetting = Ebh::app()->getConfig()->load('othersetting');
                $appsetting['szlz'] = empty($appsetting['szlz'])?0:$appsetting['szlz'];
                $szlz = $appsetting['szlz'] == $roominfoSetting['crid'];
				
                if (!empty($varpool['pay_item']['allow'])) {
                    $label = $szlz ? '立即观看' : '进入学习';
                } else if ($varpool['pay_item']['url'] === 0) {
                    $label = $szlz ? '点击观看' : '免费开通';
                } else {
                    $label = '点击报名';
                }
                if ($varpool['pay_item']['url'] === 0) {
                    if ($szlz) { ?>
                        <p class="egrdze-1" style="padding: 20px;"></p>

                    <?php } else { ?>
                        <p class="egrdze-1">免费</p>
                    <?php } }else { ?>
                    <p class="egrdze"><span class="plshi">平台使用费</span><span class="hrewrd">￥</span><?=sprintf("%01.2f", empty($varpool['pay_item']['iprice'])?'':$varpool['pay_item']['iprice'])?></p>
                <?php } ?>


                <p class="rryfge">自报名之日起<span class="ndejtr"><?php if (isset($varpool['pay_item']['imonth']) && $varpool['pay_item']['imonth'] > 0) { echo $varpool['pay_item']['imonth'].'个月'; } else {echo (empty($varpool['pay_item']['iday'])?0:$varpool['pay_item']['iday']).'天';} ?></span>有效期</p>
                <a id="nowregister" href="<?php if (!empty($varpool['pay_item']['url'])) { ?><?=htmlspecialchars($varpool['pay_item']['url'], ENT_COMPAT)?><?php } else { ?>javascript:;<?php } ?>" class="kehtfs<?=$varpool['pay_item']['sign_status']?><?php if(!empty($varpool['surveyid'])) { echo ' survey'; } ?>" folderid ="<?=(isset($varpool['pay_item']['folderid'])?$varpool['pay_item']['folderid']:0)?>" itemid="<?=(isset($varpool['pay_item']['itemid'])?$varpool['pay_item']['itemid']:0)?>"><?=$label?></a>
				<?php //限制报名人数的
				if(!empty($varpool['pay_item']['islimit']) && $varpool['pay_item']['limitnum']>0){
					$color = $varpool['pay_item']['opencount'] == $varpool['pay_item']['limitnum']?'green':'red';
					?>
				<span style="float:left;font-size:16px;color:#999;margin-top:10px">
				已报名：<span style="color:<?=$color?>;font-weight:bold;"><?=$varpool['pay_item']['opencount']?></span>/<span style="font-weight:bold"><?=$varpool['pay_item']['limitnum']?></span>
				</span>
				<?php }?>
                <a href="javascript:void(0)" id='addcollect' style="display:none;text-align:center;color:#ff9900;line-height:38px;margin-right:30px;border:1px solid #ff9900;float: left;width: 148px;height: 38px;border-radius: 3px;">加入收藏</a>
                <a href="javascript:void(0)" id='cancelcollect' style="display:none;text-align:center;color:#ff9900;line-height:38px;margin-right:30px;border:1px solid #ff9900;float: left;width: 148px;height: 38px;border-radius: 3px;">取消收藏</a>
                
            </div>
        </div>
    </div>
    <!--课程列表-->
    <div class="lefstr-1 group" style="overflow:hidden;">
        <div class="nav_list">
            <ul class="nav_listson" style="float: left;">
                <li><a href="/courseinfo/<?=(!empty($varpool['pay_item']['itemid'])?$varpool['pay_item']['itemid']:0)?>.html?pos=0"<?php if ($varpool['pos'] == 0){ ?> class="sel"<?php } ?>>课程目录</a></li>
                <li><a href="<?php if($varpool['pos'] == 0){ ?>/courseinfo/<?=(isset($varpool['pay_item']['itemid'])?$varpool['pay_item']['itemid']:0)?>.html?pos=1<?php } else { ?>javascript:;<?php }?>"<?php if ($varpool['pos'] == 1){ ?> class="sel"<?php } ?>>课程介绍</a></li>
                <li><a href="<?php if($varpool['pos'] == 0){ ?>/courseinfo/<?=(isset($varpool['pay_item']['itemid'])?$varpool['pay_item']['itemid']:0)?>.html?pos=2<?php } else { ?>javascript:;<?php }?>"<?php if ($varpool['pos'] == 2){ ?> class="sel"<?php } ?>>任课教师</a></li>
                <li><a href="<?php if($varpool['pos'] == 0){ ?>/courseinfo/<?=(isset($varpool['pay_item']['itemid'])?$varpool['pay_item']['itemid']:0)?>.html?pos=3<?php } else { ?>javascript:;<?php }?>"<?php if ($varpool['pos'] == 3){ ?> class="sel"<?php } ?>>资料下载</a></li>
            </ul>
            <?php if ($varpool['pos'] == 0){?>
    		<div class="courseserbox" style="float: right;margin-top: 15px;margin-right: 30px;">
    			<input style="font-size: 12px;color: rgb(50, 50, 50);"  name="txtname" class="newsou" id="searcourseq" value="<?= !empty($q) ? $q : '';?>" type="text" />
				<input type="button" class="soulico" value="" id="searcoursebtn">
    		</div>
    		<?php } ?>
        </div>
        
        <div class="listmode">
            <div class="list-content" loaded="0"<?php if ($varpool['pos'] != 0){ ?> style="display:none"<?php } ?>></div>
            <div class="list-content" loaded="0"<?php if ($varpool['pos'] != 1){ ?> style="display:none"<?php } ?>></div>
            <div class="list-content" loaded="0"<?php if ($varpool['pos'] != 2){ ?> style="display:none"<?php } ?>></div>
            <div class="list-content" loaded="0"<?php if ($varpool['pos'] != 3){ ?> style="display:none"<?php } ?>></div>
        </div>
    </div>
    
    
    
    
    <div class="mainright group">
        <!--最新报名-->
        <?php if (!empty($varpool['latest_sign'])) { ?>
            <div class="ranking-1 ranking1s-1">
                <div class="rankingtitle-1"><?php echo empty($isSzlz) ? '最新报名': '最近观看';?></div>
                <div class="rankinglist">
                    <ul>
                        <?php foreach ($varpool['latest_sign'] as $index => $item) { ?>
                            <li<?php if ($index % 5 == 4) { echo ' class="last"'; } ?>>
                                <div class="headportrait"><img src="<?=getavater($item,'50_50')?>" style="width:50px;height:50px;"></div>
                                <div class="headimg"></div>
                                <div class="rankname"><?=half_hide_name(getusername($item))?></div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="clear"></div>
        <?php } ?>
        <!--最新动态-->
        <?php if (!empty($varpool['dynamic'])) {
            $max_index = count($varpool['dynamic']) - 1; ?>
            <div class="dynamics-1 ranking2s-1">
                <div class="rankingtitle-1">最新动态</div>
                <div class="latestregistrlist">
                    <ul class="floatleft">
                        <?php foreach ($varpool['dynamic'] as $index => $item) { ?>
                            <li<?php if ($index == $max_index) { echo ' class="last"'; } ?>>
                                <div class="touxiang fl">
                                    <div class="headportrait"><img title="<?=half_hide_name(getusername($item))?>" class="traitimg" src="<?=getavater($item,'50_50')?>"></div>
                                </div>
                                <div class="newsignup fl">
                                    <p></p>
                                    <div class="openservice">学习课件：<a href="javascript:;" title="<?=htmlspecialchars($item['title'], ENT_COMPAT)?>"><?=htmlspecialchars(shortstr($item['title'], 18), ENT_NOQUOTES)?></a></div>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="clear"></div>
        <?php } ?>
        <!--热门课程-->
        <?php if (!empty($varpool['courselist'])) { ?>
            <div class="courseranking-1 ranking3s-1">
                <div class="rankingtitle-1">热门课程</div>
                <div class="courserankinglist">
                    <ul class="floatleft">
                        <?php
                        $class_arr = array(
                            1 => 'second',
                            2 => 'third',
                            3 => 'four',
                            4 => 'four',
                            5 => 'four'
                        );
                        foreach ($varpool['courselist'] as $index => $item) {
                            $img = show_plate_course_cover($item['img']);
                            $img = !empty($img) ? show_thumb($img, '129_77') : 'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_129_77.jpg' ?>
                            <li<?php if ($index > 0) { echo ' class="'.$class_arr[$index].'"'; } ?>>
                                <div class="pxlist"><?=$index + 1 ?></div>
                                <a href="javascript:;"><div><img src="<?=htmlspecialchars($img, ENT_COMPAT) ?>" class="fl mt5 list-cover" height="55" width="93"></div></a>
                                <div class="coursedetail">
                                    <a href="javascript:;" class="courraanktitle"><?=htmlspecialchars(shortstr($item['foldername'], 20), ENT_NOQUOTES)?></a>
                                </div>
                                <div class="courserankingnumber"><?=$item['coursewarenum']?></div>
                                <?php
                                $viewnum = $viewnumlib->getViewnum('folder', $item['folderid']);
                                if (empty($viewnum)) {
                                    $viewnum = $item['viewnum'];
                                }
                                ?>
                                <div class="rankingpopularity"><?=big_number($viewnum)?></div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        <?php } ?>
    </div>

</div>


<!--分享弹窗-->
<div id="share_course" style="display: none;">	
	<!--<div class="school_share" style="height: 230px">
		<div class="marginbott24" style="height: 230px;float: left;">
			<p class="sharetitle">网校链接</p>
			<div style="height: 144px;">
				<div class="seeqrbox">
					<div>
						<img class="showqr" src=""/>
					</div>
				</div>
				<div style="float: left;height: 150px;">
					<p class="qrbox">
						<a href="javascript:void(0)" class="qrload">256*256</a>
						<span class="qrtips">适合插入文档</span>
					</p>
					<p class="qrbox">
						<a href="javascript:void(0)" class="qrload">512*512</a>
						<span class="qrtips">适合插入PPT</span>
					</p>
					<p class="qrbox">
						<a href="javascript:void(0)" class="qrload">1024*1024</a>
						<span class="qrtips">适合印刷出版物</span>
					</p>
					<p class="qrbox" style="margin-bottom: 0px;">
						<a href="javascript:void(0)" class="qrloadsvg">矢量图</a>
						<span class="qrtips">适合多样使用场景</span>
						<span style="display: none;" id="svg-wrap" class="svg-wrap"></span>
					</p>
				</div>
			</div>
			<p style="height: 20px;clear: both;font-size: 15px;text-align: center;margin-top: 15px;">注：点击尺寸进行下载</p>
		</div>
		
		
		<div style="margin-top: 40px;float: left;padding-left: 30px;border-left: 1px solid #ccc;margin-left: 30px;">
			<p class="sharetitle_send">发送到</p>
			<div style="" class="shareschoolbox">-->
				<!--<div class="sharecourse"></div>--><!--动态生成-->
			<!--</div>
		</div>
	</div>	-->
	
	<!--<div style="width: 100%;height: 1px;background: #ccc;margin-top: 20px;margin-bottom: 30px;"></div>-->
	
	<div class="course_share" style="height: 230px">
		<div class="marginbott24" style="height: 230px;">
			<p class="sharetitle">课程链接</p>
			<div style="height: 144px;">
				<div class="seeqrbox">
					<div>
						<img class="showqr showqr_course" src=""/>
					</div>
				</div>
				<div style="float: left;height: 150px;">
					<p class="qrbox">
						<a href="javascript:void(0)" class="qrload qrload_course">256*256</a>
						<span class="qrtips">适合插入文档</span>
					</p>
					<p class="qrbox">
						<a href="javascript:void(0)" class="qrload qrload_course">512*512</a>
						<span class="qrtips">适合插入PPT</span>
					</p>
					<p class="qrbox">
						<a href="javascript:void(0)" class="qrload qrload_course">1024*1024</a>
						<span class="qrtips">适合印刷出版物</span>
					</p>
					<p class="qrbox" style="margin-bottom: 0px;">
						<a href="javascript:void(0)" class="qrloadsvg qrloadsvg_course">矢量图</a>
						<span class="qrtips">适合多样使用场景</span>
						<span style="display: none;" id="svg-wrap" class="svg-wrap"></span>
					</p>
				</div>
			</div>
			<p style="height: 20px;clear: both;font-size: 15px;text-align: center;margin-top: 15px;">注：点击尺寸进行下载</p>
		</div>
		
		
		<div style="margin-top: 40px;">
			<p class="sharetitle_send">发送到</p>
			<div style="height: 72px;float: left;margin-bottom: 20px;" class="sharecoursebox">
				<!--<div class="sharecourse"></div>--><!--动态生成-->
			</div>
		</div>
	</div>	
	
</div>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/share/css/share.min.css">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/share/jquery.qrcode.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/share/jquery.share.js"></script>
<script type='text/javascript' src='http://static.ebanhui.com/ebh/js/share/raphael-2.1.0-min.js'></script>
<script type='text/javascript' src='http://static.ebanhui.com/ebh/js/share/qrcodesvg.js'></script>
<script type="text/javascript">
    (function($) {
        var index = <?=$varpool['pos']?>;
        var nologin;		//是否登录控制器
        $.ajax({			//课程详情页面一加载请求接口获取是否显示收藏按钮
            type:"post",
            url:"/room/collect/checkcollectbutton.html",
            async:true,
            dataType:'json',
            data:{"folderid":'<?php echo (isset($varpool['pay_item']['folderid'])?$varpool['pay_item']['folderid']:0) ?>'},
            success:function(json){
                if(json.code == 1){
                    var data  = json.data;
                    if(data.collect == 0){
                        $("#addcollect").hide();
                        $("#cancelcollect").hide();
                    }else if(data.collect == 1){
                        $("#addcollect").hide();
                        $("#cancelcollect").show()
                    }else if(data.collect == 2){
                        $("#addcollect").show();
                        $("#cancelcollect").hide();
                    }
                }else{
                    
                }
            },
            error:function(json){

            }
        });


        var item = eval(<?=json_encode($varpool['pay_item'])?>);
       
        $("img.list-cover").bind('error', function() {
            var src = $(this).attr("src");
            src = src.replace('_129_77', '');
            $(this).attr('src', src);
            var errnum = $(this).attr('errnum') || 0;
            if (errnum > 0) {
                $(this).unbind('error');
                return;
            }
            errnum++;
            $(this).attr('errnum', errnum);
        });
        var folderid = <?=(isset($varpool['pay_item']['folderid'])?$varpool['pay_item']['folderid']:0)?>;
        function ajaxLoad(jdom, index, pageindex) {
            var urls = [
                '/room/portfolio/course_directory.html',
                '/room/portfolio/course_info.html',
                '/room/portfolio/course_teachers.html',
                '/room/portfolio/course_docs.html'
            ];
            var url = urls[index];
            $.get(url, {'fid': folderid, 'p': pageindex}, function(d) {
                jdom.html(d);
                jdom.attr('loaded', '1');
            }, 'html');
        }
        $.surveyId = <?=!empty($varpool['surveyid']) ? intval($varpool['surveyid']) : '0'?>;
        $("a.kehtfs").bind('click', function() {
            var t = $(this);
            if (t.hasClass('plate-sign-disabled')) {
                return false;
            }
            if (t.hasClass('plate-sign-unlogin')) {
                //未登录处理
                if (t.hasClass('survey')) {
                    $.loginByWindow(t.attr('itemid'), 'survey');
                    return false;
                }
                $.loginByWindow(t.attr('itemid'));
                return false;
            }
            if (t.hasClass('plate-sign-unallow')) {
                //教师账号处理
                $.note('教师账号，不允许进行此操作。');
                return false;
            }
            if (t.hasClass('survey')) {
                $.survey(item);
                return false;
            }
            if (t.hasClass('plate-sign-free')) {
                //免费课程处理
                $.buyFreeItem(item);
                return false;
            }
        });

        $("ul.nav_listson").bind('click', function(e) {
            if (e.target.nodeName.toLowerCase() != 'a') {
                return false;
            }
            var t = $(e.target);
            var p = t.parent('li');
            p.siblings('li').find('a').removeClass('sel');
            t.addClass('sel');
            $("div.listmode div.list-content").hide();
            var position = p.index();
            var current = $("div.listmode div.list-content").eq(position);
            current.show();
            if (current.attr('loaded') == '0') {
                ajaxLoad(current, position, 1);
            }
        });

        ajaxLoad($("div.listmode div.list-content").eq(index), index, 1);

        $("div.listmode").bind('click', function(e) {
            if (e.target.nodeName.toLowerCase() != 'a') {
                return false;
            }
            var t = $(e.target);
            if (!t.attr('data')) {
                return false;
            }
            var p = t.parents('div.list-content');
            $.ajax({
                'url': t.attr('data'),
                'type': 'get',
                'dataType': 'html',
                'cache': true,
                'success': function(html) {
                    p.html(html);
                }
            });
            return false;
        });
		
		//这里是搜索
		initsearch("searcourseq","请输入课程关键字");
		$("#searcoursebtn").click(function(){
			var q = $("#searcourseq").val();
			if(q == "请输入课程关键字"){
				q = "";
			}
			$.get('/room/portfolio/course_directory.html', {'fid': folderid,'p': 1,'q': q}, function(d) {
                $("div.listmode div.list-content").eq(0).html(d);
                $("div.listmode div.list-content").eq(0).attr('loaded', '1');
            }, 'html');
		});

        var $addcollect = $("#addcollect");			//加入收藏按钮
        var $cancelcollect = $("#cancelcollect"); 	//取消收藏按钮

        $addcollect.click(function(){	//加入收藏操作
            $.ajax({
                type: "post",
                url: "/room/collect/changebuttonstate.html",
                async: true,
                dataType: 'json',
                data:{
                    'flag': 1,
                    'itemid': '<?php echo (isset($varpool['pay_item']['itemid'])?$varpool['pay_item']['itemid']:0) ?>' ,
                    'folderid': '<?php echo (isset($varpool['pay_item']['folderid'])?$varpool['pay_item']['folderid']:0) ?>'
                },
                success: function(data){
                    if(data.code == 1){
                        $addcollect.css("display","none");
                        $cancelcollect.css("display","block");

                        var addone = "<span class='addone' style='opacity:0;text-align:center;line-height:36px;color:red;position:absolute;float:left;width:36px;height:36px;top:-18px;left:0;'>+1</span>";
                        window.parent.$(".kflist").append(addone);
                        $(".addone").animate({opacity: '1',top: '-30px'}, 300).animate({opacity: '0'}, 300);
                        setTimeout(function(){
                            $(".addone").remove();
                        },600);

                        window.parent.getcollect();
                    }else{
                        //console.log("收藏失败");
                    }
                },
                error:function(data){
                    //console.log(data);
                }

            });
        });

        $cancelcollect.click(function(){    //取消收藏操作
            $.ajax({
                type: "post",
                url: "/room/collect/changebuttonstate.html",
                async: true,
                dataType: 'json',
                data:{
                    'flag': 0,
                    'folderid': '<?php echo (isset($varpool['pay_item']['folderid'])?$varpool['pay_item']['folderid']:0) ?>'
                },
                success: function(data){
                    if(data.code ==1){

                        $addcollect.css("display","block");
                        $cancelcollect.css("display","none");

                        var addone = "<span class='addone' style='opacity:0;text-align:center;line-height:36px;color:red;position:absolute;float:left;width:36px;height:36px;top:-18px;left:0;'>-1</span>";
                        window.parent.$(".kflist").append(addone);
                        $(".addone").animate({opacity: '1',top: '-30px'}, 300).animate({opacity: '0'}, 300);
                        setTimeout(function(){
                            $(".addone").remove();
                        },600);

                        window.parent.getcollect();
                    }else{
                        //console.log("取消收藏失败");
                    }
                },
                error:function(data){
                    //console.log(data);
                }

            });
        });

 
        
  		$("#kshare").on("click",function(){
            if($(this).hasClass('plate-sign-unlogin')){
            	$.loginByWindow(true,null,'share');
            	return false;
            }else{
                var usersharekey = '<?=$varpool['sharekey']?>';
                var schoolsharekey = '<?=$varpool['schoolsharekey']?>';
                if(usersharekey=="" || usersharekey=="0" || schoolsharekey=="" || schoolsharekey=="0"){
                	sharekey = getsharekey();
                	usersharekey = sharekey.coursesharekey;
                	schoolsharekey = sharekey.schoolsharekey;
                }
                ////console.log(usersharekey);
                if(usersharekey=="0"){
                    alert('获取分享码失败')
                    return false;
                }else{
                	sharecourse(usersharekey,schoolsharekey);
                 } 
            }
  		});
		var $share_course = $("#share_course")[0];
		function sharecourse(usersharekey,schoolsharekey){
			dialog({
				title: '课程分享',
				content: $share_course,
				onshow:function(){
					//生产链接url
					var baseurl = '<?=$varpool['baseurl']?>';
					var domain = '<?=$varpool['roominfo']['domain']?>';
					var crname = '<?=$varpool['roominfo']['crname']?>';
					var wapurl = 'http://wap.ebh.net/shop/school/courselist.html?domain='+domain+'&sharekey='+schoolsharekey;
					var content = escape(encodeURIComponent(wapurl));
					var showsrc = baseurl+'?content='+content+'&show=1&size=6';
					$('.showqr').attr('src',showsrc);

					//打印输出
					//console.log('schoolshareurl:'+wapurl);
					
					var download256 = baseurl+ '?content='+content+'&down=1'+ '&size=8';
					var download512 = baseurl+ '?content='+content+'&down=1'+ '&size=16';
					var download1024 = baseurl+ '?content='+content+'&down=1'+ '&size=32';
					$($('.qrload')[0]).attr('href',download256);
					$($('.qrload')[1]).attr('href',download512);
					$($('.qrload')[2]).attr('href',download1024);
				
					//分享操作
					var shareschool = "<div class='shareschool sharecourse'></div>";
					$('.shareschoolbox').append(shareschool);
					$('.shareschool').share({
						url: wapurl,
						source: crname,
						title: crname,
						description: crname,
						summary: crname,
						image: showsrc,
						sites: ['wechat','weibo']
					});
			      	//生成矢量图
			      	$('.qrloadsvg').click(function(){
			      		createSvg(content);
			      	});
			      	//课程分享
			      	var coursename = '<?=htmlspecialchars(!isset($varpool['pay_item']['iname'])?'':$varpool['pay_item']['iname'], ENT_NOQUOTES)?>';
			      	var shareitemid = "<?=(!empty($varpool['pay_item']['itemid'])?$varpool['pay_item']['itemid']:0)?>";
					var sharekey = usersharekey;
			      	var wapcourseurl = 'http://wap.ebh.net/sharecourse/'+shareitemid+'.html?sharekey='+sharekey;
					var content_course = escape(encodeURIComponent(wapcourseurl));
					var showcoursesrc = baseurl+'?content='+content_course+'&show=1&size=6';

					//打印输出
					//console.log('courseshareurl:'+wapcourseurl);
					
					$('.showqr_course').attr('src',showcoursesrc);
			      	
					var download256_course = baseurl+ '?content='+content_course+'&down=1'+ '&size=8';
					var download512_course = baseurl+ '?content='+content_course+'&down=1'+ '&size=16';
					var download1024_course = baseurl+ '?content='+content_course+'&down=1'+ '&size=32';
					$($('.qrload_course')[0]).attr('href',download256_course);
					$($('.qrload_course')[1]).attr('href',download512_course);
					$($('.qrload_course')[2]).attr('href',download1024_course);
			      	
			      	var sharecourse = "<div class='sharecourse'></div>";
					$('.sharecoursebox').append(sharecourse);
					$('.sharecourse').share({
						url: wapcourseurl,
						source: coursename,
						title: coursename,
						description: coursename,
						summary: coursename,
						image: showcoursesrc,
						sites: ['wechat','weibo']
					});
			      	
			      	$('.qrloadsvg_course').click(function(){
			      		createSvg(content_course);
			      	});
				},
				onclose:function(){
					$('.sharecourse').empty();
					$('.sharecourse').remove();
					if($('#kshare').hasClass("plate-sign-login")){
						location.reload();
					}
				}
			}).showModal();
		}
		
		function getsharekey(){
			var itemid = "<?=(!empty($varpool['pay_item']['itemid'])?$varpool['pay_item']['itemid']:0)?>";
			var sharekey = {coursesharekey:'0',schoolsharekey:'0'};
			$.ajax({
				'url':'/room/portfolio/getsharekeyajax.html',
				type:'post',	
				dataType:'json',
				async: false,
				data:{'itemid':itemid},
				success:function(json){
					//console.log(json)
					if(json.code){
						alert(json.data.msg);
						return false;
					}else{
						sharekey = json.data;
						}
					},
				error:function(){
					//console.log('获取分享key失败,请刷新后重试');
					}	
				});
			return sharekey;
			}
		function createSvg(content){
			var qrcodesvg = new Qrcodesvg(content, "svg-wrap", 250);
			qrcodesvg.draw();
			qrcodesvg.createSquare();
			
			var svgXml = $('.svg-wrap').html();
			var image = new Image();
			image.src = 'data:image/svg+xml;base64,' + window.btoa(unescape(encodeURIComponent(svgXml))); //给图片对象写入base64编码的svg流
			var a = document.createElement('a');
			a.href = image.src; //直接导出SVG
			a.download = mathRand(); //设定下载名称
			a.click(); //点击触发下载 
			// 随机生成数字
			function mathRand() {
				var num = "";
				for(var i = 0; i < 6; i++) {
					num += Math.floor(Math.random() * 10);
				}
				return num;
			}
		}
    })(jQuery);

	
</script>
<script src="http://static.ebanhui.com/design/js/getroominfo.js"></script>
<script src="http://static.ebanhui.com/design/js/player.js"></script>