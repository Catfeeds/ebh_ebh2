<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$room['crname']?></title>
</head>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css?v=20160524001"/>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<body>
<div class="wrap">
	<div class="cmain">
    	<div class="cmain_top mt10">
        	<div class="cmain_top_l fl">
            	<div class="xiutgt fr mt10"><span style="padding-left:15px;"><?=$clinfo['title']?></span></div>
                <div class="clear"></div>
                <div class="gerenxinxi">
                	<div class="touxiang fl"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/touxiang1s.jpg" height="78" width="78" /></div>
                    <div class="rigpxiang ml10 fl">
                    	<div class="mt5">
                        	<p class="name fl"><?=$user['realname']?></p>
                            <p class="jifen fl">500</p>
                        </div>
                        <div class="clear"></div>
                        <div class="ejiants">
                        	<p class="gerenxx"><a href="#">个人信息</a></p>
							<div>
                            	<div class="kewate fl"><span class="jifenico" style="width:<?=$percent?>%"></span></div>
								<div class="fl" ><span style=" line-height:10px; color: #999;font-family: Arial; padding-left:5px;"><?=$percent?>%</span></div>
                            </div>
						</div>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="qianming"><p class="qianmings">这位同学很懒，什么都没留下</p></div>
                <div class="gzfs">
                	<div class="fl"><span class="span1s">0</span><br /><span class="span2s">关注</span></div>
                    <div class="fr"><span class="span1s">12</span><br /><span class="span2s">粉丝</span></div>
                </div>
            </div>
            <div class="cmain_top_r fr">
            	<div>
                    <div class="titles fl">
                        <span>2015年绍兴名师高考专题复习冲刺加分课</span>
                    </div>
					<?php if(!empty($signed)){
							$showsign[0] = ' style="display:none"';
							$showsign[1] = '';
						}else{
							$showsign[0] = '';
							$showsign[1] = ' style="display:none"';
						}
						$weekarr = array('日','一','二','三','四','五','六');
					?>
                	<div class="grkgee fr">
						<span class="dgrtwe">周<?=$weekarr[Date('w',SYSTIME)]?><p><?=Date('m/d',SYSTIME)?></p></span>
			<span id="creditplus" style="display:none;position:absolute;color:orange;right:35px;top:72px;">+1积分</span>
			<a href="javascript:void(0)" class="daotqian" onclick="signin()" <?=$showsign[0]?>>签到</a>
			<span class="daotqian2" <?=$showsign[1]?> title="已经连续签到<?=$continuous?>天" day="<?=$continuous?>">已签到</span>
					</div>
                </div>
                <div class="clear"></div>
                <div class="esukang">
                	<a  class="zzhuye fl" href="#"></a>
					<a  class="xxuexi fl" href="#"><span id="myspan">2</span></a>
					<a  class="zzuoye fl" href="#"></a>
					<a class="ttiwen fl" href="#"></a>
					<a class="kkaoshi fl" href="#"></a>
                    <a class="mores fl" href="#"></a>
				</div>
            </div>
        </div>
        <div class="clear"></div>