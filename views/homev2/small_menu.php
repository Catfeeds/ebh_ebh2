	<?php 
	$uri = $this->uri;
	$controller = $uri->uri_control();
	$action = $uri->uri_method();
//var_dump($controller);
//var_dump($action);
	?>
	<style>
	.weaktil{
		height:42px;
		padding-top:5px;
	}
	.weaktil ul li, .weaktil .datek{
		display: inline;
		float: left;
		font-size: 14px;
		line-height: 33px;
		margin: 0 15px;
		padding: 9px 0 0;
		width:90px;
	}
	.weaktil ul li a {
		color: #666;
		font-family: 微软雅黑;
		font-size: 16px;
	}
	.weaktil .datek a {
		background:url("http://static.ebanhui.com/ebh/tpl/default/images/workcurrent.jpg") no-repeat scroll right 0;
		color: #2696f0;
		display: block;
		padding: 0 12px 0 0;
	}
	.weaktil .datek a span {
		background:url("http://static.ebanhui.com/ebh/tpl/default/images/workcurrent.jpg") no-repeat scroll left 0;
		color: #2696f0;
		display: block;
		padding: 0 0 0 12px;
	}
	a:link{
        text-decoration: none;
    }
	</style>
  	<div style=" margin-bottom:10px; width:1000px;" class="weaktil">
		<ul>
			<?php
	        $roominfo = Ebh::app()->room->getcurroom();
	        $roominfo['crid'] = empty($roominfo['crid'])?0:$roominfo['crid'];
	        if(!empty($roominfo['crid'])){
	        	$appsetting = Ebh::app()->getConfig()->load('othersetting');
		        $appsetting['zjdlr'] = !empty($appsetting['zjdlr']) ? $appsetting['zjdlr'] : 0;
		        $appsetting['newzjdlr'] = !empty($appsetting['newzjdlr']) ? $appsetting['newzjdlr'] : array();
		        $is_zjdlr = ($roominfo['crid'] == $appsetting['zjdlr']) || (in_array($roominfo['crid'],$appsetting['newzjdlr']));
		        $is_newzjdlr = in_array($roominfo['crid'],$appsetting['newzjdlr']); 
        	}else{
        		$is_zjdlr = false;
	        	$is_newzjdlr = false;
        	}
			$ht = $this->input->get('ht');

			?>
			<li class="<?php if(($controller=='profile')&&($action=='profile')){ echo 'datek';}?>" ><a href="/homev2/profile/profile.html<?=empty($hidetop)?'':'?ht=1'?>"><span>基本信息</span></a></li>
			<?php if(!$is_zjdlr) { ?>
			<li class="<?php if(($controller=='profile')&&($action=='avatar')){ echo 'datek';}?>" ><a href="/homev2/profile/avatar.html<?=empty($hidetop)?'':'?ht=1'?>"><span>修改头像</span></a></li>
			<?php } ?>
			<li class="<?php if(($controller=='profile')&&($action=='pass')){ echo 'datek';}?>" ><a href="/homev2/profile/pass.html<?=empty($hidetop)?'':'?ht=1'?>"><span>修改密码</span></a></li>
			<?php if($user['groupid']==6 && (!$is_zjdlr)){?>
				<li class="<?php if(($controller=='profile')&&($action=='msg')){ echo 'datek';}?>" ><a href="/homev2/profile/msg.html<?=empty($hidetop)?'':'?ht=1'?>"><span>服务记录</span></a></li>
			<?php }?>
            <?php if(!$is_zjdlr) { ?>
				<li class="<?php if(($controller=='safety')&&(($action=='index')||($action=='bind'))){ echo 'datek';}?>" ><a href="/homev2/safety/index.html<?=empty($hidetop)?'':'?ht=1'?>"><span>安全设置</span></a></li>
            <?php } ?>
    		<?php if((!$is_zjdlr)){ ?>
			<li class="<?php if(($controller=='safety')&&($action=='paypass')){ echo 'datek';}?>" ><a href="/homev2/safety/paypass.html<?=empty($hidetop)?'':'?ht=1'?>"><span>支付密码</span></a></li>
			<?php } ?>
		</ul>
	</div>
	<div class="clear"></div>