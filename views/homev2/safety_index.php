<?php
$ht = $this->input->get('ht');
if ($ht == 1) {
	$this->display('homev2/header1');
} else {
	$this->display('homev2/header');
}
?>
<?php $this->display('homev2/top');?>
<div class="divcontent">
	<div class="conentlft">
	<div class="topbaad">
	<div class="user-main clearfix">
	<div class="lefrig" style="background:#fff;margin-top:10px;width:1000px;">
	<?php $this->display('homev2/small_menu');?>
	<div class="lnarit">
		<ul>
			<li class="jettyus" style="position: relative;">
				<span class="kreye lietba1">手机绑定</span>
				<span style="color:#333;position: absolute;left: 63px;bottom: 10px;">绑定后可以使用手机号登录，密码不变</span>
				<?php if(!empty($bind['is_mobile'])&&($bind['is_mobile']==1)){?>
				<span class="yisabt">已绑定</span>
				<span class="sihatme">您绑定的手机：
				<?php
				$jsonMobile = json_decode($bind['mobile_str'],true);
				
				$mobile = $jsonMobile['mobile'];
				//$mobile = '15803266989';
				$m_3_first = substr($mobile,0, 3);
				$m_4_last = substr($mobile,-4);
				echo $m_3_first.'****'.$m_4_last;
				?>
				</span>
				<a href="javascript:;" class="huisrt bindbtn" data-type="type=mobile&op=change" >更改</a>
				<?php }else{?>
				<span class="akwnth">未绑定</span>
				<span class="sihatme"></span>
				<a href="javascript:;" class="basrte bindbtn" data-type="type=mobile&op=bind">绑定</a>
				<?php }?>

			</li>
			<li class="jettyus" style="position: relative;">
				<span class="kreye lietba2">邮箱绑定</span>
				<span style="color:#333;position: absolute;left: 63px;bottom: 10px;">绑定后可以使用邮箱登录，密码不变</span>
				<?php if(!empty($bind['is_email'])&&($bind['is_email']==1)){?>
				<span class="yisabt">已绑定</span>
				<span class="sihatme">您绑定的邮箱：
				<?php
				$jsonEmail = json_decode($bind['email_str'],true);
				$email = $jsonEmail['email'];
				//$email = '15803266989@163.com';
				$e_3_first = substr($email,0, 3);
				$e_last = substr($email,stripos( $email,'@'));
				echo $e_3_first.'****'.$e_last;
				?>
				</span>
				<a href="javascript:;" class="huisrt bindbtn" data-type="type=email&op=change">更改</a>
				<?php }else{?>
				<span class="akwnth">未绑定</span>
				<span class="sihatme"></span>
				<a href="javascript:;" class="basrte bindbtn" data-type="type=email&op=bind">绑定</a>
				<?php }?>
			</li>
			<li class="jettyus">
			<?php if(!empty($bind['is_qq'])&&($bind['is_qq']==1)){?>
				<span class="kreye lietba3">QQ绑定</span>
				<span class="yisabt">已绑定</span>
				<span class="sihatme">您绑定的QQ昵称:
				<?php 
				$jsonQQ = json_decode($bind['qq_str'],true);
				//var_dump($bind['qq_str']);
				if(!empty($jsonQQ['nickname'])){
					echo $jsonQQ['nickname'];
				}else{
					echo '暂无';
				}
				?></span>
				<a href="javascript:;" class="huisrt bindbtn" data-type="type=qq&op=unbind">解绑</a>
			<?php }else{?>
				<span class="kreye lietba3">QQ绑定</span>
				<span class="akwnth">未绑定</span>
				<span class="sihatme"></span>
				<a href="javascript:;" class="basrte bindbtn" data-type="type=qq&op=bind">绑定</a>
			<?php }?>
			</li>
			<li class="jettyus">
			<?php if(!empty($bind['is_wx'])&&($bind['is_wx']==1)){?>
				<span class="kreye lietba4">微信绑定</span>
				<span class="yisabt">已绑定</span>
				<span class="sihatme">您绑定的微信昵称：
				<?php 
					$jsonWX = json_decode($bind['wx_str'],true);
					if(!empty($jsonWX)){
						echo $jsonWX['nickname'];
					}else{
						echo '暂无';
					}
				?>
				</span>
				<a href="javascript:;" class="huisrt bindbtn" data-type="type=wx&op=unbind">解绑</a>
			<?php }else{?>
				<span class="kreye lietba4">微信绑定</span>
				<span class="akwnth">未绑定</span>
				<span class="sihatme"></span>
				<a href="javascript:;" class="basrte bindbtn" data-type="type=wx&op=bind">绑定</a>
			<?php }?>
			</li>
			<li class="jettyus" style="border-bottom:none">
			<?php if(!empty($bind['is_weibo'])&&($bind['is_weibo']==1)){?>
				<span class="kreye lietba5">微博绑定</span>
				<span class="yisabt">已绑定</span>
				<span class="sihatme">您绑定的微博昵称：
				<?php 
					$jsonWEIBO = json_decode($bind['weibo_str'],true);
					if(!empty($jsonWEIBO['nickname'])){
						echo $jsonWEIBO['nickname'];
					}else{
						echo '暂无';
					}
					
				?>
				</span>
				<a href="javascript:;" class="huisrt bindbtn" data-type="type=weibo&op=unbind">解绑</a>
			<?php }else{?>
				<span class="kreye lietba5">微博绑定</span>
				<span class="akwnth">未绑定</span>
				<span class="sihatme"></span>
				<a href="javascript:;" class="basrte bindbtn" data-type="type=weibo&op=bind">绑定</a>
			<?php }?>
			</li>
		</ul>
	</div>
