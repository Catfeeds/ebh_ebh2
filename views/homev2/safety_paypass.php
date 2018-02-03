<?php
    $room = Ebh::app()->room->getcurroom();
    $domain = empty($room['domain'])?'':$room['domain'];
    $room['crid'] = empty($room['crid'])?0:$room['crid'];
    if(!empty($room['crid'])){
    	$appsetting = Ebh::app()->getConfig()->load('othersetting');
        $appsetting['zjdlr'] = !empty($appsetting['zjdlr']) ? $appsetting['zjdlr'] : 0;
        $appsetting['newzjdlr'] = !empty($appsetting['newzjdlr']) ? $appsetting['newzjdlr'] : array();
        $is_zjdlr = ($room['crid'] == $appsetting['zjdlr']) || (in_array($room['crid'],$appsetting['newzjdlr']));
        $is_newzjdlr = in_array($room['crid'],$appsetting['newzjdlr']); 
    }else{
   	    $is_zjdlr = false;
        $is_newzjdlr = false;
    }
if ($is_zjdlr) {
	$this->display('homev2/header1');
}else {
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
			<li class="jettyus" style="border-bottom:none">
			<?php if(!empty($bind['is_paypass'])&&($bind['is_paypass']==1)){?>
			   <span class="kreye lietba6">支付密码</span>
	           <span class="yisabt">已绑定</span>
	           <?php $payObj = json_decode($bind['paypass_str'],true);?>
	           <?php $levelArr = array('0'=>'弱','1'=>'一般','2'=>'很好','3'=>'极好');?>
	           <?php if($payObj['level']<2){?>
	           <span class="sihatme">安全强度：<?=$levelArr[$payObj['level']]?> 建议您设置更高强度的密码</span>
	           <?php }else{?>
	           <span class="sihatme">安全强度：<?=$levelArr[$payObj['level']]?> 。 </span>
	           <?php }?>
	           <a class="huisrt bindbtn" href="javascript:;" data-type="type=paypass&op=edit">更改</a>
			<?php }else{?>
			    <span class="kreye lietba6">支付密码</span>
           		<span class="akwnth">未设置</span>
				<span class="sihatme"></span>
				<a href="javascript:;" class="basrte bindbtn" data-type="type=paypass&op=bind">设置</a>
			<?php }?>
	         </li>
		</ul>
	</div>
</div>
</div>
</div>
</div>
    <!--<div class="cotentrgt">
    	<img src="http://static.ebanhui.com/ebh/tpl/2016/images/rgtimg.jpg" />
    </div>-->
</div>
<script type="text/javascript">
$(function(){
	$(".bindbtn").bind('click',function(){
		var href = "/homev2/safety/paypass.html<?=empty($hidetop)?'':'?ht=1'?>";
		var type = $(this).data('type');
		//先验证是否绑定了手机号
		$.ajax({
			url:href,
			data:{op:'checkmobilebind'},
			dataType:'json',
			type:'GET',
			success:function(json){
				if(json.code){
					location.href=href+'?'+type;
				}else{		
					top.dialog({
				        skin:"ui-dialog2-tip",
				        width:350,
				        content: "<div class='PPic'></div><p>设置支付密码前,请先绑定您的手机号</p>",
						onshow:function(){
							var that=this;
							setTimeout(function () {
								location.href="/homev2/safety/bind.html?type=mobile&op=bind<?=empty($hidetop)?'':'&ht=1'?>";
								that.close().remove();
							}, 2000);
						}
					}).show();
				}
			}
		});
	
		//console.log(type);

	});


})
</script>
<?php $this->display('homev2/footer');?>