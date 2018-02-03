<?php $this->display('homev2/header'); ?>
<?php $this->display('homev2/top');?>
<div class="divcontent">
    <div class="jetke">
<?php $this->display('homev2/purse_menu');?>
        <h2 class="etjudt" style="margin:10px 0 0 0">银行卡最多绑定10张</h2>
        <div class="wordent">
        	<?php if(!empty($mybank)){ ?>
        	<?php foreach ($mybank as $key=>$item){?>
	        	<div id="div_<?=$key?>" class="<?=$bank[$item['bindex']]['class']?> keyang">
	            	<span class="kaid"><a href="javascript:;" class="jsbte" data="<?=$item['bindex']?>#<?=$item['khname']?>#<?=$item['account']?>"></a><span class="xiast">**** **** ****</span><?=substr($item['account'],-4,4)?></span>
	            </div>
            <?php } ?>
            <?php } ?>
            <!-- 银行卡满十张不显示添加银行卡链接 -->
            <div id="bindbtn" class="keyang" <?php if(count($mybank) > 9){ ?> style="display: none" <?php } ?>>
            	<a href="<?=geturl('homev2/purse/bindbank')?>"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/yitast.jpg" /></a>
            </div>
        </div>
    </div>
    <div id="bindtc" class="khrery">
    <!-- 解绑银行卡号、解绑目标div -->
	    <input id="bindexval" type="hidden" value="0">
	    <input id="todiv" type="hidden" value="">
	</div>
</div>
<script language="javascript">
$(function(){

	$('.jsbte').on('click',function(){
		var data = $(this).attr('data'),
		todiv = $(this).parent().parent().attr('id');
		$('#bindexval').val(data);
		$('#todiv').val(todiv);
		var d = dialog({
			title:"信息提示",
			content:"是否解除绑定",
			width:300,
			cancel:function(){
				this.close().remove();
			},
			cancelValue:"取消",
			ok:function(){
				var data = $('#bindexval').val(),
				todiv = $('#todiv').val();
				H.get('tipbindtc') && H.get('tipbindtc').exec('close');
				$.post('/homev2/safety/unbindbank.html',{data:data},function(data){
					if(data.code == 1){
						$('#'+todiv).remove();
						if($('#bindbtn').is(':hidden')){
							$('#bindbtn').show();
						}
					}else{
						var d = dialog({
					        skin:"ui-dialog2-tip",
					        width:350,
					        content: "<div class='FPic'></div><p>解绑失败</p>",	
							onshow:function(){
								var that=this;
								setTimeout(function () {
									that.close().remove();
								}, 1000);
							}
						});
						d.showModal();
					}
				},'json');
				
			},
			okValue:"确定"
		});
		d.showModal();
	})
})
</script>
<?php $this->display('homev2/footer');?>