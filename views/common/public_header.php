<div class="topbar">
	<div class="top-bd clearfix">
                <?php 
//				if($room['template'] == 'one' || $room['template'] == 'scb')
//					$hidesome = 1;
				if(empty($user)) { ?>
		<div class="login-info"><span style="width:100px; "> <?=($room['domain'] != 'jx')?'欢迎来到'.$room['crname'].'！':'欢迎来到嘉兴市智慧教育在线课堂'?> </span><!--<?php if(empty($hidesome)){?><a target="_blank" href="http://www.ebh.net/">e板会首页</a><?php }?>-->
		<?php if($room['domain'] != 'jx'){?>
		<a href="javascript:tologin('/login.html?returnurl=__url__');">登录</a><a href="javascript:toregister('/register.html?returnurl=__url__');">注册</a>
		<?php }?>
			<?php
				$Uproom = Ebh::app()->lib('Uproom');
				echo $Uproom->getUproom();
			?>
				</div>
                <?php } else { 
                    $isadmin = ($user['uid'] == $room['uid'] && $room['isschool'] == 5) ? 1 : 0;
                ?>
                <div class="login-info"><span style="width:170px; ">您好 <?= $user['username'] ?> <?=($room['domain'] != 'jx')?'欢迎来到'.$room['crname'].'！':'欢迎来到嘉兴市智慧教育在线课堂'?> </span><?php if ($isadmin == 1) { ?><a style="color:red;" href="/croom.html">管理后台</a><?php } ?><a href="/logout.html">安全退出</a><!--<?php if(empty($hidesome)){?><a target="_blank" href="http://www.ebh.net/">e板会首页</a><?php }?>-->
				<?php
					$Uproom = Ebh::app()->lib('Uproom');
					echo $Uproom->getUproom();
				?></div>
				
                <?php } ?>
		<?php if($room['domain'] != 'zjgxedu') {?>
		<ul class="quick-menu">
		<li><a href="http://jiazhang.ebh.net/" target="_blank" class="cent">家长监控平台</a></li>
		<li><a target="_blank" class="cent" href="http://soft.ebh.net/ebhbrowser.exe">锁屏浏览器</a></li>
		<li><a target="_blank" class="cent" href="<?=geturl('intro/app')?>">APP应用</a></li>
		<li><a href="javascript:void(0);" onclick="SetHome(this,window.location);" class="cent">设为主页</a></li>

		
		</ul>
		<?php } ?>
	</div>
</div>
<script type="text/JavaScript">
	var tologin = function(url){
		url = url.replace('__url__',encodeURIComponent(location.href));
		location.href=url;
	}
	var toregister = function(url){
		url = url.replace('__url__',encodeURIComponent(location.href));
		location.href=url;
	}

</script>