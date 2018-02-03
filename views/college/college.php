<?php $this->display('college/room_header'); ?>

    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/css/statch.css"/>
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen">
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/share/css/share.min.css">
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css" media="screen"/>
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css"/>
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/selcur/css/selcur.css<?=getv()?>"/>
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/mall/css/popupwindow.css"/>
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/mall/css/cropper.css"/>


    <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
    <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/share/jquery.qrcode.min.js"></script>
    <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/share/jquery.share.js"></script>
    <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/feedback.js"></script>
    <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.js"></script>

    <!-- 12.02.2016 添加meta标签 -->
    <meta content="width=1000, user-scalable=no, target-densitydpi=300;" name="viewport"/>
    <!-- <link rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/college/mobileStyle.css"> -->
    <style>
        a:hover {
            text-decoration: none;
        }

        a.cla {
            color: #fff;
        }

        .cla:hover {
            color: #fff;
        }

        .fxz2 {
            height: 54px;
            line-height: 54px;
            padding-left: 10px;
        }

        a.hdjhk {
            color: #00aaf0 !important;
            font-family: Microsoft Yahei;
            font-size: 12px;
        }


        span.xnrts {
            background: url("http://static.ebanhui.com/ebh/tpl/2014/images/ico_bj.jpg") no-repeat;
            color: #ffffff;
            height: 20px;
            line-height: 20px;
            position: absolute;
            right: 4px;
            text-align: center;
            width: 20px;
            top: 5px;
        }

        .rigpxiang .mypurses {
            top: 22px;
        }

        #jquery-overlay {
            z-index: 10000
        }

        #jquery-lightbox {
            z-index: 10001
        }

        .rigpxiang p.schooljieshao{
            color:#666;
            font-size:14px;
            width:130px;
            line-height:18px;;
        }
        .tQRCode{
            display:none;
            left: -162px;
            position: absolute;
            top: -82px;
            padding-right:19px;
            background:url(http://static.ebanhui.com/ebh/tpl/2016/images/wxxx2.png) right bottom no-repeat;
        }
        .tQRCode img{background-color:#fff;}
        .baoke {
            font-family: "Microsoft YaHe";
            width: 515px;
            text-align:left;
        }
        .imgrts {
            float: left;
            height: 54px;
            width: 90px;
        }
        .suitrna {
            float: left;
            margin-left: 10px;
            width: 400px;
        }
        .suitrna h2 {
            font-size: 18px;
        }
        .suitrna .p1 {
            color: #999;
            font-size: 14px;
        }
        .nasirte {
            border: 1px solid #e3e3e3;
            float: left;
            height: 120px;
            margin: 30px 0 20px;
            position: relative;
            width: 510px;
        }
        .titses {
            background: #fff none repeat scroll 0 0;
            font-size: 16px;
            left: 20px;
            padding: 0 3px;
            position: absolute;
            top: -15px;
        }
        .paewes {
            color: #666;
            font-size: 14px;
            height: 96px;
            line-height: 1.8;
            overflow-y: auto;
            padding: 12px 16px;
            width: 478px;
        }
        .jduste {
            color: #666;
            float: left;
            font-size: 14px;
            width: 100%;
        }
        .cshortr {
            color: #21b200;
            font-size: 22px;
            font-weight: bold;
        }
        .ansirrt {
            float: left;
            height: 35px;
            margin-top: 25px;
            text-align: right;
            width: 100%;
        }
        a.baodbtn {
            background: #619bff none repeat scroll 0 0;
            color: #fff;
            float: left;
            font-size: 14px;
            height: 32px;
            line-height: 32px;
            margin-left: 260px;
            text-align: center;
            width: 112px;
        }
        a.qsrbtn {
            background: #eee none repeat scroll 0 0;
            border: 1px solid #dcdcdc;
            color: #999;
            float: left;
            font-size: 14px;
            height: 30px;
            line-height: 30px;
            margin-left: 30px;
            text-align: center;
            width: 110px;
        }
		.fltbot {
			width:250px;
			float:left;
			margin: 5px 0 0 40px;
		}
		.seduc {
			width:60px;
			height:60px;
			border:solid 1px #e3e3e3;
			margin-right: 15px;
			float:left;
			text-align: center;
		}
		.bottxt {
			height:30px;
			text-align:center;
			line-height:3;
		}
		.bottxt2 {
			display: inline-block;
			color:#666;
			line-height:1.5;
			font-size: 12px;
		}
		.yelbtn {
			background:#ffa929;
			width:90px;
			font-size:18px;
			font-weight:bold;
			height:32px;
			border-radius:5px;
			margin:5px 0 0 10px;
			line-height:32px;
			color:#fff;
			text-align:center;
			display:block;
		}

        div.toplinks{background-color:#1FBBA6;height:40px;line-height:40px;font-weight:700;}
        div.toplinks a.clink{color:#fff;margin:0 0 0 15px;font-size:15px;}
        <?php if (empty($showModuleMenu)) { ?>.cmain_top.mt10{height:auto;}<?php } ?>
    </style>
    <input type="hidden" value="" id="methodController" />
    <script type="text/javascript">
         //判断是否为移动端登录12.01.2016
                // var sUserAgent = navigator.userAgent.toLowerCase();
                // var bIsIpad = sUserAgent.match(/ipad/i) == "ipad";
                // var bIsIphoneOs = sUserAgent.match(/iphone os/i) == "iphone os";
                // var bIsMidp = sUserAgent.match(/midp/i) == "midp";
                // var bIsUc7 = sUserAgent.match(/rv:1.2.3.4/i) == "rv:1.2.3.4";
                // var bIsUc = sUserAgent.match(/ucweb/i) == "ucweb";
                // var bIsAndroid = sUserAgent.match(/android/i) == "android";
                // var bIsCE = sUserAgent.match(/windows ce/i) == "windows ce";
                // var bIsWM = sUserAgent.match(/windows mobile/i) == "windows mobile";
                // if (bIsIpad || bIsIphoneOs || bIsMidp || bIsUc7 || bIsUc || bIsAndroid || bIsCE || bIsWM) {
                //         mainFrame.style.width = 980 + 'px';
                // } else {
                // }


        //滚动条初始化
        function scrollInit(){
            $(window).scroll(function(){
                var pageC = pageCondition();
                try{
                    window.frames['mainFrame'].pageCondition(pageC);
                }catch(e){
                }
            })
        }
        //分页条件
        function pageCondition(){
            var windowHeight =  $(window).height();
            var scrollheight = $(this).scrollTop();
            var documentHeight = $(document).height();
            var pageHeight = 100;//距底部的分页高度
            if(windowHeight<documentHeight){
                if( windowHeight + scrollheight >= documentHeight -pageHeight ){
                    return 1;
                }
            }
            return 0;
        }
        //滚动条置顶
        function topSet(){
            $(window).scrollTop(0);
        }
    </script>
    <!--巴南党校一些信息过滤-->
<?php $domain = $this->uri->uri_domain();
	$appsetting = Ebh::app()->getConfig()->load('othersetting');
	$is_zjdlr = empty($is_zjdlr)?false:true;
	$is_newzjdlr = empty($is_newzjdlr)?false:true;

?>

    <div class="wrap" style="<?= $is_zjdlr?'background:none;margin-top:150px':''?>">
        <?php if(!$is_zjdlr){?>
            <div style="position:relative; width:980px; margin:0 auto; height:0px;">
                <div class="titles fl"><?php if (!empty($showModuleMenu)) { ?>
                    <span class="spans" style="left:130px; top:-50px; *top:-40px;"><?= $room['crname'] ?></span><?php } ?>
                </div>
            </div>
        <?php }?>
        <div class="cmain" style="<?= $is_zjdlr?'background:none':''?>">
            <!--国土资源增加导航条star-->
            <?php if($is_zjdlr){// 是<国土资源厅>账号登录
                ?>
                <div class="navtop">
                    <ul>
                        <li class="navtopli cur"><a href="/myroom.html" target="_self">首页</a></li>
                        <?php if($is_newzjdlr){?>
                        <li class="navtopli"><a href="/myroom/college/study/cwlist/<?=$appsetting['newlecture']?>.html" target="mainFrame">讲座中心</a></li>
                        <li class="navtopli"><a href="/myroom/college/study/cwlist/<?=$appsetting['newtransaction']?>.html" target="mainFrame">业务纵览</a></li>
                        <li class="navtopli"><a href="/myroom/college/study/cwlist/<?=$appsetting['newregulations']?>.html" target="mainFrame">政策法规</a></li>
                        <?php }else{?>
                        <li class="navtopli"><a href="/myroom/college/study/cwlist/<?=$appsetting['lecture']?>.html" target="mainFrame">讲座中心</a></li>
                        <li class="navtopli"><a href="/myroom/college/study/cwlist/<?=$appsetting['transaction']?>.html" target="mainFrame">业务纵览</a></li>
                        <li class="navtopli"><a href="/myroom/college/study/cwlist/<?=$appsetting['regulations']?>.html" target="mainFrame">政策法规</a></li>
                        <?php }?>
                        <li class="navtopli"><a href="/college/myask/all.html" target="mainFrame">交流园地</a></li>
                        <li class="navtopli"><a href="/homev2/profile/profile.html?ht=1" target="mainFrame">个人中心</a></li>
                        <li class="navtopli"><a href="/college/classmate/online.html" target="mainFrame">在线同学</a></li>
                        <li class="navtopli"><a href="/logout.html" target='_self'>退出系统</a></li>
                    </ul>
                </div>
                <script type="text/javascript">
                    $(function () {
                        $(".navtop ul li").on("click",function(){
                            $(".navtop ul li").removeClass("cur");
                            $(this).addClass("cur");
                        })
                    });
                </script>
            <?php }?>
            <!--国土资源增加导航条end-->
            <div class="cmain_top mt10 <?=(isApp()==true)?"appnone":""?>">
                <?php if (!empty($toplinks)) { ?><div class="toplinks"><?php foreach ($toplinks as $toplink) { ?>
                    <a class="clink" href="<?=htmlspecialchars($toplink['href'], ENT_COMPAT)?>"<?php if (!empty($toplink['target'])) { ?>
                     target="<?=$toplink['target'] == 1 ? 'mainFrame' : '_blank'?>"<?php } ?>><?=htmlspecialchars($toplink['name'], ENT_NOQUOTES)?></a>
                <?php } ?></div><?php } ?>
				<?php
                if (!empty($showModuleMenu)) {
				if ($is_zjdlr) { ?>
                    <div class="cmain_top_l fl" style="z-index:2;position:relative; width: 297px">
                        <h2 class="gtname"><?=!empty($user['realname']) ? $user['realname'] : $user['username']?></h2>
                        <p class="gttple"><span class="fl">工作单位：</span><span class="gtdsrt fl" id="zjdlr-unit"><?=!empty($unit) ? htmlspecialchars($unit, ENT_NOQUOTES) : '' ?></span></p>

                        <?php if($is_newzjdlr){?>
                        	<p class="gttple">
                            <a href="/studyscorelogs/getScoreList.html" target="mainFrame" class="fl" style="color: #999;width: 158px;"><span class="fl">总学分：</span><span class="gtfense"><?=!empty($scoresum) ? floatval($scoresum) : 0?></span></a>
                            <span class="fl">本年度：
                                <span class="gthuit"><?=!empty($yearCredit) ? intval($yearCredit) : 0?></span>
                            </span>
                            </p>
                        <?php }else{?>
                        	<p class="gttple"><a href="javascript:void(0)" target="mainFrame" style="color: #999;"><span class="fl">已获学分：</span><span class="gtfense"><?=!empty($user['credit']) ? floatval($user['credit']) : 0?></span></a></p>
                        <?php }?>

                        <?php if(!$is_newzjdlr){?>
                        	<p class="gttple"><span class="fl">个人排名：</span><span class="gthuit"><?=isset($credit_rank) ? $credit_rank : '' ?></span></p>
                        <?php }?>

                        <p class="gttple">
                        	<?php if($is_newzjdlr){?>
                        		<a href="/college/myarticle/my.html" target="mainFrame" class="fl" style="color: #999;width: 158px;">文章：
	                        		<span class="gthuit"><?=!empty($articlecount) ? intval($articlecount) : 0?></span>
	                        	</a>
	                        	<span class="fl">评论：
	                        		<span class="gthuit"><?=!empty($reviewcount) ? intval($reviewcount) : 0?></span>
	                        	</span>
                        	<?php }else{?>
                        		<a href="javascript:void(0)" target="mainFrame" class="fl" style="color: #999;width: 158px;">文章：
	                        		<span class="gthuit">0</span>
	                        	</a>
	                        	<span class="fl" >评论：
	                        		<span class="gthuit"><?=!empty($myreviewcount) ? intval($myreviewcount) : 0?></span>
	                        	</span>
                        	<?php }?>
                        </p>
                    </div>
                <?php } else { ?>
                    <div class="cmain_top_l fl" style="z-index:2;position:relative; width: 297px">
                        <?php
                        $roominfo['crid'] = empty($roominfo['crid'])?0:$roominfo['crid'];
                        ?>
                        <?php if ($domain != 'bndx' && !$is_zjdlr) { ?>
                            <div class="xiutgt fr mt10"><a class="cla" href="/home/score/description.html" target="mainFrame"><span style="padding-left:15px;"><?= $clinfo['title'] ?></span></a></div>
                        <?php } else { ?>
                            <div style="margin-top:30px"></div>
                        <?php } ?>
                        <div class="clear"></div>
                        <?php
                        if ($user['sex'] == 1)
                            $defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
                        else
                            $defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
                        $face = empty($user['face']) ? $defaulturl : $user['face'];
                        $face = str_replace('.jpg', '_78_78.jpg', $face);
                        ?>
                        <div class="gerenxinxi">
                            <div class="touxiang fl"><a class="listbr" href="/homev2/profile/<?=$is_zjdlr?'profile':'avatar'?>.html?ht=1"
                                                        target="mainFrame"></a><img src="<?= $face ?>" height="78" width="78"/></div>
                            <div class="rigpxiang ml10 fl" style="position:relative;">
                                <div>
                                    <?php if ($is_zjdlr) { ?>
                                        <a href="/homev2/profile/profile.html?ht=1" target="mainFrame"><p class="name fl"><?= shortstr($user['realname'], 6, '') ?></p></a>
                                    <?php }else{ ?>
                                        <a href="<?=geturl('homev2/profile')?>"><p class="name fl"><?= shortstr($user['realname'], 6, '') ?></p></a>
                                    <?php } ?>
                                    <p class="jifen fl"><a href="/home/score/credit.html" target="mainFrame"><?= $user['credit'] ?></a></p>
                                </div>
                                <div class="clear"></div>
                                <?php if ($is_zjdlr){ ?>
                                    <p class="schooljieshao"><?php echo mb_substr(empty($myclass)?:$myclass['classname'], 0, 16, 'utf-8');?></p>
                                <?php }else{ ?>
                                    <?php if ($domain != 'bndx' && !$is_zjdlr) { ?>
                                        <div class="mypurse mt10" id="mypurse">
                                            <div class="mypico fl"></div>
                                            <div class="fl mypu"><a href="/homev2/purse/index.html">我的钱包</a></div>
                                        </div>
                                    <?php } ?>

                                    <div class="clear"></div>
                                    <!--判断是网校还是企业，企业$room_type变量输出1，0为网校-->
									<?php $room_type = Ebh::app()->room->getRoomType();$room_type = $room_type == 'com' ? 1 : 0;?>
                                    <div class="mypurses mt10" id="mypurses" style="background:<?=($room_type==1) ? 'url(http://static.ebanhui.com/ebh/tpl/2016/images/mypbj_qy.png)':'url(http://static.ebanhui.com/ebh/tpl/2016/images/mypbj.png)'?> no-repeat center;display:none;height:<?=($room_type==1) ? '78px':'184px'?>;">
                                        <div class="mypurse" id="mypurse2">
                                            <div class="mypico fl"></div>
                                            <div class="fl mypu"><a href="/homev2/purse/index.html">我的钱包</a></div>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="zhye">账户余额：<span><?= $user['balance'] ?></span> 元<a href="http://pay.ebh.net/"
                                                                                                        target="_blank"
                                                                                                        style="padding-left:10px; color:#00aaf0 ;font-family: Microsoft Yahei;">充值</a><!--<a href="#" style="padding-left:10px;">提现</a>-->
                                        </div>

                                        <div class="clear"></div>
                                        <iframe style="display: <?=($room_type==1) ? "none":"block"?>;" id="couponFrame"  name="couponFrame" scrolling="no" width="227" height="46" frameborder="0"
                                                src="<?= geturl('college/coupon') ?>"></iframe>
                                        <?php if (!empty($mycoupon)) { ?>
                                            <div class="fxz" style="display: <?=($room_type==1) ? "none":"block"?>;">
                                                <div class="fl">分享至：</div>
                                                <div class="share-bar fl">
                                                </div>
                                            </div>
                                            <script>
                                                $('.share-bar').share({
                                                    url: 'http://www.ebh.net/coupon.html?code=<?=$mycoupon?>',
                                                    source: 'e板会',
                                                    title: '优惠专享！网校优惠任你拿！',
                                                    description: '分享学习，分享快乐！我从<?=empty($roominfo['crname']) ? 'e板会' : $roominfo['crname'] ?>获得了优惠码：<?=$mycoupon?>，开通任意课程服务都能享受优惠价哦，一起来吧！',
                                                    summary: '好友使用你的优惠码购买课程，尊享网校优惠！你也可以获得现金奖励哦！快快行动吧！',
                                                    image: 'http://static.ebanhui.com/ebh/tpl/2016/images/ebh_coupon.jpg',
                                                    sites: ['qzone', 'wechat', 'weibo']
                                                });
                                            </script>
                                        <?php } else { ?>
                                            <div class="fxz2" style="display: <?=($room_type==1) ? "none":"block"?>;">
                                                <a class="hdjhk" href="http://www.ebh.net/coupon.html" target="_blank">查看优惠码规则</a>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                                <div class="clear"></div>
                                <script>
                                	//积分超过万的时候保留1位小数用中文万表示，如1.0万
                                   	var $jifen = $(".jifen a");
                                   	var $xiutgt = $(".xiutgt span");
							        var jifen = $jifen.html();
							        if( jifen >= 10000 ){
							        	$xiutgt.html("文曲星");
							        }
							       	if(parseInt(jifen / 10000) > 0){
							       		var jifenStr = jifen+"";
										jifen = parseInt(jifen / 10000);
										$jifen.html(jifen+"."+jifenStr[jifenStr.length-4]+"万");
							       	}
                                    //显示钱包
                                    $(document).on("mouseenter","#mypurses,#mypurse",function () {
                                        $("#mypurses").show();
                                    });
                                    $(document).on("mouseleave","#mypurses,#mypurse",function () {
                                        $("#mypurses").hide();
                                    });

                                    function prev(jo) {
                                        jo.each(function () {
                                            $(this).lightBox();
                                        });
                                    }

                                    //config
                                    function dialogConfig(msg, callback) {
                                        var d = dialog({
                                            title: '信息提示',
                                            content: '<div class="sckj1s" style="padding:0"><div class="xzkctsxx" style="">' + msg + '</div></div>',
                                            id: 'dialog-config',
                                            fixed: true,
                                            'okValue': '确定',
                                            'ok': callback,
                                            'cancelValue': '取消',
                                            'cancel': function () {

                                            }
                                        });
                                        d.showModal();
                                    }
                                    function showConfigMsg(msg, callback) {
                                        var d = dialog({
                                            title: '信息提示',
                                            content: '<div class="sckj1s" style="padding:0;width:200px;"><div class="xzkctsxx" style="width:200px">' + msg + '</div></div>',
                                            id: 'dialog-config',
                                            fixed: true,
                                            'okValue': '确定',
                                            'ok': callback,
                                            cancel:false
                                            //quickClose: true
                                        });
                                        d.showModal();
                                        setTimeout(function () {
                                            d.close().remove();
                                            callback();
                                        }, 2000);
                                    }
                                    function showMsg(strMsg, callback) {
                                        var d = dialog({
                                            title: '信息提示',
                                            content: '<div class="sckj1s"><div class="xzkctsxx" style="">' + strMsg + '</div></div>',
                                            id: 'alert',
                                            padding: 0,
                                            fixed: true,
                                            quickClose: true
                                        });
                                        d.show();
                                        setTimeout(function () {
                                            if (callback) {
                                                callback();
                                            }
                                            d.close().remove();
                                        }, 2000);
                                    }
                                </script>
                            </div>
                        </div>
                        <div class="clear"></div>
						<?php if(!$is_zjdlr){?>
						<div class="fltbot">
							<a class="bottxt2" href="/studyscorelogs/getScoreList.html" target="mainFrame">
								<div class="seduc">
									<p class="bottxt"><?=!empty($scoresum) ? floatval($scoresum) : 0?></p><p>学分</p>
								</div>
							</a>
							<a class="bottxt2" href="javascript:void(0)" target="mainFrame">
								<div class="seduc">
									<p class="bottxt" style="color: #666;"><?=$ltime?></p>
									<p class="bottxt2">学时</p>
								</div>
							</a>
							<a class="bottxt2" href="/home/score/credit.html" target="mainFrame">
								<div class="seduc">
									<p class="bottxt"><?=$user['credit']?></p><p>积分</p>
								</div>
							</a>
						</div>
						<?php } else {?>

                        <div class="qianming"><p class="qianmings" style="width:230px; text-align:left;"><span id="mysign_span"
                                                                                                               style="display:block;width:235px;cursor:text; text-align:left;"
                                                                                                               title="<?= empty($user['mysign']) ? '点击修改签名' : $user['mysign'] ?>"><?= empty($user['mysign']) ? '暂无签名' : shortstr($user['mysign']) ?></span>
                                <input type="text" maxlength="140" id="mysign"
                                       style="display:none;width:195px;border:1px solid #9eb7cb;height:20px;line-height:20px;padding:0 5px;margin-top:5px;margin-bottom:1px ">
                            </p></div>
                        <?php if ($domain != 'bndx') { ?>
                            <?php if( !$is_zjdlr){ ?>
                                <div class="gzfs">
                                    <div class="fl"><a class="snsa" href="http://sns.ebh.net/follow.html" target="_blank"><span
                                                class="span1s" id="follownum"><?= empty($myfavoritcount) ? 0 : $myfavoritcount ?></span><br/><span
                                                class="span2s">关注</span></a></div>
                                    <div class="fr"><a class="snsa" href="http://sns.ebh.net/follow/fans.html" target="_blank"><span
                                                class="span1s"><?= empty($myfanscount) ? 0 : $myfanscount ?></span><br/><span
                                                class="span2s">粉丝</span></a></div>
                                </div>

                            <?php }}
						}?>
                    </div>
                <?php } ?>

                <div class="cmain_top_r fr">
                    <div>
                        <div class="titles fl">
                            <span>Hello！<?= !empty($user['realname']) ? $user['realname'] : $user['username'] ?><?php if ($domain != 'bndx') { ?>&nbsp;<?= $roominfo['property'] !=3?($is_zjdlr?'学员':'同学'):''?>，欢迎使用<?= $room['crname'] ?>。<?php } ?></span><?php if ($domain == 'bndx') { ?>
                                <span style="padding-left:0;font-size:14px;font-weight:bold;color:#fb0d1f">&nbsp;&nbsp;本网站系巴南党校学员内部学习交流平台，严禁相关资源转载外传</span><?php } ?>
                        </div>
                        <?php if (!empty($signed)) {
                            $showsign[0] = ' style="display:none"';
                            $showsign[1] = '';
                        } else {
                            $showsign[0] = '';
                            $showsign[1] = ' style="display:none"';
                        }
                        $weekarr = array('日', '一', '二', '三', '四', '五', '六');
                        ?>
                        <div class="grkgee fr">
                            <p class="dgrtwe"><span
                                    style="font-size:16px; display:block; height:25px;"><?= Date('Y-m-d', SYSTIME) ?></span><span
                                    class="dates"><?= Date('d', SYSTIME) ?></span>&nbsp;星期<?= $weekarr[Date('w', SYSTIME)] ?></p>
                <span id="creditplus"
                      style="display:none;position:absolute;color:orange;right:57px;top:-2px;z-index:100">+1积分</span>
                        <?php if(!$is_zjdlr){?>
                            <a href="javascript:void(0)" class="daotqian" onclick="signin()" <?= $showsign[0] ?>><div class="yelbtn">签到</div><span
                                    style="font-size:14px; line-height:25px; *line-height:12px;"><?= $continuous ?>天</span></a>

                            <p class="daotqian2" <?= $showsign[1] ?> title="已经连续签到<?= $continuous ?>天" day="<?= $continuous ?>">
                                已签到<br><span style="font-size:14px; line-height:5px;*line-height:12px;"
                                             class="afsign"><?= $continuous ?>天</span></p>
                        <?php }?>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <div class="esukang modulediv">
                        <?php $moodulecount = 0;
						foreach ($modulelist as $k => $module) {
							$moodulecount++;
                            $target = empty($module['target']) ? 'mainFrame' : $module['target'];
                            $mname = empty($module['nickname']) ? $module['modulename'] : $module['nickname'];
                            $modulename = shortstr($mname, 8, '');
                            $zjdlrarr = array('mykong','yunpan');
                            ?>
                            <?php if(!in_array($module['classname'],$zjdlrarr) || !$is_zjdlr){?>
                                <a title="<?= $mname ?>" class="<?= $module['classname'] ?> fl dfocus" href="<?= $module['url'] ?>"
                                   target="<?= empty($module['target']) ? 'mainFrame' : $module['target'] ?>">
                                    <img
                                        src="<?= $imgurl = 'http://static.ebanhui.com/ebh/tpl/2016/images/titleico/myroom/47/' . $module['classname'] . '.png'; ?>"/>

                                    <p class="jisrers"><?= $modulename ?></p>
                                </a>
                            <?php }?>
                            <?php
                            unset($modulelist[$k]);
                            if ($moodulecount == 7)
                                break;
                        }?>

                    </div>
                </div>
                <?php } ?>
            </div>
            <div class="clear"></div>

            <?php //if(in_array($this->uri->uri_domain(),array('xiaoxue','rzjt'))) {
            if (!empty($showModuleMenu) && !empty($modulelist)) {
                ?>
                <div class="cmain_bottoms cmain_bottoms2 cmain_top_r " style="margin-top:1px;padding-bottom:0;">
                    <!--
                    <h3>微题>></h3>
                    <ul>
                        <li class="smartexamenew fl"><a href="/smartexam/smartexam/qlist.html"></a></li>
                    </ul>
                    -->
                    <div class="esukangs modulediv">
                        <?php
                        foreach ($modulelist as $module) {
                            $target = empty($module['target']) ? 'mainFrame' : $module['target'];
                            $mname = empty($module['nickname']) ? $module['modulename'] : $module['nickname'];
                            $modulename = shortstr($mname, 8, '');
                            $zjdlrarr = array('mykong','yunpan');
                            ?>
                            <?php if(!in_array($module['classname'],$zjdlrarr) || !$is_zjdlr){?>
                                <a title="<?= $mname ?>" href="<?= $module['url']?>" target="<?= $target ?>"
                                   class="dfocus subtop <?= $module['classname'] ?> fl">
                                    <img class="tyrtrew"
                                         src="<?= $imgurl = 'http://static.ebanhui.com/ebh/tpl/2016/images/titleico/myroom/32/' . $module['classname'] . '.png'; ?>"/>

                                    <p class="jisrers"><?= $modulename ?></p>
                                </a>
                            <?php }?>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>


            <div class="rigksts" style="background:white;float:right;margin-top:10px;display:none;border:none">
                <img src="http://static.ebanhui.com/ebh/tpl/2014/images/colleger.jpg"/>

            </div>
            <?php
            if (empty($idefurl))
                $idefurl = "/myroom/college.html";
            if ($this->input->cookie('refer')) {
				$refer = urldecode($this->input->cookie('refer'));
				$curhost = getdomain();
                $sub_domain = substr($curhost, strpos($curhost, '.'));
				if(substr($refer,0,7) != 'http://' || substr($refer,0,strlen($curhost)) == $curhost) {	//非相同域名则止加载默认页面,如当前域名为 xiaoxue.ebh.net 而需要加载的为rqzx.ebh.net 则不进行加载 避免数据错乱
					$idefurl = $refer;
					// $this->input->setCookie('refer', '');
                    echo '<script>setCookie("ebh_refer","", -1, "/", "'.$sub_domain.'");</script>';
                    echo '<script>setCookie("ebh_refer","");</script>';
				} else {
					$idefurl = "/myroom/college.html";
				}
            }
			//直接显示学习页面的网校
			$noindex = Ebh::app()->getConfig()->load('myroomnoindex');
			if(empty($noindex)){
				$noindex = array();
			}
			if(in_array($roominfo['domain'],$noindex)){
				$idefurl = '/myroom/college/study.html';
			}
            if (!empty($url))
                $idefurl = $url;
            ?>
            <iframe onload="resetmain()" id="mainFrame" name="mainFrame" scrolling="no" width="100%" height="100%" frameborder="0"
                    src="<?= $idefurl ?>" style="margin-top:10px;"></iframe>


            <!--意见反馈start-->
            <?php
            $qcode_lib = Ebh::app()->lib('Qcode');
            $qcode = $qcode_lib->get_qcode();
            ?>
            <div style="width:100%;position:fixed;top:55%;height:1px;display: none" id="ujdkgj" >
                <ul class="toolbarx">
                    <li class="tool tFeedback"><a style="display:none" onclick="feedback()">意见反馈</a></li>
                    <li class="tool tWechat"><a style="display:none">微信学习</a><div class="tQRCode"><img src="<?=htmlspecialchars($qcode, ENT_COMPAT)?>" width="141" height="141" /></div></li>
                </ul>
            </div>
            <!--意见反馈end-->

        </div>
    </div>
    <script>

        function getUrlParam(name) {
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
            var r = window.location.search.substr(1).match(reg);  //匹配目标参数
            if (r != null) return unescape(r[2]);
            return null; //返回参数值
        }

        $(function () {
            var furl = getUrlParam('url');
            $.each($('.dfocus'), function (k, v) {
                if ($(this).attr('href') == furl)
                    $(this).addClass('onhover');
            });

            //$(".zzhuye").addClass('onhover');

        })

        function signin() {
            $.ajax({
                type: 'POST',
                'url': '/myroom/mysetting/sign.html',
                data: {'signin': 1},
                success: function (data) {
                    $('.daotqian2').attr('title', '已经连续签到' + (1 + parseInt($('.daotqian2').attr('day'))) + '天');
                    $('.afsign').html((1 + parseInt($('.daotqian2').attr('day'))) + '天');
                    $('.daotqian').hide();
                    $('.daotqian2').show();
                    $('#creditplus').fadeTo(1000, 1);
                    $('#creditplus').fadeTo(2000, 0);
                }
            });

        }
        var resetmain = function (sys) {
        	var subheight = arguments[0] ? arguments[0] : 0;
            try {
                if(sys == 'sysss'){
                    var iframeHeight =  $("#mainFrame").contents().find("body").height();
                    $("#mainFrame").height(iframeHeight);
                    return false
                }
                var mainFrame = document.getElementById("mainFrame");
                var iframeHeight = Math.min(mainFrame.contentWindow.window.document.documentElement.scrollHeight, mainFrame.contentWindow.window.document.body.scrollHeight) + 1;
				if(subheight > 0 && subheight > iframeHeight){
					iframeHeight = subheight;
					}
                newiframeHeight = iframeHeight < 700 ? 700 : iframeHeight;
                if(isFirefox=navigator.userAgent.indexOf("Firefox")>0){
                    var mainH =  mainFrame.contentWindow.document.getElementById('Main');
                    if(mainH){
                    	newiframeHeight = iframeHeight + 618;
                    }
                }
                $(mainFrame).height(newiframeHeight);


            } catch (e) {

            }
        }
        var Func = function (name, func) {
            if (typeof func != "undefined") {
                window[name] = func;
                return Func;
            } else {
                return window[name];
            }
        }
        $(function () {
            $('body').bind('click', function (e) {
                try {
                    Func('pclicked') && Func('pclicked')(e);
                } catch (e) {
                }
            });
        });

        $('.frold').click(function () {
            // $('#mainFrame').width(790);
            // $('.rigksts').show();
        });
        $('.frnew').click(function () {
            // $('#mainFrame').width(1000);
            // $('.rigksts').hide();
        });


        $(".modulediv a").click(function () {
            $(".modulediv a").removeClass('onhover');
            $(this).addClass('onhover');
        })


        $("#mysign_span,.qianmings").click(function () {
            var mytitle = $("#mysign_span").attr("title");
            if (mytitle == '点击修改签名') mytitle = '';
            //显示输入框
            $("#mysign_span").hide();
            $("#mysign").show();
            $("#mysign").focus();
            $("#mysign").val(mytitle);
        });

        $("#mysign").blur(function () {
            var mysign = $("#mysign").val();
            var mytitle = $("#mysign_span").attr("title");
            if (mytitle == '点击修改签名') mytitle = '';
            //判断长度小于140字符
            if (mysign.length > 140) {
                alert("签名请不要超过140个字");
                $("#mysign").focus();
                return false;
            }
            ;
            //有修改时保存
            if (mysign != mytitle) {
                //ajax保存
                $.ajax({
                    url: "<?=geturl('home/profile/editmysign')?>",
                    type: "post",
                    data: {mysign: mysign},
                    dataType: "json",
                    success: function (data) {
                        if (data.code == 1) {
                            $("#mysign_span").html(data.mysign);
                            if (mysign == '') mysign = '点击修改签名';
                            $("#mysign_span").attr("title", mysign);
                            $("#mysign").hide();
                            $("#mysign_span").show();
                        }
                        else if (data.code == -1) {
                            var str = '';
                            $.each(data.Sensitive, function (name, value) {
                                str += value + '&nbsp;';
                            });
                            var d = dialog({
                                title: '提示',
                                content: '签名包含敏感词汇' + str + '！请修改后重试...',
                                cancel: false,
                                okValue: '确定',
                                ok: function () {
                                }
                            });
                            $(".ui-dialog-autofocus").css("float", "inherit");
                            $(".ui-dialog-autofocus").css("margin", "0 auto");
                            d.showModal();
                            return false;
                        }
                        else {
                            $("#mysign").hide();
                            $("#mysign_span").show();
                        }
                    }
                });
            }
            else {
                //显示签名
                $("#mysign").hide();
                $("#mysign_span").show();
            }
        });
        var notitleA = true;
    </script>


<?php if (($room['isschool'] == 6 && $check != 1) || ($room['isschool'] == 7)) { ?>
    <style type="text/css">
        .waigme {
            width: 550px;
            height: 290px;
            background-color: gray;
            border-radius: 10px;
            display: none;
        }

        .nelame {
            width: 530px;
            height: 306px;
            margin: 10px;
            float: left;
            display: inline;
            border: 8px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            box-shadow: 0 0 20px #333333;
            opacity: 1;
        }

        .nelame .leficos {
            width: 125px;
            height: 265px;
            float: left;
            background: url(http://static.ebanhui.com/ebh/tpl/default/images/kaitongico0104.jpg) no-repeat 30px 32px;
        }

        .nelame .rigsize {
            width: 375px;
            float: left;
            margin-top: 25px;
        }

        .rigsize .tishitit {
            font-size: 14px;
            color: #d31124;
            font-weight: bold;
            line-height: 30px;
        }

        .rigsize .phuilin {
            line-height: 2;
            color: #6f6f6f;
        }

        .nelame a.kaitongbtn {
            display: block;
            width: 147px;
            height: 50px;
            line-height: 50px;
            background-color: #ff9c00;
            color: #fff;
            text-decoration: none;
            text-align: center;
            font-size: 20px;
            float: left;
            font-family: "微软雅黑";
            font-weight: bold;
            margin-top: 20px;
            border-radius: 5px;
        }

        .nelame a.guanbibtn {
            float: left;
            color: #939393;
            font-size: 14px;
            margin: 40px 0 0 12px;
        }

        .xkcg1s {
            width: 412px;
            height: 175px;
            font-family: 微软雅黑;
            float: left;
        }

        .mycjkclb1s {
            font-size: 16px;
            color: #333;
            text-align: center;
            margin-top: 20px;
        }

        .xkcg1s .p1s {
            color: #999;
            font-size: 12px;
            text-align: center;
            margin: 0;
            padding-top: 10px;
        }

        a.jxxk1s {
            background: #5e8cf1;
            border: 1px solid #5e8cf1;
            border-radius: 3px;
            color: #fff;
            display: block;
            margin: 0 auto;
            font-size: 14px;
            height: 30px;
            line-height: 30px;
            text-align: center;
            width: 110px;
            text-decoration: none;
        }

        .xuanbtn2s {
            margin-top: 20px;
        }

    </style>
    <script type="text/javascript">
        function opencountdiv() {
            if (!H.get('dialogoc')) {
                H.create(new P({
                    id: 'dialogoc',
                    title: '信息提示',
                    easy: true,
                    width: 420,
                    padding: 5,
                    content: $('#opencount')[0]
                }), 'common').exec('show');
            } else {
                H.get('dialogoc').exec('show')
            }
        }
        var iname = "";
        var iurl = "";
        function setiinfo(siname, siurl) {
            if (siname != undefined)
                iname = siname;
            if (siurl != undefined)
                iurl = siurl;
            if (iname != "") {
                $(".tishitit").html("对不起，您还未开通 " + iname + " 或服务已到期。");
            }
        }
        function openonline() {
            if ($("#agreement").is(':checked') != true) {
                alert("请先阅读并同意《e板会用户支付协议》。");
                return;
            }
            var url = "myroom.html?url=/myroom/college/study.html";
            if (iurl != "")
                url = iurl;
            document.location.href = url;

        }
        function closeWindows() {
            var browserName = navigator.appName;
            var browserVer = parseInt(navigator.appVersion);
            if (browserName == "Microsoft Internet Explorer") {
                var ie7 = (document.all && !window.opera && window.XMLHttpRequest) ? true : false;
                if (ie7) {
                    window.open('', '_parent', '');
                    window.close();
                }
                else {
                    this.focus();
                    self.opener = this;
                    self.close();
                }
            } else {
                try {
                    this.focus();
                    self.opener = this;
                    self.close();
                }
                catch (e) {

                }

                try {
                    window.open('', '_self', '');
                    window.close();
                }
                catch (e) {

                }
            }
        }
    </script>

    <div class="xkcg1s" id="opencount" style="display:none;">
        <div class="mycjkclb1s tishitit">对不起，您尚未开通课程或课程已到期</div>
        <p class="p1s">开通课程后，您就可以随时地在网校使用在线学习、</p>

        <p class="p1s">做作业、互动答疑等所有功能了。</p>

        <div class="xuanbtn2s">
            <a href="javascript:void(0)" onclick="openonline()" class="jxxk1s">去开通</a>
        </div>
    </div>


    <div class="nelame" style="display:none;">
        <div style="width:530px;height:300px;background:#fff;">
            <div class="leficos">
            </div>
            <div class="rigsize">
                <h2 class="tishitit">对不起，您还未开通学习和作业功能或服务已到期。</h2>

                <p style="font-weight:bold;">开通后您可以在学习课程和我的作业里进行在线学习和作业。</p>

                <p class="phuilin">在云教学网校，您可以随时随地在线学习、预习新课，复习旧知、记录和向老师提交笔记、在线做作业、在错题集里巩固错题、在线答疑、查看学习表、与老师，同学互动交流等。</p>

                <div class="czxy" style="padding-left:0px;padding-top:10px;">
                    <input name="agreement" id="agreement" type="checkbox" value="1" checked="checked"/>
                    <label for="agreement" style="font-weight:bold;">我已阅读并同意《<a
                            href="<?= geturl('agreement/payment') ?>" target="_blank"
                            style="color:#00AEE7;">e板会用户支付协议</a>》
                    </label>
                </div>
            </div>

            <a href="javascript:openonline();" class="kaitongbtn">在线开通</a>
            <a href="<?= geturl('myroom') ?>" class="guanbibtn">返回首页</a>
        </div>
    </div>
<?php } ?>

<?php if (!isApp() && empty($nophoto) && ($room['isschool'] == 3 || $room['isschool'] == 6 || $room['isschool'] == 7)) { ?>
    <style type="text/css">
        .waigmes {
            width: 355px;
            height: 190px;
            background-color: gray;
            opacity: .80;
            filter: Alpha(Opacity=80);
            border-radius: 10px;
        }

        .nelames {
            width: 335px;
            height: 170px;
            background-color: #FFFFFF;
            margin: 10px;
            float: left;
            display: inline;
        }

        .nelames .leficoss {
            width: 135px;
            height: 128px;
            float: left;
            margin: 10px 0 0 10px;
        }

        .nelames .rigsizes {
            width: 170px;
            float: left;
            margin-top: 10px;
        }

        .rigsizes .tishitits {
            font-size: 14px;
            color: #212121;
            font-weight: bold;
            line-height: 22px;
        }

        .rigsizes .phuilin {
            line-height: 1.8;
            color: #6f6f6f;
        }

        .czxy input {
            vertical-align: middle;
        }

        .toptites {
            background: url(http://static.ebanhui.com/ebh/tpl/default/images/titbgt.jpg) repeat-x;
            height: 28px;
            line-height: 28px;
            font-size: 14px;
            font-weight: bold;
            padding-left: 5px;
            position: relative;
            width: 330px;
            color: #212121;
        }

        .toptites a.guanbtn {
            background: url(http://static.ebanhui.com/ebh/tpl/default/images/guanbibtn.jpg) no-repeat;
            display: block;
            width: 24px;
            height: 24px;
            right: 2px;
            top: 2px;
            position: absolute;
        }

        .rigsizes a.chuanicobtn {
            display: block;
            width: 152px;
            color: #212121;
            height: 30px;
            line-height: 30px;
            background: url(http://static.ebanhui.com/ebh/tpl/default/images/chuanbtnbg.jpg) repeat-x;
            font-size: 14px;
            text-align: center;
            text-decoration: none;
        }
    </style>
    <script type="text/javascript">
        var hastip = 0;
        function phototip(div) {
            if (hastip == 0) {
                showDivModel(div);
            }
            hastip = 1;
        }
        function closeDivModel(div) {
            $('.logDialog').remove();
            $('.waigmes').remove();
        }

        $(function () {
            <?php if(empty($nophoto) && empty($user['face']) && ($room['isschool'] == 3 || $room['isschool'] == 6 || $room['isschool'] == 7) && $room['crid']!=10420 && !$is_zjdlr) { ?>
            phototip(".waigmes");
            <?php }?>
            $(".guanbtn").click(function () {
                closeDivModel(".waigmes");
            });
            $("#phptotip").click(function () {
                if ($("#phptotip").is(':checked')) {
                    setCookie('ebh_nophoto', 1, 360);
                } else {
                    setCookie('ebh_nophoto', 0, 360);
                }
            });
        });
    </script>

    <?php
    if ($user['sex'] == 1)
        $defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
    else
        $defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';

    ?>
    <div class="waigmes" style="display:none">
        <div class="nelames">
            <div class="toptites">系统消息<a href="javascript:void(0);" class="guanbtn"></a></div>
            <div class="leficoss">
                <a href="<?= geturl('/homev2/profile/avatar.html?ht=1') ?>" title="上传我的头像" target="mainFrame"
                   onclick="closeDivModel('.waigmes');"><img src="<?= $defaulturl ?>"/></a>
            </div>
            <div class="rigsizes">
                <h2><?= shortstr(empty($user['realname']) ? $user['username'] : $user['realname'], 12) ?>您好：</h2>

                <p class="phuilin">系统建议你修改自己的头像，<br/>以便老师、同学更好的找到你。</p>
                <a href="<?= geturl('/homev2/profile/avatar.html?ht=1') ?>" target="mainFrame" class="chuanicobtn"
                   onclick="closeDivModel('.waigmes');">上传我的头像</a>

                <div class="czxy" style="padding-left:0px;padding-top:10px;">
                    <input id="phptotip" type="checkbox" value="1" name="phptotip">
                    <label for="phptotip" style="font-weight:bold;">
                        下次不再提示
                    </label>
                </div>
            </div>

        </div>
    </div>
<?php } ?>
<?php if ($roominfo['domain'] == 'zjgxedu') { ?>
    <div id="allclear" style="display:none;font-size:20px;margin-top:30px;text-indent:20px">
        恭喜你，已经获得浙江省高校青年教师岗位培训网络学习学时认证 ，<a style="color:red" href="http://zjzx.zjnu.edu.cn/bm/" target="_blank">点击此处</a>了解考试详情。
    </div>
    <script>
        function showallclear() {
            H.create(new P({
                id: 'showallclear',
                content: $('#allclear'),
                width: 850,
                height: 100,
                title: '恭喜',
                easy: true
            }), 'common').exec('show');
        }
    </script>
<?php } ?>
    <script type="text/javascript">
        $(function () {
            var url = '<?= geturl('myroom/userstate')?>';
            var type = [1, 2, 4, 7, 8];

            $.ajax({
                type: 'POST',
                url: url,
                data: {"type": type},
                dataType: "json",
                success: function (data) {
                    if (data != undefined && data[1] != undefined && data[1] > 0) {
                        var examcount = data[1] > 99 ? 99 : data[1];
                        $("a[href='/college/myexam/all.html']").append("<span>" + examcount + "</span>");
                    }
                    if (data != undefined && data[2] != undefined && data[2] > 0) {
                        var askcount = data[2] > 99 ? 99 : data[2];
                        $(".xxuexi").append("<span>" + askcount + "</span>");
                    }
                    if (data != undefined && data[4] != undefined && data[4] > 0) {
                        var askcount = data[4] > 99 ? 99 : data[4];
                        $(".ttiwen").append("<span>" + askcount + "</span>");
                    }
                    if (data != undefined && data[7] != undefined && data[7] > 0) {
                        var examcount = data[7] > 99 ? 99 : data[7];
                        $(".kkaoshi").append("<span>" + examcount + "</span>");
                    }
                    if (data != undefined && data[8] != undefined && data[8] > 0) {
                        var activecount = data[8] > 99 ? 99 : data[8];
                        $(".activity").append("<span class=''>" + activecount + "</span>");
                    }
                }
            });

        });

        $(function () {

            if($("a[href='/college/examv2.html']").length == 0)
                return false;
            var url = '<?= geturl('college/examv2/unfishCount')?>';

            $.ajax({
                type: 'POST',
                url: url,
                dataType: "json",
                success: function (data) {
                    if (data != undefined && data > 0) {//作业2.0
                        var examcount = data > 99 ? 99 : data;
                        $("a[href='/college/examv2.html']").append("<span>" + examcount + "</span>");
                    }
                }
            });
        });
        // 未参加的互动数
        $(function () {

            if($("a[href='/college/iacourse.html']").length == 0)
                return false;
            var url = '<?= geturl('college/iacourse/unfishCount')?>';

            $.ajax({
                type: 'POST',
                url: url,
                dataType: "json",
                success: function (data) {
                    if (data != undefined && data > 0) {//未参加的互动数
                        var unfishCount = data > 99 ? 99 : data;
                        $("a[href='/college/iacourse.html']").append("<span class='hudong'>" + unfishCount + "</span>");
                    }
                }
            });
        });
        function globalDiaog(params) {
            var d = dialog({
                'title':params.title||'标题',
                'content':params.content||'',
                'onshow':params.onshow||function(){},
                'okValue':params.okValue||"确定",
                'cancelValue':params.cancelValue||"取消",
                'width':460,
                'padding':0,
                'ok':params.ok||function(){ },
                'cancel':params.cancel||function(){}
            });
            d.showModal();
        }
    </script>

	<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/loginlog.js<?=getv()?>" crid="<?=$roominfo['crid']?>" id="loginlogjs"></script>
    <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/table.js"></script>
    <script type="text/javascript">
        function refreshFollowNum() {
            $("#follownum").html(parseInt($("#follownum").html()) + 1);
        }
        function goto(){
            location.href = '';
        }
        function upUnit(unit) {
            $("#zjdlr-unit").html(unit);
        }
    </script>
<?php debug_info();?>
<?php $this->display('common/icp_footer'); ?>