</div>
</div>
</div>
</div>
   <!-- <div class="cotentrgt">
    	<img src="http://static.ebanhui.com/ebh/tpl/2016/images/rgtimg.jpg" />
    </div>-->
</div>
<script type="text/javascript">
$(function(){
	$(".bindbtn").bind('click',function(){
		var href = "/homev2/safety/bind.html";
		var type = $(this).data('type');
		//console.log(type);
		
		if(type == 'type=qq&op=bind'){
			toLogin('qq');
		}else if(type == 'type=wx&op=bind'){
			toLogin('wx');
		}else if(type == 'type=weibo&op=bind'){
			toLogin('sina');
		}else if(/unbind/.test(type)){
			var tval = type.split('&').shift();
			var vtype =tval.split('=').pop();
			//if(confirm("确定要进行解绑吗?")){
				var d = dialog({
					title: '信息提示',
					content: '确定要进行解绑吗？',
					width:350,
					okValue: '确定',
					ok: function () {
						this.close().remove();
						$.ajax({
						url:'/homev2/safety/unbind.html',
						type:'POST',
						dataType:'json',
						data:{type:vtype},
						success:function(json){
							if(json.status){
								//解绑成功
								var d = dialog({
							        skin:"ui-dialog2-tip",
							        width:350,
							        content: "<div class='TPic'></div><p>已成功解绑！</p>",
									onshow:function(){
										var that=this;
										setTimeout(function () {
											that.close().remove();
											location.reload();
											}, 1000);
									}
								});
								d.showModal();
							}else{
								//解绑失败	
								var d = dialog({
							        skin:"ui-dialog2-tip",
							        width:350,
							        content: "<div class='FPic'></div><p>解绑失败！</p>",
									onshow:function(){
										var that=this;
										setTimeout(function () {
											that.close().remove();
											}, 1000);
									}
								});
								d.showModal();
							
							}
						},
						error:function(){
							}	
						});
					},
					cancelValue: '取消',
					cancel: function () {}
				});
				d.showModal();
				
			//}
		}else{
			location.href=href+'?'+type+<?=empty($hidetop)?'""':'"&ht=1"'?>;
		}
		
	});

	   var childWindow;
       function toLogin(id){
          	var returnurl = encodeURI(document.location.toString()+"?callback=bind_success");
            var href="http://www.ebh.net/otherlogin/"+id+".html?returnurl="+returnurl;
           childWindow = window.open(href,"_blank", "toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=620,height=550");
        }
})
</script>
<?php $this->display('homev2/footer');?>