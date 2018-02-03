<div class="topbar">
		<div class="top-bd clearfix">
            <div class="login-info">
			<?php
				$homename = empty($room) ? 'e板会' : $room['crname'];
			?>
			<?php if(empty($user)){?>
			<span style="width:170px; ">您好 欢迎来到<?= $homename ?>！ </span>
			<?php if(empty($room['domain']) || $room['domain'] != 'victor') {?>
			<a href="javascript:tologin('/login.html?returnurl=__url__');">登录</a>
			<a href="javascript:toregister('/register.html?returnurl=__url__');">注册</a>
			<?php } ?>
			<?php }else{?>
			<span style="width:170px; ">您好 <?=$user['username']?> 欢迎来到<?= $homename ?>！ </span><a href="/logout.html">安全退出</a><a href="/" >首页</a>
			<?php }?>
			</div>
			
		</div>
	</div>