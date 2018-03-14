<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/2014/css/lingxiao.css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js?version=20150528001"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xform.js"></script>
<?php $systemsetting = Ebh::app()->room->getSystemSetting(); ?>
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<title><?=$room['crname']?></title>
<style>
    .sktztoat,.sotpadd{
        line-height: 40px;
    }
</style>
</head>

<body>
<?php $this->display('common/up_header'); ?>
<div class="latsds">
	<div class="neikats">
    	<div class="kstdyh">
        <!--登录前-->
		<?php if(!empty($user)) {
			$sex = empty($user['sex']) ? 'man' : 'woman';
            $type = $user['groupid'] == 5 ? 't' : 'm';
            $defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/'.$type.'_'.$sex.'.jpg';
            $face = empty($user['face']) ? $defaulturl : $user['face'];
            $facethumb = getthumb($face,'78_78');
			if($room['uid'] == $user['uid']){
				$url = geturl('aroomv2');
			}else{
				$url = $user['groupid'] == 5 ? geturl('troom') : geturl('myroom');
            }
			?>
			<div class="dsyghd">
                <div class="fdhdty">
                    <img src="<?= $facethumb ?>"></div>
                <div class="shoswtu">
                    <h2 class="kstyuds"><?=$user['username']?></h2>
                    <p>上次登录时间：</p>
                    <p><?= $user['lastlogintime']?></p>
                </div>
            </div>
			
            <div class="kestyr">
            	<a href="/logout.html" class="tiusbtn"></a>
                <a href="<?=$url?>" class="jinstbtn"></a>
            </div>
		<?php }else{?>
		<form id="form1" name="form1" action="/login.html?inajax=1&login_from=classroom" onsubmit="form_submit();return false;">
                    <input type="hidden" name="loginsubmit" value="1" />

		<div class="kestyr">
            	<span class="kstyu">账号：</span>
            	<input class="sktztoat" type="text" x_hit="请输入账号" value="" name="username" id="username" />
            </div>
        	<div class="kestyr elwidth">
            	<span class="kstyu">密码：</span>
            	<input class="sotpadd" type="password" name="password" x_hit="请输入密码" id="password" />
            </div>
            <p class="laswt">
                <input type="checkbox" checked="checked" value="1" name="cookietime" style="vertical-align: middle;">
                <label for="cookietime">下次自动登录</label>
                <a class="etgdfr" href="/forget.html">忘记密码？</a>
            </p>
            <div class="kestyr">
				<input class="ludsbtn" type="submit" name="Submit" value="" />
            </div>
		</form>
        <script>
            $(function(){
                var _xform = new xForm({
                    domid:'form1',
                    errorcss:'cuotic',
                    okcss:'zhengtic',
                    showokmsg:false
                });
            });
        </script>
		<?php }?>
            <!--登录后-->
			<!--
            
			-->
        </div>
    </div>
</div>

<?php
    $this->display('common/footer');
    ?>
