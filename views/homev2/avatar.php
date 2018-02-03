<?php
    $ht = $this->input->get('ht');
    if ($ht == 1) {
		$this->display('homev2/header1');
	} else {
		$this->display('homev2/header');
	}
?>
<?php $this->display('homev2/top'); ?>
<div class="divcontent">
	<div class="conentlft">
	<div class="topbaad">
	<div class="user-main clearfix">
	<div class="lefrig" style="background:#fff;margin-top:10px;width:1000px;">
	<?php $this->display('homev2/small_menu');?>
	<?php
	$domain=$this->uri->uri_domain();
	$uid=$user['uid'];
	$url=urlencode('/static/flash/xml/photoOnLine.xml');
	$returnurl=urlencode('http://'.$domain.'.ebanhui.com/home/profile/profile.html');
	$resurl=urlencode('/static/flash/avatarRES.swf');
	// $picurl = urlencode('http://'.$domain.'.ebanhui.com/avatar.html?uid='.$uid);
	$picurl = urlencode($picurl);
	if(empty($user['face'])){
		 if($user['sex']==1){
			if($user['groupid']==5){
				$initpicurl=urlencode('http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg');
			}else{
				$initpicurl=urlencode('http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg');
			}
		}else{
			if($user['groupid']==5){
				$initpicurl=urlencode('http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg');
			}else{
				$initpicurl=urlencode('http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg');
			}
		 }
	}else{
		$initpicurl=urlencode($user['face']);
	}
	?>
	<object type="application/x-shockwave-flash" data="/static/flash/photoOnline.swf" width="747"
			height="510" id="blog_index_flash_ff">
			<param name="quality" value="high" />
			<param name="FlashVars" value="url=<?=$url?>&returnurl=<?=$returnurl?>&uid=<?=$uid?>&resurl=<?=$resurl?>&picurl=<?=$picurl?>&initpicurl=<?=$initpicurl?>" />
			<param name="wmode" value="transparent" />
			<param name="menu" value="false">
			<param name="allowScriptAccess" value="sameDomain" />
			<param name="allowFullScreen" value="true" />
			<param name="movie" value="/static/flash/photoOnline.swf" /><!--兼容ie6-->
	</object>
		</div>
	</div>
</div>
</div>
<!--<div class="cotentrgt">
<img src="http://static.ebanhui.com/ebh/tpl/2016/images/rgtimg.jpg" />
</div>-->
</div>
<script type="text/javascript">
	function pliushFun(){//刷新
		window.location.reload(); 
	}
	$(function(){
		top.$('#mainFrame').width(1000);
		top.$('.rigksts').hide();
	})
</script>
<?php $this->display('homev2/footer');?>