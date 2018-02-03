<?php $this->display('homev2/header'); ?>
<?php $this->display('homev2/top');?>
<div class="divcontent">
    <div class="jetke">
<?php $this->display('homev2/purse_menu');?>
        <h2 class="etjudt" style="margin:10px 0;">银行卡绑定暂时只支持10家银行的借记卡</h2>
        <div id="myform" class="wordent">
            <span class="ketet">绑定银行卡</span>
            <div class="bsdtrs">
            	<span class="leftxt">持卡人姓名：</span>
                <div class="rigtxt">
               		<input class="lisste grey" name="khname" type="text" id="khname" maction="check_khname" x_hit="开户人姓名" x_func="check"/>
                </div>
            </div>
            <div class="bsdtrs">
            	<span class="leftxt">银行卡卡号：</span>
                <div class="rigtxt">
               		<input class="lisste grey" name="yhaccount" type="text" id="yhaccount" maction="check_yhaccount" x_hit="银行卡号" x_func="check"/>
                </div>
            </div>
            <div class="bsdtrs">
            	<span class="leftxt">银行卡名称：</span>
                <div class="rigtxt">
               		<div id="xhwrap" class="kstdg">
                        <span class="vholder" tag="0">请选择银行</span>
                        <div class="liawtlet" style="max-height: 260px; width: 248px; overflow-y: auto; display: none;">
                        	<?php foreach ($bank as $k=>$v){ ?>
                            <a class="chver_option" href="javascript:;" tag="<?=$k?>" title="<?=$v['name']?>"><?=$v['name']?></a>
                            <?php } ?>
                        </div>
                        <input id="yhname" name="yhname" maction="check_yhname" x_func="check" x_msgid="yhname_msg" type="hidden" value="-1">
                    </div>
                    <span id="yhname_msg"></span>
                </div>
            </div>
            <a href="javascript:;" class="lanlsbtn leftop">同意协议并确定</a>
            <a target="_blank" href="<?=geturl('agreement/payment')?>" class="hwrehu">《用户支付协议》</a>
        </div>
    </div>
</div>
<!-- 绑定提示框 
<div id="successmsg" class="khrery">
	<h2 class="kester">绑定成功</h2>
</div>
<div id="errormsg" class="khrery">
	<h2 class="kester">绑定失败</h2>
</div>
<div id="repeatmsg" class="khrery">
	<h2 class="kester">同一类型银行卡只能绑定一次</h2>
</div>
<div id="xianzhimsg" class="khrery">
	<h2 class="kester">绑定银行卡张数不能超出10张</h2>
</div>-->
<script language='javascript'>
//后台校验
function check(obj){
    var data = _xform.getdata();   
    var action = $(this).attr('maction');
    obj.res = 0;
    if(action == 'check_khname'){
    	if($.trim(data.khname) == ''){
    		obj.res = -1;
    		obj.msg = '开户人姓名不能为空';
        }
    }else if(action == 'check_yhaccount'){
		var reg = /^\d{16,19}$/g;
		if(!reg.test(data.yhaccount)){
			obj.res = -1;
			obj.msg = '银行卡号为16-19位数字';
		}
    }else if(action == 'check_yhname'){
		if(parseInt(data.yhname) <=0 ){
			obj.res = -1;
			obj.msg = '银行名字不能为空';
		}	
    }
}
$(function(){
	//绑定成功后的跳转
	var rurl = "<?=$isbank?>" == "1" ? "<?=geturl('homev2/purse/bank')?>" : "<?=geturl('homev2/purse/applycash')?>";
	
	//验证框架初始化
	window._xform = new xForm({
		domid:'myform',
		errorcss:'cuotic',
		showokmsg:false
	});
	//银行卡选择
	$('#xhwrap').on('click',function(){
		$('#xhwrap .liawtlet').toggle();
	})
	$('#xhwrap .chver_option').on('click',function(){
		var title = $(this).attr('title'),
			tag = $(this).attr('tag');
		$('#xhwrap .vholder').html(title);
		$('#xhwrap .vholder').attr('tag',tag);
		$('#yhname').val(tag);
		$('#yhname').trigger('blur');
	})
	//绑定银行卡处理
	$('.lanlsbtn').on('click',function(){
		var data = _xform.getdata();
		var ret = _xform.check();
		if(ret){
			$.post('/homev2/safety/bindbank.html',{data:data},function(data){
				if(data.code == 1){
					/*var d = dialog({
				        skin:"ui-dialog2-tip",
				        width:350,
				        content: "<div class='TPic'></div><p>绑定成功</p>",	
						onshow:function(){
							var that=this;
							setTimeout(function(){
								that.close().remove();
							},1000);
							location.href = rurl;
						}
					});
					d.showModal();*/
					location.href = rurl;
				}else if(data.code == -3){
					var d = dialog({
				        skin:"ui-dialog2-tip",
				        width:350,
				        content: "<div class='FPic'></div><p>绑定银行卡张数不能超出10张</p>",	
						onshow:function(){
							var that=this;
							setTimeout(function(){
								that.close().remove();
							},2000);
						}
					});
					d.showModal();
				}else if(data.code == -4){
					var d = dialog({
				        skin:"ui-dialog2-tip",
				        width:350,
				        content: "<div class='FPic'></div><p>同一类型银行卡只能绑定一次</p>",	
						onshow:function(){
							var that=this;
							setTimeout(function(){
								that.close().remove();
							},2000);
						}
					});
					d.showModal();
				}else{
					var d = dialog({
				        skin:"ui-dialog2-tip",
				        width:350,
				        content: "<div class='FPic'></div><p>绑定失败</p>",	
						onshow:function(){
							var that=this;
							setTimeout(function(){
								that.close().remove();
							},2000);
						}
					});
					d.showModal();
				}
			},'json');
		}
	})
})
//点击空白处隐藏select
$(function(){
    $(document).on('click', function(e) {
        var target = e.srcElement || e.target;
        if(!($(target).is('.kstdg') || $(target).is('.vholder'))){
			$('.liawtlet').hide();
        }
    })
})
</script>
<?php $this->display('homev2/footer');?>