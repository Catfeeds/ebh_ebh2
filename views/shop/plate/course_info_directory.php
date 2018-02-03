<?php
if (!empty($directory)) { ?>
    <div class="listmode">
    	
        <?php foreach ($directory as $item) { ?>
            <div class="other-1">
                <a href="javascript:;"><?=htmlspecialchars($item['section'], ENT_NOQUOTES)?>(<?=intval($item['count'])?>)</a>
            </div>
            <ul>
                <?php foreach ($item['items'] as $d) { ?>
                    <li class="setud kettshe">
                        <div class="skthgd">
                            <img style="border-radius:25px;" src="<?=getavater($d,'50_50')?>" />
                            <p><?=!empty($d['realname']) ? htmlspecialchars($d['realname'], ENT_NOQUOTES) : $d['username'] ?></p>
                        </div>
                        <div class="ettyusr">
                            <a class="fusrets" style="color:#666"  href="javascript:;">
                                <img src="http://static.ebanhui.com/ebh/tpl/2014/images/kustgd2.png"/>
                            </a>
                            <img src="<?=htmlspecialchars($d['logo'], ENT_COMPAT)?>" />
                        </div>
                        <div class="sktgte">
                            <?php if($d['attachmentnum'] > 0) { ?>
                                <i class="fujianico" style="margin:5px 5px 0 0;" title="此课件包含附件" ></i>
                            <?php } ?>
                            <?php if(!empty($d['live'])){?>
                                <i class="label-live" title="直播课件">直播</i>
                            <?php }?>
                            <p style="color:#fa5353;font-size:15px;font-weight:bold;"><?=htmlspecialchars($d['title'], ENT_NOQUOTES)?></p>
                            <p style="width:580px;"><?=htmlspecialchars($d['summary'], ENT_NOQUOTES)?></p>
                        </div>
                        
                       <?php if (!empty($d['showtype'])) {?>
                        <!--这里要做判断-->
                        <?php if ($d['showtype']==3) {?>
                        	<div class="coursestate mfst" onclick="window.location = '/course/<?=$d['cwid']?>.html'"></div>
                        <?php } elseif($d['showtype']==1) {?>
                        	<div class="coursestate djkt" onclick="threefun($(this),'<?=$d['cprice']?>','<?=$d['cwid']?>')"></div>
                        	<?php } elseif($d['showtype']==2) {?>
                        	<div class="coursestate jrxx" onclick="window.location = '/myroom/mycourse/<?=$d['cwid']?>.html'"></div>
                        	<?php }?>
                        <?php }?>
                    </li>
                <?php }?>
            </ul>
        <?php }?>
    </div>
    
    <div id="clickkt" style="display: none;">
    	<div class="courseinfolog">
			<span class="courimgbox">
				<img src=""/>
			</span>
			<span class="courtext">
				<p class="courname">课程</p>
				<p class="court">拼音：yi</p>
			</span>
		</div>
		<div class="courseinfopr">
			<p style="">支付金额</p>
			<span class="prebox">
				<span class="paymon">2.05</span>
				<span class="payyuan">元</span>
			</span>
		</div>
		
		<div class="payment">
			<p class="chosepay">选择支付方式</p>
			<div>
				<input type="radio" name="pay2" id="wxpay" value="wx" /> <label for="wxpay" style="margin-right: 50px;">微信</label>
				<input type="radio" name="pay2" id="ipaypay" value="ipay" /> <label for="ipaypay" style="margin-right: 50px;">支付宝</label>
				<input type="radio" name="pay2" id="mywpay" value="my" /> <label for="mywpay">我的钱包</label>
			</div>
			
			<div class="paywx showpay">
				<iframe src="" style="float:left;border:none!important;border-radius: 0px;position: relative;z-index: 0;" scrolling="no" frameborder="0" width="115" height="115"></iframe>
				<span class="payermatxt">微信扫一扫，完成支付</span>
			</div>
			<div class="payipay">
				<iframe src="" style="float:left;border:none!important;border-radius: 0px;position: relative;z-index: 0;" scrolling="no" frameborder="0" width="115" height="115"></iframe>
				<span class="payermatxt">支付宝扫一扫，完成支付</span>
			</div>
			<div class="paymw">
				<span class="nowpay">立即支付</span>
				<span class="monyu">我的余额：<span id="mymoney" style="color: #ffaf28;">0</span>元</span>
			</div>
		</div>
    </div>
    
   	<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/dotjs/jquery.dotdotdot.min.js"></script>
    <script type="text/javascript">
    	var timerpay;
    	//快捷支付的弹窗函数
    	function threefun(that,money,cwid){
    	    var nologin = <?php echo empty($nologin) ? 0 : 1;?>;
    	    if (nologin) {
    	    	$('#nav-login').click();
    	    	return;
    	    } 		
			dialog({
				title:'快捷支付',
				content:$("#clickkt")[0],
				onshow:function(){
					$('input[type=radio][name=pay2][value="wx"]').prop("checked","true");
					var payname = that.parent().children().eq(2).children().eq(0).html();
					var paytxt = that.parent().children().eq(2).children().eq(1).html();
					var src = that.parent().children().eq(1).children('img').attr('src');
					$(".courname").html(payname);
					$(".courname").attr("title",payname);
					$(".court").html(paytxt);
					$(".court").attr("title",paytxt);
					$(".courimgbox img").attr('src',src);
					$(".paymon").html(money);
					
					$(".paywx").addClass("showpay");
					$(".payipay").removeClass("showpay");
					$(".paymw").removeClass("showpay");
					paybywechat(money,cwid);
					$('input[type=radio][name=pay2]').change(function(){
						if(this.value === "wx"){
							$(".paywx").addClass("showpay");
							$(".payipay").removeClass("showpay");
							$(".paymw").removeClass("showpay");
							paybywechat(money,cwid);
						}else if(this.value === "ipay"){
							$(".paywx").removeClass("showpay");
							$(".payipay").addClass("showpay");
							$(".paymw").removeClass("showpay");
							paybyali(money,cwid);
						}else{
							$(".paywx").removeClass("showpay");
							$(".payipay").removeClass("showpay");
							$(".paymw").addClass("showpay");
							paybywallet(cwid);
							$(".nowpay").click(function(){
								paymywal(money,cwid);
							});
						}
					});
					$(".court").dotdotdot({});
				},
				onclose:function(){
					clearInterval(timerpay);
				}
			}).showModal();
		};
		//使用微信支付  
		function paybywechat(money,cwid){
			clearInterval(timerpay);
			setTimeout(function(){
				$.ajax({
			        url:'/ibuy/wxnativepay.html',
			        data:{'money':money,'cwid':cwid},
			        type:'post',
			        dataType:'json',
			        success:function(data){
			        	if(data.status == 0){
			        		var url = data.url;
							$('.paywx iframe').attr('src',url);
							clearInterval(timerpay);
							timerpay = setInterval(function(){
								$.ajax({
									url:"/ibuy/checkweixinbuy.html",
									type:'POST',
									data:{cachekey:data.cachekey},
									dataType:'JSON',
									success:function(json){
										if(json.status==0){
											clearInterval(timerpay);
											top.dialog({
							        			skin:"ui-dialog2-tip",
												title: '',
												content: "<div class='TPic'></div><p style='text-align:center'>支付成功</p>",
												width:200,
												cancel: false,
												onshow:function(){
													var that=this;
													setTimeout(function () {
													that.close().remove();
													}, 1000);
												},
												onclose:function(){	
													window.location.reload();
												}
											}).showModal();
											return false;
										}
									}
								});
							},2000);
			        	}else{
			        		top.dialog({
						        skin:"ui-dialog2-tip",
						        width:350,
						        content: "<div class='FPic'></div><p style='text-align:center'>"+data.msg+"</p>",		
								onshow:function(){
									var that=this;
									setTimeout(function () {
										that.close().remove();
									}, 1500);
								}
							}).showModal();
							return false;
			        	}
			        }
			    });
			},100);
		};
		//使用支付宝支付  
		function paybyali(money,cwid){
			setTimeout(function(){
				clearInterval(timerpay);
				$.ajax({
			        url:'/ibuy/alipayOrder.html',
			        data:{'money':money,'cwid':cwid},
			        type:'post',
			        dataType:'json',
			        success:function(data){
			        	if(data.status ==1){
			        		var url = '/ibuy/alipayQRDate.html?ordernum='+data.ordernum+'&ordername='+data.ordername+'&money='+data.money+'&cwid='+cwid;
							$('.payipay iframe').attr('src',url);
							clearInterval(timerpay);
							timerpay = setInterval(function(){
								$.ajax({
									url:"/ibuy/getpaystatus.html",
									type:'POST',
									data:{ordernum:data.ordernum},
									dataType:'JSON',
									success:function(json){
										if(json.code){
											clearInterval(timerpay);
											top.dialog({
							        			skin:"ui-dialog2-tip",
												title: '',
												content: "<div class='TPic'></div><p style='text-align:center'>支付成功</p>",
												width:200,
												cancel: false,
												onshow:function(){
													var that=this;
													setTimeout(function () {
														that.close().remove();
													}, 1000);
												},
												onclose:function(){	
													window.location.reload();
												}
											}).showModal();
											return false;
										}
									}
								});
							},2000);
			        	}else{
			        		top.dialog({
						        skin:"ui-dialog2-tip",
						        width:350,
						        content: "<div class='FPic'></div><p style='text-align:center'>"+data.msg+"</p>",		
									onshow:function(){
										var that=this;
										setTimeout(function () {
											that.close().remove();
										}, 1500);
									}
								}).showModal();
							return false;
				        }
				    }
				});
			},100);
		};
		//使用钱包付款
		function paybywallet(money){
			clearInterval(timerpay);
			setTimeout(function(){
				var url = '/ibuy/checkWallet.html';
				$.ajax({
			        url:url,
			        data:{money:money},
			        type:'post',
			        dataType:'json',
			        success:function(data){
			        	$("#mymoney").html(data.balance);
			        }
			    });
			},100);	
		} 
		function paymywal(money,cwid){
			$.ajax({
		        url:'/ibuy/bpay.html',
		        data:{'totalfee':money,'cwid':cwid},
		        type:'post',
		        dataType:'json',
		        success:function(data){
		        	if(data.status == 1){
		        		var moneyhave = $("#mymoney").html();
		        		var moneyleft = moneyhave - money;
		        		$("#mymoney").html(moneyleft);
		        		top.dialog({
		        			skin:"ui-dialog2-tip",
							title: '',
							content: "<div class='TPic'></div><p style='text-align:center'>支付成功</p>",
							width:200,
							cancel: false,
							onshow:function(){
								var that=this;
								setTimeout(function () {
									that.close().remove();
								}, 1000);
							},
							onclose:function(){
								window.location.reload();
							}
						}).showModal();
						return false;
		        	}else{
		        		top.dialog({
					        skin:"ui-dialog2-tip",
					        width:350,
					        content: "<div class='FPic'></div><p style='text-align:center'>"+data.msg+"</p>",		
							onshow:function(){
								var that=this;
								setTimeout(function () {
									that.close().remove();
								}, 1500);
							}
						}).showModal();
						return false;
		        	}
		        }
		    });
		}
    </script>
    <?=$pagestr?>
    <?php return; } ?>
<div class="nodata"></div>